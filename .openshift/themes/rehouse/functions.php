<?php
/**
 * Main functions file
 *
 * @package wpCasa
 * @subpackage re:house
 */

/**
 * Remove default wpCasa actions
 *
 * @since 1.0
 */

add_action( 'wpsight_setup','unhook_wpcasa_actions' );

function unhook_wpcasa_actions() {
    remove_action( 'wpsight_main_before', 'wpsight_place_listing_search' );
    remove_action( 'wpsight_head_print', 'wpsight_stylesheets_print' );
    remove_action( 'customize_register', 'wpsight_customize_register_color' );
}

 
/**
 * Remove Google font Droid Serif
 * and add Oswald and Roboto
 *
 * @since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'dequeue_wpcasa_styles', 100 );

function dequeue_wpcasa_styles() {
	wp_dequeue_style( 'droid-serif' );	 
	wp_enqueue_style( 'oswald-roboto', '//fonts.googleapis.com/css?family=Oswald|Roboto:400,700', false, '1.0', 'all' ); 
}

 
/**
 * Set custom header $args
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_custom_header_args', 'rehouse_custom_header_args', 100 );

function rehouse_custom_header_args( $args ) {
	
	$args['height'] 			 = 700;
	$args['default-text-color']  = 'ffffff';
	$args['default-image'] 		 = false;
	$args['wp-head-callback'] 	 = 'rehouse_header_style';
	
	return $args;
	
}

// gets included in the site header

function rehouse_header_style() {
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
 * @since 1.0
 */
 
add_action( 'wpsight_setup', 'rehouse_custom_background_theme_support' );
 
