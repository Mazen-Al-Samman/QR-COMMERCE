<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('backend')->middleware(['web','api'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
    Route::get('/store', [\App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
});
