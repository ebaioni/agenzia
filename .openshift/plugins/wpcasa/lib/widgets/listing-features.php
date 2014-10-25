<?php

/**
 * Create listing features widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listing_features' );
 
function wpsight_register_widget_listing_features() {

	register_widget( 'wpSight_Listing_Features' );

}

/**
 * Widget class
 */
	
class wpSight_Listing_Features extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Features on single listing pages', 'wpsight' ) );
		parent::__construct( 'wpSight_Listing_Features', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listing Features', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_single() && get_post_type() == wpsight_listing_post_type() ) {
    
    		extract( $args, EXTR_SKIP );
        	        
        	$title 			 = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        	$unlink_features = isset( $instance['unlink_features'] ) ? $instance['unlink_features'] : false;

        	// Get features
        	$listing_features_terms = get_the_terms( get_the_ID(), 'feature' );
        	
        	// Stop here if no features
        	if( empty( $listing_features_terms ) )
        		return;
        	
        	?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-features section clearfix clear">
        		
				<?php 
					// Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">    
        	    	        <h2><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook listing features title inside
        	    	            do_action( 'wpsight_listing_features_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div>
						
					<?php }
						
					// Display features
			
					if( is_single() && get_post_type() == wpsight_listing_post_type() && ! empty( $listing_features_terms ) ) {
					
						$listing_features = '<ul class="clearfix">';
						
						foreach( $listing_features_terms as $term ) {
						
							// Optionally unlink features
						
							if( $unlink_features ) {
							
								$listing_features .= '<li>' . $term->name . '</li>';
							
							} else {
						
								$listing_features .= '<li><a href="' . get_term_link( $term, 'feature' ) . '">' . $term->name . '</a></li>';
							
							}
						
						}
						
						$listing_features .= '</ul>';
    						
    					echo apply_filters( 'wpsight_widget_listing_features', $listing_features, $args, $instance );
    				
    				}		
				?>
				
			</div>
			
        <?php }
        
    }

    function update( $new_instance, $old_instance ) {  
    
    	$new_instance = (array) $new_instance;
    	
		$instance = array(
			'unlink_features' => 0
		);
		
		foreach ( $instance as $field => $val )
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
		$instance = wp_parse_args( (array) $instance, array( 'unlink_features' => false ) );
		$title 	  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'unlink_features' ); ?>" name="<?php echo $this->get_field_name( 'unlink_features' ); ?>" <?php checked( $instance['unlink_features'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'unlink_features' ); ?>"><?php _e( 'Unlink features', 'wpsight' ); ?></label>		
		</p><?php

	}

} // end class wpSight_Listing_Features