<?php

use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::controller(SuperAdminAuthController::class)->prefix('superAdmin')->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:superAdmin');
        Route::post('/refresh','refresh');
    });
});
