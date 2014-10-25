<?php

/**
 * Built header output with top bar,
 * main header section with logo and header right area
 * and main and sub menu.
 *
 * @package wpSight
 */
 
/**
 * Built doctype and open html and head tag.
 * Add classes to html tag for ie7 and ie8.
 * Add meta tag for content type with charset.
 *
 * @since 1.0
 */
 
add_action( 'wpsight_head', 'wpsight_do_doctype' );
 
function wpsight_do_doctype() {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie7" <?php language_attributes( 'xhtml' ); ?>"> <![endif]-->
<!--[if IE 8 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie8" <?php language_attributes( 'xhtml' ); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class="not-ie8" <?php language_attributes( 'xhtml' ); ?>> <!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php

}

/**
 * Built title tag
 *
 * @since 1.0
 */
 
add_action( 'wpsight_head', 'wpsight_do_title' );
 
function wpsight_do_title() {
	
	$args = array(
		'separator' => ' &raquo; ',
		'position'  => 'right'
	);
	
	$args = apply_filters( 'wpsight_do_title_args', $args );

	$output = "\n" . '<title>' . wp_title( $args['separator'], false, $args['position'] ) . get_bloginfo( 'name' ) . '</title>';
	
	echo apply_filters( 'wpsight_do_title', $output );

}

/**
 * Add scripts to header
 *
 * @since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'wpsight_scripts' );

function wpsight_scripts() {

	// Enqueue jQuery
	wp_enqueue_script( 'jquery' );
	
	// Enqueue custom scripts	
	wp_enqueue_script( 'scripts', WPSIGHT_ASSETS_JS_URL . '/scripts.min.js', array( 'jquery' ), '1.2.2', true );
	
	// Enqueue Bootstrap JS
	wp_enqueue_script( 'bootstrap', WPSIGHT_ASSETS_JS_URL . '/bootstrap.min.js', array( 'jquery' ), '2.0', true );

	// Enqueue comment reply
	if ( is_singular() && get_option( 'thread_comments' ) && ! is_page_template( 'page-tpl-blog.php' ) )
		wp_enqueue_script( 'comment-reply' );
		
	// Enqueue Prettify
	if( current_theme_supports( 'prettify' ) )
		wp_enqueue_script( 'prettify', WPSIGHT_ASSETS_JS_URL . '/prettify/prettify.js', array( 'scripts' ), '1.0', true );
	
	// Enqueue Google Maps
	if( current_theme_supports( 'gmaps' ) )
		wp_enqueue_script( 'gmaps', '//maps.google.com/maps/api/js?sensor=false', '', '4.2', false );
		
	// Enqueue Photoswipe
	if( current_theme_supports( 'PhotoSwipe' ) ) {
		wp_enqueue_script( 'photoswipe', WPSIGHT_ASSETS_JS_URL . '/photoswipe/photoswipe.js', array( 'jquery' ), '3.0.5', true );
		wp_enqueue_script( 'klass', WPSIGHT_ASSETS_JS_URL . '/photoswipe/klass.min.js', array( 'jquery' ), '3.0.5', true );
		wp_enqueue_script( 'photoswipe-code', WPSIGHT_ASSETS_JS_URL . '/photoswipe/code.photoswipe.jquery-3.0.5.min.js', array( 'jquery' ), '3.0.5', true );
	}
	
	// Enqueue Flexslider
	if( current_theme_supports( 'FlexSlider' ) )
		wp_enqueue_script( 'flex', WPSIGHT_ASSETS_JS_URL . '/flex/jquery.flexslider-min.js', array( 'jquery' ), '2.1', true );
	
	// Localize scripts
	
	$data = array(
		'menu_blank' 			   => apply_filters( 'wpsight_mobile_menu_default', __( 'Select a page', 'wpsight' ) ),
		'cookie_path' 			   => COOKIEPATH,
		'cookie_search_advanced'   => WPSIGHT_COOKIE_SEARCH_ADVANCED,
		'cookie_search_query'	   => WPSIGHT_COOKIE_SEARCH_QUERY,
		'cookie_favorites_compare' => WPSIGHT_COOKIE_FAVORITES_COMPARE,
		'comment_button_class' 	   => apply_filters( 'wpsight_button_class_comment', 'btn btn-large btn-primary' )
	);
	
	wp_localize_script( 'scripts', 'wpsight_localize', $data );
	
}

/**
 * Add stylesheets to header
 *
 * @since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'wpsight_stylesheets' );

function wpsight_stylesheets() {

	// Enqueue Bootstrap CSS
	wp_enqueue_style( 'bootstrap', WPSIGHT_ASSETS_CSS_URL . '/bootstrap.min.css', false, '2.0', 'all'  );
	
	// Enqueue Droid Serif Google font
	wp_enqueue_style( 'droid-serif', '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic', false, '1.2', 'all' );
	
	// Enqueue wpSight layout CSS
	wp_enqueue_style( 'layout', WPSIGHT_ASSETS_CSS_URL . '/layout.min.css', false, '1.2', 'all'  );
	
	// Enqueue default theme CSS
	wp_enqueue_style( 'style', get_bloginfo( 'stylesheet_url' ), false, '1.2', 'screen'  );
	
	// Enqueue RTL stylesheet
	if( is_rtl() )
		wp_enqueue_style( 'rtl', WPSIGHT_ASSETS_CSS_URL . '/rtl.min.css', false, '1.2', 'all' );
	
	// Enqueue Photoswipe CSS
	if( current_theme_supports( 'PhotoSwipe' ) )
		wp_enqueue_style( 'photoswipe', WPSIGHT_ASSETS_JS_URL . '/photoswipe/photoswipe.css', false, '3.0.5', 'all' );
}

/**
 * Add print styles to print header
 *
 * @since 1.2
 */
 
add_action( 'wpsight_head_print', 'wpsight_stylesheets_print' );

function wpsight_stylesheets_print() { ?>
<link href="<?php echo WPSIGHT_URL; ?>/style-print.css" rel="stylesheet" type="text/css">
<?php
}

/**
 * Add favicon and main stylesheet to
 * wpsight_head hook.
 *
 * @since 1.0
 */
 
add_action( 'wpsight_head', 'wpsight_do_head' );

function wpsight_do_head() {

	echo "\n";	
	if( wpsight_get_option( 'favicon' ) )
		echo "\n" . '<link rel="Shortcut Icon" href="' . wpsight_get_option( 'favicon' ) . '" type="image/x-icon" />';

}

/**
 * Add meta tags to
 * wpsight_head hook.
 *
 * @since 1.0
 */
 
add_action( 'wpsight_head', 'wpsight_do_meta' );

function wpsight_do_meta() {

	$output = "\n";
	$output .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />' . "\n\n";
	
	echo apply_filters( 'wpsight_do_meta', $output );

}

/**
 * Custom RSS feed
 *
 * @since 1.0
 */

add_filter( 'feed_link' , 'wpsight_feed_link', 1, 2 );

function wpsight_feed_link( $output, $feed ) {

	$feed_url = wpsight_get_option( 'custom_rss' );
	
	if( ! empty( $feed_url ) ) {

		$feed_array = array(
			'rss' => $feed_url,
			'rss2' => $feed_url,
			'atom' => $feed_url,
			'rdf' => $feed_url,
			'comments_rss2' => ''
		);
		
		$feed_array = apply_filters( 'wpsight_feed_link_array', $feed_array );
		
		$feed_array[$feed] = $feed_url;
		
		$output = $feed_array[$feed];
	
	}

	return $output;
}

/**
 * Add generator meta tag
 * for theme info
 *
 * @since 1.0
 */

add_filter( 'the_generator', 'wpsight_generator' );

function wpsight_generator( $generator ) {
	$generator .= "\r\n" . '<meta name="generator" content="' . WPSIGHT_NAME . ' ' . WPSIGHT_VERSION . '" />';
	return $generator;
}

/**
 * Add custom CSS from
 * theme options to header
 *
 * @since 1.0
 */
 
add_action( 'wp_head', 'wpsight_do_custom_css' );

function wpsight_do_custom_css() {

	$css_option = wpsight_get_option( 'custom_css' );
	
	if( ! empty( $css_option ) ) {	
	
		$css  = '<style type="text/css" media="screen">';
		$css .= stripslashes( $css_option );
		$css .= '</style>' . "\n";
		
		echo $css;
		
	}

}
 
/**
 * Add theme mods CSS from
 * theme options to header
 *
 * @since 1.0
 */
 
add_action( 'wp_head', 'wpsight_do_theme_mods_css' );

function wpsight_do_theme_mods_css() {

	$mods = '';
	
	// Get link color
	
	$link_color = wpsight_generate_css( 'a, a:visited, .title a:hover, .post-title a:hover, #logo-text span, .wpsight-menu .sf-menu li li a:hover, .category-description a, .listing-features a:hover, .listing-search-buttons div:hover, #the404, .flex-direction-nav .flex-prev:hover, .flex-direction-nav .flex-next:hover', 'color', 'link_color' );
	$link_color .= wpsight_generate_css( 'span.favorites-remove:hover', 'background-color', 'link_color' );
	
	if( ! empty( $link_color ) )
		$mods .= $link_color;
	
	if( ! empty( $mods ) ) {	
	
		$css  = '<style type="text/css" media="screen">';
		$css .= $mods;
		$css .= '</style>' . "\n";
		
		echo $css;
		
	}

}
 
/**
 * Built top bar with menu
 * and social icons
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_before', 'wpsight_do_top' );
 
function wpsight_do_top() {

	// Open layout wrap
	wpsight_layout_wrap( 'top-wrap' ); ?>

	<div id="top" class="row"><?php
	
		// Check if social icons to display
		$nr = apply_filters( 'wpsight_social_icons_nr', 5 );
				
		$social_icons = array();
		
		for( $i = 1; $i <= $nr; $i++ ) {
		    $social_icons[] = wpsight_get_social_icon( wpsight_get_option( 'icon_' . $i ) );				    
		}
		
		// Remove empty elements
		$social_icons = array_filter( $social_icons );
		
		// Set top-left span accordingly
		$span = ! empty( $social_icons ) ? 'span8' : 'span12';
		
		if( has_nav_menu( 'menu-top-left' ) ) { ?>
	        		
			<div id="top-left" class="<?php echo $span; ?>">
			
				<?php echo wpsight_menu( 'top-left', false ); ?>
			
			</div><!-- #top-left --><?php
	
		}
		
		// Loop through social icons
		
		if( ! empty( $social_icons ) ) {
		
		    $i = 1;
		    
		    // Set top-right span accordingly
			$span = ! has_nav_menu( 'menu-top-left' ) ? 'span12' : 'span4';
		    
		    $output  = '<div id="top-right" class="' . $span . '">' . "\n";
		    $output .= '<div class="social-icons">' . "\n";
		    
		    foreach( $social_icons as $k => $v ) {				
		        $social_link = wpsight_get_option( 'icon_' . $i . '_link' );				    	
		        $output .= '<a href="' . $social_link . '" target="_blank" title="' . $v['title'] . '" class="social-icon social-icon-' . $v['id'] . '"><img src="' . $v['icon'] . '" alt="" /></a>' . "\n";				    		
		        $i++;				    		
		    }
		    
		    $output .= '</div><!-- .social-icons -->' . "\n";
		    $output .= '</div><!-- #top-right -->' . "\n";
		    
		    echo apply_filters( 'wpsight_social_icons_top', $output );
		} ?>
	
	</div><!-- #top --><?php
	
	// Close layout wrap	
	wpsight_layout_wrap( 'top-wrap', 'close' );
	        		
}

/**
 * Custom header image
 *
 * @since 1.0
 */
 
/**
 * Add custom header theme support
 *
 * @since 1.0
 */

add_action( 'wpsight_setup', 'wpsight_custom_header_theme_support' );
 
function wpsight_custom_header_theme_support() {
	
	$args = array(
		'width'               => 1060,
		'height'              => 142,
		'flex-width'		  => true,
		'flex-height'		  => true,
		'header-text'		  => false,
		'default-text-color'  => '303030',
		'default-image'       => false,
		'random-default'	  => false,
		'wp-head-callback'    => 'wpsight_header_style',
		'admin-head-callback' => 'wpsight_admin_header_style',
	);

	$args = apply_filters( 'wpsight_custom_header_args', $args );
	
	/** 
	 * Register support for custom header WordPress 3.4+
	 * with fallback for older versions.
	 */

	if ( function_exists( 'get_custom_header' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		define( 'NO_HEADER_TEXT', 	   true );
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'] );
	}

}

// gets included in the site header
function wpsight_header_style() {
	$header_image = get_header_image();
	if( empty( $header_image ) )
		return;
	?>
<style type="text/css">
#header-wrap {
    background: url(<?php header_image(); ?>) no-repeat center center;
    background-size: cover;
}
</style>
<?php }

// gets included in the admin header
function wpsight_admin_header_style() { ?>
<style type="text/css">
#headimg {
    width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
    height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
    background: no-repeat;
}
</style>
<?php }

