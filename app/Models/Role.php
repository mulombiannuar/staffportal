<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $guarded = [];
    public function getUserRoles($id)
    {
        return DB::table('role_user')
                  ->where('user_id', $id)
                  ->join('roles', 'roles.id', '=', 'role_user.role_id')
                  ->get();
    }

    public function getUsersWithRoles()
    {
        $users = User::where('accessibility', 1)->orderBy('name', 'asc')->get();
        for ($s=0; $s <count($users) ; $s++) 
        { 
            $users[$s]->roles = $this->getUserRoles($users[$s]->id);
        }
        return $users;
    }

    public static function getRolePermissions($id)
    {
        return DB::table('permission_role')
                  ->where('role_id', $id)
                  ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                  ->get();
    }

}