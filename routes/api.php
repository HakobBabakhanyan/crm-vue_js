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

Route::post('login', 'Auth\AuthController@login');

Route::group(['middleware' => ['jwt.verify:admin']], function() {
    Route::post('user', 'AdminController@getAuthenticatedUser');
    Route::post('user/update', 'AdminController@update');
    Route::get('companies/get', 'CompaniesController@getCompanies');
    Route::get('companies/get/{company}', 'CompaniesController@getCompany');
    Route::post('companies/sync', 'CompaniesController@sync');
    Route::delete('companies/destroy/{company}', 'CompaniesController@destroy');
    Route::post('logout', 'Auth\AuthController@logout');
});