/**
 * Add custom background theme support
 *
 * @since 1.0
 */
 
add_action( 'wpsight_setup', 'wpsight_custom_background_theme_support' );
 
function wpsight_custom_background_theme_support() {

	$args = array(
		'default-color' => 'f8f8f8',
		'default-image' => WPSIGHT_ASSETS_IMG_URL . '/bg-dots.png'
	);
	
	$args = apply_filters( 'wpsight_custom_background_args', $args );	
	
	/** 
	 * Register support for custom background WordPress 3.4+
	 * with fallback for older versions.
	 */

	if ( function_exists( 'get_custom_header' ) ) {
	    add_theme_support( 'custom-background', $args );
	} else {
	    define( 'BACKGROUND_COLOR', $args['default-color'] );
	  	define( 'BACKGROUND_IMAGE', $args['default-image'] );
	    add_custom_background();
	}

}

/**
 * Built logo
 *
 * @since 1.0
 */
 
add_action( 'wpsight_logo', 'wpsight_do_logo' );

function wpsight_get_logo( $location = false ) {

	// Get logo image from options
	$logo_image = wpsight_get_option( 'logo', true );
	
	// Filter logo image
	$logo_image = apply_filters( 'wpsight_do_logo_image', $logo_image, $location );
	
	// Get logo text from options
	$logo_text = wpsight_get_option( 'logo_text' );
	
	// Filter logo text
	$logo_text = apply_filters( 'wpsight_do_logo_text', $logo_text, $location );
	
	$logo = false;
	
	// Get logo title	
	$logo_title = get_bloginfo( 'name' );
	
	// Filter logo title
	$logo_title = apply_filters( 'wpsight_do_logo_title', $logo_title, $location );
	
	if( ! empty( $logo_image ) )
		// Create logo image
		$logo = '<div id="logo"><a href="' . home_url() . '" title="' . $logo_title . '"><img src="' . $logo_image . '" alt="" /></a></div><!-- #logo -->';		
	
	if( ! empty( $logo_text ) )
		// Get text logo and set to blog name if emtpy
		$logo = '<div id="logo-text"><a href="' . home_url() . '" title="' . $logo_title . '">' . $logo_text . '</a></div><!-- #logo-text -->';
	
	// Get logo slogan	
	$logo_description = get_bloginfo( 'description' );
	
	// Filter logo slogan
	$logo_description = apply_filters( 'wpsight_do_logo_description', $logo_description, $location );
	
	if( ! empty( $logo_description ) ) {
	
		// Set slogan tag to H1 on front page
		$tag = ( is_front_page() ) ? 'h1' : 'div';
		$logo .= "\n" . '<' . $tag . ' id="logo-description">' . $logo_description . '</' . $tag . '>';
		
	}
		
	return apply_filters( 'wpsight_get_logo', $logo, $location );

}

