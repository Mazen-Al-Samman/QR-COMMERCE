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

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('profile', [\App\Http\Controllers\AuthController::class, 'profile']);
    Route::post('profile/update', [\App\Http\Controllers\AuthController::class, 'updateProfile']);

    Route::group(['middleware' => 'auth:api'], function () {
        /* vendors Routes */
        Route::post('vendors', [\App\Http\Controllers\VendorsController::class, 'vendorsApi'])->name('vendor-api');
        /* End vendors Routes */

        /* categories Routes */
        Route::post('categories', [\App\Http\Controllers\CategoryController::class, 'categoriesApi'])->name('product-api');
        /* End categories Routes */

        /* products Routes */
        Route::post('vendor/products',[\App\Http\Controllers\ProductController::class,'vendorProductsApi'])->name('vendor-products-api');
        Route::post('product/details',[\App\Http\Controllers\ProductController::class,'productByBarcodeApi'])->name('barcode-products-api');
        Route::post('products', [\App\Http\Controllers\ProductController::class, 'productsApi'])->name('product-api');
        /* End products Routes */
    });
});
