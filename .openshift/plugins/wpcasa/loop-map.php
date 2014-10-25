<?php
/**
 * The template for displaying a properties map
 *
 * @package wpSight
 * @since 1.1
 */
global $map_query;

$map_args = array(
	'map_type' 	   	    => 'ROADMAP',
	'control_type' 	    => 'true',
	'control_nav'  	    => 'true',
	'scrollwheel'  	    => 'false',
	'streetview'   	    => 'true',
	'map_icon'		    => apply_filters( 'wpsight_map_listing_icon', WPSIGHT_ASSETS_IMG_URL . '/map-listing.png' ),
	'map_icon_w'	    => 24,
	'map_icon_h'	    => 37,
	'map_icon_x'	    => 12,
	'map_icon_y'	    => 37,
	'map_icon_shadow'   => apply_filters( 'wpsight_map_listing_icon_shadow', WPSIGHT_ASSETS_IMG_URL . '/map-listing-shadow.png' ),
	'map_icon_shadow_w' => 24,
	'map_icon_shadow_h' => 17,
	'map_icon_shadow_x' => 12,
	'map_icon_shadow_y' => 8,
	'cluster'			=> array(
		'radius'  => 20,
		'markers' => array(
			5 => array(
				'content'  => '<div class="cluster cluster-1">CLUSTER_COUNT</div>',
				'width'    => 50,
				'height'   => 50,
				'offset_x' => -25,
				'offset_y' => -25
			),
			10 => array(
				'content'  => '<div class="cluster cluster-2">CLUSTER_COUNT</div>',
				'width'    => 60,
				'height'   => 60,
				'offset_x' => -30,
				'offset_y' => -30
			),
			25 => array(
				'content'  => '<div class="cluster cluster-3">CLUSTER_COUNT</div>',
				'width'    => 70,
				'height'   => 70,
				'offset_x' => -35,
				'offset_y' => -35
			),
			50 => array(
				'content'  => '<div class="cluster cluster-4">CLUSTER_COUNT</div>',
				'width'    => 80,
				'height'   => 80,
				'offset_x' => -40,
				'offset_y' => -40
			)
		)
	)
);

$map_args = apply_filters( 'wpsight_loop_map_args', $map_args ); ?>

