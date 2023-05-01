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
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
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
        //return CustomerTicket::getCustomerOverdueTickets();
        $pageData = [
            'page_name' => 'crm',
            'page_title' => 'crm',
            'title' => 'Customer Tickets',
            'tickets' => CustomerTicket::getCustomerTickets(),
            'workflows' => TicketWorkflow::getWorkFlowTickets(),
            'overdue_tickets' => CustomerTicket::getCustomerOverdueTickets(),
            'closed_tickets' => CustomerTicket::getCustomerTicketsByStatus(1),
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

        //return $request;
        //return Admin::getOutpostSupervisor($outpost);

        $workflow_id = $request->workflow_id;
        $workflow_user_id = $request->workflow_user_id;
        $date_raised = $request->date_raised;
        $category = $request->category;
        $user_id = $request->user_id;
        $message = $request->message;
        $source = $request->source;

        $clientData = CRMCustomer::getClientByMobileNumber($customer_phone);
        if ($clientData) $bimas_br_id = $clientData->bimas_br_id;

        //Register and get details of registered client
        $customerData = $this->getRegisteredCustomerDetails($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id, Auth::user()->id);

        // Create new ticket for the client
        $ticket = CustomerTicket::saveCustomerTicket($message, $user_id, $source, $category, $date_raised, $customerData->customer_id, Auth::user()->id);

        //Register ticket to the workflow
        CustomerTicket::newCustomerTicketWorkFlow(1, $ticket->ticket_id, $workflow_id, $workflow_user_id);

        //Save audit trail
        $activity_type = 'Customer Ticket Creation';
        $description = 'Successfully created new customer ticket ' . $ticket->ticket_uuid . ' for ' . $customerData->customer_name;
        User::saveAuditTrail($activity_type, $description);

        $outpost = Admin::getOutpostById($outpost);
        $ticketCategory = TicketCategory::find($category);
        $ticket_message = $this->getTicketCustomisedMessage($category);
        $messageModel = new Message();

        //Send sms notification to the officer
        $user = User::getUserById($ticket->officer_id);
        $officer_ticket_message = 'you have a new client ticket ' . $ticket->ticket_uuid . ' for ' . strtoupper($customerData->customer_name) . ' generated at the Staffportal. Login at the portal to view details. ';
        $messageModel->saveSystemMessage($ticketCategory->category_name, $user->mobile_no, $user->name,  $officer_ticket_message, true);

        // Send sms notification to the branch manager
        $branch_supervisor = Admin::getOutpostSupervisor($outpost->outpost_id);
        if (!empty($branch_supervisor)) {
            $supervisor_ticket_message = $this->setSupervisorMessage($ticket->ticket_uuid, $user);
            $messageModel->saveSystemMessage($ticketCategory->category_name, $branch_supervisor->mobile_no, $branch_supervisor->name,  $supervisor_ticket_message, true);
        }

        //Send Customer customized sms notification
        $customer_message = $this->setCustomerMessage($outpost, $ticket_message, $ticket->ticket_uuid, $user);
        $messageModel->saveSystemMessage($ticketCategory->category_name, $customerData->customer_phone, $customerData->customer_name,  $customer_message, true);

        //Send sms notification to the logged in user
        $loggedInUser = User::getUserById(Auth::user()->id);
        $loggedInUserMessage = 'you have successfully registered new client ticket ' . $ticket->ticket_uuid . ' for ' . strtoupper($customerData->customer_name) . ' for ' . $outpost->outpost_name . ' branch';
        $messageModel->saveSystemMessage($ticketCategory->category_name, $loggedInUser->mobile_no, $loggedInUser->name, $loggedInUserMessage, true);

        //Send message marketting if category is 1
        if ($category == 1) {
            $marketting_officer = CustomerTicket::markettingOfficer();
            $marketing_message = $this->setOperationAreaMessage($ticket->ticket_uuid, $customerData->customer_name);
            $messageModel->saveSystemMessage($ticketCategory->category_name,  $marketting_officer['mobile_no'], $marketting_officer['name'],  $marketing_message, true);
        }

        //Send email to outpost email
        $emailSubject = 'New Customer Ticket for ' . strtoupper($customerData->customer_name) . '-' . $customerData->customer_phone . ' raised on Staffportal';
        $emailMessage = $this->setOfficerMessage($ticket->message, $officer_ticket_message);
        $customerCareEmail = 'customercare@bimaskenya.com';
        $branchEmail = $outpost->outpost_email;
        $messageModel->SendSystemEmail($user->name, $branchEmail, $emailMessage, $emailSubject);
        $messageModel->SendSystemEmail($user->name, $customerCareEmail, $emailMessage, $emailSubject);

        return back()->with('success', 'Successfully created new customer ticket for ' . $customerData->customer_name . '. Notifications sent to customer and relevant officer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messageModel = new Message();
        $ticket = CustomerTicket::getCustomerTicketById($id);
        $customer = CRMCustomer::getCustomerByMobileNumber($ticket->customer_phone);
        // return TicketWorkflow::getUserForwadedToLevels(Auth::user()->id);

        $pageData = [
            'page_name' => 'crm',
            'page_title' => 'crm',
            'ticket' => $ticket,
            'ticketData' => $ticket,
            'customer' => $customer,
            'closed' => $ticket->ticket_closed,
            'title' => 'Customer Ticket - ' . $ticket->ticket_uuid,
            'survey_data' => CustomerTicket::getSurveyDataByTicketID($id),
            'ticket_url' => CustomerTicket::getTicketURL($ticket->ticket_uuid),
            'escalations' => CustomerTicket::getTicketEscalationWorkflowLevels($id),
            'current_workflow' => CustomerTicket::getTicketCurrentWorkflowLevel($id),
            'workflows' => TicketWorkflow::getUserForwadedToLevels(Auth::user()->id)
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
        if ($clientData) $bimas_br_id = $clientData->bimas_br_id;

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
        $description = 'Successfully updated customer ticket ' . $ticket->ticket_uuid . ' for ' . $customerData->customer_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('crm.tickets.index'))->with('success', 'Successfully updated customer ticket for ' . $customerData->customer_name);
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
        $description = 'Deleted customer ticket successfully of the id ' . $id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Customer Ticket Successfully');
    }

    public function fetchWorkflowUsers(Request $request)
    {
        $workflow_id =  $request->input('workflow');
        $workflows = TicketWorkflow::getWorkFlowUsers($workflow_id);
        $output = '<option value="">- Select Workflow User -</option>';
        foreach ($workflows as $row) {
            $output .= '<option value="' . $row->workflow_user_id . '">' . $row->workflow_user_name . '</option>';
        }
        return $output;
    }

    public function getRegisteredCustomerDetails($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id, $user_id)
    {
        $customer = CRMCustomer::getCustomerByMobileNumber($customer_phone);
        if ($customer) return $customer;

        return $this->registerCustomer($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id, $user_id);
    }

    public function registerCustomer($customer_name, $customer_phone, $residence, $business, $branch, $outpost, $bimas_br_id, $user_id)
    {
        $customer = new CRMCustomer();
        $customer->customer_phone = $customer_phone;
        $customer->customer_name = $customer_name;
        $customer->created_by = $user_id;
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

    public function setCustomerMessage($outpost, $message, $ticket_id, $user)
    {
        $message = str_replace("ticket_id", $ticket_id, $message);
        $message = str_replace("branch_name", $outpost->outpost_name, $message);
        $message = str_replace("office_number", $outpost->office_number, $message);
        $message = str_replace("officer_number", $user->mobile_no, $message);
        $message = str_replace("officer_name", $user->name, $message);
        return $message;
    }

    public function setOfficerMessage($customer_message, $officer_ticket_message)
    {
        return ucfirst($officer_ticket_message) . ' Here is the content of the ticket:  ' . $customer_message;
    }

    private function setSupervisorMessage($ticket_id, $user)
    {
        return 'a new client ticket for ' . $ticket_id . ' has been registered under your branch and assigned to ' . strtoupper($user->name) . '. Login into the Staffportal to view details. For any assistance, contact Communications Dept.';
    }

    private function setOperationAreaMessage($ticket_uuid, $customer_name)
    {
        return 'a new client ticket ID ' . $ticket_uuid . ' for ' . strtoupper($customer_name) . ' has been registered seeking assistance outside our areas of operations. Login into the Staffportal to view details. For any assistance, contact Communications Dept.';
    }

    private function setCustomerEscalationMessage($ticket_id)
    {
        return 'thank you for contacting BIMAS concerning our products and services. Your issue of ticket ID ' . $ticket_id . ' has been escalated to another agent. Please be patient while we try to resolve the matter in the best way and shortest time possible';
    }

    private function setCustomerTicketClosureMessage($ticket_id)
    {
        return 'Your issue of ticket ID ' . $ticket_id . ' has been successfully closed. Thank you for your patience. For further inquiries you can always contact our customer care line on 0701111700';
    }

    private function setOfficerEscalationMessage($ticket_id)
    {
        return 'You have ticket issue of ID ' . $ticket_id . ' forwarded to you. Login to the Staffportal to view details';
    }

    private function setOfficerOverdueReminderMessage($ticket_id, $hours, $customer_name)
    {
        return 'Your ticket of ID ' . $ticket_id . ' for ' . strtoupper($customer_name) . ' is overdue with ' . $hours . ' hours. Login to the Staffportal to view details';
    }

    public function getTicketCustomisedMessage($category)
    {
        $ticketCategory = TicketCategory::find($category);
        $message = $ticketCategory->message_template;
        return $message;
    }

    /// Normal users not admin
    public function customerTickets()
    {
        $customerTicket = new CustomerTicket();
        $user = User::getUserById(Auth::user()->id);
        //return $this->getTicketsByWorkflow('ICT Manager', $user->outpost);

        $pageData = [
            'user' =>  $user,
            'page_name' => 'crm',
            'title' => 'Customer Tickets',
            'sources' => TicketSource::getSources(),
            'categories' => TicketCategory::getCategories(),
            'workflows' => TicketWorkflow::getCRMWorkflows(),
            'outpost_users' => User::getOutpostUsers($user->outpost),
            'senior_manager' => User::hasSeniorManagerRole($user->id),
            'tickets_data' => $customerTicket->getGroupedTickets($user->outpost),
            'branches' => DB::table('branches')->orderBy('branch_name', 'asc')->get(),

            /// Tickets by workflow levels
            'creditofficer' => $this->getTicketsByWorkflow('Credit Officer', $user->outpost),
            'branchmanager' => $this->getTicketsByWorkflow('Branch Manager', $user->outpost),
            'creditsmanager' => $this->getTicketsByWorkflow('Credits Manager', $user->outpost),
            'auditmanager' => $this->getTicketsByWorkflow('Audit Manager', $user->outpost),
            'marketingmanager' => $this->getTicketsByWorkflow('Marketing Manager', $user->outpost),
            'legalmanager' => $this->getTicketsByWorkflow('Legal Manager', $user->outpost),
            'operationsmanager' => $this->getTicketsByWorkflow('Operations Manager', $user->outpost),
            'humanresourcemanager' => $this->getTicketsByWorkflow('Human Resource Manager', $user->outpost),
            'ictmanager' => $this->getTicketsByWorkflow('ICT Manager', $user->outpost),
            'financemanager' => $this->getTicketsByWorkflow('Finance Manager', $user->outpost),
            'generalmanager' => $this->getTicketsByWorkflow('General Manager', $user->outpost),
            'ceo' => $this->getTicketsByWorkflow('Chief Executive Officer', $user->outpost),
            'communication' => $this->getTicketsByWorkflow('Communication Officer"', $user->outpost),

        ];
        return view('crm.ticket.customer_tickets', $pageData);
    }

    public static function getTicketsByWorkflow($workflow_user_name, $outpost_id)
    {
        $customerTicket = new CustomerTicket();
        $tickets = $customerTicket->getGroupedTickets($outpost_id);
        foreach ($tickets as $ticket) {
            if (strtolower($ticket->workflow_user_name == $workflow_user_name))
                return $ticket->tickets;
        }
        return [];
    }


    private function getWorkflowTickets($workflow_id, $outpost_id)
    {
        return CustomerTicket::getTicketsByWorkflowAndOutpostID($workflow_id, $outpost_id);
    }

    public function saveTicketComment(Request $request)
    {
        $request->validate([
            'current_id' => 'integer|required',
            'ticket_id' => 'integer|required',
            'ticket_resolved' => 'integer|required',
            'workflow_message' => 'string|required',
            //'workflow_user_id' => 'integer|required',
        ]);

        $current_id = $request->current_id;
        $ticket_resolved = $request->ticket_resolved;
        $workflow_message = $request->workflow_message;
        $ticket_id = $request->ticket_id;

        if ($ticket_resolved == 1) {
            $workflow_id = 1;
            $workflow_user_id = 1;
        } else {
            $request->validate([
                'workflow_id' => 'integer|required',
                'workflow_user_id' => 'integer|required',
            ]);
            $workflow_id = $request->workflow_id;
            $workflow_user_id = $request->workflow_user_id;
        }
        //return $request;

        // Update workflow message
        TicketWorkflow::submitTicketComment($current_id, $workflow_message, $ticket_resolved, 0);

        //Register ticket to the workflow
        $ticket = CustomerTicket::find($ticket_id);

        $workflow = new TicketWorkflow();
        $workflow->is_current = 1;
        $workflow->ticket_id = $ticket_id;
        $workflow->workflow_id = $workflow_id;
        $workflow->workflow_user_id = $workflow_user_id;
        $workflow->save();

        //Save audit trail
        $activity_type = 'Customer Ticket Comment';
        $description = 'Successfully submitted customer ticket comment for ' . $ticket->ticket_uuid;
        User::saveAuditTrail($activity_type, $description);

        $messageModel = new Message();
        $customerData = CRMCustomer::find($ticket->customer_id);

        // Send message to client if ticket escalated beyond branch
        if ($workflow_id === 5) {
            $customer_message = $this->setCustomerEscalationMessage($ticket->ticket_uuid);
            $messageModel->saveSystemMessage('Ticket Escalation Customer', $customerData->customer_phone, $customerData->customer_name,  $customer_message, true);
        }

        // Get the person ticket being escalated to and send notification
        $persons = $this->getEscalatedPersonsDetails($ticket_id, $workflow_user_id);
        if (!empty($persons)) {
            foreach ($persons as $person) {
                // Send sms notification
                $officer_message = $this->setOfficerEscalationMessage($ticket->ticket_uuid);
                $messageModel->saveSystemMessage('Ticket Escalation Officer', $person->mobile_no, $person->name,  $officer_message, true);

                // Send email to the person
                $emailSubject = 'Ticket Escalation for ' . strtoupper($customerData->customer_name) . '-' . $customerData->customer_phone . ' raised on Staffportal';
                $messageModel->SendSystemEmail($person->name, $person->email, $officer_message, $emailSubject);
            }
        }

        if (Auth::user()->hasRole('communication|admin'))
            return redirect(route('crm.tickets.index'))->with('success', 'Successfully submitted comment for customer ticket of ' . $customerData->customer_name . '. Notifications sent to the relevant officer');

        return redirect(route('crm.tickets.customers'))->with('success', 'Successfully submitted comment for customer ticket of ' . $customerData->customer_name . '. Notifications sent to the relevant officer');
    }

    //Get the person ticket being escalated
    public function getEscalatedPersonsDetails($ticket_id, $workflow_user_id)
    {
        $ticket = CustomerTicket::find($ticket_id);
        $workflow = DB::table('crm_workflow_users')->where('workflow_user_id', $workflow_user_id)->first();
        if ($workflow_user_id === 12 || $workflow_user_id === 13) {
            $users = [];
            $user = User::getUserById($ticket->officer_id);
            return is_null($user) ? [] : array_push($users, $user);
        }

        $role = DB::table('roles')->where('name', strtolower($workflow->workflow_user_name))->first();
        if ($role) {
            $role_users = DB::table('role_user')->where('role_id', $role->id)->pluck('user_id')->toArray();
            if ($role_users) {
                $users = User::getUsersById($role_users);
                return is_null($users) ? [] : $users;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function closeTicket(Request $request)
    {
        $request->validate([
            'current_id' => 'integer|required',
            'ticket_id' => 'integer|required',
            'date_closed' => 'date|required',
            'closure_message' => 'string|required',
        ]);

        $closure_message = $request->closure_message;
        $date_closed = $request->date_closed;
        $ticket_id = $request->ticket_id;
        $current_id = $request->current_id;

        $messageModel = new Message();
        $ticket = CustomerTicket::find($ticket_id);
        $customerData = CRMCustomer::find($ticket->customer_id);

        // Update workflow message
        TicketWorkflow::submitTicketComment($current_id, $closure_message, 1, 0);

        // Submit ticket closure comment
        TicketWorkflow::submitTicketClosureComment($ticket_id, $closure_message);

        //Close customer ticket
        CustomerTicket::closeTicket($ticket_id, $closure_message, $date_closed);

        //Save audit trail
        $activity_type = 'Customer Ticket Closure';
        $description = 'Successfully closed ticket of ID ' . $ticket->ticket_uuid;
        User::saveAuditTrail($activity_type, $description);

        //Send Customer customized sms notification
        $customer_message = $this->setCustomerTicketClosureMessage($ticket->ticket_uuid);
        $messageModel->saveSystemMessage('Client Ticket Closure', $customerData->customer_phone, $customerData->customer_name,  $customer_message, true);

        //Send sms notification to the logged in user
        $loggedInUser = User::getUserById(Auth::user()->id);
        $loggedInUserMessage = 'you have successfully closed client ticket ' . $ticket->ticket_uuid . ' for ' . strtoupper($customerData->customer_name) . ' on ' . Carbon::now();
        $messageModel->saveSystemMessage('Client Ticket Closure', $loggedInUser->mobile_no, $loggedInUser->name, $loggedInUserMessage, true);

        return redirect(route('crm.tickets.index'))->with('success', 'Successfully closed client ticket of ' . $customerData->customer_name . '. Notifications sent to the client');
    }

    public function saveClientSurveyData(Request $request)
    {
        //return $request;
        $request->validate([
            'ticket_id' => 'integer|required',
            'survey_message' => 'string|required',
            'survey_link' => 'string|required',
        ]);
        //return $request;

        $survey_message = $request->survey_message;
        $survey_link = $request->survey_link;
        $ticket_id = $request->ticket_id;

        $messageModel = new Message();
        $ticket = CustomerTicket::find($ticket_id);
        $customerData = CRMCustomer::find($ticket->customer_id);

        // Save survey data remotely
        try {
            $client =  new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
            $url = env('FEEDBACK_URL') . "api/customer-feedback/v1/save-survey-data";

            $form_data = [
                'ticket_id' => $ticket_id,
                'ticket_uuid' => $ticket->ticket_uuid,
                'customer_name' => $customerData->customer_name,
                'customer_phone' => $customerData->customer_phone,
            ];

            $response = $client->post(
                $url,
                [
                    RequestOptions::ALLOW_REDIRECTS => [
                        'max' => 5,
                        'track_redirects' => true,
                    ],
                    RequestOptions::FORM_PARAMS => $form_data,
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
            file_put_contents("log.txt", $th . " \n", FILE_APPEND);
            return back()->with('warning', 'There was an error while trying to post survey data to remote server : ' . $th);
        }

        //save survey data locally
        CustomerTicket::saveSurveyData($ticket_id, $ticket->ticket_uuid, $survey_link, $survey_message . ' ' . $survey_link);

        //Send customer notification sms
        $messageModel->saveSystemMessage('Client Survey Message', $customerData->customer_phone, $customerData->customer_name, $survey_message . ' ' . $survey_link, true);

        //Send sms notification to the logged in user
        $loggedInUser = User::getUserById(Auth::user()->id);
        $loggedInUserMessage = 'you have successfully initiated client feedback survey response for ticket ID ' . $ticket->ticket_uuid . ' for ' . strtoupper($customerData->customer_name) . ' on ' . Carbon::now();
        $messageModel->saveSystemMessage('Client Survey Message', $loggedInUser->mobile_no, $loggedInUser->name, $loggedInUserMessage, true);

        //Save audit trail
        $activity_type = 'Customer Survey Message';
        $description = 'Successfully sent customer survey for ticket of ID ' . $ticket->ticket_uuid;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('crm.tickets.show', $ticket_id))->with('success', 'Successfully sent customer survey for ticket of ID ' . $ticket->ticket_uuid);
    }

    public function resendSurveyMessage(Request $request)
    {
        $request->validate([
            'ticket_id' => 'integer|required',
            'survey_message' => 'string|required',
        ]);
        //return $request;
        $survey_message = $request->survey_message;
        $ticket_id = $request->ticket_id;

        $messageModel = new Message();
        $ticket = CustomerTicket::find($ticket_id);
        $customerData = CRMCustomer::find($ticket->customer_id);

        //Cannot send sms once count == 3
        if ($ticket->reminder_count >= 3)
            return redirect(route('crm.tickets.show', $ticket_id))->with('warning', 'Cannot send customer survey reminder response for ticket of ID ' . $ticket->ticket_uuid . '. Maximum number of 3 counts reached');

        //Send customer notification sms
        CustomerTicket::sendCustomerReminder($ticket_id, $customerData, $survey_message);

        //Send sms notification to the logged in user
        $loggedInUser = User::getUserById(Auth::user()->id);
        $loggedInUserMessage = 'you have successfully sent client feedback reminder message for ticket ID ' . $ticket->ticket_uuid . ' for ' . strtoupper($customerData->customer_name) . ' on ' . Carbon::now();
        $messageModel->saveSystemMessage('Client Survey Reminder', $loggedInUser->mobile_no, $loggedInUser->name, $loggedInUserMessage, true);

        //Save audit trail
        $activity_type = 'Customer Survey Reminder';
        $description = 'Successfully sent customer survey for ticket of ID ' . $ticket->ticket_uuid;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('crm.tickets.show', $ticket_id))->with('success', 'Successfully sent customer survey reminder response for ticket of ID ' . $ticket->ticket_uuid);
    }

    public function surveyFeedbacks()
    {
        $pageData = [
            'page_name' => 'crm',
            'page_title' => 'crm',
            'title' => 'Survey Responses Data',
            'pending_feedbacks' => CustomerTicket::getSurveyData(0),
            'completed_feedbacks' => CustomerTicket::getSurveyData(1),
        ];
        return view('crm.feedbacks', $pageData);
    }

    public function surveyFeedback($ticket_uuid)
    {
        $surveyData = CustomerTicket::getSurveyDataById($ticket_uuid);
        //return unserialize($surveyData->customer_response)['Q1'];
        $pageData = [
            'page_name' => 'crm',
            'page_title' => 'crm',
            'ticket' => $surveyData,
            'title' => 'Customer Survey Responses',
            'response' => unserialize($surveyData->customer_response),
        ];
        return view('crm.feedback', $pageData);
    }

    // Synch data from the remote server
    public function syncSurveyData()
    {
        $customerTicket = new CustomerTicket();
        try {
            $client =  new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
            $url = env('FEEDBACK_URL') . "api/customer-feedback/v1/get/synced/0";

            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $data = json_decode($response->getBody());
            $customerTicket->syncSurveyData($data);
        } catch (\Throwable $th) {
            throw $th;
            file_put_contents("log.txt", $th . " \n", FILE_APPEND);
            return back()->with('warning', 'There was an error while trying to post survey data to remote server : ' . $th);
        }

        //Save audit trail
        $activity_type = 'Survey Data Synchronization';
        $description = 'Successfully synchronized customer survey data ' . count($data) . ' records affected';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Customer feedback survey data synchronized successfuly : ' . count($data) . ' records affected');
    }

    // Send reminder messages for overstaying tickets
    public function sendOverdueTicketsReminders()
    {
        $affected_rows = 0;
        $tickets = CustomerTicket::getCustomerTicketsByActiveStatus(0, 1);

        try {
            foreach ($tickets as $ticket) {
                $data = $this->getTicketOverdueHours($ticket->ticket_id, $ticket->created_at);
                if (!empty($data)) {
                    $this->sendOverdueTicketReminderMessage($ticket->ticket_id, $data['hours']);
                    $affected_rows = $affected_rows + 1;
                }
            }
        } catch (\Throwable $th) {
            return back()->with('danger', 'Reminder notification messages could not be sent successfully. ' . $th->getMessage());
        }

        // Send communication officer message
        $messageModel = new Message();
        $defaultUser = CustomerTicket::defaultUser();
        $communicationMessage = 'a total of ' . $affected_rows . ' tickets are overdue as at ' . now();
        $messageModel->saveSystemMessage('Overdue Message Reminder', $defaultUser->mobile_no, $defaultUser->name, $communicationMessage, true);

        //Save audit trail
        $activity_type = 'Overdue Tickets Reminders';
        $description = 'Successfully sent overdue customer tickets reminders. ' . $affected_rows . ' records affected ';
        User::saveAuditTrail($activity_type, $description);

        //return $tickets;
        return redirect(route('crm.tickets.index'))->with('success', 'Successfully sent overdue customer tickets reminders. ' . $affected_rows . ' records affected ');
    }

    // Get ticket overdue hours
    public function getTicketOverdueHours($ticket_id, $date_created)
    {
        $data = [];
        $ticket = CustomerTicket::getCustomerTicketById($ticket_id);
        $maximum_hours = $ticket->max_stay_hours;
        $maximum_days = round($ticket->max_stay_hours / 24);

        $date = Carbon::parse($date_created);
        $hours = $date->diffInHours(Carbon::now());
        $days = $date->diffInDays(Carbon::now());

        if ($hours > $maximum_hours) {
            $overdue_hours = $hours - $maximum_hours;
            $overdue_days =  $days - $maximum_days;

            DB::table('customer_tickets')->where('ticket_id', $ticket_id)
                ->update([
                    'overdue_hours' => $overdue_hours,
                    'overdue_days' => $overdue_days
                ]);

            $data = ['days' => $overdue_days, 'hours' => $overdue_hours];
        }

        return $data;
    }

    // Send officer reminder message for overdue tickets
    public function sendOverdueTicketReminderMessage($ticket_id, $hours)
    {
        $ticket = CustomerTicket::getCustomerTicketById($ticket_id);
        $outpost = Admin::getOutpostById($ticket->outpost_id);
        $customerData = CRMCustomer::find($ticket->customer_id);
        $messageModel = new Message();

        //Send sms notification to the officer
        $user = User::getUserById($ticket->officer_id);
        $reminder_message = $this->setOfficerOverdueReminderMessage($ticket->ticket_uuid, $hours, $customerData->customer_name);
        $messageModel->saveSystemMessage('Overdue Message Reminder', $user->mobile_no, $user->name,  $reminder_message, true);

        //Send email to outpost email
        $emailSubject = 'Overdue Customer Ticket for ' . strtoupper($customerData->customer_name) . '-' . $customerData->customer_phone . ' raised on Staffportal';
        $messageModel->SendSystemEmail($user->name, $outpost->outpost_email, $reminder_message, $emailSubject);

        return true;
    }
}
