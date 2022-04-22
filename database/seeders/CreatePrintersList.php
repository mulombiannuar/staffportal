<?php

namespace Database\Seeders;

use App\Models\Products\Printer;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePrintersList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $printers = DB::table('tbl_printers')
                   // ->join('tbl_users', 'tbl_users.user_id', '=', 'tbl_printers.printer_assigned_to')
                    //->select('tbl_printers.*', 'tbl_users.user_email')
                    ->get();

        //for ($s=0; $s <count($users) ; $s++) 
        //{ 
            for ($d=0; $d <count($printers) ; $d++) 
            { 
                // if ($users[$s]->email == $printers[$d]->user_email) 
                // {
                    $printer = new Printer();
                    $printer->product_id = 6;
                    $printer->name = $printers[$d]->printer_name;;
                    $printer->serial_number = $printers[$d]->printer_serialnumber;
                    $printer->ip_address = $printers[$d]->printer_ip_address;
                    $printer->supplier = $printers[$d]->printer_supplier;
                    $printer->date_assigned = $printers[$d]->printer_creation_date;
                    $printer->date_purchased = $printers[$d]->printer_date_purchased;
                    $printer->additional_info = $printers[$d]->printer_date_purchased;
                    $printer->assigned_to =  Profile::where('outpost', $printers[$d]->printer_outpost_id)->first()->user_id;
                    $printer->assigned_by = 11;
                    $printer->save();
                // }
            }
       // }
    }
}