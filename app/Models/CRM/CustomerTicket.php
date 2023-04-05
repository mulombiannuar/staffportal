<?php

namespace App\Models\CRM;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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


    public static function getCustomerTicketsByCategory($category_id)
    {
        $tickets = DB::table('customer_tickets')
            ->join('crm_customers', 'crm_customers.customer_id', '=', 'customer_tickets.customer_id')
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
                'source_name',
                'outpost_name',
                'users.name as officer_name'
            )
            ->where('category_id', $category_id)
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

        for ($s = 0; $s < count($workflows); $s++) {
            if ($workflows[$s]->workflow_user_id == 12 || $workflows[$s]->workflow_user_id == 13) {
                $workflows[$s]->tickets = $this->getTicketsByWorkflowAndOutpostID($workflows[$s]->workflow_user_id, $outpost_id);
            } else {
                $workflows[$s]->tickets = $this->getTicketsByWorkflowAndOutpostID($workflows[$s]->workflow_user_id, null);
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
                //'ticket_workflows.workflow_user_id',
                'customer_tickets.created_at',
                'customer_tickets.category_id',
                'customer_tickets.source_id',
                'customer_tickets.ticket_id',
                'customer_tickets.date_raised',
                'customer_tickets.ticket_uuid',
                'crm_customers.customer_id',
                'customer_name',
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
        for ($s = 0; $s < count($tickets); $s++) {
            $tickets[$s]->current_level = CustomerTicket::getTicketCurrentWorkflowLevel($tickets[$s]->ticket_id)->workflow_user_name;
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
                'email'
            )
            ->where(['ticket_id' => $ticket_id, 'is_current' => 0])
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
                // 'created_by',
                'category_name',
                'source_name',
                'outpost_name',
                'branch_name',
                'users.name as officer_name'
            )
            ->where('customer_tickets.ticket_id', $ticket_id)
            ->first();
    }

    public static function getCustomerTicketsById($customer_id)
    {
        return DB::table('customer_tickets')
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
    }

    public static function saveCustomerTicket($message, $user_id, $source, $category, $date_raised, $customer_id)
    {
        $ticket = new CustomerTicket();
        $ticket->message = $message;
        $ticket->officer_id = $user_id;
        $ticket->source_id = $source;
        $ticket->category_id = $category;
        $ticket->date_raised = $date_raised;
        $ticket->created_by = Auth::user()->id;
        $ticket->ticket_uuid = CustomerTicket::generateTicketID();
        $ticket->customer_id = $customer_id;
        $ticket->save();
        return $ticket;
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
        DB::table('customer_tickets')->where('ticket_id', $ticket_id)
            ->update(['customer_sent_survey' => 1]);

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

    public function syncSurveyData($data)
    {
        for ($s = 0; $s < count($data); $s++) {
            $this->updateRemoteHasSynced($data[$s]->ticket_id);
            $this->updateCustomerHasResponded($data[$s]->ticket_id);
            $this->updateCustomerResponse($data[$s]->ticket_id, $data[$s]->date_responded, $data[$s]->ip_address, $data[$s]->customer_response);
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
            return back()->with('warning', 'There was an error while trying to synch survey data to remote server : ' . $th);
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

    private static function generateTicketID(): string
    {
        $rand = rand(0, 9);
        $bytes = random_bytes(6);
        $base64 = base64_encode($bytes);

        return rtrim(strtr($base64, '+/', $rand), '=');
        //return rtrim(strtr($base64, '+/', '-_'), '=');
    }

    public static function getTicketURL($ticket_uuid)
    {
        return env('FEEDBACK_URL') . $ticket_uuid;
    }
}
