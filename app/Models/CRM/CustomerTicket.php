<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
                 ->select(
                    'customer_tickets.*', 
                    'customer_name',
                    'residence',
                    'business',
                    'branch_id',
                    'outpost_id',
                    'bimas_br_id',
                    // 'created_by',
                    'category_name',
                    'source_name'
                    )
                 ->orderBy('ticket_id', 'desc')
                 ->get();
    }
}
