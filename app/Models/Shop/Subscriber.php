<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subscriber extends Model
{
    use HasFactory;
    protected $table = 'subscribers';
    protected $primaryKey = 'subscriber_id';

    protected $fillable = [
        'name',
        'email',
    ];

    public static function getSubscribers()
    {
        return DB::table('subscribers')
                  ->orderBy('subscriber_id', 'desc')
                  ->get();
    }
}