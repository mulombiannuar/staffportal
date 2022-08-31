<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Motor extends Model
{
    use HasFactory;
    protected $table = 'motors';
    protected $primaryKey = 'motor_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getMotors()
    {
        return DB::table('motors')
                  ->join('users', 'users.id', '=', 'motors.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('motor_id', 'desc')
                  ->get();
    }

    public function getBranchMotors($id)
    {
        return DB::table('motors')
                  ->join('users', 'users.id', '=', 'motors.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'motors.name as device_name',
                    'users.name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public static function getUserMotors($user_id)
    {
        return DB::table('motors')
                  ->join('users', 'users.id', '=', 'motors.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'motors.name as device_name',
                    'users.name',
                   )
                  ->where('assigned_to', $user_id)
                  ->get();
    }

    public function getMotorById($id)
    {
        return DB::table('motors')
                  ->join('users', 'users.id', '=', 'motors.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'profiles.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('motor_id', $id)
                  ->first();
    }
}