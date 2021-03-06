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
        
        // review
        Route::post('/reviews/{productId}', 'ReviewController@review')->name('product_review');
        
        // wishlist
        Route::post('wishlists/{productId}', 'WishlistController@store')->name('wishlist_product_store');
        Route::delete('wishlists/{productId}', 'WishlistController@delete')->name('wishlist_product_delete');

        //order
        Route::put('/orders/{order}/status', 'OrderController@updateStatus')->name('api_order_update_status');
    });
});
