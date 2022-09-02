<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCampaign extends Model
{
    use HasFactory;
    protected $table = 'customer_campaigns';
    protected $primaryKey = 'campaign_id';

    public static function getCampaigns()
    {
        $campaigns = CustomerCampaign::orderBy('campaign_id', 'desc')->get();
        for ($s=0; $s <count($campaigns) ; $s++) 
        { 
            $campaigns[$s]->count = Customer::where('campaign_id', $campaigns[$s]->campaign_id)->count();
        }
        return $campaigns;
    }
}