<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    /**
     * Acceso libre
     */
    Route::post('login', 'AuthController@login');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::group(['middleware' => 'auth:api'], function() {
    // Rutas generales de usuario logeado
    Route::get('client', 'ClientController@list');

    Route::get('currency', 'CurrencyController@list');

    Route::get('category', 'CategoryController@list');
    Route::put('category/{id}', 'CategoryController@update');
    Route::delete('category/{id}', 'CategoryController@delete');

    /**
     * Acceso administrador
     */
    Route::group(['middleware' => 'is_admin'], function() {
        // Rutas de monedas
        Route::post('currency', 'CurrencyController@store');
        Route::put('currency/{id}', 'CurrencyController@update');
        Route::delete('currency/{id}', 'CurrencyController@delete');

        // Rutas de clientes
        Route::post('client', 'ClientController@store');
        Route::get('client/{id}', 'ClientController@details');
        Route::put('client/{id}', 'ClientController@update');
        Route::delete('client/{id}', 'ClientController@delete');
        Route::put('client/{id}/profile', 'ClientController@upload');

        // Rutas de categorias
        Route::post('category', 'CategoryController@storeCategory');
    });

    Route::group(['middleware' => 'is_client'], function() {
        // Detalles de cliente
        Route::get('client/{id}', 'ClientController@details');
        
        // Rutas de Categorias
        Route::post('category', 'CategoryController@storeClientCategory');
        
        // Rutas de movimientos
        Route::get('balance', 'ClientMovementController@getBalance');
        Route::get('daily-expenses', 'ClientMovementController@dailyExpensesReport');
        Route::get('category-expenses', 'ClientMovementController@categoryExpensesReport');
        Route::get('projection-expenditure', 'ClientMovementController@projectionExpenditureReport');

        Route::get('movement', 'ClientMovementController@list');
        Route::post('movement', 'ClientMovementController@newMovement');
        Route::put('movement/{id}', 'ClientMovementController@update');
        Route::delete('movement/{id}', 'ClientMovementController@delete');
    });
});

Route::fallback(function(){
    return response()->json(['message' => 'Page Not Found.'], 404);
});