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
        Route::get('vendors', [\App\Http\Controllers\VendorsController::class, 'vendorsApi'])->name('vendor-api');
        /* End vendors Routes */

        /* categories Routes */
        Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'categoriesApi'])->name('product-api');
        /* End categories Routes */

        /* products Routes */
        Route::get('vendor/products/{vendor_id}',[\App\Http\Controllers\ProductController::class,'vendorProductsApi'])->name('vendor-products-api');
        Route::get('product/details/{vendor_id}/{barcode}',[\App\Http\Controllers\ProductController::class,'productByBarcodeApi'])->name('barcode-products-api');
        Route::get('products/{category_id?}', [\App\Http\Controllers\ProductController::class, 'productsApi'])->name('product-api');
        /* End products Routes */

        /* feedback Routes */
        Route::post('feedback/store',[\App\Http\Controllers\FeedbackController::class,'storeApi']);
        /* End feedback Routes */

        Route::post('qr/store',[\App\Http\Controllers\QuickResponseCodeController::class,'storeApi']);

        /* MyReport Routes */
        Route::post('report/store',[\App\Http\Controllers\MyReportController::class,'storeApi']);
        Route::post('report/delete',[\App\Http\Controllers\MyReportController::class,'deleteApi']);
        Route::get('reports/{id}',[\App\Http\Controllers\MyReportController::class,'showApi']);
    });
});
