<?php

/**
 * Create listing search widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 0.8
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listings_search' );
 
function wpsight_register_widget_listings_search() {

	register_widget( 'wpSight_Listings_Search' );

}

/**
 * Widget class
 */
	
class wpSight_Listings_Search extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Advanced listing search form', 'wpsight' ) );
		parent::__construct( 'wpSight_Listings_Search', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listings Search', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
    	        
    	$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false; ?>
    	
    	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listings-search-widget section clearfix clear"><?php 
    	
			// Display title if exists
			
			if( ! empty( $title ) ) { ?>
			    
			    <div class="title clearfix">    
			        <h1><?php echo $title; ?></h1>
			        <?php
			            // Action hook listing search title inside
			            do_action( 'wpsight_listings_search_title_inside', $args, $instance );
			        ?>    	
			    </div>
			    
			<?php }						
			    
			/**
			 * Display search form.
			 * See code in /lib/framework/listings.php
			 */
			do_action( 'wpsight_listings_search', $args, $instance ); ?>
        	
        </div><?php
        
    }

    function update( $new_instance, $old_instance ) {  
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title 	  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			
		</p><?php

	}

} // end class wpSight_Listings_Search