<?php
/**
 * Main functions file
 *
 * @package wpSight
 * @subpackage Ushuaia
 */
 
/**
 * Ushuaia setup actions
 *
 * @since 1.0
 */

add_action( 'wpsight_setup','ushuaia_setup' );

function ushuaia_setup() {
    add_filter( 'wpsight_image_sizes', 'ushuaia_image_sizes' );
    remove_action( 'wpsight_listing_title_after', 'wpsight_do_listing_details_overview' );
	remove_action( 'wpsight_widget_listing_title_after', 'wpsight_do_listing_details_overview', 10, 2 );
	remove_action( 'wpsight_head_print', 'wpsight_stylesheets_print' );
}
 
/**
 * Add full size slider image size
 *
 * @since 1.0
 */

function ushuaia_image_sizes( $sizes ) {
	
	$sizes['slider'] = array(
	    'size' => array(
	    	'w' => 1600,
	    	'h' => 600
	    ),
	    'crop'  => true,
	    'label' => __( 'slider', 'wpsight' )
	);
	
	return $sizes;
	
}
 
/**
 * Remove Google font droid serif
 *
 * @since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'dequeue_wpsight_styles', 100 );

function dequeue_wpsight_styles() {
	wp_dequeue_style( 'droid-serif' );
}

/**
 * Add stylesheets to header
 *
 * @since 1.2
 */
 
add_action( 'wpsight_head_print', 'ushuaia_stylesheets_print' );

function ushuaia_stylesheets_print() { ?>
<link href="<?php echo WPSIGHT_CHILD_URL; ?>/style-print.css" rel="stylesheet" type="text/css">
<?php
}

/**
 * Unset submenu
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_menus', 'ushuaia_menus' );

function ushuaia_menus( $menus ) {

	unset( $menus['sub'] );
	
	return $menus;

}
 
/**
 * Set custom header $args
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_custom_header_args', 'ushuaia_custom_header_args', 100 );

function ushuaia_custom_header_args( $args ) {
	
	$args['height'] 			 = 490;
	$args['default-text-color']  = 'ffffff';
	$args['default-image'] 		 = get_stylesheet_directory_uri() . '/images/header-image.png';
	$args['wp-head-callback'] 	 = 'ushuaia_header_style';
	
	return $args;
	
}

// gets included in the site header

function ushuaia_header_style() {
	$header_image = get_header_image();	
	if( empty( $header_image ) )
		return;
	?>
<style type="text/css">
#outer {
    background: url(<?php header_image(); ?>) no-repeat 30% -220px;
}
</style>
<?php }

/**
 * Add custom background theme support
 *
 * @since 1.0.2
 */
 
add_action( 'wpsight_setup', 'ushuaia_custom_background_theme_support' );
 
function ushuaia_custom_background_theme_support() {

	$args = array(
		'default-color' => 'ffffff',
		'default-image' => false
	);
	
	$args = apply_filters( 'ushuaia_custom_background_args', $args );	
	
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
 * Set different default value
 * for header right in theme options
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_layout', 'ushuaia_options_layout' );

function ushuaia_options_layout( $options ) {

	$options['header_right']['std'] = '<i class="icon-phone"></i> ' . __( 'Need expert advice? Call us now - 555 555 555', 'wpsight' ) . "\n" . '<span id="find-home">' . __( 'find your dream home today', 'wpsight-ushuaia' ) . '</span>';
	
	return $options;

}

/**
 * Remove boxed from body class
 */
 
add_filter( 'body_class', 'ushuaia_remove_boxed', 100 );

function ushuaia_remove_boxed( $classes ) {
	
	return str_replace( 'boxed', '', $classes );
	
}

/**
 * Set button classes
 *
 * @since 1.1
 */
 
add_filter( 'wpsight_button_class_agent', 'ushuaia_button_class' );
add_filter( 'wpsight_button_class_contact', 'ushuaia_button_class' );

function ushuaia_button_class( $class ) {
	
	return $class . ' btn-primary';

}

/**
 * Include slider
 *
 * @since 1.0
 */
 
require_once( 'lib/slider.php' );

/**
 * Create more button
 *
 * @since 1.0
 */

add_filter( 'wpsight_excerpt_more', 'ushuaia_excerpt_more' );

function ushuaia_excerpt_more() {
	return ' <a class="moretag" href="'. get_permalink( get_the_ID() ) . '">[' . apply_filters( 'wpsight_more_text', __( 'Read more', 'wpsight' ) ) . ']</a>';
}

/**
 * Display listing details overview
 * after listing teaser
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_content_after', 'ushuaia_do_listing_details_overview' );
add_action( 'wpsight_listing_map_content', 'ushuaia_do_listing_details_overview' );
add_action( 'wpsight_widget_listing_content_after', 'ushuaia_do_listing_details_overview', 10, 2 );

function ushuaia_do_listing_details_overview( $args = '', $instance = '' ) {
	
	// Stop if on listing single page
	//if( is_listing_single() || empty( $instance ) )
	//	return;
		
	echo preg_replace( '/\s+/', ' ', wpsight_get_listing_details() );
	
}

/**
 * Limit image size on listings map
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_do_listing_image_size', 'ushuaia_limit_image_size_map' );

function ushuaia_limit_image_size_map( $image_size ) {

	if( is_page_template( 'page-tpl-map.php' ) )
		$image_size = 'post-thumbnail';
		
	return $image_size;

}

/**
 * Set listing map icon
 *
 * @since 1.2
 */

add_filter( 'wpsight_map_listing_icon', 'ushuaia_map_listing_icon', 11 );

function ushuaia_map_listing_icon( $icon ) {

	$icon = WPSIGHT_CHILD_URL . '/images/map-listing.png';
	
	return $icon;

}

/**
 * Register custom customizer color options
 *
 * @since 1.2
 */

remove_action( 'customize_register', 'wpsight_customize_register_color' );
add_action( 'customize_register', 'ushuaia_customize_register_color', 11 );

function ushuaia_customize_register_color( $wp_customize ) {
	
	// Add setting link color
	
	$wp_customize->add_setting(
		'link_color',
		array(
			'default' 		=> '#485a70',
			'type' 			=> 'theme_mod'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'customize_link_color',
			array(
			    'label'    => __( 'Link Color', 'wpsight' ),
			    'section'  => 'colors',
			    'settings' => 'link_color',
			)
		)
	);

}

/**
 * Set exmaple content XML name
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_example_xml_name', 'ushuaia_example_xml_name' );

function ushuaia_example_xml_name() {
	return 'ushuaia';
}

/**
 * Create theme update object
 *
 * @since 1.0
 */
 
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-updates.php' );

add_filter( 'tuc_request_update_query_args-ushuaia', 'tuc_request_update_query_args_ushuaia' );

function tuc_request_update_query_args_ushuaia( $args ) {

	$args['theme'] = 'ushuaia';
	$args['token'] = wpsight_nonce( 86400, 'ushuaia' );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	'ushuaia',
	'http://update.wpcasa.com/api.php'
);