<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $guardName = "";
        $route = "";
        if (Auth::guard('web')->check()) {
            $guardName = "web";
            $route = "admin.dashboard";
        } else if (Auth::guard('vendor')->check()) {
            $guardName = "vendor";
            $route = "admin-vendor.dashboard";
        }

        $auth_obj = Auth::guard($guardName)->user();

        $currentAction = Route::current()->getName();
        $permissions = RolePermission::select("permission")->where(['role_id' => $auth_obj->role_id])->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')->get();
        $request->attributes->add(['permissions' => $permissions]);

        if (!$this->hasPermission($permissions, $currentAction)) {
            return redirect()->route($route);
        }

        return $next($request);
    }

    public function hasPermission($permissions, $current_action)
    {
        foreach ($permissions as $permission) {
            if ($permission->permission == $current_action) {
                return true;
            }
        }
        return false;
    }
}
