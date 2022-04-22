<?php

namespace Database\Seeders;

use App\Models\Products\Swittch;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateSwitchesList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $switches = DB::table('tbl_switches')
                    ->get();
        for ($d=0; $d <count($switches) ; $d++) 
        { 
            $switch = new Swittch();
            $switch->product_id = 9;
            $switch->name = $switches[$d]->switch_name;
            $switch->serial_number = $switches[$d]->switch_serialnumber;
            $switch->model_no = $switches[$d]->model_number;
            $switch->location = $switches[$d]->switch_location;
            $switch->supplier = 'MFI';
            $switch->date_assigned = $switches[$d]->creation_date;
            $switch->date_purchased = $switches[$d]->switch_date_purchased;
            $switch->additional_info = 'Device in good condition';
            $switch->assigned_to = Profile::where('outpost', $switches[$d]->switch_outpost_id)->first()->user_id;
            $switch->assigned_by = 11;
            $switch->save();

        }
    }
}