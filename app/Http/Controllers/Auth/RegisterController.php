<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Picqer;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function makeBarcodeExample(Request $request)
    {
        $label =  $request->barcode;

        $barcode_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = $barcode_generator->getBarcode($label, $barcode_generator::TYPE_CODE_128);

        echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '">';
        echo '<p>'.$label;
    }

    public function makeBarcode(Request $request)
    {
        $label =  $request->barcode;

        $barcode_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = $barcode_generator->getBarcode($label, $barcode_generator::TYPE_CODE_128);

        echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '">';
        echo '<p>'.$label;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'barcode' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createAPI(Request $request)
    {   
        if($user = User::where('email', $request->email)->exists())
        {
            return response()->json(["message " => "User exists."], 404);
        }
        else
        {
            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
            return response()->json($user, 201);
        }
    }

    protected function create(array $data)
    {
        #self::makeBarcode($data['barcode']);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
