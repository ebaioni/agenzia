<?php
/**
 * Create search form details
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_search_form_details' ) ) {

	function wpsight_search_form_details() {
	
		$standard_details = wpsight_standard_details();
	
		$search_details = array(
		
			'status' => array(
				'label' 		=> __( 'Status', 'wpsight' ),
				'key'			=> '_price_status',
				'data' 			=> wpsight_listing_statuses(),
				'type' 			=> 'select',
				'data_compare' 	=> '=',
				'data_type' 	=> false,
				'default'		=> false,
				'advanced'		=> false,
	    		'position'		=> 10
			),
			'location' => array(
				'label'			=> __( 'Location', 'wpsight' ),
				'taxonomy'		=> 'location',
				'data' 			=> array(
					// wp_dropdown_categories() options
					'dropdown' => true
				),
				'type' 			=> 'taxonomy',
				'data_compare' 	=> false,
				'data_type' 	=> false,
				'default'		=> false,
				'advanced'		=> false,
	    		'position'		=> 20
			),
			'listing-type' => array(
				'label'			=> __( 'Type', 'wpsight' ),
				'taxonomy'		=> 'listing-type',
				'data' 			=> array(
					// wp_dropdown_categories() options
					'dropdown' => true
				),
				'type' 			=> 'taxonomy',
				'data_compare' 	=> false,
				'data_type' 	=> false,
				'default'		=> false,
				'advanced'		=> false,
	    		'position'		=> 30
			),
			$standard_details['details_1']['id'] => array(
				'label' 		=> $standard_details['details_1']['label'],
				'key'			=> '_details_1',
				'type'  		=> 'text',
				'data_compare' 	=> '=',
				'data_type' 	=> false,
				'default'		=> false,
				'advanced'		=> false,
	    		'position'		=> 40
			),
			$standard_details['details_2']['id'] => array(
				'label' 		=> $standard_details['details_2']['label'],
				'key'			=> '_details_2',
				'type'  		=> 'text',
				'data_compare' 	=> '=',
				'data_type' 	=> false,
				'default'		=> false,
				'advanced'		=> false,
	    		'position'		=> 50
			),
			'min' => array(
				'label' 		=> __( 'Price (min)', 'wpsight' ),
				'key'			=> '_price',
				'type' 			=> 'text',
				'data_compare' 	=> '>=',
				'data_type' 	=> 'numeric',
				'default'		=> false,
				'advanced'		=> true,
	    		'position'		=> 60
			),
			'max' => array(
				'label' 		=> __( 'Price (max)', 'wpsight' ),
				'key'			=> '_price',
				'type' 			=> 'text',
				'data_compare' 	=> '<=',
				'data_type' 	=> 'numeric',
				'default'		=> false,
				'advanced'		=> true,
	    		'position'		=> 70
			),
			'orderby' => array(
				'label'			=> __( 'Order by', 'wpsight' ),
				'key'			=> false,
				'data_compare' 	=> false,
				'data_type' 	=> false,
				'type' 			=> 'radio',
				'data' 			=> array(
					'date'  => __( 'Date', 'wpsight' ),
					'price' => __( 'Price', 'wpsight' ),
					'title'	=> __( 'Title', 'wpsight' )
				),
				'default'		=> 'date',
				'advanced'		=> true,
	    		'position'		=> 80
			),
			'order' => array(
				'label'			=> __( 'Order', 'wpsight' ),
				'key'			=> false,
				'data_compare' 	=> false,
				'data_type' 	=> false,
				'type' 			=> 'radio',
				'data' 			=> array(
					'asc'  => __( 'asc', 'wpsight' ),
					'desc' => __( 'desc', 'wpsight' )
				),
				'default'		=> 'desc',
				'advanced'		=> true,
	    		'position'		=> 90
			)
			
		);
		
		// Apply filter to array	
		$search_details = apply_filters( 'wpsight_search_form_details', $search_details );
		
		// Sort array by position        
	    $search_details = wpsight_sort_array_by_position( $search_details );
		
		// Return filtrable array	
		return $search_details;
	
	}

}

/**
 * Listing search
 *
 * Use search template even if s is empty
 *
 * @since 1.0
 */

add_filter( 'request', 'wpsight_request_filter' );

function wpsight_request_filter( $query_vars ) {

    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    
    return $query_vars;
}

