<?php

namespace Database\Seeders;

use App\Models\Products\Router;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRoutersList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routers = DB::table('tbl_routers')
                    ->get();
        for ($d=0; $d <count($routers) ; $d++) 
        { 
            $router = new Router();
            $router->product_id = 7;
            $router->name = $routers[$d]->router_name;;
            $router->serial_number = $routers[$d]->router_serialnumber;
            $router->ip_address = '192.168.0.13';
            $router->supplier = 'MFI';
            $router->location = $routers[$d]->router_location;
            $router->date_assigned = $routers[$d]->creation_date;
            $router->date_purchased = $routers[$d]->router_date_purchased;
            $router->additional_info = 'Hello World';
            $router->assigned_to =  Profile::where('branch', $routers[$d]->router_branch_id)->first()->user_id;
            $router->assigned_by = 11;
            $router->save();
        }
    }
}