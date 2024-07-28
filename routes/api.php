<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompliantsController;
use App\Http\Controllers\Employee\EmployeeAuthController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Models\Compliant;
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
            Route::get('/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verification.verify');
        });

    Route::controller(EmployeeAuthController::class)->prefix('employee')
        ->group(function () {
            Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:employee');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout')->middleware('auth:employee');
        });
});
Route::controller(SuperAdminController::class)->prefix('SuperAdmin')
    ->group(function () {
        Route::get('/ShowAdmins', 'ShowAdmins')->middleware('auth:superAdmin');
        Route::post('/ToggleAdminsStatus', 'ToggleAdminsStatus')->middleware('auth:superAdmin');
        Route::get('/ShowCompliants', 'ShowCompliants')->middleware('auth:superAdmin');


    });
Route::controller(AdminController::class)->prefix('Admin')
    ->group(function () {
        Route::get('/ShowCompliants', 'ShowCompliants')->middleware('auth:admin');

    });
    Route::controller(SubscriptionController::class)->prefix('subscription')
    ->group(function () {
        Route::post('/MakePlan', 'MakePlan')->middleware('auth:superAdmin');
        Route::get('/ShowPlans', 'ShowPlans')->middleware('auth:admin');
        Route::post('/PickePlan', 'PickePlan')->middleware('auth:admin');

    });
    Route::controller(CompliantsController::class)->prefix('Compliant')
    ->group(function () {
        Route::post('/WriteComplaintAdmins', 'WriteComplaintAdmins')->middleware('auth:admin');
        Route::post('/WriteComplaintEmployees', 'WriteComplaintEmployees')->middleware('auth:employee');

    });
    Route::controller(ClientController::class)->prefix('client')
    ->group(function () {
        Route::post('/StoreClients', 'store')->middleware('auth:admin');
        Route::post('/UpdateClients', 'update')->middleware('auth:admin');
        Route::get('/ShowClients', 'show')->middleware('auth:admin');
        Route::post('/ShowClient','showId')->middleware('auth:admin');
        Route::post('/DeleteClient','delete')->middleware('auth:admin');
        Route::post('/SortClients','sort')->middleware('auth:admin');
    });
    /*
 * login route for default route
 */
Route::get('login', function () {
    return response()->json([
        'message' => 'unauthorized'
    ]);
})->name('login');

/*
 * Reset password success and failure
 */
Route::get('reset-password/success', function () {
    return view('auth.success');
})->name('success');

Route::get('reset-password/fail', function () {
    return view('auth.fail');
})->name('fail');


/*
 *  Roles management
 */
Route::middleware('auth:admin')->group(function () {

    Route::prefix('role')->controller(RoleController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show', 'show');
            Route::get('show/{id}', 'showOne');
            Route::put('update/{id}', 'update');
            Route::delete('delete/{id}', 'destroy');
        });

    /*
     * Employees management
     */
    Route::prefix('employee')->controller(EmployeeController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show', 'show');
            Route::get('show/{id}', 'showOne');
            Route::put('update/{id}', 'update');
            Route::delete('delete/{id}', 'destroy');
        });
});
