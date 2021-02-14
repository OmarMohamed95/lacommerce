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
        Route::get('/carts/total-price', 'CartController@getTotalPrice')->name('api_cart_total_price');
        Route::put('/carts/{productId}/quantity', 'CartController@updateQuantity')->name('api_cart_update_quantity');
        Route::post('/carts', 'CartController@store')->name('api_cart_store');
        Route::delete('/carts/{productId}', 'CartController@delete')->name('api_cart_delete');
        
    });
});
