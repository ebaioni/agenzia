<?php

/**
 * Create listing location widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listing_location' );
 
function wpsight_register_widget_listing_location() {

	register_widget( 'wpSight_Listing_Location' );

}

/**
 * Widget class
 */
	
class wpSight_Listing_Location extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Location on single listing pages', 'wpsight' ) );
		parent::__construct( 'wpSight_Listing_Location', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listing Location', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    	
    	extract( $args, EXTR_SKIP );
    
    	$title 		= isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $maptype 	= isset( $instance['map_type'] ) ? $instance['map_type'] : 'ROADMAP';
        $mapzoom 	= isset( $instance['map_zoom'] ) ? (int) $instance['map_zoom'] : 14;
        $streetview = isset( $instance['streetview'] ) ? $instance['streetview'] : true;
        
        $map_args = array(
        	'control_type' => 'false',
        	'control_nav'  => 'true',
        	'scrollwheel'  => 'false',
        	'map_icon'		    => apply_filters( 'wpsight_map_listing_icon', WPSIGHT_ASSETS_IMG_URL . '/map-listing.png' ),
			'map_icon_w'	    => 24,
			'map_icon_h'	    => 37,
			'map_icon_x'	    => 12,
			'map_icon_y'	    => 37,
			'map_icon_shadow'   => apply_filters( 'wpsight_map_listing_icon_shadow', WPSIGHT_ASSETS_IMG_URL . '/map-listing-shadow.png' ),
			'map_icon_shadow_w' => 24,
			'map_icon_shadow_h' => 17,
			'map_icon_shadow_x' => 12,
			'map_icon_shadow_y' => 8
        );
        
        $map_args = apply_filters( 'wpsight_widget_listing_location_map_args', $map_args, $args, $instance );
        
        if( is_single() && get_post_type() == wpsight_listing_post_type() ) {
        
        	// Get post custom data
        
        	$custom = get_post_custom( get_the_ID() );
        	
        	// Get geo code
        	
        	if( ! empty( $custom['_map_geo'][0] ) )
        		$marker = 'latLng:[' . $custom['_map_geo'][0] . ']';
        		
        	// Get address
        	
        	if( ! empty( $custom['_map_address'][0] ) )
        		$marker = 'address: "' . $custom['_map_address'][0] . '"';
        	
        	// If new location value is available, use it

        	if( ! empty( $custom['_map_location'][0] ) )
        		$marker = 'latLng:[' . $custom['_map_location'][0] . ']';
        	
        	if( ! empty( $marker ) ) { ?>
        	
        		<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-location section clearfix clear">
        			
        			<?php        				
        				$marker = 'marker:{ ' . $marker . ', options: { icon: ' . apply_filters( 'wpsight_map_listing_marker_icon', 'new google.maps.MarkerImage("' . $map_args['map_icon'] . '", new google.maps.Size(' . $map_args['map_icon_w'] . ', ' . $map_args['map_icon_h'] . '), new google.maps.Point(0, 0), new google.maps.Point(' . $map_args['map_icon_x'] . ', ' . $map_args['map_icon_y'] . '))', get_the_ID(), $map_args ) . ', shadow: ' . apply_filters( 'wpsight_map_listing_marker_icon_shadow', 'new google.maps.MarkerImage("' . $map_args['map_icon_shadow'] . '", new google.maps.Size(' . $map_args['map_icon_shadow_w'] . ', ' . $map_args['map_icon_shadow_h'] . '), new google.maps.Point(0, 0), new google.maps.Point(' . $map_args['map_icon_shadow_x'] . ', ' . $map_args['map_icon_shadow_y'] . '))', get_the_ID(), $map_args ) . ' } }';
        				
        				$listing_location = '<script type="text/javascript">
							jQuery(document).ready(function($){
							    $(".listing-location-map").gmap3({
    								' . $marker . ',
    								map:{
    								  options:{
	  							  	  	zoom: ' . $mapzoom . ',
	  							  	  	mapTypeId: google.maps.MapTypeId.' . $maptype . ',
      								  	mapTypeControl: ' . $map_args['control_type'] . ',
      								  	navigationControl: ' . $map_args['control_nav'] . ',
      								  	scrollwheel: ' . $map_args['scrollwheel'] . ',
      								  	streetViewControl: ' . $streetview . '
    								  }
    								}
	  							});	            
							});
						</script>';
						
						// Display title if exists
						
						if( ! empty( $title ) ) { ?>
							
							<div class="title clearfix">    
        		    	        <h2><?php echo $title; ?></h2>
        		    	        <?php
        		    	            // Action hook listing location title inside
        		    	            do_action( 'wpsight_listing_location_title_inside', $args, $instance );
        		    	        ?>    	
        		    	    </div>
							
						<?php }
							
						$listing_location .= '<div class="listing-location-map"></div>';
						
						if( ! empty( $custom['_map_note'][0] ) )
							$listing_location .= '<div class="listing-location-map-note alert clear">' . $custom['_map_note'][0] . '</div>';	
						
						echo apply_filters( 'wpsight_widget_listing_location', $listing_location, $args, $instance );
					?>
					
				</div><!-- .listing-location --><?php
			
			} // endif ! empty( $marker )
		}        
	}

    function update( $new_instance, $old_instance ) {
    
    	$instance = array(
			'streetview' => 0
		);
		
		foreach ( $instance as $field => $val )
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
    
    	$instance['title'] 	  = strip_tags($new_instance['title']);
    	$instance['map_type'] = $new_instance['map_type'];
    	$instance['map_zoom'] = (int) $new_instance['map_zoom'];
                  
        return $instance;
    }
 
    function form( $instance ) {
    
    	$defaults = array(
    		'streetview' => true
    	);
        
        $instance = wp_parse_args( (array) $instance, $defaults );
		$title 	  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$maptype  = isset( $instance['map_type'] ) ? $instance['map_type'] : 'ROADMAP';
		$mapzoom  = isset( $instance['map_zoom'] ) ? (int) $instance['map_zoom'] : 14; ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'map_type' ); ?>"><?php _e( 'Map type', 'wpsight' ); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'map_type' ); ?>" name="<?php echo $this->get_field_name( 'map_type' ); ?>">
				<option value="ROADMAP" <?php selected( 'ROADMAP', $maptype )?>><?php _e( 'Map', 'wpsight' ); ?></option>
				<option value="SATELLITE" <?php selected( 'SATELLITE', $maptype )?>><?php _e( 'Satellite', 'wpsight' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'map_zoom') ; ?>"><?php _e( 'Zoom level', 'wpsight' ); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'map_type' ); ?>" name="<?php echo $this->get_field_name( 'map_zoom' ); ?>">
				<?php
					for( $i=1; $i<=20; $i++)  {
						echo '<option' . selected( $i, $mapzoom ) . '>' . $i . '</option>';
					}
				?>
			</select>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'streetview' ); ?>" name="<?php echo $this->get_field_name( 'streetview' ); ?>"<?php checked( $instance['streetview'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'streetview' ); ?>"><?php _e( 'Enable streetview', 'wpsight' ); ?></label>		
		</p><?php

	}

} // end class wpSight_Listing_Location