<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    
    function reportPageShow(){
        return view('pages.dashboard.report-page');
    }


    function salesReportGenerating(Request $request){
        $user_id = $request->header('id');

        $fromDate = date('Y-m-d', strtotime($request->FromDate));
        $toDate = date('Y-m-d', strtotime($request->ToDate));
         
        $total = Invoice::where('user_id', '=', $user_id)->where('created_at', '>=', $fromDate)
        ->where('created_at', '<=', $toDate)->sum('total');

        $discount = Invoice::where('user_id', '=', $user_id)->where('created_at', '>=', $fromDate)
        ->where('created_at', '<=', $toDate)->sum('discount');

        $vat = Invoice::where('user_id', '=', $user_id)->where('created_at', '>=', $fromDate)
        ->where('created_at', '<=', $toDate)->sum('vat');

        $payable = Invoice::where('user_id', '=', $user_id)->where('created_at', '>=', $fromDate)
        ->where('created_at', '<=', $toDate)->sum('payable');

        $list = Invoice:: where('user_id', '=', $user_id)
        ->where('created_at', '>=', $fromDate)
        ->where('created_at', '<=', $toDate)
        ->with('customer')
        ->get();

        $data = [
            'total' => $total,
            'discount' => $discount,
            'vat' => $vat,
            'payable' => $payable,
            'list' => $list,
            'FromDate' => $request->FromDate,
            'ToDate' => $request->ToDate
        ];

        $pdf = Pdf::loadView('pages.report.SalesReport',$data);

        return $pdf->download('invoice.pdf');


    }


}
