<?php
/**
 * Ensure backwards compatibility
 *
 * @package wpSight
 */

/**
 * Match wpCasa theme constants
 *
 * @since 1.2
 */

add_action( 'wpsight_init', 'wpcasa_constants', 11 );
 
function wpcasa_constants() {

	// General theme constants
	
	define( 'WPCASA_NAME', WPSIGHT_NAME );
	define( 'WPCASA_DOMAIN', WPSIGHT_DOMAIN );
	define( 'WPCASA_VERSION', WPSIGHT_VERSION );
	
	// Layout can be four or three columns

	define( 'WPCASA_LAYOUT', WPSIGHT_LAYOUT );
	
	// Location constants (paths)
	
	define( 'WPCASA_DIR', WPSIGHT_DIR );
	define( 'WPCASA_CHILD_DIR', WPSIGHT_CHILD_DIR );
	
	define( 'WPCASA_LIB_DIR', WPSIGHT_LIB_DIR );
	define( 'WPCASA_ADMIN_DIR', WPSIGHT_ADMIN_DIR );
	define( 'WPCASA_FRAMEWORK_DIR', WPSIGHT_FRAMEWORK_DIR );
	define( 'WPCASA_SHORTCODES_DIR', WPSIGHT_SHORTCODES_DIR );
	define( 'WPCASA_CLASSES_DIR', WPSIGHT_CLASSES_DIR );
	define( 'WPCASA_FUNCTIONS_DIR', WPSIGHT_FUNCTIONS_DIR );
	define( 'WPCASA_WIDGETS_DIR', WPSIGHT_WIDGETS_DIR );

	// Location constants (URLs)
	
	define( 'WPCASA_URL', WPSIGHT_URL );
	define( 'WPCASA_CHILD_URL', WPSIGHT_CHILD_URL );
	
	define( 'WPCASA_LIB_URL', WPSIGHT_LIB_URL );
	define( 'WPCASA_ASSETS_URL', WPSIGHT_ASSETS_URL );
	define( 'WPCASA_ASSETS_IMG_URL', WPSIGHT_ASSETS_IMG_URL );
	define( 'WPCASA_ASSETS_JS_URL', WPSIGHT_ASSETS_JS_URL );
	define( 'WPCASA_ASSETS_CSS_URL', WPSIGHT_ASSETS_CSS_URL );
	define( 'WPCASA_JS_URL', WPSIGHT_JS_URL );
	define( 'WPCASA_ADMIN_URL', WPSIGHT_ADMIN_URL );
	define( 'WPCASA_ADMIN_IMG_URL', WPSIGHT_ADMIN_IMG_URL );
	
	define( 'WPCASA_IMAGES', WPSIGHT_IMAGES );
	define( 'WPCASA_ICONS', WPSIGHT_ICONS );
	
	define( 'WPCASA_OPTIONS_DIR', WPSIGHT_OPTIONS_DIR );
	
	// Cookie constants
	
	define( 'WPCASA_COOKIE_FAVORITES', WPSIGHT_COOKIE_FAVORITES );
	define( 'WPCASA_COOKIE_FAVORITES_COMPARE', WPSIGHT_COOKIE_FAVORITES_COMPARE );
	define( 'WPCASA_COOKIE_SEARCH_ADVANCED', WPSIGHT_COOKIE_SEARCH_ADVANCED );
	define( 'WPCASA_COOKIE_SEARCH_QUERY', WPSIGHT_COOKIE_SEARCH_QUERY );
	define( 'WPCASA_COOKIE_SEARCH_MAP', WPSIGHT_COOKIE_SEARCH_MAP );
	
	// Define paths for meta box plugin
	
	define( 'WPCASA_METABOX_URL', WPSIGHT_METABOX_URL );
	define( 'WPCASA_METABOX_DIR', WPSIGHT_METABOX_DIR );

}

/**
 * Match wpCasa functions
 *
 * @since 1.2
 */

function wpcasa_get_option( $name, $default = false ) {	
    return wpsight_get_option( $name, $default );
}

function wpcasa_standard_details() {	
    return wpsight_standard_details();
}

function wpcasa_get_measurement_units( $unit ) {	
    return wpsight_get_measurement_units( $unit );
}

function wpcasa_get_property_id( $id ) {
	wpsight_get_listing_id( $id );
}