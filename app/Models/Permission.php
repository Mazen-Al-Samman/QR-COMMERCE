<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function createPermission($request)
    {
        $permission = new Permission();
        $permission->permission = $request->permission;
        $permission->description = $request->description;
        return $permission->save();
    }

    public function updatePermission($id,$request)
    {
        $permission = Permission::find($id);
        $permission->permission = $request->permission;
        $permission->description = $request->description;
        return $permission->save();
    }
}
