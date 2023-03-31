<?php

namespace App\Models\CRM;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    public static function getUserForwadedToLevels($user_id)
    {
        $user = User::find($user_id);
        if($user->hasRole('communication')) 
        return TicketWorkflow::forwardedLevels([2,3,4,5,6,7]);

        if($user->hasRole('chief executive officer')) 
        return TicketWorkflow::forwardedLevels([1,2,3,4,5,6,7]);

        if($user->hasRole('general manager')) 
        return TicketWorkflow::forwardedLevels([1,2,4]);

        if(User::hasSeniorManagerRole($user_id)) 
        return TicketWorkflow::forwardedLevels([1,2,5]);
        
        if($user->hasRole('branch manager')) 
        return TicketWorkflow::forwardedLevels([4,6]);
        
        if($user->hasRole('receptionist')) 
        return TicketWorkflow::forwardedLevels([1,2,3,4,5,6]);
        
        if($user->hasRole('credit officer')) 
        return TicketWorkflow::forwardedLevels([5]);

        return [];
    }


    private static function forwardedLevels($data)
    {
        return  DB::table('crm_workflows')->where('status', 1)
                  ->whereIn('workflow_id', $data)
                  ->select('name', 'workflow_id')
                  ->orderBy('workflow_id', 'asc')
                  ->get();
    }

    public static function submitTicketComment($id, $workflow_message, $ticket_resolved)
    {
        return  DB::table('ticket_workflows')->where('id', $id)
                  ->update([
                    'is_current' => 0,
                    'message_by' => Auth::user()->id,
                    'date_responded' => Carbon::now(),
                    'ticket_resolved' => $ticket_resolved,
                    'workflow_message' => $workflow_message,
                ]);        
    }
}
