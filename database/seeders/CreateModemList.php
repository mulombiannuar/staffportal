<?php

namespace Database\Seeders;

use App\Models\Products\Modem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateModemList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $modems = DB::table('tbl_modems')
                    ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_modems.modem_assigned_to')
                    ->select('tbl_modems.*', 'tbl_users.user_email')
                    ->get();

        for ($s=0; $s <count($users) ; $s++) 
        { 
            for ($d=0; $d <count($modems) ; $d++) 
            { 
                if ($users[$s]->email == $modems[$d]->user_email) 
                {
                    $modem = new Modem();
                    $modem->product_id = 4;
                    $modem->name = $modems[$d]->modem_name;
                    $modem->serial_number = $modems[$d]->modem_serialnumber;
                    $modem->phone_number = $modems[$d]->modem_mobile_no;
                    $modem->date_assigned = $modems[$d]->modem_date_assigned;
                    $modem->date_purchased = $modems[$d]->modem_date_assigned;
                    $modem->additional_info =$modems[$d]->item_status;
                    $modem->assigned_to = $users[$s]->id;
                    $modem->assigned_by = 1;
                    $modem->save();
                }
            }
        }
    }
}