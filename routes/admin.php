<?php

Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function(){
    
    Route::get('/', 'DefaultController@index');

    // categories
    Route::get('/categories', 'CategoryController@index')->name('admin_category_index');
    Route::get('/categories/create', 'CategoryController@create')->name('admin_category_create');
    Route::post('/categories/store', 'CategoryController@store')->name('admin_category_store');
    Route::get('/categories/{categoryId}/edit', 'CategoryController@edit')->name('admin_category_edit');
    Route::put('/categories/{categoryId}', 'CategoryController@update')->name('admin_category_update');
    Route::any('/categories/delete/{categoryId?}', 'CategoryController@delete')->name('admin_category_delete');

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
    Route::get('/brands', 'BrandController@index')->name('admin_brand_index');
    Route::get('/brands/create', 'BrandController@create')->name('admin_brand_create');
    Route::post('/brands/store', 'BrandController@store')->name('admin_brand_store');
    Route::get('/brands/{brandId}/edit', 'BrandController@edit')->name('admin_brand_edit');
    Route::put('/brands/{brandId}', 'BrandController@update')->name('admin_brand_update');
    Route::any('/brands/delete/{brandId?}', 'BrandController@delete')->name('admin_brand_delete');

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

    // order
    Route::get('/order', 'OrderController@index')->name('admin_order_index');
    Route::get('/order/{order}/overview', 'OrderController@overview')->name('admin_order_overview');
    Route::post('/order/state_multible', 'OrderController@updateStatus')->name('admin_order_multiple_state');

    // sittings
    Route::get('/sittings', 'SettingController@index');
    Route::post('/sittings/create', 'SettingController@create');
    Route::post('/sittings/update/{id}', 'SettingController@update');

    // admins
    Route::get('/user', 'UserController@index')->name('admin_user_index');
});