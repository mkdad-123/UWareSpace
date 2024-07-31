<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CompliantsController;
use App\Http\Controllers\Employee\EmployeeAuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseItemController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
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
        ->group( function (){
            Route::post('store','store');
            Route::get('show-all','show');
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
            Route::get('show-all' , 'showAll');
            Route::get('show/{id}' , 'showItems');
            Route::put('update/{warehouse}' , 'update');
            Route::delete('delete/{warehouse}' , 'delete');
        });

    /*
    * Item management for admin dashboard
    */
    Route::prefix('admin/item')->controller(ItemController::class)
        ->group(function (){
            Route::get('show-all' , 'showAll');
            Route::get('show/{item}' , 'show');
        });

    Route::prefix('vehicle')->controller(VehicleController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show-all', 'showAll');
            Route::put('update/{vehicle}', 'update');
            Route::delete('delete/{vehicle}', 'delete');
        });
});

Route::middleware('auth:employee')->group(function () {

    Route::prefix('employee/warehouse')->controller(WarehouseController::class)
        ->group(function () {
            Route::get('show-all', 'showAll');
            Route::get('show/{id}', 'showItems');
        });

    Route::prefix('item')->controller(ItemController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show-all', 'showAll');
            Route::get('show/{item}', 'show');
            Route::post('update/{item}', 'update');
            Route::delete('delete/{item}', 'delete');
            Route::get('filter', 'filter');
        });

    Route::prefix('item')->controller(WarehouseItemController::class)
        ->group(function () {
            Route::post('store-in-warehouse/{item}', 'store');
            Route::put('update-in-warehouse/{item}', 'update');
            Route::get('warehouse/filter-minimum-quantity/{warehouse}' , 'filterMinQuantity');
        });

    Route::prefix('employee/vehicle')->controller(VehicleController::class)
        ->group(function () {
            Route::get('show-all', 'showAll');
        });


    Route::prefix('shipment')->controller(ShipmentController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show-all', 'showAll');
            Route::get('show/{shipment}', 'show');
            Route::post('update/{shipment}', 'update');
            Route::delete('delete/shipment', 'delete');
            Route::get('filter', 'filter');
        });

});

