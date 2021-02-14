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

Route::group(['namespace' => 'Api'], function(){
    // search
    Route::get('/search', 'SearchController@search')->name('api_search_action');
    
    Route::group(['middleware' => 'auth:api'], function() {
        // cart
        Route::get('/cart/total-price', 'CartController@getTotalPrice')->name('api_cart_total_price');
        Route::put('/cart/updateQuantity', 'CartController@updateQuantity')->name('api_cart_update_quantity');
        Route::post('/cart/store', 'CartController@store')->name('api_cart_store');
        Route::delete('/cart/delete/{id}', 'CartController@delete')->name('api_cart_delete');
        
    });
});
