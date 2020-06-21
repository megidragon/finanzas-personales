<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    /**
     * Acceso libre
     */
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::group(['middleware' => 'auth:api'], function() {
    /**
     * Acceso administrador
     */
    Route::group(['middleware' => 'is_admin'], function() {
        Route::get('currency', 'CurrencyController@list');
        Route::post('currency', 'CurrencyController@store');
        Route::put('currency/{id}', 'CurrencyController@update');
        Route::delete('currency/{id}', 'CurrencyController@delete');

        Route::get('client', 'ClientController@list');
        Route::post('client', 'ClientController@store');
        Route::get('client/{id}', 'ClientController@details');
        Route::put('client/{id}', 'ClientController@update');
        Route::delete('client/{id}', 'ClientController@delete');
        Route::put('client/{id}/profile', 'ClientController@upload');

        
    });
  });

Route::fallback(function(){
    return response()->json(['message' => 'Page Not Found.'], 404);
});