<?php

namespace App\Models\Records;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanForm extends Model
{
    use HasFactory;
    protected $table = 'loan_forms';
    protected $primaryKey = 'form_id';

    public static function saveUploadedExcelData($disbursment_date, $file_name, $affected_rows, $upload_type)
    {
    //    if ($upload_type == 'loans') 
    //    DB::table('client_loans')->where(['disbursment_date' => $disbursment_date])->delete();

    //    if ($upload_type == 'clients') 
    //    DB::table('clients2')->where(['registration_date' => $disbursment_date])->delete();
        
        return DB::table('uploaded_excel_data')->insert([
            'disbursment_date' => $disbursment_date,
            'records_affected' => $affected_rows,
            'uploaded_by' => Auth::user()->id,            
            'excel_file_name' => $file_name,
            'upload_type' => $upload_type,
            'created_at' => now()
        ]);       
    }

    public static function getUploadedExcels($type)
    {
        return DB::table('uploaded_excel_data')
                 ->join('users', 'users.id', '=', 'uploaded_excel_data.uploaded_by')
                 ->select('name', 'uploaded_excel_data.*')
                 ->where('upload_type', $type)
                 ->orderBy('uploaded_excel_data.id', 'desc')->get();
    }
  
    public static function getClientLoans()
    {
        return DB::table('client_loans')->orderBy('application_date', 'desc')->get();
    }

    public static function getClientLoansByClientID($client_id)
    {
        $loans = DB::table('client_loans')->where('client_id', $client_id)->orderBy('application_date', 'desc')->get();
        
        for ($s=0; $s <count($loans) ; $s++) 
        {
            $client = Client::getClientBRId($client_id);
            $product_id = Admin::getLoanProductByCode($loans[$s]->product_id)->product_id;
            $loan_form = LoanForm::getRequestedLoanForm($client->client_id, $product_id, $loans[$s]->loan_amount, $loans[$s]->disbursment_date);
            $loans[$s]->loan_form_id = $loan_form ? $loan_form->form_id : null  ;
        }
        return $loans;
    }

    public static function getClientLoanAccount($id)
    {
        return DB::table('client_loans')
                 ->leftJoin('clients', 'clients.bimas_br_id', '=', 'client_loans.client_id')
                 ->join('loan_products', 'loan_products.product_code', '=', 'client_loans.product_id')
                 ->select(
                    'client_loans.*', 
                    'client_name',
                    'client_phone',
                    'national_id',
                    'loan_products.product_id as pro_id')
                 ->where('id', $id)
                 ->first();
    }

    public static function getClientLoanAccounts($client_id)
    {
        $client = DB::table('clients')->where('client_id', $client_id)->first();
        return DB::table('client_loans')->where('client_id', $client->bimas_br_id)->orderBy('application_date', 'desc')->get();
    }

    public static function getFilingTypesByClass($class)
    {
        if(is_null($class) || Auth::user()->hasRole('admin')) return DB::table('filing_types')->orderBy('type_name', 'asc')->get();
        return DB::table('filing_types')->where('class', $class)->orderBy('type_name', 'asc')->get();
    }

    public static function getLoanFormById($form_id)
    {
        return LoanForm::join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                       ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                       ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                       ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                       ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                       ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                       //->select('clients.*', 'users.name as created_by', 'branch_name', 'outpost_name')
                       ->where(['form_id'=> $form_id])
                       ->first();
    }

    public static function getLoanForms($class)
    {
        if(Auth::user()->hasRole('admin')) return LoanForm::getAllLoanForms();

        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                    ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                    ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'type_name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->where('filing_types.class', $class)
                    ->orderBy('form_id', 'desc')
                    ->get();
    }

    public static function getAllLoanForms()
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                    ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                    ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'type_name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->orderBy('form_id', 'desc')
                    ->get();
    }

    public static function getLoanFormsByType($type_id)
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                    ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                    ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'type_name',
                        'filing_labels.file_number as filing_number',
                        )
                    ->where('filing_type_id', $type_id)
                    ->orderBy('bimas_br_id', 'asc')
                    ->get();
    }

    public static function getLoanFormsByFileNumber($file_number)
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                     ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                     ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                     ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                     ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                     ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                     ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'filing_labels.file_number as filing_number',
                        )
                     ->where('loan_forms.file_number', $file_number)
                     ->orderBy('bimas_br_id', 'asc')
                     ->get();
    }

    public static function getRequestedLoanForm($client_id, $product_id, $amount, $date)
    {
        return LoanForm::join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                       ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                       //->select('clients.*', 'users.name as created_by', 'branch_name', 'outpost_name')
                       ->where([
                            'loan_forms.client_id'=> $client_id,
                            'amount' => $amount,
                            'loan_forms.product_id' => $product_id,
                            'disbursment_date' => $date
                        ])
                       ->first();
    }

    public function getRequestedReport($category, $filing_type,   $start_date, $end_date)
    {
        //  1. Loan Forms 2. Change Forms 3. Requested Loan Forms 4. Requested Change Forms
        $data = [];

        //Loan Forms
        if($category == 1 || $category == 8 || $category == 9 ||$category == 10 || $category == 11)
        $data = $this->getLoanFormsByTypeAndCreationDate($filing_type, $start_date, $end_date);

        //Change Forms
        if($category == 2)
        $data = ClientChangeForm::getClientChangeFormsByDateRanges($start_date, $end_date);

        //Requested Loan Forms
        if($category == 3 || $category == 8 || $category == 9 ||$category == 10 || $category == 11)
        $data = RequestedLoanForm::getRequestedLoanFormsByDateRanges($filing_type, $start_date, $end_date);

        if($category == 4)
        $data = RequestedChangeForm::getRequestedChangeFormsByDateRanges($start_date, $end_date);
        
        return $data;
    }

    private static function getLoanFormsByTypeAndCreationDate($filing_type, $start_date, $end_date)
    {
        return LoanForm::join('users', 'users.id', '=', 'loan_forms.created_by')
                    ->join('clients', 'clients.client_id', '=', 'loan_forms.client_id')
                    ->join('loan_products', 'loan_products.product_id', '=', 'loan_forms.product_id')
                    ->join('filing_labels', 'filing_labels.label_id', '=', 'loan_forms.file_number')
                    ->join('filing_types', 'filing_types.type_id', '=', 'loan_forms.filing_type_id')
                    ->join('branches', 'branches.branch_id', '=', 'clients.branch_id')
                    ->join('outposts', 'outposts.outpost_id', '=', 'clients.outpost_id')
                    ->select(
                        'clients.*', 
                        'loan_forms.*', 
                        'branch_name', 
                        'outpost_name',
                        'product_name',
                        'product_code',
                        'file_label',
                        'type_name',
                        'filing_labels.file_number as filing_number',
                    )
                    ->where('filing_type_id', $filing_type)
                    ->where('loan_forms.created_at', '>=', $start_date)
                    ->where('loan_forms.created_at', '<=', $end_date)
                    ->orderBy('bimas_br_id', 'asc')
                    ->get();
    }
}
