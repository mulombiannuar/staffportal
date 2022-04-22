<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'sliders';
    protected $primaryKey = 'slider_id';

    public static function geSliders()
    {
       return DB::table('sliders')
                ->join('users', 'users.id', '=', 'sliders.user_id')
                ->orderBy('slider_id', 'desc')
                ->get();
    }

    public static function getSlidersByStatus($status)
    {
       return DB::table('sliders')
                // ->join('users', 'users.id', '=', 'sliders.user_id')
                ->where('sliders.status', $status)
                ->orderBy('slider_id', 'desc')
                ->get();
    }


}