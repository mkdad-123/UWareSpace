<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompliantsController;
use App\Http\Controllers\Employee\EmployeeAuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Order\OrderStatusController;
use App\Http\Controllers\Order\PurchaseController;
use App\Http\Controllers\Order\PurchaseOrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Warehouse\WarehouseController;
use App\Http\Controllers\Warehouse\WarehouseItemController;
use Illuminate\Support\Facades\Route;

/*
 * Authentication System for super admin , admin , employee
 */

Route::group(['prefix' => 'auth'], function () {

    Route::controller(AdminAuthController::class)->prefix('admin')
        ->group(function () {
            Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:admin');
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout')->middleware('auth:admin');
            Route::get('/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verification.verify');
        });
});

Route::controller(SubscriptionController::class)->prefix('subscription')
    ->group(function () {
        Route::post('/PickePlan', 'PickePlan')->middleware('auth:admin');
    });

Route::controller(CompliantsController::class)->prefix('Compliant')
    ->group(function () {
        Route::post('/WriteComplaintAdmins', 'WriteComplaintAdmins')->middleware('auth:admin');
    });


Route::middleware('auth:admin')->group(function () {

    Route::prefix('role')->controller(RoleController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show', 'show');
            Route::get('show/{id}', 'showOne');
            Route::put('update/{id}', 'update');
            Route::delete('delete/{id}', 'destroy');
            Route::get('permissions' , 'showPermission');
        });

    Route::get('permissions/show-all' , [RoleController::class,'showPermission']);

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

    /*
    * Vehicle management for admin dashboard
    */
    Route::prefix('vehicle')->controller(VehicleController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show-all', 'showAll');
            Route::put('update/{vehicle}', 'update');
            Route::delete('delete/{vehicle}', 'delete');
        });

    /*
    * Supplier management for admin dashboard
    */

    Route::controller(SupplierController::class)->prefix('supplier')
        ->group(function () {

            Route::post('store', 'store');
            Route::put('update/{id}', 'update');
            Route::get('show-all', 'showAll');
            Route::get('show/{id}','show');
            Route::delete('delete/{id}','delete');
            Route::post('sort','sort');
        });

    Route::controller(ClientController::class)->prefix('admin/client')
        ->group(function () {
            Route::get('show-all', 'showAll');
            Route::get('show/{id}','show');
            // Route::post('sort','sort');
        });

    /*
     * Show Purchases
     */
    Route::prefix('admin/received/purchase')->controller(PurchaseController::class)
        ->group(function (){
            Route::get('show-all-purchase', 'showPurchases');
        });

    Route::prefix('purchase')->controller(OrderStatusController::class)
        ->group(function (){
            Route::post('changeStatus/{order}', 'changeStatusPurchase');
        });

    Route::prefix('admin/orders/purchase')->controller(PurchaseOrderController::class)
        ->group(function () {
            Route::get('show-all', 'showAll');
            Route::get('show/{order}', 'show');
        });
});
