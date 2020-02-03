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

Route::group(['middleware' => ['jwt.verify:admin']], function () {
    Route::post('user', 'AdminController@getAuthenticatedUser');
    Route::post('user/update', 'AdminController@update');

    Route::group(['prefix' => 'companies'], function () {
        Route::get('index', 'CompanyController@index');
        Route::get('get', 'CompanyController@get');
        Route::post('sync', 'CompanyController@sync');
        Route::delete('destroy', 'CompanyController@destroy');
    });
    Route::group(['prefix' => 'persons'], function () {
        Route::get('index', 'PersonController@index');
        Route::get('get', 'PersonController@get');
        Route::post('sync', 'PersonController@sync');
        Route::delete('destroy', 'PersonController@destroy');
    });

    Route::group(['prefix' => 'customers'], function () {
        $controller = 'CustomerController';
        Route::get('index', $controller . '@index');
        Route::get('get/selects', $controller . '@getSelectsItems');
        Route::get('search', $controller . '@search');
        Route::post('create', $controller . '@create');
        Route::delete('destroy', $controller . '@destroy');
    });

    Route::group(['prefix' => 'items'], function () {
        $controller = 'ItemController';
        Route::get('index', $controller . '@index');
        Route::post('sync', $controller . '@sync');
        Route::get('get', $controller . '@get');
        Route::get('search', $controller . '@search');
        Route::delete('destroy', $controller . '@destroy');

        Route::group(['prefix' => 'categories'], function () {
            $controller = 'ItemCategoryController';
            Route::get('index', $controller . '@index');
            Route::get('get', $controller . '@get');
            Route::get('search', $controller . '@search');
            Route::post('sync', $controller . '@sync');
            Route::delete('destroy', $controller . '@destroy');
        });
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'currencies'], function () {
            $controller = 'CurrencyController';
            Route::get('index', $controller . '@index');
            Route::get('get', $controller . '@get');
            Route::get('get', $controller . '@get');
            Route::post('sync', $controller . '@sync');
            Route::delete('destroy', $controller . '@destroy');
        });
        Route::group(['prefix' => 'taxes'], function () {
            $controller = 'TaxController';
            Route::get('index', $controller . '@index');
            Route::get('get', $controller . '@get');
            Route::get('search', $controller . '@search');
            Route::post('sync', $controller . '@sync');
            Route::delete('destroy/{item}', $controller . '@destroy');
        });
    });
    Route::group(['prefix' => 'incomes'], function () {
        Route::group(['prefix' => 'categories'], function () {
            $controller = 'InvoiceCategoryController';
            Route::get('index', $controller . '@index');
            Route::get('get', $controller . '@get');
            Route::post('sync', $controller . '@sync');
            Route::delete('destroy/{item}', $controller . '@destroy');
        });

        Route::group(['prefix' => 'invoices'], function () {
            $controller = 'InvoiceController';
            Route::get('number', $controller . '@getNumber');
        });
    });


    Route::post('logout', 'Auth\AuthController@logout');
});

