<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    function customerPage(Request $request){
        return view('pages.dashboard.customer-page');
    }
    function customerListShow(Request $request){
        try{
            $userId = $request->header('id');

            $users = Customer::where('user_id', '=', $userId)->get();

            return response()->json([
                'status' => 'success',
                'data' => $users
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => "Request fail",
                'error' => $e->getMessage()
            ]);
        }
    }


    function customerCreation(Request $request){
        try{
            $userId = $request->header('id');
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');

            $data = Customer::create([
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "user_id" => $userId
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Customer has been created successfully',
                'data' => $data
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to create customer',
            ]);
        }
    }

    function customerUpdating(Request $request){
        try{
            $userId = $request->header('id');
            $customerId = $request->input('id');

            Customer::where('id', '=', $customerId)->where('user_id', '=', $userId)
            ->update([
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "phone" => $request->input('phone')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Customer has been updated successfully'
            ]);
        }
        catch(Exception $E){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to updated customer'
            ]);
        }
    }

    function customerDeleting(Request $request){
        try{
            $userId = $request->header('id');
            $customerId = $request->input('id');

            Customer::where('id', '=', $customerId)->where('user_id', '=', $userId)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Customer deleted successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to delete customer',
                'error' => $e->getMessage()
            ]);
        }
    }

    function customerById(Request $request){
        $userId = $request->header('id');
        $customerId = $request->input('id');

        $data = Customer::where('id', '=', $customerId)->where('user_id', '=', $userId)->first();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }




}
