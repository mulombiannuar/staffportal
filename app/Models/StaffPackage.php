<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StaffPackage extends Model
{
    use HasFactory;
    protected $table = 'staff_packages';
    protected $primaryKey = 'staff_id';

    public static function getPackageById($id)
    {
        return  DB::table('staff_packages')
                  ->join('users', 'users.id', '=', 'staff_packages.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('cvp_products', 'cvp_products.product_id', '=', 'staff_packages.product')
                  ->join('cvp_packages', 'cvp_packages.product', '=', 'cvp_products.product_id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->where('staff_id', $id)
                  ->select(
                        'staff_packages.*', 
                        'cvp_products.*',
                        'cvp_packages.*',
                        'outposts.outpost_name',
                        'outposts.outpost_id',
                        'branches.branch_name',
                        'branches.branch_id',
                        'users.name as staff_name', 
                        )
                  ->first();
    }

    public static function getAllPackagesUsers()
    {
        $staffPackage = new StaffPackage();
        $users =  DB::table('staff_packages')
                  ->join('users', 'users.id', '=', 'staff_packages.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('cvp_products', 'cvp_products.product_id', '=', 'staff_packages.product')
                  ->join('cvp_packages', 'cvp_packages.package_id', '=', 'staff_packages.package')
                  ->select(
                      'staff_packages.*', 
                      'cvp_products.*',
                      'cvp_packages.*',
                      'outposts.outpost_name',
                      'users.name as staff_name', 
                      )
                  ->orderBy('staff_id', 'desc')
                  ->get();
        $staffPackage->getPackagesAttributes($users);
        return $users;
    }

    public static function getPackagesAttributes($users)
    {
        for ($s=0; $s <count($users) ; $s++) 
        { 
            if ($users[$s]->product == 1 || $users[$s]->product == 3) {
                $users[$s]->staff_mobile = User::find($users[$s]->user_id)->profile->mobile_no;
            }

            if ($users[$s]->product == 2 || $users[$s]->product == 4) {
                $users[$s]->staff_mobile = User::find($users[$s]->user_id)->phone
                                        ?  User::find($users[$s]->user_id)->phone->phone_number 
                                        : 'null';
            }

            if ($users[$s]->product == 5) {
                $users[$s]->staff_mobile = User::find($users[$s]->user_id)->modem
                                        ?  User::find($users[$s]->user_id)->modem->phone_number 
                                        : 'null';
            }
        }
        return $users;
    }

    public static function getUsersByProductId($product_id)
    {
        if ($product_id == 1 OR $product_id == 3)  #CVP Staff Airtime #CVP Staff Data
        {
            $users = DB::table('staff_packages')
                        ->join('users', 'users.id', '=', 'staff_packages.user_id')
                        ->join('profiles', 'profiles.user_id', '=', 'users.id')
                        ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                        ->join('cvp_products', 'cvp_products.product_id', '=', 'staff_packages.product')
                        ->join('cvp_packages', 'cvp_packages.package_id', '=', 'staff_packages.package')
                        ->select(
                            'staff_packages.*', 
                            'cvp_packages.*',
                            'outposts.outpost_name',
                            'cvp_products.type',
                            'users.name as staff_name', 
                            'profiles.mobile_no as staff_mobile', 
                            )
                        ->where('staff_packages.product', $product_id)
                        ->orderBy('staff_id', 'desc')->get();
        }
        elseif ($product_id == 2 OR $product_id == 4)  #CVP Tablet Airtime #CVP Tablet Data
        {
             $users = DB::table('staff_packages')
                        ->join('users', 'users.id', '=', 'staff_packages.user_id')
                        ->join('phones', 'phones.assigned_to', '=', 'users.id')
                        ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                        ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                        ->join('cvp_products', 'cvp_products.product_id', '=', 'staff_packages.product')
                        ->join('cvp_packages', 'cvp_packages.package_id', '=', 'staff_packages.package')
                        ->select(
                            'staff_packages.*', 
                            'cvp_packages.*',
                            'outposts.outpost_name',
                            'cvp_products.type',
                            'phones.phone_number as staff_mobile',
                            'users.name as staff_name',
                        )
                        ->where('staff_packages.product', $product_id)
                        ->orderBy('staff_id', 'desc')->get();
        }
        else  #CVP Modem Data
        {
            $users = DB::table('staff_packages')
                        ->join('users', 'users.id', '=', 'staff_packages.user_id')
                        ->join('modems', 'modems.assigned_to', '=', 'users.id')
                        ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                        ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                        ->join('cvp_products', 'cvp_products.product_id', '=', 'staff_packages.product')
                        ->join('cvp_packages', 'cvp_packages.package_id', '=', 'staff_packages.package')
                        ->select(
                            'staff_packages.*', 
                            'cvp_packages.*',
                            'cvp_products.type',
                            'outposts.outpost_name',
                            'modems.phone_number as staff_mobile',
                            'users.name as staff_name',
                        )
                        ->where('staff_packages.product', $product_id)
                        ->orderBy('staff_id', 'desc')->get();
        }
        return $users;
    }

    public function getJoiningTableAttributes($product_id)
    {
        $attributes = [
            'joiningTable' => 'users',
            'joiningColumn' => 'id',
        ];
       
        if ($product_id == 1 OR $product_id == 3){
            $attributes = [
                'joiningTable' => 'users',
                'joiningColumn' => 'id',
            ];
        } 
        if ($product_id == 2 OR $product_id == 4){
            $attributes = [
                'joiningTable' => 'phones',
                'joiningColumn' => 'assigned_to',
            ];
        }
        if ($product_id == 3){
            $attributes = [
                'joiningTable' => 'modems',
                'joiningColumn' => 'assigned_to',
            ];
        }
       
        return $attributes;
    }
}