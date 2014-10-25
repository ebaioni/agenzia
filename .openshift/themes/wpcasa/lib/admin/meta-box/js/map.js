
var marker, map, geocoder, icon, shadow;

jQuery( document ).ready( function ()
{
   /*jshint jquery: true, devel:true, browser: true, newcap: true, noempty: true, strict: true, undef: true */
   "use strict";
   var icon   = new window.google.maps.MarkerImage(wpsight_localize_map.map_icon,
   				new window.google.maps.Size( parseInt(wpsight_localize_map.map_icon_w), parseInt(wpsight_localize_map.map_icon_h) ),
   				new window.google.maps.Point(0, 0),
   				new window.google.maps.Point( parseInt(wpsight_localize_map.map_icon_x), parseInt(wpsight_localize_map.map_icon_y) ) 
   );
   var shadow = new window.google.maps.MarkerImage(wpsight_localize_map.map_icon_shadow,
   				new window.google.maps.Size( parseInt(wpsight_localize_map.map_icon_shadow_w), parseInt(wpsight_localize_map.map_icon_shadow_h) ),
   				new window.google.maps.Point(0, 0),
   				new window.google.maps.Point( parseInt(wpsight_localize_map.map_icon_shadow_x), parseInt(wpsight_localize_map.map_icon_shadow_y) )
   );
   var latlng = new window.google.maps.LatLng( parseInt(wpsight_localize_map.map_center_lat), parseInt(wpsight_localize_map.map_center_long ) );
   map        = new window.google.maps.Map( jQuery( '.rwmb-map-canvas' )[0], {
      zoom              : 8,
      center            : latlng,
      streetViewControl : wpsight_localize_map.map_streetview,
      mapTypeId         : window.google.maps.MapTypeId.ROADMAP,
      scrollwheel		: false
      });
   marker     = new window.google.maps.Marker( {position: latlng, map: map, draggable: true, icon: icon, shadow: shadow} );
   geocoder   = new window.google.maps.Geocoder();

   window.google.maps.event.addListener( map, 'click', function ( event )
   {
      marker.setPosition( event.latLng );
      updatePositionInput( event.latLng );

      window.setTimeout(function() {
        map.panTo(marker.getPosition());
      }, 500);

   } );
   window.google.maps.event.addListener( marker, 'drag', function ( event )
   {
      updatePositionInput( event.latLng );
      window.setTimeout(function() {
        map.panTo(marker.getPosition());
      }, 500);
   } );

   updatePositionMarker();
   autoCompleteAddress();

   function updatePositionInput( latLng )
   {
      jQuery( '#rwmb-map-coordinate' ).val( latLng.lat() + ',' + latLng.lng() );
      codeLatLng(latLng.lat(),latLng.lng());
   }

   function updatePositionMarker()
   {
      var coord = jQuery( '#rwmb-map-coordinate' ).val(),
         addressField = jQuery( '#rwmb-map-goto-address-button' ).val(),
         l, zoom;

      if ( coord )
      {
         l = coord.split( ',' );
         marker.setPosition( new window.google.maps.LatLng( l[0], l[1] ) );

         zoom = l.length > 2 ? parseInt( l[2], 10 ) : 15;

         map.setCenter( marker.position );
         map.setZoom( zoom );
      }
      else
         if ( addressField ){
            geocodeAddress( addressField );
         }
   }

   function geocodeAddress( addressField )
   {
      // console.log(addressField);
      var address = '',
         fieldList = addressField.split( ',' ),
         loop;

      for ( loop = 0; loop < fieldList.length; loop++ )
      {
         address += jQuery( '#' + fieldList[loop] ).val();
      }

      address = address.replace( /\n/g, ',' );
      address = address.replace( /,,/g, ',' );
      geocoder.geocode( {'address': address}, function ( results, status )
      {
         if ( status == window.google.maps.GeocoderStatus.OK )
         {
            updatePositionInput( results[0].geometry.location );
            marker.setPosition( results[0].geometry.location );
            map.setCenter( marker.position );
            map.setZoom( 15 );
         }
      } );
   }


   function autoCompleteAddress(){
      var addressField = jQuery( '#rwmb-map-goto-address-button' ).val();
      if (!addressField) return null;

      jQuery( '#' + addressField).autocomplete({
         source: function(request, response) {
            // TODO: add 'region' option, to help bias geocoder.
           geocoder.geocode( {'address': request.term }, function(results, status) {
             response(jQuery.map(results, function(item) {
               return {
                 label     : item.formatted_address,
                 value     : item.formatted_address,
                 latitude  : item.geometry.location.lat(),
                 longitude : item.geometry.location.lng()
               };
             }));
           });
         },
         select: function(event, ui) {     
            jQuery("#rwmb-map-coordinate").val(ui.item.latitude + ',' + ui.item.longitude );       
            codeLatLng(ui.item.latitude,ui.item.longitude);           

            var location = new window.google.maps.LatLng(ui.item.latitude, ui.item.longitude);

            map.setCenter(location);
            // Drop the Marker
            setTimeout( function(){
              marker.setValues({
                 position    : location,
                 animation   : window.google.maps.Animation.DROP
              });
            }, 1500);
         }
      });
   }

   function codeLatLng( lat, lng) {
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({'latLng': latlng}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              jQuery('#_map_address').val(results[0].formatted_address);
              //Ajax save
              ajax_save_map();
            } else {
             jQuery('#_map_address').val('invalid address');
            }
          } else {
            //alert('Geocoder failed due to: ' + status);
          }
        });
  }


  function ajax_save_map(){
    var data = {
        action  : 'rwmb_save_map',
        post_id : jQuery('#post_ID').val(),
        map_address: jQuery('#_map_address').val(),
        map_location: jQuery('#rwmb-map-coordinate').val()
      };

      jQuery.post( ajaxurl, data, function( r ){
          var res = wpAjax.parseAjaxResponse( r, 'ajax-response' );
          if ( res.errors )
            alert( res.responses[0].errors[0].message );
        }, 'xml' );
  }


} );
