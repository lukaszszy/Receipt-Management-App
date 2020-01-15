<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByCategory(Request $request, $category)
    {
        if(Auth::guard('api')->attempt([
            'email' => $request->email,
            'password' => $request->password]))
        {
            $id = Category::where('name', $category)->first()->id;
            $services = Category::find($id)->services;

            if(is_null($services)){ return response()->json(["message " => "Record not found."], 404);}
            return response()->json($services, 200);
        }
        else{
            return response()->json(["message " => "User auth failed."], 404);
        }
    }

}
