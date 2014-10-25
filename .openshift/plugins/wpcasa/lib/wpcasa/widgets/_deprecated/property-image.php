<?php

/**
 * Create property image widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_property_image' );
 
function wpcasa_register_widget_property_image() {
	register_widget( 'wpCasa_Property_Image' );
}

/**
 * Widget class
 */
	
class wpCasa_Property_Image extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Featured image on single property pages', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Image', WPSIGHT_NAME . ' ' . _x( 'Property Image', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_single() && get_post_type() == 'property' && has_post_thumbnail( get_the_ID() ) ) {
    
    		extract( $args, EXTR_SKIP );
        	        
        	$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        	
        	?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="property-image listing-image section clearfix clear">
        		
				<?php
					// Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">    
        	    	        <h2><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook property description title inside
        	    	            do_action( 'wpsight_listing_image_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div>
						
					<?php }
				
					// If in sidebar display smaller image
					
					$args['id'] = isset( $args['id'] ) ? $args['id'] : false;
					$wpcasa_thumb = ( $args['id'] == 'sidebar-property' ) ? 'post-thumbnail' : 'big';
					
					// Set full width image
					if( get_post_meta( get_the_ID(), '_layout', true ) == 'full-width' )
						$wpcasa_thumb = 'full';
									
					// Display featured image
					echo apply_filters( 'wpsight_widget_listing_image', get_the_post_thumbnail( get_the_ID(), $wpcasa_thumb, array( 'alt' => get_the_title(), 'title' => get_the_title() ) ), $args, $instance );
				?>
				
			</div><!-- .property-image --><?php

		}
        
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

} // end class wpCasa_Property_Image