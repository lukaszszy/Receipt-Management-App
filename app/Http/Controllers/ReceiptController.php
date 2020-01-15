<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::guard('api')->attempt([
            'email' => $request->email,
            'password' => $request->password]))
        {
            return response()->json(Receipt::with('receipt_items')->where('user_id', Auth::guard('api')->user()->id)->get(), 200);
        }
        else{
            return response()->json(["message " => "User auth failed."], 404);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guard('store')->attempt([
            'email' => $request->email,
            'password' => $request->password]))
        {
            $receipt = Receipt::create([
                'payment_date' => $request->payment_date,
                'payment_amount' => $request->payment_amount,
                'user_id' => $this->findUserByBarcode($request->barcode),
                'store_id' => Auth::guard('store')->check() ? Auth::guard('store')->user()->id : null,
            ]);
        }
        else{
            return response()->json(["message " => "Store auth failed."], 404);
        }


        return response()->json($receipt, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(Auth::guard('api')->attempt([
            'email' => $request->email,
            'password' => $request->password]))
        {
            $receipt = Receipt::with('receipt_items')->where('user_id', Auth::guard('api')->user()->id)->get()->find($id);
            if(is_null($receipt)){ return response()->json(["message " => "Record not found."], 404);}
            return response()->json($receipt, 200);
        }
        else{
            return response()->json(["message " => "User auth failed."], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        if(Auth::guard('store')->attempt([
            'email' => $request->email,
            'password' => $request->password]))
        {
            $receipt = Receipt::find($id);
            if(is_null($receipt)){ return response()->json(["message " => "Record not found."], 404);}
            $receipt->update($request->all());
            return response()->json($receipt, 200);
        }
        else{
            return response()->json(["message " => "Store auth failed."], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guard('store')->attempt([
            'email' => $request->email,
            'password' => $request->password]))
        {
            $receipt = Receipt::where('store_id', Auth::id())->get()->find($id);
            if(is_null($receipt)){ return response()->json(["message " => "Record not found."], 404);}
            $receipt->delete();
            return response()->json(null, 204);
        }
        else{
            return response()->json(["message " => "User auth failed."], 404);
        }
    }

    public function findUserByBarcode($barcode)
    {
        $user = User::where('barcode', $barcode)->first();
        $id = $user->id;
        return $id;
    }
}
