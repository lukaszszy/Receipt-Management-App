<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->group(function(){
    Route::post('/login', 'Auth\LoginController@loginAPI');
    Route::post('/register', 'Auth\RegisterController@createAPI');

    Route::get('/receipt', 'ReceiptController@index');
    Route::get('/receipt/{id}', 'ReceiptController@show');

    Route::get('/servicesByCategory/{category}', 'ServiceController@showByCategory');
});

Route::prefix('store')->group(function(){
    Route::post('login', 'Auth\StoreLoginController@loginAPI');
    Route::post('register', 'Auth\StoreRegisterController@createAPI');

    Route::post('/receipt', 'ReceiptController@store');
    Route::put('/receipt/{id}', 'ReceiptController@update');
    Route::delete('/receipt/{id}', 'ReceiptController@destroy');
    
});

Route::prefix('service')->group(function(){
    Route::post('login', 'Auth\ServiceLoginController@loginAPI');
    Route::post('register', 'Auth\ServiceRegisterController@createAPI');    
});

Route::apiResource('receiptItem', 'ReceiptItemController');