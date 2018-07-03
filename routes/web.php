<?php

Auth::routes();

Route::group(
  ['middleware' => array_merge(['site'], (env('APP_VERSION') === 'develop' ? ['auth.basic'] : [])), 'prefix' => ''],

  function() {
    Route::get('/', 'MainController@main');
    Route::get('/services/{id?}', 'MainController@services');
    Route::get('/blog/{id?}', 'MainController@blog');
    Route::get('/contact-us', 'MainController@contact_us');
    Route::get('/about-company', 'MainController@about_company');
    Route::get('/portfolio/{page?}', 'MainController@portfolio');


    Route::get('/form', 'MainController@form');

    // Catalog
    Route::get('/catalog/{name?}/{id?}', 'MainController@catalog');
    Route::post('/_tools/search_render_catalog', 'MainController@search_render_catalog');

    Route::get('/selection-request', 'MainController@selection_request');
    Route::get('/search/{page?}', 'MainController@search');

    // Favorite
    Route::get('/favorite', 'MainController@favorite');
    Route::post('/_tools/add_favorite', 'MainController@add_favorite');
    Route::post('/_tools/submit_required', 'MainController@submit_required');

    // Admin Panel
    Route::get('/admin/', 'Admin::LoginController@index');

    // Page
    Route::get('/{name?}', 'MainController@page');
  }
);
