<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Auth;
class AdminController extends Controller
{
    //

	// Get Login Page
    protected function getLogin(){
    	return View('admin/login');
    }

    protected function postLogin(){
    	$rules = array(
    		'email' => 'required|email',
    		'password' => 'required'
    		);

    	$validator  =  Validator::make(Input::all(),$rules);

    	if($validator->passes()){
    		// Here Do Authentication
	        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
	            // Authentication passed...
	            return Redirect::to('admin/');
	        }else{
	        	return Redirect::to('admin/login')->withInput()->with('error',"Wrong Password and Username password combination");
	        }
    	}else{
    		// return 
    		return Redirect::route('adminGetLogin')->withErrors($validator)->with('error','Something wrong, please insert username and password correctly');
    	}

    }

    protected function getHomePage(){
    	return View("admin/home");
    }

    protected function getLogout(){
    	Auth::logout();
    	return Redirect::to("/admin");
    }

}
