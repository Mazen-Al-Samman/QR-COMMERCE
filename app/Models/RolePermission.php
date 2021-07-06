<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

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

    public function addRolePermissions($request)
    {
        $status = true;
        if($request->permissions){
            foreach ($request->permissions as $permission) {
                $role_premission = new RolePermission();
                $role_premission->role_id = $request->role_id;
                $role_premission->permission_id = $permission;
                if (!$role_premission->save())
                    $status = false;
            }
        }
        return $status;
    }

    public function getPermissionsByRoleID($role_id){
        return RolePermission::where(['role_id' => $role_id])->get();
    }
}
