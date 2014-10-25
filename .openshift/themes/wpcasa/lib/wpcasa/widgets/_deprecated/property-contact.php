<?php

/**
 * Create property contact widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Start session for captcha
 */
 
add_action( 'init', 'wpcasa_start_session' );

function wpcasa_start_session() {
	if( ! session_id() )
		session_start();
}
 
/**
 * Register widget
 */

add_action( 'widgets_init', 'wpcasa_register_widget_property_contact' );
 
function wpcasa_register_widget_property_contact() {
	register_widget( 'wpCasa_Property_Contact' );
}

/**
 * Widget class
 */
	
class wpCasa_Property_Contact extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Contact form on single property pages', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Contact', WPSIGHT_NAME . ' ' . _x( 'Property Contact', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_single() && get_post_type() == 'property' ) {

    		extract( $args, EXTR_SKIP );
        	        
        	$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        	$email_widget = isset( $instance['email'] ) ? sanitize_email( $instance['email'] ) : false; ?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="property-contact listing-contact section clearfix clear">
        	
        		<div id="contact"><?php

					// Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">    
        	    	        <h2><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook property contact title inside
        	    	            do_action( 'wpsight_listing_contact_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div><?php
        	    	    
					}
					
					/**
					 * Display contact form.
					 * See code in /lib/framework/properties.php
					 */
					do_action( 'wpsight_contact_form', 'listing', $instance ); ?>
					
				</div>
				
			</div>
			
        <?php }

	}

    function update( $new_instance, $old_instance ) {  
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
    	$instance['email'] = sanitize_email( $new_instance['email'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
        global $options;
        
		$instance	 = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $email = isset( $instance['email'] ) ? sanitize_email( $instance['email'] ) : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" /><br />
			<span class="description"><?php _e( 'If emtpy, emails are sent to the author of the property entry.', 'wpsight' ); ?></span>
		</p><?php

	}

} // end class wpCasa_Property_Contact