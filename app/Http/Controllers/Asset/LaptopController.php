<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\MaintenanceLog;
use App\Models\Products\Laptop;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            'title' => 'Add New Laptop',
            'branches' => Admin::getBranches()
        ];
        return view('assets.laptop.create', $pageData);
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
            'display' => [
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
            'additional_info' => [
                'required',
                'string',
            ],

        ]);
        //return $request;

        $user_id = $request->input('user_id');
        $user_exists = Laptop::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');
        
        $laptop = new Laptop();
        $laptop->product_id = 2;
        $laptop->name = $request->input('name');
        $laptop->manufacturer = $request->input('manufacturer');
        $laptop->model = $request->input('model');
        $laptop->serial_number = $request->input('serial_number');
        $laptop->operating_system = $request->input('operating_system');
        $laptop->supplier_name = $request->input('supplier_name');
        $laptop->os_key = $request->input('os_key');
        $laptop->office_name = $request->input('office_name');
        $laptop->office_key = $request->input('office_key');
        $laptop->processor = $request->input('processor');
        $laptop->display = $request->input('display');
        $laptop->ram = $request->input('ram');
        $laptop->hdd_details = $request->input('hdd_details');
        $laptop->date_assigned = $request->input('date_assigned');
        $laptop->date_purchased = $request->input('date_purchased');
        $laptop->additional_info = $request->input('additional_info');
        $laptop->assigned_to = $request->input('user_id');
        $laptop->assigned_by = Auth::user()->id;
        $laptop->save();

        //Save audit trail
        $activity_type = 'Laptop Creation';
        $description = 'Successfully created new laptop with serial number '.$laptop->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'laptops'))->with('success', 'New laptop  details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Laptop();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $log = new MaintenanceLog();
        $details = $asset->getLaptopById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Laptop Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 2),
            'repairs' => $repair->getAssetRepairHistory($id, 2),
            'logs' => $log->getAssetLogHistory($id, 2),
        ];
        return view('assets.laptop.show', $pageData);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Laptop();
        //return $asset->getDesktopById($id);
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Laptop Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getLaptopById($id),
        ];
        return view('assets.laptop.edit', $pageData);
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
            'display' => [
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
            'additional_info' => [
                'required',
                'string',
            ],

        ]);

        $laptop = Laptop::find($id);
        $laptop->name = $request->input('name');
        $laptop->manufacturer = $request->input('manufacturer');
        $laptop->model = $request->input('model');
        $laptop->serial_number = $request->input('serial_number');
        $laptop->operating_system = $request->input('operating_system');
        $laptop->supplier_name = $request->input('supplier_name');
        $laptop->os_key = $request->input('os_key');
        $laptop->office_name = $request->input('office_name');
        $laptop->office_key = $request->input('office_key');
        $laptop->processor = $request->input('processor');
        $laptop->display = $request->input('display');
        $laptop->ram = $request->input('ram');
        $laptop->hdd_details = $request->input('hdd_details');
        $laptop->date_assigned = $request->input('date_assigned');
        $laptop->date_purchased = $request->input('date_purchased');
        $laptop->additional_info = $request->input('additional_info');
        $laptop->assigned_to = $request->input('user_id');
        $laptop->save();

        //Save audit trail
        $activity_type = 'Laptop Updation';
        $description = 'Successfully updated laptop with serial number '.$laptop->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'laptops'))->with('success', 'Llaptop  details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Laptop::find($id)->delete();
        AssignedAsset::where(['product_id' => 2, 'asset_id' => $id])->delete();
        MaintenanceLog::where(['product_id' => 2, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Laptop Deletion';
        $description = 'Successfully deleted laptop details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'laptops'))->with('success', 'Laptop data deleted successfully');
    }
}