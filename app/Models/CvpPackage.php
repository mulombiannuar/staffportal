<?php

namespace App\Models;

use App\Models\Products\Modem;
use App\Models\Products\Phone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CvpPackage extends Model
{
    use HasFactory;
    protected $table = 'cvp_packages';
    protected $primaryKey = 'package_id';

    public static function getPackages()
    {
        return  DB::table('cvp_packages')
                  ->join('users', 'users.id', '=', 'cvp_packages.created_by')
                  ->join('cvp_products', 'cvp_products.product_id', '=', 'cvp_packages.product')
                  ->select(
                      'cvp_packages.*', 
                      'cvp_products.*',
                      'users.name as user_name', 
                      )
                  ->orderBy('name', 'desc')->get();
    }

    public static function getProductsDetails()
    {
        $cvp = new CvpPackage();
        return $cvp->getDetails(Admin::getCvpProducts());
    }

    private function getDetails($products)
    {
        for ($s=0; $s <count($products) ; $s++) 
        { 
            //$products[$s]->packages = $cvp->getProductPackages($products[$s]->product_id);
            //$products[$s]->beneficiaries = $cvp->getProductBeneficiaries($products[$s]->product_id);
            $products[$s]->users = StaffPackage::getUsersByProductId($products[$s]->product_id);;
        }
        return $products;
    }

    public function getProductPackages($product_id)
    {
        return  DB::table('cvp_packages')
                  ->where('product', $product_id)
                  ->orderBy('amount', 'asc')
                  ->get();
    }

    public function getProductBeneficiaries($product_id)
    {
        switch ($product_id) 
        {
            case 1:  #CVP Staff Airtime
                $beneficiaries = User::getUsers();
                break;

            case 2:  #CVP Tablet Data
                $phone = new Phone();
                $beneficiaries = $phone->getPhones();
                break;

            case 3:  #CVP Staff Data
                $beneficiaries = User::getUsers();
                break;

            case 4:  #CVP Tablet Airtime
                $phone = new Phone();
                $beneficiaries = $phone->getPhones();
                break;

            case 5:  #CVP Modem Data
                $modem = new Modem();
                $beneficiaries = $modem->getModems();
                break;
            
            default:
                $beneficiaries = User::getUsers();
                break;
                
        }
        return $beneficiaries;
    }

}