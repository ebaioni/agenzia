<?php

/**
 * Create listing title widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listing_title' );
 
function wpsight_register_widget_listing_title() {

	register_widget( 'wpSight_Listing_Title' );

}

/**
 * Widget class
 */
	
class wpSight_Listing_Title extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Main title on single listing pages', 'wpsight' ) );
		parent::__construct( 'wpSight_Listing_Title', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listing Title', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_singular() && get_post_type() == wpsight_listing_post_type() ) {
    
    		extract( $args, EXTR_SKIP );
        	        
        	$title 			 = '[' . __( 'Listing Title', 'wpsight' ) . ']';
        	$title_listing   = apply_filters( 'the_title', get_the_title( get_the_ID() ) );
        	$title_favorites = isset( $instance['title_favorites'] ) ? $instance['title_favorites'] : true;
        	$title_print  	 = isset( $instance['title_print'] ) ? $instance['title_print'] : true; ?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-title section clearfix clear">
        		
				<div class="title clearfix">
					<h1 class="entry-title"><?php echo apply_filters( 'wpsight_widget_listing_title', $title_listing, $args, $instance ); ?></h1>
        	    	<?php
        	   		    // Action hook listing title inside
        	   		    do_action( 'wpsight_listing_title_inside', $args, $instance );
        	   		?>    	
        	    </div>
				
			</div><!-- .listing-title --><?php

		}
        
	}

    function update( $new_instance, $old_instance ) {
    
    	$new_instance = (array) $new_instance;
    	
		$instance = array(
			'title_favorites' => 0,
			'title_print' 	  => 0
		);
		
		foreach ( $instance as $field => $val )
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
		
		$instance['title'] = '[' . __( 'Listing Title', 'wpsight' ) . ']';
                  
        return $instance;
    }
 
    function form( $instance ) {
        
        $defaults = array(
    		'title_favorites' => true,
    		'title_print' 	  => true
    	);
        
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title	  = '[' . __( 'Listing Title', 'wpsight' ) . ']';
?>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="hidden" value="<?php echo esc_attr( $title ); ?>" />

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'title_favorites' ); ?>" name="<?php echo $this->get_field_name( 'title_favorites' ); ?>" <?php checked( $instance['title_favorites'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'title_favorites' ); ?>"><?php _e( 'Display favorites link', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'title_print' ); ?>" name="<?php echo $this->get_field_name( 'title_print' ); ?>" <?php checked( $instance['title_print'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'title_print' ); ?>"><?php _e( 'Display print link', 'wpsight' ); ?></label>		
		</p><?php

	}

} // end class wpSight_Listing_Title