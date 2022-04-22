<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\Products\PowerSupply;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PowerSupplyController extends Controller
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
            'title' => 'Add New UPS',
            'branches' => Admin::getBranches()
        ];
        return view('assets.ups.create', $pageData);
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
            'serial_number' => [
                'required',
                'string',
                Rule::unique(PowerSupply::class),
            ],
            'supplier' => [
                'required',
                'string',
            ],
            'output_capacity' => [
                'required',
                'string',
            ],
            'input_capacity' => [
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
            'battery_time' => [
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
        $user_exists = PowerSupply::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');

        $ups = new PowerSupply();
        $ups->product_id = 10;
        $ups->name = $request->input('name');
        $ups->serial_number = $request->input('serial_number');
        $ups->output_capacity = $request->input('output_capacity');
        $ups->input_capacity = $request->input('input_capacity');
        $ups->battery_time = $request->input('battery_time');
        $ups->supplier = $request->input('supplier');
        $ups->date_assigned = $request->input('date_assigned');
        $ups->date_purchased = $request->input('date_purchased');
        $ups->additional_info = $request->input('additional_info');
        $ups->assigned_to = $request->input('user_id');
        $ups->assigned_by = Auth::user()->id;
        $ups->save();

        //Save audit trail
        $activity_type = 'UPS Creation';
        $description = 'Successfully created new UPS with serial number '.$ups->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'ups'))->with('success', 'New UPS details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new PowerSupply();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getPowerSupplyById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'UPS Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 10),
            'repairs' => $repair->getAssetRepairHistory($id, 10),
        ];
        return view('assets.ups.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new PowerSupply();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit UPS Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getPowerSupplyById($id),
        ];
        return view('assets.ups.edit', $pageData);
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
            'serial_number' => [
                'required',
                'string',
            ],
            'supplier' => [
                'required',
                'string',
            ],
            'output_capacity' => [
                'required',
                'string',
            ],
            'input_capacity' => [
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
            'battery_time' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $ups = PowerSupply::find($id);
        $ups->name = $request->input('name');
        $ups->serial_number = $request->input('serial_number');
        $ups->output_capacity = $request->input('output_capacity');
        $ups->input_capacity = $request->input('input_capacity');
        $ups->battery_time = $request->input('battery_time');
        $ups->supplier = $request->input('supplier');
        $ups->date_assigned = $request->input('date_assigned');
        $ups->date_purchased = $request->input('date_purchased');
        $ups->additional_info = $request->input('additional_info');
        $ups->assigned_to = $request->input('user_id');
        $ups->save();

        //Save audit trail
        $activity_type = 'UPS Updation';
        $description = 'Successfully updated UPS with serial number '.$ups->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'ups'))->with('success', 'UPS details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PowerSupply::find($id)->delete();
        AssignedAsset::where(['product_id' => 10, 'asset_id' => $id])->delete();
        Repair::where(['product_id' => 10, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'UPS Deletion';
        $description = 'Successfully deleted UPS data';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'ups'))->with('success', 'UPS data deleted successfully');
    }
}