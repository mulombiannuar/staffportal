<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Phone extends Model
{
    use HasFactory;
    protected $table = 'phones';
    protected $primaryKey = 'phone_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getPhones()
    {
        return DB::table('phones')
                  ->join('users', 'users.id', '=', 'phones.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'phones.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('phone_id', 'desc')
                  ->get();
    }

    public static function getUserPhones($user_id)
    {
        return DB::table('phones')
                  ->join('users', 'users.id', '=', 'phones.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'phones.*',
                    'phones.name as device_name',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                   )
                  ->where('assigned_to', $user_id)
                  ->get();
    }

    public function getBranchPhones($id)
    {
        return DB::table('phones')
                  ->join('users', 'users.id', '=', 'phones.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'phones.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'phones.name as device_name',
                    'users.name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public function getOutpostPhones($id)
    {
        return DB::table('phones')
                  ->join('users', 'users.id', '=', 'phones.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'phones.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                    'users.status',
                   )
                  ->where(['outpost_id'=> $id, 'status' => 1])
                  ->get();
    }

    public function getPhoneById($id)
    {
        return DB::table('phones')
                  ->join('users', 'users.id', '=', 'phones.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'phones.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('phone_id', $id)
                  ->first();
    }

}