<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Employee\EmployeeAuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;


/*
 * Authentication System for super admin , admin , employee
 */
Route::group(['prefix' => 'auth'], function () {

    Route::controller(SuperAdminAuthController::class)->prefix('superAdmin')
        ->group(function () {
        Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:superAdmin');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:superAdmin');
    });

    Route::controller(AdminAuthController::class)->prefix('admin')
        ->group(function () {
        Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:admin');
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:admin');
        Route::get('/email/verify/{id}/{hash}', 'verify')->middleware( 'signed')->name('verification.verify');
    });

    Route::controller(EmployeeAuthController::class)->prefix('employee')
        ->group(function () {
        Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:employee');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:employee');
    });

});

/*
 * login route for default route
 */
Route::get('login',function (){
    return response()->json([
        'message' => 'unauthorized'
    ]);
})->name('login');

/*
 * Reset password success and failure
 */
Route::get('reset-password/success' , function (){
    return view('auth.success');
})->name('success');

Route::get('reset-password/fail' , function (){
    return view('auth.fail');
})->name('fail');


/*
 *  Roles management
 */
Route::middleware('auth:admin')->group( function (){

    Route::prefix('role')->controller(RoleController::class)
        ->group( function (){
            Route::post('store','store');
            Route::get('show','show');
            Route::get('show/{id}','showOne');
            Route::put('update/{id}','update');
            Route::delete('delete/{id}','destroy');
        });

    /*
     * Employees management
     */
    Route::prefix('employee')->controller(EmployeeController::class)
        ->group( function (){
            Route::post('store','store');
            Route::get('show','show');
            Route::get('show/{employee}','showOne');
            Route::put('update/{employee}','update');
            Route::delete('delete/{employee}','destroy');
        });

    /*
 * Warehouse management
 */
    Route::prefix('warehouse')->controller(WarehouseController::class)
        ->group(function (){
            Route::post('store' , 'store');
            Route::get('show-all' , 'showAll')->middleware('auth:employee');
            Route::get('show/{warehouse}' , 'show')->middleware('auth:employee');;
            Route::put('update/{warehouse}' , 'update');
            Route::delete('delete/{warehouse}' , 'delete');
        });
});





