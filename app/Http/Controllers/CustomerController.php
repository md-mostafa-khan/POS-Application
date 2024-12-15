<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function CustomerPage(){
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request){
        $user_id = $request->header('id');
        return Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'user_id' => $user_id,
        ]);
    }

    function CustomerList(Request $request){
        $user_id = $request->header('id');
        return Customer::where('user_id', $user_id)->get();
    }

    function CustomerDelete(Request $request)
    {
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return Customer::where('id', $customer_id)->where('user_id', $user_id)->delete();

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ], 200);
    }

    function CustomerById(Request $request)
    {
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return Customer::where('id', $customer_id)->where('user_id', $user_id)->first();

    }

    function CustomerUpdate(Request $request)
    {
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        $UData = Customer::where('id', $customer_id)->where('user_id', $user_id)->update([
            'name' => $request->input('name'),
            'email'=> $request->input('email'),
            'mobile'=> $request->input('mobile'),

        ]);
        if ($UData) {
            return response()->json([
                'status' => 'success',
                'data' => $UData,
            ], 200);
        }
        return response()->json([
            'status' => 'fail',
            'data' => $UData,
        ], 200);


    }

}
