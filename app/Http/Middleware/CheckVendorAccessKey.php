<?php

namespace App\Http\Middleware;

use App\Models\Vendor;
use Closure;
use Illuminate\Http\Request;

class CheckVendorAccessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessKey = $request->header('accessKey');
        if ($accessKey && Vendor::where(['access_key' => $accessKey])->exists()) {
            return $next($request);
        }
        return response()->json([
            'status' => false,
            'message' => 'You Dont have Permission !!'
        ]);
    }
}
