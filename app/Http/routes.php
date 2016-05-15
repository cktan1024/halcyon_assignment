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
Route::post('admin/login', array("as"=>"adminPostLogin", 'uses'=>"AdminController@postLogin"));



Route::group(array('prefix'=>'admin','middleware' => ['auth']),function(){
	Route::get('',['as'=>'adminGetHomePage',  'uses' => 'AdminController@getHomePage']);

	Route::get('restaurant', ["uses" => "RestaurantController@getRestaurantsPage"]);
	Route::get('restaurant/list',['uses' => 'RestaurantController@getRestaurantList']);

	//Add new Restaurant
	Route::get('restaurant/create',array('as' => 'adminGetCreateRestaurant'  , 'uses'=>'RestaurantController@getCreateRestaurant'));
	Route::post('restaurant/create',array('as' => 'adminPostCreateRestaurant' ,'uses'=>'RestaurantController@postCreateRestaurant'));

	//Edit Restaurant
	Route::get('restaurant/edit/{id}',array('as'=>"adminGetEditRestaurant","uses"=>"RestaurantController@getEditRestaurant"));
	Route::get('restaurant/edit',["uses"=>"RestaurantController@getRestaurantList"]);
	Route::post('restaurant/edit/',array('as'=>"adminPostEditRestaurant","uses"=>"RestaurantController@postEditRestaurant"));
	Route::post('restaurant/delete/',array('as'=>"adminPostDeleteRestaurant","uses"=>"RestaurantController@postEditRestaurant"));

	//Add New Category and delete Category
	Route::post('restaurant/category/create', array('as' => 'adminPostAddCategory', 'uses' =>'CategoryController@postAddCategory'));
	Route::post('restaurant/category/delete',array('as' => "adminPostDeleteCategory", 'uses' => 'CategoryController@postDeleteCategory'));

	Route::get('logout',array( "as"=>"adminGetLogout", 'uses' => 'AdminController@getLogout'));
});
