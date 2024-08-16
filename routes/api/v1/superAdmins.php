<?php

use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;


    /*
     * Authentication System for super admin
     */

Route::group(['prefix' => 'auth'], function () {

    Route::controller(SuperAdminAuthController::class)->prefix('superAdmin')
        ->group(function () {
            Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:superAdmin');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout')->middleware('auth:superAdmin');
        });
});

Route::controller(SubscriptionController::class)->prefix('subscription')
    ->group(function () {
        Route::post('/MakePlan', 'MakePlan')->middleware('auth:superAdmin');
        Route::get('/ShowPlans', 'ShowPlans');
    });

Route::controller(SuperAdminController::class)->prefix('SuperAdmin')
    ->group(function () {
        Route::get('/ShowAdmins', 'ShowAdmins')->middleware('auth:superAdmin');
        Route::get('/ShowAdminsActive', 'ShowAdminsActive')->middleware('auth:superAdmin');
        Route::get('/ShowAdminsUnActive', 'ShowAdminsUnActive')->middleware('auth:superAdmin');
        Route::post('/ToggleAdminsStatus', 'ToggleAdminsStatus')->middleware('auth:superAdmin');
        Route::post('/makeAdminsStatusActive', 'makeAdminsStatusActive')->middleware('auth:superAdmin');
        Route::get('/ShowCompliants', 'ShowCompliants')->middleware('auth:superAdmin');

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
 * Reset password success and failure for all guards
 */
Route::get('reset-password/success', function () {
    return view('auth.success');
})->name('success');

Route::get('reset-password/fail', function () {
    return view('auth.fail');
})->name('fail');
