<?php

namespace App;
use Hash;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    // Declare Tabe Admin
   	protected $table =  "admins";
   	protected$primaryKey =  "admin_id";

   	function setPasswordAttribute($value){
   		$this->attributes['password'] =  Hash::make($value);
   	}
}
