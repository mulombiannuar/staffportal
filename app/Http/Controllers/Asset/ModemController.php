<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\Products\Modem;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ModemController extends Controller
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
            'title' => 'Add New Modem',
            'branches' => Admin::getBranches()
        ];
        return view('assets.modem.create', $pageData);
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
                Rule::unique(Modem::class),
            ],
            'phone_number' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
                Rule::unique(Modem::class),
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

        $user_id = $request->input('user_id');
        $user_exists = Modem::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');

        //return $request;
        $modem = new Modem();
        $modem->product_id = 4;
        $modem->name = $request->input('name');
        $modem->serial_number = $request->input('serial_number');
        $modem->phone_number = $request->input('phone_number');
        $modem->date_assigned = $request->input('date_assigned');
        $modem->date_purchased = $request->input('date_purchased');
        $modem->additional_info = $request->input('additional_info');
        $modem->assigned_to = $request->input('user_id');
        $modem->assigned_by = Auth::user()->id;
        $modem->save();

        //Save audit trail
        $activity_type = 'Modem Creation';
        $description = 'Successfully created new modem with serial number '.$modem->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'modems'))->with('success', 'New modem details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Modem();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getModemById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Modem Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 4),
            'repairs' => $repair->getAssetRepairHistory($id, 4),
        ];
        return view('assets.modem.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Modem();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Modem Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getModemById($id),
        ];
        return view('assets.modem.edit', $pageData);
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
            'phone_number' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
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
        $modem = Modem::find($id);
        $modem->product_id = 4;
        $modem->name = $request->input('name');
        $modem->serial_number = $request->input('serial_number');
        $modem->phone_number = $request->input('phone_number');
        $modem->date_assigned = $request->input('date_assigned');
        $modem->date_purchased = $request->input('date_purchased');
        $modem->additional_info = $request->input('additional_info');
        $modem->assigned_to = $request->input('user_id');
        $modem->save();
    
        //Save audit trail
        $activity_type = 'Modem Updation';
        $description = 'Successfully updated modem with serial number '.$modem->serial_number;
        User::saveAuditTrail($activity_type, $description);
    
        return redirect(route('admin.assets.show', 'modems'))->with('success', 'Modem data saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Modem::find($id)->delete();
        AssignedAsset::where(['product_id' => 4, 'asset_id' => $id])->delete();
        Repair::where(['product_id' => 4, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Modem Deletion';
        $description = 'Successfully deleted modem details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'modems'))->with('success', 'Modem data deleted successfully');
    }
}