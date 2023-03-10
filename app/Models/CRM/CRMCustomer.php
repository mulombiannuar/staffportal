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

}
