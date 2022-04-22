<?php

namespace Database\Seeders;

use App\Models\MotorMaintenance;
use App\Models\Products\Motor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateMotorMaintenanceList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $bookings = DB::table('tbl_bookings')
                       ->join('tbl_motorbikes_repairs', 'tbl_motorbikes_repairs.booking_id', '=', 'tbl_bookings.booking_id')
                       ->join('tbl_motorbikes', 'tbl_motorbikes.motorbike_id', '=', 'tbl_bookings.booked_motorbike_id')
                       ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_bookings.booked_user_id')
                       ->select(
                            'tbl_bookings.*', 
                            'tbl_users.user_email',
                            'tbl_motorbikes.motorbike_registration', 
                            'tbl_motorbikes_repairs.service_date',
                            'tbl_motorbikes_repairs.action_done as service_done',
                            'tbl_motorbikes_repairs.action_by',
                            'tbl_motorbikes_repairs.repair_cost',
                            'tbl_motorbikes_repairs.repair_reason',
                            )
                       ->get();
        
        
        for ($s=0; $s <count($users) ; $s++) { 
            for ($i=0; $i <count($bookings) ; $i++) { 
                if ($users[$s]->email == $bookings[$i]->user_email) {
                    $log = new MotorMaintenance();
                    $log->user_id = $users[$s]->id;
                    $log->asset_id = Motor::where('reg_no', $bookings[$i]->motorbike_registration)->first()->motor_id;
                    $log->type = 'Scheduled Maintenance';
                    $log->date = $bookings[$i]->booked_date;
                    $log->message = $bookings[$i]->booked_message;
                    $log->reference = $bookings[$i]->booking_ref;
                    $log->status = $bookings[$i]->booked_status;
                    $log->approved_by = 179;
                    $log->approval_message = $bookings[$i]->rejection_message;
                    $log->service_date = $bookings[$i]->serviced_date;
                    $log->service_done = $bookings[$i]->service_done;
                    $log->service_by = 179;
                    $log->service_cost = $bookings[$i]->repair_cost;
                    $log->service_cause = 'Cause of Mileage Limits';
                    $log->additional_info = $bookings[$i]->service_done;
                    $log->date_approved = $bookings[$i]->booked_date;
                    $log->save();
                }
            }
        }

    }
}