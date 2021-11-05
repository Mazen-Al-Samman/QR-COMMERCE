<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = new Role();
        $roles = $role->getAllRoles();
        return view('backend.rolePermission.index',[
            'roles' => $roles,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $role_id
     * @return \Illuminate\Http\Response
     */
    public function create($role_id)
    {

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
    public function show($role_id, Request $request)
    {
        $role = Role::find($role_id);
        $rolePermission = new RolePermission();
        $permissions = $rolePermission->getPermissionsByRoleID($role->id);
        return view('backend.rolePermission.view', [
            'role' => $role,
            'permissions' => $permissions,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $role_id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_id, Request $request)
    {
        $permission = new Permission();
        $permissions = $permission->getPermissionsWithSelected($role_id);
        $role = Role::find($role_id);

        return view('backend.rolePermission.edit',[
            'role' => $role,
            'permissions' => $permissions,
            'userAuthPermission' => $this->getUserPermissionns($request),
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
            return \redirect()->route('role-permission.manage',['role_id' => $request->role_id]);
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
            return \redirect()->route('role-permission.create');
        }
    }
}
