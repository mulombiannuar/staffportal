<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCampaign extends Model
{
    use HasFactory;
    protected $table = 'customer_campaigns';
    protected $primaryKey = 'campaign_id';
}