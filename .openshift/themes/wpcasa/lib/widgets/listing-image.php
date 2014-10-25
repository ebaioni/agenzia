<?php

/**
 * Create listing image widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listing_image' );
 
function wpsight_register_widget_listing_image() {

	register_widget( 'wpSight_Listing_Image' );

}

/**
 * Widget class
 */
	
class wpSight_Listing_Image extends WP_Widget {
    
    function __construct() {
		$widget_ops = array( 'description' => __( 'Featured image on single listing pages', 'wpsight' ) );
		parent::__construct( 'wpSight_Listing_Image', ':: ' . WPSIGHT_NAME . ' ' . _x( 'Listing Image', 'listing widget', 'wpsight' ), $widget_ops );
	}
 
    function widget( $args, $instance ) {
    
    	if( is_listing_single() && has_post_thumbnail( get_the_ID() ) ) {
    
    		extract( $args, EXTR_SKIP );
        	        
        	$title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        	
        	// Set image info
        	
        	$thumbnail 	   = get_post( get_post_thumbnail_id() );
        	$thumbnail_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
        	
        	// Get image caption
        	$caption = $thumbnail->post_excerpt ? $thumbnail->post_excerpt : false;
        	
        	// Get image alt text
        	$alt = $thumbnail_alt ? $thumbnail_alt : get_the_title();
        	
        	// Get image description
        	$description = $thumbnail->post_content ? $thumbnail->post_content : get_the_title(); ?>
        	
        	<div id="<?php echo wpsight_dashes( $this->id ); ?>" class="listing-image section clearfix clear">
        		
				<?php
					// Display title if exists
					
					if( ! empty( $title ) ) { ?>
						
						<div class="title clearfix">    
        	    	        <h2><?php echo $title; ?></h2>
        	    	        <?php
        	    	            // Action hook listing description title inside
        	    	            do_action( 'wpsight_listing_image_title_inside', $args, $instance );
        	    	        ?>    	
        	    	    </div>
						
					<?php }
				
					// If in sidebar display smaller image
					
					$args['id'] = isset( $args['id'] ) ? $args['id'] : false;
					$wpsight_thumb = ( $args['id'] == wpsight_get_sidebar( 'sidebar-listing' ) ) ? 'post-thumbnail' : 'big';
					
					// Set full width image
					if( get_post_meta( get_the_ID(), '_layout', true ) == 'full-width' )
						$wpsight_thumb = 'full';
						
					// Set full width image
					if( ! is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing' ) ) )
						$wpsight_thumb = 'full';
									
					// Display featured image
					$listing_image = apply_filters( 'wpsight_widget_listing_image', get_the_post_thumbnail( get_the_ID(), $wpsight_thumb, array( 'alt' => $alt, 'title' => $description ) ), $args, $instance );
					
					// Wrap if caption
					if( $caption )
						$listing_image = '<div class="wp-caption alignnone">' . $listing_image . '<p class="wp-caption-text">' . $caption . '</p>' . '</div><!-- .wp-caption -->';
						
					echo $listing_image;
				?>
				
			</div><!-- .listing-image --><?php

		}
        
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

} // end class wpSight_Listing_Image