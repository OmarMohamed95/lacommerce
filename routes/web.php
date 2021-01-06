<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App'], function(){
    
    // home
    Route::get('/', 'DefaultController@index');
    // home
    Route::get('/home', 'DefaultController@index')->name('home_index');

    // search
    Route::post('/search', 'SearchController@search')->name('search_action');

    // category
    Route::get('/category/{id}', 'CategoryController@index')->name('category_index');

    // product
    Route::get('/product/index/{id}', 'ProductController@index')->name('product_index');
    Route::post('products/review/{id}', 'ProductController@review')->name('product_review');

    // wishlist
    Route::get('wishlist/{id}', 'WishlistController@index')->name('wishlist_index');
    Route::get('wishlist/store/{id}', 'WishlistController@store')->name('wishlist_store');
    Route::get('wishlist/delete/{id}', 'WishlistController@delete')->name('wishlist_delete');

    // cart
    Route::get('cart/index/{id}', 'CartController@index')->name('cart_index');
    Route::post('cart/updateQuantity', 'CartController@updateQuantity')->name('cart_update_quantity');
    Route::get('cart/store/{id}', 'CartController@store')->name('cart_index')->name('cart_store');
    Route::get('cart/delete/{id}', 'CartController@delete')->name('cart_index')->name('cart_delete');

    // checkout
    Route::get('checkout', 'CheckoutController@index')->name('checkout_index');
    Route::get('checkout/orders/{id}', 'CheckoutController@myOrders')->name('checkout_orders');
    Route::get('checkout/done/{order_code}', 'CheckoutController@done')->name('checkout_done');
    Route::any('checkouts/trackOrder/{orderCode?}', 'CheckoutController@trackOrderByCode')->name('checkout_track_code');
    Route::post('checkout/checkout/{id}', 'CheckoutController@checkout')->name('checkout_action');

    //profile
    Route::get('profile', 'ProfileController@index')->name('profile_index');
    Route::post('profile/update', 'ProfileController@update')->name('profile_update_action');

});

Auth::routes();



