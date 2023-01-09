<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\CustomerCampaign;
use App\Models\Message;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

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
        Customer::where('campaign_id', $id)->delete();
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

    public function addBranchCustomer()
    {
        //return Profile::getProfileByUserId(Auth::user()->id);
        $pageData = [
            'page_name' => 'customers',
            'title' => 'Add New Branch Customer',
            'campaigns' => CustomerCampaign::getCampaigns(),
            'user' => Profile::getProfileByUserId(Auth::user()->id),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('admin.customers.add_branch_customer', $pageData);
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
        $systemMessage = 'thank you for contacting BIMAS concerning our products and services. Our officer at '.$outpost->outpost_name.'-'.$outpost->office_number.' will get in touch with you concerning your issue. In case your issue is not resolved, you can contact our customer care line on 0110408032. For self service dial *645*300#. BIMAS';
        $message = new Message();
        $messageBody = $message->getGreetings(strtoupper($customer->customer_name)).', '.$systemMessage;
        $mobileNo = '2547'.substr(trim( $customer->customer_phone), 2);
    
        //$message->sendSms($mobileNo, $messageBody);
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
        $message->sendSms('254703539208', $systemMessage);

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

        $emailSubject = 'New Customer Ticket for '.strtoupper($customer->customer_name).'-'.$customer->customer_phone. ' raised on Staffportal';
        $emailMessage = $customer->customer_message;
        $customerCareEmail = 'customercare@bimaskenya.com';
        $ictSupportEmail = 'ictsupport@bimaskenya.com';
        $sendEmail = new Message();
        $sendEmail->SendSystemEmail('Customer Care', $customerCareEmail, $emailMessage, $emailSubject);
        $sendEmail->SendSystemEmail('ICT Support Care', $ictSupportEmail, $emailMessage, $emailSubject);

         if(Auth::user()->hasRole('admin|communication'))
         return redirect(route('customers.campaigns.show', $customer->campaign_id))->with('success', 'Successfully created new customer issue for '.$customer->customer_name. '. Notifications sent to customer and relevant officer');
        return redirect(route('customers.branch_customers'))->with('success', 'Successfully created new customer issue for '.$customer->customer_name. '. Notifications sent to customer and relevant officer');
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
        $description = 'Successfully updated response message customer issue for '. $customer->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created updated response message');
    }

    public function saveAdminMessage(Request $request, $id)
    {
        //return $request;
        $request->validate([
            'admin_message' => [
                'required',
            ],
        ]);

        //return $request;
        $customer = Customer::find($id);
        $customer->admin_message = $request->input('admin_message');
        $customer->issue_sorted = $request->input('issue_sorted');
        $customer->save();

        //Save audit trail
        $activity_type = 'Admin Response Message';
        $description = 'Successfully updated response message customer issue for '. $customer->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created updated response message');
    }

    public function branchCustomers()
    {
        $user = User::getUserById(Auth::user()->id);
        $branch = Admin::getBranchById($user->branch_id);
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Branch Customers : '.$branch->branch_name,
            'customers' => Customer::getCustomersByBranch($user->branch_id)
        ];
        return view('admin.customers.branch_customers', $pageData);
    }

    ## Beginning of API methods
    public function loans()
    {
        $data = [];
        try{
            $remote_url = env('WEBSITE_URL');
            $client =  new Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false )));
            //$client = new Client(); 

            $user = User::getUserById(Auth::user()->id);
            $url = Auth::user()->hasRole('admin|communication')
            ? $remote_url."api/customers/v1/get-loans/" 
            : $remote_url."api/customers/v1/get-branch-loans/{$user->branch_id}";
            
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());

            $data = $responseBody;
        } catch (\Throwable $e){
            file_put_contents("log.txt", $e . " \n", FILE_APPEND);
        }
        
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Website Applied Loans',
            'loans' => $data,
        ];
        return view('admin.customers.loans', $pageData);
    }

    public function showLoan($id)
    {
        $data = [];
        try{
            $remote_url = env('WEBSITE_URL');
            $client = new Client(); 

            $url = $remote_url."api/customers/v1/get-loans/{$id}";
            
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());

            $data = $responseBody[0];
        } catch (\Throwable $e){
            file_put_contents("log.txt", $e . " \n", FILE_APPEND);
        }
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Loan Details',
            'loan' => $data,
        ];
        return view('admin.customers.loan', $pageData);
      
    }

    public function approveLoan(Request $request, $id)
    {
        try {
                $remote_url = 'https://www.bimaskenya.com/';
                //$client = new Client(); 
                $client =  new Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
                $url = $remote_url."api/customers/v1/approve-loan/{$id}";
                
                $response = $client->request('PUT', $url);

                $response = $client->put(
                    $url,
                    [
                        RequestOptions::ALLOW_REDIRECTS => [
                            'max' => 5,
                            'track_redirects' => true,
                        ],
                        RequestOptions::FORM_PARAMS => $request->all(),
                    ]
                );
                $statusCode = $response->getStatusCode(); // 200
           } 
        catch (\Throwable $th) {
              throw $th;
              file_put_contents("log.txt", $th . " \n", FILE_APPEND);
              return back()->with('warning', 'There was an error while trying to approve the request : '.$th);
        }

         //Save audit trail
         $activity_type = 'Online Loan Approval';
         $description = 'Successfully approved online loan with ID '. $id;
         User::saveAuditTrail($activity_type, $description);
            
        return back()->with('success', 'Loan approved successfully with status code : '.$statusCode);
    }

    public function commentLoan(Request $request, $id)
    {
        $request->validate([
            'commented_by' => [
                'required',
            ],
            'officer_comment' => [
                'required',
            ],
        ]);
        
        try {
            $remote_url = 'https://www.bimaskenya.com/';
            //$client = new Client(); 
            $client =  new Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
            $url = $remote_url."api/customers/v1/comment-loan/{$id}";
            
            $response = $client->request('PUT', $url);

            $response = $client->put(
                $url,
                [
                    RequestOptions::ALLOW_REDIRECTS => [
                        'max' => 5,
                        'track_redirects' => true,
                    ],
                    RequestOptions::FORM_PARAMS => $request->all(),
                ]
            );
            $statusCode = $response->getStatusCode(); // 200
       } 
    catch (\Throwable $th) {
          throw $th;
          file_put_contents("log.txt", $th . " \n", FILE_APPEND);
          return back()->with('warning', 'There was an error while trying to submit your comment : '.$th);
       }

        //Save audit trail
        $activity_type = 'Online Loan Commenting';
        $description = 'Successfully commented on online loan with ID '. $id;
        User::saveAuditTrail($activity_type, $description);
        
       return back()->with('success', 'Comment submitted successfully with status code : '.$statusCode);
    }

    public function contacts()
    {
        $data = [];
        try{
            $remote_url = env('WEBSITE_URL');
            $client = new Client(); 

            $url = $remote_url."api/customers/v1/get-contacts/";
            
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());

            $data = $responseBody;
        } catch (\Throwable $e){
            file_put_contents("log.txt", $e . " \n", FILE_APPEND);
        }

      //  return $data;
      
        $pageData = [
			'page_name' => 'customers',
            'title' => 'Website Contacts',
            'contacts' => $data,
        ];
        return view('admin.customers.contacts', $pageData);
    }


    

   
}