<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/vendor/login', [\App\Http\Controllers\Auth\LoginController::class, 'vendorLogin'])->name('vendor.login.submit');
Route::get('/no-permission', [\App\Http\Controllers\MainController::class, 'noPermissions'])->name('no-permissions.index');
Route::get('/expired', [\App\Http\Controllers\MainController::class, 'expired'])->name('expired');



Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/en', [\App\Http\Controllers\HomeController::class, 'index_en'])->name('index_en');
Route::post('/phoneCheck', [\App\Http\Controllers\AuthController::class, 'checkUser']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('backend')->group(function () {
    Auth::routes();
    Route::get('/invoice/stream-pdf/{invoice_id}', [\App\Http\Controllers\InvoiceController::class, 'streamPdf'])->name('invoice.streamPdf');

    Route::prefix('ajax')->group(function (){
        Route::post('/updateStatusField', [\App\Http\Controllers\AjaxController::class, 'updateStatusField']);
        Route::get('/updateFlagField', [\App\Http\Controllers\AjaxController::class, 'updateFlagField']);
        Route::get('/resubscribeVendor', [\App\Http\Controllers\AjaxController::class, 'resubscribeVendor']);
    });

    Route::group(['middleware' => ['login-auth', 'prevent-back-history']], function () {
        Route::group(['middleware' => ['auth-permissions']], function () {
            Route::get('/profile', [\App\Http\Controllers\MainController::class, 'profile'])->name('profile.show');
            Route::put('/update/profile', [\App\Http\Controllers\MainController::class, 'updateProfile'])->name('profile.update');
            Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
            Route::get('/vendor/dashboard', [\App\Http\Controllers\AdminVendorController::class, 'index'])->name('admin-vendor.dashboard');

            Route::prefix('admin')->group(function () {
                Route::get('/', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
                Route::post('/store', [\App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
                Route::put('/update/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
                Route::get('/edit/{id}', [\App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\AdminController::class, 'show'])->name('admin.show');
            });

            Route::prefix('user')->group(function () {
                Route::get('/', [\App\Http\Controllers\UserController::class, 'create'])->name('user.create');
                Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
                Route::put('/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
                Route::get('/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.show');
            });

            Route::prefix('role')->group(function () {
                Route::get('/', [\App\Http\Controllers\RoleController::class, 'create'])->name('role.create');
                Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy');
                Route::put('/update/{id}', [\App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
                Route::get('/edit/{id}', [\App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\RoleController::class, 'show'])->name('role.show');
            });

            Route::prefix('permission')->group(function () {
                Route::get('/', [\App\Http\Controllers\PermissionController::class, 'create'])->name('permission.create');
                Route::post('/store', [\App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\PermissionController::class, 'destroy'])->name('permission.destroy');
                Route::put('/update/{id}', [\App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update');
                Route::get('/edit/{id}', [\App\Http\Controllers\PermissionController::class, 'edit'])->name('permission.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\PermissionController::class, 'show'])->name('permission.show');
            });

            Route::prefix('role-permission')->group(function () {
                Route::get('/', [\App\Http\Controllers\RolePermissionController::class, 'index'])->name('role-permission.index');
                Route::get('/manage/{role_id}', [\App\Http\Controllers\RolePermissionController::class, 'edit'])->name('role-permission.manage');
                Route::put('/update/{role_id}', [\App\Http\Controllers\RolePermissionController::class, 'update'])->name('role-permission.update');
                Route::get('/show/{role_id}', [\App\Http\Controllers\RolePermissionController::class, 'show'])->name('role-permission.show');
            });

            Route::prefix('vendor')->group(function () {
                Route::get('/', [\App\Http\Controllers\VendorsController::class, 'create'])->name('vendor.create');
                Route::post('/store', [\App\Http\Controllers\VendorsController::class, 'store'])->name('vendor.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\VendorsController::class, 'destroy'])->name('vendor.destroy');
                Route::get('/edit/{id}', [\App\Http\Controllers\VendorsController::class, 'edit'])->name('vendor.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\VendorsController::class, 'show'])->name('vendor.show');
                Route::put('/update/{id}', [\App\Http\Controllers\VendorsController::class, 'update'])->name('vendor.update');
            });

            Route::prefix('admin/vendor')->group(function () {
                Route::group(['middleware' => ['vendor-auth']], function () {
                    Route::get('/', [\App\Http\Controllers\AdminVendorController::class, 'create'])->name('admin-vendor.create');
                    Route::post('/store', [\App\Http\Controllers\AdminVendorController::class, 'store'])->name('admin-vendor.store');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\AdminVendorController::class, 'destroy'])->name('admin-vendor.destroy');
                    Route::get('/show/{id}', [\App\Http\Controllers\AdminVendorController::class, 'show'])->name('admin-vendor.show');
                    Route::get('/edit/{id}', [\App\Http\Controllers\AdminVendorController::class, 'edit'])->name('admin-vendor.edit');
                    Route::put('/update/{id}', [\App\Http\Controllers\AdminVendorController::class, 'update'])->name('admin-vendor.update');
                });

            });
            Route::prefix('category')->group(function () {
                Route::get('/', [\App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
                Route::post('/store', [\App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');
                Route::get('/edit/{id}', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
                Route::put('/update/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
            });

            Route::prefix('banner')->group(function () {
                Route::get('/', [\App\Http\Controllers\BannerController::class, 'create'])->name('banner.create');
                Route::post('/store', [\App\Http\Controllers\BannerController::class, 'store'])->name('banner.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\BannerController::class, 'destroy'])->name('banner.destroy');
                Route::get('/edit/{id}', [\App\Http\Controllers\BannerController::class, 'edit'])->name('banner.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\BannerController::class, 'show'])->name('banner.show');
                Route::put('/update/{id}', [\App\Http\Controllers\BannerController::class, 'update'])->name('banner.update');
            });

            Route::prefix('product')->group(function () {
                Route::get('/', [\App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
                Route::post('/store', [\App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
                Route::delete('/delete/{id}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
                Route::get('/imageDelete/{id}', [\App\Http\Controllers\ProductController::class, 'deleteImage'])->name('product_image.destroy');
                Route::get('/edit/{id}', [\App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
                Route::get('/show/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
                Route::put('/update/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
            });


            Route::prefix('invoice')->group(function () {
                Route::get('/', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice.index');
                Route::get('/create', [\App\Http\Controllers\InvoiceController::class, 'create'])->name('invoice.create');
                Route::get('/store', [\App\Http\Controllers\InvoiceController::class, 'store'])->name('invoice.store');
                Route::post('/add-to-cart', [\App\Http\Controllers\InvoiceController::class, 'addToCart'])->name('invoice.addToCart');
                Route::post('/delete-from-cart', [\App\Http\Controllers\InvoiceController::class, 'deleteFromCart'])->name('invoice.deleteFromCart');
                Route::post('/update-cart', [\App\Http\Controllers\InvoiceController::class, 'updateCart'])->name('invoice.updateCart');
                Route::get('/show/{invoice_id}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
                Route::get('/download-pdf/{invoice_id}', [\App\Http\Controllers\InvoiceController::class, 'downloadPDF'])->name('invoice.pdf');

           });

        });
    });
});
