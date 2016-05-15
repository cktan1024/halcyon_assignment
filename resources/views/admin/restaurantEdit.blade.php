@extends('layouts.admin')

@section('content')

	<div class="container admin-panel">
	    <div class="row">
	        <div class="col-md-12">
	            <div class="panel panel-default">
	                <div class="panel-heading">Edit Restaurant</div>
	
	                <div class="panel-body">
	                	<form action="{{ route('adminPostEditRestaurant') }}" method="post">
	                		<input type="hidden" name="restaurant_id" value="{{$restaurantInfo['restaurant_id']}}">
	                		{{ csrf_field() }}
                			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                			<div class="form-group">
		                			<label for="name">Restaurant Name</label>
		                			<input type="text" name="name" id="name" class="form-control" placeholder="Restaurant Name" value="<?php if(old('name') !== null ){ echo old('name'); }else{ echo $restaurantInfo['name']; }  ?>">
		                			@if($errors->has('name'))
		                				<span class="error-text">{{$errors->first('name')}}</span>
		                			@endif	                			
	                			</div>
	                		</div>

	                		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		                		<div class="form-group">
		                			<label for="description">Restaurant Description</label>
		                			<input type="text" name="description" id="description" class="form-control" placeholder="Restaurant Description" value="<?php if(old('description') !== null ){ echo old('description'); }else{ echo $restaurantInfo['description']; }  ?>">
		                			@if($errors->has('description'))
		                				<span class="error-text">{{$errors->first('description')}}</span>
		                			@endif
	                			</div>
	                		</div>
	                		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                			<div class="row">
			                		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				                		<div class="form-group">
				                			<label for="category_id">Category</label>
				                			<div class="input-group">
					                			<select name="category_id" id="category_id" class="form-control" placeholder="Add new Category">
					                			<option>--Select or create new category--</option>
					                			<?php
					                				foreach ($categoryList as $key => $value) {
					                					?>
															<option value="{{$value['category_id']}}" <?php if(old('category_id') !== null and $value['category_id'] ==  old('category_id') ){ echo 'selected'; }elseif(old('category_id') === null and $value['category_id'] ==  $restaurantInfo['category_id'] ){ echo 'selected';  } ?>  >{{$value['name']}}</option>
					                					<?php
					                				}
					                			?>
					                			</select>
										      <span class="input-group-btn">
										        <button class="btn btn-default" id="delete_category-btn" type="button"><i class="fa fa-times"></i> Delete</button>
										      </span>						                						                						                				
				                			</div>

			                			</div>
					                			@if($errors->has('category_id'))
					                				<span class="error-text">{{$errors->first('category_id')}}</span>
					                			@endif				                			
			                		</div>	  
			                		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			                			<div class="form-group">
				                			<label for="new_category">Add new Category</label>
			                				<div class="input-group">
				                				<input type="text" id="new_category" class="form-control">
				                				<span class="input-group-btn">
				                					<button class="btn btn-default" type="button" id="add_new_category"> Add New</button>
				                				</span>
			                				</div>
			                			</div>
			                		</div>	                					
	                			</div>
	                		</div>
                			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	                			<div class="form-group">
		                			<label for="lat">Lat(Lattitude)</label>
		                			<input type="text" name="lat" id="lat" class="form-control" placeholder="Restaurant lat" value="<?php if(old('lat') !== null ){ echo old('lat'); }else{ echo $restaurantInfo['lat']; }  ?>">
		                			@if($errors->has('lat'))
		                				<span class="error-text">{{$errors->first('lat')}}</span>
		                			@endif                				
	                			</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
		                			<label for="lng">lng(Longitude)</label>
		                			<input type="text" name="lng" id="lng" class="form-control" placeholder="Restaurant lng" value="<?php if(old('lng') !== null ){ echo old('lng'); }else{ echo $restaurantInfo['lng']; }  ?>">
		                			@if($errors->has('lng'))
		                				<span class="error-text">{{$errors->first('lng')}}</span>
		                			@endif
	                			</div>
	                		</div>	   
	                		<div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
		                		<input type="submit" value='Submit' class="btn btn-lg btn-info">
	                		</div>
	                		
	                	</form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<Script>


		$(document).ready(function(){
			$('#add_new_category').click(function(){
				category =  document.getElementById('new_category').value;
				$.post('{{route("adminPostAddCategory")}}',{category:category,_token:'{{ csrf_token() }}'},function(e){
					result  = JSON.parse(e );
					if(result.status ==  "200"){
						$('#category_id option').remove('selected');
						$('#category_id').append('<option value="'+result.category.category_id+'" selected>'+result.category.name+'</option>');
						showMessage('info','Successfully Added new Category');
					}else{
						console.log(result.error);
						showMessage('danger',result.error.category[0]);


					}
				})
			})

			$('#delete_category-btn').click(function(){
				category  = document.getElementById('category_id').value;
				$.post('{{route("adminPostDeleteCategory")}}',{category_id:category,_token:'{{ csrf_token() }}'},function(e){
					result  = JSON.parse(e );
					if(result.status ==  "200"){
						$('#category_id option[value="'+result.category_id+'"]').remove();
						showMessage('info','Successfully Deleted Category');
					}else{
						console.log(result.error);
						showMessage('danger',result.error.category_id[0]);
					}
				})				
			})
		})
	</Script>
@endsection