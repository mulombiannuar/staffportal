<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWorkflowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workflows = [
            ['name' => 'Communication Officer', 'max_days' => 1, 'escalation_period' => 30],
            ['name' => 'Chief Executive Officer', 'max_days' => 1, 'escalation_period' => 30],
            ['name' => 'General Manager', 'max_days' => 1, 'escalation_period' => 30],
            ['name' => 'Senior Managers', 'max_days' => 1, 'escalation_period' => 30],
            ['name' => 'Branch Manager', 'max_days' => 1, 'escalation_period' => 30],
            ['name' => 'Credit Officer', 'max_days' => 1, 'escalation_period' => 30],
            ['name' => 'Receptionist', 'max_days' => 1, 'escalation_period' => 30],
        ];

        DB::table('crm_workflows')->truncate();

        for ($s=0; $s <count($workflows) ; $s++) 
        { 
            DB::table('crm_workflows')->insert([
                'name' => $workflows[$s]['name'],
                'max_days' => $workflows[$s]['max_days'],
                'escalation_period' => $workflows[$s]['escalation_period'],
                'created_at' => now()
            ]);
        }
    }
}
