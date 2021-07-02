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

//Route::get('/backend',[\App\Http\Controllers\AdminController::class,'index'])->name('dashboard');
//
//
//Route::prefix('admin')->group(function () {
//    Route::get('/create',[\App\Http\Controllers\AdminController::class,'create'])->name('admin.create');
//    Route::get('/store',[\App\Http\Controllers\AdminController::class,'store'])->name('admin.store');
//
//});
