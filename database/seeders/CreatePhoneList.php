<?php

namespace Database\Seeders;

use App\Models\Products\Phone;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePhoneList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $phones = DB::table('tbl_mobile_phones')
                     ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_mobile_phones.assigned_to')
                     ->select('tbl_mobile_phones.*', 'tbl_users.user_email')
                     ->get();

        for ($s=0; $s <count($users) ; $s++) 
        { 
            for ($d=0; $d <count($phones) ; $d++) 
            { 
                if ($users[$s]->email == $phones[$d]->user_email) 
                {
                    $phone = new Phone();
                    $phone->product_id = 3;
                    $phone->name = $phones[$d]->phone_device_name;
                    $phone->serial_number = $phones[$d]->phone_serial_number;
                    $phone->imei_number = $phones[$d]->phone_imei_number;
                    $phone->phone_number = $phones[$d]->phone_number;
                    $phone->puk_1 = $phones[$d]->phone_puk_1;
                    $phone->puk_2 = $phones[$d]->phone_puk_2;
                    $phone->pin_1 = $phones[$d]->phone_pin_1;
                    $phone->pin_2 = $phones[$d]->phone_pin_2;
                    $phone->date_assigned =$phones[$d]->date_assigned;
                    $phone->date_purchased =$phones[$d]->date_purchased;
                    $phone->additional_info =$phones[$d]->item_status;
                    $phone->assigned_to = $users[$s]->id;
                    $phone->assigned_by = 1;
                    $phone->save();
                }
            }
        }
    }
}