<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function dashboardPage(){
        return view('pages.dashboard.dashboard-page');
        
    }


    function dashboardSummaryShow(Request $request){
        try{
            $userId = $request->header('id');

            $products = Product::where("user_id", '=', $userId)->count();
            $customer = Customer::where("user_id", '=', $userId)->count();
            $category = Category::where("user_id", '=', $userId)->count();
            $invoice = Invoice::where("user_id", '=', $userId)->count();
            $total = Invoice::where("user_id", '=', $userId)->sum("total", 1);
            $vat = Invoice::where("user_id", '=', $userId)->sum("vat", 1);
            $discount = Invoice::where("user_id", '=', $userId)->sum("discount", 1);
            $payable = Invoice::where("user_id", '=', $userId)->sum("payable", 1);

            $summary = [
                "products" => $products,
                "customers" => $customer,
                "categories" => $category,
                "invoices" => $invoice,
                "total" => round($total, 2),
                "vat" => round($vat, 2),
                "discount" => round($discount, 2),
                "payable" => round($payable, 2)
                ];

                return response()->json([
                    'status' => 'success',
                    'summary' => $summary
                    ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Somethisng went wrong',
                'error' => $e->getMessage()
                ]);
        }

    }
}
