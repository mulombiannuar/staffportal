<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DrivingLicense extends Model
{
    use HasFactory;
    protected $table = 'driving_licenses';
    protected $primaryKey = 'license_id';

    public function getLicenses()
    {
        return DB::table('driving_licenses')
                  ->join('motors', 'motors.motor_id', '=', 'driving_licenses.asset_id')
                  ->join('users', 'users.id', '=', 'driving_licenses.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'driving_licenses.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('license_id', 'desc')
                  ->get();
    }

    public function getLicenseById($id)
    {
        return DB::table('driving_licenses')
                  ->join('motors', 'motors.motor_id', '=', 'driving_licenses.asset_id')
                  ->join('users', 'users.id', '=', 'driving_licenses.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'driving_licenses.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('license_id', $id)
                  ->first();
    }

    public function getLicensesByAssetId($id)
    {
        return DB::table('driving_licenses')
                  ->join('motors', 'motors.motor_id', '=', 'driving_licenses.asset_id')
                  ->join('users', 'users.id', '=', 'driving_licenses.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'driving_licenses.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('asset_id', $id)
                  ->orderBy('license_id', 'desc')
                  ->get();
    }
}