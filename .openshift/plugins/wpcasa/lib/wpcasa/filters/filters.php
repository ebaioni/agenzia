<?php
/**
 * Add wpCasa-specific filters
 *
 * @package wpSight
 */
 
/**
 * Set wpCasa post type 'property'
 * instead of 'listing'
 *
 * @since 1.2
 */
 
add_action( 'wpsight_setup', 'wpsight_set_listing_post_type' );

function wpsight_set_listing_post_type() {
	add_filter( 'wpsight_listing_post_type', 'wpsight_wpcasa_listing_post_type' );
}

function wpsight_wpcasa_listing_post_type() {
	return 'property';
}

/**
 * Create standard features array
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_standard_details', 'wpsight_wpcasa_standard_details', 11 );
 
function wpsight_wpcasa_standard_details() {

	// Set standard details

	$standard_details = array(
	
    	'details_1' => array(
    		'id' 		  => 'details_1',
    		'label'		  => __( 'Bedrooms', 'wpsight' ),
    		'unit'		  => '',
    		'data' 		  => array( '' => __( 'n/d', 'wpsight' ), '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ),
    		'description' => '',
    		'position'	  => 10
    	),
    	'details_2'	=> array(
    		'id' 		  => 'details_2',
    		'label'		  => __( 'Bathrooms', 'wpsight' ),
    		'unit'		  => '',
    		'data' 		  => array( '' => __( 'n/d', 'wpsight' ), '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ),
    		'description' => '',
    		'position'	  => 20
    	),
    	'details_3' => array(
    		'id' 		  => 'details_3',
    		'label'		  => __( 'Plot Size', 'wpsight' ),
    		'unit'		  => 'm2',
    		'data'		  => false,
    		'description' => '',
    		'position'	  => 30
    	),
    	'details_4' => array(
    		'id' 		  => 'details_4',
    		'label'		  => __( 'Living Area', 'wpsight' ),
    		'unit'		  => 'm2',
    		'data'		  => false,
    		'description' => '',
    		'position'	  => 40
    	),
    	'details_5' => array(
    		'id' 		  => 'details_5',
    		'label'		  => __( 'Terrace', 'wpsight' ),
    		'unit'		  => 'm2',
    		'data'		  => false,
    		'description' => '',
    		'position'	  => 50
    	),
    	'details_6' => array(	
    		'id' 		  => 'details_6',
    		'label'		  => __( 'Parking', 'wpsight' ),
    		'unit'		  => '',
    		'data'		  => false,
    		'description' => '',
    		'position'	  => 60
    	),
    	'details_7' => array(
    		'id' 		  => 'details_7',
    		'label'		  => __( 'Heating', 'wpsight' ),
    		'unit'		  => '',
    		'data'		  => false,
    		'description' => '',
    		'position'	  => 70
    	),
    	'details_8' => array(
    		'id' 		  => 'details_8',
    		'label'		  => __( 'Built in', 'wpsight' ),
    		'unit'		  => '',
    		'data'		  => false,
    		'description' => '',
    		'position'	  => 80
    	)
    	
    );
    
    // Apply filter to array    
    $standard_details = apply_filters( 'wpsight_wpcasa_standard_details', $standard_details );
    
    // Sort array by position        
    $standard_details = wpsight_sort_array_by_position( $standard_details );
	
	// Return array    
    return $standard_details;

}

/**
 * Create search form details
 *
 * @since 1.0
 */
 
add_filter( 'wpsight_search_form_details', 'wpsight_wpcasa_search_form_details', 9 );
 
function wpsight_wpcasa_search_form_details( $details ) {

	// Reset general listing type
	unset( $details['listing-type'] );
	
	// Add property type
	
	$details['property-type'] = array(
	    'label'			=> __( 'Type', 'wpsight' ),
	    'taxonomy'		=> 'property-type',
	    'data' 			=> array(
		    'dropdown' => true
		),
	    'type' 			=> 'taxonomy',
	    'data_compare' 	=> false,
	    'data_type' 	=> false,
	    'default'		=> false,
	    'advanced'		=> false,
	    'position'		=> 30
	);
	
	// Get standard details
	$standard_details = wpsight_standard_details();
	
	// Set standard details IDs
	
	$standard_details_1 = $standard_details['details_1']['id'];
	$standard_details_2 = $standard_details['details_2']['id'];
	
	$details[$standard_details_1] = array(
		'label' 		=> $standard_details['details_1']['label'],
		'data'  		=> $standard_details['details_1']['data'],
		'key'			=> '_details_1',
		'type'  		=> 'select',
		'data_compare' 	=> '>=',
		'data_type' 	=> 'numeric',
		'default'		=> false,
		'advanced'		=> false,
    	'position'		=> 40
	);
	
	$details[$standard_details_2] = array(
		'label' 		=> $standard_details['details_2']['label'],
		'data'  		=> $standard_details['details_2']['data'],
		'key'			=> '_details_2',
		'type'  		=> 'select',
		'data_compare' 	=> '>=',
		'data_type' 	=> 'numeric',
		'default'		=> false,
		'advanced'		=> false,
    	'position'		=> 50
	);
	
	// Apply filter to array    
    $details = apply_filters( 'wpsight_wpcasa_search_form_details', $details );
    
    // Sort array by position        
    $details = wpsight_sort_array_by_position( $details );
	
	// Return array    
    return $details;
	
	

}

/**
 * Single template redirect for property
 * post type (=> single-listing.php)
 *
 * @since 1.2
 */

add_filter( 'template_include', 'wpsight_wpcasa_redirect_single' );

function wpsight_wpcasa_redirect_single( $template ) {

	if( is_singular() && get_post_type() == 'property' )
		return WPSIGHT_DIR . '/single-listing.php';
		
	return $template;
}

/**
 * Page template redirect for latest
 * properties (=> page-tpl-listings.php)
 *
 * @since 1.2
 */

add_filter( 'page_template', 'wpsight_wpcasa_page_template_properties' );

function wpsight_wpcasa_page_template_properties( $page_template ) {
	
	$template = get_post_meta( get_the_ID(), '_wp_page_template' );

    if ( $template[0] == 'page-tpl-properties.php' )
        return WPSIGHT_DIR . '/page-tpl-listings.php';
        
    return $page_template;
}

/**
 * Set default text in keyword
 * search text input field
 *
 * @since 1.2
 */

add_filter( 'wpsight_listing_search_labels', 'wpsight_wpcasa_listing_search_labels' );

function wpsight_wpcasa_listing_search_labels( $labels ) {

	$labels['default'] = __( 'Keyword or Property ID', 'wpsight' ) . '&hellip;';
	
	return $labels;

}

/**
 * Set sold/rented text in
 * price meta box
 *
 * @since 1.2
 */

add_filter( 'wpsight_listing_price_labels', 'wpsight_wpcasa_listing_price_labels' );

function wpsight_wpcasa_listing_price_labels( $labels ) {

	$labels['not_available'] = __( 'Property is sold or rented', 'wpsight' );
	
	return $labels;

}

/**
 * Set property map icon
 *
 * @since 1.2
 */

add_filter( 'wpsight_map_listing_icon', 'wpsight_wpcasa_map_listing_icon' );

function wpsight_wpcasa_map_listing_icon( $icon ) {

	$icon = WPSIGHT_ASSETS_IMG_URL . '/map-property.png';
	
	return $icon;

}