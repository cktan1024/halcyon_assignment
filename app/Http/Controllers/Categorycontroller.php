<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Category;

class Categorycontroller extends Controller
{
    protected function postAddCategory(){
    	$rules = array('category' =>'required|unique:category,name');

    	$validator =  Validator::make(Input::all(),$rules);

    	if($validator->passes()){
    		$result['status'] = "200";

    		$category =  new Category;
    		$category->name= Input::get('category');
    		$category->save();
    		$category->toArray();
    		$result['category'] = $category;
    	}else{
    		$result['status'] = "401";
    		$result['error'] = $validator->messages();
    	}
    	return json_encode($result);
    }

    protected function postDeleteCategory(){
    	$rules  = array('category_id' => 'required|exists:category,category_id');

    	$validator = Validator::make(Input::all(),$rules);

    	if($validator->passes()){
    		$result['status'] = "200";
    		Category::where('category_id',"=",Input::get('category_id'))->delete();
    		$result['category_id'] = Input::get('category_id');
    	}else{
    		$result['status'] = "401";
    		$result['error'] = $validator->messages();
    	}
		return json_encode($result);    	
    }
}
