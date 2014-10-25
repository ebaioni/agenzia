<?php
/**
 * Main functions file
 *
 * @package wpSight
 * @subpackage Paraíba
 */

/**
 * Remove Google font droid serif
 * and add Montserrat
 *
 * @since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'dequeue_wpsight_styles', 100 );

function dequeue_wpsight_styles() {
	wp_dequeue_style( 'droid-serif' );
	wp_enqueue_style( 'montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700', false, '1.0', 'all' );
}

 
/**
 * Set custom header $args
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_custom_header_args', 'paraiba_custom_header_args', 100 );

function paraiba_custom_header_args( $args ) {
	
	$args['width'] 			 	= 2000;
	$args['height'] 			= 1143;
	$args['flex-width'] 		= true;
	$args['flex-height'] 		= true;
	$args['default-text-color'] = 'ffffff';
	$args['default-image'] 		= get_stylesheet_directory_uri() . '/images/header-image.jpg';
	$args['wp-head-callback'] 	= 'paraiba_header_style';
	
	return $args;
	
}

// Create wp_head callback

function paraiba_header_style() {
	$header_image = get_header_image();	
	if( empty( $header_image ) )
		return;
	?>
<style type="text/css">
#container-wrap-header {
    background: url(<?php header_image(); ?>) no-repeat center;
    background-size: cover;
}
</style>
<?php }


/**
 * Add custom background theme support
 *
 * @since 1.1.1
 */
 
add_action( 'wpsight_setup', 'paraiba_custom_background_theme_support' );
 
function paraiba_custom_background_theme_support() {

	$args = array(
		'default-color' => 'eee',
		'default-image' => false
	);
	
	$args = apply_filters( 'paraiba_custom_background_args', $args );	
	
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
	remove_action( 'wp_head', 'wpsight_do_theme_mods_css' );
}


/**
 * Set container around top and header wrap
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_before', 'paraiba_header_before_header' );

function paraiba_header_before_header() {

	echo '<div id="container-wrap-header">';

}

add_action( 'wpsight_header_after', 'paraiba_header_after_header' );

function paraiba_header_after_header() {

	echo '</div><!-- #container-wrap-header -->';

}


/**
 * Set container around main and footer wrap
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_after', 'paraiba_header_after_main', 11 );

function paraiba_header_after_main() {

	echo '<div id="container-wrap-main">';

}

add_action( 'wpsight_footer_after', 'paraiba_footer_after_main', 4 );

function paraiba_footer_after_main() {

	echo '</div><!-- #container-wrap-main -->';

}


/**
 * Add print logo option
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_general', 'paraiba_options_general' );

function paraiba_options_general( $options ) {

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
 * Remove standard 'Show search on'
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_search', 'paraiba_options_search' );

function paraiba_options_search( $options ) {

	$options['search_show']['std'] = array(
		'search'  	=> '0',
		'archive' 	=> '0',
		'templates' => '0'
	);
	
	return $options;

}


/**
 * Set different default value
 * for header right in theme options
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_options_layout', 'paraiba_options_layout' );

function paraiba_options_layout( $options ) {

	$options['header_right']['std'] = '<div id="hero">' . __( 'Find Your <em>Dream</em> Home!', 'wpsight-paraiba' ) . '</div>' . "\n" . '[listing_search]';
	
	return $options;

}


/**
 * Add background color to social icons
 * on theme settings page
 *
 * @since 1.2
 */

add_action( 'admin_head', 'admin_css' );

function admin_css(){ ?>
<style>
	#wpsight-options .section-info img { padding: 5px; background: #292e34 }
</style>
<?php
}


