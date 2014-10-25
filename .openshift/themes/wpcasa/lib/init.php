<?php

/**
 * Add theme features, define constants and load framework
 *
 * @package wpSight
 */

// wpsight_pre hook
do_action( 'wpsight_pre' );

/**
 * Define wpSight theme constants
 *
 * @since 1.0
 */

add_action( 'wpsight_init', 'wpsight_constants' );

function wpsight_constants() {

	// General theme constants
	
	define( 'WPSIGHT_NAME', 'wpCasa' );
	define( 'WPSIGHT_DOMAIN', 'wpcasa' );
	define( 'WPSIGHT_VERSION', '1.3.6' );
	
	// Layout can be four or three columns

	define( 'WPSIGHT_LAYOUT', apply_filters( 'wpsight_layout', 'three' ) );
	
	// Location constants (paths)
	
	define( 'WPSIGHT_DIR', get_template_directory() );
	define( 'WPSIGHT_CHILD_DIR', get_stylesheet_directory() );
	
	define( 'WPSIGHT_LIB_DIR', WPSIGHT_DIR . '/lib' );
	define( 'WPSIGHT_ADMIN_DIR', WPSIGHT_LIB_DIR . '/admin' );
	define( 'WPSIGHT_FRAMEWORK_DIR', WPSIGHT_LIB_DIR . '/framework' );
	define( 'WPSIGHT_SHORTCODES_DIR', WPSIGHT_LIB_DIR . '/shortcodes' );
	define( 'WPSIGHT_CLASSES_DIR', WPSIGHT_LIB_DIR . '/classes' );
	define( 'WPSIGHT_FUNCTIONS_DIR', WPSIGHT_LIB_DIR . '/functions' );
	define( 'WPSIGHT_WIDGETS_DIR', WPSIGHT_LIB_DIR . '/widgets' );

	// Location constants (URLs)
	
	define( 'WPSIGHT_URL', get_template_directory_uri() );
	define( 'WPSIGHT_CHILD_URL', get_stylesheet_directory_uri() );
	
	define( 'WPSIGHT_LIB_URL', WPSIGHT_URL . '/lib' );
	define( 'WPSIGHT_ASSETS_URL', WPSIGHT_LIB_URL . '/assets' );
	define( 'WPSIGHT_ASSETS_IMG_URL', WPSIGHT_ASSETS_URL . '/img' );
	define( 'WPSIGHT_ASSETS_JS_URL', WPSIGHT_ASSETS_URL . '/js' );
	define( 'WPSIGHT_ASSETS_CSS_URL', WPSIGHT_ASSETS_URL . '/css' );
	define( 'WPSIGHT_JS_URL', WPSIGHT_LIB_URL . '/js' );
	define( 'WPSIGHT_ADMIN_URL', WPSIGHT_LIB_URL . '/admin' );
	define( 'WPSIGHT_ADMIN_IMG_URL', WPSIGHT_ADMIN_URL . '/img' );
	
	define( 'WPSIGHT_IMAGES', WPSIGHT_CHILD_URL . '/images' );
	define( 'WPSIGHT_ICONS', WPSIGHT_IMAGES . '/icons' );
	
	define( 'WPSIGHT_OPTIONS_DIR', WPSIGHT_ADMIN_URL . '/' );
	
	// Cookie constants
	
	define( 'WPSIGHT_COOKIE_FAVORITES', WPSIGHT_DOMAIN . '_favorites' );
	define( 'WPSIGHT_COOKIE_FAVORITES_COMPARE', WPSIGHT_DOMAIN . '_favorites_compare' );
	define( 'WPSIGHT_COOKIE_SEARCH_ADVANCED', WPSIGHT_DOMAIN . '_advanced_search' );
	define( 'WPSIGHT_COOKIE_SEARCH_QUERY', WPSIGHT_DOMAIN . '_search_query' );
	define( 'WPSIGHT_COOKIE_SEARCH_MAP', WPSIGHT_DOMAIN . '_search_map' );
	
	// Define paths for meta box plugin
	
	define( 'WPSIGHT_METABOX_URL', WPSIGHT_ADMIN_URL . '/meta-box' );
	define( 'WPSIGHT_METABOX_DIR', WPSIGHT_ADMIN_DIR . '/meta-box' );

}

/**
 * Load all the framework files and features
 *
 * @since 1.0
 */
 
add_action( 'wpsight_init', 'wpsight_load_framework' );

function wpsight_load_framework() {

	// wpsight_pre_framework hook
	do_action( 'wpsight_pre_framework' );
	
	// Load framework files
	require_once( WPSIGHT_LIB_DIR . '/' . WPSIGHT_DOMAIN . '/init.php' );
	
	// Load theme options framework
	require_once( WPSIGHT_LIB_DIR . '/admin/options/options-framework.php' );

	// Load meta boxes framework
	require_once( WPSIGHT_LIB_DIR . '/admin/meta-box/meta-box.php' );
	
	// Load theme customizer class	
	require_once( WPSIGHT_LIB_DIR . '/admin/customizer.php' );
	
	// Load theme update class	
	require_once( WPSIGHT_LIB_DIR . '/admin/theme-updates.php' );
	
	// Load profile image class	
	require_once( WPSIGHT_LIB_DIR . '/admin/profile-image.php' );
	
	// Load general functions
	
	require_once( WPSIGHT_LIB_DIR . '/functions/general.php' );
	require_once( WPSIGHT_LIB_DIR . '/functions/menus.php' );
	require_once( WPSIGHT_LIB_DIR . '/functions/helpers.php' );
	
	// Load listing functions

	require_once( WPSIGHT_LIB_DIR . '/functions/listings.php' );
	require_once( WPSIGHT_LIB_DIR . '/functions/search.php' );
	require_once( WPSIGHT_LIB_DIR . '/functions/contact.php' );
	require_once( WPSIGHT_LIB_DIR . '/functions/queries.php' );

	// Load framework
	
	require_once( WPSIGHT_LIB_DIR . '/framework/header.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/main.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/post.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/listings.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/search.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/contact.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/agents.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/roles.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/comments.php' );
	require_once( WPSIGHT_LIB_DIR . '/framework/footer.php' );
	
	// Load post types
	require_once( WPSIGHT_LIB_DIR . '/framework/post-types.php' );
	
	// Load taxonomies
	require_once( WPSIGHT_LIB_DIR . '/framework/taxonomies.php' );
	
	// Load meta boxes
	require_once( WPSIGHT_LIB_DIR . '/admin/meta-boxes.php' );
	
	// Load shortcodes

	require_once( WPSIGHT_LIB_DIR . '/shortcodes/general.php' );
	require_once( WPSIGHT_LIB_DIR . '/shortcodes/post.php' );
	require_once( WPSIGHT_LIB_DIR . '/shortcodes/footer.php' );
	require_once( WPSIGHT_LIB_DIR . '/shortcodes/listings.php' );
	
	// Load widgets	
	require_once( WPSIGHT_LIB_DIR . '/widgets/widgets.php' );
	
	// Load captcha
	require_once( WPSIGHT_LIB_DIR . '/admin/captcha/securimage.php' );
	
}

// wpsight_init hook
do_action( 'wpsight_init' );

// wpsight_setup hook
do_action( 'wpsight_setup' );

/**
 * Set content width for embeds
 *
 * @since 1.0
 */

if ( ! isset( $content_width ) ) 
    $content_width = apply_filters( 'wpsight_content_width', 640 );
