<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $license = new DrivingLicense();
        //return $license->getAssetlicenses();
        $pageData = [
            'page_name' => 'assets',
            'title' => 'Assets licenses',
            'licenses' => $license->getLicenses(),
        ];
        return view('assets.licenses', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'issuance_date' => [
                'required',
                'string',
            ],
            'expiry_date' => [
                'required',
                'string',
            ],
            'license_no' => [
                'required',
                'string',
                Rule::unique(DrivingLicense::class),
            ],

        ]);
        //return $request;
        $license = new DrivingLicense();
        $license->user_id = $request->input('user_id');
        $license->asset_id = $request->input('asset_id');
        $license->license_no = $request->input('license_no');
        $license->issuance_date = $request->input('issuance_date');
        $license->expiry_date = $request->input('expiry_date');
        $license->action_by = Auth::user()->id;
        $license->save();

        //Save audit trail
        $activity_type = 'Driving License Creation';
        $description = 'Created new license data for the asset id '.$license->asset_id .' expiration date '.$license->expiry_date;
        User::saveAuditTrail($activity_type, $description);

       // return redirect(route('admin.licenses.index'))->with('success', 'Asset license data for the selected item successfully saved');
        return back()->with('success', 'Asset license data for the selected item successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'issuance_date' => [
                'required',
                'string',
            ],
            'expiry_date' => [
                'required',
                'string',
            ],
            'license_no' => [
                'required',
                'string',
            ],

        ]);
        //return $request;
        $license = DrivingLicense::find($id);
        $license->license_no = $request->input('license_no');
        $license->issuance_date = $request->input('issuance_date');
        $license->expiry_date = $request->input('expiry_date');
        $license->action_by = Auth::user()->id;
        $license->save();

        //Save audit trail
        $activity_type = 'Driving License Updation';
        $description = 'Updated license data for the asset id '.$license->asset_id .' expiration date '.$license->expiry_date;
        User::saveAuditTrail($activity_type, $description);

       // return redirect(route('admin.licenses.index'))->with('success', 'Asset license data for the selected item successfully saved');
        return back()->with('success', 'Asset license data for the selected item successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DrivingLicense::find($id)->delete();

        //Save audit trail
        $activity_type = 'License Data Deletion';
        $description = 'Successfully deleted asset license data ';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Asset license data successfully deleted');
    }
}