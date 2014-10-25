<?php

/**
 * Create general shortcodes with
 * Bootstrap classes
 *
 * @package wpSight
 */
 
/**
 * Shortcode to output buttons
 *
 * @since 1.0
 */
 
add_shortcode( 'button', 'wpsight_button_shortcode' );

function wpsight_button_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'label'	 => '[linktext]',
		'url' 	 => '',
		'id'	 => '',
		'class'  => 'btn',
		'size'	 => '',
		'icon'	 => '',
		'autop'  => '',
		'target' => '',
		'status' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Set link href
	$href = ! empty( $id ) ? get_permalink( (int) $id ) : esc_url( $url );
	
	// Set link class
	$class = ! empty( $class ) ? 'btn ' . $class : 'btn';
	
	// Set button size
	$class .= ! empty( $size ) ? ' btn-' . $size : false;
	
	// Set button icon
	$icon = ! empty( $icon ) ? '<i class="icon-' . $icon . '"></i> ' : false;
	
	// Set link target
	$target = ! empty( $target ) ? ' target="' . $target . '"' : false;
	
	// Set link status
	$class .= ( $status == 'disabled' ) ? ' disabled' : false;
	
	$output = sprintf( '%1$s<a class="%5$s" href="%4$s"%7$s>%6$s%3$s</a>%2$s', $before, $after, $label, $href, $class, $icon, $target );
	
	// Wrap in p tags
	if( $autop != 'false' )
		$output = wpautop( $output );

	return apply_filters( 'wpsight_button_shortcode', $output, $atts );

}

/**
 * Shortcode to output alert boxes
 *
 * @since 1.0
 */
 
add_shortcode( 'alert', 'wpsight_alert_shortcode' );

function wpsight_alert_shortcode( $atts, $content = null ) {

	$defaults = array(
		'class'   => 'alert alert-block',
		'width'   => '',
		'close'   => '',
		'heading' => ''
	);

    extract( shortcode_atts( $defaults, $atts ) );
    
    // Set class
    $class = ! empty( $class ) ? 'alert alert-block ' . $class : 'alert alert-block';
    
    // Set width
    $width = ! empty( $width ) ? ' style="width:' . $width . '"' : false;
    
    // Set close
    $close = ( $close == 'true' ) ? '<a class="close" data-dismiss="alert">&times;</a>' : false;
    
    // Set heading
    $heading = ! empty( $heading ) ? '<h3 class="alert-heading">' . $heading . '</h3>' : false;
		
	// Allow shortcodes in $content
	$content = do_shortcode( $content );
    
    $output = sprintf( '<div class="%2$s"%3$s>%4$s%5$s%1$s</div>', $content, $class, $width, $close, $heading );
    
    return apply_filters( 'wpsight_alert_shortcode', $output, $atts );

}

/**
 * Shortcode to output Bootstrap icon
 *
 * @since 1.2
 */
 
add_shortcode( 'icon', 'wpsight_icon_shortcode' );

