<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function ProductPage()
    {
        return view('pages.dashboard.product-page');
    }

    public function ProductCreate(Request $request){
        $user_id = $request->header('id');

        $image = $request->file('img');
        $time = time();
        $file_name = $image->getClientOriginalName();
        $image_name = $user_id.$time.$file_name;
        $img_url = "uploads/".$image_name;
        // upload image
        $image->move(public_path('uploads'), $image_name);
        // save to database
        return Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $img_url,
            'category_id' => $request->input('category_id'),
            'user_id' => $user_id
        ]);
    }

    public function ProductDelete(Request $request){
        $product_id = $request->input('id');
        $user_id = $request->header('id');
        $filePath = $request->input('file_path');
        File::delete($filePath);
        return Product::where('id', $product_id)->where('user_id', $user_id)->delete();
    }

    public function ProductById(Request $request){
        $product_id = $request->input('id');
        $user_id = $request->header('id');
        return Product::where('id', $product_id)->where('user_id', $user_id)->first();
    }

    public function ProductList(Request $request){
        $user_id = $request->header('id');
        return Product::where('user_id', $user_id)->get();
    }

    public function ProductUpdate(Request $request){
        $product_id = $request->input('id');
        $user_id = $request->header('id');

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $time = time();
            $file_name = $image->getClientOriginalName();
            $image_name = $user_id . $time . $file_name;
            $img_url = "uploads/" . $image_name;
            // upload image
            $image->move(public_path('uploads'), $image_name);
            $filePath = $request->input('file_path');
            File::delete($filePath);
            return Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img_url' => $img_url,
                'category_id' => $request->input('category_id'),
            ]);
        } else {
            return Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'category_id' => $request->input('category_id'),
            ]);
        }
    }
}
