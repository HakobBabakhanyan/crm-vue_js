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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', 'Auth\AuthController@login');

Route::group(['middleware' => ['jwt.verify:admin']], function() {
    Route::post('user', 'AdminController@getAuthenticatedUser');
    Route::post('user/update', 'AdminController@update');

    Route::group(['prefix'=>'companies'],function (){
        Route::get('index', 'CompaniesController@index');
        Route::get('get', 'CompaniesController@get');
        Route::post('sync', 'CompaniesController@sync');
        Route::delete('destroy', 'CompaniesController@destroy');
    });
    Route::group(['prefix'=>'persons'],function (){
        Route::get('index', 'PersonsController@index');
        Route::get('get', 'PersonsController@get');
        Route::post('sync', 'PersonsController@sync');
        Route::delete('destroy', 'PersonsController@destroy');
    });

    Route::group(['prefix'=>'customers'],function (){
        $controller = 'CustomersController';
        Route::get('get', $controller.'@getCustomers');
        Route::get('get/companies', $controller.'@getCustomersCompanies');
        Route::get('search/companies',$controller.'@searchCompanies');
        Route::get('get/persons', $controller.'@getCustomersPersons');
        Route::get('search/persons',$controller.'@searchPersons');
        Route::get('get/selects', $controller.'@getSelectsItems');
        Route::post('create', $controller.'@create');
        Route::delete('destroy/{customer}', $controller.'@destroy');
    });

    Route::group(['prefix'=>'items'],function (){
        $controller = 'ItemsController';
        Route::get('index',$controller.'@index');
        Route::post('sync',$controller.'@sync');
        Route::get('get/{item}',$controller.'@getItem');
        Route::delete('destroy/{item}',$controller.'@destroy');

        Route::group(['prefix'=>'categories'],function (){
            $controller = 'ItemCategoriesController';
            Route::get('index',$controller.'@index');
            Route::get('get/{category}',$controller.'@getCategory');
            Route::get('search',$controller.'@search');
            Route::post('sync',$controller.'@sync');
            Route::delete('destroy/{category}',$controller.'@destroy');
        });
    });

    Route::group(['prefix'=>'settings'],function (){
       Route::group(['prefix'=>'currencies'],function (){
          $controller = 'CurrenciesController';
          Route::get('index',$controller.'@index');
           Route::get('get/all',$controller.'@getAll');
           Route::get('get/{item}',$controller.'@getItem');
           Route::post('sync',$controller.'@sync');
           Route::delete('destroy/{item}',$controller.'@destroy');
       });
       Route::group(['prefix'=>'taxes'],function (){
           $controller = 'TaxesController';
           Route::get('index',$controller.'@index');
           Route::get('get/{item}',$controller.'@getItem');

           Route::post('sync',$controller.'@sync');
           Route::delete('destroy/{item}',$controller.'@destroy');
       });
    });
    Route::group(['prefix'=>'incomes'],function (){
        Route::group(['prefix'=>'categories'],function (){
            $controller = 'IncomeCategoriesController';
            Route::get('index',$controller.'@index');
            Route::get('get/{item}',$controller.'@getItem');

            Route::post('sync',$controller.'@sync');
            Route::delete('destroy/{item}',$controller.'@destroy');
        });
    });



    Route::post('logout', 'Auth\AuthController@logout');
});

