<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Auth;

class adminController extends Controller
{
    //

	// Get Login Page
    public function getLogin(){
    	return View('admin/login');
    }

    public function postLogin(){
    	$rules = array(
    		'email' => 'required|email',
    		'password' => 'required'
    		);

    	$validator  =  Validator::make(Input::all(),$rules);

    	if($validator->passes()){
    		// Here Do Authentication
	        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
	            // Authentication passed...
	            return Redirect::to('/');
	        }else{
	        	return Redirect::to('admin/login')->withInput()->with('error',"Wrong Password and Username password combination");
	        }
    	}else{
    		// return 

    		return Redirect::to('admin/login')->withErrors($validator)->with('error','Something wrong, please insert username and password correctly');
    	}

    }
}
