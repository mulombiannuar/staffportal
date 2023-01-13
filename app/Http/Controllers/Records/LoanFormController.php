<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Records\Client;
use App\Models\Records\FilingLabel;
use App\Models\Records\LoanForm;
use App\Models\Records\RequestedLoanForm;
use App\Models\User;
use App\Utilities\Buttons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LoanFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //return $this->getLoanForms();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Records Loan Forms ('.LoanForm::count().')',
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
        ];
        return view('records.forms.index', $pageData);
    }

    public function getLoanForms()
    {
        $forms = LoanForm::getLoanForms();
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
        $request->validate(['category' => 'required|integer']);
        $filing_type = DB::table('filing_types')->where('type_id', $request->category)->first();
        $pageData = [
			'page_name' => 'records',
            'filing_type' => $filing_type,
            'title' => $filing_type->type_name. ' Forms',
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
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
        $pageData = [
			'page_name' => 'records',
            'title' => 'Add Loan Forms',
            'products' => Admin::getLoanProducts(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
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
        $clientLoanData = $form->getLoanFormRequestById($request->request_id);

        $pageData = [
			'page_name' => 'records',
            'title' => 'Add Loan Forms',
            'products' => Admin::getLoanProducts(),
            'loan_form' => $clientLoanData,
            'client' => Client::getClientBRId($request->client_id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
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
            'loan_form' => "required|mimes:pdf",
        ]);

         $client = Client::find($request->clients);
         $product = Admin::getLoanProductById($request->product);
         $fileLabel = FilingLabel::find($request->file_label);
         $filingType = DB::table('filing_types')->where('type_id', $request->filing_type)->first();

         //client-0108981-wf04-cash loan-cash001-1673348015
         $loanFormName = $this->getFormName($client, $product, $filingType, $fileLabel); 

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

         return redirect(route('records.loan-forms.index'))->with('success', 'Successfully upladed new loan form for'.$client->client_name);
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
        //return LoanForm::getLoanFormById($id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Loan Form Details',
            'products' => Admin::getLoanProducts(),
            'loan_form' => LoanForm::getLoanFormById($id),
            'loan_forms' => $form->getLoanFormRequestByFormId($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
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
        $pageData = [
			'page_name' => 'records',
            'title' => 'Update Loan Form',
            'products' => Admin::getLoanProducts(),
            'loan_form' => LoanForm::getLoanFormById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
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
            'loan_form' => "mimes:pdf",
        ]);

         $client = Client::find($request->clients);
         $product = Admin::getLoanProductById($request->product);
         $fileLabel = FilingLabel::find($request->file_label);
         $filingType = DB::table('filing_types')->where('type_id', $request->filing_type)->first();

         //client-0108981-wf04-cash loan-cash001-1673348015
         $loanFormName = $this->getFormName($client, $product, $filingType, $fileLabel); 

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

        //Save audit trail
        $activity_type = 'Loan Form Deletion';
        $description = 'Successfully deleted loan with id '. $id;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.loan-forms.index'))->with('success', 'Successfully deleted loan form with id '.$id);
    }

    public function loanProducts()
    {
        // $data = $this->getCSVFileArrayValues('products.csv')['rows'];
        // for ($s=0; $s <count($data) ; $s++) { 
        //     DB::table('loan_products')->insert([
        //         'product_code' => $data[$s][0],
        //         'product_name' => $data[$s][1],
        //         'product_class_id' => $data[$s][2],
        //         'created_by' => Auth::user()->id,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // } 

        $pageData = [
			'page_name' => 'records',
            'title' => 'Loan Products',
            'products' => Admin::getLoanProducts()
        ];
        return view('records.clients.loan_products', $pageData);
    }

    private function getCSVFileArrayValues($fileName)
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

    private function getFormName($client, $product, $filingType, $fileLabel)
    {
        return 'client-'.$client->bimas_br_id.
                      '-'.strtoupper($product->product_code).
                      '-'.ucwords($filingType->type_name).
                      '-'.strtoupper($fileLabel->file_label.$fileLabel->file_number).
                      '-'.time();
    }
}
