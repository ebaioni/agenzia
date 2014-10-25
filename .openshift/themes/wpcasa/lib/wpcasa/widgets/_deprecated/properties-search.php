<?php

/**
 * Create property description widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 0.8
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_property_search' );
 
function wpcasa_register_widget_property_search() {
	register_widget( 'wpCasa_Property_Search' );
}

/**
 * Widget class
 */
	
class wpCasa_Property_Search extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Advanced property search form', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Search', WPSIGHT_NAME . ' ' . _x( 'Property Search', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
    	        
    	$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false; ?>
    	
    	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-search-widget section clearfix clear">
    		
        	<?php 
        		// Display title if exists
        		
        		if( ! empty( $title ) ) { ?>
        			
        			<div class="title clearfix">    
    	    	        <h1><?php echo $title; ?></h1>
    	    	        <?php
    	    	            // Action hook property description title inside
    	    	            do_action( 'wpsight_listing_search_title_inside', $args, $instance );
    	    	        ?>    	
    	    	    </div>
        			
        		<?php }						
        			
        		/**
        		 * Display search form.
        		 * See code in /lib/framework/properties.php
        		 */
        		do_action( 'wpsight_listings_search', $args, $instance );        		
        	?>
        	
        </div>
        
    <?php }

    function update( $new_instance, $old_instance ) {  
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
        global $options;
        
		$instance	= wp_parse_args( (array) $instance, array( 'title' => '') );
		$title 		= isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			
		</p><?php

	}

} // end class wpCasa_Property_Search