<?php

namespace App\Models\CRM;

use App\Models\Message;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class CustomerTicket extends Model
{
    use HasFactory;
    protected $table = 'customer_tickets';
    protected $primaryKey = 'ticket_id';

    public static function getCustomerTickets()
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                //'branch_id',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            //->where('crm_customers.deleted_at', '!=', null)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getCustomerTicketsByDate($date)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                //'branch_id',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->whereDate('customer_tickets.created_at', $date)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getCustomerOverdueTickets()
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                'crm_customers.outpost_id',
                'bimas_br_id',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->where('ticket_closed', 0)
            ->where('overdue_days', '!=', 0)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getCustomerOverdueTicketsByDate($date)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                'crm_customers.outpost_id',
                'bimas_br_id',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->where('ticket_closed', 0)
            ->where('overdue_days', '!=', 0)
            ->whereDate('customer_tickets.created_at', '>=', $date)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getCustomerTicketsByStatus($status)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->join('users as closers', 'closers.id', '=', 'customer_tickets.closed_by')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                //'branch_id',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name',
                'closers.name as closed_by'
            )
            ->where('ticket_closed', $status)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getCustomerTicketsByStatusAndDate($status, $date)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->join('users as closers', 'closers.id', '=', 'customer_tickets.closed_by')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                //'branch_id',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name',
                'closers.name as closed_by'
            )
            ->where('ticket_closed', $status)
            ->whereDate('customer_tickets.date_closed', $date)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getCustomerTicketsByCategory($category_id)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'category_name',
                'residence',
                'business',
                //'branch_id',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->where('customer_tickets.category_id', $category_id)
            ->orderBy('ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function getTicketsByWorkflowAndOutpostID($workflow_user_id, $outpost_id)
    {
        $data = $outpost_id == null
            ? [
                'ticket_workflows.workflow_user_id' => $workflow_user_id,
                'ticket_closed' => 0,
                'is_current' => 1
            ]
            : [
                'ticket_workflows.workflow_user_id' => $workflow_user_id,
                'outposts.outpost_id' => $outpost_id,
                'ticket_closed' => 0,
                'is_current' => 1
            ];


        $tickets = DB::table('ticket_workflows')
            ->join('customer_tickets', 'customer_tickets.ticket_id', '=', 'ticket_workflows.ticket_id')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->where($data)
            ->select(
                'customer_tickets.created_at',
                'customer_tickets.category_id',
                'customer_tickets.source_id',
                'customer_tickets.ticket_id',
                'customer_tickets.date_raised',
                'customer_tickets.ticket_uuid',
                'crm_customers.customer_id',
                'customer_name',
                'hold_hours',
                'customer_phone',
                'residence',
                'business',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'outposts.outpost_id',
                'users.name as officer_name'
            )
            ->orderBy('customer_tickets.ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public function getGroupedTickets($outpost_id)
    {
        $workflows = DB::table('crm_workflow_users')
            ->select('workflow_user_name', 'workflow_user_id')
            ->orderBy('workflow_id', 'asc')
            ->get();

        foreach ($workflows as $workflow) {
            if ($workflow->workflow_user_id == 12 || $workflow->workflow_user_id == 13) {
                $workflow->tickets = $this->getTicketsByWorkflowAndOutpostID($workflow->workflow_user_id, $outpost_id);
            } else {
                $workflow->tickets = $this->getTicketsByWorkflowAndOutpostID($workflow->workflow_user_id, null);
            }
        }
        return $workflows;
    }

    public static function getTicketsByWorkflowID($workflow_id)
    {
        $tickets = DB::table('ticket_workflows')
            ->join('customer_tickets', 'customer_tickets.ticket_id', '=', 'ticket_workflows.ticket_id')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->where([
                'ticket_workflows.workflow_id' => $workflow_id,
                'ticket_closed' => 0,
                'is_current' => 1
            ])
            ->select(
                //'ticket_workflows.id',
                //'ticket_workflows.workflow_id',
                'customer_tickets.category_id',
                'customer_tickets.created_at',
                'customer_tickets.category_id',
                'customer_tickets.source_id',
                'customer_tickets.ticket_id',
                'customer_tickets.date_raised',
                'customer_tickets.ticket_uuid',
                'crm_customers.customer_id',
                'customer_name',
                'hold_hours',
                'customer_phone',
                'residence',
                'business',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->orderBy('customer_tickets.ticket_id', 'desc')
            ->get();

        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    private static function getTicketsCurrentLevels($tickets)
    {
        foreach ($tickets as $ticket) {
            $ticket->current_level = CustomerTicket::getTicketCurrentWorkflowLevel($ticket->ticket_id)->workflow_user_name;
            $current_ticket = CustomerTicket::getCurrentActiveTicketWorkflowLevel($ticket->ticket_id);
            $ticket->progress_status = CustomerTicket::setTicketStatus($current_ticket);
        }
        return $tickets;
    }

    public static function getTicketCurrentWorkflowLevel($ticket_id)
    {
        return DB::table('ticket_workflows')
            ->join('crm_workflow_users', 'crm_workflow_users.workflow_user_id', '=', 'ticket_workflows.workflow_user_id')
            ->select('workflow_user_name', 'id')
            ->where(['ticket_id' => $ticket_id, 'is_current' => 1])
            ->first();
    }

    public static function getCurrentActiveTicketWorkflowLevel($ticket_id)
    {
        return DB::table('ticket_workflows')
            ->select('hold_hours')
            ->where(['ticket_id' => $ticket_id, 'is_current' => 1])
            ->first();
    }

    public static function setTicketStatus($ticket)
    {
        return is_null($ticket->hold_hours) ?  'In progress' : 'Held for ' . $ticket->hold_hours . ' hours';
    }

    public static function getTicketEscalationWorkflowLevels($ticket_id)
    {
        return DB::table('ticket_workflows')
            ->join('users', 'users.id', '=', 'ticket_workflows.message_by')
            ->join('crm_workflow_users', 'crm_workflow_users.workflow_user_id', '=', 'ticket_workflows.workflow_user_id')
            ->select(
                'workflow_user_name',
                'workflow_message',
                'date_responded',
                'name as officer_name',
                'ticket_resolved',
                'resolution_time',
                'email',
                'hold_hours'
            )
            ->where(['ticket_id' => $ticket_id, 'is_current' => 0])
            ->get();
    }

    public static function getCustomerTicketsByActiveStatus($ticket_closed, $is_current)
    {
        return DB::table('ticket_workflows')
            ->join('customer_tickets', 'customer_tickets.ticket_id', '=', 'ticket_workflows.ticket_id')
            ->where(['ticket_closed' => $ticket_closed, 'is_current' => $is_current])
            ->select('ticket_workflows.*', 'is_current')
            ->get();
    }

    public static function getCustomerTicketById($ticket_id)
    {
        return DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('branches', 'branches.branch_id', '=', 'crm_customers.branch_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->join('users as creators', 'creators.id', '=', 'customer_tickets.created_by')
            ->join('ticket_workflows', 'ticket_workflows.ticket_id', '=', 'customer_tickets.ticket_id')
            ->join('crm_workflow_users', 'crm_workflow_users.workflow_user_id', '=', 'ticket_workflows.workflow_id')
            ->join('crm_workflows', 'crm_workflows.workflow_id', '=', 'crm_workflow_users.workflow_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                'crm_customers.branch_id',
                'crm_customers.outpost_id',
                'ticket_workflows.workflow_id',
                'workflow_user_name',
                'crm_workflows.name as workflow_name',
                'crm_workflows.workflow_id as flow_id',
                'bimas_br_id',
                'hold_hours',
                'max_stay_hours',
                'category_name',
                'source_name',
                'outpost_name',
                'branch_name',
                'creators.name as created_by',
                'users.name as officer_name',
            )
            ->where('customer_tickets.ticket_id', $ticket_id)
            ->first();
    }

    public static function getCustomerTicketsById($customer_id)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('ticket_categories', 'ticket_categories.category_id', '=', 'customer_tickets.category_id')
            ->join('ticket_sources', 'ticket_sources.source_id', '=', 'customer_tickets.source_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('users', 'users.id', '=', 'customer_tickets.officer_id')
            ->select(
                'customer_tickets.*',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                //'branch_id',
                'crm_customers.outpost_id',
                'bimas_br_id',
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->where('crm_customers.customer_id', $customer_id)
            ->orderBy('ticket_id', 'desc')
            ->get();
        return CustomerTicket::getTicketsCurrentLevels($tickets);
    }

    public static function saveCustomerTicket($message, $user_id, $source, $category, $date_raised, $customer_id, $created_by)
    {
        $ticket = new CustomerTicket();
        $ticket->message = $message;
        $ticket->officer_id = $user_id;
        $ticket->source_id = $source;
        $ticket->category_id = $category;
        $ticket->date_raised = $date_raised;
        $ticket->created_by = $created_by;
        $ticket->ticket_uuid = CustomerTicket::generateTicketID();
        $ticket->customer_id = $customer_id;
        $ticket->save();
        return $ticket;
    }

    public static function newCustomerTicketWorkFlow($is_current, $ticket_id, $workflow_id, $workflow_user_id)
    {
        $workflow = new TicketWorkflow();
        $workflow->ticket_id = $ticket_id;
        $workflow->is_current = $is_current;
        $workflow->workflow_id = $workflow_id;
        $workflow->workflow_user_id = $workflow_user_id;
        $workflow->save();
        return $workflow;
    }

    public static function updateCustomerTicket($ticket_id, $message, $user_id, $source, $category, $date_raised)
    {
        $ticket = CustomerTicket::find($ticket_id);
        $ticket->message = $message;
        $ticket->officer_id = $user_id;
        $ticket->source_id = $source;
        $ticket->category_id = $category;
        $ticket->date_raised = $date_raised;
        $ticket->save();
        return $ticket;
    }

    public static function saveSurveyData($ticket_id, $ticket_uuid, $survey_link, $survey_message)
    {
        CustomerTicket::updateSurveySentCount($ticket_id);
        return DB::table('ticket_survey')->insert([
            'ticket_id' => $ticket_id,
            'date_sent' => Carbon::now(),
            'sent_by' => Auth::user()->id,
            'ticket_uuid' => $ticket_uuid,
            'survey_link' => $survey_link,
            'survey_message' => $survey_message,
            'created_at' => Carbon::now()
        ]);
    }

    public static function updateSurveySentCount($ticket_id)
    {
        $ticket = CustomerTicket::find($ticket_id);
        $reminder_count = $ticket->reminder_count + 1;

        return DB::table('customer_tickets')->where('ticket_id', $ticket_id)
            ->update([
                'customer_sent_survey' => 1,
                'reminder_count' => $reminder_count
            ]);
    }

    public static function sendCustomerReminder($ticket_id, $customerData, $survey_message)
    {
        $messageModel = new Message();

        //Update survey count
        CustomerTicket::updateSurveySentCount($ticket_id);

        //Send customer notification sms
        $messageModel->saveSystemMessage('Customer Survey Reminder', $customerData->customer_phone, $customerData->customer_name, $survey_message, true);

        return 0;
    }

    public static function getSurveyData($status)
    {
        return DB::table('ticket_survey')
            ->join('users', 'users.id', '=', 'ticket_survey.sent_by')
            ->join('customer_tickets', 'customer_tickets.ticket_id', '=', 'ticket_survey.ticket_id')
            ->join('users as officers', 'officers.id', '=', 'customer_tickets.officer_id')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->select(
                'ticket_survey.*',
                'users.name as sent_by',
                'date_raised',
                'customer_name',
                'customer_phone',
                'residence',
                'outpost_name',
                'officers.name as officer_name'
            )
            ->where('customer_responded_survey', $status)
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function getSurveyDataByDate($status, $date)
    {
        return DB::table('ticket_survey')
            ->join('users', 'users.id', '=', 'ticket_survey.sent_by')
            ->join('customer_tickets', 'customer_tickets.ticket_id', '=', 'ticket_survey.ticket_id')
            ->join('users as officers', 'officers.id', '=', 'customer_tickets.officer_id')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->select(
                'ticket_survey.*',
                'users.name as sent_by',
                'date_raised',
                'customer_name',
                'customer_phone',
                'residence',
                'outpost_name',
                'officers.name as officer_name'
            )
            ->whereDate('ticket_survey.date_responded', $date)
            ->where('customer_responded_survey', $status)
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function getSurveyDataById($ticket_uuid)
    {
        return DB::table('ticket_survey')
            ->join('customer_tickets', 'customer_tickets.ticket_id', '=', 'ticket_survey.ticket_id')
            ->join('users as officers', 'officers.id', '=', 'customer_tickets.officer_id')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
            ->join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
            ->join('branches', 'branches.branch_id', '=', 'crm_customers.branch_id')
            ->select(
                'ticket_survey.*',
                'date_raised',
                'customer_name',
                'customer_phone',
                'residence',
                'business',
                'message',
                'branch_name',
                'outpost_name',
                'officers.name as officer_name'
            )
            ->where('ticket_survey.ticket_uuid', $ticket_uuid)
            ->orderBy('id', 'desc')
            ->first();
    }

    public static function getSurveyDataByTicketID($ticket_id)
    {
        return DB::table('ticket_survey')
            ->join('users', 'users.id', '=', 'ticket_survey.sent_by')
            ->select('ticket_survey.*', 'name')
            ->where('ticket_id', $ticket_id)
            ->first();
    }

    public static function closeTicket($ticket_id, $closure_message, $date_closed)
    {
        return  DB::table('customer_tickets')->where('ticket_id', $ticket_id)
            ->update([
                'ticket_closed' => 1,
                'date_closed' => $date_closed,
                'closed_by' => Auth::user()->id,
                'closure_comment' => $closure_message,
            ]);
    }

    public function syncSurveyData($datas)
    {
        foreach ($datas as $data) {
            $this->updateRemoteHasSynced($data->ticket_id);
            $this->updateCustomerHasResponded($data->ticket_id);
            $this->updateCustomerResponse($data->ticket_id, $data->date_responded, $data->ip_address, $data->customer_response);
        }

        return true;
    }

    private function updateCustomerHasResponded($ticket_id)
    {
        return  DB::table('customer_tickets')->where('ticket_id', $ticket_id)
            ->update([
                'customer_responded_survey' => 1,
                'updated_at' => Carbon::now()
            ]);
    }

    private function updateRemoteHasSynced($ticket_id)
    {
        try {
            $client =  new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
            $client->put(env('FEEDBACK_URL') . "api/customer-feedback/v1/sync-data/{$ticket_id}");
        } catch (\Throwable $th) {
            throw $th;
            file_put_contents("log.txt", $th . " \n", FILE_APPEND);
        }
    }

    private function updateCustomerResponse($ticket_id, $date_responded, $ip_address, $customer_response)
    {
        return  DB::table('ticket_survey')->where('ticket_id', $ticket_id)
            ->update([
                'ip_address' => $ip_address,
                'date_responded' => $date_responded,
                'customer_response' => $customer_response,
                'updated_at' => Carbon::now()
            ]);
    }

    public static function communicationOfficer()
    {
        return [
            'name' => 'Catherine Mukami',
            'email' => 'cmukami@bimaskenya.com',
            'office_email' => 'customercare@bimaskenya.com',
            'mobile_no' => '0722776906'
        ];
    }

    public static function defaultUser()
    {
        $user = new stdClass;
        $user->name = 'Catherine Mukami';
        $user->mobile_no = '0722776906';
        $user->office_mobile = '0701111700';
        $user->email = 'cmukami@bimaskenya.com';
        $user->office_email = 'customercare@bimaskenya.com';
        return $user;
    }

    public static function markettingOfficer()
    {
        return [
            'name' => 'Backson Ndiba',
            'email' => 'bndiba@bimaskenya.com',
            'mobile_no' => '0723209040'
        ];
    }

    public static function getOutpostRandomUser($outpost_id)
    {
        $random_ids = DB::table('profiles')->where('outpost', $outpost_id)->pluck('user_id')->toArray();
        $length =  count($random_ids);

        if (is_null($random_ids) || empty($random_ids))
            return 176;

        shuffle($random_ids);
        return $random_ids[0];
    }

    private static function generateTicketID(): string
    {
        $rand = rand(0, 9);
        $bytes = random_bytes(6);
        $base64 = base64_encode($bytes);

        $string = rtrim(strtr($base64, '+/', $rand), '=');
        return str_replace(['/', '+', '%'], '', $string);;
        //return rtrim(strtr($base64, '+/', '-_'), '=');
    }

    public static function getTicketURL($ticket_uuid)
    {
        return env('FEEDBACK_URL') . $ticket_uuid;
    }
}
