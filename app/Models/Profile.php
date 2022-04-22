<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $primaryKey = 'profile_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public static function getProfileByUserId($user_id)
    {
        return DB::table('profiles')->where('user_id', $user_id)->first();
    }
}