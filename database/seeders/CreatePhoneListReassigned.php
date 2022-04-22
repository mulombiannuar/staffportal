<?php

namespace Database\Seeders;

use App\Models\AssignedAsset;
use App\Models\Products\Phone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePhoneListReassigned extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phones = Phone::get();
        $logs = DB::table('tbl_mobile_phones_reassigned')
                ->join('tbl_mobile_phones', 'tbl_mobile_phones.phone_id', '=', 'tbl_mobile_phones_reassigned.phone_id')
                ->select('tbl_mobile_phones_reassigned.*', 'tbl_mobile_phones.phone_serial_number')
                ->get();

        for ($s=0; $s <count($phones) ; $s++) 
        { 
            for ($l=0; $l <count($logs) ; $l++) 
            { 
                if ($phones[$s]->serial_number == $logs[$l]->phone_serial_number) 
                {
                    $assigned = new AssignedAsset();
                    $assigned->product_id = 3;
                    $assigned->assigned_by = 1;
                    $assigned->asset_id = $phones[$s]->phone_id;
                    $assigned->current_user = $phones[$s]->assigned_to;
                    $assigned->previous_user = 11;
                    $assigned->message = $logs[$l]->reassigned_status;
                    $assigned->date_assigned = $logs[$l]->date_reassigned ;
                    $assigned->save();
                }
            }
        }
    }
}