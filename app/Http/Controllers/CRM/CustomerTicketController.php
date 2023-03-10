<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\CRMCustomer;
use App\Models\CRM\CustomerTicket;
use App\Models\CRM\TicketCategory;
use App\Models\CRM\TicketSource;
use App\Models\CRM\TicketWorkflow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class CustomerTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'crm',
			'page_title' => 'crm',
            'title' => 'Customer Tickets',
            'tickets' => CustomerTicket::getCustomerTickets(),
        ];
        return view('crm.ticket.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
            'page_name' => 'crm',
            'title' => 'Add New Customer Ticket',
            'sources' => TicketSource::getSources(),
            'categories' => TicketCategory::getCategories(),
            'workflows' => TicketWorkflow::getCRMWorkflows(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('crm.ticket.create', $pageData);
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
            'customer_phone' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10',
            ],
            'customer_name' => [
                'required',
                'string'
            ],
            'residence' => [
                'required',
            ],
            'business' => [
                'required',
            ],
            'date_raised' => [
                'required',
                'date'
            ],
            'message' => [
                'required',
                'string'
            ],
            'branch' => 'integer|required',
            'outpost_id' => 'integer|required',
            'user_id' => 'integer|required',
            'source' => 'integer|required',
            'category' => 'integer|required',
            'workflow_id' => 'integer|required',
            'workflow_user_id' => 'integer|required',
        ]);

        $bimas_br_id = null;
        $customer_name = $request->customer_name;
        $customer_phone = $request->customer_phone; 
        $residence = $request->residence; 
        $business = $request->business;
        $branch = $request->branch;
        $outpost = $request->outpost_id;

        //$workflow_id = $request->workflow_id;
        $workflow_user_id = $request->workflow_user_id;
        $date_raised = $request->date_raised;
        $category = $request->category;
        $user_id = $request->user_id;
        $message = $request->message;
        $source = $request->source;

        $clientData = CRMCustomer::getClientByMobileNumber($customer_phone);
        if($clientData) $bimas_br_id = $clientData->bimas_br_id;
        
        //Register and get details of registered client
        $customerData = $this->getRegisteredCustomerDetails($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id);

        // Create new ticket for the client
        $ticket = new CustomerTicket();
        $ticket->message = $message;
        $ticket->officer_id = $user_id;
        $ticket->source_id = $source;
        $ticket->category_id = $category;
        $ticket->date_raised = $date_raised;
        $ticket->created_by = Auth::user()->id;
        $ticket->ticket_uuid = $this->generateTicketID();
        $ticket->customer_id = $customerData->customer_id;
        $ticket->save();

        //Register ticket to the workflow
        $workflow = new TicketWorkflow();
        $workflow->is_current = 1;
        $workflow->ticket_id = $ticket->ticket_id;
        $workflow->workflow_id = $workflow_user_id;
        $workflow->save();

        //Save audit trail
        $activity_type = 'Customer Ticket Creation';
        $description = 'Successfully created new customer ticket '.$ticket->ticket_uuid.' for '. $customerData->customer_name;
        User::saveAuditTrail($activity_type, $description);


        //SMS Notification sending

        //Send email to outpost email

        return redirect(route('crm.tickets.index'))->with('success', 'Successfully created new customer customer for '.$customerData->customer_name. '. Notifications sent to customer and relevant officer');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function generateTicketID(): string
    {
        $bytes = random_bytes(8);
        $base64 = base64_encode($bytes);

        return rtrim(strtr($base64, '+/', '-_'), '=');
    }

    public function fetchWorkflowUsers(Request $request)
    {
        $workflow_id =  $request->input('workflow');
        $workflows = TicketWorkflow::getWorkFlowUsers($workflow_id);
        $output = '<option value="">- Select Workflow User -</option>'; 
        foreach($workflows as $row)
        {
          $output .= '<option value="'.$row->workflow_user_id.'">'.$row->workflow_user_name.'</option>';
        }
        return $output; 
    }

    private function getRegisteredCustomerDetails($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id)
    {
        $customer = CRMCustomer::getCustomerByMobileNumber($customer_phone);
        if ($customer) return $customer;

        return $this->registerCustomer($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id);
    }

    private function registerCustomer($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id)
    {
        $customer = new CRMCustomer();
        $customer->customer_phone = $customer_phone;
        $customer->customer_name = $customer_name;
        $customer->created_by = Auth::user()->id;
        $customer->bimas_br_id = $bimas_br_id;
        $customer->residence = $residence;
        $customer->business = $business;
        $customer->branch_id = $branch;
        $customer->outpost_id = $outpost;
        $customer->save();
        return $customer;
    }
}
