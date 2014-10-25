<?php
/**
 * Main functions file
 *
 * @package wpCasa
 * @subpackage CasaNova
 */
 
/**
 * Remove Google font droid serif
 * and add Oswald and Lora
 */
 
add_action( 'wp_enqueue_scripts', 'dequeue_wpcasa_styles', 100 );

function dequeue_wpcasa_styles() {
	wp_dequeue_style( 'droid-serif' );	 
	wp_enqueue_style( 'oswald-lora', 'http://fonts.googleapis.com/css?family=Oswald|Lora:400,700', false, '1.0', 'all' ); 
}
 
/**
 * Set custom header $args
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_custom_header_args', 'casanova_custom_header_args', 100 );

function casanova_custom_header_args( $args ) {
	
	$args['height'] 			 = 700;
	$args['default-text-color']  = 'ffffff';
	$args['default-image'] 		 = get_stylesheet_directory_uri() . '/images/header-image.jpg';
	$args['wp-head-callback'] 	 = 'casanova_header_style';
	
	return $args;
	
}

// gets included in the site header

function casanova_header_style() {
	$header_image = get_header_image();	
	if( empty( $header_image ) )
		return;
	?>
<style type="text/css">
#main-top {
    background: url(<?php header_image(); ?>) repeat-y center top;
}
</style>
<?php }

/**
 * Add custom background theme support
 *
 * @since 1.1.1
 */
 
add_action( 'wpsight_setup', 'casanova_custom_background_theme_support' );
 
function casanova_custom_background_theme_support() {

	$args = array(
		'default-color' => 'eeeeee',
		'default-image' => false
	);
	
	$args = apply_filters( 'casanova_custom_background_args', $args );	
	
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
 * Remove boxed from body class
 */
 
add_filter( 'body_class', 'casanova_remove_boxed', 100 );

function casanova_remove_boxed( $classes ) {
	
	return str_replace( 'boxed', '', $classes );
	
}

/**
 * Add print stylesheet to print header
 *
 * @since 1.2
 */
 
add_action( 'wpsight_head_print', 'casanova_stylesheets_print' );

function casanova_stylesheets_print() { ?>
<link href="<?php echo WPSIGHT_CHILD_URL; ?>/style-print.css" rel="stylesheet" type="text/css">
<?php
}

/**
 * Remove default wpCasa actions
 *
 * @since 1.0
 */

add_action( 'wpsight_setup','unhook_wpcasa_actions' );

function unhook_wpcasa_actions() {
    remove_action( 'wpsight_main_before', 'wpsight_place_listing_search' );
    remove_action( 'wpsight_head_print', 'wpsight_stylesheets_print' );
}

/**
 * Add search to wpsight_main_before hook
 *
 * @since 1.0
 */

add_action( 'wpsight_main_before', 'casanova_place_property_search' );

function casanova_place_property_search() {

	$search_show = wpsight_get_option( 'search_show', false );
	
	if( $search_show['search'] && is_search() ) {
		$show = true;
	} elseif( $search_show['archive'] && ( is_tax( 'location' ) || is_tax( 'feature' ) || is_tax( 'property-type' ) || is_tax( 'property-category' ) ) ) {
		$show = true;
	} elseif( $search_show['templates'] && ( is_page_template( 'page-tpl-listings.php' ) || is_page_template( 'page-tpl-properties.php' ) ) ) {
		$show = true;
	} else {
		$show = false;
	}
	
	if( $show == true ) {
		echo '<div id="listing-search-wrap" class="wrap"><div class="container"><div class="row"><div class="span12">';
		wpsight_do_listing_search();
		echo '</div></div></div></div>';
	}

}

/**
 * Set button classes
 *
 * @since 1.1
 */
 
add_filter( 'wpsight_button_class_agent', 'casanova_button_class' );
add_filter( 'wpsight_button_class_contact', 'casanova_button_class' );

function casanova_button_class( $class ) {
	
	return $class . ' btn-primary';

}

/**
 * Create more button
 *
 * @since 1.0
 */

add_filter( 'wpsight_excerpt_more', 'casanova_excerpt_more' );

function casanova_excerpt_more() {
	return '<div class="moretag-wrap"><a class="moretag btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . apply_filters( 'wpsight_more_text', __( 'Read more', 'wpsight' ) ) . '</a></div>';
}

/**
 * Limit image size on properties map
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_do_property_image_size', 'casanova_limit_image_size_map' );

function casanova_limit_image_size_map( $image_size ) {

	if( is_page_template( 'page-tpl-map.php' ) )
		$image_size = 'post-thumbnail';
		
	return $image_size;

}

/**
 * Set property map icon
 *
 * @since 1.2
 */

add_filter( 'wpsight_map_listing_icon', 'casanova_map_listing_icon', 11 );

function casanova_map_listing_icon( $icon ) {

	$icon = WPSIGHT_CHILD_URL . '/images/map-listing.png';
	
	return $icon;

}

/**
 * Register custom customizer color options
 *
 * @since 1.2
 */

remove_action( 'customize_register', 'wpsight_customize_register_color' );
add_action( 'customize_register', 'casanova_customize_register_color', 11 );

function casanova_customize_register_color( $wp_customize ) {
	
	// Add setting link color
	
	$wp_customize->add_setting(
		'link_color',
		array(
			'default' 		=> '#21659B',
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
 
add_filter( 'wpsight_example_xml_name', 'casanova_example_xml_name' );

function casanova_example_xml_name() {
	return 'casanova';
}

/**
 * Create theme update object
 *
 * @since 1.1
 */
 
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-updates.php' );

add_filter( 'tuc_request_update_query_args-casanova', 'tuc_request_update_query_args_casanova' );

function tuc_request_update_query_args_casanova( $args ) {

	$args['theme'] = 'casanova';
	$args['token'] = wpsight_nonce( 86400, 'casanova' );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	'casanova',
	'http://update.wpcasa.com/api.php'
);