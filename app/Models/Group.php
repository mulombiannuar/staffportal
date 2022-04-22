<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use HasFactory;
    
    public static function getGroups()
    {
        return  DB::table('groups')
                   ->leftJoin('branches', 'branches.branch_code', '=', 'groups.OurBranchID')
                   ->orderBy('GroupName', 'asc')
                   ->get();
    }

    public static function getGroupById($GroupID)
    {
        return DB::table('groups')
                  ->where('GroupID', $GroupID)
                  ->leftJoin('branches', 'branches.branch_code', '=', 'groups.OurBranchID')
                  ->first();
    }

    public static function getGroupsByOfficer($officer)
    {
        return  DB::table('groups')
                   ->where('officer1', $officer)
                   ->leftJoin('branches', 'branches.branch_code', '=', 'groups.OurBranchID')
                   ->orderBy('GroupName', 'asc')
                   ->get();
    }
}