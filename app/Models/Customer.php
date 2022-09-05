<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';

    public static function getCustomers()
    {
        return DB::table('customers')
                  ->join('users', 'users.id', '=', 'customers.created_by')
                  ->join('users as officers', 'officers.id', '=', 'customers.officer_id')
                  ->join('customer_campaigns', 'customer_campaigns.campaign_id', '=', 'customers.campaign_id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'customers.outpost_id')
                  ->join('branches', 'branches.branch_id', '=', 'customers.branch_id')
                  ->select(
                    'customers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                    'officers.name as officer_name',
                   )
                  //->orderBy('customer_id', 'desc')
                  ->orderBy('customers.created_at', 'desc')
                  ->get();
    }

    public static function getCustomersByBranch($branch_id)
    {
        return DB::table('customers')
                  ->join('users', 'users.id', '=', 'customers.created_by')
                  ->join('users as officers', 'officers.id', '=', 'customers.officer_id')
                  ->join('customer_campaigns', 'customer_campaigns.campaign_id', '=', 'customers.campaign_id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'customers.outpost_id')
                  ->join('branches', 'branches.branch_id', '=', 'customers.branch_id')
                  ->select(
                    'customers.*',
                    'customer_campaigns.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                    'officers.name as officer_name',
                   )
                  ->where('customers.branch_id', $branch_id)
                  ->orderBy('customers.created_at', 'desc')
                  ->get();
    }

    public static function getCustomersByCampaign($campaign_id)
    {
        return DB::table('customers')
                  ->join('users', 'users.id', '=', 'customers.created_by')
                  ->join('users as officers', 'officers.id', '=', 'customers.officer_id')
                  ->join('customer_campaigns', 'customer_campaigns.campaign_id', '=', 'customers.campaign_id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'customers.outpost_id')
                  ->join('branches', 'branches.branch_id', '=', 'customers.branch_id')
                  ->select(
                    'customers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                    'officers.name as officer_name',
                   )
                  ->where('customers.campaign_id', $campaign_id)
                  ->orderBy('customers.created_at', 'desc')
                  ->get();
    }

    public static function getCustomerById($customer_id)
    {
        return DB::table('customers')
                  ->join('users', 'users.id', '=', 'customers.created_by')
                  ->join('users as officers', 'officers.id', '=', 'customers.officer_id')
                  ->join('customer_campaigns', 'customer_campaigns.campaign_id', '=', 'customers.campaign_id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'customers.outpost_id')
                  ->join('branches', 'branches.branch_id', '=', 'customers.branch_id')
                  ->select(
                    'customers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                    'officers.name as officer_name',
                   )
                  ->where('customer_id', $customer_id)
                  ->first();
    }

}