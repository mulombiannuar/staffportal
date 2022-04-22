<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Router extends Model
{
    use HasFactory;
    protected $table = 'routers';
    protected $primaryKey = 'router_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getRouters()
    {
        return DB::table('routers')
                  ->join('users', 'users.id', '=', 'routers.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'routers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('router_id', 'desc')
                  ->get();
    }

    public function getBranchRouters($id)
    {
        return DB::table('routers')
                  ->join('users', 'users.id', '=', 'routers.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'routers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public function getRouterById($id)
    {
        return DB::table('routers')
                  ->join('users', 'users.id', '=', 'routers.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'routers.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('router_id', $id)
                  ->first();
    }
}