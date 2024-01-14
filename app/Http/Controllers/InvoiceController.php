<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{


    function salePageShow(){
        return view('pages.dashboard.sale-page');
    }

    function invoicePageShow(){
        return view('pages.dashboard.invoice-page');
    }

    function invoiceListShow(Request $request){
        try{
            $userId = $request->header('id');
            $invoiceList = Invoice::where('user_id', '=', $userId)->with('customer')->get();

            return response()->json([
                'status' => 'success',
                'data' => $invoiceList
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail',
                'error' => $e->getMessage()
            ]);
        }

    }


    function invoiceCreation(Request $request){
        DB::beginTransaction();

        try{
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                "total" => $total,
                "discount" => $discount,
                "vat" => $vat,
                "payable" => $payable,
                "user_id" => $user_id,
                "customer_id" => $customer_id
            ]);

            $invoiceID = $invoice->id;

            $products = $request->input('products');

            foreach($products as $singleProduct){
                InvoiceProduct::create([
                    "invoice_id" => $invoiceID,
                    "user_id" => $user_id,
                    "product_id" => $singleProduct['product_id'],
                    "qty" => $singleProduct['qty'],
                    "sale_price" => $singleProduct['sale_price']
                ]);
            }

            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Request success to create new invoice'
            ]);

        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>'fail',
                'message'=>'Request fail',
                'error'=>$e->getMessage()
            ]);
        }
    }


    function invoiceDetails(Request $request){
        $userId = $request->header('id');

        $customerDetails = Customer::where('user_id', '=', $userId)->where('id', '=', $request->input('customer_id'))->first();
        $invoiceTotal = Invoice::where('user_id', '=', $userId)->where('id', '=', $request->input('invoice_id'))->first();
        $invoiceProduct = InvoiceProduct::where('user_id', '=', $userId)
                          ->where('invoice_id', '=', $request->input('invoice_id'))->with('product')->get();


        return array(
            'invoice'=>$invoiceTotal,
            'customer'=>$customerDetails,
            'products'=>$invoiceProduct
        );

    }


    function invoiceDeleting(Request $request){
        DB::beginTransaction();

        try{
            $userId = $request->header('id');
            InvoiceProduct::where('user_id', '=', $userId)->where('invoice_id', '=', $request->input('invoice_id'))->delete();
            
            Invoice::where('user_id', '=', $userId)->where('id', '=', $request->input('invoice_id'))->delete();

            Db::commit();

            return response()->json([
                'status'=>'success',
                'message'=>'Request success to delete invoice'
            ]);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>'fail',
                'message'=>'Request fail !',
                'error' => $e->getMessage()
            ]);
        }
    }






}
