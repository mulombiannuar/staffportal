<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Modem extends Model
{
    use HasFactory;
    protected $table = 'modems';
    protected $primaryKey = 'modem_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getModems()
    {
        return DB::table('modems')
                  ->join('users', 'users.id', '=', 'modems.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'modems.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('modem_id', 'desc')
                  ->get();
    }

    public function getBranchModems($id)
    {
        return DB::table('modems')
                  ->join('users', 'users.id', '=', 'modems.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'modems.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public function getOutpostModems($id)
    {
        return DB::table('modems')
                  ->join('users', 'users.id', '=', 'modems.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'modems.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                    'users.status',
                   )
                  ->where(['outpost_id'=> $id, 'status' => 1])
                  ->get();
    }

    public function getModemById($id)
    {
        return DB::table('modems')
                  ->join('users', 'users.id', '=', 'modems.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'modems.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('modem_id', $id)
                  ->first();
    }
}