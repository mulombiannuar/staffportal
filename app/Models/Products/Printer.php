<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Printer extends Model
{
    use HasFactory;
    protected $table = 'printers';
    protected $primaryKey = 'printer_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'assigned_to');
    }

    public function getPrinters()
    {
        return DB::table('printers')
                  ->join('users', 'users.id', '=', 'printers.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'printers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name as user_name',
                   )
                  ->orderBy('printer_id', 'desc')
                  ->get();
    }

    public function getBranchPrinters($id)
    {
        return DB::table('printers')
                  ->join('users', 'users.id', '=', 'printers.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'printers.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'users.name',
                   )
                  ->where('branch_id', $id)
                  ->get();
    }

    public function getPrinterById($id)
    {
        return DB::table('printers')
                  ->join('users', 'users.id', '=', 'printers.assigned_to')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'printers.*',
                    'outposts.outpost_name',
                    'outposts.outpost_id',
                    'branches.branch_name',
                    'branches.branch_id',
                    'users.name as user_name',
                   )
                  ->where('printer_id', $id)
                  ->first();
    }
}