<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generatePDF()
    {

        $data = [
            'title' => 'تقرير المبيعات',
            'content' => 'هذا هو محتوى التقرير باللغة العربية.'
        ];
       // $arabic = new Arabic();
        $pdf = PDF::loadView('pdf.sell_report');
        return $pdf->download('report.pdf');
    }
}
