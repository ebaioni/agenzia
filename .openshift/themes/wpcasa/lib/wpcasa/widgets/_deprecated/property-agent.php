<?php

/**
 * Create property agent widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_property_agent' );
 
function wpcasa_register_widget_property_agent() {
	register_widget( 'wpCasa_Property_Agent' );
}

/**
 * Widget class
 */
	
class wpCasa_Property_Agent extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Agent info on single property pages', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Agent', WPSIGHT_NAME . ' ' . _x( 'Property Agent', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	global $authordata;
        extract( $args, EXTR_SKIP );
        
        if( is_single() && get_post_type() == 'property' ) {
        
			$title_name		= isset( $instance['title_name'] ) ? $instance['title_name'] : true;
        	$title 			= ( $title_name ) ? '[' . __( 'Agent Name', 'wpsight' ) . ']' : strip_tags( $instance['title'] );
        	$title_contact	= isset( $instance['title_contact'] ) ? $instance['title_contact'] : false;
        	
        	?>
 
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="property-agent listing-agent section clearfix clear">
			
				<?php					
					// Build widget title
				
					if( $title_name )
						$title = get_the_author_meta( 'display_name' );
					
					// Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">
							<h2 class="author"><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook property agent title inside
        	    	            do_action( 'wpsight_listing_agent_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div><?php
        	    	    
        	    	}
					
					// Get author loop template
					get_template_part( 'loop', 'author' );
					
				?>
 
			</div><!-- .property-agent -->
			
		<?php }
    }

    function update($new_instance, $old_instance) {
    
    	$instance = array(
			'title_name' 	=> 0,
			'title_contact' => 0
		);
		
		foreach ( $instance as $field => $val ) {
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
		}
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $instance;
    }
 
    function form($instance) {
        
        $defaults = array(
			'title_name' 	=> true,
			'title_contact' => false
		);
        
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title 	  = ( $instance['title_name'] ) ? '[' . __( 'Agent Name', 'wpsight' ) . ']' : strip_tags( $instance['title'] );
		
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'title_name' ); ?>" name="<?php echo $this->get_field_name( 'title_name' ); ?>"<?php checked( $instance['title_name'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'title_name' ); ?>"><?php _e( 'Agent name as widget title', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'title_contact' ); ?>" name="<?php echo $this->get_field_name( 'title_contact' ); ?>"<?php checked( $instance['title_contact'], true ); ?> />
			<label for="<?php echo $this->get_field_id( 'title_contact' ); ?>"><?php _e( 'Show jump link to contact form', 'wpsight' ); ?></label>		
		</p><?php
		
	}

} // end class wpCasa_Property_Agent