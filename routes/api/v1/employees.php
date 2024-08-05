<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompliantsController;
use App\Http\Controllers\Employee\EmployeeAuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Order\OrderStatusController;
use App\Http\Controllers\Order\PurchaseController;
use App\Http\Controllers\Order\PurchaseOrderController;
use App\Http\Controllers\Order\SellOrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Warehouse\WarehouseController;
use App\Http\Controllers\Warehouse\WarehouseItemController;
use Illuminate\Support\Facades\Route;



    /*
     * Authentication System for employee
     */
    Route::group(['prefix' => 'auth'], function () {

        Route::controller(EmployeeAuthController::class)->prefix('employee')
            ->group(function () {
                Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:employee');
                Route::post('/login', 'login');
                Route::post('/logout', 'logout')->middleware('auth:employee');
            });
    });

    Route::controller(CompliantsController::class)->prefix('Compliant')
        ->group(function () {
            Route::post('/WriteComplaintEmployees', 'WriteComplaintEmployees')->middleware('auth:employee');
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

    Route::controller(ClientController::class)->prefix('client')
        ->group(function () {
            Route::post('store', 'store');
            Route::put('update/{id}', 'update');
            Route::get('show-all', 'showAll');
            Route::get('show/{id}','show');
            Route::delete('delete/{id}','delete');
            Route::post('sort','sort');
        });

    Route::controller(SupplierController::class)->prefix('employee/supplier')
        ->group(function () {
            Route::get('show-all', 'showAll');
            Route::get('show/{id}','show');
            // Route::post('sort','sort');
        });


    Route::prefix('shipment')->controller(ShipmentController::class)
        ->group(function () {
            Route::post('store', 'store');
            Route::get('show-all', 'showAll');
            Route::get('show/{shipment}', 'show');
            Route::post('update/{shipment}', 'update');
            Route::delete('delete/{shipment}', 'delete');
            Route::post('add-order-in-shipment/{shipment}' , 'addOrder');
            Route::get('filter', 'filter');
        });

    Route::prefix('orders')->group(function (){

        Route::prefix('purchase')->group(function (){

            Route::controller(PurchaseOrderController::class)
                ->group(function () {
                    Route::post('store', 'store');
                    Route::get('show-all', 'showAll');
                    Route::get('show/{order}', 'show');
                    Route::delete('delete/{order}', 'delete');
                    Route::post('batch/{order}' , 'addBatch');
                });

            Route::controller(OrderStatusController::class)
                ->group(function (){
                    Route::post('changeStatus/{order}', 'changeStatusPurchase');
                });
        });

        Route::prefix('sell')->group(function (){

            Route::controller(SellOrderController::class)
                ->group(function () {
                    Route::post('store', 'store');
                    Route::get('show-all', 'showAll');
                    Route::get('show/{order}', 'show');
                    Route::delete('delete/{order}', 'delete');
                    Route::get('show-nearest-warehouse/with-quantity/{client}' , 'checkNearestWarehouse');
                });

            Route::controller(OrderStatusController::class)
                ->group(function (){
                  //  Route::post('changeStatus/{order}', 'changeStatusPurchase');
                });
        });
    });

    Route::prefix('received/purchase')->controller(PurchaseController::class)
        ->group(function (){
            Route::get('show-all-purchase', 'showPurchases');
            Route::get('show-all-non-inventoried', 'showNonInventoried');
        });
});
