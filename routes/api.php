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
    Route::post('activate', [\App\Http\Controllers\AuthController::class, 'activateUser']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);




    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('profile', [\App\Http\Controllers\AuthController::class, 'profile']);
        Route::post('profile/update', [\App\Http\Controllers\AuthController::class, 'updateProfile']);

        /* vendors Routes */
        Route::get('vendors', [\App\Http\Controllers\VendorsController::class, 'vendorsApi'])->name('vendor-api');
        Route::get('vendors/featured', [\App\Http\Controllers\VendorsController::class, 'featuredVendorsSliders'])->name('vendor-api');
        /* End vendors Routes */

        Route::get('invoice/get-invoice/{id}',[\App\Http\Controllers\InvoiceController::class,'getInvoiceById'])->name('get-invoice-by-id');
        Route::get('invoice/get-vendor-invoice/{vendor_id}',[\App\Http\Controllers\InvoiceController::class,'getInvoiceByVendor'])->name('get-vendor-invoice');
        Route::get('invoice/get-my-vendors',[\App\Http\Controllers\InvoiceController::class,'getMyVendors'])->name('get-my-vendors');
        Route::get('invoice/get-category-invoice/{category_id}',[\App\Http\Controllers\InvoiceController::class,'getInvoiceByCategory'])->name('get-category-invoice');
        Route::get('invoice/get-my-category',[\App\Http\Controllers\InvoiceController::class,'getMyCategory'])->name('get-my-category');
        Route::get('invoice/my-invoice',[\App\Http\Controllers\InvoiceController::class,'getMyinvoice'])->name('get-my-invoice');
//        Route::get('invoice/update-invoice/{id}',[\App\Http\Controllers\InvoiceController::class,'UpdateInvoice'])->name('update-invoice');

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
        Route::get('reports',[\App\Http\Controllers\MyReportController::class,'showApi']);
    });
});
