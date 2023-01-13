<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Records\Client;
use App\Models\Records\ClientChangeForm;
use App\Models\Records\RequestedChangeForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestedChangeFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'title' => 'Add Change Forms',
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.requested_change.create', $pageData);
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
            'bimas_br_id' => 'required|string|digits:7|max:7|min:7',
            'client_phone' => 'required|digits:12|max:12|min:12',
            'national_id' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'officer_message' => 'required|string',
            'date_changed' => 'required|string|max:255',
            'branch' => 'required|integer',
            'outpost' => 'required|integer',
            'is_original' => 'required|integer',
        ]);

        $requestedForm = new RequestedChangeForm();
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
        $requestedForm->date_changed = $request->input('date_changed');
        $requestedForm->officer_message = $request->input('officer_message');
        $requestedForm->reference = strtoupper('CDCF'.'-'.date('YmdHi'));
        $requestedForm->save();

        $formType = $requestedForm->is_original? 'original copy' : 'electronic copy';
        //send user notification and email
        $message = new Message();
        $user = User::getUserById(Auth::user()->id);

        $systemMessage = 'you have successfully lodged a new '.$formType.' client details change form request with reference '. $requestedForm->reference.' for '.$requestedForm->client_name. '-'.$requestedForm->bimas_br_id;
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
        $message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'change_form_request'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //send email
        $mailSubject = 'Client change form request of reference '.$requestedForm->reference;
        $message->SendSystemEmail(ucwords($user->name), $user->email, $messageBody, strtoupper($mailSubject));

        //send sms to records admin
        $admins = RequestedLoanFormController::getRecordsAdmins();
        for ($s=0; $s <count($admins) ; $s++) 
        { 
            $adminMessage = strtoupper($user->name).' has lodged a new '.$formType.' client details change form request with reference '.$requestedForm->reference;
            $message = new Message();
            $messageBody = $message->getGreetings(strtoupper($admins[$s]['name'])).', '.$adminMessage;
            $mobileNo = $admins[$s]['mobile_no'];
            //$message->sendSms($mobileNo, $sms);
            $message->sendSms('254703539208', $messageBody);

            $message->message_status = 'sent'; 
            $message->message_type = 'records_admin'; 
            $message->recipient_no = $mobileNo; 
            $message->recipient_name = $admins[$s]['name']; 
            $message->logged_date =  date('D, d M Y H:i:s'); 
            $message->message_body = $messageBody;
            $message->save();
        }

        //Save audit trail
        $activity_type = 'Client Change Form Request';
        $description = 'Created new '.$formType.' client details change form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);

        $redirectRoute = Auth::user()->hasRole('admin|records') 
        ? route('records.change-forms.index')
        : route('user.change-forms.view');

        return redirect($redirectRoute)->with('success', 'You have successfully lodged new '.$formType.' client details change form request of reference '. $requestedForm->reference);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formData = RequestedChangeForm::getChangeFormRequestById($id);
        $client = Client::getClientBRId($formData->bimas_br_id);
        $requestedChangeForm = [];
        if($client)
        $requestedChangeForm = ClientChangeForm::getRequestedChangeForm($formData->bimas_br_id, $formData->date_changed);
        
        $pageData = [
            'client' => $client,
            'form'=> $formData,
			'page_name' => 'records',
            'requested_form' => $requestedChangeForm,
            'title' => 'Client Change Form Details',
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.requested_change.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return RequestedChangeForm::getChangeFormRequestById($id);
        $pageData = [
			'page_name' => 'records',
            'title' => 'Update Change Forms',
            'form'=> RequestedChangeForm::getChangeFormRequestById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('records.requested_change.edit', $pageData);
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
            'user_id' => 'required|integer',
            'officer_message' => 'required|string',
            'date_changed' => 'required|string|max:255',
            'branch' => 'required|integer',
            'outpost' => 'required|integer',
            'is_original' => 'required|integer',
        ]);

        $requestedForm = RequestedChangeForm::find($id);
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
        $requestedForm->date_changed = $request->input('date_changed');
        $requestedForm->officer_message = $request->input('officer_message');
        $requestedForm->reference = strtoupper('CDCF'.'-'.date('YmdHi'));
        $requestedForm->save();

        $formType = $requestedForm->is_original? 'original copy' : 'electronic copy';
      
        //Save audit trail
        $activity_type = 'Client Change Form Updation';
        $description = 'Updated '.$formType.' client details change form request of reference '. $requestedForm->reference;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('records.change-forms.index'))->with('success', 'You have successfully updated '.$formType.' client details change form request of reference '. $requestedForm->reference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestedChangeForm::find($id)->delete();

        //Save audit trail
        $activity_type = 'Change Form Request Deletion';
        $description = 'Successfully deleted change form request of id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted change form request successfully');
    }
}
