<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\CustomerCampaign;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'campaigns' => CustomerCampaign::getCampaigns(),
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
        $campaign = CustomerCampaign::find($id);
        $pageData = [
			'page_name' => 'customers',
            'title' => $campaign->campaign_name,
            'campaign' => $campaign,
            'campaigns' => Customer::getCustomers(),
            'customers' => Customer::getCustomersByCampaign($id)
        ];
        return view('admin.customers.show', $pageData);
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

    public function addCustomer($campaign)
    {
        $pageData = [
            'campaign' => $campaign,
			'page_name' => 'customers',
            'title' => 'Add New Customer',
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('admin.customers.add_customer', $pageData);
    }

    public function saveCustomer(Request $request)
    {
        //return $request;
        $request->validate([
            'campaign_id' => [
                'required',
                'integer',
            ],
            'mobile_no' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'customer_name' => [
                'required',
            ],
            'residence' => [
                'required',
            ],
            'business' => [
                'required',
            ],
            'branch' => ['required'],
            'outpost_id' => ['required'],
            'user_id' => ['required'],
        ]);

        //return $request;
        $customer = new Customer();
        $customer->campaign_id = $request->input('campaign_id');
        $customer->customer_phone = $request->input('mobile_no');
        $customer->customer_name = $request->input('customer_name');
        $customer->residence = $request->input('residence');
        $customer->business = $request->input('business');
        $customer->customer_message = $request->input('message');
        $customer->branch_id = $request->input('branch');
        $customer->outpost_id = $request->input('outpost_id');
        $customer->officer_id = $request->input('user_id');
        $customer->created_by = Auth::user()->id;
        $customer->save();

        //Save audit trail
        $activity_type = 'Customer Issue Creation';
        $description = 'Successfully created new customer issue for '. $customer->customer_name;
        User::saveAuditTrail($activity_type, $description);

        //Send sms notification to the customer
        $outpost = Admin::getOutpostById($customer->outpost_id);
        $systemMessage = 'thank you for contacting BIMAS concerning our products and services. For assistance you can contact our officer at '.$outpost->outpost_name.' branch office on '.$outpost->office_number.'. For self service dial *645*300#. BIMAS';
        $message = new Message();
        $messageBody = $message->getGreetings(strtoupper($customer->customer_name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim( $customer->customer_phone), 2);
    
        //$message->sendSms($mobileNo, $systemMessage);
        $message->sendSms('254703539208', $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'sms_customer'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $customer->customer_name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        
        //Send sms notification to the officer
        $user = User::getUserById($customer->officer_id);
        $systemMessage = 'you have a new client issue ticket for '.strtoupper($customer->customer_name).' generated at the Staffportal. Login at the portal to view details. For assistance contact Communication Dpt';
        $message = new Message();
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
    
        //$message->sendSms($mobileNo, $systemMessage);
        $message->sendSms('254703539208', $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'sms_officer'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Send sms notification to the user
        $user = User::getUserById(Auth::user()->id);
        $systemMessage = 'you have successfully registered new client issue ticket for '.strtoupper($customer->customer_name).' for '.$outpost->outpost_name. ' branch';
        $messageBody = $message->getGreetings(strtoupper($user->name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
    
        $message->sendSms($mobileNo, $messageBody);

        $message->message_status = 'sent'; 
        $message->message_type = 'sms_user'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        return redirect(route('customers.campaigns.show', $customer->campaign_id))->with('success', 'Successfully created new customer issue for '.$customer->customer_name. '. Notifications sent to customer and relevant officer');
    }
    
    public function editCustomer($id)
    {
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Edit Customer Issue',
            'customer' => Customer::getCustomerById($id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('admin.customers.edit_customer', $pageData);
    }

    public function updateCustomer(Request $request, $id)
    {
        //return $request;
        $request->validate([
            'mobile_no' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'customer_name' => [
                'required',
            ],
            'residence' => [
                'required',
            ],
            'business' => [
                'required',
            ],
            'branch' => ['required'],
            'outpost_id' => ['required'],
            'user_id' => ['required'],
        ]);

        //return $request;
        $customer = Customer::find($id);
        $customer->customer_phone = $request->input('mobile_no');
        $customer->customer_name = $request->input('customer_name');
        $customer->residence = $request->input('residence');
        $customer->business = $request->input('business');
        $customer->customer_message = $request->input('message');
        $customer->branch_id = $request->input('branch');
        $customer->outpost_id = $request->input('outpost_id');
        $customer->officer_id = $request->input('user_id');
        $customer->save();

        //Save audit trail
        $activity_type = 'Customer Issue Updation';
        $description = 'Successfully updated customer issue for'. $customer->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('customers.campaigns.show', $customer->campaign_id))->with('success', 'Successfully created new customer issue for '.$customer->customer_name. '. Notifications sent to customer and relevant officer');
    }

    public function deleteCustomer($id)
    {
        Customer::find($id)->delete();

        //Save audit trail
        $activity_type = 'Customer Issue Deletion';
        $description = 'Deleted Customer Issue successfully';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Customer Issue successfully');
    }

    public function showCustomer($id)
    {
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Customer Issue Details',
            'customer' => Customer::getCustomerById($id),
        ];
        return view('admin.customers.show_customer', $pageData);
    }

    public function saveOfficerMessage(Request $request, $id)
    {
        //return $request;
        $request->validate([
            'officer_message' => [
                'required',
            ],
        ]);

        //return $request;
        $customer = Customer::find($id);
        $customer->officer_message = $request->input('officer_message');
        $customer->responder_id = Auth::user()->id;
        $customer->save();

        //Save audit trail
        $activity_type = 'Officer Response Message';
        $description = 'Successfully updated response message customer issue for'. $customer->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created updated response message');
    }

   
}