// Set $wp_query accordingly

add_filter( 'pre_get_posts', 'wpsight_query_filter' );

function wpsight_query_filter( $query ) {	

	global $wp_query;
	
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $wp_query->is_home = false;
		$wp_query->is_search = true;
    }
    
    return $query;
}

/**
 * Listing search
 *
 * Check if search term s is taxonomy term
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_search_is_taxnomy_term' ) ) {

	function wpsight_search_is_taxnomy_term( $s = false, $tax = false ) {	
	
		if( ! empty( $s ) && in_multiarray( sanitize_title( $s ), get_terms( $tax ) ) ) {
							
		    $terms = get_terms( $tax );
		    
		    foreach( $terms as $term ) {
		    
		    	if( $term->slug == sanitize_title( $s ) ) {
		    		
		    		return true;
		    	
		    	}
		    }
		    
		}
		
		return false;
	
	}

}

/**
 * Set custom query vars for sorting
 *
 * @since 1.0
 */

add_filter( 'init', 'wpsight_custom_query_vars' );

function wpsight_custom_query_vars() {

    global $wp;    
    $wp->add_query_var( 'order' );
    $wp->add_query_var( 'orderby' );
    
}

/**
 * Built search form fields
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_search_form_fields' ) ) {

	function wpsight_search_form_fields( $search_fields, $search_details, $search_get, $search_advanced = false ) {
	
		// Create form fields
		$listing_search = '';
	
		foreach( $search_fields as $detail => $value ) {
		
			// Check if advanced search field
			if( $search_advanced == true && $value['advanced'] != true )
				continue;
				
			if( $search_advanced == false && $value['advanced'] == true )
				continue;
		    			
		    if( isset( $search_details[$detail] ) && $search_details[$detail] ) {
		    
		    	$listing_search .= '<div class="listing-search-field listing-search-field-' . $value['type'] . ' listing-search-field-' . $detail . '">';
		
		    	// Create custom options (select)
		    	
		    	if( $value['type'] == 'select' ) {
		    	
		    		$listing_search .= '<select class="listing-search-' . $detail . ' select" name="' . $detail . '">' . "\n";
		    	
		    		// Empty option with label	    					
		    		$listing_search .= '<option value="">' . $value['label'] . '</option>' . "\n";
		    	
		    		foreach( $value['data'] as $k => $v ) {
		    		
		    			$search_get[ $detail ] = isset( $search_get[ $detail ] ) ? $search_get[ $detail ] : false;
		    		
		    			if( ! empty( $k ) ) {
		    			
		    				$search_get[ $detail ] = ( isset( $search_get[ $detail ] ) && ! empty( $search_get[ $detail ] ) ) ? $search_get[ $detail ] : $value['default'];
		    			
		    				$listing_search .= '<option value="' . $k . '"' . selected( $k, sanitize_title( $search_get[ $detail ] ), false ) . '>' . $v . '</option>' . "\n";
		    			}
		
		    		}
		    		
		    		$listing_search .= '</select><!-- .listing-search-' . $detail . ' -->' . "\n";
		    		
		    	// Create custom options (text)
		
		    	} elseif( $value['type'] == 'text' ) {
		    		
		    		$search_get[ $detail ] = isset( $search_get[ $detail ] ) ? $search_get[ $detail ] : false;
		    		
		    		$listing_search .= '<input class="listing-search-' . $detail . ' text" title="' . $value['label'] . '" name="' . $detail . '" type="text" value="' . $search_get[ $detail ] . '" />' . "\n";
		    		
		    	// Create radio options
		    		
		    	} elseif( $value['type'] == 'radio' ) {
		    	
		    		if( ! empty( $value['label'] ) )
		    			$listing_search .= '<label class="radiogroup" for="' . $detail . '">' . $value['label'] . '</label>' . "\n";
		    		
		    		$search_get[ $detail ] = ( isset( $search_get[ $detail ] ) ) ? $search_get[ $detail ] : $value['default'];
		    		
		    		foreach( $value['data'] as $k => $v ) {
		    		
		    			$default = ( $value['default'] == $k ) ? 'true' : 'false';
		    		
		    			$listing_search .= '<label class="radio"><input type="radio" name="' . $detail . '" value="' . $k . '"' . checked( $k, $search_get[ $detail ], false ) . ' data-default="' . $default . '"/> ' . $v . '</label>' . "\n";
		    		
		    		}
		    		
		    	// Create taxonomy options
		    	
		    	} elseif( $value['type'] == 'taxonomy' ) {
		    	
		    		if( isset( $value['data']['dropdown'] ) && $value['data']['dropdown'] === true ) {
		    	
		    			$taxonomy = $value['taxonomy'];
		    			
		    			// Pre-select taxonomy if search is term
		    			
		    			$search_get[ $taxonomy ] = isset( $search_get[ $taxonomy ] ) ? $search_get[ $taxonomy ] : false;
		    			$taxonomy_s = ( wpsight_search_is_taxnomy_term( $search_get['s'], $taxonomy ) ) ? $search_get[ 's' ] : $search_get[ $taxonomy ];
		    			
		    			$taxonomy_s = ! empty( $taxonomy_s ) ? sanitize_title( $taxonomy_s ) : false;
		    			
		    			// Set wp_dropdown_categories() $args
		    			
		    			$defaults = array(
		    				'taxonomy'			=> $value['taxonomy'],
		    				'show_option_none' 	=> $value['label'],
		    				'selected'			=> $taxonomy_s,
		    				'hierarchical'		=> 1,
		    				'echo'				=> 0,
		    				'name'				=> $detail,
		    				'class'           	=> 'listing-search-' . $detail . ' select',
		    				'walker'			=> new wpSight_Walker_TaxonomyDropdown(),
		    				'orderby'         	=> 'ID', 
							'order'           	=> 'ASC',
							'show_count'      	=> 0,
							'hide_empty'      	=> 1, 
							'child_of'        	=> 0,
							'exclude'         	=> '',
							'id'              	=> '',
							'depth'           	=> 0,
							'hide_if_empty'   	=> false,
							'cache'				=> true
		    			);
		    			
		    			// Mix in search form fields $args
		    			$args = wp_parse_args( $value['data'], $defaults );
		    			
		    			// Check if transients are active
						$transients = apply_filters( 'wpsight_transients_taxonomies', false, 'listings-search', $args, $value['taxonomy'] );
						
						// If taxonomy transients are active

						if( $transients === true ) {
						
							// If transient does not exist
		    			
		    				if( false !== $taxonomy_s || isset( $value['data']['cache'] ) && $value['data']['cache'] === false ) {
		    				
		    					// If cache is false, make sure to delete transient
		    					
		    					$transient = get_transient( 'wpsight_taxonomy_dropdown_' . $value['taxonomy'] );
		    					
		    					if( false !== $transient )
		    						delete_transient( $transient );
		    				
		    					// If an option is pre-selected, create dropdown dynamically
							
								$taxonomy_dropdown = wp_dropdown_categories( $args );
								
							} else {
							
								// If we use default dropdown, use transient
							
								if ( false === ( $taxonomy_dropdown = get_transient( 'wpsight_taxonomy_dropdown_' . $value['taxonomy'] ) ) ) {
								
									// Create taxonomy dropdown
								 	$taxonomy_dropdown = wp_dropdown_categories( $args );
								 	
								 	// Set transient for this dropdown
								 	set_transient( 'wpsight_taxonomy_dropdown_' . $value['taxonomy'], $taxonomy_dropdown, DAY_IN_SECONDS );

								}
							
							}

						// If taxonomy transients are not active
						
						} else {

							// Create taxonomy dropdown
							$taxonomy_dropdown = wp_dropdown_categories( $args );
						
						}
		    		
		    			// Add dropdown		    	
		    			$listing_search .= $taxonomy_dropdown;
					
					} else {
					
						$listing_search .= '<select class="listing-search-' . $detail . ' select" name="' . $detail . '">' . "\n";
		    	
		    			// Empty option with label	    					
		    			$listing_search .= '<option value="">' . $value['label'] . '</option>' . "\n";
		    				
		    			$taxonomy = $value['taxonomy'];
		    			
		    			// Pre-select taxonomy if search is term
		    			$search_get[ $taxonomy ] = isset( $search_get[ $taxonomy ] ) ? $search_get[ $taxonomy ] :false;
		    			$taxonomy_s = ( wpsight_search_is_taxnomy_term( $search_get['s'], $taxonomy ) ) ? $search_get[ 's' ] : $search_get[ $taxonomy ];    						
		    			
		    			foreach( $value['data'] as $k => $v ) {
		    			
		    				if( $v->parent != 0 )
		    					continue;
		    			
		    				$listing_search .= '<option value="' . $v->slug . '"' . selected( $v->slug, sanitize_title( $taxonomy_s ), false ) . '>' . $v->name . '</option>' . "\n";
		    				
		    				$children_1 = get_terms( $taxonomy, array( 'child_of' => $v->term_id, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true ) );
		    				
		    				if( $children_1 ) {
		    				
		    					foreach ( $children_1 as $child_1 ) {
		    					
		    						if( $child_1->parent != $v->term_id || ! in_multiarray( $child_1->term_id, $value['data'] ) )
		    							continue;
		    					
		    						$listing_search .= '<option value="' . $child_1->slug . '"' . selected( $child_1->slug, sanitize_title( $taxonomy_s ), false ) . '>' . str_repeat( '&#45;', 1 ) . '&nbsp;' . $child_1->name . '</option>' . "\n";
		    						
		    						$children_2 = get_terms( $taxonomy, array( 'child_of' => $child_1->term_id, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true ) );
		    						
		    						if( $children_2 ) {
		    						
		    							foreach ( $children_2 as $child_2 ) {
		    							
		    								if( $child_2->parent != $child_1->term_id || ! in_multiarray( $child_2->term_id, $value['data'] ) )
		    									continue;
		    						
		    								$listing_search .= '<option value="' . $child_2->slug . '"' . selected( $child_2->slug, sanitize_title( $taxonomy_s ), false ) . '>' . str_repeat( '&#45;', 2 ) . '&nbsp;' . $child_2->name . '</option>' . "\n";
		    								
		    								$children_3 = get_terms( $taxonomy, array( 'child_of' => $child_2->term_id, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true ) );
		    								
		    								if( $children_3 ) {
		    									
		    									foreach ( $children_3 as $child_3 ) {
		    							
		    										if( $child_3->parent != $child_2->term_id || ! in_multiarray( $child_3->term_id, $value['data'] ) )
		    											continue;
		    									
		    										$listing_search .= '<option value="' . $child_3->slug . '"' . selected( $child_3->slug, sanitize_title( $taxonomy_s ), false ) . '>' . str_repeat( '&#45;', 3 ) . '&nbsp;' . $child_3->name . '</option>' . "\n";
		    										
		    										$children_4 = get_terms( $taxonomy, array( 'child_of' => $child_3->term_id, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true ) );
		    										
		    										if( $children_4 ) {
		    											
		    											foreach ( $children_4 as $child_4 ) {
		    										
		    												if( $child_4->parent != $child_3->term_id || ! in_multiarray( $child_4->term_id, $value['data'] ) )
		    													continue;
		    											
		    												$listing_search .= '<option value="' . $child_4->slug . '"' . selected( $child_4->slug, sanitize_title( $taxonomy_s ), false ) . '>' . str_repeat( '&#45;', 4 ) . '&nbsp;' . $child_4->name . '</option>' . "\n";
		    											
		    											}
		    											
		    										} // endif $children_4
		    									
		    									}
		    									
		    								} // endif $children_3
		    							
		    							}
		    						
		    						} // endif $children_2
		    					
		    					}
		    				
		    				} // endif $children_1
		    			
		    			}
		    			
		    			$listing_search .= '</select><!-- .listing-search-' . $detail . ' -->' . "\n";
					
					}
		    	
		    	}
		    	
		    	$listing_search .= '</div><!-- .listing-search-field .listing-search-field-' . $detail . ' -->';
		    
		    }
		    					
		}
		
		return $listing_search;
	
	}

}

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_search_form_filters' ) ) {

	function wpsight_search_form_filters( $search_fields, $search_details, $search_get, $search_advanced = false ) {
	
		// Get advanced search filters
		
		$search_filters = wpsight_get_option( 'search_filters', false );
		
		if( $search_filters ) {
		    $get_filters = array();
		    $search_filters_nr = apply_filters( 'wpsight_listing_search_filters_nr', 8 );
		    for( $i = 1; $i <= $search_filters_nr; $i++ ) {			
		        $get_filters[$i] = wpsight_get_option( 'filter_' . $i );
		    }
		    $get_filters = array_filter( (array) $get_filters );
		}
		
		// Search filters
		    
		if( $search_filters && ! empty( $get_filters ) ) {
		
		    $listing_search_filters = '<div class="listing-search-field-filter">' . "\n";
		    
		    $i = 1;
		    
		    foreach( $get_filters as $filter ) {
		    
		    	$filter = explode(',', $filter);
		    	$search_get[ 'f' . $i ] = isset( $search_get[ 'f' . $i ] ) ? $search_get[ 'f' . $i ] : false;
		    
		    	$listing_search_filters .= '<div class="listing-search-filter f' . $i . '">' . "\n";
		    	$listing_search_filters .= '<label class="checkbox"><input type="checkbox" name="f' . $i . '" value="' . sanitize_title( $filter[1] ) . '"' . checked( sanitize_title( $filter[1] ), $search_get[ 'f' . $i ], false ) . ' /><span>' . $filter[1] . '</span></label>' . "\n";
		    	$listing_search_filters .= '</div><!-- .listing-search-filter.f' . $i . ' -->' . "\n";
		    	
		    	$i++;
		    
		    }
		    
		    $listing_search_filters .= '</div><!-- .listing-search-filters -->' . "\n\n";
		    
		    // Filter search filter section
		    $listing_search_filters = apply_filters( 'wpsight_search_form_filters', $listing_search_filters, $search_fields, $search_details, $search_get, $search_advanced );
		    
		    return $listing_search_filters;
		
		}
	
	}

}


/**
 * Set cookie for search query
 *
 * @package wpSight
 * @version 1.0
 */
 
