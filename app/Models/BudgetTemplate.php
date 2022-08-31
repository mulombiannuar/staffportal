<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BudgetTemplate extends Model
{
    use HasFactory;
    protected $table = 'budget_templates';
    protected $primaryKey = 'temp_id';

    public static function getTemplates()
    {
        return DB::table('budget_templates')
                  ->join('users as officers', 'officers.id', '=', 'budget_templates.user_id')
                  ->join('users as creators', 'creators.id', '=', 'budget_templates.created_by')
                  ->join('profiles', 'profiles.user_id', '=', 'officers.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'budget_templates.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'profiles.mobile_no',
                    'officers.name as officer_name',
                    'creators.name as creator_name',
                   )
                  ->orderBy('temp_id', 'desc')
                  ->get();
    }

    public static function getUserTemplates($user_id, $branch_id)
    {
        if ($branch_id == null) {
          $token = ['budget_templates.user_id' => $user_id];
        }else{
          $token = ['branch_id' => $branch_id];
        }  
        return DB::table('budget_templates')
                  ->join('users as officers', 'officers.id', '=', 'budget_templates.user_id')
                  ->join('budget_years', 'budget_years.year_id', '=', 'budget_templates.year')
                  ->join('users as creators', 'creators.id', '=', 'budget_templates.created_by')
                  ->join('profiles', 'profiles.user_id', '=', 'officers.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'budget_years.*',
                    'budget_templates.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'profiles.mobile_no',
                    'officers.name as officer_name',
                    'creators.name as creator_name',
                   )
                  ->where($token)
                  ->orderBy('temp_id', 'desc')
                  ->get();
    }

    public static function getTemplateById($id)
    {
        return DB::table('budget_templates')
                  ->join('users as officers', 'officers.id', '=', 'budget_templates.user_id')
                  ->join('budget_years', 'budget_years.year_id', '=', 'budget_templates.year')
                  ->join('profiles', 'profiles.user_id', '=', 'officers.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'budget_years.*',
                    'budget_templates.*',
                    'outposts.outpost_id',
                    'outposts.outpost_name',
                    'branches.branch_id',
                    'branches.branch_name',
                    'profiles.mobile_no',
                    'officers.name as officer_name',
                   )
                  ->where('temp_id', $id)
                  ->first();
    }

    public static function getTemplateByUserAndYear($user_id, $year)
    {
        return DB::table('budget_templates')
                  ->where(['user_id' => $user_id,'year'=> $year])
                  ->first();
    }

    public static function getBranchTemplates($id)
    {
        return DB::table('budget_templates')
                  ->join('users as officers', 'officers.id', '=', 'budget_templates.user_id')
                  ->join('users as creators', 'creators.id', '=', 'budget_templates.created_by')
                  ->join('profiles', 'profiles.user_id', '=', 'officers.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'budget_templates.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'profiles.mobile_no',
                    'officers.name as officer_name',
                    'creators.name as creator_name',
                   )
                  ->where('branch_id', $id)
                  ->orderBy('temp_id', 'desc')
                  ->get();
    }

    public static function getOutpostTemplates($id)
    {
        return DB::table('budget_templates')
                  ->join('users as officers', 'officers.id', '=', 'budget_templates.user_id')
                  ->join('users as creators', 'creators.id', '=', 'budget_templates.created_by')
                  ->join('profiles', 'profiles.user_id', '=', 'officers.id' )
                  ->join('outposts', 'outposts.outpost_id', '=', 'profiles.outpost')
                  ->join('branches', 'branches.branch_id', '=', 'outposts.outpost_branch_id')
                  ->select(
                    'budget_templates.*',
                    'outposts.outpost_name',
                    'branches.branch_name',
                    'profiles.mobile_no',
                    'officers.name as officer_name',
                    'creators.name as creator_name',
                   )
                  ->where('outpost_id', $id)
                  ->orderBy('temp_id', 'desc')
                  ->get();
    }
    
}