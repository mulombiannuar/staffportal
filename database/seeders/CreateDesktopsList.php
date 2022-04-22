<?php

namespace Database\Seeders;

use App\Models\Products\Desktop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class CreateDesktopsList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::get();
        $desktops = DB::table('tbl_desktops')
                       ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_desktops.desktop_assigned_to')
                       ->select('tbl_desktops.*', 'tbl_users.user_email')
                       ->get();

        for ($s=0; $s <count($users) ; $s++) 
        { 
            for ($d=0; $d <count($desktops) ; $d++) 
            { 
                if ($users[$s]->email == $desktops[$d]->user_email) 
                {
                    $desktop = new Desktop;
                    $desktop->product_id = 1;
                    $desktop->name = $desktops[$d]->desktop_name;
                    $desktop->manufacturer =$desktops[$d]->desktop_manufacturer;
                    $desktop->model =$desktops[$d]->desktop_model;
                    $desktop->serial_number =$desktops[$d]->desktop_serialnumber;
                    $desktop->operating_system =$desktops[$d]->desktop_os;
                    $desktop->supplier_name =$desktops[$d]->desktop_supplier;
                    $desktop->os_key =$desktops[$d]->desktop_os_key;
                    $desktop->office_name =$desktops[$d]->desktop_office_name;
                    $desktop->office_key =$desktops[$d]->desktop_office_key;
                    $desktop->processor =$desktops[$d]->desktop_processor;
                    $desktop->keyboard_name =$desktops[$d]->desktop_keyboardname;
                    $desktop->monitor_type =$desktops[$d]->desktop_monitortype;
                    $desktop->monitor_serial =$desktops[$d]->desktop_monitorserialnumber;
                    $desktop->keyboard_serial =$desktops[$d]->desktop_keyboardserial;
                    $desktop->ram =$desktops[$d]->desktop_ram;
                    $desktop->hdd_details =$desktops[$d]->desktop_hdd;
                    $desktop->date_assigned =$desktops[$d]->desktop_date_assigned;
                    $desktop->date_purchased =$desktops[$d]->desktop_date_purchased;
                    $desktop->additional_info =$desktops[$d]->item_status;
                    $desktop->assigned_to = $users[$s]->id;
                    $desktop->assigned_by = 1;
                    $desktop->save();
                }
            }
        }
    }
}