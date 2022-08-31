<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\MaintenanceLog;
use App\Models\Products\Desktop;
use App\Models\Repair;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesktopController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Add New Desktop',
            'branches' => Admin::getBranches()
        ];
        return view('assets.desktop.create', $pageData);
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
            'supplier_name' => [
                'required',
                'string',
            ],
            'date_purchased' => [
                'required',
                'string',
            ],
            'model' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'serial_number' => [
                'required',
                'string',
            ],
            'monitor_serial' => [
                'required',
                'string',
            ],
            'monitor_type' => [
                'required',
                'string',
            ],
            'operating_system' => [
                'required',
                'string',
            ],
            'os_key' => [
                'required',
                'string',
            ],
            'hdd_details' => [
                'required',
                'string',
            ],
            'processor' => [
                'required',
                'string',
            ],
            'ram' => [
                'required',
                'string',
            ],
            'office_name' => [
                'required',
                'string',
            ],
            'office_key' => [
                'required',
                'string',
            ],
            'keyboard_name' => [
                'required',
                'string',
            ],
            'keyboard_serial' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);

        $user_id = $request->input('user_id');
        $user_exists = Desktop::where('assigned_to', $user_id)->first();

        if($user_exists && $user_id != 136 || $user_id != 248)
        return back()->with('danger', 'This user already exists in this list assets');

        $desktop = new Desktop();
        $desktop->product_id = 1;
        $desktop->name = $request->input('name');
        $desktop->manufacturer = $request->input('manufacturer');
        $desktop->model = $request->input('model');
        $desktop->serial_number = $request->input('serial_number');
        $desktop->operating_system = $request->input('operating_system');
        $desktop->supplier_name = $request->input('supplier_name');
        $desktop->os_key = $request->input('os_key');
        $desktop->office_name = $request->input('office_name');
        $desktop->office_key = $request->input('office_key');
        $desktop->processor = $request->input('processor');
        $desktop->keyboard_name = $request->input('keyboard_name');
        $desktop->monitor_type = $request->input('monitor_type');
        $desktop->monitor_serial = $request->input('monitor_serial');
        $desktop->keyboard_serial = $request->input('keyboard_serial');
        $desktop->ram = $request->input('ram');
        $desktop->hdd_details = $request->input('hdd_details');
        $desktop->date_assigned = $request->input('date_assigned');
        $desktop->date_purchased = $request->input('date_purchased');
        $desktop->additional_info = $request->input('additional_info');
        $desktop->assigned_to = $request->input('user_id');
        $desktop->assigned_by = Auth::user()->id;
        $desktop->save();

        //Save audit trail
        $activity_type = 'Desktop Creation';
        $description = 'Successfully created new desktop with serial number '.$desktop->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'desktops'))->with('success', 'New desktop  details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Desktop();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $log = new MaintenanceLog();
        $details = $asset->getDesktopById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Desktop Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 1),
            'repairs' => $repair->getAssetRepairHistory($id, 1),
            'logs' => $log->getAssetLogHistory($id, 1),
        ];
        return view('assets.desktop.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Desktop();
        //return $asset->getDesktopById($id);
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Desktop Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getDesktopById($id),
        ];
        return view('assets.desktop.edit', $pageData);
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
        //return $request;
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
            'supplier_name' => [
                'required',
                'string',
            ],
            'date_purchased' => [
                'required',
                'string',
            ],
            'model' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'serial_number' => [
                'required',
                'string',
            ],
            'monitor_serial' => [
                'required',
                'string',
            ],
            'monitor_type' => [
                'required',
                'string',
            ],
            'operating_system' => [
                'required',
                'string',
            ],
            'os_key' => [
                'required',
                'string',
            ],
            'hdd_details' => [
                'required',
                'string',
            ],
            'processor' => [
                'required',
                'string',
            ],
            'ram' => [
                'required',
                'string',
            ],
            'office_name' => [
                'required',
                'string',
            ],
            'office_key' => [
                'required',
                'string',
            ],
            'keyboard_name' => [
                'required',
                'string',
            ],
            'keyboard_serial' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);

        $desktop = Desktop::find($id);
        $desktop->name = $request->input('name');
        $desktop->manufacturer = $request->input('manufacturer');
        $desktop->model = $request->input('model');
        $desktop->serial_number = $request->input('serial_number');
        $desktop->operating_system = $request->input('operating_system');
        $desktop->supplier_name = $request->input('supplier_name');
        $desktop->os_key = $request->input('os_key');
        $desktop->office_name = $request->input('office_name');
        $desktop->office_key = $request->input('office_key');
        $desktop->processor = $request->input('processor');
        $desktop->keyboard_name = $request->input('keyboard_name');
        $desktop->monitor_type = $request->input('monitor_type');
        $desktop->monitor_serial = $request->input('monitor_serial');
        $desktop->keyboard_serial = $request->input('keyboard_serial');
        $desktop->ram = $request->input('ram');
        $desktop->hdd_details = $request->input('hdd_details');
        $desktop->date_assigned = $request->input('date_assigned');
        $desktop->date_purchased = $request->input('date_purchased');
        $desktop->additional_info = $request->input('additional_info');
        $desktop->assigned_to = $request->input('user_id');
        $desktop->save();

        //Save audit trail
        $activity_type = 'Desktop Updation';
        $description = 'Successfully updated desktop with serial number '.$desktop->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'desktops'))->with('success', 'Desktop  details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Desktop::find($id)->delete();
        AssignedAsset::where(['product_id' => 1, 'asset_id' => $id])->delete();
        MaintenanceLog::where(['product_id' => 1, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Desktop Deletion';
        $description = 'Successfully deleted desktop details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'desktops'))->with('success', 'Desktop  data deleted successfully');
    }
}