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
use DB;


class restaurantController extends Controller
{
    //
    protected $table = 'restaurant';

    protected function getRestaurantsPage(){
    	// $list = Restaurant::all()->toArray();
        $list  = DB::table('restaurants')->leftJoin('category',function($join){
            $join->on("restaurants.category_id","=",'category.category_id');
        })->select('restaurants.*','category.name as category_name')->get();
    	return View::make('admin/restaurantList',compact('list'));
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
            'lat' => 'required|numeric|min:-90|max:90',
            'lng' => 'required|numeric|min:-180|max:180'
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
            return Redirect::route('adminGetCreateRestaurant')->withErrors($validator)->withInput()->with('message',['warning' => 'Failed to add new Restaurant']);
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
            'lat' => 'required|numeric|min:-90|max:90',
            'lng' => 'required|numeric|min:-180|max:180'
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
            return Redirect::route('adminGetEditRestaurant',[Input::get('restaurant_id')])->withErrors($validator)->withInput()->with('message',['warning' => 'Failed to Edit Restaurant Information']);
        }
    }     

    //post Delete Restaurant
    public function postDeleteRestaurant(){
        $rules = array(
            'restaurant_id' => 'required|exists:restaurants,restaurant_id',
            );

        $validator =  Validator::make(Input::all(),$rules);

        if($validator->passes()){
            $result['status'] = "200";
            Restaurant::find(Input::get('restaurant_id'))->delete();
        }else{            
            $result['status'] = "401";
            $result['error'] =  $validator->messages();
        }

        return json_encode($result);
    }
}
