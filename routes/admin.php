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
        Route::resource('custom_field', 'custom_field');
        Route::get('/custom_field/editProduct/{id}/{product_id}', 'custom_field@editProduct');
        Route::get('/custom_field/deleteSingle/{id}', 'custom_field@deleteSingle');
        Route::post('/custom_field/deleteMultible', 'custom_field@deleteMultible');

        // reviews
        Route::get('/reviews', 'reviews@index');
        Route::get('/reviews/overview/{id}', 'reviews@overview');
        Route::get('/reviews/deleteSingle/{id}', 'reviews@deleteSingle');
        Route::post('/reviews/deleteMultible', 'reviews@deleteMultible');

        // checkout
        Route::get('/checkout', 'checkouts@index');
        Route::get('/checkout/overview/{id}', 'checkouts@overview');
        Route::post('/checkout/state_multible', 'checkouts@state_multible');
        Route::post('/checkout/state_single/{state}', 'checkouts@state_single');

        // sittings
        Route::get('/sittings', 'sittings@index');
        Route::post('/sittings/create', 'sittings@create');
        Route::post('/sittings/update/{id}', 'sittings@update');

        // admins
        Route::get('/admins/allAdmins', 'admins@allAdmins');
        Route::get('/admins/create', 'admins@create');
        Route::post('/admins/store', 'admins@store');
        Route::get('/admins/edit/{id}', 'admins@edit');
        Route::post('/admins/update/{id}', 'admins@update');
        Route::get('/admins/deleteSingle/{id}', 'admins@deleteSingle');
        Route::post('/admins/deleteMultible', 'admins@deleteMultible');

        Route::get('/home', 'homes@index');

        Route::get('/logout', 'admins@logout');
    });
});