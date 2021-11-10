<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    const ROLE_PREFIX = 'role-permission';

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    public function getAllRolesPermissions()
    {
        return RolePermission::all();
    }


    public function updateRolePermission($request) {
        RolePermission::where(['role_id' => $request->role_id])->delete();
        $status = true;
        if($request->permissions) {
            foreach ($request->permissions as $permission) {
                $rolePermission = new RolePermission();
                $rolePermission->role_id = $request->role_id;
                $rolePermission->permission_id = $permission;
                if (!$rolePermission->save())
                    $status = false;
            }
        }
        return $status;
    }

    public function getPermissionsByRoleID($role_id){
        return RolePermission::where(['role_id' => $role_id])->get();
    }
}
