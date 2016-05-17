<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
      <style type="text/css">
          #map{
            width: 100%;
            margin:0px auto;
            height: 80vh;
          }
      </style>
        <div class="container-fluid">
          <div class="col-xs-12 colsm-4 col-md-4 col-lg-4">
            <h3>Settings</h3>
            <hr>
            <div class="form-group">
              <label for="distance">Distance(KM)</label>
              <input type="text" class="form-control" name="distance" id="distance" placeholder="Insert distance or leave it blank(default 5km)">
            </div>

            <div class="form-group">
              <label for="category">Category</label>
              <select name="category_id" id="category_id" class="form-control">
                <option value="">All</option>
                <?php 
                  foreach ($categoryList as $key => $value) {
                    ?>
                      <option value="{{$value['category_id']}}">{{$value['name']}}</option>
                    <?php
                  }
                 ?>
               </select>
            </div>

            <div class="form-group">
              <label for="number">Number of Restaurant</label>
              <input type="number" integer id="number" name="number" class="form-control" placeholder="Insert desired amount of restaurant to be display(default 20)">
            </div>
            <div class="form-grou">
              <button class="btn btn-info btn-lg" onclick="initMap()">Find</button>
              <span>*noted, the distance is counted with straight line distance, for travel distance and travel time need to use Google Distance Matrix Api</span>
            </div>
          </div>
          <div class="col-sx-12 col-sm-8 col-md-8 col-lg-8">
            <div class="row">
              <hr>

              <div id="map"></div>
            </div>
          </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsFzC6RUppY4IN81bjT_jSH34TgzeeJII">
        </script>

        <script type="text/javascript">
          $(window).load(function(){
            initMap();
          })


          function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: 1.4345261999999999, lng: 103.82743389999999},
              zoom: 12
            });
            var infoWindow = new google.maps.InfoWindow({map: map});

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Current Location<br>lat:'+position.coords.latitude+'<br>lng:'+position.coords.longitude);
                map.setCenter(pos);
                // Call function to get restaurant List
                getNearestRestaurant(position.coords.latitude,position.coords.longitude,map);
              }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
              });
            } else {
              // Browser doesn't support Geolocation
              handleLocationError(false, infoWindow, map.getCenter());
            }

          }

          function getNearestRestaurant(lat,lng,map){
            var category_id =  document.getElementById('category_id').value;
            var distance =  document.getElementById('distance').value;
            var amount =  document.getElementById('number').value;

            $.get('restaurant/nearest',{lat:lat,lng:lng,category_id:category_id,distance:distance,amount:amount},function(e){
              result =  JSON.parse(e);
              displayMarker(result.restaurant_list,map);
              console.log(result.restaurant_list);
            });
          }

          function displayMarker(restaurantList,map){
              var infowindow = new Array();
              var marker= new Array();
              $.each(restaurantList,function(restaurantKey,restaurantInfo){

                  infowindow[restaurantKey] = new google.maps.InfoWindow({
                    content:'Name:'+restaurantInfo.name+'<br>'+
                  'Category: '+restaurantInfo.category_name +"<br>"+
                  'Latitude: '+restaurantInfo.lat +"<br>"+
                  'Longitude: '+restaurantInfo.lng +"<br>"+
                  'Distance: '+ Math.round(restaurantInfo.distance*100)/100 +"km<br>"
                  });
                  infowindow


                  marker[restaurantKey] = new google.maps.Marker({
                      position:{
                        lat:parseFloat(restaurantInfo.lat),
                        lng:parseFloat(restaurantInfo.lng)
                      },
                      map: map,
                      title: restaurantInfo.name
                    });
                  
                  marker[restaurantKey].addListener('click', function() {
                    infowindow[restaurantKey].open(map, marker[restaurantKey]);
                  });                  
              })
          }

          function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                  'Error: The Geolocation service failed.' :
                                  'Error: Your browser doesn\'t support geolocation.');
          }
        </script>
    </body>
</html>