<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MotorMaintenance extends Model
{
    use HasFactory;
    protected $table = 'motor_maintenances';
    protected $primaryKey = 'log_id';

    public function getLogs()
    {
        $logs = DB::table('motor_maintenances')
                  ->join('motors', 'motors.motor_id', '=', 'motor_maintenances.asset_id')
                  ->join('users as bookers', 'bookers.id', '=', 'motor_maintenances.user_id')
                  ->leftJoin('users as servicers', 'servicers.id', '=', 'motor_maintenances.service_by')
                  ->leftJoin('users as approvers', 'approvers.id', '=', 'motor_maintenances.approved_by')
                  ->join('profiles', 'profiles.user_id', '=', 'bookers.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'motor_maintenances.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'bookers.name as booker_name',
                    'servicers.name as servicer_name',
                    'approvers.name as approver_name',
                   )
                  ->orderBy('log_id', 'desc')
                  ->get();

        for ($s=0; $s <count($logs) ; $s++) 
        { 
            $logs[$s]->approval = $this->getApprovalStatus($logs[$s]->status);
        }
        return $logs;
    }

    public function getLogById($id)
    {
        return DB::table('motor_maintenances')
                    ->join('motors', 'motors.motor_id', '=', 'motor_maintenances.asset_id')
                    ->join('users as bookers', 'bookers.id', '=', 'motor_maintenances.user_id')
                    ->leftJoin('users as servicers', 'servicers.id', '=', 'motor_maintenances.service_by')
                    ->leftJoin('users as approvers', 'approvers.id', '=', 'motor_maintenances.approved_by')
                    ->join('profiles', 'profiles.user_id', '=', 'bookers.id' )
                    ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                    ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                    ->select(
                        'motors.*',
                        'motor_maintenances.*',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'bookers.name as booker_name',
                        'servicers.name as servicer_name',
                        'servicers.email as servicer_email',
                        'approvers.name as approver_name',
                    )
                  ->where('log_id', $id)
                  ->first();
    }

    public function getLogsByAssetId($id)
    {
        $logs = DB::table('motor_maintenances')
                    ->join('motors', 'motors.motor_id', '=', 'motor_maintenances.asset_id')
                    ->join('users as bookers', 'bookers.id', '=', 'motor_maintenances.user_id')
                    ->leftJoin('users as servicers', 'servicers.id', '=', 'motor_maintenances.service_by')
                    ->leftJoin('users as approvers', 'approvers.id', '=', 'motor_maintenances.approved_by')
                    ->join('profiles', 'profiles.user_id', '=', 'bookers.id' )
                    ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                    ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                    ->select(
                        'motors.*',
                        'motor_maintenances.*',
                        'bookers.name as booker_name',
                        'servicers.name as servicer_name',
                        'outposts.outpost_name',
                        'branches.branch_name',
                        'approvers.name as approver_name',
                    )
                  ->where('asset_id', $id)
                  ->orderBy('log_id', 'desc')
                  ->get();

        for ($s=0; $s <count($logs) ; $s++) 
        { 
            $logs[$s]->approval = $this->getApprovalStatus($logs[$s]->status);
        }
        return $logs;
    }

    public function getApprovalStatus($status)
    {
       switch ($status) 
       {
            case 0:
                $message = 'Waiting Approval';
                break;

            case 1:
                $message = 'Booking Approved';
                break;

            case 2:
                $message = 'Booking Rescheduled';
                break;
                
           default:
               $message = 'Approved';
               break;
       }
       return $message;
    }
}