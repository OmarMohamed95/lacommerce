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
    Route::get('/', 'DefaultController@index')->name('home_index');

    // category
    Route::get('/category/{id}', 'CategoryController@index')->name('category_index');

    // product
    Route::get('/product/{id}', 'ProductController@index')->name('product_index');

    // wishlist
    Route::get('wishlist', 'WishlistController@index')->name('wishlist_index');

    // cart
    Route::get('cart', 'CartController@index')->name('cart_index');

    // order
    Route::get('order', 'OrderController@index')->name('order_index');
    Route::get('order/my-orders', 'OrderController@myOrders')->name('order_my_orders');
    Route::get('order/done/{orderId}', 'OrderController@done')->name('order_done');
    Route::any('orders/trackOrder/{orderId?}', 'OrderController@trackOrderByCode')->name('order_track');
    Route::post('order/checkout', 'OrderController@checkout')->name('order_checkout_action');

    //profile
    Route::get('profile', 'ProfileController@index')->name('profile_index');
    Route::post('profile/update', 'ProfileController@update')->name('profile_update_action');

});

Auth::routes();



