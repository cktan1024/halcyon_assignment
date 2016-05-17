<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    //completed
    public function getNearestRestaurant(){
        $rules = array("distance" => "numeric",
            'category_id' => 'integer|exists:category,category_id',
            'lat' => 'required|numeric|min:-90|max:90',
            'lng' => 'required|numeric|min:-180|max:180',
            'amount' => 'integer'
            );
        $input  = Input::all();
        $validator = Validator::make($input,$rules);

        if($validator->passes()){

            if(!isset($input['distance']) or $input['distance'] == ""){
                // default distance 5km
                $input['distance'] =  5;
            }
            if(!isset($input['amount']) or $input['amount'] == ""){
                // Default fetch 1o restautant
                $input['amount'] = 10;
            }

            
            $RestaurantList  = DB::table("restaurants")->join("category",function($join) use($input){

                $join->on("restaurants.category_id","=","category.category_id");

                if(isset($input['category_id']) and $input['category_id'] != ""){
                    echo "1";
                    $join->where('category.category_id','=',$input['category_id']);
                }   

            })
            ->select(DB::raw("restaurants.*,category.name as category_name,( 6371 * acos( cos( radians(".$input['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$input['lng'].") ) + sin( radians(".$input['lat'].") ) * sin( radians( lat ) ) ) ) AS distance"))->orderBy("distance","ASC")
            ->having("distance","<=",$input['distance'])
            ->get($input['amount']);    

            $result['status']    = "200";
            $result['message'] = "sucessfully get nearest restaurant";
            $result["restaurant_list"] = $RestaurantList;        
        }else{
            $result['status'] ="500";
            $result['message'] = "Failed to retrieve nearest restraurant list";
            $result['error'] = $validator->messages();
        }

        return json_encode($result);
    }    
}
