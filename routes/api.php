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

    Route::group(['prefix'=>'companies'],function (){
        Route::get('get', 'CompaniesController@getCompanies');
        Route::get('get/all', 'CompaniesController@getCompaniesAll');
        Route::get('get/{company}', 'CompaniesController@getCompany');
        Route::post('sync', 'CompaniesController@sync');
        Route::delete('destroy/{company}', 'CompaniesController@destroy');
    });
    Route::group(['prefix'=>'persons'],function (){
        Route::get('get', 'PersonsController@getPersons');
        Route::get('get/all', 'PersonsController@getPersonsAll');
        Route::get('get/{person}', 'PersonsController@getPerson');
        Route::post('sync', 'PersonsController@sync');
        Route::delete('destroy/{person}', 'PersonsController@destroy');
    });

    Route::group(['prefix'=>'customers'],function (){
        $controller = 'CustomersController';
        Route::get('get', $controller.'@getCustomers');
        Route::get('get/companies', $controller.'@getCustomersCompanies');
        Route::get('get/persons', $controller.'@getCustomersPersons');
        Route::get('get/selects', $controller.'@getSelectsItems');
        Route::post('create', $controller.'@create');
        Route::delete('destroy/{customer}', $controller.'@destroy');
    });

    Route::group(['prefix'=>'items'],function (){
        $controller = 'ItemsController';
        Route::get('index',$controller.'@index');
        Route::post('create',$controller.'@sync');
        Route::get('get/{item}',$controller.'@getItem');
        Route::delete('destroy/{item}',$controller.'@destroy');

        Route::group(['prefix'=>'categories'],function (){
            $controller = 'ItemCategoriesController';
            Route::get('index',$controller.'@index');
            Route::get('get/{category}',$controller.'@getCategory');
            Route::get('search',$controller.'@search');
            Route::post('create',$controller.'@sync');
            Route::delete('destroy/{category}',$controller.'@destroy');

        });

    });



    Route::post('logout', 'Auth\AuthController@logout');
});

