<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\Products\Scanner;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ScannerController extends Controller
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
            'title' => 'Add New Scanner',
            'branches' => Admin::getBranches()
        ];
        return view('assets.scanner.create', $pageData);
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
                Rule::unique(Scanner::class),
            ],
            'supplier' => [
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
        $user_exists = Scanner::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');

        $scanner = new Scanner();
        $scanner->product_id = 8;
        $scanner->name = $request->input('name');
        $scanner->serial_number = $request->input('serial_number');
        $scanner->supplier = $request->input('supplier');
        $scanner->date_assigned = $request->input('date_assigned');
        $scanner->date_purchased = $request->input('date_purchased');
        $scanner->additional_info = $request->input('additional_info');
        $scanner->assigned_to = $request->input('user_id');
        $scanner->assigned_by = Auth::user()->id;
        $scanner->save();

        //Save audit trail
        $activity_type = 'Scanner Creation';
        $description = 'Successfully created new scanner with serial number '.$scanner->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'scanners'))->with('success', 'New scanner details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Scanner();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getScannerById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Scanner Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 8),
            'repairs' => $repair->getAssetRepairHistory($id, 8),
        ];
        return view('assets.scanner.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Scanner();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Scanner Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getScannerById($id),
        ];
        return view('assets.scanner.edit', $pageData);
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
        $scanner = Scanner::find($id);
        $scanner->product_id = 6;
        $scanner->name = $request->input('name');
        $scanner->serial_number = $request->input('serial_number');
        $scanner->supplier = $request->input('supplier');
        $scanner->date_assigned = $request->input('date_assigned');
        $scanner->date_purchased = $request->input('date_purchased');
        $scanner->additional_info = $request->input('additional_info');
        $scanner->assigned_to = $request->input('user_id');
        $scanner->save();

        //Save audit trail
        $activity_type = 'Scanner Updation';
        $description = 'Successfully updated scanner with serial number '.$scanner->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'scanners'))->with('success', 'Scanner details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Scanner::find($id)->delete();
        AssignedAsset::where(['product_id' => 8, 'asset_id' => $id])->delete();
        Repair::where(['product_id' => 8, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Scanner Deletion';
        $description = 'Successfully deleted scanner details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'scanners'))->with('success', 'Scanner data deleted successfully');
    }
}