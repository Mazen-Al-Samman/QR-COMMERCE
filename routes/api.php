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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('backend')->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/show/{id}', [\App\Http\Controllers\AdminController::class, 'show'])->name('admin.show');
        Route::post('/update/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    });
});
