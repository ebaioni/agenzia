<?php

/**
 * Create property details widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_property_details' );
 
function wpcasa_register_widget_property_details() {
	register_widget( 'wpCasa_Property_Details' );
}

/**
 * Widget class
 */

class wpCasa_Property_Details extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Details on single property pages', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Details', WPSIGHT_NAME . ' ' . _x( 'Property Details', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
		extract( $args, EXTR_SKIP );

		$property_type 		= isset( $instance['property_type'] ) ? $instance['property_type'] : true;
		$property_location 	= isset( $instance['property_location'] ) ? $instance['property_location'] : true;
		$property_id 		= isset( $instance['property_id'] ) ? $instance['property_id'] : true;

		/** Loop through standard details */

		foreach( wpsight_standard_details() as $key => $values ) {

			$key = isset( $instance[$key] ) ? $instance[$key] : true;

		}
    
    	if( is_single() && get_post_type() == 'property' ) { ?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-details listing-details section clearfix clear">
        	
        		<div class="title clearfix">
	        		
	        		<div class="title-price property-price listing-price">
	        			<?php wpsight_price(); ?>
	        		</div>
	        		
	        		<?php
	        			// Action hook property details title inside
		        		do_action( 'wpsight_listing_details_title_inside', $args, $instance );
					?>
						
				</div><!-- .title -->
				
				<?php						
				    // Display details

				    $standard_details = wpsight_standard_details();

				    $property_details  = '';

				    // Loop through standard details

				    if( ! empty( $standard_details ) ) {

				    	$i = 0;

				    	$property_details .= '<div class="row">' . "\n";

				    	foreach( $standard_details as $feature => $value ) {

				    		// Append property ID to details

				    		if( $i == 0 && $property_id ) {

				    			$property_details_id = '<div class="' . wpsight_get_span( 'small' ) . '">' . "\n";

				    			$property_details_id .= '<span class="listing-details-label">' . __( 'Property ID', 'wpsight' ) . ':</span>' . "\n";
				    			$property_details_id .= '<span class="listing-details-value">' . wpsight_get_listing_id( get_the_ID() ) . '</span><!-- .listing-id-value -->' . "\n";

				    			$property_details_id .= '</div><!-- .listing-details-id -->' . "\n";

				    			$property_details .= apply_filters( 'wpsight_listing_details_id', $property_details_id );

				    		}

				    		$property_details_value = get_post_meta( get_the_ID(), '_' . $feature, true );

				    		if ( ! empty( $property_details_value ) && $instance[$feature] ) {

				    			$property_details .= '<div class="' . wpsight_get_span( 'small' ) . '">' . "\n";

				    			$property_details .= '<span class="listing-details-label">' . $value['label'] . ':</span><!-- .listing-' . $feature . '-label -->' . "\n";
				    			$property_details .= '<span class="listing-details-value">' . $property_details_value . ' ' . wpsight_get_measurement_units( $value['unit'] ) . '</span><!-- .listing-' . $feature . '-value -->' . "\n";

				    			$property_details .= '</div><!-- .property-' . $feature . ' -->' . "\n";

				    		}

				    		$i++;

				    	} // endforeach
				    	
				    	// Add date - will be hidden by CSS display:none
				    	
				    	$property_details .= '<div class="' . wpsight_get_span( 'small' ) . '">' . "\n";
				    	$property_details .= '<span class="listing-date updated">' . get_the_date() . '</span>' . "\n";
				    	$property_details .= '</div>' . "\n";

				    	$property_details .= '</div><!-- .row -->' . "\n";

				    } // endif
    			    	
    			    echo apply_filters( 'wpsight_widget_listing_details', $property_details );
	        	?>
				
			</div><!-- .listing-details --><?php

		}
        
	}

    function update( $new_instance, $old_instance ) {
    
    	$new_instance = (array) $new_instance;
    	
		$instance = array(
			'property_type' => 0,
			'property_location' => 0,
			'property_id' => 0
		);

		$standard_details = wpsight_standard_details();

		foreach( wpsight_standard_details() as $key => $values ) {		
			$instance[$key] = 0;		
		}

		foreach ( $instance as $field => $val ) {
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
		}
                  
        return $instance;
    }
 
    function form( $instance ) {
    
    	$defaults = array(
    		'property_type' => true,
    		'property_location' => true,
    		'property_id' => true
    	);
    	
    	$standard_details = wpsight_standard_details();

		foreach( wpsight_standard_details() as $key => $values ) {		
			$defaults[$key] = true;		
		}
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'property_type' ); ?>" name="<?php echo $this->get_field_name( 'property_type' ); ?>" <?php checked( $instance['property_type'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'property_type' ); ?>"><?php _e( 'Display property type', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'property_location' ); ?>" name="<?php echo $this->get_field_name( 'property_location' ); ?>" <?php checked( $instance['property_location'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'property_location' ); ?>"><?php _e( 'Display property location', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'property_id' ); ?>" name="<?php echo $this->get_field_name( 'property_id' ); ?>" <?php checked( $instance['property_id'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'property_id' ); ?>"><?php _e( 'Display property ID', 'wpsight' ); ?></label>		
		</p>
		
		<?php

		/** Loop through standard details */

		$standard_details = wpsight_standard_details();

		foreach( wpsight_standard_details() as $key => $values ) { ?>
			
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key], 1 ); ?> />
				<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo __( 'Display', 'wpsight' ) . ': <em>' . $values['label'] . '</em>'; ?></label>		
			</p><?php
			
		}

	}

} // end class wpSight_Listing_details