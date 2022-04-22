<?php

namespace Database\Seeders;

use App\Models\MaintenanceLog;
use App\Models\Products\Desktop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateDesktopsMaintenanceLog extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desktops = Desktop::get();
        $logs =   DB::table('tbl_maintenance_logs')
                    ->join('tbl_desktops', 'tbl_desktops.desktop_id', '=', 'tbl_maintenance_logs.device_id')
                    ->where('tbl_maintenance_logs.product_id', 2)
                    ->select('tbl_maintenance_logs.*', 'tbl_desktops.desktop_serialnumber')
                    ->get();
                            
        for ($s=0; $s <count($desktops) ; $s++) 
        { 
            for ($l=0; $l <count($logs) ; $l++) 
            { 
                if ($desktops[$s]->serial_number == $logs[$l]->desktop_serialnumber) 
                {
                    $log = new MaintenanceLog();
                    $log->cost = 0;
                    $log->product_id = 1;
                    $log->action_by = 11;
                    $log->asset_id = $desktops[$s]->desktop_id;
                    $log->current_user = $desktops[$s]->assigned_to;
                    $log->date_done = $logs[$l]->creation_date;
                    $log->hdw_log_status = $logs[$l]->hdw_log_status;
                    $log->hdw_log_comment = $logs[$l]->hdw_log_comment;
                    $log->hdd_cleanup_status = $logs[$l]->hdd_cleanup_status;
                    $log->hdd_cleanup_comment = $logs[$l]->hdd_cleanup_comment;
                    $log->hdd_capacity_status = $logs[$l]->hdd_capacity_status;
                    $log->hdd_capacity_comment = $logs[$l]->hdd_capacity_comment;
                    $log->hdw_tools_status = $logs[$l]->hdw_tools_status;
                    $log->hdw_tools_comment = $logs[$l]->hdw_tools_comment;
                    $log->windows_update_status = $logs[$l]->windows_update_status;
                    $log->windows_update_comment = $logs[$l]->windows_update_comment;
                    $log->browser_status = $logs[$l]->browser_status;
                    $log->browser_comment = $logs[$l]->browser_comment;
                    $log->sftw_status = $logs[$l]->sftw_status;
                    $log->sftw_comment = $logs[$l]->sftw_comment;
                    $log->antivirus_status = $logs[$l]->antivirus_status;
                    $log->antivirus_comment = $logs[$l]->antivirus_comment;
                    $log->antivirus_log = $logs[$l]->antivirus_log;
                    $log->antivirus_log_comment = $logs[$l]->antivirus_log_comment;
                    $log->security_log = $logs[$l]->security_log;
                    $log->security_log_comment = $logs[$l]->security_log_comment;
                    $log->backup_status = $logs[$l]->backup_status;
                    $log->backup_comment = $logs[$l]->backup_comment;
                    $log->supervisor_comment = $logs[$l]->overall_comment;
                    $log->manager_comment = $logs[$l]->manager_comment;
                    $log->save();
                }
            }
        }
    }
}