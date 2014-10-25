<?php

/**
 * Built custom menus
 *
 * @package wpSight
 *
 */
 
/**
 * Create menus array
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_menus' ) ) {

	function wpsight_menus() {
	
		$wpsight_menus = array(		
			'top-left' => __( 'Top Left Menu', 'wpsight' ),
			'main' 	   => __( 'Main Menu', 'wpsight' ),
			'sub'      => __( 'Sub Menu', 'wpsight' )
		);
		
		return apply_filters( 'wpsight_menus', $wpsight_menus );
	
	}

}
 
/**
 * Register custom menus
 *
 * @since 1.0
 */
 
add_action( 'wpsight_setup', 'wpsight_register_menus' );

function wpsight_register_menus() {

	foreach( wpsight_menus() as $menu => $label ) {
	
		register_nav_menu( 'menu-' . $menu, $label );	
	
	}

}

/**
 * Add option home to menu items
 *
 * @since 1.0
 */
 
add_filter( 'wp_page_menu_args', 'home_page_menu_item' );

function home_page_menu_item( $args ) {

	$args['show_home'] = true;
	
	return $args;
	
}

/**
 * Create menu with optional fallback
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_menu' ) ) {

	function wpsight_menu( $menu_location, $menu_default = false ) {
	
		// Stop if no menu location
	
		if( empty( $menu_location ) )
			return false;

		$wpsight_menu = '';
		
		// If menu location exists
			
		if( has_nav_menu( 'menu-' . $menu_location ) ) {
		
			// Check if transients are active
			$transients = apply_filters( 'wpsight_transients_menus', false, $menu_location );
					
			// If menu transients are active
			
			if( $transients === true ) {
					
				// If transient does not exist
				
				if ( false === ( $menu_query = get_transient( 'wpsight_menu_' . wpsight_underscores( $menu_location ) ) ) ) {
					
					// Create custom menu
						
					if( has_nav_menu( 'menu-' . $menu_location ) ) {
					
						// Build menu query
				
				 		$menu_query = wp_nav_menu( array(
				 			'sort_column' 	  => 'menu_order',
				 			'container_class' => 'wpsight-menu wpsight-menu-' . $menu_location,
				 			'menu_class' 	  => 'sf-menu',
				 			'theme_location'  => 'menu-' . $menu_location,
				 			'echo' 			  => false
				 		) );
				 		
				 		// Set transient for this menu				
						set_transient( 'wpsight_menu_' . wpsight_underscores( $menu_location ), $menu_query, DAY_IN_SECONDS );
				
					}
				    
				}

			// If menu transients are not active
			
			} else {
			
				// Build menu query
			
				$menu_query = wp_nav_menu( array(
				    'sort_column' 	  => 'menu_order',
				    'container_class' => 'wpsight-menu wpsight-menu-' . $menu_location,
				    'menu_class' 	  => 'sf-menu',
				    'theme_location'  => 'menu-' . $menu_location,
				    'echo' 			  => false
				) );		
			
			}
			
			$wpsight_menu = $menu_query;
		
		} // endif has_nav_menu()
		
		// Show link to custom menus admin page if default true
		
		if( ! has_nav_menu( 'menu-' . $menu_location ) && $menu_default === true ) {
		
			$wpsight_menu = '<div class="wpsight-menu wpsight-menu-' . $menu_location . '"><ul class="sf-menu">';
			$wpsight_menu .= '<li class="current-menu-item"><a href="' . home_url() . '/wp-admin/nav-menus.php">' . __( 'Create a custom menu', 'wpsight' ) . ' &rarr;</a></li>';
			$wpsight_menu .= '</ul></div>';
			
		}
		
		if( ! empty( $wpsight_menu ) )	
			return $wpsight_menu;
			
	}

}


/**
 * Delete menu transients
 *
 * @since 1.3.1.1
 */

add_action( 'wp_update_nav_menu',  'wpsight_transients_delete_menus' );

function wpsight_transients_delete_menus() {

	$menu_locations = get_nav_menu_locations();
	
	if( empty( $menu_locations ) )
		return false;
		
	foreach( $menu_locations as $location => $v )
		delete_transient( 'wpsight_' . wpsight_underscores( $location ) );
    
}
