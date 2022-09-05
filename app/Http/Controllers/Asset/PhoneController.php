<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\MaintenanceLog;
use App\Models\Products\Phone;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PhoneController extends Controller
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
            'title' => 'Add New Mobile Phone',
            'branches' => Admin::getBranches()
        ];
        return view('assets.phone.create', $pageData);
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
                Rule::unique(Phone::class),
            ],
            'imei_number' => [
                'required',
                'string',
            ],
            'phone_number' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
                Rule::unique(Phone::class),
            ],
            'puk_1' => [
                'required',
                'string',
            ],
            'puk_2' => [
                'required',
                'string',
            ],
            'pin_1' => [
                'required',
                'string',
            ],
            'pin_2' => [
                'required',
                'string',
            ],
            'date_purchased' => [
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
        $user_exists = Phone::where('assigned_to', $user_id)->first();
        $user = User::find($user_id);

        if(!empty($user_exists) && !$user->hasRole('admin'))
        return back()->with('danger', 'This user already exists in this list assets');

        $phone = new Phone();
        $phone->product_id = 3;
        $phone->name = $request->input('name');
        $phone->serial_number = $request->input('serial_number');
        $phone->imei_number = $request->input('imei_number');
        $phone->phone_number = $request->input('phone_number');
        $phone->puk_1 = $request->input('puk_1');
        $phone->puk_2 = $request->input('puk_2');
        $phone->pin_1 = $request->input('pin_1');
        $phone->pin_2 = $request->input('pin_2');
        $phone->date_assigned = $request->input('date_assigned');
        $phone->date_purchased = $request->input('date_purchased');
        $phone->additional_info = $request->input('additional_info');
        $phone->assigned_to = $request->input('user_id');
        $phone->assigned_by = Auth::user()->id;
        $phone->save();

        //Save audit trail
        $activity_type = 'Phone Creation';
        $description = 'Successfully created new phone with serial number '.$phone->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'phones'))->with('success', 'New phone details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Phone();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getPhoneById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Mobile Phone Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 3),
            'repairs' => $repair->getAssetRepairHistory($id, 3),
        ];
        return view('assets.phone.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Phone();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Phone Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getPhoneById($id),
        ];
        return view('assets.phone.edit', $pageData);
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
            'imei_number' => [
                'required',
                'string',
            ],
            'phone_number' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'puk_1' => [
                'required',
                'string',
            ],
            'puk_2' => [
                'required',
                'string',
            ],
            'pin_1' => [
                'required',
                'string',
            ],
            'pin_2' => [
                'required',
                'string',
            ],
            'date_purchased' => [
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
     
        $phone = Phone::find($id);
        $phone->name = $request->input('name');
        $phone->serial_number = $request->input('serial_number');
        $phone->imei_number = $request->input('imei_number');
        $phone->phone_number = $request->input('phone_number');
        $phone->puk_1 = $request->input('puk_1');
        $phone->puk_2 = $request->input('puk_2');
        $phone->pin_1 = $request->input('pin_1');
        $phone->pin_2 = $request->input('pin_2');
        $phone->date_assigned = $request->input('date_assigned');
        $phone->date_purchased = $request->input('date_purchased');
        $phone->additional_info = $request->input('additional_info');
        $phone->assigned_to = $request->input('user_id');
        $phone->save();

        //Save audit trail
        $activity_type = 'Phone Updation';
        $description = 'Successfully updated phone with serial number '.$phone->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'phones'))->with('success', 'Phone details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Phone::find($id)->delete();
        AssignedAsset::where(['product_id' => 3, 'asset_id' => $id])->delete();
        MaintenanceLog::where(['product_id' => 3, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Phone Deletion';
        $description = 'Successfully deleted mobile phone details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'phones'))->with('success', 'Mobile phone data deleted successfully');
    }
}