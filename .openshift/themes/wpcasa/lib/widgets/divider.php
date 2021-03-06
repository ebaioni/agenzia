<?php

/**
 * Create divider widget.
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_divider' );
 
function wpsight_register_widget_divider() {
		register_widget( 'wpSight_Divider' );
}

class wpSight_Divider extends WP_Widget {
 
	function __construct() {
		$widget_ops = array( 'description' => __( 'Visual divider between widgets', 'wpsight' ) );
		parent::__construct( 'wpSight_Divider', ':: ' . WPSIGHT_NAME . ' ' . __( 'Divider', 'wpsight' ), $widget_ops );
    }
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
        
        $title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $align = isset( $instance['align'] ) ? $instance['align'] : 'left';
        
        $notitle = empty( $title ) ? ' no-title' : ''; ?>
        
		<div id="<?php echo wpsight_dashes( $widget_id ); ?>-wrap" class="widget-wrap widget-divider-wrap<?php echo $notitle; ?>">
		
		    <div id="<?php echo wpsight_dashes( $widget_id ); ?>" class="widget widget-divider clearfix">
		    
		    	<div class="widget-inner"><?php
		
		    		if( ! empty( $title ) ) {
		    			$align = 'title-' . $align;
		    			echo '<h3 class="title ' . $align . '">' . $title . '</h3>';
		    		} ?>
		
		    	</div><!-- .widget-inner -->
		    	
		    </div><!-- .widget -->
		    
		</div><!-- .widget-wrap --><?php
        
    }

    function update( $new_instance, $old_instance ) {
    
    	$instance = $old_instance;
    
    	$instance['title'] = strip_tags( $new_instance['title'] );
    	$instance['align'] = strip_tags( $new_instance['align'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
		$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$align = isset( $instance['align'] ) ? $instance['align'] : 'left';
?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
		    <label for="<?php echo $this->get_field_id( 'align' ); ?>"><?php _e( 'Title Align', 'wpsight' ); ?>:</label>
		    <select class="widefat" id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>">
		    	<option value="left"<?php selected( 'left', $align ); ?>><?php _e( 'left', 'wpsight' ); ?></option>
		    	<option value="center"<?php selected( 'center', $align ); ?>><?php _e( 'center', 'wpsight' ); ?></option>
		    	<option value="right"<?php selected( 'right', $align ); ?>><?php _e( 'right', 'wpsight' ); ?></option>
		    </select>
		</p><?php

	}

} // end class wpSight_Divider