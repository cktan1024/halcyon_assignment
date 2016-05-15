<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Restaurant;
use App\Category;
use View;


class restaurantController extends Controller
{
    //
    protected $table = 'restaurant';

    protected function getRestaurantsPage(){
    	return View::make('admin/restaurantList');
    }

    protected function getRestaurantList(){
        $list = Restaurant::all();
        return json_encode($list);
    }

    // Get Add New Restaurant Page
    protected function getCreateRestaurant(){
        $categoryList =  Category::all()->toArray();
        return View('admin/restaurantnew',compact('categoryList'));
    }

    // post Add new Restaurant
    public function postCreateRestaurant(){
        $rules  = array(
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:category,category_id',
            'lat' => 'required|between:-90,90',
            'lng' => 'required|between:-180,180'
            );

        $validator  = Validator::make(Input::all(),$rules);

        if($validator->passes()){

            $restaurant = new Restaurant;
            $restaurant->name  = Input::get('name');
            $restaurant->description  = Input::get('description');
            $restaurant->category_id  = Input::get('category_id');
            $restaurant->lat  = Input::get('lat');
            $restaurant->lng  = Input::get('lng');
            $restaurant->save();
            $restaurant->toArray();
            $restaurant->restaurant_id;
            return Redirect::route('adminGetEditRestaurant',[$restaurant->restaurant_id])->with('message',['success' => 'Successfully Added new Restaurant']);

        }else{
            // print_r($validator->messages());
            return Redirect::route('adminGetCreateRestaurant')->withErrors($validator)->withInput()->with('message',['error' => 'Failed to add new Restaurant']);
        }
    }        

    //Get Add Edit restaurant Page
    protected function getEditRestaurant($id){
        $categoryList =  Category::all()->toArray();
        $restaurantInfo =  Restaurant::find($id)->toArray();
        return View('admin/restaurantEdit',compact('categoryList','restaurantInfo'));        
    }

    // post Add new Restaurant
    public function postEditRestaurant(){
        $rules  = array(
            'restaurant_id' => 'required|exists:restaurants,restaurant_id',
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:category,category_id',
            'lat' => 'required|between:-90,90',
            'lng' => 'required|between:-180,180'
            );

        $validator  = Validator::make(Input::all(),$rules);

        if($validator->passes()){

            $restaurant = Restaurant::find(Input::get('restaurant_id'));
            $restaurant->name  = Input::get('name');
            $restaurant->description  = Input::get('description');
            $restaurant->category_id  = Input::get('category_id');
            $restaurant->lat  = Input::get('lat');
            $restaurant->lng  = Input::get('lng');
            $restaurant->save();
            $restaurant->toArray();
            $restaurant->restaurant_id;
            return Redirect::route('adminGetEditRestaurant',[Input::get('restaurant_id')])->with('message',['success' => 'Successfully Edited Restaurant information']);

        }else{
            // print_r($validator->messages());
            return Redirect::route('adminGetEditRestaurant',[Input::get('restaurant_id')])->withErrors($validator)->withInput()->with('message',['error' => 'Failed to Edit Restaurant Information']);
        }
    }     

}
