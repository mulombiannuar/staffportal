<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\DrivingLicense;
use App\Models\FuelConsumption;
use App\Models\InsurancePolicy;
use App\Models\Message;
use App\Models\MotorMaintenance;
use App\Models\Products\Motor;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MotorController extends Controller
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
			'page_name' => 'assets',
            'title' => 'Add New Motor',
            'branches' => Admin::getBranches()
        ];
        return view('assets.motor.create', $pageData);
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
            'outpost_id' => [
                'required', 
                'integer', 
            ],
            'branch' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'required',
                'string',
            ],
            'chassis_number' => [
                'required',
                'string',
                Rule::unique(Motor::class),
            ],
            'reg_no' => [
                'required',
                'string',
                Rule::unique(Motor::class),
            ],
            'mileage' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
                'string',
            ],
            'color' => [
                'required',
                'string',
            ],
            'engine' => [
                'required',
                'string',
            ],
            'model' => [
                'required',
                'string',
            ],
            'build_year' => [
                'required',
                'string',
            ],
            'last_maintenance' => [
                'required',
                'string',
            ],
            'supplier' => [
                'required',
                'string',
            ],
            'date_assigned' => [
                'required',
                'string',
            ],
            'date_purchased' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);
        //return $request;

        $user_id = $request->input('user_id');
        $user_exists = Motor::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');

        $motor = new Motor();
        $motor->product_id = 5;
        $motor->name = $request->input('name');
        $motor->chassis_number = $request->input('chassis_number');
        $motor->mileage = $request->input('mileage');
        $motor->type = $request->input('type');
        $motor->color = $request->input('color');
        $motor->engine = $request->input('engine');
        $motor->model = $request->input('model');
        $motor->reg_no = $request->input('reg_no');
        $motor->build_year = $request->input('build_year');
        $motor->last_maintenance = $request->input('last_maintenance');
        $motor->supplier = $request->input('supplier');
        $motor->date_assigned = $request->input('date_assigned');
        $motor->date_purchased = $request->input('date_purchased');
        $motor->additional_info = $request->input('additional_info');
        $motor->assigned_to = $request->input('user_id');
        $motor->assigned_by = Auth::user()->id;
        $motor->save();

        //Save audit trail
        $activity_type = $motor->type.' Creation';
        $description = 'Successfully created new motor with chassis number '.$motor->chassis_number;
        User::saveAuditTrail($activity_type, $description);

        //Send email and SMS notification to owner
        $user = User::getUserById($motor->assigned_to);
        $systemMessage = $motor->type.' with registration number '.$motor->reg_no.' has been successfully assigned to you. Contact Admin for more assistance';
        $message = new Message();
        $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
    
        //$message->sendSms($mobileNo, $systemMessage);
        $message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'motor_assigning'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        return redirect(route('admin.assets.show', 'motors'))->with('success', 'New Motor details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Motor();
        $assign = new AssignedAsset();
        $license = new DrivingLicense();
        $log = new MotorMaintenance();
        $fuel = new FuelConsumption();
        //return $log->getLogsByAssetId($id);
        $details = $asset->getMotorById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => $details->type.' Details - '.ucwords($details->chassis_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 5),
            'licenses' => $license->getLicensesByAssetId($id),
            'logs' => $log->getLogsByAssetId($id),
            'fuels' => $fuel->getConsumptionsByAssetId($id),
            'products' => InsurancePolicy::getInsuranceProducts(),
            'companies' => InsurancePolicy::getInsuranceCompanies(),
            'policy' => InsurancePolicy::getInsurancePolicyByRefNumber($details->reg_no)
        ];
        return view('assets.motor.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Motor();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Motor Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getMotorById($id),
        ];
        return view('assets.motor.edit', $pageData);
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
            'outpost_id' => [
                'required', 
                'integer', 
            ],
            'branch' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'required',
                'string',
            ],
            'chassis_number' => [
                'required',
                'string',
            ],
            'reg_no' => [
                'required',
                'string',
            ],
            'mileage' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
                'string',
            ],
            'color' => [
                'required',
                'string',
            ],
            'engine' => [
                'required',
                'string',
            ],
            'model' => [
                'required',
                'string',
            ],
            'build_year' => [
                'required',
                'string',
            ],
            'last_maintenance' => [
                'required',
                'string',
            ],
            'supplier' => [
                'required',
                'string',
            ],
            'date_assigned' => [
                'required',
                'string',
            ],
            'date_purchased' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $motor = Motor::find($id);
        $motor->name = $request->input('name');
        $motor->chassis_number = $request->input('chassis_number');
        $motor->mileage = $request->input('mileage');
        $motor->type = $request->input('type');
        $motor->color = $request->input('color');
        $motor->engine = $request->input('engine');
        $motor->model = $request->input('model');
        $motor->reg_no = $request->input('reg_no');
        $motor->build_year = $request->input('build_year');
        $motor->last_maintenance = $request->input('last_maintenance');
        $motor->supplier = $request->input('supplier');
        $motor->date_assigned = $request->input('date_assigned');
        $motor->date_purchased = $request->input('date_purchased');
        $motor->additional_info = $request->input('additional_info');
        $motor->assigned_to = $request->input('user_id');
        $motor->save();

        //Save audit trail
        $activity_type = 'Motor Updation';
        $description = 'Successfully updated motor with chassis number '.$motor->chassis_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'motors'))->with('success', $motor->type.' details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Motor::find($id)->delete();
        AssignedAsset::where(['product_id' => 5, 'asset_id' => $id])->delete();
        //Repair::where(['product_id' => 4, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Motor Deletion';
        $description = 'Successfully deleted motor details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'motors'))->with('success', 'Motor data deleted successfully');
    }
}