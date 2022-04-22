<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
///use App\Models\Shop\Category;
use App\Models\Shop\Product;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'category_id');
    }

    public static function getCategories()
    {
       $category = new Category;
       $categories = $category->categories();
       for ($i=0; $i <count($categories) ; $i++) { 
          $categories[$i]->count = count(Product::where('category', $categories[$i]->category_id)->get());
       }
       return $categories;
    }

    public function categories()
    {
       return DB::table('categories')
                ->orderBy('name', 'asc')
                ->get();
    }

}