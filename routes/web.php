<?php

Auth::routes();

Route::group(
	['middleware' => array_merge(['site'], (env('APP_VERSION') === 'develop' ? ['auth.basic'] : [])), 'prefix' => ''],

	function() {
		Route::get('/', 'MainController@main');
		Route::get('/services/{id?}', 'MainController@services');

		Route::get('/selection-request', 'MainController@selection_request');
		Route::get('/catalog/{name?}/{id?}', 'MainController@catalog');
		Route::get('/blog/{id?}', 'MainController@blog');
		Route::get('/about-us', 'MainController@about_us');
		Route::get('/about-company', 'MainController@about_company');
		Route::get('/contact-us', 'MainController@contact_us');
		Route::get('/vacancies/{id?}', 'MainController@vacancies');
		Route::get('/location/{id}', 'MainController@location');
		Route::get('/request-for-accommodation', 'MainController@request_for_accommodation');
		Route::get('/search/{page?}', 'MainController@search');

		// Favorite
		Route::get('/favorite', 'MainController@favorite');
		Route::post('/_tools/add_favorite', 'MainController@add_favorite');
		Route::post('/_tools/search_render_villas', 'MainController@search_render_villas');
		Route::post('/_tools/submit_required', 'MainController@submit_required');

		Route::get('/admin/', 'Admin::LoginController@index');

		// Page
		Route::get('/{name?}', 'MainController@page');
	}
);
