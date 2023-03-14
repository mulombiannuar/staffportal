<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CRM\CRMCustomer;
use App\Models\CRM\CustomerTicket;
use App\Models\CRM\TicketCategory;
use App\Models\CRM\TicketSource;
use App\Models\CRM\TicketWorkflow;
use App\Models\Message;
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
        //return CustomerTicket::getCustomerTickets();
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
        $ticket = CustomerTicket::saveCustomerTicket($message, $user_id, $source, $category, $date_raised, $customerData->customer_id);

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

        $outpost = Admin::getOutpostById($outpost);
        $ticketCategory = TicketCategory::find($category);
        $messageModel = new Message();

        //Send Customer customized sms notification
        $customer_message = $this->setCustomerMessage($outpost, $ticketCategory->message_template, $ticket->ticket_uuid);
        $messageModel->saveSystemMessage($ticketCategory->category_name, $customer_phone, $customer_name,  $customer_message, true);

        //Send sms notification to the office
        $user = User::getUserById($ticket->officer_id);
        $officer_ticket_message = 'you have a new client ticket '.$ticket->ticket_uuid.' for '.strtoupper($customer_name).' generated at the Staffportal. Login at the portal to view details. ';
        $messageModel->saveSystemMessage($ticketCategory->category_name, $user->mobile_no, $user->name,  $officer_ticket_message, true);
        
        //Send sms notification to the logged in user
        $loggedInUser = User::getUserById(Auth::user()->id);
        $loggedInUserMessage = 'you have successfully registered new client ticket '.$ticket->ticket_uuid.' for '.strtoupper($customer_name).' for '.$outpost->outpost_name. ' branch';
        $messageModel->saveSystemMessage($ticketCategory->category_name, $loggedInUser->mobile_no, $loggedInUser->name, $loggedInUserMessage, true);

        //Send email to outpost email
        $emailSubject = 'New Customer Ticket for '.strtoupper($customer_name).'-'.$customer_phone. ' raised on Staffportal';
        $emailMessage = $this->setOfficerMessage($ticket->message, $officer_ticket_message);
        $customerCareEmail = 'customercare@bimaskenya.com';
        $branchEmail = $outpost->outpost_email;
        $messageModel->SendSystemEmail($user->name, $branchEmail, $emailMessage, $emailSubject);
        $messageModel->SendSystemEmail($user->name, $customerCareEmail, $emailMessage, $emailSubject);
        
        return redirect(route('crm.tickets.index'))->with('success', 'Successfully created new customer ticket for '.$customerData->customer_name. '. Notifications sent to customer and relevant officer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = CustomerTicket::getCustomerTicketById($id);
        $pageData = [
            'page_name' => 'crm',
            'ticket' => $ticket,
            'title' => 'Customer Ticket - '.$ticket->ticket_uuid,
        ];
        return view('crm.ticket.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return CustomerTicket::getCustomerTicketById($id);
        $ticket = CustomerTicket::getCustomerTicketById($id);
        $customer = CRMCustomer::getCustomerByMobileNumber($ticket->customer_phone);
        $pageData = [
            'page_name' => 'crm',
            'ticket' => $ticket,
            'customer' => $customer,
            'title' => 'Update Customer Ticket',
            'sources' => TicketSource::getSources(),
            'categories' => TicketCategory::getCategories(),
            'workflows' => TicketWorkflow::getCRMWorkflows(),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),
        ];
        return view('crm.ticket.edit', $pageData);
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

        $ticketData = CustomerTicket::find($id);
        
        $bimas_br_id = null;
        $customer_name = $request->customer_name;
        $customer_phone = $request->customer_phone; 
        $residence = $request->residence; 
        $business = $request->business;
        $branch = $request->branch;
        $outpost = $request->outpost_id;

        $workflow_user_id = $request->workflow_user_id;
        $date_raised = $request->date_raised;
        $category = $request->category;
        $user_id = $request->user_id;
        $message = $request->message;
        $source = $request->source;

        $clientData = CRMCustomer::getClientByMobileNumber($customer_phone);
        if($clientData) $bimas_br_id = $clientData->bimas_br_id;
        
        //Update and get details of client
        $customerData = $this->updateCustomer($ticketData->customer_id, $customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id);

        // Update ticket for the client
        $ticket = CustomerTicket::updateCustomerTicket($id, $message, $user_id, $source, $category, $date_raised);

        //Update ticket to the workflow
        $workflow = TicketWorkflow::where('ticket_id', $id)->first();
        $workflow->is_current = 1;
        $workflow->workflow_id = $workflow_user_id;
        $workflow->save();

        //Save audit trail
        $activity_type = 'Customer Ticket Updation';
        $description = 'Successfully updated customer ticket '.$ticket->ticket_uuid.' for '. $customerData->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('crm.tickets.index'))->with('success', 'Successfully updated customer ticket for '.$customerData->customer_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomerTicket::destroy($id);
        TicketWorkflow::where('ticket_id', $id)->delete();
        
        //Save audit trail
        $activity_type = 'Customer Ticket Deletion';
        $description = 'Deleted customer ticket successfully of the id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Customer Ticket Successfully');
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

    public function registerCustomer($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id)
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

    public function updateCustomer($customer_id, $customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id)
    {
        $customer = CRMCustomer::find($customer_id);
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

    private function setCustomerMessage($outpost, $message, $ticket_id)
    {
        $message = str_replace("ticket_id", $ticket_id, $message);
        $message = str_replace("branch_name", $outpost->outpost_name, $message);
        $message = str_replace("office_number", $outpost->office_number, $message);
        return $message;
    }

    private function setOfficerMessage($customer_message, $officer_ticket_message)
    {
        return ucfirst($officer_ticket_message).' Here is the content of the ticket:  '.$customer_message;
    }
}
