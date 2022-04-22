<?php

namespace Database\Seeders;

use App\Models\Products\Laptop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CreateLaptopsList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $laptops = DB::table('tbl_laptops')
                     ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_laptops.laptop_assigned_to')
                     ->select('tbl_laptops.*', 'tbl_users.user_email')
                     ->get();

        for ($s=0; $s <count($users) ; $s++) 
        { 
            for ($d=0; $d <count($laptops) ; $d++) 
            { 
                if ($users[$s]->email == $laptops[$d]->user_email) 
                {
                    $laptop = new Laptop();
                    $laptop->product_id = 2;
                    $laptop->name = $laptops[$d]->laptop_name;
                    $laptop->manufacturer =$laptops[$d]->laptop_manufacturer;
                    $laptop->model =$laptops[$d]->laptop_model;
                    $laptop->serial_number =$laptops[$d]->laptop_serialnumber;
                    $laptop->operating_system =$laptops[$d]->laptop_os;
                    $laptop->supplier_name =$laptops[$d]->laptop_supplier;
                    $laptop->os_key =$laptops[$d]->laptop_os_key;
                    $laptop->office_name =$laptops[$d]->laptop_office_name;
                    $laptop->office_key =$laptops[$d]->laptop_office_key;
                    $laptop->processor =$laptops[$d]->laptop_processor;
                    $laptop->display =$laptops[$d]->laptop_display;
                    $laptop->ram =$laptops[$d]->laptop_ram;
                    $laptop->hdd_details =$laptops[$d]->laptop_hdd;
                    $laptop->date_assigned =$laptops[$d]->laptop_date_assigned;
                    $laptop->date_purchased =$laptops[$d]->laptop_date_purchased;
                    $laptop->additional_info =$laptops[$d]->item_status;
                    $laptop->assigned_to = $users[$s]->id;
                    $laptop->assigned_by = 1;
                    $laptop->save();
                }
            }
        }
    }
}