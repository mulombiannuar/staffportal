<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AssignedAsset;
use App\Models\Products\Router;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RouterController extends Controller
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
            'title' => 'Add New Router',
            'branches' => Admin::getBranches()
        ];
        return view('assets.router.create', $pageData);
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
                Rule::unique(Router::class),
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
        $router = new Router();
        $router->product_id = 7;
        $router->name = $request->input('name');
        $router->serial_number = $request->input('serial_number');
        $router->ip_address = $request->input('ip_address');
        $router->supplier = $request->input('supplier');
        $router->location = $request->input('location');
        $router->date_assigned = $request->input('date_assigned');
        $router->date_purchased = $request->input('date_purchased');
        $router->additional_info = $request->input('additional_info');
        $router->assigned_to = $request->input('user_id');
        $router->assigned_by = Auth::user()->id;
        $router->save();

        //Save audit trail
        $activity_type = 'Router Creation';
        $description = 'Successfully created new router with serial number '.$router->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'routers'))->with('success', 'New router details saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = new Router();
        $assign = new AssignedAsset();
        $repair = new Repair();
        $details = $asset->getRouterById($id);
        $pageData = [
            'asset' => $details,
			'page_name' => 'assets',
            'title' => 'Router Details - '.ucwords($details->serial_number),
            'branches' => Admin::getBranches(),
            'assigns' => $assign->getAssetAssignedHistory($id, 7),
            'repairs' => $repair->getAssetRepairHistory($id, 7),
        ];
        return view('assets.router.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = new Router();
        $pageData = [
			'page_name' => 'assets',
            'title' => 'Edit Router Details',
            'branches' => Admin::getBranches(),
            'asset' => $asset->getRouterById($id),
        ];
        return view('assets.router.edit', $pageData);
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

        $user_id = $request->input('user_id');
        $user_exists = Router::where('assigned_to', $user_id)->first();

        if($user_exists)
        return back()->with('danger', 'This user already exists in this list assets');


        $router = Router::find($id);
        $router->name = $request->input('name');
        $router->serial_number = $request->input('serial_number');
        $router->ip_address = $request->input('ip_address');
        $router->supplier = $request->input('supplier');
        $router->location = $request->input('location');
        $router->date_assigned = $request->input('date_assigned');
        $router->date_purchased = $request->input('date_purchased');
        $router->additional_info = $request->input('additional_info');
        $router->assigned_to = $request->input('user_id');
        $router->save();

        //Save audit trail
        $activity_type = 'Router Updation';
        $description = 'Successfully updated router with serial number '.$router->serial_number;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'routers'))->with('success', 'Router details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Router::find($id)->delete();
        AssignedAsset::where(['product_id' => 7, 'asset_id' => $id])->delete();
        Repair::where(['product_id' => 7, 'asset_id' => $id])->delete();

        //Save audit trail
        $activity_type = 'Router Deletion';
        $description = 'Successfully deleted Router details ';
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.assets.show', 'routers'))->with('success', 'Router data deleted successfully');
    }
}