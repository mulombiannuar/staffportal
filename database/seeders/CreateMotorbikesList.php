<?php

namespace Database\Seeders;

use App\Models\Products\Motor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateMotorbikesList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $motorbikes = DB::table('tbl_motorbikes')
                     ->leftJoin('tbl_users', 'tbl_users.user_id', '=', 'tbl_motorbikes.motorbike_assigned_to')
                     ->select('tbl_motorbikes.*', 'tbl_users.user_email')
                     ->get();

        for ($s=0; $s <count($users) ; $s++) 
        { 
            for ($d=0; $d <count($motorbikes) ; $d++) 
            { 
                if ($users[$s]->email == $motorbikes[$d]->user_email) 
                {
                    $motor = new Motor();
                    $motor->product_id = 5;
                    $motor->name = $motorbikes[$d]->motorbike_name;
                    $motor->chassis_number = $motorbikes[$d]->motorbike_serialnumber;
                    $motor->mileage = $motorbikes[$d]->motorbike_mileage;
                    $motor->type = $motorbikes[$d]->device_type;
                    $motor->color = $motorbikes[$d]->motorbike_color;
                    $motor->engine = $motorbikes[$d]->motorbike_engine;
                    $motor->model = $motorbikes[$d]->motorbike_make;
                    $motor->reg_no = $motorbikes[$d]->motorbike_registration;
                    $motor->build_year = $motorbikes[$d]->motorbike_build_year;
                    $motor->last_maintenance = $motorbikes[$d]->date_maintanence;
                    $motor->supplier = $motorbikes[$d]->supplier_name;
                    $motor->date_assigned = $motorbikes[$d]->motorbike_date_assigned;
                    $motor->date_purchased = $motorbikes[$d]->date_purchased;
                    $motor->additional_info = $motorbikes[$d]->motorbike_condition;
                    $motor->assigned_to =$users[$s]->id;
                    $motor->assigned_by = 179;
                    $motor->save();
                }
            }
        }
    }
}