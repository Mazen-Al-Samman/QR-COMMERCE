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
        Route::delete('/delete', [\App\Http\Controllers\AdminController::class, 'delete'])->name('admin.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    });
});
