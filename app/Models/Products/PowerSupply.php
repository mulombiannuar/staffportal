<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PowerSupply extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'power_supplies';
    protected $primaryKey = 'ups_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getPowerSupplies()
    {
        return DB::table('power_supplies')
                ->join('users', 'users.id', '=', 'power_supplies.assigned_to')
                ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'power_supplies.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                )
                ->orderBy('ups_id', 'desc')
                ->get();
    }

    public function getBranchPowerSupplies($id)
    {
        return DB::table('power_supplies')
                ->join('users', 'users.id', '=', 'power_supplies.assigned_to')
                ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'power_supplies.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                )
                ->where('branch_id', $id)
                ->get();
    }

    public function getPowerSupplyById($id)
    {
        return DB::table('power_supplies')
                ->join('users', 'users.id', '=', 'power_supplies.assigned_to')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'power_supplies.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                )
                ->where('ups_id', $id)
                ->first();
    }
}