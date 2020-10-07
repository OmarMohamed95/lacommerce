<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){

    Config::set('auth.defines', 'admin');

    Route::get('/login', 'admins@index');
    Route::post('/login', 'admins@checkLogin')->name('admin.login.submit');
    Route::get('/', 'admins@index');

    Route::group(['middleware' => 'admin:admin'], function(){

        // categories
        Route::resource('categories', 'CategoryController');
        Route::get('/categories/deleteSingle/{id}', 'CategoryController@deleteSingle');
        Route::post('/categories/deleteMultible', 'CategoryController@deleteMultible');

        // products
        Route::resource('products', 'ProductController');
        Route::get('/products/getBrandsByCat/{id}', 'ProductController@getBrandsByCat');
        Route::get('/products/deleteSingle/{id}', 'ProductController@deleteSingle');
        Route::post('/products/deleteMultible', 'ProductController@deleteMultible');

        // offers
        Route::resource('offers', 'OfferController');
        Route::get('/offers/deleteSingle/{id}', 'OfferController@deleteSingle');
        Route::post('/offers/deleteMultible', 'OfferController@deleteMultible');

        // brands
        Route::resource('brands', 'BrandController');
        Route::get('/brands/deleteSingle/{id}', 'BrandController@deleteSingle');
        Route::post('/brands/deleteMultible', 'BrandController@deleteMultible');

        // custom field
        Route::resource('custom_field', 'CustomFieldController');
        Route::get('/custom_field/editProduct/{id}/{product_id}', 'CustomFieldController@editProduct');
        Route::get('/custom_field/deleteSingle/{id}', 'CustomFieldController@deleteSingle');
        Route::post('/custom_field/deleteMultible', 'CustomFieldController@deleteMultible');

        // reviews
        Route::get('/reviews', 'ReviewController@index');
        Route::get('/reviews/overview/{id}', 'ReviewController@overview');
        Route::get('/reviews/deleteSingle/{id}', 'ReviewController@deleteSingle');
        Route::post('/reviews/deleteMultible', 'ReviewController@deleteMultible');

        // checkout
        Route::get('/checkout', 'CheckoutController@index');
        Route::get('/checkout/overview/{id}', 'CheckoutController@overview');
        Route::post('/checkout/state_multible', 'CheckoutController@state_multible');
        Route::post('/checkout/state_single/{state}', 'CheckoutController@state_single');

        // sittings
        Route::get('/sittings', 'SettingController@index');
        Route::post('/sittings/create', 'SettingController@create');
        Route::post('/sittings/update/{id}', 'SettingController@update');

        // admins
        Route::get('/admins/allAdmins', 'AdminController@allAdmins');
        Route::get('/admins/create', 'AdminController@create');
        Route::post('/admins/store', 'AdminController@store');
        Route::get('/admins/edit/{id}', 'AdminController@edit');
        Route::post('/admins/update/{id}', 'admins@update');
        Route::get('/admins/deleteSingle/{id}', 'AdminController@deleteSingle');
        Route::post('/admins/deleteMultible', 'AdminController@deleteMultible');

        Route::get('/home', 'HomeController@index');

        Route::get('/logout', 'admins@logout');
    });
});