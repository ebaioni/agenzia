<?php

/**
 * Create listing agent widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_featured_agent' );
 
function wpsight_register_widget_featured_agent() {

	register_widget( 'wpSight_Featured_Agent' );

}

/**
 * Widget class
 */
	
class wpSight_Featured_Agent extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Featured agent info', 'wpsight' ) );
		parent::__construct( 'wpSight_Featured_Agent', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Featured Agent', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
		global $authordata;
		extract( $args, EXTR_SKIP );
		
		$agent			= isset( $instance['agent'] ) ? $instance['agent'] : false;
		$title_name		= isset( $instance['title_name'] ) ? $instance['title_name'] : true;
		$title 			= ( $title_name ) ? '[' . __( 'Agent Name', 'wpsight' ) . ']' : strip_tags( $instance['title'] );
		$title_contact	= isset( $instance['title_contact'] ) ? $instance['title_contact'] : false; ?>
		
		<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-agent featured-agent section clearfix clear">
		
		    <?php					
		    	// Build widget title
		    
		    	if( $title_name ) {
		    		$agent = get_userdata( $agent );
		    		$title = $agent->display_name;
		    	}
		    	
		    	// Display title if exists
		    	
		    	if( ! empty( $title ) ) { ?>
		    		
		    		<div class="title clearfix">
		    			<h2 class="author"><?php echo $title; ?></h2>
		    	        <?php
		    	            // Action hook listing agent title inside
		    	            do_action( 'wpsight_featured_agent_title_inside', $args, $instance );
		    	        ?>    	
		    	    </div><?php
		    	    
		    	}
		    	
		    	// Get author/listing agent information
				do_action( 'wpsight_listing_agent', 'featured', $args, $instance );
		    	
		    ?>
		
		</div><!-- .featured-agent --><?php
		
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
    
    	$instance['agent'] = strip_tags( $new_instance['agent'] );
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $instance;
    }
 
    function form($instance) {
        
        $defaults = array(
			'title_name' 	=> true,
			'title_contact' => false
		);
        
		$instance = wp_parse_args( (array) $instance, $defaults );
		$agent	  = isset( $instance['agent'] ) ? $instance['agent'] : false;
		$title 	  = ( $instance['title_name'] ) ? '[' . __( 'Agent Name', 'wpsight' ) . ']' : strip_tags( $instance['title'] ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'agent' ); ?>"><?php _e( 'Agent', 'wpsight' ); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'agent' ); ?>" name="<?php echo $this->get_field_name( 'agent' ); ?>">
				<option value=""><?php _e( 'Please select user', 'wpsight' ); ?>&hellip;</option>
				<?php
					$args = apply_filters( 'wpsight_featured_agent_user_args', $args );
					foreach( get_users( $args ) as $user ) {
						echo '<option value="' . $user->ID . '"' . selected( $user->ID, $agent, false ) . '>' . $user->display_name . '</option>';
					}
				?>
			</select>
		</p>
		
		<div<?php if( $agent == false ) echo ' style="display:none"';?>>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</label>
			</p>
			
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'title_name' ); ?>" name="<?php echo $this->get_field_name( 'title_name' ); ?>"<?php checked( $instance['title_name'], true ); ?> />
				<label for="<?php echo $this->get_field_id( 'title_name' ); ?>"><?php _e( 'Agent name as widget title', 'wpsight' ); ?></label>		
			</p>
			
			<p<?php if( ! is_pagetemplate_active( 'page-tpl-contact.php' ) ) echo ' style="display:none"';?>>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'title_contact' ); ?>" name="<?php echo $this->get_field_name( 'title_contact' ); ?>"<?php checked( $instance['title_contact'], true ); ?> />
				<label for="<?php echo $this->get_field_id( 'title_contact' ); ?>"><?php _e( 'Show link to contact form', 'wpsight' ); ?></label>		
			</p>
		
		</div><?php
		
	}

} // end class wpSight_Featured_Agent