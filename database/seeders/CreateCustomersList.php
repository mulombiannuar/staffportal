<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateCustomersList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::getUsers();
        $customers = DB::table('tbl_promotion_clients')
                     ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_promotion_clients.officer_id')
                     ->select('tbl_promotion_clients.*', 'tbl_users.user_email')
                     ->where('promotion_id', 5) ###MUSYI
                     ->get();

        for ($s=0; $s <count($users) ; $s++) 
        { 
            for ($d=0; $d <count($customers) ; $d++) 
            { 
                if ($users[$s]->email == $customers[$d]->user_email) 
                {
                    $customer = new Customer();
                    $customer->campaign_id = 4;
                    $customer->officer_id = $users[$s]->id;
                    $customer->customer_name = $customers[$d]->client_name;
                    $customer->customer_phone = $customers[$d]->client_phone;
                    $customer->residence = $customers[$d]->residence;
                    $customer->business = $customers[$d]->business;
                    $customer->customer_message = $customers[$d]->client_message;
                    $customer->has_activated = $customers[$d]->has_activated;
                    $customer->officer_message = $customers[$d]->officer_message;
                    $customer->responder_id = $users[$s]->id;
                    $customer->issue_sorted =$customers[$d]->issue_sorted;
                    $customer->admin_message = 'Admin has not entered her message';
                    $customer->branch_id =$users[$s]->branch;
                    $customer->outpost_id =$users[$s]->outpost;
                    $customer->created_by = 179;
                    $customer->created_at =$customers[$d]->creation_date;
                    $customer->updated_at =$customers[$d]->updation_date;
                    $customer->save();
                }
            }
        }
    }
}