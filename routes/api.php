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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['jwt.verify:admin']], function() {
    Route::post('user', 'AdminController@getAuthenticatedUser');
    Route::post('user/update', 'AdminController@update');
    Route::get('user', 'AdminController@getAuthenticatedUser');
    Route::post('logout', 'AuthController@logout');
});

