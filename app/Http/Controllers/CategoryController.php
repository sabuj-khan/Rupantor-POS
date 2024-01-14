<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    function categoryPage(){
        return view('pages.dashboard.category-page');
    }
    function categoryListShow(Request $request){
        $userId = $request->header('id');

        $data = Category::where('user_id', '=', $userId)->get();

        return response()->json([
            'status' => 'status',
            'data' => $data
        ]);
    }

    function categoryCreation(Request $request){
        try{
            $userId = $request->header('id');
            $name = $request->input('name');

            $data = Category::create([
                'name' => $name,
                'user_id' => $userId
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Category has been created successfully',
                'data' => $data
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to create category'
            ]);
        }
    }


    function categoryUpdating(Request $request){
        try{
            $userId = $request->header('id');
            $categoriId = $request->input('id');

            Category::where('id', '=', $categoriId)->where('user_id', '=', $userId)
            ->update([
                'name' => $request->input('name')
            ]);

            return response()->json([
                'status' => 'status',
                'message' => 'Category has been updated successfully'
            ]);

        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to create category'
            ]);
        }
    }


    function categoryDeleting(Request $request){
        try{
            $userId = $request->header('id');
            $categoriId = $request->input('id');

            Category::where('id', '=', $categoriId)->where('user_id', '=', $userId)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Category has been deleted successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to delete category'
            ]);
        }
    }

    function categoryById(Request $request){
        try{
            $userId = $request->header('id');
            $categoriId = $request->input('id');

            $data = Category::where('id', '=', $categoriId)->where('user_id', '=', $userId)->first();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail'
            ]);
        }
    }



}
