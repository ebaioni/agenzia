<?php
/**
 * Main functions file
 *
 * @package wpSight
 * @subpackage Penthouse
 */
 
/**
 * Set layout to four columns
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_layout', 'penthouse_layout' );

function penthouse_layout() {
	return 'four';
}

/**
 * Set container around main and footer wrap
 *
 * @since 1.0
 */
 
add_action( 'wpsight_header_after', 'penthouse_header_after' );

function penthouse_header_after() {

	echo '<div id="container-wrap">';

}

add_action( 'wpsight_footer_after', 'penthouse_footer_after' );

function penthouse_footer_after() {

	echo '</div><!-- #container-wrap -->';

}
 
/**
 * Remove Google font droid serif
 * and add Oswald and Lora
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
 
add_filter( 'wpsight_custom_header_args', 'penthouse_custom_header_args', 100 );

function penthouse_custom_header_args( $args ) {
	
	$args['width'] 			 	= 100;
	$args['height'] 			= 400;
	$args['default-text-color'] = 'ffffff';
	$args['default-image'] 		= get_stylesheet_directory_uri() . '/images/header-image.jpg';
	$args['wp-head-callback'] 	= 'penthouse_header_style';
	
	return $args;
	
}

// gets included in the site header

function penthouse_header_style() {
	$header_image = get_header_image();	
	if( empty( $header_image ) )
		return;
	?>
<style type="text/css">
#outer {
    background: url(<?php header_image(); ?>) repeat-x center top;
}
#footer-bottom-wrap {
	background: url(<?php header_image(); ?>) repeat center top;
}
</style>
<?php }

/**
 * Add custom background theme support
 *
 * @since 1.1.1
 */
 
add_action( 'wpsight_setup', 'penthouse_custom_background_theme_support' );
 
function penthouse_custom_background_theme_support() {

	$args = array(
		'default-color' => 'eeeeee',
		'default-image' => false
	);
	
	$args = apply_filters( 'penthouse_custom_background_args', $args );	
	
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
}

/**
 * Customize menus
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_menus', 'penthouse_menus' );
 
function penthouse_menus( $menus ) {

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
 
add_action( 'wpsight_header_before', 'penthouse_do_top' );
 
function penthouse_do_top() {

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
 * Set button classes
 *
 * @since 1.1
 */
 
add_filter( 'wpsight_button_class_search', 'penthouse_button_class' );
add_filter( 'wpsight_button_class_agent', 'penthouse_button_class' );
add_filter( 'wpsight_button_class_contact', 'penthouse_button_class' );
add_filter( 'wpsight_button_class_calltoaction', 'penthouse_button_class' );

function penthouse_button_class( $class ) {

	$class = str_replace( 'btn-primary', '', $class );
	
	return $class . ' btn-success';

}

/**
 * Add Gravityforms button class
 */
 
remove_filter( 'gform_submit_button', 'wpsight_gform_submit_button', 10, 2 );
add_filter( 'gform_submit_button', 'penthouse_gform_submit_button', 10, 2 );

function penthouse_gform_submit_button( $button ) {

	return str_replace( 'class="', 'class="btn btn-success ', $button );

}

/**
 * Create more button
 *
 * @since 1.0
 */

add_filter( 'wpsight_excerpt_more', 'penthouse_excerpt_more' );

function penthouse_excerpt_more() {
	return '<div class="moretag-wrap"><a class="moretag btn btn-success" href="'. get_permalink( get_the_ID() ) . '">' . apply_filters( 'wpsight_more_text', __( 'Read more', 'wpsight' ) ) . '</a></div>';
}

/**
 * Limit image size on listings map
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_do_listing_image_size', 'penthouse_limit_image_size_map' );

function penthouse_limit_image_size_map( $image_size ) {

	if( is_page_template( 'page-tpl-map.php' ) )
		$image_size = 'post-thumbnail';
		
	return $image_size;

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
 
add_action( 'wpsight_footer_after', 'penthouse_do_footer_bottom', 5 );
 
function penthouse_do_footer_bottom() {

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
     #wpsight .section-info img { background: #202020 url(<?php header_image(); ?>) repeat }
     </style>
<?php
}

/**
 * Register custom customizer color options
 *
 * @since 1.2
 */

remove_action( 'customize_register', 'wpsight_customize_register_color' );
add_action( 'customize_register', 'penthouse_customize_register_color', 11 );

function penthouse_customize_register_color( $wp_customize ) {
	
	// Add setting link color
	
	$wp_customize->add_setting(
		'link_color',
		array(
			'default' 		=> '#5bb75b',
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
 
add_filter( 'wpsight_example_xml_name', 'penthouse_example_xml_name' );

function penthouse_example_xml_name() {
	return 'penthouse';
}

/**
 * Create theme update object
 *
 * @since 1.1
 */
 
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-updates.php' );

add_filter( 'tuc_request_update_query_args-penthouse', 'tuc_request_update_query_args_penthouse' );

function tuc_request_update_query_args_penthouse( $args ) {

	$args['theme'] = 'penthouse';
	$args['token'] = wpsight_nonce( 86400, 'penthouse' );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	'penthouse',
	'http://update.wpcasa.com/api.php'
);