function wpsight_icon_shortcode( $atts ) {

	$defaults = array(
		'type'	 => 'thumbs-up',
		'class'	 => '',
		'size'	 => '',
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Replace icon- just in case
	$type = str_replace( 'icon-', '', $type );
	
	// Set font-size
	$size = ! empty( $size ) ? ' style="font-size:' . $size . '"' : false;

	$output = sprintf( '<%6$s class="wpsight-icon-sc"%5$s>%1$s<i class="icon-%3$s %4$s"></i>%2$s</%6$s>', $before, $after, $type, $class, $size, $wrap );

	return apply_filters( 'wpsight_icon_shortcode', $output, $atts );

}

/**
 * Custom post gallery shortcode
 *
 * @since 1.0
 */

add_shortcode( 'image_gallery', 'wpsight_image_gallery' );

function wpsight_image_gallery( $atts ) {

	$defaults = array(
		'link'	  => '',
		'order'   => 'ASC',
        'orderby' => 'menu_order ID',
        'id'      => get_the_ID(),
        'size'    => 'post-thumbnail',
        'include' => '',
        'exclude' => '',
        'nclear'  => ''
	);

	extract( shortcode_atts( $defaults, $atts ) );

    if ( ! empty( $include ) ) {
    
    	$include = preg_replace( '/[^0-9,]+/', '', $include );
    
    	$args = array(
    		'include' 		 => $include,
    		'post_status' 	 => 'inherit',
    		'post_type' 	 => 'attachment',
    		'post_mime_type' => 'image',
    		'order' 		 => $order,
    		'orderby' 		 => $orderby
    	);
    	
    	$args = apply_filters( 'wpsight_image_gallery_args', $args );
    
        $_attachments = get_posts( $args );

        $attachments = array();
        
        foreach ( $_attachments as $k => $v ) {
            $attachments[$v->ID] = $_attachments[$k];
        }
        
    } else {
    
    	if( $exclude == 'featured' )
    		$exclude = get_post_thumbnail_id( get_the_ID() );
    
    	$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
    	
    	$args = array(
    		'post_parent' 	 => $id,
    		'exclude' 		 => $exclude,
    		'post_status' 	 => 'inherit',
    		'post_type' 	 => 'attachment',
    		'post_mime_type' => 'image',
    		'order' 		 => $order,
    		'orderby' 		 => $orderby
    	);
    	
    	$args = apply_filters( 'wpsight_image_gallery_args', $args );
    	
        $attachments = get_children( $args );
        
    }

	// Stop if no attachments

    if ( empty( $attachments ) )
        return;
        
    // Return attachment link list in feeds

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
        return $output;
    }
    
    // Get layout
    
    $layout    = get_post_meta( get_the_ID(), '_layout', true );
    $post_type = get_post_type();
    
    // Check full size
    
    $full_size = ( $layout == 'full-width' || ( ! is_active_sidebar( 'sidebar' ) && ! is_active_sidebar( 'sidebar-' . $post_type ) ) ) ? true : false;
    
    // Set clear
    
    if( $size == 'post-thumbnail' || $size == 'small' ) {    
    	if( $full_size == true ) {
		    $n = ( WPSIGHT_LAYOUT == 'four' ) ? 4 : 3;
		} else {
		    $n = ( WPSIGHT_LAYOUT == 'four' ) ? 3 : 2;
		}		
	} elseif( $size == 'half' ) {
		$n = 2;    
    } elseif( $size == 'big' ) {
    	// Correct size if necessary
    	$size = ( $full_size == true ) ? 'full' : $size;
    	$n = 1;    
    } elseif( $size == 'full' ) {
    	$n = 1;
    }
    
    // Correct image size
    $size = ( $size == 'small' ) ? 'post-thumbnail' : $size;
    
    // Correct span depending on image size
    $span = ( $size == 'post-thumbnail' ) ? 'small' : $size;
    
    // Begin image gallery output
    
    $output  = "\n\n" . '<div class="image-gallery">' . "\n";
    $output .= "\n\t" . '<div class="row">' . "\n\n";
    
    // Set counter
    $i = 0;
    
    	// Loop through attachments

		foreach ( $attachments as $attachment_id => $attachment ) {
			
			// Set custom $n
			$n = ! empty( $nclear ) ? $nclear : $n;

			$clear = ( $i%$n == 0 ) ? ' clear' : false;

		    $output .= "\t\t" . '<div class="image-gallery-item ' . wpsight_get_span( $span ) . $clear . '">';

		    // Link to attachment page

		    if( $link == 'attachment' ) {
		    	$output .= '<span class="overlay"><span>';
		    	$output .= wp_get_attachment_link( $attachment_id, $size, true, false );
		    	$output .= '</span></span><!-- .overlay -->';		    
		    } else {

		    	// Unlinked image

		    	$image  = '<span class="overlay overlay-zoom"><span>';
		    	$image .= wp_get_attachment_image( $attachment_id , $size );	    
		    	$image .= '</span></span><!-- .overlay -->';

		    	// Link image if desired

		    	if( $link != 'false' ) {
		    		$src 	 = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wpsight_post_gallery_lightbox_size', 'original' ) );
		    		$output .= '<a href="' . $src[0] . '" title="' . $attachment->post_title . '" class="gallery-link">' . $image . '</a>';
		    	} else {
		    		$output .= $image;		    	
		    	}    
		    }

		    if( ! empty( $attachment->post_excerpt ) )
		    	$output .= '<div class="image-gallery-caption">' . $attachment->post_excerpt . '</div>';

		    $output .= '</div>' . "\n\n";

			// Increase counter
			$i++;

		} // endforeach

	$output .= "\t" . '</div><!-- .row -->' . "\n";
	$output .= "\n" . '</div><!-- .image-gallery -->' . "\n\n";

    return apply_filters( 'wpsight_image_gallery_shortcode', $output, $atts );
}

