<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Imports\ClientLoansImport;
use App\Models\Admin;
use App\Models\Records\Client;
use App\Models\Records\ClientChangeForm;
use App\Models\Records\FilingLabel;
use App\Models\Records\LoanForm;
use App\Models\Records\RequestedChangeForm;
use App\Models\Records\RequestedLoanForm;
use App\Models\Records\RequestedLoanFormApproval;
use App\Models\User;
use App\Utilities\Buttons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LoanFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard()
    {
        $filingClass = FilingLabel::getUserFilingClass(); 
        //return $this->getRecordStats();
        $pageData = [
             'page_name' => 'records',
             'title' => $filingClass['title'],
             'clients' => Client::count(),
             'change_forms' => ClientChangeForm::count(),
             'requested_loan' => RequestedLoanForm::count(),
             'requested_change' => RequestedChangeForm::count(),
             'products' => DB::table('loan_products')->count(),
             'loans' => DB::table('client_loans')->count(),

             'loan_forms' => $this->getRecordStats()['loan_forms'],
             'filing_labels' => $this->getRecordStats()['filing_labels'],
             'loan_files' => count($this->getFilesData( 'public/assets/loans'))
         ];
         return view('records.dashboard', $pageData);
    }

    public function clientLoans()
    {
        //return $this->getCSVFileArrayValues('upload_test.csv');
        //return $this->saveCSVFileLoansRawData('activeLoans-2023-03-15.csv');
        //return $this->getLoanClientLoans();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Active Client Loans',
            'excels' => LoanForm::getUploadedExcels('loans')
        ];
        return view('records.forms.client_loans', $pageData);
    }

    public function getLoanClientLoans()
    {
        $loans = LoanForm::getClientLoans();
        return Datatables::of($loans)
                        ->addIndexColumn()
                        ->addColumn('application', function ($loan) {
                            return Buttons::dataTableClientLoanLink($loan->id, $loan->application_id);
                        })
                        ->rawColumns(['application'])
                        ->make(true);
    }

     
    public function index()
    {
       //return $this->getLoanForms();
       $filingClass = FilingLabel::getUserFilingClass();
       //return LoanForm::getFilingTypesByClass($filingClass['class']); 
        $pageData = [
			'page_name' => 'records',
            'title' => 'Loan Forms Management',
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.forms.index', $pageData);
    }

    public function getLoanForms()
    {
        $filingClass = FilingLabel::getUserFilingClass();
        $forms = LoanForm::getLoanForms($filingClass['class']);
        return DataTables::of($forms)
                        ->addIndexColumn()
                        ->addColumn('action', function ($form) {
                            return Buttons::dataTableButtons(
                                route('records.loan-forms.show', $form->form_id),
                                route('records.loan-forms.edit', $form->form_id),
                                route('records.loan-forms.destroy', $form->form_id),
                            );
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function loanCategory(Request $request)
    {
        $filingClass = FilingLabel::getUserFilingClass(); 
        $request->validate(['category' => 'required|integer']);

        if ($request->category == 7) 
        return redirect(route('records.change-forms.index'))->with('success', 'These are the clients change forms available');

        $filing_type = DB::table('filing_types')->where('type_id', $request->category)->first();
        $pageData = [
			'page_name' => 'records',
            'filing_type' => $filing_type,
            'title' => $filing_type->type_name. ' Forms',
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.forms.category', $pageData);
    }

    public function getLoanFormsByFilingType($type_id)
    {
        $forms = LoanForm::getLoanFormsByType($type_id);
        return DataTables::of($forms)
                        ->addIndexColumn()
                        ->addColumn('action', function ($form) {
                            return Buttons::dataTableButtons(
                                route('records.loan-forms.show', $form->form_id),
                                route('records.loan-forms.edit', $form->form_id),
                                route('records.loan-forms.destroy', $form->form_id),
                            );
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filingClass = FilingLabel::getUserFilingClass(); 
        $pageData = [
			'page_name' => 'records',
            'title' => 'Upload New Loan Form',
            'products' => Admin::getLoanProducts(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.forms.create', $pageData);
    }

    public function createLoanFormUsingLoanRequest(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'request_id' => 'required|integer',
        ]);

        $form = new RequestedLoanForm();
        $filingClass = FilingLabel::getUserFilingClass();
        $clientLoanData = $form->getLoanFormRequestById($request->request_id);

        $pageData = [
			'page_name' => 'records',
            'title' => 'Add Loan Forms',
            'products' => Admin::getLoanProducts(),
            'loan_form' => $clientLoanData,
            'client' => Client::getClientBRId($request->client_id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.forms.create_loan_request', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'branch' => 'required|integer',
            'outpost_id' => 'required|integer',
            'clients' => 'required|integer',
            'filing_type' => 'required|integer',
            'file_label' => 'required|integer',
            'product' => 'required|integer',
            'amount' => 'required|string|max:255',
            'disbursment_date' => 'required|string|max:255',
            'application_id' => 'required|string|unique:loan_forms',
            'loan_form' => "required|mimes:pdf",
         ]);

         $client = Client::find($request->clients);
         $application_id = $request->application_id;
         $product = Admin::getLoanProductById($request->product);
         $fileLabel = FilingLabel::find($request->file_label);
         $filingType = DB::table('filing_types')->where('type_id', $request->filing_type)->first();

         //client-0108981-wf04-cash loan-cash001-1673348015
         $loanFormName = $this->getFormName($client, $product, $filingType, $fileLabel, $application_id); 

         $loanFormDocName = 'nopdf.pdf';
         if($request->hasFile('loan_form')) 
         {
             $extension = $request->file('loan_form')->getClientOriginalExtension();
             
             $loanFormDocName = $loanFormName.'.'.$extension;
 
             $request->file('loan_form')->storeAs('public/assets/loans', $loanFormDocName);
         }

         $form = new LoanForm();
         $form->product_id = $product->product_id;
         $form->client_id = $client->client_id;
         $form->filing_type_id = $request->filing_type;
         $form->file_number = $request->file_label;
         $form->amount = $request->amount;
         $form->application_id = $request->application_id;
         $form->disbursment_date = $request->disbursment_date;
         $form->payee = $request->payee;
         $form->cheque_no = $request->cheque_no;
         $form->file_name = $loanFormDocName;
         $form->created_by = Auth::user()->id;
         $form->save();

         //Save audit trail
         $activity_type = 'Loan Form Upload';
         $description = 'Successfully uploaded new loan form for '. $client->client_name;
         User::saveAuditTrail($activity_type, $description);

         return redirect(route('records.loan-forms.index'))->with('success', 'Successfully uploaded new loan form for'.$client->client_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = new RequestedLoanForm();
        $filingClass = FilingLabel::getUserFilingClass();
        //return LoanForm::getLoanFormById($id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Loan Form Details',
            'products' => Admin::getLoanProducts(),
            'loan_form' => LoanForm::getLoanFormById($id),
            'loan_forms' => $form->getLoanFormRequestByFormId($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.forms.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return LoanForm::getLoanFormById($id);
        $filingClass = FilingLabel::getUserFilingClass();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Update Loan Form',
            'products' => Admin::getLoanProducts(),
            'loan_form' => LoanForm::getLoanFormById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.forms.edit', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch' => 'required|integer',
            'outpost_id' => 'required|integer',
            'clients' => 'required|integer',
            'filing_type' => 'required|integer',
            'file_label' => 'required|integer',
            'product' => 'required|integer',
            'amount' => 'required|string|max:255',
            'disbursment_date' => 'required|string|max:255',
            'application_id' => 'required|string',
            'loan_form' => "mimes:pdf",
        ]);

         $client = Client::find($request->clients);
         $application_id = $request->application_id;
         $product = Admin::getLoanProductById($request->product);
         $fileLabel = FilingLabel::find($request->file_label);
         $filingType = DB::table('filing_types')->where('type_id', $request->filing_type)->first();

         //client-0108981-wf04-cash loan-cash001-1673348015
         $loanFormName = $this->getFormName($client, $product, $filingType, $fileLabel, $application_id); 

         $form = LoanForm::find($id);
         $loanFormDocName = $form->file_name;
         
         if($request->hasFile('loan_form')) 
         {
             Storage::delete('public/assets/loans/'.$loanFormDocName);

             $extension = $request->file('loan_form')->getClientOriginalExtension();
             
             $loanFormDocName = $loanFormName.'.'.$extension;
 
             $request->file('loan_form')->storeAs('public/assets/loans', $loanFormDocName);
         }
         
         $form->product_id = $product->product_id;
         $form->client_id = $client->client_id;
         $form->filing_type_id = $request->filing_type;
         $form->file_number = $request->file_label;
         $form->amount = $request->amount;
         $form->application_id = $request->application_id;
         $form->disbursment_date = $request->disbursment_date;
         $form->payee = $request->payee;
         $form->cheque_no = $request->cheque_no;
         $form->file_name = $loanFormDocName;
         $form->save();

         //Save audit trail
         $activity_type = 'Loan Form Updation';
         $description = 'Successfully updated loan form for '. $client->client_name;
         User::saveAuditTrail($activity_type, $description);

         return redirect(route('records.loan-forms.index'))->with('success', 'Successfully updated existing loan form for '.$client->client_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form = LoanForm::find($id);
        Storage::delete('public/assets/loans/'.$form->file_name);
        $form->delete();

        RequestedLoanForm::where('request_loan_id', $id)->delete();
        RequestedLoanFormApproval::where('loan_form_id', $id)->delete();

        //Save audit trail
        $activity_type = 'Loan Form Deletion';
        $description = 'Successfully deleted loan with id '. $id;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.loan-forms.index'))->with('success', 'Successfully deleted loan form with id '.$id);
    }

    public function loanProducts()
    {
    //    $data = $this->getCSVFileArrayValues('products.csv')['rows'];
    //     for ($s=0; $s <count($data) ; $s++) { 
    //         DB::table('loan_products')->insert([
    //             'product_code' => $data[$s][1],
    //             'product_name' => $data[$s][0],
    //             'product_class_id' => $data[$s][2],
    //             'created_by' => Auth::user()->id,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);
    //     } 
    //     return 'Process completed successfully';

        $pageData = [
			'page_name' => 'records',
            'title' => 'Loan Products',
            'products' => Admin::getLoanProducts()
        ];
        return view('records.clients.loan_products', $pageData);
    }

    public function uploadedLoanForms()
    {
        $path = 'public/assets/loans';
        //return $this->getFilesData($files, $path);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Uploaded Loan Files',
            'files' => $this->getFilesData($path)
        ];
        return view('records.uploaded_loans', $pageData);
    }

    private function getFilesData($path)
    {
        $loanFiles = [];
        $files = Storage::disk('local')->allFiles($path);

        for ($i=0; $i <count($files) ; $i++) { 
            $loanFile = mb_substr($files[$i], strlen($path) + 1);
            array_push($loanFiles, $loanFile);
        }
        return $loanFiles;
    }

    public static function getCSVFileArrayValues($fileName)
    {
        $file = asset('assets/docs/'.$fileName);
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $headers = array_shift($rows);
        return [
            'headers' => $headers,
            'rows' => $rows
        ];
    }

    public function fetchFilingLabelsByType(Request $request)
    {
       $type =  $request->input('type');
       $labels = FilingLabel::getFilesByType($type);
       $output = '';
       if (count($labels) == 0) {
         $output .= '<option value="">- No Record Files Found -</option>';
       }else{
          $output .= '<option value="">- Select Record File below -</option>';
          foreach ($labels as $label) 
          {
            $output .= '<option value="'.$label->label_id.'">'.$label->file_label.$label->file_number.'</option>';
          }
       }
       return $output;
    }

    private function getFormName($client, $product, $filingType, $fileLabel, $application_id)
    {
       return   $client->bimas_br_id.
                '-'.$application_id.
                '-'.strtoupper($product->product_code).
                '-'.ucwords($filingType->type_name).
                '-'.strtoupper($fileLabel->file_label.$fileLabel->file_number).
                '-'.time();
    }

    //// Records Reports
    public function recordsReports()
    {
        $filingClass = FilingLabel::getUserFilingClass();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Records Reports',
            'filing_types' => LoanForm::getFilingTypesByClass($filingClass['class'])
        ];
        return view('records.reports.index', $pageData);
    }

    public function reportType(Request $request)
    {
        $request->validate([
            'category' => 'required|integer',
            'filing_type' => 'required|integer',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $category = $request->category;
        $filing_type = $request->filing_type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $data = $this->getReportData($category);
        $loanForm = new LoanForm();
        
        $reportData = $loanForm->getRequestedReport($category, $filing_type, $start_date, $end_date);

        $pageData = [
            'data' => $reportData,
			'page_name' => 'records',
            'title' => $data['title'],
        ];
        return view('records.reports.'.$data['view'], $pageData);
    }

    private function getReportData($category)
    {
        switch ($category) 
        {
            case 1:
            case 8:
            case 9:
            case 10:
            case 11:
                $title = 'Clients Loan Forms';
                $reportView = 'client-loan-forms';
                break;
            case 2:
                $title = 'Clients Change Forms';
                $reportView = 'client-change-forms';
                break;
            case 3:
            case 8:
            case 9:
            case 10:
            case 11:
                $title = 'Requested Loan Forms';
                $reportView = 'requested-loan-forms';
                break;
            case 4:
                $title = 'Requested Change Forms';
                $reportView = 'requested-change-forms';
                break;  
            default:
                $title = 'Clients Loan Forms';
                $reportView = 'client-loan-forms';
                break;
        }
        return [
            'view' => $reportView,
            'title' => $title
        ];
    }

    private function getRecordStats()
    {
        $filingClass = FilingLabel::getUserFilingClass(); 
        if(Auth::user()->hasRole('admin'))
        {
            return  [
                'loan_forms' => LoanForm::count(),
                'filing_labels' => FilingLabel::count(),
                //'requested_loan' => RequestedLoanForm::count(),
            ];
        }else{
            return [
                'loan_forms' => count(LoanForm::getLoanForms($filingClass['class'])),
                'filing_labels' => count(FilingLabel::getFilesByTypeAndClass($filingClass['class'])),
                //'requested_loan' => RequestedLoanForm::count(),
            ];
        }
    }

    public function fetchClientAccounts(Request $request)
    {
       $accounts = LoanForm::getClientLoanAccounts($request->client);
       $output = '';
       if (count($accounts) == 0) {
         $output .= '<option value="">- No Clients Accounts found -</option>';
       }else{
          $output .= '<option value="">- Select Loan Account -</option>';
          foreach ($accounts as $account) 
          {
            $output .= '<option value="'.$account->id.'">'.$account->product_id.' - '.$account->account_id.'</option>';
          }
       }
       return $output;
    }

    public function getAccountDetails(Request $request)
    {
        $data = LoanForm::getClientLoanAccount($request->account);
        return response()->json($data);
    }

    public function saveCSVFileLoansRawData($file_name)
    {
        $data = LoanFormController::getCSVFileArrayValues($file_name)['rows'];
       // return count($data);
        for ($s=0; $s <count($data) ; $s++) { 
            DB::table('client_loans')->insert([
                'client_id' => $data[$s][0],
                'account_id' => $data[$s][1],
                'product_id' => $data[$s][2],
                'application_id' => $data[$s][3],
                'loan_amount' => round($data[$s][4]),
                'loan_series' => $data[$s][5],
                'application_date' => $data[$s][7],
                'disbursment_date' => $data[$s][6],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 

        return 'Data import completed successfully. '.count($data). ' records affected.';
    }

    public function importExcelLoans(Request $request)
    {
        $request->validate([
            'excel_file' => "required|mimes:xls,xlsx,csv", 
            'disbursment_date' => 'required|date'           
        ]);

       // return date_format(date_create($request->disbursment_date), 'Y-m-d h:m:s');

        //Backup database first

        Excel::import(new ClientLoansImport, $request->excel_file);

        //Save excel file
        $excelFileName = 'client-loans-'.$request->disbursment_date;

        if($request->hasFile('excel_file')) 
        {
            $extension = $request->file('excel_file')->getClientOriginalExtension();
            
            $newExcelFileName = $excelFileName.'.'.$extension;

            $request->file('excel_file')->storeAs('public/assets/excels', $newExcelFileName);
        }

        // Save import data
        DB::table('uploaded_excel_data')->insert([
            'disbursment_date' => $request->disbursment_date,
            'excel_file_name' => $newExcelFileName,
            'uploaded_by' => Auth::user()->id,            
            'records_affected' => 0,
            'upload_type' => 'loans',
            'created_at' => now()
        ]);
        
        return back()->with('success', 'Excel data imported successfully');
    }
}
