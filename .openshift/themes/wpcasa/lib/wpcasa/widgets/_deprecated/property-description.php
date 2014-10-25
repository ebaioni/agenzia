<?php

/**
 * Create property description widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_property_description' );
 
function wpcasa_register_widget_property_description() {
	register_widget( 'wpCasa_Property_Description' );
}

/**
 * Widget class
 */
	
class wpCasa_Property_Description extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Description on single property pages', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Description', WPSIGHT_NAME . ' ' . _x( 'Property Description', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_single() && get_post_type() == 'property' ) {
    
        	extract( $args, EXTR_SKIP );
        	        
        	$title  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        	$margin = empty( $title ) ? ' style="margin-top:-10px"' : '';
        	
        	// Get description
        	
        	$property = get_post( get_the_ID() );
			$property_description = wpsight_format_content( $property->post_content );
			
			if( empty( $property_description ) )
				return; ?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="property-description listing-description section clearfix clear"<?php echo $margin; ?>>
        		
				<?php 
					// Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">    
        	    	        <h2><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook property description title inside
        	    	            do_action( 'wpsight_listing_description_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div>
						
					<?php }						
						
					// Display content
					echo apply_filters( 'wpsight_widget_listing_description', $property_description );
				?>
				
			</div>
			
        <?php }
        
	}

    function update( $new_instance, $old_instance ) {  
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
        global $options;
        
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title 	  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p><?php

	}

} // end class wpCasa_Property_Description