add_action( 'init', 'wpsight_search_cookie' );
 
function wpsight_search_cookie() {

	// Can be deactivated by filter
	$search_cookie = apply_filters( 'wpsight_search_cookie', true );
	
	// Stop if not search or cookie disabled

	if( ! isset( $_GET['s'] ) || isset( $_GET['stype'] ) || $search_cookie == false || is_admin() )
		return;
		
	// Get all gets

	foreach( $_GET as $get => $get_v ) {
		$get_query[ $get ] = $get_v;
	}
	
	// Make string from get array		
	$search_query = wpsight_implode_array( ',', $get_query );

	// Set cookie live without page load
	$_COOKIE[WPSIGHT_COOKIE_SEARCH_QUERY] = $search_query;
	
	// Set cookie with comma-separated parameters
    setcookie( WPSIGHT_COOKIE_SEARCH_QUERY, $search_query, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false );
    
}



/**
 * Allow search by listing ID (listings)
 *
 * @since 1.0
 */

add_action( 'parse_request', 'wpsight_listing_id_search' );

function wpsight_listing_id_search( $wp ) {

    global $wpdb, $pagenow;

    if( 'edit.php' != $pagenow )
        return;

    // If it's not a search return
    if( ! isset( $wp->query_vars['s'] ) )
        return;

    // Search custom fields for listing ID
    
    $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
    WHERE meta_value LIKE '%s'
    ", $wp->query_vars['s'] ) );
    
    if( ! empty( $post_ids_meta ) ) {
    	unset( $wp->query_vars['s'] );    	
		$wp->query_vars['p'] = $post_ids_meta[0];
		do_action( 'wpsight_listing_id_search' );
	}
    
}

/**
 * Allow search by listing ID (media library)
 *
 * @since 1.2
 */

add_action( 'parse_request', 'wpsight_listing_id_search_media' );

function wpsight_listing_id_search_media( $wp ) {

    global $wpdb, $pagenow;

    if( 'upload.php' != $pagenow )
        return;

    // If it's not a search return
    if( ! isset( $wp->query_vars['s'] ) )
        return;

    // Search custom fields for listing ID

    $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
    WHERE meta_value LIKE '%s'
    ", $wp->query_vars['s'] ) );
    
    if( ! empty( $post_ids_meta ) ) {
    	unset( $wp->query_vars['s'] );    	
		$wp->query_vars['post_parent'] = $post_ids_meta[0];
		do_action( 'wpsight_listing_id_search' );
	}
    
}

// Set search results title accordingly

add_action( 'wpsight_listing_id_search', 'wpsight_filter_media_custom_search_title' );

function wpsight_filter_media_custom_search_title() {
	add_filter( 'get_search_query', 'wpsight_media_custom_search_title' );
}

function wpsight_media_custom_search_title() {	
	return $_GET['s'];	
}
