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

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('backend')->group(function () {
    Auth::routes();
    Route::group(['middleware' => ['auth','prevent-back-history']], function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\MainController::class, 'profile'])->name('profile');
        Route::put('/update/profile', [\App\Http\Controllers\MainController::class, 'updateProfile'])->name('update.profile');

        Route::prefix('admin')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
            Route::post('/store', [\App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
            Route::delete('/delete/{id}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.delete');
            Route::put('/update/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
            Route::get('/edit/{id}', [\App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
            Route::get('/show/{id}', [\App\Http\Controllers\AdminController::class, 'show'])->name('admin.show');
        });

        Route::prefix('role')->group(function () {
            Route::get('/', [\App\Http\Controllers\RoleController::class, 'create'])->name('role.create');
            Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
            Route::delete('/delete/{id}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('role.delete');
            Route::put('/update/{id}', [\App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
            Route::get('/edit/{id}', [\App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
            Route::get('/show/{id}', [\App\Http\Controllers\RoleController::class, 'show'])->name('role.show');
        });

        Route::prefix('permission')->group(function () {
            Route::get('/', [\App\Http\Controllers\PermissionController::class, 'create'])->name('permission.create');
            Route::post('/store', [\App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');
            Route::delete('/delete/{id}', [\App\Http\Controllers\PermissionController::class, 'destroy'])->name('permission.delete');
            Route::put('/update/{id}', [\App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update');
            Route::get('/edit/{id}', [\App\Http\Controllers\PermissionController::class, 'edit'])->name('permission.edit');
            Route::get('/show/{id}', [\App\Http\Controllers\PermissionController::class, 'show'])->name('permission.show');
        });

        Route::prefix('rolePermission')->group(function () {
            Route::get('/', [\App\Http\Controllers\RolePermissionController::class, 'index'])->name('rolePermission.index');
            Route::get('/manage/{role_id}', [\App\Http\Controllers\RolePermissionController::class, 'edit'])->name('rolePermission.manage');
            Route::put('/update/{role_id}', [\App\Http\Controllers\RolePermissionController::class, 'update'])->name('rolePermission.update');
            Route::get('/show/{role_id}', [\App\Http\Controllers\RolePermissionController::class, 'show'])->name('rolePermission.show');
        });

        Route::prefix('vendor')->group(function () {
            Route::get('/', [\App\Http\Controllers\VendorsController::class, 'create'])->name('vendor.create');
            Route::post('/store', [\App\Http\Controllers\VendorsController::class, 'store'])->name('vendor.store');
            Route::delete('/delete/{id}', [\App\Http\Controllers\VendorsController::class, 'destroy'])->name('vendor.delete');
            Route::get('/edit/{id}', [\App\Http\Controllers\VendorsController::class, 'edit'])->name('vendor.edit');
            Route::get('/show/{id}', [\App\Http\Controllers\VendorsController::class, 'show'])->name('vendor.show');
            Route::put('/update/{id}', [\App\Http\Controllers\VendorsController::class, 'update'])->name('vendor.update');
        });
    });

});
