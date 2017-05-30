<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//后台业务
Route::any('admins/login','Admin\LoginController@login');
Route::group(['prefix'=>'admins','namespace'=>'Admin','middleware'=>['admin.login']],function(){
	Route::any('index','IndexController@index');
	Route::any('info','IndexController@info');
	Route::any('quit','IndexController@quit');
	Route::any('pass','IndexController@pass');
	Route::any('order','CategoryController@order');
	Route::resource('category','CategoryController');
	Route::resource('article','ArticleController');
	Route::any('upload','CommonController@upload');
	Route::resource('links','LinksController');
	Route::resource('nav','NavController');
	Route::resource('conf','ConfController');
	Route::post('modify','ConfController@modify');
});

Route::get('validate_code/create','Service\ValidateController@create');
Route::any('/crypt','Admin\LoginController@crypt');