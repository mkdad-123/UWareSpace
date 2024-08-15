<?php

namespace App\Http\Controllers;

use App\Models\SellOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generatePDFForSells()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sellOrders  = $admin->load([
            'sellOrders.order.warehouse' , 'sellOrders.client' , 'sellOrders.shipment',
        ])->sellOrders()
            ->with([ 'order:id,invoice_number,warehouse_id','order.warehouse:id,name' , 'client:id,name' , 'shipment:id,tracking_number'])
            ->sell()->get();

//        $data = [
//            'title' => 'تقرير المبيعات',
//            'content' => 'هذا هو محتوى التقرير باللغة العربية.'
//        ];

        return $sellOrders;

//        $pdf = PDF::loadView('pdf.sell_report');
//        return $pdf->download('report.pdf');
    }
}
