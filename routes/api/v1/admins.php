<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompliantsController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Order\OrderStatusController;
use App\Http\Controllers\Order\PurchaseController;
use App\Http\Controllers\Order\PurchaseOrderController;
use App\Http\Controllers\Order\SellController;
use App\Http\Controllers\Order\SellOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Route;

    /*
     * Authentication System for admin
     */

Route::group(['prefix' => 'auth'], function () {

    Route::controller(AdminAuthController::class)->prefix('admin')
        ->group(function () {
            Route::post('password/forgot-password/{broker}', 'forgotPassword')->middleware('guest:admin');
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::post('/logout', 'logout')->middleware('auth:admin');
            Route::get('/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verification.verify');
            Route::get('/redirect', 'redirectToAuth');
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
            Route::get('show/{id}','showOne');
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

    Route::prefix('admin')->group(function (){

        /*
        * Item management for admin dashboard
        */
        Route::prefix('item')->controller(ItemController::class)
            ->group(function (){
                Route::get('show-all' , 'showAll');
                Route::get('show/{item}' , 'show');
            });

        Route::prefix('shipment')->controller(ShipmentController::class)
            ->group(function () {
                Route::get('show-all', 'showAll');
                Route::get('show/{shipment}', 'show');
            });

        Route::prefix('received/purchase')->controller(PurchaseController::class)
            ->group(function (){
                Route::get('show-all-purchase', 'showPurchases');
            });

        Route::get('received/sell/show-all-sell', [SellController::class ,'showSells']);

        Route::prefix('debt')->controller(DebtController::class)
            ->group(function (){
                Route::get('show-all-debt-purchase', 'showDebtPurchase');
                Route::get('show-all-debt-sell', 'showDebtSell');
            });


        Route::prefix('orders/purchase')->controller(PurchaseOrderController::class)
            ->group(function () {
                Route::get('show-all', 'showAll');
                Route::get('show/{purchaseOrder}', 'show');
            });

        Route::controller(SellOrderController::class)
            ->group(function () {
                Route::get('show-all', 'showAll');
                Route::get('show/{sellOrder}', 'show');
            });

        Route::controller(AdminNotificationController::class)
            ->prefix('notification')->group(function (){
                Route::get('/show_all' , 'index');
                Route::get('/unread' , 'unread');
                Route::post('/put_mark_All' , 'markReadAll');
                Route::post('/put_mark/{id}' , 'markRead');
                Route::post('/delete_All' , 'deleteAll');
                Route::delete('/delete_One/{id}' , 'delete');
            });

        Route::prefix('reports')->controller(ReportController::class)->group(function (){
            Route::get('sales' , 'generatePDFForSells');
            Route::get('purchases' , 'generatePDFForPurchase');
        });

        Route::get('invoice/{sellOrder}' , [InvoiceController::class,'generateInvoice']);
    });

});