/**
 * Custom post slider shortcode
 *
 * @since 1.0
 */

add_shortcode( 'image_slider', 'wpsight_image_slider' );

function wpsight_image_slider( $atts ) {

	$defaults = array(
		'link'	  	=> '',
		'order'   	=> 'ASC',
        'orderby' 	=> 'menu_order ID',
        'id'      	=> get_the_ID(),
        'size'    	=> 'big',
        'include' 	=> '',
        'exclude' 	=> '',
        'prevnext'	=> 'true',
        'keynav' 	=> 'false',
        'mousenav' 	=> 'false',
        'effect'  	=> 'fade',
        'direction' => 'horizontal',
        'timer'   	=> 0
	);

	extract( shortcode_atts( $defaults, $atts ) );

    if ( ! empty( $include ) ) {
    
    	$include = preg_replace( '/[^0-9,]+/', '', $include );
    
		$args = array(
		    'include' 		 => $include,
		    'post_status' 	 => 'inherit',
		    'post_type' 	 => 'attachment',
		    'post_mime_type' => 'image',
		    'order' 		 => $order,
		    'orderby' 		 => $orderby
		);
    	
    	$args = apply_filters( 'wpsight_image_slider_args', $args );
    
        $_attachments = get_posts( $args );

        $attachments = array();
        
        foreach ( $_attachments as $k => $v ) {
            $attachments[$v->ID] = $_attachments[$k];
        }
        
    } else {
    
    	if( $exclude == 'featured' )
    		$exclude = get_post_thumbnail_id( get_the_ID() );
    
    	$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
    	
    	$args = array(
    		'post_parent' 	 => $id,
    		'exclude' 		 => $exclude,
    		'post_status' 	 => 'inherit',
    		'post_type' 	 => 'attachment',
    		'post_mime_type' => 'image',
    		'order' 		 => $order,
    		'orderby' 		 => $orderby
    	);
    	
    	$args = apply_filters( 'wpsight_image_slider_args', $args );
    	
        $attachments = get_children( $args );
        
    }

	// Stop if no attachments

    if ( empty( $attachments ) )
        return;
        
    // Return attachment link list in feeds

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
        return $output;
    }
    
    // Get layout
    
    $layout    = get_post_meta( get_the_ID(), '_layout', true );
    $post_type = get_post_type();
    
    // Check full size
    
    $full_size = ( $layout == 'full-width' || ( ! is_active_sidebar( 'sidebar' ) && ! is_active_sidebar( 'sidebar-' . $post_type ) ) ) ? true : false;
    
    // Correct image size
	$size = ( $full_size == true && $size == 'big' ) ? 'full' : $size;
    
    // Correct image size
    $size = ( $size == 'small' ) ? 'post-thumbnail' : $size;
    
    // Correct span depending on image size
    $span = ( $size == 'post-thumbnail' ) ? 'small' : $size;

	// Correct timer and slideshow = true
	$slideshow = ( $timer == 0 ) ? 'false' : 'true';

	// Correct timer
	$timer = ( $timer != 0 ) ? $timer . '000' : 0;

	$slider_args = array(
	    'animation' 		=> '"' . $effect . '",',
	    'direction' 		=> '"' . $direction . '",',
	    'slideshow' 		=> "$slideshow,",
	    'slideshowSpeed' 	=> "{$timer},",
	    'animationDuration' => '300,',
	    'directionNav' 		=> "$prevnext,",
	    'controlNav' 		=> 'false,',
	    'keyboardNav' 		=> "$keynav,",
	    'mousewheel' 		=> "$mousenav,",
	    'prevText' 			=> '"' . __( 'Previous', 'wpsight' ) . '",',
	    'nextText'			=> '"' . __( 'Next', 'wpsight' ) . '",',
	    'pausePlay' 		=> 'false,',
	    'pauseText' 		=> '"' . __( 'Pause', 'wpsight' ) . '",',
	    'playText' 			=> '"' . __( 'Play', 'wpsight' ) . '",',
	    'animationLoop' 	=> 'true,',
	    'pauseOnAction' 	=> 'true,',
	    'pauseOnHover' 		=> 'true'
	);

	$slider_args = apply_filters( 'wpsight_image_slider_options_args', $slider_args );

	// Create inline slider Javascript

	$output  = "\n" . '<script type="text/javascript">' . "\n";
	$output .= 'jQuery(document).ready(function($){' . "\n";
	$output .= "\t" . '$(function(){' . "\n";
	$output .= "\t\t" . '$(".flexslider").flexslider({' . "\n";
	foreach( $slider_args as $k => $v )
		$output .= "\t\t\t" . $k . ': ' . $v . "\n";
	$output .= "\t\t" . '});' . "\n";
	$output .= "\t" . '});' . "\n";
	$output .= '});' . "\n";
	$output .= '</script>' . "\n\n";

	/**
	 * Set fixed height on slider container
	 * to avoid layout jump on load
	 */						
	$img = wpsight_get_image_size( $size );
	$height = $img['size']['h'];
        		
    $output .= '<div class="row"><div class="image-slider ' . wpsight_get_span( $span ) . '">' . "\n";	
	$output .= "\n\t" . '<div class="flexslider height-' . $height . '"><ul class="slides">' . "\n";

	// Loop through attachments

	foreach ( $attachments as $attachment_id => $attachment ) {

		$output .= "\n\t\t" . '<li>';

		// Link to attachment page

		if( $link == 'attachment' ) {

		    $output .= wp_get_attachment_link( $attachment_id, $size, true, false );

		} else {

		    // Unlinked image

		    $image = wp_get_attachment_image( $attachment_id , $size );	    

		    // Link image if desired

		    if( $link != 'false' ) {
		    	$src 	 = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wpsight_post_slider_lightbox_size', 'original' ) );
		    	$output .= '<a href="' . $src[0] . '" title="' . $attachment->post_title . '" class="gallery-link">' . $image . '</a>';
		    } else {
		    	$output .= $image;		    	
		    }    
		}

		$output .= '</li>' . "\n";

	}

	$output .= "\n\t" . '</ul></div><!-- .flexslider -->' . "\n";
	$output .= "\n" . '</div><!-- .image-slider --></div>' . "\n";

	return apply_filters( 'wpsight_image_slider_shortcode', $output, $atts );
}

/**
 * Run shortcodes at priority 7 not 11 (default)
 * to make sure wpautop() works properly.
 *
 * @since 1.0
 * @see http://www.viper007bond.com/2009/11/22/wordpress-code-earlier-shortcodes/
 */
 
add_filter( 'the_content', 'wpsight_run_general_shortcodes_earlier', 7 );

function wpsight_run_general_shortcodes_earlier( $content ) {

    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
    
    // Register listing shortcodes
 
    add_shortcode( 'icon', 'wpsight_icon_shortcode' );
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}