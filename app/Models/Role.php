<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    const SUPER_ADMIN = 1;
    const VENDOR = 2;
    const ROLE_PREFIX = 'role';
    public function admin(){
        return $this->hasMany(Admin::class);
    }

    public function getAllRoles()
    {
        return Role::paginate(15);
    }

    public function getAllVendorRoles()
    {
        return Role::where('level', '<>' , Role::SUPER_ADMIN)->get();
    }

    public function createRole($request){
        $role = new Role();
        $role->role_title = $request->role_title;
        $role->role_description = $request->role_description;
        $role->level = ($request->for_admins) ? self::SUPER_ADMIN : self::VENDOR;
        return $role->save();
    }

    public function updateRole($id,$request){
        $role = Role::find($id);
        $role->role_title = $request->role_title;
        $role->role_description = $request->role_description;
        $role->level = ($request->for_admins) ? self::SUPER_ADMIN : self::VENDOR;
        return $role->save();
    }
}
