<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use App\Models\MotorMaintenance;
use App\Models\Products\Motor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotorMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = new MotorMaintenance();
        //return $license->getAssetlicenses();
        $pageData = [
            'page_name' => 'assets',
            'title' => 'Motors Maintenance Logs',
            'logs' => $log->getLogs(),
        ];
        return view('assets.logs.motor_index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function book($asset_id)
    {
        $asset = new Motor();
        $details = $asset->getMotorById($asset_id);
        $pageData = [
            'page_name' => 'assets',
            'title' => 'Maintenance Services Booking',
            'asset' => $details,
        ];
        return view('assets.logs.motor_add', $pageData);
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
            'asset_id' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
                'string',
            ],
            'date' => [
                'required',
                'string',
            ],
            'message' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $log = new MotorMaintenance();
        $log->user_id = $request->input('user_id');
        $log->asset_id = $request->input('asset_id');
        $log->type = $request->input('type');
        $log->date = $request->input('date');
        $log->message = $request->input('message');
        $log->reference = 'Bkl-'.date('YmdHi');
        $log->save();

        $user = User::getUserById($log->user_id);
        $admins = Admin::getAdmins();

        //Save audit trail
        $activity_type = 'Booking Creation';
        $systemMessage = 'You have successfully lodged new booking with reference '.$log->reference .' dated '.$log->date;
        User::saveAuditTrail($activity_type, $systemMessage);

        //Send email and SMS notification to owner
        $message = new Message();
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
      
        //$message->sendSms($mobileNo, $systemMessage);
        $message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'booking'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Send email and SMS notification to admins
        for ($s=0; $s <count($admins) ; $s++) 
        { 
            $sms = strtoupper($user->name).' has successfully lodged new booking with reference '.$log->reference .' dated '.$log->date;
            $message = new Message();
            $messageBody = $message->getGreetings(strtoupper($admins[$s]['user_name'])).', '.$sms;
            $mobileNo = $admins[$s]['user_phone'];
        
            //$message->sendSms($mobileNo, $sms);

            $message->message_status = 'sent'; 
            $message->message_type = 'access_token'; 
            $message->recipient_no = $mobileNo; 
            $message->recipient_name = $admins[$s]['user_name']; 
            $message->logged_date =  date('D, d M Y H:i:s'); 
            $message->message_body = $messageBody;
            $message->save();
        }
        return redirect(route('admin.motors.show', $log->asset_id))->with('success', 'You have successfully lodged new booking with reference '.$log->reference .' dated '.$log->date);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $log = new MotorMaintenance();
       // return $log->getLogById($id);
        $details = $log->getLogById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Booking Details - '.strtoupper($details->reference),
            'branches' => Admin::getBranches(),
            'approval' => $log->getApprovalStatus($details->status),
            'log' => $log->getLogById($id),
        ];
        return view('assets.logs.motor_show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $log = new MotorMaintenance();
        //return $log->getLogsByAssetId($id);
        $details = $log->getLogById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Booking Details - '.strtoupper($details->reference),
            'branches' => Admin::getBranches(),
            'log' => $log->getLogById($id),
        ];
        return view('assets.logs.motor_edit', $pageData);
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
            'type' => [
                'required',
                'string',
            ],
            'date' => [
                'required',
                'string',
            ],
            'message' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $log = MotorMaintenance::find($id);
        $log->type = $request->input('type');
        $log->date = $request->input('date');
        $log->message = $request->input('message');
        $log->save();

        //Save audit trail
        $activity_type = 'Booking Details Updation';
        $description = 'Successfully updated booking details with reference '.$log->reference;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully updated booking details with reference '.$log->reference);
    }

    public function approveBooking(Request $request, $id)
    {
        $request->validate([
            'status' => [
                'required',
                'integer',
            ],
            'date' => [
                'required',
                'string',
            ],
            'approval_message' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $log = MotorMaintenance::find($id);
        $log->status = $request->input('status');
        $log->date = $request->input('date');
        $log->approval_message = $request->input('approval_message');
        $log->approved_by = Auth::user()->id;
        $log->date_approved = Carbon::now();
        $log->save();

        //Save audit trail
        $activity_type = 'Booking Details Approval';
        $description = 'Successfully approved booking details with reference '.$log->reference;
        User::saveAuditTrail($activity_type, $description);

        //Send email and SMS notification to owner
        $user = User::getUserById($log->user_id);
        $systemMessage = 'your booking reference '.$log->reference.' has been approved successfully. Check in the in your staffportal account for more details';
        $message = new Message();
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
      
        //$message->sendSms($mobileNo, $systemMessage);
        $message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'booking_approval'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        return back()->with('success', 'Successfully approved booking details with reference '.$log->reference);
    }

    public function saveService(Request $request, $id)
    {
        $request->validate([
            'service_cause' => [
                'required',
                'string',
            ],
            'service_date' => [
                'required',
                'string',
            ],
            'service_cost' => [
                'required',
                'numeric',
            ],
            'service_done' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $log = MotorMaintenance::find($id);
        $log->service_cause = $request->input('service_cause');
        $log->service_date = $request->input('service_date');
        $log->service_done = $request->input('service_done');
        $log->service_cost = $request->input('service_cost');
        $log->additional_info = $request->input('additional_info');
        $log->service_by = Auth::user()->id;
        $log->save();

        //Save audit trail
        $activity_type = 'Booking Service Saving';
        $description = 'Successfully saved booking service details with reference '.$log->reference;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully saved booking service details with referenc '.$log->reference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MotorMaintenance::find($id)->delete();

        //Save audit trail
        $activity_type = 'Motor Maintenance Data Deletion';
        $description = 'Successfully deleted Motor Maintenance Data ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully deleted Motor Maintenance Data');
    }
}