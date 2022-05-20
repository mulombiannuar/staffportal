<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, 
        Sluggable;
    
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'slug',
       ];
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'product_name'
            ]
        ];
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public static function getProductById($id)
    {
        return DB::table('products')
                  ->join('users', 'users.id', '=', 'products.officer')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'users.name as user_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                   )
                   ->where('product_id', $id)
                  ->first();
    }

    public static function getProductBySlug($slug)
    {
        return DB::table('products')
                  ->join('users', 'users.id', '=', 'products.officer')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'users.name as user_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                   )
                   ->where('slug', $slug)
                  ->get();
    }

    public static function searchProductByQuery($query)
    {
        return DB::table('products')
                ->join('users', 'users.id', '=', 'products.officer')
                ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->join('categories', 'categories.category_id', '=', 'products.category')
                ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'users.name as user_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                )
                ->where('product_name', 'LIKE', "%{$query}%")
                ->orWhere('color', 'LIKE', "%{$query}%")
                ->orWhere('engine', 'LIKE', "%{$query}%")
                ->orWhere('color', 'LIKE', "%{$query}%")
                ->orWhere('motor_types.name', 'LIKE', "%{$query}%")
                ->orWhere('categories.name', 'LIKE', "%{$query}%")
                ->orderBy('product_name', 'asc')
                ->get();
    }

    public static function getProducts()
    {
        return DB::table('products')
                  ->join('users', 'users.id', '=', 'products.officer')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'users.name as user_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                   )
                  ->orderBy('product_id', 'desc')
                  ->get();
    }

    public static function getProductsByCategory($category)
    {
        return DB::table('products')
                  ->join('users', 'users.id', '=', 'products.officer')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                    'users.name as user_name',
                   )
                  ->where(['categories.name' => $category, 'products.status' => 1])
                  ->orderBy('product_id', 'desc')
                  ->get();
    }

    public static function getProductsByStatus($status)
    {
        return DB::table('products')
                  ->join('users', 'users.id', '=', 'products.officer')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'users.name as user_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                   )
                  ->where('products.status', $status)
                  ->orderBy('product_id', 'desc')
                  ->paginate(12);
    }

    public static function getBranchProducts($id)
    {
        return DB::table('products')
                  ->join('users', 'users.id', '=', 'products.officer')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->join('categories', 'categories.category_id', '=', 'products.category')
                  ->join('motor_types', 'motor_types.type_id', '=', 'products.type')
                  ->select(
                    'products.*',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'users.name as user_name',
                    'motor_types.name as type_name',
                    'categories.name as category_name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public static function getDistinctProducts()
    {
        return DB::table('orders')->select('product')->distinct('product')->get();
    }
    
}