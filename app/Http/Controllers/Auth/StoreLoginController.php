<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StoreLoginController extends Controller
{
    public function __construct(){
        //$this->middleware('guest:store');
    }

    public function showLoginForm(){
        return view('auth.store-login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('store')->attempt([
                    'email' => $request->email,
                    'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('store.dashboard'));
        }

        return redirect()->back();
    }

    public function loginAPI(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('store')->attempt([
                    'email' => $request->email,
                    'password' => $request->password]))
        {
            return response()->json(["message " => "Accepted."], 200);
        }
        else{
            return response()->json(["message " => "Record not found."], 404);
        }
    }
}
