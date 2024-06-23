<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "Admin" middleware group. Make something great!
|
*/


// admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showAdminLoginForm'])->name('login.form');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'adminLogin'])->name('login.post');
    Route::post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'adminLogout'])->name('logout');

    // authanticated routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

        // customer crud
        Route::resource('/customers', \App\Http\Controllers\Admin\CustomerController::class);
        Route::patch('/customers/{customer}/approve', [\App\Http\Controllers\Admin\CustomerController::class, 'approve'])->name('admin.customers.approve');
    });
});
