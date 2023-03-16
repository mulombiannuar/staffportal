<?php

namespace App\Models\CRM;

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
                 //->where('crm_customers.deleted_at', '!=', null)
                 ->orderBy('ticket_id', 'desc')
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


    private static function generateTicketID(): string
    {
        $bytes = random_bytes(5);
        $base64 = base64_encode($bytes);

        //return rtrim(strtr($base64, '+/', 'O'), '=');
        return rtrim(strtr($base64, '+/', '-_'), '=');
    }
}
