<?php

/**
 * Create listing details widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listing_details' );
 
function wpsight_register_widget_listing_details() {

	register_widget( 'wpSight_Listing_Details' );

}

/**
 * Widget class
 */

class wpSight_Listing_Details extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Details on single listing pages', 'wpsight' ) );
		parent::__construct( 'wpSight_Listing_Details', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listing Details', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
		extract( $args, EXTR_SKIP );

		$listing_type 	  = isset( $instance['listing_type'] ) ? $instance['listing_type'] : true;
		$listing_location = isset( $instance['listing_location'] ) ? $instance['listing_location'] : true;
		$listing_id 	  = isset( $instance['listing_id'] ) ? $instance['listing_id'] : true;

		// Loop through standard details

		foreach( wpsight_standard_details() as $key => $values )
			$key = isset( $instance[$key] ) ? $instance[$key] : true;
    
    	if( is_single() && get_post_type() == wpsight_listing_post_type() ) { ?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-details section clearfix clear">
        	
        		<div class="title clearfix">
	        		
	        		<div class="title-price listing-price">
	        			<?php wpsight_price(); ?>
	        		</div>
	        		
	        		<?php
	        			// Action hook listing details title inside
		        		do_action( 'wpsight_listing_details_title_inside', $args, $instance );
					?>
						
				</div><!-- .title -->
				
				<?php						
				    // Display details

				    $standard_details = wpsight_standard_details();

				    $listing_details  = '';

				    // Loop through standard details

				    if( ! empty( $standard_details ) ) {

				    	$i = 0;

				    	$listing_details .= '<div class="row">' . "\n";

				    	foreach( $standard_details as $feature => $value ) {
		
							$standard_details_option = wpsight_get_option( $feature );
							
							// If details hasn't been set before, display default
							
							if( ! isset( $standard_details_option['label'] ) )
								$standard_details_option = wpsight_get_option( $feature, true );
				    	
				    		// Don't show detail if label is emtpy in options
							
							if( empty( $standard_details_option['label'] ) )
								continue;

				    		// Append listing ID to details

				    		if( $i == 0 && $listing_id ) {

				    			$listing_details_id = '<div class="' . wpsight_get_span( 'small' ) . '">' . "\n";

				    			$listing_details_id .= '<span class="listing-details-label">' . __( 'Listing ID', 'wpsight' ) . ':</span>' . "\n";
				    			$listing_details_id .= '<span class="listing-details-value">' . wpsight_get_listing_id( get_the_ID() ) . '</span><!-- .listing-id-value -->' . "\n";

				    			$listing_details_id .= '</div><!-- .listing-details-id -->' . "\n";

				    			$listing_details .= apply_filters( 'wpsight_listing_details_id', $listing_details_id, $args, $instance );

				    		}

				    		$listing_details_value = get_post_meta( get_the_ID(), '_' . $feature, true );
				    		
				    		// Check if value is data key
				    		
				    		if( ! empty( $value['data'] ) )
				    			$listing_details_value = $value['data'][$listing_details_value];

				    		if ( ! empty( $listing_details_value ) && $instance[$feature] ) {

				    			$listing_details .= '<div class="' . wpsight_get_span( 'small' ) . '">' . "\n";

				    			$listing_details .= '<span class="listing-details-label">' . $value['label'] . ':</span><!-- .listing-' . $feature . '-label -->' . "\n";
				    			$listing_details .= '<span class="listing-details-value">' . $listing_details_value . ' ' . wpsight_get_measurement_units( $value['unit'] ) . '</span><!-- .listing-' . $feature . '-value -->' . "\n";

				    			$listing_details .= '</div><!-- .listing-' . $feature . ' -->' . "\n";

				    		}

				    		$i++;

				    	} // endforeach
				    	
				    	// Add date - will be hidden by CSS display:none
				    	
				    	$listing_details .= '<div class="' . wpsight_get_span( 'small' ) . '">' . "\n";
				    	$listing_details .= '<span class="listing-date updated">' . get_the_date() . '</span>' . "\n";
				    	$listing_details .= '</div>' . "\n";

				    	$listing_details .= '</div><!-- .row -->' . "\n";

				    } // endif
    			    	
    			    echo apply_filters( 'wpsight_widget_listing_details', $listing_details, $args, $instance );
	        	?>
				
			</div><!-- .listing-details --><?php

		}
        
	}

    function update( $new_instance, $old_instance ) {
    
    	$new_instance = (array) $new_instance;
    	
		$instance = array(
			'listing_type' 	   => 0,
			'listing_location' => 0,
			'listing_id' 	   => 0
		);

		foreach( wpsight_standard_details() as $key => $values )
			$instance[$key] = 0;

		foreach( $instance as $field => $val )
			if( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
                  
        return $instance;
    }
 
    function form( $instance ) {
    
    	$defaults = array(
    		'listing_type' 	   => true,
    		'listing_location' => true,
    		'listing_id' 	   => true
    	);
    	
		foreach( wpsight_standard_details() as $key => $values )
			$defaults[$key] = true;
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'listing_type' ); ?>" name="<?php echo $this->get_field_name( 'listing_type' ); ?>" <?php checked( $instance['listing_type'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'listing_type' ); ?>"><?php _e( 'Display type', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'listing_location' ); ?>" name="<?php echo $this->get_field_name( 'listing_location' ); ?>" <?php checked( $instance['listing_location'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'listing_location' ); ?>"><?php _e( 'Display location', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'listing_id' ); ?>" name="<?php echo $this->get_field_name( 'listing_id' ); ?>" <?php checked( $instance['listing_id'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'listing_id' ); ?>"><?php _e( 'Display ID', 'wpsight' ); ?></label>		
		</p>
		
		<?php

		// Loop through standard details

		$standard_details = wpsight_standard_details();

		foreach( wpsight_standard_details() as $key => $values ) { ?>
			
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key], 1 ); ?> />
				<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo __( 'Display', 'wpsight' ) . ': <em>' . $values['label'] . '</em>'; ?></label>		
			</p><?php
			
		}

	}

} // end class wpSight_Listing_Details