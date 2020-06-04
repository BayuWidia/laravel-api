<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//routing yang ingin diprotect dengan sanctum, maka harus menggunakan middleware dari auth:sanctum
Route::group(['middleware' => 'auth:sanctum'], function() {
    //sehingga semua routing yang ada di dalamnya harus mengirimkan token
    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@show');
    Route::get('/users/searchByName/{name}', 'UserController@searchByName');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{id}', 'UserController@update');
    Route::delete('/users/{id}', 'UserController@delete');

    Route::get('/users/all/tokens', 'UserController@getAllUserToken');
    Route::get('/users/delete/id', 'UserController@revokeToken');
});

Route::post('/login', 'UserController@login');
