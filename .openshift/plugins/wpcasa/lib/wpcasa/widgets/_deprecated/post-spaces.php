<?php

/**
 * Create lastest posts widget.
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_post_spaces' );
 
function wpcasa_register_widget_post_spaces() {

	if( current_theme_supports( 'post-spaces' ) )
		register_widget( 'wpCasa_Post_Spaces' );

}

class wpCasa_Post_Spaces extends WP_Widget {
 
	function __construct() {
		$widget_ops = array( 'description' => __( 'Custom sidebar content on posts and pages', 'wpsight' ) );
		parent::__construct( 'wpCasa_Post_Spaces', WPSIGHT_NAME . ' ' . __( 'Post Spaces', 'wpsight' ), $widget_ops );
    }
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
    
    	// Only on posts and pages
    	if( ! is_singular() )
    		return;
        
        $title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $space = isset( $instance['space'] ) ? $instance['space'] : false;
        
        // Get custom field
        $space_content = get_post_meta( get_the_ID(), $space, true );
        
        // Stop if it has no value
        if( empty( $space_content ) )
        	return; ?>
        
		<div id="<?php echo wpsight_dashes( $widget_id ); ?>-wrap" class="widget-wrap widget-post-spaces-wrap">
		
		    <div id="<?php echo wpsight_dashes( $widget_id ); ?>" class="widget section widget-post-spaces clearfix">
		    
		    	<div class="widget-inner"><?php
		
		    		if( ! empty( $title ) )
		    			echo '<h3 class="title">' . $title . '</h3>';
		    			
		    		echo wpsight_format_content( $space_content ); ?>
		
		    	</div><!-- .widget-inner -->
		    	
		    </div><!-- .widget -->
		    
		</div><!-- widget-wrap --><?php
        
    }

    function update( $new_instance, $old_instance ) {  
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
                  
        return $new_instance;
    }
 
    function form( $instance ) {
        
		$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $space = isset( $instance['space'] ) ? $instance['space'] : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p <?php if( count( wpsight_post_spaces() ) == 1 ) echo 'style="display:none"'; ?>>
			<label for="<?php echo $this->get_field_id( 'space' ); ?>"><?php _e( 'Space', 'wpsight' ); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'space' ); ?>" name="<?php echo $this->get_field_name( 'space' ); ?>">	
				<?php
					foreach( wpsight_post_spaces() as $k => $v ) {
						echo '<option value="' . $v['key'] . '" ' . selected( $v['key'], $space, false ) . '>' . $v['label'] . '</option>';
					}
				?>				
			</select><br />
			<span class="description"><?php _e( 'Select the space to display', 'wpsight' ); ?></span>			
		</p><?php

	}

} // end class wpsight_post_spaces