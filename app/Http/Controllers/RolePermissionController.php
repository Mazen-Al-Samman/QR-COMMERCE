<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = new Role();
        $roles = $role->getAllRoles();
        return view('backend.rolePermission.index',[
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $role_id
     * @return \Illuminate\Http\Response
     */
    public function create($role_id)
    {
        $permission = new Permission();
        $role = Role::find($role_id);
        $permissions = $permission->getUnselectedPermissions();
        $role_permission = new RolePermission();
        $roles_permissions = $role_permission->getAllRolesPermissions();

        return view('backend.rolePermission.create', [
            'role' => $role,
            'permissions' => $permissions,
            'roles_permissions' => $roles_permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $role_id
     * @return \Illuminate\Http\Response
     */
    public function show($role_id)
    {
        $role = Role::find($role_id);
        $rolePermission = new RolePermission();
        $permissions = $rolePermission->getPermissionsByRoleID($role->id);
        return view('backend.rolePermission.view', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $role_id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_id)
    {
        $permissions = DB::table('permissions')
                        ->select(['role_permissions.role_id','role_permissions.permission_id As RolePermission_per_id','permissions.permission','permissions.id AS permission_id','permissions.description'])
            ->leftJoin('role_permissions',function($join) use ($role_id) {
                $join->on('role_permissions.permission_id','=','permissions.id')
                    ->where('role_permissions.role_id',$role_id);
            })->get();

        $role = Role::find($role_id);

        return view('backend.rolePermission.edit',[
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rolePermission = new RolePermission();
        if($rolePermission->UpdateRolePermission($request)) {
            $request->session()->flash('alert-update', 'Process was succeeded!');
            return \redirect()->route('rolePermission.manage',['role_id' => $request->role_id]);
        }
        return new \Exception('an error occurred');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (RolePermission::where(['role_id' => $id])->delete()) {
            $request->session()->flash('alert-delete', 'User was successful deleted!');
            return \redirect()->route('rolePermission.create');
        }
    }
}