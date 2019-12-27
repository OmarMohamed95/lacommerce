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

Route::group(['namespace' => 'app'], function(){
    
    // home
    Route::get('/', 'home@index');
    // home
    Route::get('/home', 'home@index')->name('home');

    // search
    Route::post('/search', 'search@search');

    // category
    Route::get('/category/{id}', 'categories@index');
    Route::get('/category/tools/{id}', 'categories@tools');

    // product
    Route::get('/product/index/{id}', 'products@index');

    // product review
    Route::post('products/review/{id}', 'products@review');

    // wishlist
    Route::get('wishlist/{id}', 'wishlists@index');
    Route::get('wishlist/store/{id}', 'wishlists@store');
    Route::get('wishlist/delete/{id}', 'wishlists@delete');

    // cart
    Route::get('cart/index/{id}', 'carts@index');
    Route::post('cart/updateQuantity/{use_id}/{product_id}', 'carts@updateQuantity');
    Route::get('cart/store/{id}', 'carts@store');
    Route::get('cart/delete/{id}', 'carts@delete');

    // checkout
    Route::get('checkout', 'checkouts@index');
    Route::get('checkout/orders/{id}', 'checkouts@orders');
    Route::get('checkout/done/{order_code}', 'checkouts@done');
    Route::get('checkout/track_order', 'checkouts@track_order');
    Route::post('checkouts/trackOrder', 'checkouts@trackOrderByNumber');
    Route::get('checkout/track/{order_code}', 'checkouts@track');
    Route::post('checkout/checkout/{id}', 'checkouts@checkout');

    //profile
    Route::get('profile', 'profile@index');
    Route::post('profile/update', 'profile@update');

});

Auth::routes();



