<?php

/**
 * Create listing gallery widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listing_gallery' );
 
function wpsight_register_widget_listing_gallery() {

	register_widget( 'wpSight_Listing_Gallery' );

}

/**
 * Widget class
 */
	
class wpSight_Listing_Gallery extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Gallery on single listing pages', 'wpsight' ) );
		parent::__construct( 'wpSight_Listing_Gallery', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listing Gallery', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_single() && get_post_type() == wpsight_listing_post_type() ) {
    
    		extract( $args, EXTR_SKIP );
        	        
        	$title 			  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        	$display 		  = isset( $instance['display'] ) ? $instance['display'] : 'thumbs';
        	$effect 		  = isset( $instance['slider_effect'] ) ? $instance['slider_effect'] : 'fade';
        	$timer	 		  = isset( $instance['slider_timer'] ) ? (int) $instance['slider_timer'] : 0;
        	$prevnext		  = isset( $instance['slider_prevnext'] ) ? $instance['slider_prevnext'] : true;
        	$links		  	  = isset( $instance['gallery_links'] ) ? $instance['gallery_links'] : false;
        	
        	// Optional exclude
        	$exclude_featured = isset( $instance['exclude_featured'] ) ? $instance['exclude_featured'] : false;
        	$exclude_images   = isset( $instance['exclude_images'] ) ? preg_replace( array( '/[^\d,]/', '/(?<=,),+/', '/^,+/', '/,+$/' ), '', $instance['exclude_images'] ) : false;
        	
        	// Optional include
        	$include_images	  = get_post_meta( get_the_ID(), 'gallery_include', true );
        	$include   		  = preg_replace( array( '/[^\d,]/', '/(?<=,),+/', '/^,+/', '/,+$/' ), '', $include_images );
        	
        	// Create exclude
        	
        	$exclude = false;
        	        	
        	if( $exclude_featured )
	        	$exclude = 'featured';
        	
        	if( $exclude_images )
	        	$exclude = $exclude_images;
        	
        	// Create prevnext
        	$prevnext = $prevnext ? 'true' : 'false';
        	
        	// Remove links
        	$links = $links ? 'false' : 'true';
					
			$do_shortcode_args = array(
			    'exclude'  => $exclude,
			    'include'  => $include,
			    'effect'   => $effect,
			    'timer'    => $timer,
			    'prevnext' => $prevnext,
			    'link'	   => $links
			);
			
			// Correct size depending on widget area
			
			if( $args['id'] == wpsight_get_sidebar( 'sidebar-listing' ) || $args['id'] == 'sidebar' )
				$do_shortcode_args = array_merge( array( 'size' => 'small' ), $do_shortcode_args );				
			    
			$do_shortcode_args = apply_filters( 'wpsight_listing_gallery_shortcode_args', $do_shortcode_args, $args, $instance );
			
			// Set up $shortcode_args for shortcode
			
			$shortcode_args = '';
			
			foreach( $do_shortcode_args as $k => $v ) {
				if( $do_shortcode_args[$k] )
					$shortcode_args .= ' ' . $k . '="' . $v . '"';
			}
			
			// Reduce margin top if title empty			
			$margin = empty( $title ) ? ' style="margin-top:-10px"' : '';
					
			// Create listing gallery
			
			$remove_links = isset( $remove_links ) ? $remove_links : false;
			
			$listing_gallery = '';
			    
			if( $display == 'thumbs' ) {			
			    // Apply image_gallery shortcode				    	
			    $listing_gallery .= do_shortcode( '[image_gallery' . $shortcode_args . $remove_links . ']' );			
			} else {			
			    // Apply image_slider shortcode				    
			    $listing_gallery .= do_shortcode( '[image_slider' . $shortcode_args . $remove_links . ']' );			
			}
			
			// Stop if no images
			if( empty( $listing_gallery ) )
				return; ?>
        	
        	<div id="<?php echo wpsight_dashes( $args['widget_id'] ); ?>" class="listing-gallery section clearfix clear"<?php echo $margin; ?>>
        		
				<?php						 
				    // Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">    
        	    	        <h2><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook listing gallery title inside
        	    	            do_action( 'wpsight_listing_gallery_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div>
						
					<?php }			    
		        
		    		echo apply_filters( 'wpsight_widget_listing_gallery', $listing_gallery, $args, $instance );
				    
				?>
				    
		    </div><!-- .listing-gallery --><?php
		}        
    }

    function update( $new_instance, $old_instance ) {  
    
    	$new_instance = (array) $new_instance;
    	
		$instance = array(
			'slider_prevnext'  => 0,
			'gallery_links'    => 0,
			'exclude_featured' => 0
		);
		
		foreach ( $instance as $field => $val )
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
    
    	$instance['title'] 	        = strip_tags( $new_instance['title'] );
    	$instance['display'] 	    = $new_instance['display'];
    	$instance['slider_effect']  = $new_instance['slider_effect'];
    	$instance['slider_timer']   = (int) $new_instance['slider_timer'];
    	$instance['exclude_images'] = preg_replace( array( '/[^\d,]/', '/(?<=,),+/', '/^,+/', '/,+$/' ), '', $new_instance['exclude_images'] );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
		$defaults = array(
			'display' 		   => 'thumbs',
			'slider_prevnext'  => true,
			'gallery_links'    => false,
			'exclude_featured' => false
		);
        
		$instance		= wp_parse_args( (array) $instance, $defaults );
		$title 			= isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$display		= isset( $instance['display'] ) ? $instance['display'] : 'thumbs';
		$effect			= isset( $instance['slider_effect'] ) ? $instance['slider_effect'] : 'fade';
		$timer			= isset( $instance['slider_timer'] ) ? (int) $instance['slider_timer'] : 0;
       	$exclude_images = isset( $instance['exclude_images'] ) ? preg_replace( array( '/[^\d,]/', '/(?<=,),+/', '/^,+/', '/,+$/' ), '', $instance['exclude_images'] ) : false;
       	
       	// Create exclude
        	
       	$exclude = false;
       	
       	if( $exclude_images )
       	    $exclude = $exclude_images; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display', 'wpsight' ); ?>:</label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>">			
				<option value="thumbs"<?php selected( $display, 'thumbs' ); ?>><?php _e( 'Thumbnails', 'wpsight' ); ?></option>
				<option value="slider"<?php selected( $display, 'slider' ); ?>><?php _e( 'Slider', 'wpsight' ); ?></option>				 
			</select>			
		</p>
		
		<div<?php if( $display != 'slider' ) echo ' style="display:none"'; ?>>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'slider_effect' ); ?>"><?php _e( 'Effect', 'wpsight' ); ?>:</label><br />
				<select class="widefat" id="<?php echo $this->get_field_id( 'slider_effect' ); ?>" name="<?php echo $this->get_field_name( 'slider_effect' ); ?>">			
					<option value="fade"<?php selected( $effect, 'fade' ); ?>><?php _e( 'Fade', 'wpsight' ); ?></option>
					<option value="slide"<?php selected( $effect, 'slide' ); ?>><?php _e( 'Slide', 'wpsight' ); ?></option>				 
				</select>			
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'slider_timer' ); ?>"><?php _e( 'Timer', 'wpsight' ); ?>:</label><br />
				<select class="widefat" id="<?php echo $this->get_field_id( 'slider_timer' ); ?>" name="<?php echo $this->get_field_name( 'slider_timer' ); ?>">			
					<option value="0"<?php selected( $timer, '0' ); ?>><?php _e( 'off', 'wpsight' ); ?></option>					
					<?php for( $i = 1; $i <= 10; $i++ ) { ?>					
					<option value="<?php echo $i; ?>"<?php selected( $timer, $i ); ?>><?php echo $i . ' ' . __( 'seconds', 'wpsight' ); ?></option>
					<?php } ?>
				</select>			
			</p>
			
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'slider_prevnext' ); ?>" name="<?php echo $this->get_field_name( 'slider_prevnext' ); ?>" <?php checked( $instance['slider_prevnext'], true ) ?> />
				<label for="<?php echo $this->get_field_id( 'slider_prevnext' ); ?>"><?php _e( 'Display previous / next', 'wpsight' ); ?></label>		
			</p>
		
		</div>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'gallery_links' ); ?>" name="<?php echo $this->get_field_name( 'gallery_links' ); ?>" <?php checked( $instance['gallery_links'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'gallery_links' ); ?>"><?php _e( 'Remove links', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'exclude_featured' ); ?>" name="<?php echo $this->get_field_name( 'exclude_featured' ); ?>" <?php checked( $instance['exclude_featured'], true ) ?> />
			<label for="<?php echo $this->get_field_id( 'exclude_featured' ); ?>"><?php _e( 'Exclude featured image', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_images' ); ?>"><?php _e( 'Exclude', 'wpsight' ); ?>:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'exclude_images' ); ?>" name="<?php echo $this->get_field_name( 'exclude_images' ); ?>" type="text" value="<?php echo esc_attr( $exclude ); ?>" /><br />
			<span class="description"><?php _e( 'Comma-separated list of image IDs', 'wpsight' ); ?></span>		
		</p><?php

	}

} // end class wpSight_Listing_Gallery