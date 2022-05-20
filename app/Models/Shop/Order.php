<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'cart_id',
        'customer_id',
        'location',
        'city',
        'county',
        'payment',
        'date',
        'outpost',
        'bid_number',
       ];

    public static function getAllBids()
    {
        return DB::table('orders')
                ->join('carts', 'carts.cart_id', '=', 'orders.cart_id' )
                ->join('products', 'products.product_id', '=', 'carts.product_id' )
                ->join('users', 'users.id', '=', 'products.officer')
                ->join('outposts', 'outposts.outpost_id', '=', 'products.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->join('categories', 'categories.category_id', '=', 'products.category')
                ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                ->select(
                    'carts.*',
                    'orders.*',
                    'products.slug',
                    'products.images',
                    'products.reg_no',
                    'products.loan_balance',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'products.product_name',
                    'users.name as user_name',
                    'products.disposal_price',
                    'carts.created_at as bid_date',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                )
                ->orderBy('order_id', 'DESC')
                ->get();
    }

    public static function getBidsByProduct($product)
    {
        return DB::table('orders')
                ->join('carts', 'carts.cart_id', '=', 'orders.cart_id' )
                ->join('products', 'products.product_id', '=', 'carts.product_id' )
                ->join('users', 'users.id', '=', 'products.officer')
                ->join('outposts', 'outposts.outpost_id', '=', 'products.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->join('categories', 'categories.category_id', '=', 'products.category')
                ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                ->select(
                    'carts.*',
                    'orders.*',
                    'products.slug',
                    'products.images',
                    'products.reg_no',
                    'products.loan_balance',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'products.product_name',
                    'users.name as user_name',
                    'products.disposal_price',
                    'carts.created_at as bid_date',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                )
                ->where([
                    'orders.product' => $product, 
                    ])
                ->orderBy('order_id', 'DESC')
                ->get();
    }

    public static function getDistinctUserBids()
    {
        $products = Product::getDistinctProducts();
        for ($s=0; $s <count($products) ; $s++) { 
            $products[$s]->data = Product::getProductById($products[$s]->product);
            $products[$s]->count = Order::where('product', $products[$s]->product)->count();
        }
        return $products;
    }

    public static function getUserBids($user_id)
    {
        return DB::table('orders')
                ->join('carts', 'carts.cart_id', '=', 'orders.cart_id' )
                ->join('products', 'products.product_id', '=', 'carts.product_id' )
                ->join('categories', 'categories.category_id', '=', 'products.category')
                ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                ->select(
                    'carts.*',
                    'orders.*',
                    'products.slug',
                    'products.images',
                    'products.product_name',
                    'products.disposal_price',
                    'carts.created_at as bid_date',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                )
                ->where([
                    'orders.customer_id' => $user_id, 
                    ])
                ->get();
    }

    public static function getBidById($id)
    {
        return DB::table('orders')
                 ->join('carts', 'carts.cart_id', '=', 'orders.cart_id' )
                 ->join('products', 'products.product_id', '=', 'carts.product_id' )
                 ->join('users', 'users.id', '=', 'products.officer')
                 ->join('outposts', 'outposts.outpost_id', '=', 'products.outpost')
                 ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                 ->join('categories', 'categories.category_id', '=', 'products.category')
                 ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                 ->select(
                    'carts.*',
                    'orders.*',
                    'products.slug',
                    'products.images',
                    'products.reg_no',
                    'products.loan_balance',
                    'products.loan_amount',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'products.product_name',
                    'users.name as user_name',
                    'products.disposal_price',
                    'carts.created_at as bid_date',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                  )
                 ->where([
                    'orders.order_id' => $id, 
                    ])
                ->get();
    }
}