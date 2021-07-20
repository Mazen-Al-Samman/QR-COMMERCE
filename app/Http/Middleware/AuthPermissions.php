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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $currentAction = Route::current()->getName();
        $permissions = RolePermission::select("permission")->where(['role_id' => Auth::user()->role_id])->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')->get();
        $request->attributes->add(['permissions' => $permissions]);
        if (!$this->hasPermission($permissions, $currentAction)) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }

    public function hasPermission($permissions, $current_action) {
        foreach ($permissions as $permission) {
            if ($permission->permission == $current_action) {
                return true;
            }
        }
        return false;
    }
}
