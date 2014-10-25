<?php

/**
 * Apply filter hooks for
 * wpCasa-specific widgets
 *
 * @package wpSight
 */
 
/**
 * Add wpCasa-specific widget areas
 * to main widget areas array
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_areas', 'wpsight_wpcasa_widget_areas', 9 );

function wpsight_wpcasa_widget_areas( $areas ) {

	// Unset general widget areas
	
	unset( $areas['listing'] );
	unset( $areas['sidebar-listing'] );
	unset( $areas['sidebar-listing-archive'] );

	// Add property widget areas
	
	$wpcasa_widget_areas = array(
	
		'property' => array(
			'name' 			=> __( 'Listing Single Content', 'wpsight' ),
			'description' 	=> __( 'Main content on single listing pages', 'wpsight' ),
			'id' 			=> 'property',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h3 class="title">',
			'after_title' 	=> '</h3>',
			'position'		=> 85
		),
		
		'sidebar-property' => array(
			'name' 			=> __( 'Listing Single Sidebar', 'wpsight' ),
			'description'	=> __( 'Sidebar on single listing pages', 'wpsight' ),
			'id' 			=> 'sidebar-property',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 86
		),
		
		'sidebar-property-archive' => array(
			'name' 			=> __( 'Listing Archive Sidebar', 'wpsight' ),
			'description' 	=> __( 'Sidebar on listing archive pages', 'wpsight' ),
			'id' 			=> 'sidebar-property-archive',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 87
		)
	
	);
	
	// Merge arrays
	$wpcasa_widget_areas = array_merge( $areas, $wpcasa_widget_areas );
	
	// Sort array by position        
    $wpcasa_widget_areas = wpsight_sort_array_by_position( $wpcasa_widget_areas );
	
	return apply_filters( 'wpsight_wpcasa_widget_areas', $wpcasa_widget_areas );

}

/**
 * Set post type for
 * latest listings widget
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listings_latest_query_args', 'wpsight_wpcasa_widget_listings_latest_query_args' );

function wpsight_wpcasa_widget_listings_latest_query_args( $args ) {
	$args['post_type'] = 'property';	
	return $args;
}
