<?php

namespace App\Http\Controllers;



use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generatePDFForSells(Request $request)
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sellOrders  = $admin->load([
            'sellOrders.order.warehouse' , 'sellOrders.client' , 'sellOrders.shipment',
        ])->sellOrders()
            ->whereBetween('sell_orders.created_at',[$request->fromDate,$request->toDate])
            ->with([ 'order:id,invoice_number,price,warehouse_id','order.warehouse:id,name' , 'client:id,name' , 'shipment:id,tracking_number'])
            ->sell()->get();

        $total_price = 0;

        foreach ($sellOrders as $order){

            $total_price += $order['order']['price'];
        }
        $company = [
          'name' => $admin->name,
          'email' => $admin->email,
          'phones' => $admin->phones
        ];

        $data = [
            'title' => 'Sales Report',
            'content' => 'This is the sales summary',
            'orders' => $sellOrders,
            'total_price' => $total_price,
            'logo' => $admin->logo,
            'company' => $company,
        ];

        $pdf = PDF::loadView('pdf.sell_report' , $data)->setPaper('a4');

        return $pdf->stream('report.pdf');
    }

    public function generatePDFForPurchase(Request $request)
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $purchaseOrders = $admin->load([
            'purchaseOrders.order.warehouse', 'purchaseOrders.supplier',
        ])->purchaseOrders()
            ->whereBetween('purchase_orders.created_at',[$request->fromDate,$request->toDate])
            ->with(['order:id,invoice_number,price,warehouse_id','order.warehouse:id,name', 'supplier:id,name'])
            ->purchase()->get();

        $total_price = 0;

        foreach ($purchaseOrders as $order){
            $total_price += $order['order']['price'];
        }

        $company = [
            'name' => $admin->name,
            'email' => $admin->email,
            'phones' => $admin->phones
        ];

        $data = [
            'title' => 'Purchase Report',
            'content' => 'This is the purchases summary',
            'orders' => $purchaseOrders,
            'total_price' => $total_price,
            'logo' => $admin->logo,
            'company' => $company,
        ];


        $pdf = PDF::loadView('pdf.purchase_report' , $data)->setPaper('a4');
        return $pdf->stream('report.pdf');
    }
}
