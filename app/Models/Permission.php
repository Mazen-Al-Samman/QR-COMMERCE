<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    const ROLE_PREFIX = 'permission';
    use HasFactory;

    public function getAllPermissions()
    {
        return Permission::paginate(15);
    }

    public function getPermissionsWithSelected($role_id)
    {
        return DB::table('permissions')
                    ->select([
                        'role_permissions.role_id',
                        'role_permissions.permission_id As RolePermission_per_id',
                        'permissions.permission',
                        'permissions.id AS permission_id',
                        'permissions.description'
                    ])
                    ->leftJoin('role_permissions', function ($join) use ($role_id) {
                        $join->on('role_permissions.permission_id', '=', 'permissions.id')
                            ->where('role_permissions.role_id', $role_id);
                    })->get();
    }

    public function createPermission($request)
    {
        $permission = new Permission();
        $permission->permission = $request->permission;
        $permission->description = $request->description;
        return $permission->save();
    }

    public function updatePermission($id, $request)
    {
        $permission = Permission::find($id);
        $permission->permission = $request->permission;
        $permission->description = $request->description;
        return $permission->save();
    }

}