/**
 * Customize menus
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_menus', 'paraiba_menus' );
 
function paraiba_menus( $menus ) {

	// Remove top left
	unset( $menus['top-left'] );
	
	// Add bottom menu
	$menus['bottom'] = __( 'Bottom Menu', 'wpsight' );
	
	return $menus;

}


/**
 * Built top bar with logo
 * and main menu
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_before', 'paraiba_do_top' );
 
function paraiba_do_top() {

	// Open layout wrap
	wpsight_layout_wrap( 'top-wrap' ); ?>

	<div id="top" class="row">
	
		<div id="top-logo" class="span4">
		
			<?php
    			// Action hook for logo output
    			do_action( 'wpsight_logo' );
    		?>
		
		</div><!-- #top-logo -->
	        		
		<div id="top-menu" class="span8">
		
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
 
add_filter( 'wpsight_do_print_logo_image', 'paraiba_do_print_logo_image' );

function paraiba_do_print_logo_image( $image ) {

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
 
add_filter( 'wpsight_get_logo', 'paraiba_do_logo_image', 10, 2 );

function paraiba_do_logo_image( $logo, $location ) {

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
add_filter( 'gform_submit_button', 'paraiba_gform_submit_button', 10, 2 );

function paraiba_gform_submit_button( $button ) {

	return str_replace( 'class="', 'class="btn btn-primary ', $button );

}


/**
 * Create more button
 *
 * @since 1.0
 */

add_filter( 'wpsight_excerpt_more', 'paraiba_excerpt_more' );

function paraiba_excerpt_more() {
	return '<div class="moretag-wrap"><a class="moretag btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">' . apply_filters( 'wpsight_more_text', __( 'Read more', 'wpsight' ) ) . '</a></div>';
}


/**
 * Set listing map icon
 *
 * @since 1.2
 */

add_filter( 'wpsight_map_listing_icon', 'paraiba_map_listing_icon', 11 );

function paraiba_map_listing_icon( $icon ) {

	$icon = WPSIGHT_CHILD_URL . '/images/map-listing.png';
	
	return $icon;

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
 * Built footer bottom and add to
 * wpsight_footer_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_footer_after', 'paraiba_do_footer_bottom', 5 );
 
function paraiba_do_footer_bottom() {

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


/**
 * Register custom customizer color options
 *
 * @since 1.2
 */


add_action( 'customize_register', 'paraiba_customize_register_color', 11 );

function paraiba_customize_register_color( $wp_customize ) {
	
	// Add setting link color
	
	$wp_customize->add_setting(
		'accent_color',
		array(
			'default' 		=> '#20b2b2',
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
 
add_action( 'wp_head', 'paraiba_do_theme_mods_css' );

function paraiba_do_theme_mods_css() {

	$mods = '';
	
	// Get link color
	
	$link_color = wpsight_generate_css( 'a, a:visited, .listing-search-buttons div:hover, #hero em, #hero a, #hero a:hover, #hero a:visited, .wpsight-menu-bottom.wpsight-menu .sf-menu li li a:hover', 'color', 'accent_color' );
	$link_color .= wpsight_generate_css( '.title a:hover, .post-title a:hover, .listing-features a:hover, .wpsight-menu .sf-menu a:hover, .wpsight-menu .sf-menu li li a:hover', 'color', 'accent_color', false, ' !important' );
	$link_color .= wpsight_generate_css( '.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled], .btn-primary:active, .btn-primary.active, .flex-direction-nav .flex-prev:hover, .flex-direction-nav .flex-next:hover, span.favorites-remove:hover', 'background-color', 'accent_color' );
	
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
 * Set exmaple content XML name
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_example_xml_name', 'paraiba_example_xml_name' );

function paraiba_example_xml_name() {
	return 'paraiba';
}

/**
 * Create theme update object
 *
 * @since 1.1
 */
 
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-updates.php' );

add_filter( 'tuc_request_update_query_args-paraiba', 'tuc_request_update_query_args_paraiba' );

function tuc_request_update_query_args_paraiba( $args ) {

	$args['theme'] = 'paraiba';
	$args['token'] = wpsight_nonce( 86400, 'paraiba' );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	'paraiba',
	'http://update.wpcasa.com/api.php'
);
