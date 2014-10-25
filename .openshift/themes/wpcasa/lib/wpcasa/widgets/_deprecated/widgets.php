<?php

/**
 * If old wpCasa widgets were activated,
 * use them instead of using wpSight widgets.
 *
 * @package wpSight
 */
 
/**
 * Use old wpCasa widgets if
 * they were activated
 *
 * @since 1.2
 */
 
// add_action( 'wpsight_init', 'wpcasa_widgets_deprecated', 11 );
 
function wpcasa_widgets_deprecated() {

	$wpcasa_widgets = apply_filters( 'wpsight_wpcasa_widgets', true );

	if( WPSIGHT_NAME != 'wpCasa' || $wpcasa_widgets === false )
		return;

	foreach( wpsight_widgets() as $k => $v ) {
	
		// Convert to old wpCasa names
		
		$wid = str_replace( 'listing', 'property', str_replace( 'listings', 'properties', str_replace( 'wpsight', 'wpcasa', strtolower( $v['wid'] ) ) ) );
		$tpl = str_replace( 'listing', 'property', str_replace( 'listings', 'properties', strtolower( $v['tpl'] ) ) );
		
		// Set new file path
		$widget_file = str_replace( '/lib/widgets/', '/widgets/_deprecated/', $tpl );
		
		// Check if widget was activated
		
		$widget_option = get_option( 'widget_' . $wid );
		
		if( is_array( $widget_option ) )
			require_once( WPSIGHT_WPCASA_DIR . $widget_file );
	
	} // endforeach
	
}

/**
 * Backwards compatiblity for
 * wpcasa_dashes()
 *
 * @since 1.2
 */
 
function wpcasa_dashes( $id ) {
	wpsight_dashes( $id );
}