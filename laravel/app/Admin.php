<?php

namespace App;
use Hash;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //
    // Declare Tabe Admin
   	protected $table =  "admins";
   	protected $primaryKey =  "admin_id";
    protected $hidden = [
        'password', 'remember_token',
    ];

   	protected function setPasswordAttribute($value){
   		$this->attributes['password'] =  Hash::make($value);
   	}
}
