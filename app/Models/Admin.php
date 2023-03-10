<?php

namespace App\Models;

use App\Models\Products\Desktop;
use App\Models\Products\Laptop;
use App\Models\Products\Modem;
use App\Models\Products\Motor;
use App\Models\Products\Phone;
use App\Models\Products\PowerSupply;
use App\Models\Products\Printer;
use App\Models\Products\Router;
use App\Models\Products\Scanner;
use App\Models\Products\Swittch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Print_;

class Admin extends Model
{
    use HasFactory;

    public static function getBranches()
    {
        return  DB::table('branches')->orderBy('branch_name', 'asc')->get();
    }

    public static function getBranchById($id)
    {
        return  DB::table('branches')->where('branch_id', $id)->first();
    }

    public static function getBranchByCode($code)
    {
        return  DB::table('branches')->where('branch_code', $code)->first();
    }


    public static function getOutpostById($id)
    {
        return  DB::table('outposts')->where('outpost_id', $id)->first();
    }

    public static function getOutposts()
    {
        return  DB::table('outposts')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select('outposts.*', 'branches.branch_name')
                  ->orderBy('outpost_branch_id', 'ASC')
                  ->get();
    }

    public static function getOutpostByName($name)
    {
        return  DB::table('outposts')->where('outpost_name', $name)->first();
    }

    public static function getCvpProducts()
    {
        return  DB::table('cvp_products')->orderBy('product_id', 'asc')->get();
    }

    public static function getMotorTypes()
    {
        return  DB::table('motor_types')->orderBy('name', 'asc')->get();
    }

    public static function getAssetsCategories()
    {
        $admin = new Admin();
        $categories = DB::table('asset_types')->get();
        for ($s=0; $s <count($categories) ; $s++) 
        { 
            $categories[$s]->count = $admin->getCategoryCount($categories[$s]->asset_id);
        }
        return $categories;
    }

    private function getCategoryCount($asset_id)
    {
        switch ($asset_id) 
        {
            case 1:
                $count = Desktop::count();
                break;

            case 2:
                $count = Laptop::count();
                break;

            case 3:
                $count = Phone::count();
                break;

            case 4:
                $count = Modem::count();
                break;

            case 5:
                $count = Motor::count();
                break;

            case 6:
                $count = Printer::count();
                break;

            case 7:
                $count = Router::count();
                break;

            case 8:
                $count = Scanner::count();
                break;

            case 9:
                $count = Swittch::count();
                break;

            case 10:
                $count = PowerSupply::count();
                break;
            
            default:
                $count = Desktop::count();
            break;
        }
        return $count;
    }

    public static function getAdmins()
    {
        $users = array(
            array(
                'user_name' => 'Mulombi Anuary',
                'user_phone' => '254703539208'
            ),
            array(
                'user_name' => 'Nicholas Mugo',
                'user_phone' => '254720961661'
            ),
            array(
                'user_name' => 'Marangu Kimathi',
                'user_phone' => '254725493645'
            ), 
            array(
                'user_name' => 'Faith Utuku',
                'user_phone' => '254710802686'
            ), 
            array(
                'user_name' => 'Josphat Njogu',
                'user_phone' => '254715677376'
            )
        );
        return $users;
    }

    public static function getRanProcesses()
    {
        return  DB::table('system_processes')
                  ->join('users', 'users.id', '=', 'system_processes.user')
                  ->orderBy('system_processes.id', 'asc')
                  ->select('users.name as user_name', 'system_processes.*')
                  ->get();
    }

    public static function getSystemProcesses()
    {
        return [
            'Policies Expiration Status',
            // 'Policies Expiration Reminder',
        ];
    }

    public static function getRandomNumbers($min, $max)
    {
        return mt_rand($min, $max); 
    }

    public static function getBudgetYears()
    {
        return  DB::table('budget_years')->orderBy('year_id', 'asc')->get();
    }

    public static function getBudgetYearById($id)
    {
        return  DB::table('budget_years')->where('year_id', $id)->first();
    }

    public static function getLoanProducts()
    {
        return DB::table('loan_products')->where('status', 1)->orderBy('product_name', 'asc')->get();
    }

    public static function getLoanProductById($id)
    {
        return DB::table('loan_products')->where('product_id', $id)->first();
    }

    public static function getLoanProductByCode($product_code)
    {
        return DB::table('loan_products')->where('product_code', $product_code)->first();
    }

    public static function formatMobileNumber($mobile_no)
    {
        return '254'.substr(trim($mobile_no), 1);
    }

  
   
}