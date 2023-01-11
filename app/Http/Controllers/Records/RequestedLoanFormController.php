<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Records\Client;
use App\Models\Records\LoanForm;
use App\Models\Records\RequestedLoanForm;
use App\Models\Records\RequestedLoanFormApproval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class RequestedLoanFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanRequest = new RequestedLoanForm();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Requested Loan Forms',
            'loanRequests' => $loanRequest->getLoanFormRequests()
        ];
        return view('records.requested.index', $pageData);
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
            'title' => 'Add Loan Form Request',
            'products' => Admin::getLoanProducts(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => DB::table('filing_types')->orderBy('type_name', 'asc')->get()
        ];
        return view('records.requested.create', $pageData);
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
            'bimas_br_id' => 'required|string|digits:7|max:7|min:7|unique:clients,bimas_br_id',
            'client_phone' => 'required|digits:12|max:12|min:12|unique:clients,client_phone',
            'national_id' => 'required|string|max:255|unique:clients,national_id',
            'client_name' => 'required|string|max:255',
            'product' => 'required|integer',
            'amount' => 'required|string|max:255',
            'disbursment_date' => 'required|string|max:255',
            'branch' => 'required|integer',
            'outpost' => 'required|integer',
        ]);

        $product = Admin::getLoanProductById($request->product);
        $requestedForm = new RequestedLoanForm();
        $requestedForm->date_requested = Carbon::now();
        $requestedForm->bimas_br_id = $request->input('bimas_br_id');
        $requestedForm->client_phone = $request->input('client_phone');
        $requestedForm->client_name = $request->input('client_name');
        $requestedForm->national_id = $request->input('national_id');
        $requestedForm->branch_id = $request->input('branch');
        $requestedForm->outpost_id = $request->input('outpost');
        $requestedForm->requested_by = $request->input('user_id');
        $requestedForm->amount = $request->input('amount');
        $requestedForm->product_id = $request->input('product');
        $requestedForm->officer_message = $request->input('officer_message');
        $requestedForm->disbursment_date = $request->input('disbursment_date');
        $requestedForm->reference = $this->getRequestReference($product->product_code);
        $requestedForm->save();

        //send user notification and email
        $message = new Message();
        $user = User::getUserById(Auth::user()->id);

        $systemMessage = 'you have successfully lodged a new loan form request with reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id;
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
        $message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'loan_form_request'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //send email
        $mailSubject = 'Loan form request of reference '.$requestedForm->reference;
        $message->SendSystemEmail(ucwords($user->name), $user->email, $messageBody, strtoupper($mailSubject));

        //send sms to records admin
        $admins = $this->getRecordsAdmins();
        for ($s=0; $s <count($admins) ; $s++) 
        { 
            $adminMessage = strtoupper($user->name).' has lodged a new loan form request with reference '.$requestedForm->reference;
            $message = new Message();
            $messageBody = $message->getGreetings(strtoupper($admins[$s]['name'])).', '.$adminMessage;
            $mobileNo = $admins[$s]['mobile_no'];
        
            //$message->sendSms($mobileNo, $sms);

            $message->message_status = 'sent'; 
            $message->message_type = 'records_admin'; 
            $message->recipient_no = $mobileNo; 
            $message->recipient_name = $admins[$s]['name']; 
            $message->logged_date =  date('D, d M Y H:i:s'); 
            $message->message_body = $messageBody;
            $message->save();
        }

        //Save audit trail
        $activity_type = 'Loan Form Request';
        $description = 'Created new loan form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.requested-forms.index'))->with('success', 'You have successfully lodged new loan form request of reference '. $requestedForm->reference);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requestedLoanForm = [];
        $form = new RequestedLoanForm();
        $loanRequest = $form->getLoanFormRequestById($id);
        $client = Client::getClientBRId($loanRequest->bimas_br_id);
        if($client){
            $requestedLoanForm = LoanForm::getRequestedLoanForm(
                $client->client_id, 
                $loanRequest->product_id, 
                $loanRequest->amount, 
                $loanRequest->disbursment_date);
        }

        $pageData = [
            'client' => $client,
			'page_name' => 'records',
            'loanRequest' => $loanRequest,
            'loan_form' => $requestedLoanForm,
            'title' => 'Loan Form Request Details',
            'products' => Admin::getLoanProducts(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.requested.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanRequest = new RequestedLoanForm();
        $pageData = [
			'page_name' => 'records',
            'title' => 'Update Loan Form Request',
            'products' => Admin::getLoanProducts(),
            'loanRequest' => $loanRequest->getLoanFormRequestById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.requested.edit', $pageData);
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
            'bimas_br_id' => 'required|string|digits:7|max:7|min:7',
            'client_phone' => 'required|digits:12|max:12|min:12',
            'national_id' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'product' => 'required|integer',
            'amount' => 'required|string|max:255',
            'disbursment_date' => 'required|string|max:255',
            'branch' => 'required|integer',
            'outpost' => 'required|integer',
        ]);

        $requestedForm = RequestedLoanForm::find($id);
        $requestedForm->bimas_br_id = $request->input('bimas_br_id');
        $requestedForm->client_phone = $request->input('client_phone');
        $requestedForm->client_name = $request->input('client_name');
        $requestedForm->national_id = $request->input('national_id');
        $requestedForm->branch_id = $request->input('branch');
        $requestedForm->outpost_id = $request->input('outpost');
        $requestedForm->requested_by = $request->input('user_id');
        $requestedForm->amount = $request->input('amount');
        $requestedForm->product_id = $request->input('product');
        $requestedForm->officer_message = $request->input('officer_message');
        $requestedForm->disbursment_date = $request->input('disbursment_date');
        $requestedForm->save();

        //Save audit trail
        $activity_type = 'Loan Form Request Updation';
        $description = 'Updated loan form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.requested-forms.index'))->with('success', 'You have successfully updated loan form request of reference '. $requestedForm->reference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestedLoanForm::find($id)->delete();

        //Save audit trail
        $activity_type = 'Loan Form Request Deletion';
        $description = 'Successfully deleted loan form request of id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted loan form request successfully');
    }

    public function approveRequest(Request $request)
    {
        $request->validate([
            'approval_date' => 'required|string',
            'approval_message' => 'required|string',
            'approval_status' => 'required|integer',
            //'loan_form_id' => 'integer|required',
            'request_id' => 'integer|required'
        ]);

        $approvalStatus = $request->approval_status;
        $approvedForm = $request->loan_form_id;
        if ($approvalStatus == 0) {
            $approvedForm = null;
        }

        $requestedForm = RequestedLoanForm::find($request->request_id);
        $requestedForm->is_approved = $request->approval_status;
        $requestedForm->request_loan_id = $approvedForm;
        $requestedForm->save();

        $approval = new RequestedLoanFormApproval();
        $approval->approved_by = Auth::user()->id;
        $approval->date_approved = $request->approval_date;
        $approval->approval_message = $request->approval_message;
        $approval->approval_status = $request->approval_status;
        $approval->loan_form_id = $approvedForm;
        $approval->request_id = $request->request_id;
        $approval->save();

        $action = $request->approval_status == 1 ? 'approved' : 'rejected';

        //send requester sms notification and email
        $requester = User::getUserById($requestedForm->requested_by);
        $message = new Message();
        $approvalMessage = 'your loan form request of reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id.' was '.$action.'. For assistance, contact the Records Department.';
        $messageBody = $message->getGreetings(strtoupper($requester->name)).', '.$approvalMessage;
        $mobileNo = '2547'.substr(trim($requester->mobile_no), 2);
        //$message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'loan_form_'.$action; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $requester->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //send email
        $mailSubject = 'Loan form request of reference '.$requestedForm->reference;
        $message->SendSystemEmail(ucwords($requester->name), $requester->email, $messageBody, strtoupper($mailSubject));
        
        //send user notification
        $message = new Message();
        $user = User::getUserById(Auth::user()->id);

        $systemMessage = 'you have successfully '.$action.' loan form request with reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id;
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
        //$message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'loan_form_approval'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Save audit trail
        $activity_type = 'Loan Form Request Approval';
        $description = 'Created new loan form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);
 
        return redirect(route('records.requested-forms.index'))->with('success', 'You have successfully approved loan form request of reference '. $requestedForm->reference);
    }

    private function getRequestReference($product_code)
    {
        return  strtoupper($product_code.date('YmdHi'));
    }

    public static function getRecordsAdmins()
    {
        return [
            ['name' => 'Anuary Mulombi', 'mobile_no' => '254703539208'],
            ['name' => 'Ibrahim Adan', 'mobile_no' => '254716183666'],
        ];
    }

    public function fetchOutpostRequests(Request $request)
    {
       $outpost =  $request->input('outpost');
       $requests = RequestedLoanForm::getLoanFormRequestsByOutpostId($outpost);
       $output = '';
       if (count($requests) == 0) {
         $output .= '<option value="">- No Outposts Requests found -</option>';
       }else{
          $output .= '<option value="">- Select Request Reference below -</option>';
          foreach ($requests as $request) 
          {
            $output .= '<option value="'.$request->request_id.'">'.$request->reference.' - '.$request->name.'</option>';
          }
       }
       return $output;
    }
}
