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
    return view('welcome');
});

Route::prefix('backend')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');

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

});
