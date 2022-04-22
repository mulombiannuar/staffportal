<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaidPackage extends Model
{
    use HasFactory;
    protected $table = 'paid_packages';
    protected $primaryKey = 'paid_id';

    protected $fillable = [
        'staff_id',
        'date',
        'created_by',
    ];

    public function getPaidPackages($date)
    {   
        $packages = $this->paidPackages($date);
        if(count($packages) == 0){
            //return 'Hello paidPackages';
            return $this->createPaidPackage($date);
        }
        if (strtotime(date('Y-m-d')) == strtotime($date)) {
            return $this->updatePaidPackage($date);
        }
        return $packages;
    }

    private function paidPackages($date)
    {
        //return 'paidPackages($date)';
        $staffPackage = new StaffPackage();
        $users = DB::table('paid_packages')
                  ->join('staff_packages', 'staff_packages.staff_id', '=', 'paid_packages.staff_id')
                  ->join('users', 'users.id', '=', 'staff_packages.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('cvp_products', 'cvp_products.product_id', '=', 'staff_packages.product')
                  ->join('cvp_packages', 'cvp_packages.package_id', '=', 'staff_packages.package')
                  ->select(
                      'staff_packages.*', 
                      'paid_packages.date',
                      'cvp_products.*',
                      'cvp_packages.*',
                      'outposts.outpost_name',
                      'users.name as staff_name', 
                      )
                  ->where('paid_packages.date', $date)
                  ->orderBy('paid_packages.staff_id', 'desc')
                  ->get();
        $staffPackage->getPackagesAttributes($users);
        return $users;
    }

    private function createPaidPackage($date)
    {
      $packages = StaffPackage::getAllPackagesUsers();
       for ($i=0; $i <count($packages) ; $i++) { 
           PaidPackage::create([
               'staff_id' => $packages[$i]->staff_id,
               'created_by' =>  Auth::user()->id,
               'date' => $date
           ]);
       }
       return $this->paidPackages($date);
    }

    private function updatePaidPackage($date)
    {
       PaidPackage::where('date', $date)->delete();
       $packages = StaffPackage::getAllPackagesUsers();
       for ($i=0; $i <count($packages) ; $i++) { 
           PaidPackage::create([
               'staff_id' => $packages[$i]->staff_id,
               'created_by' =>  Auth::user()->id,
               'date' => $date
           ]);
       }
       return $this->paidPackages($date);
    }
    
}