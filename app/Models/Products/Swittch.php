<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Swittch extends Model
{
    use HasFactory;
    protected $table = 'switches';
    protected $primaryKey = 'switch_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getSwitches()
    {
        return DB::table('switches')
                ->join('users', 'users.id', '=', 'switches.assigned_to')
                ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'switches.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                )
                ->orderBy('switch_id', 'desc')
                ->get();
    }

    public function getBranchSwitches($id)
    {
        return DB::table('switches')
                ->join('users', 'users.id', '=', 'switches.assigned_to')
                ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'switches.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                )
                ->where('branch_id', $id)
                ->get();
    }

    public function getSwitchById($id)
    {
        return DB::table('switches')
                ->join('users', 'users.id', '=', 'switches.assigned_to')
                ->join('profiles', 'profiles.user_id', '=', 'users.id')
                ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                ->select(
                    'switches.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                )
                ->where('switch_id', $id)
                ->first();
    }

}