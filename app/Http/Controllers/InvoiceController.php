<?php

namespace App\Http\Controllers;

use App\Models\SellOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{

    public function generateInvoice(SellOrder $sellOrder)
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sell = $sellOrder->load(['order:id,invoice_number,price,warehouse_id,payment_at,payment_type'
            ,'order.warehouse:id,name' , 'client:id,name' ,
            'shipment:id,tracking_number' ,'order.orderItems','order.orderItems.item']);

        $company = [
            'name' => $admin->name,
            'email' => $admin->email,
            'phones' => $admin->phones
        ];

        $data = [
            'title' => 'Invoice',
            'content' => 'This is the sales summary',
            'order' => $sell,
            'logo' => $admin->logo,
            'company' => $company,
        ];

        $pdf = PDF::loadView('pdf.invoice' , $data)->setPaper('a4');
         return $pdf->stream('report.pdf');
    }
}
