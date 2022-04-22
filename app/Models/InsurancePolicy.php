<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InsurancePolicy extends Model
{
    use HasFactory;
    protected $table = 'insurance_policies';
    protected $primaryKey = 'policy_id';

    public static function getInsuranceCompanies()
    {
        return  DB::table('insurance_companies')->orderBy('company_name', 'asc')->get();
    }

    public static function getInsuranceProducts()
    {
        return  DB::table('insurance_products')->orderBy('product_name', 'asc')->get();
    }

    public static function getInsuranceProductById($id)
    {
        return  DB::table('insurance_products')->where('product_id', $id)->first();
    }

    public static function getInsurancePolicyById($id)
    {
        return  DB::table('insurance_policies')
                  ->leftJoin('users', 'users.id', '=', 'insurance_policies.officer')
                  ->leftJoin('insurance_products', 'insurance_products.product_id', '=', 'insurance_policies.product')
                  ->leftJoin('insurance_companies', 'insurance_companies.co_id', '=', 'insurance_policies.company')
                  ->leftJoin('outposts', 'outposts.outpost_id', '=', 'insurance_policies.outpost')
                  ->leftJoin('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->where('policy_id', $id)
                  ->first();
    }

    public static function getInsurancePolicies()
    {
        return  DB::table('insurance_policies')
                  ->orderBy('policy_id', 'desc')
                  ->leftJoin('users', 'users.id', '=', 'insurance_policies.officer')
                  ->leftJoin('insurance_products', 'insurance_products.product_id', '=', 'insurance_policies.product')
                  ->leftJoin('insurance_companies', 'insurance_companies.co_id', '=', 'insurance_policies.company')
                  ->leftJoin('outposts', 'outposts.outpost_id', '=', 'insurance_policies.outpost')
                //   ->leftJoin('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                      'insurance_policies.*',
                      'insurance_products.product_name',
                      'insurance_companies.company_name',
                      'outposts.outpost_name',
                      'users.name',
                      )
                  ->get();
    }

    public static function getInsurancePoliciesReport($date_issued, $date_expired, $report_type)
    {
        if ($report_type == 'all'){
            return  DB::table('insurance_policies')
                    ->orderBy('policy_id', 'desc')
                    ->leftJoin('users', 'users.id', '=', 'insurance_policies.officer')
                    ->leftJoin('insurance_products', 'insurance_products.product_id', '=', 'insurance_policies.product')
                    ->leftJoin('insurance_companies', 'insurance_companies.co_id', '=', 'insurance_policies.company')
                    ->leftJoin('outposts', 'outposts.outpost_id', '=', 'insurance_policies.outpost')
                    ->where('date_issued', '>=', $date_issued)
                    ->where('date_expired', '<=', $date_expired)
                    ->select(
                        'insurance_policies.*',
                        'insurance_products.product_name',
                        'insurance_companies.company_name',
                        'outposts.outpost_name',
                        'users.name',
                        )
                    ->get();
        }
        else{
            return  DB::table('insurance_policies')
                      ->orderBy('policy_id', 'desc')
                      ->leftJoin('users', 'users.id', '=', 'insurance_policies.officer')
                      ->leftJoin('insurance_products', 'insurance_products.product_id', '=', 'insurance_policies.product')
                      ->leftJoin('insurance_companies', 'insurance_companies.co_id', '=', 'insurance_policies.company')
                      ->leftJoin('outposts', 'outposts.outpost_id', '=', 'insurance_policies.outpost')
                      ->where('status', $report_type)
                      ->where('date_issued', '>=', $date_issued)
                      ->where('date_expired', '<=', $date_expired)
                      ->select(
                        'insurance_policies.*',
                        'insurance_products.product_name',
                        'insurance_companies.company_name',
                        'outposts.outpost_name',
                        'users.name',
                        )
                      ->get();
        }
    }

    public static function getInsurancePolicyByRefNumber($reference)
    {
        return  DB::table('insurance_policies')
                  ->leftJoin('users', 'users.id', '=', 'insurance_policies.officer')
                  ->leftJoin('insurance_products', 'insurance_products.product_id', '=', 'insurance_policies.product')
                  ->leftJoin('insurance_companies', 'insurance_companies.co_id', '=', 'insurance_policies.company')
                  ->leftJoin('outposts', 'outposts.outpost_id', '=', 'insurance_policies.outpost')
                  ->leftJoin('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->where('reference', $reference)
                  ->first();
    }

    public static function updatePolicyStatus($policy_id, $status)
    {
        return  DB::table('insurance_policies')
                  ->where('policy_id', $policy_id)
                  ->update(['status' => $status]);
    }
}