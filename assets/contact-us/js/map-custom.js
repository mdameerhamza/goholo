




function initialize() {

    if ($("#map").length ) {
        initMap();
    add_markers();
    search_autocomplete();
  }
  if ($("#autocomplete").length ) {
    initAutoComplete(); 
  }

  if ($("#location_map").length) {
    location_map();
  }

}
let map ="";
var markers = [];
let lat = "";
let lng = ""; 
let info = ""; 
let km = 30;
let Crcl ; // circle variable
let mapOptions = {
 zoom: 10,
 center: {lat:56.1304, lng:106.3468}
}; // map options
 





function initMap() {


    var infoWindow = new google.maps.InfoWindow(); // information window ,we will use for our location and for markers
        // set the map to the div with id = map and set the mapOptions as defualt
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        var infoWindow = new google.maps.InfoWindow({map: map});

        // get current location with HTML5 geolocation API.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                lat.value  =  position.coords.latitude ;
                lng.value  =  position.coords.longitude;
                info.nodeValue =  position.coords.longitude;
            map.setCenter(pos);

          }, function() {
                // if user block the geolocatoon API and denied detect his location
                //handleLocationError(true, infoWindow, map.getCenter());
              });
        }

        InitializeCustomMarker();


      }


      function CustomMarker(latlng, map, args)
      {

        this.latlng = latlng;
        this.args = args;
        this.setMap(map);
        this.map = map;
      }

      function InitializeCustomMarker(){
        CustomMarker.prototype = new google.maps.OverlayView();

        CustomMarker.prototype.draw = function ()
        {
          var self = this;

          if (!this.div)
          {

            // var maindiv = document.createElement('div');
            // maindiv.style.cursor = 'pointer';
            // maindiv.className = 'main_marker';


            // var imgb = document.createElement('img');
            // imgb.style.width = '50px';
            // imgb.src = base_url+"assets/images/bmarker.png";

            // maindiv.appendChild(imgb);

            var div = document.createElement('div');

            div.className = 'marker';
            div.style.position = 'absolute';
            div.style.cursor = 'pointer';

            var imgb = document.createElement('img');
            imgb.style.width = '50px';
            imgb.src = base_url+"assets/images/bmarker.png";

            div.appendChild(imgb);

            var span = document.createElement('span');
            span.style.display = 'none';
            span.style.position = 'absolute';
            span.style.left = '-19px';
            span.style.top = '-32px';

            var span1 = document.createElement('span');
            span1.className = 'marker_price';
            

            span1.innerHTML = '$'+this.args.cost;

            span.appendChild(span1);

            var img = document.createElement('img');
            img.src = base_url+"assets/images/marker.png";

            span.appendChild(img);

            div.appendChild(span);


            imgb.addEventListener("mouseover", function(event) {  
              imgb.nextSibling.style.display = "block";
            });

            imgb.addEventListener("mouseout", function(event) {      
              imgb.nextSibling.style.display = "none";
            });
            


            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);

            this.div = div;
          }

          var point = this.getProjection().fromLatLngToDivPixel(this.latlng);

          if (point)
          {
            this.div.style.left = (point.x - 20) + 'px';
            this.div.style.top = (point.y - 20) + 'px';
          }

          google.maps.event.addDomListener(this.div, "click", function (event)
          {
            google.maps.event.trigger(self, "click");
          });
        };

        CustomMarker.prototype.remove = function ()
        {
          if (this.div)
          {
            this.div.parentNode.removeChild(this.div);
            this.div = null;
          }
        };

        CustomMarker.prototype.getPosition = function ()
        {
          return this.latlng;
        };

        CustomMarker.prototype.getDraggable = function ()
        {
          return false;
        };

        CustomMarker.prototype.setVisible = function (visible)
        {
          if (this.div)
          {
            if (visible)
            {
              this.div.style.display = 'table';
              this.visible = true;
            }
            else
            {
              this.div.style.display = 'none';
              this.visible = false;
            }
          }
        };

        CustomMarker.prototype.getVisible = function ()
        {
          return this.visible;
        };
      }


      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
       infoWindow.setPosition(pos);
       infoWindow.setContent(browserHasGeolocation ?
        'Error: User Has Denied Location Detection.' :
        'Error: Your browser doesn\'t support geolocation.');
     }
      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }


      function add_markers(){

        deleteMarkers();

        var filter = "";

        if ($(".filter_select").length ) {

          filter = $(".filter_select").val();
        }

        $.ajax({
          url: base_url+"contact/get_location_marker",
          data:{
            filter: filter
          },
          type:"post",
          success:function(res){
            res =  JSON.parse(res);
            //console.log(res);
            var infowindow = new google.maps.InfoWindow();

            $.each(res,function(k,v){
            
        let bounds = new google.maps.LatLngBounds();


        var latLng = new google.maps.LatLng(v.lat_lng.lat, v.lat_lng.lng);

        var marker = new CustomMarker(latLng, map, {
          html: v.infowindow_content,
          cost: v.monthly_cost
        });

        


        markers.push(marker);

        bounds.extend(latLng);

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
          return function () {
            var html =  this.args.html;
            infowindow.setContent(html);
            $(".location_info").find(".html5lightbox").html5lightbox();
            infowindow.open(map, marker);
          }
        })
        (marker, k));
        map.setCenter(marker.getPosition());
        // map.fitBounds(bounds);      
        // map.panToBounds(bounds);   

        
        

        
      });
 
            
          }
        })
      }




      var placeSearch, autocomplete;
      var componentForm = {
       street_number: 'short_name',
       route: 'long_name',
       locality: 'long_name',
       administrative_area_level_1: 'short_name',
       country: 'long_name',
       postal_code: 'short_name'
     };

     function initAutoComplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            );



        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        $(".location_lat").val(place.geometry.location.lat());
        $(".location_lng").val(place.geometry.location.lng());


        for (var component in componentForm) {
          try{
           document.getElementById(component).value = '';
           document.getElementById(component).disabled = false;
         }catch(ex){

         }
       }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];

            
            var val = place.address_components[i][componentForm[addressType]];

            if (addressType == "route") {

                addressType = "street_number";

                street = $("#street_number").val();

                if (street != "") {

                    val = street +','+val;
                }
            }

            try{
                document.getElementById(addressType).value = val;   
            }catch(ex){

            }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
      }

      function search_autocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
          /** @type {!HTMLInputElement} */(document.getElementById('search_autocomplete')),
          );



        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', change_map_location);
      }

      function change_map_location(){
        var place = autocomplete.getPlace();

        var pos = {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng()
        };

        map.setCenter(pos);
      }

      function location_map(){
        map = new google.maps.Map(document.getElementById('location_map'),
          mapOptions);

        InitializeCustomMarker();

        lat = parseFloat($(".lat").val());
        lng = parseFloat($(".lng").val());


        var pos = {
          lat: lat,
          lng: lng
        };


        map.setCenter(pos);

        // var marker = new google.maps.Marker({
        //   position: pos,
        //   map: map,
        // });

        var latLng = new google.maps.LatLng(lat,lng);

        var marker = new CustomMarker(latLng, map, {
          cost: $(".cost").val()
        });


      }    


