<?php

namespace Database\Seeders;

use App\Models\AssignedAsset;
use App\Models\Products\Motor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateMotorsListReassigned extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motors = Motor::get();
        $logs = DB::table('tbl_motorbikes_reassigned')
                    ->leftJoin('tbl_motorbikes', 'tbl_motorbikes.motorbike_id', '=', 'tbl_motorbikes_reassigned.motobike_id')
                    ->select('tbl_motorbikes_reassigned.*', 'tbl_motorbikes.motorbike_registration')
                    ->get();
        
        for ($s=0; $s <count($motors) ; $s++) { 
            for ($l=0; $l <count($logs) ; $l++) { 
                if ($motors[$s]->reg_no == $logs[$l]->motorbike_registration) {
                    $asset = new AssignedAsset();
                    $asset->previous_user = 179;
                    $asset->current_user = $motors[$s]->assigned_to;
                    $asset->asset_id = $motors[$s]->motor_id;
                    $asset->product_id = 5;
                    $asset->date_assigned = $logs[$l]->date_reassigned;
                    $asset->message = $logs[$l]->reassigned_status;
                    $asset->assigned_by = 179;
                    $asset->save();
                }
            }
        }
    }
}