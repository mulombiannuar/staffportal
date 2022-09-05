<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\InsurancePolicy;
use App\Models\Message;
use App\Models\User;
use App\Rules\ExpiryDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'insurance',
            'title' => 'Insurance Policies',
            'branches' => Admin::getBranches(),
            'products' => InsurancePolicy::getInsuranceProducts(),
            'companies' => InsurancePolicy::getInsuranceCompanies(),
            'policies' => InsurancePolicy::getInsurancePolicies(),
        ];
        return view('admin.insurance.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'insurance',
            'title' => 'Create Insurance Policy',
            'branches' => Admin::getBranches(),
            'products' => InsurancePolicy::getInsuranceProducts(),
            'companies' => InsurancePolicy::getInsuranceCompanies(),
        ];
        return view('admin.insurance.create', $pageData);
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
            'reference' => [
                'required',
                'string',
                Rule::unique(InsurancePolicy::class),
            ],
            'product' => [
                'required',
                'integer',
            ],
            'company' => [
                'required',
                'integer',
            ],
            'client_name' => [
                'required',
                'string',
            ],
            'client_phone' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
                Rule::unique(InsurancePolicy::class),
            ],
            'client_kra' => [
                'required',
                'string',
            ],
            'client_id' => [
                'required',
                'string',
            ],
            'sum_issued' => [
                'required',
                'string',
            ],
            'premium' => [
                'required',
                'string',
            ],
            'date_issued' => [
                'required',
                'string',
            ],
            'date_expired' => [
                'required',
                'string',
                new ExpiryDate($request->input('date_issued'))
            ],

        ]);
        //return $request;
        $insurance = new InsurancePolicy();
        $insurance->outpost = $request->input('outpost_id');
        $insurance->product = $request->input('product');
        $insurance->company = $request->input('company');
        $insurance->officer = $request->input('user_id');
        $insurance->client_name = $request->input('client_name');
        $insurance->client_phone = $request->input('client_phone');
        $insurance->client_id = $request->input('client_id');
        $insurance->client_kra = $request->input('client_kra');
        $insurance->sum_issued = $request->input('sum_issued');
        $insurance->premium = $request->input('premium');
        $insurance->reference = $request->input('reference');
        $insurance->date_issued = $request->input('date_issued');
        $insurance->date_expired = $request->input('date_expired');
        $insurance->cheque_no = $request->input('cheque_no');
        $insurance->policy_no = $this->generatePolicyNumber($insurance->product);
        $insurance->created_by = Auth::user()->id;
        $insurance->status = 1;
        $insurance->save();

        //Save audit trail
        $activity_type = 'Insurance Policy Creation';
        $description = 'Successfully created new insurance policy no '.$insurance->policy_no;
        User::saveAuditTrail($activity_type, $description);

        //Send notification to client
        $message = new Message();
        $systemMessage = ' insurance policy number '.$insurance->policy_no.' has been succesfully lodged in Bimas Kenya Ltd and will be expiring on '.$insurance->date_expired.'. For assistance, contact 0723209040';
        $messageBody = $message->getGreetings(strtoupper($insurance->client_name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($insurance->client_phone), 2);
    
        //$message->sendSms($mobileNo, $messageBody);
        //$message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'policy_creation_client'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $insurance->client_name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Send notification to Admin
        $user = User::getUserById(Auth::user()->id);
        $message = new Message();
        $systemMessage = ' insurance policy number '.$insurance->policy_no.' has been succesfully lodged in Bimas Kenya Ltd and will be expiring on '.$insurance->date_expired;
        $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
    
        //$message->sendSms($mobileNo, $systemMessage);
        //$message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'policy_creation_admin'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();
        return back()->with('success', 'New Insurance policy data saved successfully');
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
			'page_name' => 'insurance',
            'title' => 'Show Insurance Policy',
            'policy' => InsurancePolicy::getInsurancePolicyById($id),
        ];
        return view('admin.insurance.show', $pageData);
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
			'page_name' => 'insurance',
            'title' => 'Edit Insurance Policy',
            'branches' => Admin::getBranches(),
            'products' => InsurancePolicy::getInsuranceProducts(),
            'companies' => InsurancePolicy::getInsuranceCompanies(),
            'policy' => InsurancePolicy::getInsurancePolicyById($id),
        ];
        return view('admin.insurance.edit', $pageData);
    }

    public function renewPolicy($id)
    {
        $pageData = [
			'page_name' => 'insurance',
            'title' => 'Renew Insurance Policy',
            'branches' => Admin::getBranches(),
            'products' => InsurancePolicy::getInsuranceProducts(),
            'companies' => InsurancePolicy::getInsuranceCompanies(),
            'policy' => InsurancePolicy::getInsurancePolicyById($id),
        ];
        return view('admin.insurance.renew', $pageData);
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
            'reference' => [
                'required',
                'string',
            ],
            'product' => [
                'required',
                'integer',
            ],
            'company' => [
                'required',
                'integer',
            ],
            'client_name' => [
                'required',
                'string',
            ],
            'client_phone' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'client_kra' => [
                'required',
                'string',
            ],
            'client_id' => [
                'required',
                'string',
            ],
            'sum_issued' => [
                'required',
                'string',
            ],
            'premium' => [
                'required',
                'string',
            ],
            'date_issued' => [
                'required',
                'string',
            ],
            'date_expired' => [
                'required',
                'string',
                new ExpiryDate($request->input('date_issued'))
            ],

        ]);
        //return $request;
        $insurance = InsurancePolicy::find($id);
        $insurance->outpost = $request->input('outpost_id');
        $insurance->product = $request->input('product');
        $insurance->company = $request->input('company');
        $insurance->officer = $request->input('user_id');
        $insurance->client_name = $request->input('client_name');
        $insurance->client_phone = $request->input('client_phone');
        $insurance->client_id = $request->input('client_id');
        $insurance->client_kra = $request->input('client_kra');
        $insurance->sum_issued = $request->input('sum_issued');
        $insurance->premium = $request->input('premium');
        $insurance->reference = $request->input('reference');
        $insurance->date_issued = $request->input('date_issued');
        $insurance->date_expired = $request->input('date_expired');
        $insurance->cheque_no = $request->input('cheque_no');
        $insurance->save();

        //Save audit trail
        $activity_type = 'Insurance Policy Updation';
        $description = 'Successfully updated insurance policy no '.$insurance->policy_no;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Insurance policy data saved successfully');
    }

    public function renew(Request $request, $id)
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
            'reference' => [
                'required',
                'string',
            ],
            'product' => [
                'required',
                'integer',
            ],
            'company' => [
                'required',
                'integer',
            ],
            'client_name' => [
                'required',
                'string',
            ],
            'client_phone' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'client_kra' => [
                'required',
                'string',
            ],
            'client_id' => [
                'required',
                'string',
            ],
            'sum_issued' => [
                'required',
                'string',
            ],
            'premium' => [
                'required',
                'string',
            ],
            'date_issued' => [
                'required',
                'string',
            ],
            'date_expired' => [
                'required',
                'string',
                new ExpiryDate($request->input('date_issued'))
            ],

        ]);
        //return $request;
        $insurance = InsurancePolicy::find($id);
        $insurance->outpost = $request->input('outpost_id');
        $insurance->product = $request->input('product');
        $insurance->company = $request->input('company');
        $insurance->officer = $request->input('user_id');
        $insurance->client_name = $request->input('client_name');
        $insurance->client_phone = $request->input('client_phone');
        $insurance->client_id = $request->input('client_id');
        $insurance->client_kra = $request->input('client_kra');
        $insurance->sum_issued = $request->input('sum_issued');
        $insurance->premium = $request->input('premium');
        $insurance->reference = $request->input('reference');
        $insurance->date_issued = $request->input('date_issued');
        $insurance->date_expired = $request->input('date_expired');
        $insurance->cheque_no = $request->input('cheque_no');
        $insurance->status = 1;
        $insurance->save();

        //Save audit trail
        $activity_type = 'Insurance Policy Renewal';
        $description = 'Successfully renewed insurance policy no '.$insurance->policy_no;
        User::saveAuditTrail($activity_type, $description);

        //Send notification to client
        $message = new Message();
        $systemMessage = ' insurance policy number '.$insurance->policy_no.' has been succesfully renewed in Bimas Kenya Ltd and will be expiring on '.$insurance->date_expired.'. For assistance, contact 0723209040';
        $messageBody = $message->getGreetings(strtoupper($insurance->client_name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($insurance->client_phone), 2);
    
        //$message->sendSms($mobileNo, $systemMessage);
        //$message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'policy_renewal_client'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $insurance->client_name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        //Send notification to Admin
        $user = User::getUserById(Auth::user()->id);
        $message = new Message();
        $systemMessage = ' insurance policy number '.$insurance->policy_no.' has been succesfully renewed in Bimas Kenya Ltd and will be expiring on '.$insurance->date_expired;
        $messageBody = $message->getGreetings(strtoupper($user->name)).' '.$systemMessage;
        $mobileNo = '2547'.substr(trim($user->mobile_no), 2);
    
        //$message->sendSms($mobileNo, $systemMessage);
        //$message->sendSms('254703539208', $systemMessage);

        $message->message_status = 'sent'; 
        $message->message_type = 'policy_renewal_admin'; 
        $message->recipient_no = $mobileNo; 
        $message->recipient_name = $user->name; 
        $message->logged_date =  date('D, d M Y H:i:s'); 
        $message->message_body = $messageBody;
        $message->save();

        return redirect(route('admin.insurances.index'))->with('success', 'Insurance policy data renewed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $policy = InsurancePolicy::find($id);

        //Save audit trail
        $activity_type = 'Insurance Policy Deletion';
        $description = 'Successfully deleted insurance policy no '.$policy->policy_no;
        User::saveAuditTrail($activity_type, $description);

        $policy->delete();
        return back()->with('success', 'Insurance policy data deleted successfully');
    }

    public function insuranceReport(Request $request)
    {
        $request->validate([
            'date_issued' => [
                'required', 
                'string', 
            ],
            'date_expired' => [
                'required',
                'string',
            ],
            'report_type' => [
                'required',
                'string',
            ],
        ]);

        $date_issued = $request->input('date_issued');
        $date_expired = $request->input('date_expired');
        $report_type = $request->input('report_type');

        $pageData = [
			'page_name' => 'insurance',
            'title' => 'Insurance Policies',
            'date' => ['date_issued' => $date_issued, 'date_expired' => $date_expired],
            'policies' => InsurancePolicy::getInsurancePoliciesReport($date_issued, $date_expired, $report_type),
        ];
        return view('admin.insurance.report', $pageData);
    }

    public static function generatePolicyNumber($product_id)
    {
        $policy_no = '';
        $product = InsurancePolicy::getInsuranceProductById($product_id);
        $policy_no = $product->product_code.'-'.time();
        return $policy_no;
    }
}