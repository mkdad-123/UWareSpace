<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

    Route::controller(SuperAdminAuthController::class)->prefix('superAdmin')->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:superAdmin');
    });
    Route::controller(AdminAuthController::class)->prefix('admin')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:admin');
    });

});

Route::prefix('role')->controller(RoleController::class)->group(function (){
    Route::post('store','store');
    Route::get('show_all_Permissions','showPermissions');
    Route::get('show','show');
    Route::get('show/{id}','showOne');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destroy');
});

Route::prefix('employee')->controller(EmployeeController::class)->group(function (){
    Route::post('store','store');
    Route::get('show','show');
    Route::get('show/{id}','showOne');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destroy');
});

Route::get('login',function (){
    return response()->json([
        'message' => 'unauthorized'
    ]);
})->name('login');
