<?php

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

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', [\App\Http\Controllers\AuthController::class,'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class,'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class,'refresh']);
    Route::post('me', [\App\Http\Controllers\AuthController::class,'me']);

    /* vendors Routes */
    Route::post('vendors' , [\App\Http\Controllers\VendorsController::class,'vendorsApi'])->name('vendor-api');
    /* End vendors Routes */

    /* products Routes */
    Route::post('products' , [\App\Http\Controllers\ProductController::class,'productsApi'])->name('product-api');
    /* End products Routes */
});
