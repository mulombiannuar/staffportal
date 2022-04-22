<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\Products\Swittch;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Swift;

class SwitchController extends Controller
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
            'title' => 'Add New Switch',
            'branches' => Admin::getBranches()
        ];
        return view('assets.switch.create', $pageData);
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
                Rule::unique(Swittch::class),
            ],
            'supplier' => [
                'required',
                'string',
            ],
            'model_no' => [
                'required',
                'string',
            ],
            'location' => [
                'required',
                'string',
            ],
            'date_assigned' => [
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
        $user_exists = Swittch::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');

        $switch = new Swittch();
        $switch->product_id = 9;
        $switch->name = $request->input('name');
        $switch->serial_number = $request->input('serial_number');
        $switch->model_no = $request->input('model_no');
        $switch->location = $request->input('location');
        $switch->supplier = $request->input('supplier');
        $switch->location = $request->input('location');
        $switch->date_assigned = $request->input('date_assigned');
        $switch->date_purchased = $request->input('date_purchased');
        $switch->additional_info = $request->input('additional_info');
        $switch->assigned_to = $request->input('user_id');
        $switch->assigned_by = Auth::user()->id;
        $switch->save();

        //Save audit trail
        $activity_type = 'Switch Creation';
        $description = 'Successfully created new switch with serial number '.$switch->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'switches'))->with('success', 'New switch details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Swittch();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getSwitchById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Switch Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 9),
            'repairs' => $repair->getAssetRepairHistory($id, 9),
        ];
        return view('assets.switch.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Swittch();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Switch Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getSwitchById($id),
        ];
        return view('assets.switch.edit', $pageData);
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
            'model_no' => [
                'required',
                'string',
            ],
            'location' => [
                'required',
                'string',
            ],
            'date_assigned' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $switch = Swittch::find($id);
        $switch->product_id = 9;
        $switch->name = $request->input('name');
        $switch->serial_number = $request->input('serial_number');
        $switch->model_no = $request->input('model_no');
        $switch->location = $request->input('location');
        $switch->supplier = $request->input('supplier');
        $switch->location = $request->input('location');
        $switch->date_assigned = $request->input('date_assigned');
        $switch->date_purchased = $request->input('date_purchased');
        $switch->additional_info = $request->input('additional_info');
        $switch->assigned_to = $request->input('user_id');
        $switch->save();

        //Save audit trail
        $activity_type = 'Switch Creation';
        $description = 'Successfully updated switch with serial number '.$switch->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'switches'))->with('success', 'Switch details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Swittch::find($id)->delete();
        AssignedAsset::where(['product_id' => 9, 'asset_id' => $id])->delete();
        Repair::where(['product_id' => 9, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Switch Deletion';
        $description = 'Successfully deleted switch data';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'switches'))->with('success', 'Switch data deleted successfully');
    }
}