function wpsight_do_logo( $location = false ) {

	$logo = wpsight_get_logo( $location );

	echo apply_filters( 'wpsight_do_logo', $logo, $location );

}

/**
 * Built header right area
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_right', 'wpsight_do_header_right' );

function wpsight_do_header_right() {

	// Get header right content from options
	$header_right = wpsight_get_option( 'header_right' );
	
	// Set default value if option has not been set
	
	if( wpsight_get_option( 'header_right' ) === false )
		$header_right = wpsight_get_option( 'header_right', true );
	
	if( ! empty( $header_right ) )
		echo apply_filters( 'wpsight_do_header_right', nl2br( $header_right ) );

}

// Activate shortocdes in header right
add_filter( 'wpsight_do_header_right', 'do_shortcode' );

/**
 * Built main menu after header
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_after', 'wpsight_do_menu' );
 
function wpsight_do_menu() {

	// Open layout wrap
	wpsight_layout_wrap( 'menu-wrap' ); ?>

	<div id="menu">	
		<?php echo wpsight_menu( 'main', true ); ?>    
    </div><!-- .menu --><?php
    
    // Close layout wrap	
	wpsight_layout_wrap( 'menu-wrap', 'close' );

}

/**
 * Built sub menu after main menu
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_after', 'wpsight_do_submenu' );
 
function wpsight_do_submenu() {

	if( ! has_nav_menu( 'menu-sub' ) )
		return;

	// Open layout wrap
	wpsight_layout_wrap( 'submenu-wrap' ); ?>

	<div id="submenu">	
		<?php echo wpsight_menu( 'sub', false ); ?>		
	</div><!-- .submenu --><?php
    
    // Close layout wrap	
	wpsight_layout_wrap( 'submenu-wrap', 'close' );

}

/**
 * Activate Yoast Breadcrumbs
 * if available
 *
 * @since 1.2
 */

add_action( 'wpsight_main_before', 'wpsight_yoast_breadcrumb', 9 );

function wpsight_yoast_breadcrumb() {
	if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() )
		yoast_breadcrumb('<div class="container"><p id="breadcrumbs">','</p></div>');
}
