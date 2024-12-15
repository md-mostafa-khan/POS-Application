<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryPage(){
        return view('pages.dashboard.category-page');
    }

    function CategoryList(Request $request){
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->get();
    }

    function CategoryCreate(Request $request){
        $user_id = $request->header('id');
        $category = Category::create([
            'name'=> $request->input('name'),
            'user_id' => $user_id
        ]);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ],201);
    }

    function CategoryDelete(Request $request){
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        $data = Category::where('id', $category_id)->where('user_id', $user_id)->delete();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ],200);
    }

    function CategoryById(Request $request){
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->first();

    }

    function CategoryUpdate(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');
        $UData= Category::where('id', $category_id)->where('user_id', $user_id)->update([
            'name' => $request->input('name')
        ]);
        if($UData){
            return response()->json([
                'status' => 'success',
                'data' => $UData,
            ], 200);
        }
        return response()->json([
            'status' => 'fail',
            'data' => $UData,
        ], 401);


    }
}
