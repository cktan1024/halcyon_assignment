@extends('layouts.admin')

@section('content')
	<div class="container admin-panel">
	    <div class="row">
	        <div class="col-md-12">
	        	<div class='text-right'>
	            		<a href="{{route('adminGetCreateRestaurant')}}" class="btn btn-lg btn-info add-new-btn">Add New Restaurant</a>
            	</div>
	            <div class="panel panel-default">
	                <div class="panel-heading">Restaurant List</div>
	
	                <div class="panel-body">
	                	<?php 
	                	
	                	?>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection