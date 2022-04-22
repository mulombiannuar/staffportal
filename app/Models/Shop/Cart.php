<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'product_id',
        'customer_id',
        'customer_name',
        'customer_mobile',
        'bid_amount',
       ];

    public static function getUserCart($user_id, $status)
    {
        return DB::table('carts')
                  ->join('products', 'products.product_id', '=', 'carts.product_id' )
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'carts.*',
                    'products.*',
                    'carts.created_at as bid_date',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                   )
                  ->where([
                      'customer_id' => $user_id, 
                      'carts.status' => $status
                      ])
                  ->get();
    }

    public static function getUserCartTotalSum($user_id, $status)
    {
        return DB::table('carts')
                 ->where([
                    'customer_id' => $user_id, 
                    'carts.status' => $status
                    ])
                  ->sum('bid_amount');
    }
}