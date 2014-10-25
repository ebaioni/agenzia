<?php
/**
 * Place listing search on archive pages
 *
 * @since 1.0
 */

add_action( 'wpsight_main_before', 'wpsight_place_listing_search' );

function wpsight_place_listing_search() {

	$search_show = wpsight_get_option( 'search_show', false );
	
	if( $search_show['search'] && is_search() && ! isset( $_GET['stype'] ) ) {
		$show = true;
	} elseif( $search_show['archive'] && ( is_tax( 'location' ) || is_tax( 'feature' ) || is_tax( 'listing-type' ) || is_tax( 'listing-category' ) || is_tax( 'property-category' ) || is_tax( 'property-category' ) ) ) {
		$show = true;
	} elseif( $search_show['templates'] && ( is_page_template( 'page-tpl-listings.php' ) || is_page_template( 'page-tpl-properties.php' ) ) ) {
		$show = true;
	} elseif( $search_show['author'] && is_author() ) {
		$show = true;
	} else {
		$show = false;
	}
	
	$show = apply_filters( 'wpsight_place_listing_search', $show );
	
	if( $show == true )
		wpsight_do_listing_search();

}

/**
 * Built the listing search form
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listings_search', 'wpsight_do_listing_search' );

function wpsight_do_listing_search() {

	echo apply_filters( 'wpsight_do_listing_search', wpsight_get_listing_search() );

}

function wpsight_get_listing_search() {

	// Get search form details
    
    $search_details = wpsight_get_option( 'search_details', true );
    
    // Check how many detail options are active
    
    $search_details_count = false;
    
    if( is_array( $search_details ) ) {
    	$search_details_tmp   = array_filter( $search_details );
    	$search_details_count = count( $search_details_tmp );
    }
    
    // Get advanced search options

	$advanced 		  = wpsight_get_option( 'search_advanced' );
	$advanced_options = wpsight_get_option( 'search_advanced_options' );
    
    // Search form labels
    
    $search_labels = array(
    	'default'   => __( 'Keyword or Listing ID', 'wpsight' ) . '&hellip;',
    	'submit'    => __( 'Search', 'wpsight' ),
    	'advanced'  => __( 'Advanced Search', 'wpsight' ),
    	'reset'  	=> __( 'Reset', 'wpsight' ),
    	'price' 	=> __( 'Price', 'wpsight' ),
    	'price_min' => __( 'Price (min)', 'wpsight' ),
    	'price_max' => __( 'Price (max)', 'wpsight' ),
    	'orderby' 	=> __( 'Orderby', 'wpsight' ),
    	'order' 	=> __( 'Order', 'wpsight' ),
    	'desc' 		=> __( 'descending', 'wpsight' ),
    	'asc' 		=> __( 'ascending', 'wpsight' ),
    	'results' 	=> __( 'Results', 'wpsight' )
    );
    
    $search_labels = apply_filters( 'wpsight_listing_search_labels', $search_labels );
    	
	$listing_search = '<div class="listing-search count-' . $search_details_count . ' clearfix clear">';
	    	
	/**
	 * Get current query
	 */
	
	$search_get_query = false;
	
	// Get query cookie
	$search_cookie = apply_filters( 'wpsight_search_cookie', true );
	
	// Set query get
	$search_get = apply_filters( 'wpsight_search_get', true );
	
	if( ! isset( $_GET['s'] ) && isset( $_COOKIE[WPSIGHT_COOKIE_SEARCH_QUERY] ) && $search_cookie == true ) {
	    
	    // When not search and cookie exists set last query	    		
	    $search_get_query = wpsight_explode_array( ',', $_COOKIE[WPSIGHT_COOKIE_SEARCH_QUERY] );
	    
	} elseif( $search_get == true ) {
	    foreach( $_GET as $get => $get_v ) {
	        $search_get_query[ $get ] = $get_v;
	    }		    	
	}
	
	$listing_search .= '<form method="get" action="' . apply_filters( 'wpsight_do_listing_search_form_action', home_url( '/' ) ) . '">';
	$listing_search .= '<div class="form-inner">';
	
	// Text field and search button
	
	$search_get_query['s'] = isset( $search_get_query['s'] ) ? $search_get_query['s'] : false;
	
	$listing_search .= '<div class="listing-search-main">' . "\n";
	
	$listing_search .= '<input type="text" class="listing-search-text text" name="s" title="' . $search_labels['default'] . '" value="' . $search_get_query['s'] . '" />' . "\n";
	$listing_search .= '<input type="submit" class="' . apply_filters( 'wpsight_button_class_search', 'listing-search-submit btn btn-large btn-primary' ) . '" name="search-submit" value="' . $search_labels['submit'] . '" />' . "\n";
	$listing_search .= '</div><!-- .listing-search-main -->' . "\n\n";
	
	// Check if there are detail options
	
	if( ! empty( $search_details_tmp ) ) {
	
	    // Details select drop downs
	    
	    $listing_search .= '<div class="listing-search-details">' . "\n";
	    
	    	// Loop through search form fields	    			
	    	$listing_search .= wpsight_search_form_fields( wpsight_search_form_details(), $search_details, $search_get_query );
	    
	    $listing_search .= '</div><!-- .listing-search-details -->' . "\n\n";
	
	}
	
	if( $advanced ) {
	
	    // Advanced Search
	    
	    $listing_search .= '<div class="listing-search-advanced ' . apply_filters( 'wpsight_listing_search_status', '' ) . '">' . "\n";
	    
	    	// Loop through search form fields (advanced)	    			
	    	$listing_search .= wpsight_search_form_fields( wpsight_search_form_details(), $advanced_options, $search_get_query, true );
	
	    	// Add search form filters
	    	$listing_search .= wpsight_search_form_filters( wpsight_search_form_details(), $advanced_options, $search_get_query, true );
	    			
	    $listing_search .= '</div><!-- .listing-search-advanced -->' . "\n\n";
	    
	    // Advanced search button
	    $advanced_search_button = '<div class="listing-search-advanced-button ' . apply_filters( 'wpsight_listing_search_status', '' ) . '">' . $search_labels['advanced'] . '</div>' . "\n";
	
	}
	
	// Advanced search and reset button
	
	$listing_search .= '<div class="listing-search-buttons">' . "\n";
	
	if( isset( $_COOKIE[WPSIGHT_COOKIE_SEARCH_QUERY] ) && ( $search_cookie == true || $search_get == true ) )
	    	$listing_search .= '<div class="listing-search-reset-button">' . $search_labels['reset'] . '</div>' . "\n";
	    	
	if( isset( $advanced_search_button ) )
	    $listing_search .= $advanced_search_button;
	    
	$listing_search .= '</div><!-- .listing-search-buttons -->' . "\n\n";	    		
	
	// Close form tag
	
	$listing_search .= '</div><!-- form-inner -->';
	$listing_search .= '</form>' . "\n";
	
	// Close form wrap
	$listing_search .= '</div><!-- .listing-search -->' . "\n";
	
	return apply_filters( 'wpsight_get_listing_search', $listing_search );

}
