<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/admin/','LoginController@index');
Route::get('/admin/login','LoginController@index');
Route::post('/admin/login','LoginController@login');
Route::get('/admin/logout', 'MainController@getLogout');

//Route::get('/admin', 'LoginController@index')->name('index');

//Route::get('/admin/index/users','UsersController@getIndex');

//Route::get('/admin/index/menu','MainController@getIndex');
//Route::get('/admin/index/menu','ModuleController@index');
//Route::get('/admin/index/menu','SettingsController@index');

Route::group([
	"prefix"=>"admin",
	"middleware"=>["authAdmin"]
],
	function() {
		// главная (рабочий стол)
		Route::get('/','MainController@getIndex');
		Route::get('/index','MainController@getIndex');
		Route::get('/docs','DocsController@getIndex');

		Route::get('/index/backup','BackupController@getIndex');
		Route::get('/index/backup/sqlBackup','BackupController@sqlBackup');
		Route::get('/index/backup/tarBackup','BackupController@tarBackup');
		Route::get('/index/backup/delBackup','BackupController@delBackup');
		Route::post('/index/backup/upload-xml','BackupController@postUploadXml');
		/*backup*/
//		Route::controller('/index/backup','BackupController');

		/* настройки */
		Route::get('/index/settings','SettingsController@getIndex');

		// пользователи
//		Route::controller('/index/users','UsersController');
		Route::get('/index/users','UsersController@getIndex');
		Route::any('/update/users/{id?}','UsersController@update');
		Route::any('/update/users/{id?}/{apply?}','UsersController@update');

		// модули
		Route::any('/index/{page?}','ModuleController@index');
		Route::get('/update/{page?}','ModuleController@update');
		Route::any('/update/{page?}/{id?}','ModuleController@update');
		Route::any('/update/{page?}/{id?}/{apply?}','ModuleController@update');
		Route::any('/copy/{page?}/{id?}','ModuleController@copy');
		Route::any('/getData/{page?}/{id?}','ModuleController@getData');

		// файлы
		Route::post('/files/upload_img','FilesController@upload_img');
		Route::post('/files/get_crop','FilesController@get_crop');
		Route::post('/files/get_edit','FilesController@get_edit');
		Route::post('/files/set_edit','FilesController@get_edit');
		Route::post('/files/edit_img','FilesController@edit_img');
		Route::post('/files/to_main','FilesController@to_main');
		Route::post('/files/upload_files', 'FilesController@upload_files');
		Route::post('/files/get_edit_file','FilesController@get_edit_file');

		// Plugins
		Route::post('/plugins/getTags','PluginsController@getTags');
		Route::post('/plugins/getTagsList','PluginsController@getTagsList');
		Route::post('/plugins/getCalendarList','PluginsController@getCalendarList');
		Route::post('/plugins/setCalendarRow','PluginsController@setCalendarRow');
		Route::post('/plugins/removeCalendarRow','PluginsController@removeCalendarRow');

		// delete row in mySQL
		Route::post('/rowDelete','MainController@rowDelete');

		// сборщик
		Route::get('/engineer','EngineerController@getIndex');

		// /tools
		Route::post('/_tools/change_param','SettingsController@change_param');
	});
