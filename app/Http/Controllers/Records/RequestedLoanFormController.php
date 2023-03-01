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
use App\Utilities\Buttons;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RequestedLoanFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $this->getCompletedRequests();
        $loanRequest = new RequestedLoanForm();
        //return $loanRequest->getLoanFormRequests(0);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Requested Loan Forms',
            'loanRequests' => $loanRequest->getLoanFormRequests(0),
            'completed' => RequestedLoanForm::where('is_completed', 1)->count()
        ];
        return view('records.requested.index', $pageData);
    }

    public function getCompletedRequests()
    {
        $loanRequest = new RequestedLoanForm();
        $loans = $loanRequest->getLoanFormRequests(1);
        return DataTables::of($loans)
                        ->addIndexColumn()
                        ->addColumn('action', function ($loan) {
                            return Buttons::dataTableViewButton(
                                route('records.requested-forms.show', $loan->request_id)
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
            'title' => 'Add Loan Form Request',
            'products' => Admin::getLoanProducts(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'filing_types' => LoanForm::getFilingTypesByClass('R')
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
        //return $request;
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
            'user_id' => 'required|integer',
        ]);
        //do something if that client is found in the system

        //return $request;
        $product = Admin::getLoanProductById($request->product);
        $requestedForm = new RequestedLoanForm();
        $requestedForm->date_requested = Carbon::now();
        $requestedForm->bimas_br_id = $request->input('bimas_br_id');
        $requestedForm->client_phone = $request->input('client_phone');
        $requestedForm->client_name = $request->input('client_name');
        $requestedForm->national_id = $request->input('national_id');
        $requestedForm->branch_id = $request->input('branch');
        $requestedForm->outpost_id = $request->input('outpost');
        $requestedForm->return_date = $request->input('return_date');
        $requestedForm->is_original = $request->input('is_original');
        $requestedForm->requested_by = $request->input('user_id');
        $requestedForm->amount = $request->input('amount');
        $requestedForm->product_id = $request->input('product');
        $requestedForm->officer_message = $request->input('officer_message');
        $requestedForm->disbursment_date = $request->input('disbursment_date');
        $requestedForm->reference = $this->getRequestReference($product->product_code);
        $requestedForm->save();

        $formType = $requestedForm->is_original? 'original copy' : 'electronic copy';
        //send user notification and email
        $message = new Message();
        $user = User::getUserById(Auth::user()->id);

        $systemMessage = 'you have successfully lodged a new '.$formType.' loan form request with reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id.'. For further assistance, contact the Records Office';
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = Admin::formatMobileNumber($user->mobile_no);
        $message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'loan_form_request'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //send email
        $mailSubject = ucwords($formType).' Loan form request of reference '.$requestedForm->reference;
        $message->SendSystemEmail(ucwords($user->name), $user->email, $messageBody, strtoupper($mailSubject));

        //send sms to records admin
        $admins = $this->getRecordsAdmins();
        for ($s=0; $s <count($admins) ; $s++) 
        { 
            $adminMessage = strtoupper($user->name).' has lodged a new '.$formType.' loan form request with reference '.$requestedForm->reference;
            $message = new Message();
            $messageBody = $message->getGreetings(strtoupper($admins[$s]['name'])).', '.$adminMessage;
            $mobileNo = $admins[$s]['mobile_no'];
            $message->sendSms($mobileNo, $messageBody);
            //$message->sendSms('254703539208', $messageBody);

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
        $description = 'Created new '.$formType.' loan form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);

        $redirectRoute = Auth::user()->hasRole('admin|records') 
        ? route('records.requested-forms.index')
        : route('user.loan-forms.view');

        return redirect($redirectRoute)->with('success', 'You have successfully lodged new '.$formType.' loan form request of reference '. $requestedForm->reference);
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
                date_format(date_create($loanRequest->disbursment_date), 'Y-m-d')
            );
        }

        //return RequestedLoanFormApproval::getRequestApprovalDetails($id);
        $pageData = [
            'client' => $client,
			'page_name' => 'records',
            'loanRequest' => $loanRequest,
            'loan_form' => $requestedLoanForm,
            'title' => 'Loan Form Request Details',
            'products' => Admin::getLoanProducts(),
            'approvalDetails' => RequestedLoanFormApproval::getRequestApprovalDetails($id),
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
            'user_id' => 'required|integer',
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
        $requestedForm->return_date = $request->input('return_date');
        $requestedForm->is_original = $request->input('is_original');
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
            //'approval_date' => 'required|string',
            'approval_message' => 'required|string',
            'approval_status' => 'required|integer',
            'request_id' => 'integer|required'
        ]);

        $approvalStatus = $request->approval_status;
        $approvedForm = $request->loan_form_id;

        $isLocked = null;
        $approvalDate = now();
        $formattedDate = date_create($request->approval_date);
        $viewableDeadline = date_add($formattedDate, date_interval_create_from_date_string("5 days"));
        
        if ($approvalStatus == 0) {
            $approvedForm = null;
            $viewableDeadline = null;
            $isLocked = 1;
        }

        $requestedForm = RequestedLoanForm::find($request->request_id);
        $requestedForm->is_completed = 1;
        $requestedForm->is_approved = $request->approval_status;
        $requestedForm->request_loan_id = $approvedForm;
        $requestedForm->save();

        $formType = $requestedForm->is_original? 'original copy' : 'electronic copy';

        $approval = new RequestedLoanFormApproval();
        $approval->is_locked = $isLocked;
        $approval->date_approved = $approvalDate;
        $approval->viewable_deadline = $viewableDeadline;
        $approval->approved_by = Auth::user()->id;
        $approval->approval_message = $request->approval_message;
        $approval->approval_status = $request->approval_status;
        $approval->loan_form_id = $approvedForm;
        $approval->request_id = $request->request_id;
        $approval->save();

        $action = $request->approval_status == 1 ? 'approved' : 'rejected';

        //send requester sms notification and email
        $requester = User::getUserById($requestedForm->requested_by);
        $message = new Message();
        $approvalMessage = 'your '.$formType.' loan form request of reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id.' was '.$action.' on '.$approvalDate.'. You can log in to the Staffportal to view. For assistance, contact the Records Department.';
        $approvalEmailMessage = 'your '.$formType.' loan form request of reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id.' was '.$action.' on '.$approvalDate.'. Click this link '.route('user.loan-forms.attachment', $request->request_id).' to view the loan form through the Staffportal. For assistance, contact the Records Department.';
        $messageEmailBody = $message->getGreetings(strtoupper($requester->name)).', '.$approvalEmailMessage;
        $messageBody = $message->getGreetings(strtoupper($requester->name)).', '.$approvalMessage;
        $mobileNo = Admin::formatMobileNumber($requester->mobile_no);
        $message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'loan_form_'.$action; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $requester->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageEmailBody;
        $message->save();

        //send email
        $mailSubject = ucwords($formType). ' Loan form request of reference '.$requestedForm->reference;
        $message->SendSystemEmail(ucwords($requester->name), $requester->email, $messageEmailBody, strtoupper($mailSubject));
        
        //send user notification
        $message = new Message();
        $user = User::getUserById(Auth::user()->id);

        $systemMessage = 'you have successfully '.$action.' '.$formType.'  loan form request with reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id;
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = Admin::formatMobileNumber($user->mobile_no);
        $message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'loan_form_'.$action; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Save audit trail
        $activity_type = 'Loan Form Request '.ucwords($action);
        $description = ucwords($action).' '.$formType.'  loan form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);
 
        return redirect(route('records.requested-forms.index'))->with('success', 'You have successfully '.$action.' '.$formType.'  loan form request of reference '. $requestedForm->reference);
    }

    private function getRequestReference($product_code)
    {
        return  strtoupper($product_code.'-'.date('YmdHi'));
    }

    public static function getRecordsAdmins()
    {
        return [
            ['name' => 'Anuary Mulombi', 'mobile_no' => '254703539208'],
            ['name' => 'Ibrahim Adan', 'mobile_no' => '254716183666'],
            ['name' => 'Christine Mwangi', 'mobile_no' => '254114474033'],
            //['name' => 'Victoria Wairimu', 'mobile_no' => '254112160112'],
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

    ///branch user loan form
    public function userRequestedLoanForms()
    {
        $loanRequest = new RequestedLoanForm();
        //return $loanRequest->getUserRequestedLoanForms(Auth::user()->id, 0);
        $pageData = [
			'page_name' => 'records',
            'title' => 'User Requested Loan Forms',
            'pendingRequests' => $loanRequest->getUserRequestedLoanForms(Auth::user()->id, 0),
            'completedRequests' => $loanRequest->getUserRequestedLoanForms(Auth::user()->id, 1),
        ];
        return view('records.requested.user_requested_forms', $pageData);
    }

    public function requestLoanForm()
    {
        $user = User::getUserById(Auth::user()->id);
        $pageData = [
            'user' => $user,
			'page_name' => 'records',
            'title' => 'Request Loan Form',
            'products' => Admin::getLoanProducts(),
            'clients' => Client::getClientsByOutpost($user->outpost_id),
        ];
        return view('records.requested.request_loan_form', $pageData);
    }

    public function requestedLoanForm($id)
    {
        $form = new RequestedLoanForm();
        $loanRequest = $form->getLoanFormRequestById($id);

        if(Auth::user()->id !== $loanRequest->requested_by)
        return back()->with('warning', 'You dont have rights to view this loan form request');
        
        //check if viewable deadline has passed
        //$this->checkIfViewableDeadline($loanRequest);
        
        $pageData = [
			'page_name' => 'records',
            'loanRequest' => $loanRequest,
            'title' => 'Loan Form Request Details',
            'products' => Admin::getLoanProducts(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
            'approvalDetails' => RequestedLoanFormApproval::getRequestApprovalDetails($id),
        ];
        return view('records.requested.requested_loan_form', $pageData);
    }

    public function viewRequestedLoanForm($id)
    {
        $form = new RequestedLoanForm();
        $loanRequest = $form->getLoanFormRequestById($id);

        $user = Auth::user();
        if(!$user->hasRole('admin|records')){
            if($user->id !== $loanRequest->requested_by || $this->checkIfViewableDeadline($loanRequest))
            return back()->with('warning', 'You dont have rights to view this loan form or viewable deadline has passed');
        }

        $pageData = [
			'page_name' => 'records',
            'page_title' => 'view',
            'loan_form' => LoanForm::find($loanRequest->request_loan_id),
            'title' => 'Requested Loan Form',
        ];
        return view('records.requested.view_loan_form', $pageData);
    }

    //check if viewable deadline has passed
    private function checkIfViewableDeadline($loanRequest)
    {
        if ($loanRequest->is_locked) return true;
        
        $today = strtotime(now());
        $deadline = strtotime($loanRequest->viewable_deadline);
        
        if ($today > $deadline){
            $requestedForm = RequestedLoanFormApproval::find($loanRequest->approval_id);
            $requestedForm->is_locked = 1;
            $requestedForm->save();
            return true;
        }
        return false;
    }
}
