<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Desktops', 
            'Laptops', 
            'Mobile Phones',
            'Modems',
            'Motorbikes',
            'Printers',
            'Routers',
            'Scanners',
            'Switches',
            'UPS'
        ];

        for ($s=0; $s <count($names) ; $s++) 
        { 
            DB::table('asset_types')->insert([
                'asset_name' => $names[$s],
                'created_at' => Carbon::now()
            ]);
        }
    }
}