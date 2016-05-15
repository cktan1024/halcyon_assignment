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
						<table id="restaurant-list" class="display" cellspacing="0" width="100%">
						        <thead>
						            <tr>
						            	<th>id</th>
						                <th>Name</th>
						                <th>description</th>
						                <th>category name</th>
						                <th>lat</th>
						                <th>lng</th>
						                <th>Action</th>
						            </tr>
						        </thead>
						        <tbody>

						        <?php 
						        	foreach($list as $key => $value){
						        		?>
						        		
							        		<tr id="restaurant_{{$value['restaurant_id']}}">
												<td>{{$value['restaurant_id']}}</td>
												<td>{{$value['name']}}</td>
												<td>{{$value['description']}}</td>
												<td>{{$value['category_name']}}</td>
												<td>{{$value['lat']}}</td>
												<td>{{$value['lng']}}</td>
												<td>
													<a href="{{ route('adminGetEditRestaurant',$value['restaurant_id']) }}"><span class="btn btn-info">Edit</span></a>
													<button  type="button" class="btn btn-danger delete-restaurant" onclick="delete_restaurant('{{$value['restaurant_id']}}')" >Delete</button>
												</td>
											</tr>							        			
						        		<?php
						        	}
						        ?>
						        </tbody>
						        <tfoot>
						            <tr>
						            	<th>id</th>
						                <th>Name</th>
						                <th>description</th>
						                <th>category_name</th>
						                <th>lat</th>
						                <th>lng</th>
						                <th>Action</th>
						            </tr>
						        </tfoot>
					    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<script>
			$(document).ready(function() {
			    $('#restaurant-list').DataTable( {
			        // "paging":   false,
			        "info":false
			    });
			} );	
			   function delete_restaurant(id){
			   		$.post('{{route("adminPostDeleteRestaurant")}}',{restaurant_id:id,'_token':'{{ csrf_token()}}'},function(e){
			   			result = JSON.parse(e);
			   			if(result.status == "200"){
	   						$('#restaurant_'+id).addClass('deleted'),
							setTimeout(function(){
								location.reload();
							}, 300);
			   					
			   			}else{
							console.log(result.error);
							showMessage('danger',result.error.restaurant_id[0]);			   				
			   			}

			   		});
			   }			
	</script>
@endsection