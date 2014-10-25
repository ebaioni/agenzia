<?php

/**
 * Create call to action widget.
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_calltoaction' );
 
function wpsight_register_widget_calltoaction() {
	register_widget( 'wpSight_Call_to_Action' );
}

class wpSight_Call_to_Action extends WP_Widget {
 
	function __construct() {
		$widget_ops = array( 'description' => __( 'Visually highlighted call to action', 'wpsight' ) );
		parent::__construct( 'wpSight_Call_to_Action', ':: ' . WPSIGHT_NAME . ' ' . __( 'Call to Action', 'wpsight' ), $widget_ops );
    }
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
    	
    	$title  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $text   = isset( $instance['text'] ) ? wp_kses_post( $instance['text'] ) : false;
        $button = isset( $instance['button'] ) ? strip_tags( $instance['button'] ) : false;
        $label  = isset( $instance['label'] ) ? strip_tags( $instance['label'] ) : __( 'Button Label', 'wpsight' );
        $target = isset( $instance['target'] ) ? $instance['target'] : false;
        
        // Set button link

		if( substr( $button, 0, 4 ) == 'http' || substr( $button, 0, 1 ) == '#' ) {
			$url = $button;
		} elseif( is_numeric( $button ) ) {
		    $url = get_permalink( $button );
		};
		
		// When jump link set smooth class
		$smooth = substr( $button, 0, 1 ) == '#' ? ' smooth' : false; ?>
        
		<div id="<?php echo wpsight_dashes( $widget_id ); ?>-wrap" class="widget-wrap widget-call-to-action-wrap">
		
		    <div id="<?php echo wpsight_dashes( $widget_id ); ?>" class="widget widget-call-to-action clearfix">
		    
		    	<div class="widget-inner"><?php
		    	
		    		// Create call to action text
		    	
		    		$output = '';
		    	
		    		if( ! empty( $title ) )
		    			$output .= '<h2>' . $title . '</h2>';
		    			
		    		if( ! empty( $text ) )
		    			$output .= '<span>' . $text . '</span>';
		    		
		    		if( ! empty( $output ) )
		    			echo '<span class="call-to-action-text">' . $output . '</span>';
		    			
		    		// Create call to action button
		    		
		    		$target = $target ? ' target="_blank"' : '';
		    			
		    		if( ! empty( $url ) )
		    			echo '<span class="call-to-action-button"><a class="' . apply_filters( 'wpsight_button_class_calltoaction', 'btn btn-large btn-primary' ) . $smooth . '" href="' . $url . '"' . $target . '>' . $label . '</a></span>'; ?>
		
		    	</div><!-- .widget-inner -->
		    	
		    </div><!-- .widget -->
		    
		</div><!-- .widget-wrap --><?php
        
    }

    function update( $new_instance, $old_instance ) {
    	
    	$instance = array(
			'target' => 0
		);
		
		foreach ( $instance as $field => $val ) {
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
		}
    
    	$instance['title'] 	= strip_tags( $new_instance['title'] );
    	$instance['text']   = wp_kses_post( $new_instance['text'] );
    	$instance['button'] = strip_tags( $new_instance['button'] );
    	$instance['label']  = strip_tags( $new_instance['label'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
        $title  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$text   = isset( $instance['text'] ) ? wp_kses_post( $instance['text'] ) : false;
		$button = isset( $instance['button'] ) ? strip_tags( $instance['button'] ) : false;
		$label  = isset( $instance['label'] ) ? strip_tags( $instance['label'] ) : __( 'Button Label', 'wpsight' );
		$target = isset( $instance['target'] ) ? $instance['target'] : false; ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text', 'wpsight' ); ?>:</label>
			<textarea class="widefat" rows="10" cols="10" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $text ); ?></textarea><br />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Button', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" value="<?php echo esc_attr( $button ); ?>" />
			</label><br />
			<span class="description"><?php _e( 'Enter URL or post/page ID', 'wpsight' ); ?></span>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />
			</label>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'target' ); ?>" name="<?php echo $this->get_field_name( 'target' ); ?>"<?php checked( $target, true ); ?> />
			<label for="<?php echo $this->get_field_id( 'target' ); ?>"><?php _e( 'Open link in new tab or window', 'wpsight' ); ?></label>		
		</p><?php
		
	}

} // end class wpSight_Call_to_Action