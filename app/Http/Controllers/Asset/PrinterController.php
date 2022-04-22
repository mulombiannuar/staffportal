<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\Products\Printer;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PrinterController extends Controller
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
            'title' => 'Add New Printer',
            'branches' => Admin::getBranches()
        ];
        return view('assets.printer.create', $pageData);
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
                Rule::unique(Printer::class),
            ],
            'supplier' => [
                'required',
                'string',
            ],
            'ip_address' => [
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
        $user_exists = Printer::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');

        $printer = new Printer();
        $printer->product_id = 6;
        $printer->name = $request->input('name');
        $printer->serial_number = $request->input('serial_number');
        $printer->ip_address = $request->input('ip_address');
        $printer->supplier = $request->input('supplier');
        $printer->date_assigned = $request->input('date_assigned');
        $printer->date_purchased = $request->input('date_purchased');
        $printer->additional_info = $request->input('additional_info');
        $printer->assigned_to = $request->input('user_id');
        $printer->assigned_by = Auth::user()->id;
        $printer->save();

        //Save audit trail
        $activity_type = 'Printer Creation';
        $description = 'Successfully created new printer with serial number '.$printer->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'printers'))->with('success', 'New printer details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Printer();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getPrinterById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Printer Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 6),
            'repairs' => $repair->getAssetRepairHistory($id, 6),
        ];
        return view('assets.printer.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Printer();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Printer Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getPrinterById($id),
        ];
        return view('assets.printer.edit', $pageData);
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
            'ip_address' => [
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
        $printer = Printer::find($id);
        $printer->name = $request->input('name');
        $printer->serial_number = $request->input('serial_number');
        $printer->ip_address = $request->input('ip_address');
        $printer->supplier = $request->input('supplier');
        $printer->date_assigned = $request->input('date_assigned');
        $printer->date_purchased = $request->input('date_purchased');
        $printer->additional_info = $request->input('additional_info');
        $printer->assigned_to = $request->input('user_id');
        $printer->save();

        //Save audit trail
        $activity_type = 'Printer Updation';
        $description = 'Successfully updated printer with serial number '.$printer->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'printers'))->with('success', 'Printer details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Printer::find($id)->delete();
        AssignedAsset::where(['product_id' => 6, 'asset_id' => $id])->delete();
        Repair::where(['product_id' => 6, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Printer Deletion';
        $description = 'Successfully deleted printer details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'printers'))->with('success', 'Printer data deleted successfully');
    }
}