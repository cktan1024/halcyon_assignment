<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class adminController extends Controller
{
    //

	// Get Login Page
    public function getLogin(){
    	return View('admin/login');
    }
}
