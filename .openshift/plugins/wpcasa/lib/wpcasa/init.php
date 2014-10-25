<?php
/**
 * Add wpCasa-specific features
 *
 * @package wpSight
 */
 
// wpsight_wpcasa_pre hook
do_action( 'wpsight_wpcasa_pre' );

/**
 * Define wpCasa theme constants
 *
 * @since 1.0
 */

add_action( 'wpsight_init', 'wpsight_wpcasa_constants', 9 );
 
function wpsight_wpcasa_constants() {
	
	// Location constants (paths)	
	define( 'WPSIGHT_WPCASA_DIR', WPSIGHT_LIB_DIR . '/wpcasa' );

}

/**
 * Load all the framework files and features
 *
 * @since 1.0
 */
 
add_action( 'wpsight_init', 'wpsight_wpcasa_load_framework', 9 );

function wpsight_wpcasa_load_framework() {

	// wpsight_pre_framework hook
	do_action( 'wpsight_wpcasa_pre_framework' );
	
	// Load wpCasa filters

	require_once( WPSIGHT_WPCASA_DIR . '/filters/filters.php' );
	require_once( WPSIGHT_WPCASA_DIR . '/filters/_deprecated.php' );
	
	// Load wpCasa actions
	
	require_once( WPSIGHT_WPCASA_DIR . '/actions/actions.php' );
	require_once( WPSIGHT_WPCASA_DIR . '/actions/_deprecated.php' );
	
	// Load widget actions and filters

	require_once( WPSIGHT_WPCASA_DIR . '/widgets/actions.php' );
	require_once( WPSIGHT_WPCASA_DIR . '/widgets/filters.php' );
	
	// Load property shortcodes
	
	require_once( WPSIGHT_WPCASA_DIR . '/shortcodes/properties.php' );
	
	// Load _deprecated file
	
	require_once( WPSIGHT_WPCASA_DIR . '/_deprecated.php' );
	
}
