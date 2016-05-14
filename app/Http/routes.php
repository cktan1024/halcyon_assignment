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

Route::get('/', function () {
    return view('welcome');
});


Route::get('admin/login', array("as"=>"adminGetLogin", 'uses'=>"AdminController@getLogin"));
Route::post('admin/login', array("as"=>"adminGetLogin", 'uses'=>"AdminController@postLogin"));

Route::group(array('prefix'=>'admin','middleware' => ['auth','web']),function(){
	Route::get('',function(){
		return View('admin/home');
	});
});
