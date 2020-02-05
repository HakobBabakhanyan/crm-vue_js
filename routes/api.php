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
function resources($controller,$item = 'item'){
    Route::get('index', $controller.'@index');
    Route::get('history', $controller.'@history');
    Route::get("show/{{$item}}", $controller.'@show');
    Route::get('get', $controller.'@get');
    Route::post('create', $controller.'@create');
    Route::put("update/{{$item}}", $controller.'@update');
    Route::delete("destroy/{{$item}}", $controller.'@destroy');
}


Route::group(['middleware' => ['jwt.verify:admin']], function () {
    Route::post('user', 'AdminController@getAuthenticatedUser');
    Route::post('user/update', 'AdminController@update');

    Route::group(['prefix' => 'companies'], function () {
        resources('CompanyController','company');
    });

    Route::group(['prefix' => 'persons'], function () {
        resources('PersonController','person');
    });

    Route::group(['prefix' => 'customers'], function () {
        $controller = 'CustomerController';
        resources($controller,'customer');
        Route::get('get/selects', $controller . '@getSelectsItems');
    });

    Route::group(['prefix' => 'items'], function () {
        $controller = 'ItemController';
        resources('ItemController','item');
        Route::group(['prefix' => 'categories'], function () {
            Route::get('search',"ItemCategoryController@search");
            resources('ItemCategoryController','category');
        });
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'currencies'], function () {
            $controller = 'CurrencyController';
            Route::get('index', $controller . '@index');
            Route::get('get', $controller . '@get');
            Route::get('search', $controller . '@search');
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

