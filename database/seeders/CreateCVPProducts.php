<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateCVPProducts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'CVP Staff Airtime',
                'type' => 'staff airtime',
            ],
            [
                'name' => 'CVP Tablet Data',
                'type' => 'tablet data',
            ],
            [
                'name' => 'CVP Staff Data',
                'type' => 'staff data',
            ],
            [
                'name' => 'CVP Tablet Airtime',
                'type' => 'tablet airtime',
            ],
            [
                'name' => 'CVP Modem Data',
                'type' => 'modem data',
            ],
        ];

        for ($s=0; $s <count($products) ; $s++) 
        { 
            DB::table('cvp_products')->insert([
                 'name' => $products[$s]['name'],
                 'type' => $products[$s]['type'],
            ]);
        }
    }
}