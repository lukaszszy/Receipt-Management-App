<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceiptItem;

class ReceiptItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ReceiptItem::get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receiptItem = ReceiptItem::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'receipt_id' => $request->receipt_id,
            'category_id' => $request->category_id,
        ]);

        return response()->json($receiptItem, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receiptItem = ReceiptItem::find($id);
        if(is_null($receiptItem)){ return response()->json(["message " => "Record not found."], 404);}
        return response()->json($receiptItem, 200);
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
        $receiptItem = ReceiptItem::find($id);
        if(is_null($receiptItem)){ return response()->json(["message " => "Record not found."], 404);}
        $receiptItem->update($request->all());
        return response()->json($receiptItem, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receiptItem = ReceiptItem::find($id);
        if(is_null($receiptItem)){ return response()->json(["message " => "Record not found."], 404);}
        $receiptItem->delete();
        return response()->json(null, 204);
    }
}
