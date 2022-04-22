<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Desktop extends Model
{
    use HasFactory;
    protected $table = 'desktops';
    protected $primaryKey = 'desktop_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getDesktops()
    {
        return DB::table('desktops')
                  ->join('users', 'users.id', '=', 'desktops.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'desktops.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('desktop_id', 'desc')
                  ->get();
    }

    public function getBranchDesktops($id)
    {
        return DB::table('desktops')
                  ->join('users', 'users.id', '=', 'desktops.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'desktops.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public function getDesktopById($id)
    {
        return DB::table('desktops')
                  ->join('users', 'users.id', '=', 'desktops.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'desktops.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('desktop_id', $id)
                  ->first();
    }

}