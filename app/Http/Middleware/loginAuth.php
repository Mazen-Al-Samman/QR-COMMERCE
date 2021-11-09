<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginAuth
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
        if (Auth::guard('web')->check()) {
            return $next($request);
        }
        if (Auth::guard('vendor')->check()) {
            $vendorEndSubscription = Auth::guard('vendor')->user()->vendor->end_subscription;
            if (strtotime($vendorEndSubscription) > strtotime(date('Y-m-d'))) {
                return $next($request);
            }
            return redirect()->route('expired');
        }
        return redirect()->route('login');
    }
}
