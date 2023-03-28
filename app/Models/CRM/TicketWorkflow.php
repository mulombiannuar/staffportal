<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TicketWorkflow extends Model
{
    use HasFactory;
    protected $table = 'ticket_workflows';
    protected $primaryKey = 'id';

    public static function getWorkFlowTickets()
    {
        $worklows = TicketWorkflow::getCRMWorkflows();
        for ($s=0; $s <count($worklows) ; $s++) { 
            $worklows[$s]->tickets = CustomerTicket::getTicketsByWorkflowID($worklows[$s]->workflow_id);
            $worklows[$s]->count = count($worklows[$s]->tickets );
        }
        return $worklows;
    }

    
    public static function getCRMWorkflows()
    {
        return  DB::table('crm_workflows')->where('status', 1)->orderBy('workflow_id', 'desc')->get();
    }

    public static function getCRMWorkflowUsers()
    {
        return  DB::table('crm_workflow_users')
                   ->join('crm_workflows', 'crm_workflows.workflow_id', 'crm_workflow_users.workflow_id')
                   ->select(
                    'crm_workflows.*',
                    'workflow_user_name'
                    )
                   ->where('crm_workflow_users.status', 1)
                   ->orderBy('workflow_id', 'asc')
                   ->get();
    }

    public static function getWorkFlowUsers($worklow_id)
    {
        return  DB::table('crm_workflow_users')->where(['workflow_id' => $worklow_id, 'status' => 1])->orderBy('workflow_user_name', 'asc')->get();
    }
}
