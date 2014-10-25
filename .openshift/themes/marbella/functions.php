<?php
/**
 * Main functions file
 *
 * @package wpCasa
 * @subpackage Marbella
 */

/**
 * Remove default wpSight actions
 *
 * @since 1.0
 */

add_action( 'wpsight_setup','unhook_wpsight_actions' );

function unhook_wpsight_actions() {
	remove_action( 'wpsight_header_before', 'wpsight_do_top' );
	remove_action( 'wpsight_header_after', 'wpsight_do_menu' );
	remove_action( 'wpsight_head_print', 'wpsight_stylesheets_print' );
	remove_action( 'customize_register', 'wpsight_customize_register_color' );
}

 
/**
 * Set container around top and header wrap
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_before', 'marbella_container_top_open' );
 
function marbella_container_top_open() {

	echo '<div id="container-top-wrap">';
	        		
}

add_action( 'wpsight_header_after', 'marbella_container_top_close' );

function marbella_container_top_close() {

	echo '</div><!-- #container-top-wrap -->';

}


/**
 * Set container around main and footer wrap
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_after', 'marbella_header_after' );

function marbella_header_after() {

	echo '</div><!-- #container-top-wrap -->';

	echo '<div id="container-wrap">';

}

add_action( 'wpsight_footer_after', 'marbella_footer_after' );

function marbella_footer_after() {

	echo '</div><!-- #container-wrap -->';

}


/**
 * Animate header area on front page
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_layout_wrap', 'marbella_layout_wrap', 10, 2 );

function marbella_layout_wrap( $layout_wrap, $wrap_id ) {

	// Only header wrap on front page

	if( $wrap_id != 'header-wrap' || ! is_front_page() )
		return $layout_wrap;
	
	// Add necessary classes	
	$layout_wrap = str_replace( 'class="wrap"', 'class="wrap animated fadeInUp"', $layout_wrap );
	
	return $layout_wrap;

}

 
/**
 * Remove Google font droid serif
 * and add Bitter
 *
 * @since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'dequeue_wpsight_styles', 100 );

function dequeue_wpsight_styles() {
	wp_dequeue_style( 'droid-serif' );
	wp_enqueue_style( 'bitter', 'http://fonts.googleapis.com/css?family=Bitter:400,700,400italic', false, '1.0', 'all' );
}

 
/**
 * Set custom header $args
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_custom_header_args', 'marbella_custom_header_args', 100 );

function marbella_custom_header_args( $args ) {
	
	$args['width'] 			 	= 2000;
	$args['height'] 			= 1143;
	$args['default-text-color'] = 'ffffff';
	$args['default-image'] 		= get_stylesheet_directory_uri() . '/images/header-image.jpg';
	$args['wp-head-callback'] 	= 'marbella_header_style';
	
	return $args;
	
}

// gets included in the site header

function marbella_header_style() {
	$header_image = get_header_image();	
	if( empty( $header_image ) )
		return;
	?>
<style type="text/css">
#container-top-wrap {
    background-image: url(<?php header_image(); ?>);
    background-repeat: no-repeat;
    background-position: center;
    background-color: #363c44;
    background-size: cover;
}
</style>
<?php }


/**
 * Add custom background theme support
 *
 * @since 1.1.1
 */
 
add_action( 'wpsight_setup', 'marbella_custom_background_theme_support' );
 