<script type="text/javascript">

	(function($){

		var map;
		
		$.fn.initialize = function() {
		
			map = $('#listings-map').gmap3({
			  map:{
			    options:{
			      	mapTypeId: google.maps.MapTypeId.<?php echo $map_args['map_type']; ?>,
			        mapTypeControl: <?php echo $map_args['control_type']; ?>,
			        navigationControl: <?php echo $map_args['control_nav']; ?>,
			        scrollwheel: <?php echo $map_args['scrollwheel']; ?>,
			        streetViewControl: <?php echo $map_args['streetview']; ?>
			    }
			  }, // end map
			  marker:{
			    values:[<?php			    	
			    		
			    	$marker_log = array();
			    
			    	while ( $map_query->have_posts() ) {
			    	
			    		$map_query->the_post();    	    
			    		$marker = NULL;
			    		
			    		// Get post ID
			    		$post_id = get_the_ID();
			    		
			    		// Get necessary custom fields
			    		
			    		$map_geo = get_post_meta( $post_id, '_map_geo', true );
			    		$map_address = get_post_meta( $post_id, '_map_address', true );
			    		$map_location = get_post_meta( $post_id, '_map_location', true );
			    		
			    		if( ! empty( $map_geo ) ) {
			    			$marker = 'latLng:[' . $map_geo . ']';
			    		} elseif( ! empty( $map_address ) ) {
			    			$marker = 'address: "' . $map_address . '"';
			    		}
			    		
			    		// Get marker address or geo code
        	
        				if( ! empty( $map_location ) ) {
        					$marker = 'latLng:[' . $map_location . ']';
        				} elseif( ! empty( $map_geo ) ) {
        					$marker = 'latLng:[' . $map_geo . ']';
        				} elseif( ! empty( $map_address ) ) {        	
        					$marker = 'address: "' . $map_address . '"';        		
        				}
			    		
			    		if( ! empty( $marker ) ) {
			    		
			    			$marker_log[$post_id] = $marker;
			    			
			    			// Set offset when marker is identical
			    			
			    			$count_values = array_count_values( $marker_log );
			    			
			    			$map_icon_x = $map_args['map_icon_x'];
			    			
			    			if( $count_values[$marker] > 1 ) {
			    				$map_icon_x = $map_args['map_icon_x'] + ( $count_values[$marker] * 15) - 15;
			    			} ?>
			    
			      		{<?php echo $marker; ?>, data: '<div class="listing-map-info"><?php do_action( 'wpsight_listing_title_before' ); ?><h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php do_action( 'wpsight_listing_title_inside', 'map' ); the_title(); ?></a></h2><?php do_action( 'wpsight_listing_title_after', 'map' ); do_action( 'wpsight_listing_map_content' ); ?></div>', options: { icon: <?php echo apply_filters( 'wpsight_map_listing_marker_icon', 'new google.maps.MarkerImage("' . $map_args['map_icon'] . '", new google.maps.Size(' . $map_args['map_icon_w'] . ', ' . $map_args['map_icon_h'] . '), new google.maps.Point(0, 0), new google.maps.Point(' . $map_icon_x . ', ' . $map_args['map_icon_y'] . '))', $post_id, $map_args ); ?>, shadow: <?php echo apply_filters( 'wpsight_map_listing_marker_icon_shadow', 'new google.maps.MarkerImage("' . $map_args['map_icon_shadow'] . '", new google.maps.Size(' . $map_args['map_icon_shadow_w'] . ', ' . $map_args['map_icon_shadow_h'] . '), new google.maps.Point(0, 0), new google.maps.Point(' . $map_args['map_icon_shadow_x'] . ', ' . $map_args['map_icon_shadow_y'] . '))', $post_id, $map_args ); ?> } },<?php
			      		
			      		} // endif
			      		
			      	} // endwhile ?>
			      		
			    ],
			    options:{
			      draggable: false
			    },
			    events:{
			      mouseover: function(marker, event, context){
			      	marker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
			        var map = $(this).gmap3("get"),
			          infowindow = $(this).gmap3({get:{name:"infowindow"}});
			        if (infowindow){
			          infowindow.open(map, marker);
			          infowindow.setContent(context.data);
			        } else {
			          $(this).gmap3({
			            infowindow:{
			              anchor:marker, 
			              options:{content: context.data}
			            }
			          });
			        }
			      }
			    }<?php if( $map_args['cluster'] != false && is_array( $map_args['cluster'] ) ) { ?>,
			    	cluster:{
    			  		radius: <?php echo $map_args['cluster']['radius']; ?>,<?php
    			  		
    			  		$cmarkers = array();
    			  		
    			  		foreach( $map_args['cluster']['markers'] as $k => $v )    			  		
    			  			$cmarkers[] .= "\n" . $k . ': { content: "' . str_replace( '"', '\'', $v['content'] ) . '", width: ' . $v['width'] . ', height: ' . $v['height'] . ', offset: { x: ' . $v['offset_x'] . ', y: ' . $v['offset_y'] . ' } }';
    			  		$cmarkers = implode( ', ', $cmarkers );
    			  		
    			  		echo $cmarkers; ?>,
    			  		events: {
    			    		click: function(cluster) {
              				  var map = $(this).gmap3("get");
              				  map.setCenter(cluster.main.getPosition());
              				  map.setZoom(map.getZoom() + 1);
              				}
    			  		}
    			  	} // end cluster<?php } // endif $map_args['cluster'] ?>

			  }, // end marker
			    autofit:{}
			});
		
		}
	
	})(jQuery);

    jQuery(document).ready(function($){
    
    	var cookie_map = '<?php echo WPSIGHT_COOKIE_SEARCH_MAP; ?>';
    	var listings_map = '#listings-map';<?php
    
    	if( ! is_page_template( 'page-tpl-map.php' ) ) { ?>
    	
    		if($.cookie(cookie_map) != 'closed') {
    			$(listings_map).initialize();
	    		$('#listings-map.open').show();
	    	}
			
	    	if ($.cookie(cookie_map) && $.cookie(cookie_map) == 'open') {
	    		$(listings_map).initialize();
	    	    $(listings_map).show();
	    	    $('.title-search-map').addClass('open');
	    	}
	    	
	    	$('.title-search-map').click(function () {
	    	    if ($(listings_map).is(':visible')) {
	    	    	$.cookie(cookie_map, 'closed',{ expires: 60, path: '<?php echo COOKIEPATH; ?>' });
	    	        $(listings_map).animate(
	    	            {
	    	                opacity: '0'
	    	            },
	    	            150,
	    	            function(){           	
	    	                $('.title-search-map').removeClass('open');
	    	                $(listings_map).slideUp(150);
	    	            }
	    	        );
	    	    }
	    	    else {
	    	        $(listings_map).slideDown(150, function(){
	    	        	$(listings_map).initialize();
	    	        	$(listings_map).gmap3({trigger:"resize"});
	    	        	$.cookie(cookie_map, 'open',{ expires: 60, path: '<?php echo COOKIEPATH; ?>' });
	    	            $(listings_map).animate(
	    	                {
	    	                    opacity: '1'
	    	                },
	    	                150
	    	            );
	    	    		$('.title-search-map').addClass('open');
	    	        });
	    	    }   
	    	});<?php
	    
	    } else { ?>
	    
	    	$(listings_map).initialize();<?php
	    
	    } ?>
        
    });
</script>

<div id="listings-map"></div>