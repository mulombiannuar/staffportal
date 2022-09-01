<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerCampaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Campaigns',
            'campaigns' => CustomerCampaign::all(),
        ];
        return view('admin.customers.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Add New Campaign',
        ];
        return view('admin.customers.create', $pageData);
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
            'campaign_name' => [
                'required',
                 Rule::unique(CustomerCampaign::class),
            ],
            'start_date' => [
                'required',
            ],
            'end_date' => [
                'required',
            ],
            'target_areas' => [
                'required',
            ],
            'target_products' => [
                'required',
            ],
        ]);

        //return $request;
          
        //return $request;
        $campaign = new CustomerCampaign();
        $campaign->campaign_name = $request->input('campaign_name');
        $campaign->start_date = $request->input('start_date');
        $campaign->end_date = $request->input('end_date');
        $campaign->target_areas = $request->input('target_areas');
        $campaign->target_products = $request->input('target_products');
        $campaign->created_by = Auth::user()->id;
        $campaign->save();

        //Save audit trail
        $activity_type = 'Customer Campaign Creation';
        $description = 'Successfully created new customer campaign '. $campaign->campaign_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created new customer campaign '.$campaign->campaign_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Campaign Details',
            'campaign' => CustomerCampaign::find($id)
        ];
        return view('admin.customers.edit', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Edit Campaign',
            'campaign' => CustomerCampaign::find($id)
        ];
        return view('admin.customers.edit', $pageData);
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
            'campaign_name' => [
                'required',
            ],
            'start_date' => [
                'required',
            ],
            'end_date' => [
                'required',
            ],
            'target_areas' => [
                'required',
            ],
            'target_products' => [
                'required',
            ],
        ]);

        //return $request;
         $campaign = CustomerCampaign::find($id);
         $campaign->campaign_name = $request->input('campaign_name');
         $campaign->start_date = $request->input('start_date');
         $campaign->end_date = $request->input('end_date');
         $campaign->target_areas = $request->input('target_areas');
         $campaign->target_products = $request->input('target_products');
         $campaign->save();
 
         //Save audit trail
         $activity_type = 'Customer Campaign Updation';
         $description = 'Successfully updated customer campaign '. $campaign->campaign_name;
         User::saveAuditTrail($activity_type, $description);
 
         return back()->with('success', 'Successfully updated customer campaign '.$campaign->campaign_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomerCampaign::find($id)->delete();

        //Save audit trail
        $activity_type = 'Customer Campaign Deletion';
        $description = 'Deleted Customer Campaign successfully';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Customer Campaign successfully');
    }
}