function rehouse_custom_background_theme_support() {

	$args = array(
		'default-color' => 'eeeeee',
		'default-image' => false
	);
	
	$args = apply_filters( 'rehouse_custom_background_args', $args );	
	
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
 
add_filter( 'wpsight_options_layout', 'rehouse_options_layout' );

function rehouse_options_layout( $options ) {

	$options['header_right']['std'] = '<i class="icon-phone"></i> ' . __( 'Need expert advice? Call us now - 555 555 555', 'wpsight' ) . "\n" . '<span id="find-home">' . __( 'find your dream home today', 'wpsight-rehouse' ) . '</span>';
	
	return $options;

}


/**
 * Add background color to social icons
 * on theme settings page
 *
 * @since 1.0
 */

add_action( 'admin_head', 'rehouse_admin_css' );

function rehouse_admin_css(){ ?>
<style>
	#wpsight-options .section-info img { padding: 5px; background: #1f2326 }
</style>
<?php
}


/**
 * Remove boxed from body class
 *
 * @since 1.0
 */
 
add_filter( 'body_class', 'rehouse_remove_boxed', 100 );

function rehouse_remove_boxed( $classes ) {
	
	return str_replace( 'boxed', '', $classes );
	
}


/**
 * Add print stylesheet to print header
 *
 * @since 1.0
 */
 
add_action( 'wpsight_head_print', 'rehouse_stylesheets_print' );

function rehouse_stylesheets_print() { ?>
<link href="<?php echo WPSIGHT_CHILD_URL; ?>/style-print.css" rel="stylesheet" type="text/css">
<?php
}


/**
 * Add search to wpsight_main_before hook
 *
 * @since 1.0
 */

add_action( 'wpsight_main_before', 'rehouse_place_property_search' );

function rehouse_place_property_search() {

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
 * Add print logo option
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_general', 'rehouse_options_general' );

function rehouse_options_general( $options ) {

	$options['logo_print'] = array( 
	    'name' => __( 'Print Logo', 'wpsight' ),
	    'desc' => __( 'Please enter a URL or upload an image.', 'wpsight' ),
	    'id'   => 'logo_print',
	    'std'  => WPSIGHT_IMAGES . '/logo-print.png',
	    'type' => 'upload'
	);

	return $options;

}


/**
 * Set print logo
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_do_print_logo_image', 'rehouse_do_print_logo_image' );

function rehouse_do_print_logo_image( $image ) {

	$logo_print = wpsight_get_option( 'logo_print' );

	if( isset( $logo_print ) && ! empty( $logo_print ) )
		return $logo_print;
		
	return $image;

}


/**
 * Set print logo in email templates
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_get_logo', 'rehouse_do_logo_image', 10, 2 );

function rehouse_do_logo_image( $logo, $location ) {

	if( $location != 'email' )
		return $logo;

	$logo_image = wpsight_get_option( 'logo', true );
	$logo_print = wpsight_get_option( 'logo_print' );
	
	if( isset( $logo_print ) && ! empty( $logo_print ) )
		return str_replace( $logo_image, $logo_print, $logo );
		
	return $logo;

}


/**
 * Set button classes
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_button_class_agent', 'rehouse_button_class' );
add_filter( 'wpsight_button_class_contact', 'rehouse_button_class' );

function rehouse_button_class( $class ) {
	
	return $class . ' btn-primary';

}


/**
 * Create more button
 *
 * @since 1.0
 */

add_filter( 'wpsight_excerpt_more', 'rehouse_excerpt_more' );

function rehouse_excerpt_more() {
	return '<div class="moretag-wrap"><a class="moretag btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . apply_filters( 'wpsight_more_text', __( 'Read more', 'wpsight' ) ) . '</a></div>';
}


/**
 * Set property map icon
 *
 * @since 1.0
 */

add_filter( 'wpsight_map_listing_icon', 'rehouse_map_listing_icon', 11 );

function rehouse_map_listing_icon( $icon ) {

	$icon = WPSIGHT_CHILD_URL . '/images/map-listing.png';
	
	return $icon;

}


/**
 * Register custom customizer color options
 *
 * @since 1.0
 */

add_action( 'customize_register', 'rehouse_customize_register_color', 11 );

function rehouse_customize_register_color( $wp_customize ) {
	
	// Add setting link color
	
	$wp_customize->add_setting(
		'accent_color',
		array(
			'default' 		=> '#c0392b',
			'type' 			=> 'theme_mod'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'customize_accent_color',
			array(
			    'label'    => __( 'Accent Color', 'wpsight' ),
			    'section'  => 'colors',
			    'settings' => 'accent_color',
			)
		)
	);

}


/**
 * Add theme mods CSS from
 * customizer to header
 *
 * @since 1.0
 */
 
add_action( 'wp_head', 'rehouse_do_theme_mods_css' );

function rehouse_do_theme_mods_css() {

	$mods = '';
	
	// Get link color
	
	$accent_color = rehouse_generate_css( 'a, a:visited, .wpsight-menu .sf-menu li li a:hover, .listing-search-buttons div:hover', 'color', 'accent_color' );
	$accent_color .= rehouse_generate_css( '.title a:hover, .post-title a:hover, .listing-features a:hover', 'color', 'accent_color', false, ' !important' );
	$accent_color .= rehouse_generate_css( '.wpsight-menu-main, .btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled], .btn-primary:active, .btn-primary.active, .flex-direction-nav .flex-prev:hover, .flex-direction-nav .flex-next:hover, span.favorites-remove:hover, .wpsight-menu .sf-menu li:hover ul, .wpsight-menu .sf-menu li.sfHover ul', 'background-color', 'accent_color' );
	$accent_color .= rehouse_generate_css( '.wpsight-menu-top-left .sf-menu ul, .wpsight-menu-top-right .sf-menu ul, .wpsight-menu-sub, .wpsight-menu-sub .sf-menu ul, .wpsight-menu-sub .sf-menu ul', 'background-color', 'accent_color', false, false, false, '.9' );
	
	if( ! empty( $accent_color ) )
		$mods .= $accent_color;
	
	if( ! empty( $mods ) ) {	
	
		$css  = '<style type="text/css" media="screen">';
		$css .= $mods;
		$css .= '</style>' . "\n";
		
		echo $css;
		
	}

}


/**
 * Helper function to display
 * theme_mods CSS
 *
 * @since 1.0
 */
 
function rehouse_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = false, $opacity = false ) {

	$output = '';
	$mod = get_theme_mod( $mod_name );
	
	if ( ! empty( $mod ) ) {		
	
		if( $opacity !== false ) {
			$rgb = rehouse_hex2rgb( $mod );
			$mod = 'rgba(' . $rgb . ',' . $opacity . ')';
		}
	
	   $output = "\n\t" . sprintf( '%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix ) . "\n";
	   
	   if ( $echo )
	      echo $output;
	}
	
	return $output;

}


/**
 * Helper function to convert
 * hex color in RGBA
 *
 * @since 1.0
 */

function rehouse_hex2rgb( $hex ) {

	$hex = str_replace( '#', '', $hex );
	
	if( strlen( $hex ) == 3 ) {
	
	   $r = hexdec( substr( $hex,0,1 ) . substr( $hex,0,1 ) );
	   $g = hexdec( substr( $hex,1,1 ) . substr( $hex,1,1 ) );
	   $b = hexdec( substr( $hex,2,1 ) . substr( $hex,2,1 ) );
	   
	} else {
	
	   $r = hexdec( substr( $hex,0,2 ) );
	   $g = hexdec( substr( $hex,2,2 ) );
	   $b = hexdec( substr( $hex,4,2 ) );

	}
	
	$rgb = array( $r, $g, $b );
	
	return implode( ',', $rgb );
}


/**
 * Set exmaple content XML name
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_example_xml_name', 'rehouse_example_xml_name' );

function rehouse_example_xml_name() {
	return 'rehouse';
}


/**
 * Create theme update object
 *
 * @since 1.0
 */
 
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-updates.php' );

add_filter( 'tuc_request_update_query_args-rehouse', 'tuc_request_update_query_args_rehouse' );

function tuc_request_update_query_args_rehouse( $args ) {

	$args['theme'] = 'rehouse';
	$args['token'] = wpsight_nonce( 86400, 'rehouse' );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	'rehouse',
	'http://update.wpcasa.com/api.php'
);
