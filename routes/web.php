<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    $p = Redis::incr('p');
    return $p;
});

Route::get("getUserDb", "UserController@getUserDb");
Route::get("getUserRedis", "UserController@getUserRedis");
Route::get("getUserRedisById/{id}", "UserController@getUserRedisById");