function marbella_custom_background_theme_support() {

	$args = array(
		'default-color' => 'eeeeee',
		'default-image' => false
	);
	
	$args = apply_filters( 'marbella_custom_background_args', $args );	
	
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
 * Add print logo option
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_general', 'marbella_options_general' );

function marbella_options_general( $options ) {

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
 * Set different default value
 * for header right in theme options
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_layout', 'marbella_options_layout' );

function marbella_options_layout( $options ) {

	$options['header_right']['std'] = '<i class="icon-phone"></i> ' . __( 'Need expert advice? Call us now - 555 555 555', 'wpsight' ) . "\n" . '<span id="find-home">' . __( 'find your dream home today', 'wpsight-marbella' ) . '</span>';
	
	return $options;

}


/**
 * Customize menus
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_menus', 'marbella_menus' );
 
function marbella_menus( $menus ) {

	// Remove top left
	unset( $menus['top-left'] );
	
	// Add bottom menu
	$menus['bottom'] = __( 'Bottom Menu', 'wpsight' );
	
	return $menus;

}


/**
 * Built top bar with menu
 * and social icons
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_before', 'marbella_do_top', 20 );
 
function marbella_do_top() {

	// Open layout wrap
	wpsight_layout_wrap( 'top-wrap' ); ?>

	<div id="top" class="row">
	        		
		<div id="top-menu" class="span12">
		
			<?php echo wpsight_menu( 'main', true ); ?>
		
		</div><!-- #top-menu -->
	
	</div><!-- #top --><?php
	
	// Close layout wrap	
	wpsight_layout_wrap( 'top-wrap', 'close' );
	        		
}


/**
 * Set print logo
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_do_print_logo_image', 'marbella_do_print_logo_image' );

function marbella_do_print_logo_image( $image ) {

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
 
add_filter( 'wpsight_get_logo', 'marbella_do_logo_image', 10, 2 );

function marbella_do_logo_image( $logo, $location ) {

	if( $location != 'email' )
		return $logo;

	$logo_image = wpsight_get_option( 'logo', true );
	$logo_print = wpsight_get_option( 'logo_print' );
	
	if( isset( $logo_print ) && ! empty( $logo_print ) )
		return str_replace( $logo_image, $logo_print, $logo );
		
	return $logo;

}


/**
 * Add Gravityforms button class
 */
 
remove_filter( 'gform_submit_button', 'wpsight_gform_submit_button', 10, 2 );
add_filter( 'gform_submit_button', 'marbella_gform_submit_button', 10, 2 );

function marbella_gform_submit_button( $button ) {

	return str_replace( 'class="', 'class="btn btn-primary ', $button );

}


/**
 * Create more button
 *
 * @since 1.0
 */

add_filter( 'wpsight_excerpt_more', 'marbella_excerpt_more' );

function marbella_excerpt_more() {
	return '<div class="moretag-wrap"><a class="moretag btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . apply_filters( 'wpsight_more_text', __( 'Read more', 'wpsight' ) ) . '</a></div>';
}


/**
 * Set listing map icon
 *
 * @since 1.2
 */

add_filter( 'wpsight_map_listing_icon', 'marbella_map_listing_icon', 11 );

function marbella_map_listing_icon( $icon ) {

	$icon = WPSIGHT_CHILD_URL . '/images/map-listing.png';
	
	return $icon;

}


/**
 * Add print stylesheet to print header
 *
 * @since 1.2
 */
 
add_action( 'wpsight_head_print', 'marbella_stylesheets_print' );

function marbella_stylesheets_print() { ?>
<link href="<?php echo WPSIGHT_CHILD_URL; ?>/style-print.css" rel="stylesheet" type="text/css">
<?php
}


/**
 * Built footer bottom and add to
 * wpsight_footer_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_footer_after', 'marbella_do_footer_bottom', 5 );
 
function marbella_do_footer_bottom() {

	// Open layout wrap
	wpsight_layout_wrap( 'footer-bottom-wrap' ); ?>

	<div id="footer-bottom" class="clearfix">
			
		<div id="bottom-menu">
		
			<?php echo wpsight_menu( 'bottom' ); ?>
		
		</div><!-- #bottom-menu --><?php
	    
		// Loop through social icons
		
		$nr = apply_filters( 'wpsight_social_icons_nr', 5 );
		
		$social_icons = array();
		
		for( $i = 1; $i <= $nr; $i++ ) {				    
		    $social_icons[] = wpsight_get_social_icon( wpsight_get_option( 'icon_' . $i ) );				    
		}
		
		// Remove empty elements
		$social_icons = array_filter( $social_icons );
		
		$output = '<div class="social-icons">';
		
		if( ! empty( $social_icons ) ) {					
		    $i = 1;														
		    foreach( $social_icons as $k => $v ) {				
		        $social_link = wpsight_get_option( 'icon_' . $i . '_link' );				    	
		        $output .= '<a href="' . $social_link . '" target="_blank" title="' . $v['title'] . '" class="social-icon social-icon-' . $v['id'] . '"><img src="' . $v['icon'] . '" alt="" /></a>' . "\n";				    		
		        $i++;				    		
		    }				    
		} else {
		    $social_icon = wpsight_get_social_icon( 'rss' );
		    $output .= '<a href="' . get_bloginfo_rss( 'rss2_url' ) . '" target="_blank" title="' . $social_icon['title'] . '" class="social-icon social-icon-' . $social_icon['id'] . '"><img src="' . $social_icon['icon'] . '" alt="" /></a>' . "\n";
		}
		
		$output .= '</div><!-- .social-icons -->';
		
		echo apply_filters( 'wpsight_social_icons_top', $output ); ?>
		
		</div><!-- #footer-bottom --><?php
    
    // Close layout wrap	
	wpsight_layout_wrap( 'footer-bottom-wrap', 'close' );

}

add_action( 'admin_head', 'admin_css' );

function admin_css(){ ?>
     <style>
     #wpsight-options .section-info img { padding: 7px; background: #363c44 }
     </style>
<?php
}


/**
 * Register custom customizer color options
 *
 * @since 1.2
 */


add_action( 'customize_register', 'marbella_customize_register_color', 11 );

function marbella_customize_register_color( $wp_customize ) {
	
	// Add setting accent color
	
	$wp_customize->add_setting(
		'accent_color',
		array(
			'default' 		=> '#dd1a4b',
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
 
add_action( 'wp_head', 'marbella_do_theme_mods_css' );

function marbella_do_theme_mods_css() {

	$mods = '';
	
	// Get link color
	
	$accent_color  = wpsight_generate_css( 'a, a:visited, .listing-search-buttons div:hover, .wpsight-menu-bottom.wpsight-menu .sf-menu li li a:hover, #header-bottom .icon-phone, #header-bottom em', 'color', 'accent_color' );
	$accent_color .= wpsight_generate_css( '.title a:hover, .post-title a:hover, .listing-features a:hover, .wpsight-menu .sf-menu a:hover, .wpsight-menu .sf-menu li li a:hover', 'color', 'accent_color', false, ' !important' );
	$accent_color .= wpsight_generate_css( '.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled], .btn-primary:active, .btn-primary.active, .flex-direction-nav .flex-prev:hover, .flex-direction-nav .flex-next:hover, span.favorites-remove:hover', 'background-color', 'accent_color' );
	
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
 * Set exmaple content XML name
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_example_xml_name', 'marbella_example_xml_name' );

function marbella_example_xml_name() {
	return 'wpcasa';
}


/**
 * Create theme update object
 *
 * @since 1.1
 */
 
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-updates.php' );

add_filter( 'tuc_request_update_query_args-marbella', 'tuc_request_update_query_args_marbella' );

function tuc_request_update_query_args_marbella( $args ) {

	$args['theme'] = 'marbella';
	$args['token'] = wpsight_nonce( 86400, 'marbella' );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	'marbella',
	'http://update.wpcasa.com/api.php'
);
