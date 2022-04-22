<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = new Role();
        $pageData = [
			'page_name' => 'users',
            'title' => 'User Roles',
            'users' => $role->getUsersWithRoles(),
        ];
        return view('admin.roles_dashboard', $pageData);
    }

    public function rolesManagement()
    {
        $pageData = [
			'page_name' => 'users',
            'title' => 'System Roles Management',
            'roles' => DB::table('roles')->orderBy('name', 'asc')->get(),
        ];
        return view('admin.roles', $pageData);
    }

    public function permissionsManagement()
    {
        $pageData = [
			'page_name' => 'users',
            'title' => 'System Permissions',
            'roles' => DB::table('roles')->orderBy('name', 'asc')->get(),
            'permissions' => DB::table('permissions')->orderBy('name', 'asc')->get(),
        ];
        return view('admin.permissions', $pageData);
    }

     public function usersRolesManagement()
    {
        $role = new Role();
        $pageData = [
			'page_name' => 'users',
            'title' => 'User Roles Management',
            'users' => $role->getUsersWithRoles(),
        ];
        return view('backend.admin.user_roles_management', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('roles')->insert([
            'description' => $request->input('description'),
            'name' => strtolower($request->input('name')),
            'display_name' => $request->input('name'),
            'created_at' => Carbon::now()
        ]);

        //Save audit trail
        $activity_type = 'New Role Creation';
        $description = 'Successfully Created new role '.$request->input('name');
        User::saveAuditTrail($activity_type, $description);
        
        return back()->with('success', 'Role data saved successfully');
    }

    public function storePermission(Request $request)
    {
        
        $permission = new Permission();
        $permission->name =  strtolower($request->input('name'));
        $permission->description =  strtolower($request->input('description'));
        $permission->display_name =   $request->input('name');
        $permission->save();
        
        DB::table('permission_role')->insert([
            'permission_id' => $permission->id,
            'role_id' => strtolower($request->input('role')),
        ]);
        
        //Save audit trail
        $activity_type = 'New Permission Creation';
        $description = 'Successfully Created new permission '.$request->input('name');
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Role data saved successfully');
    }


    public function storeUserRole(Request $request)
    {
        if(empty($request->input('roles')))
        return back()->with('danger', 'You have not selected any role. Please try again');

        $user = User::find($request->input('user_id'));

        //Delete existing role
       // DB::table('role_user')->where('user_id', $request->input('user_id'))->delete();
        $user->syncRoles($request->input('roles'), $request->input('user_id'));

        //Save audit trail
        $activity_type = 'Assigned User Role';
        $description = 'Assigned system roles to  '.$user->name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'User has been succesfully assigned selected roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userRoles($id)
    {
        $role = new Role();
        $user = User::find($id);
        $pageData = [
			'page_name' => 'users',
            'user' => User::find($id),
            'user_roles' => $role->getUserRoles($id),
            'title' => 'Roles : '.ucwords($user->name),
            'roles' => DB::table('roles')->orderBy('name', 'asc')->get(),
        ];
        return view('admin.user_roles', $pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('roles')->where('id', $id)->update([
            'description' => $request->input('description'),
            'name' => strtolower($request->input('name')),
            'display_name' => $request->input('name'),
            'updated_at' => Carbon::now()
        ]);

         //Save audit trail
         $activity_type = 'Role Updation';
         $description = 'Successfully updated role '.$request->input('name');
         User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Role data updated successfully');
    }

    public function updatePermission(Request $request, $id)
    {
        DB::table('permissions')->where('id', $id)->update([
            'description' => $request->input('description'),
            'name' => strtolower($request->input('name')),
            'display_name' => $request->input('name'),
            'updated_at' => Carbon::now()
        ]);

         //Save audit trail
         $activity_type = 'Permission Updation';
         $description = 'Successfully updated permission '.$request->input('name');
         User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Permission data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        DB::table('roles')->where('id', $id)->delete();
        DB::table('role_user')->where('role_id', $id)->delete();

        //Save audit trail
        $activity_type = 'Role Deletion';
        $description = 'Deleted system role '.$role->name.' with all its associations';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Role data deleted successfully with all its relationship');
    }

    public function destroyPermission($id)
    {
        $role = Permission::find($id);
        DB::table('permissions')->where('id', $id)->delete();
        DB::table('permission_user')->where('permission_id', $id)->delete();
        DB::table('permission_role')->where('permission_id', $id)->delete();

        //Save audit trail
        $activity_type = 'Role Deletion';
        $description = 'Deleted system permission '.$role->name.' with all its associations';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Permission data deleted successfully with all its relationship');
    }


    public function deleteUserRole($id)
    {
        DB::table('role_user')->where('id', $id)->delete();
        return back()->with('success', 'User role deleted successfully');
    }

    public function rolePermissions($role_id)
    {
        $pageData = [
			'page_name' => 'users',
            'title' => 'Roles Permissions',
            'role' => Role::find($role_id),
            'permissions' => Role::getRolePermissions($role_id),
        ];
        return view('admin.user_permissions', $pageData);
    }
}