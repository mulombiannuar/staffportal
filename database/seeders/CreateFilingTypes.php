<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateFilingTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'MPESA Loan', 
            'EDMS Loan', 
            'Daraja Bodaboda Loan',
            'Reschedule Loan',
            'Cheque Loan',
            'Cash Loan',
        ];

        for ($s=0; $s <count($names) ; $s++) 
        { 
            DB::table('filing_types')->insert([
                'type_name' => $names[$s],
                'created_by' => 1,
                'created_at' => Carbon::now()
            ]);
        }
    }
}
