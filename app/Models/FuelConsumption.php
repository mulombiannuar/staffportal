<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FuelConsumption extends Model
{
    use HasFactory;
    protected $table = 'fuel_consumptions';
    protected $primaryKey = 'fuel_id';

    
    public function getConsumptions()
    {
        return DB::table('fuel_consumptions')
                  ->join('motors', 'motors.motor_id', '=', 'fuel_consumptions.asset_id')
                  ->join('users', 'users.id', '=', 'fuel_consumptions.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'fuel_consumptions.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('fuel_id', 'desc')
                  ->get();
    }

    public function getConsumptionById($id)
    {
        return DB::table('fuel_consumptions')
                  ->join('motors', 'motors.motor_id', '=', 'fuel_consumptions.asset_id')
                  ->join('users', 'users.id', '=', 'fuel_consumptions.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'fuel_consumptions.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('fuel_id', $id)
                  ->first();
    }

    public function getConsumptionsByAssetId($id)
    {
        return DB::table('fuel_consumptions')
                  ->join('motors', 'motors.motor_id', '=', 'fuel_consumptions.asset_id')
                  ->join('users', 'users.id', '=', 'fuel_consumptions.user_id')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'motors.*',
                    'fuel_consumptions.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('asset_id', $id)
                  ->orderBy('fuel_id', 'desc')
                  ->get();
    }
}