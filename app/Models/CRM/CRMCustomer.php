<?php

namespace App\Models\CRM;

use App\Models\Records\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CRMCustomer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'crm_customers';
    protected $primaryKey = 'customer_id';

    public static function getCustomerByMobileNumber($customer_phone)
    {
        return CRMCustomer::where('customer_phone', $customer_phone)->first();
    }

    public static function getClientByMobileNumber($client_phone)
    {
        return DB::table('clients')->where(['client_phone'=> $client_phone, 'outpost_client' => 1])->first();
    }

    public static function getCustomers()
    {
        return CRMCustomer::join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
        ->select('crm_customers.*', 'outpost_name')
        ->orderBy('customer_id', 'desc')
        ->get();
    }

    public static function getCustomerById($customer_id)
    {
        return CRMCustomer::join('outposts', 'outposts.outpost_id', '=', 'crm_customers.outpost_id')
        ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
        ->select('crm_customers.*', 'outpost_name', 'branch_name')
        ->where('customer_id', $customer_id)
        ->first();
    }

}
