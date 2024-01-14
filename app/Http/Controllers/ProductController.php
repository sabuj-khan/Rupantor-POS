<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{


    function productPage(){
        return view('pages.dashboard.product-page');
    }

    function productListShow(Request $request){
        $userId = $request->header('id');

        $data = Product::where('user_id', '=', $userId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    function productcreation(Request $request){
        try{
            $userId = $request->header('id');

            $img = $request->file('img');
            $time = time();
            $fileName = $img->getClientOriginalName();
            $imageName = "{$userId}-{$time}-{$fileName}";
            $image_url = "uploads/{$imageName}";

            // File Upload
            $img->move(public_path('uploads'), $imageName);

            // Product create
            $data = Product::create([
                'user_id' => $userId,
                'category_id' => $request->input('category_id'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img' => $image_url
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product has been created successfully',
                'data' => $data
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to create product'
            ]);
        }
    }


    function productUpdating(Request $request){
        try{
            $userId = $request->header('id');
            $productId = $request->input('id');

            if($request->hasFile('img')){
                $img = $request->file('img');
                $time = time();
                $fileName = $img->getClientOriginalName();
                $imageName = "{$userId}-{$time}-{$fileName}";
                $image_url = "uploads/{$imageName}";

                // File Upload
                $img->move(public_path('uploads'), $imageName);

                // Delete File
                $filePath = $request->input('file_path');
                File::delete($filePath);

                Product::where('id', '=', $productId)->where('user_id', '=', $userId)->update([
                    'category_id' => $request->input('category_id'),
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'unit' => $request->input('unit'),
                    'img' => $image_url
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'The product has been updated successfully'
                ]);

            }else{
                Product::where('id', '=', $productId)->where('user_id', '=', $userId)->update([
                    'category_id' => $request->input('category_id'),
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'unit' => $request->input('unit'),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'The product has been updated successfully'
                ]);
            }
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to update the product',
                'error' => $e->getMessage()
            ]);
        }
    }

    function productDeleting(Request $request){
        $userId = $request->header('id');
        $productId = $request->input('id');

        $filePath = $request->input('file_path');
        File::delete($filePath);

        Product::where('id', '=', $productId)->where('user_id', '=', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);


    }


    function productByID(Request $request){
        try{
            $userId = $request->header('id');
            $productId = $request->input('id');

            $data = Product::where('id', '=', $productId)->where('user_id', '=', $userId)->first();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail !'
            ]);
        }
    }


}
