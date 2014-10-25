<?php
/**
 * Create $args arrays for
 * queries in search, taxonomy
 * and listing archive templates.
 *
 * - search
 * - taxonomy
 * - listing archive
 *
 * @package wpSight
 */
 
/**
 * Set search query args
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_listing_search_query_args' ) ) {

	function wpsight_listing_search_query_args() {	
		
		// Get all form fields / gets
		    		
		foreach( $_GET as $name => $value ) {
		    $search_get[$name] = $value;
		}
		
		global $wp_query;
		$s_false = false;
		
		$tax_query  = array();
		$meta_query = array();
		
		// Check all form details and set create queries
		
		foreach( wpsight_search_form_details() as $detail => $value ) {
		
		    if( empty( $value['type'] ) || $detail == 'nr' )
		    	continue;					
		
		    if( $value['type'] == 'taxonomy' ) {
		
		    	// Get custom taxonomy
		    	
		    	if( isset( $search_get[ $detail ] ) && $search_get[ $detail ] )
		    	    $tax_query[ $detail ] = array(
		    	    	'taxonomy'  => $value['taxonomy'],
		    	    	'field' 	=> 'slug',
		    	    	'terms' 	=> $search_get[ $detail ]
		    	    );
		    	
		    	// Check if search term is taxonomy term
		    	
		    	if( wpsight_search_is_taxnomy_term( $search_get['s'], $value['taxonomy'] ) ) {
		    	
		    		$tax_query[ $detail ] = array(
		    	        'taxonomy'  => $value['taxonomy'],
		    	        'field' 	=> 'slug',
		    	        'terms' 	=> sanitize_title( $search_get['s'] )
		    	    );
		    	    $s_false = true;
		    	    $search_get['s'] = false;
		    	
		    	}
		    		
		    } elseif( ( $value['type'] == 'select' || $value['type'] == 'radio' || $value['type'] == 'text' ) && $value['key'] != false ) {
		    
		    	$search_get[ $detail ] = isset( $search_get[ $detail ] ) ? $search_get[ $detail ] : false;
		    	
		    	if( $search_get[ $detail ] ) {
		    	
		    	    $meta_query[ $detail ] = array(
		    	    	'key' 	  => $value['key'],
		    	    	'value'   => $search_get[ $detail ],
		    	    	'compare' => $value['data_compare'],
		    	    	'type' 	  => $value['data_type']
		    	    );
		    	    
		    	}
		    	
		    }
		    
		}
		
		// Check filter checkboxes
		
		$filters_nr = apply_filters( 'wpsight_listing_search_filters_nr', 8 );
		
		$instance = isset( $instance ) ? $instance : false;
		
		for( $i = 1; $i <= $filters_nr; $i++ ) {
		    
		    if( ! empty( $search_get[ 'f' . $i ] ) ) {
		    
		    	$tax_query[ 'f' . $i ] = array(
		    	    'taxonomy'  => 'feature',
		    	    'field' 	=> 'slug',
		    	    'terms' 	=> sanitize_title( $search_get[ 'f' . $i ] )
		    	);
		    
		    }
		    
		}
		
		for( $i = 1; $i <= $filters_nr; $i++ ) {
		    $search_get[ 'f' . $i ] = strip_tags( $instance['filter' . $i] );
		}
		    	
		// Add price range to meta query
		
		if( ! empty( $search_get['min'] ) && is_numeric( preg_replace( '/\D/','', $search_get['min'] ) ) ) {
		
		    $meta_query['min'] = array(
		        'key' 	  => '_price',
		        'value'   => preg_replace( '/\D/','', $search_get['min'] ),
		        'compare' => '>=',
		        'type' 	  => 'numeric'
		    );
		    
		}
		
		if( ! empty( $search_get['max'] ) && is_numeric( preg_replace( '/\D/','', $search_get['max'] ) ) ) {
		
		    $meta_query['max'] = array(
		        'key' 	  => '_price',
		        'value'   => preg_replace( '/\D/','', $search_get['max'] ),
		        'compare' => '<=',
		        'type' 	  => 'numeric'
		    );
		    
		}
		
		// Set order and orderby
		
		if( isset( $search_get['orderby'] ) && $search_get['orderby'] == 'price' ) {
			$orderby = 'meta_value_num';
		} elseif( isset( $search_get['orderby'] ) ) {
			$orderby = $search_get['orderby'];
		} else {
			$orderby = false;
		}

		$order = isset( $search_get['order'] ) ? $search_get['order'] : 'DESC';
		
		// Set results per page number
		
		$posts_per_page = isset( $search_get['nr'] ) ? $search_get['nr'] : 12;
		    
		if( ! empty( $search_get ) ) {
		
		    $args = array(
		    	'post_type' 	 => wpsight_listing_post_type(),
		    	'posts_per_page' => $posts_per_page,
		    	's' 			 => $search_get['s'],
		    	'paged' 		 => get_query_var( 'paged' ),
		    	'orderby' 		 => $orderby,
		    	'order' 		 => $order
		    );
		    
		    // Add tax query to search args
		    
		    if( ! empty( $tax_query ) )	
		    	$args = array_merge( $args, array( 'tax_query' => $tax_query ) );
		    
		    // Add meta query to search args
		    
		    if( ! empty( $meta_query ) )
		    	$args = array_merge( $args, array( 'meta_query' => $meta_query ) );
		    	
		    
		    // Add orderby price to search args
		    
		    if( isset( $search_get['orderby'] ) && $search_get['orderby'] == 'price' ) {
		    	$orderby_args = array(
		    		'meta_key' => '_price'
		    	);
		    	$args = array_merge( $args, $orderby_args );
		    }
		    
		    // Exclude sold and rented
		    
		    global $wpdb;
		    
			$exclude_sold_rented = $wpdb->get_col( $wpdb->prepare( "
			    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
			    WHERE meta_key = '%s'
			    AND meta_value = '%s'
			", '_price_sold_rented', '1' ) );
			
			if( ! empty( $exclude_sold_rented ) && apply_filters( 'wpsight_exclude_sold_rented', false ) == true )
				$args = array_merge( $args, array( 'post__not_in' => $exclude_sold_rented ) );
		    
		    // Correct global query
		    
		    if( $s_false ) {
		    	$wp_query->is_home = false;
		    	$wp_query->is_search = true;
		    }
		    
		    // Fallback for old filter
		    $args = apply_filters( 'wpsight_listing_search_args', $args );
		    
		    // Finally return $args	    
		    return apply_filters( 'wpsight_listing_search_query_args', $args );
		    		    
		}
	
	}

}
 
/**
 * Set custom search query
 *
 * @since 1.3.2
 */

add_filter( 'pre_get_posts', 'wpsight_listing_search_query' );

function wpsight_listing_search_query( $query ) {

	if( is_search() && $query->is_main_query() ) {
	
		// Check type of search
		$stype = isset( $_GET['stype'] ) ? true : false;
		
    	if( $stype === false || $stype != 'default' ) {
    		
    		// Get listing search query
			$args = wpsight_listing_search_query_args();
			
			foreach( $args as $k => $v )		
				$query->set( $k, $v );
    		
    	}
    
    }
    
    return $query;
}


/**
 * Set taxonomy query args
 *
 * @since 1.3.5
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_listing_taxonomy_query_args' ) ) {

	function wpsight_listing_taxonomy_query_args() {		
		global $wp_query;
		
		// Set order args for global query

		$args = array(
		    'orderby' => get_query_var( 'orderby' ),
		    'order'   => get_query_var( 'order' )
		);
		
		// Set orderby price if set
						    
		if( get_query_var( 'orderby' ) == 'price' ) {
		    $args['orderby']  = 'meta_value_num';
		    $args['meta_key'] = '_price';
		}
		
		// Add posts_per_page
		$args['posts_per_page'] = 12;
		
		// Merge with original query
		$args = wp_parse_args( $args, array_filter( $wp_query->query_vars ) );
		
		// Finally return $args
		return apply_filters( 'wpsight_listing_taxonomy_query_args', $args, $wp_query->query_vars );
	
	}

}


/**
 * Set custom taxonomy query
 *
 * @since 1.3.5
 */

add_filter( 'pre_get_posts', 'wpsight_listing_taxonomy_query' );

function wpsight_listing_taxonomy_query( $query ) {

	if( is_tax() && ! is_search() && $query->is_main_query() ) {
	
		// Get listing search query
		$args = wpsight_listing_taxonomy_query_args();
		
		foreach( $args as $k => $v )		
			$query->set( $k, $v );
	
	}
    
    return $query;
}


/**
 * Set listing archive query args
 *
 * @since 1.3.5
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_listing_archive_query_args' ) ) {

	function wpsight_listing_archive_query_args() {		
		global $wp_query;
		
		// Set order args for global query

		$args = array(
		    'orderby' => get_query_var( 'orderby' ),
		    'order'   => get_query_var( 'order' )
		);
		
		// Set orderby price if set
						    
		if( get_query_var( 'orderby' ) == 'price' ) {
		    $args['orderby']  = 'meta_value_num';
		    $args['meta_key'] = '_price';
		}
		
		// Add posts_per_page
		$args['posts_per_page'] = 12;
		
		// Merge with original query
		$args = wp_parse_args( $args, array_filter( $wp_query->query_vars ) );
		
		// Finally return $args
		return apply_filters( 'wpsight_listing_archive_query_args', $args, $wp_query->query_vars );
	
	}

}


/**
 * Set custom listing archive query
 *
 * @since 1.3.5
 */

add_filter( 'pre_get_posts', 'wpsight_listing_archive_query' );

function wpsight_listing_archive_query( $query ) {

	if( is_post_type_archive( array( wpsight_listing_post_type() ) ) && $query->is_main_query() ) {
	
		// Get listing search query
		$args = wpsight_listing_archive_query_args();
		
		foreach( $args as $k => $v )		
			$query->set( $k, $v );
	
	}
    
    return $query;
}


/**
 * Set author query args
 *
 * @since 1.3.5
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_author_query_args' ) ) {

	function wpsight_author_query_args() {		
		global $wp_query;
		
		// Set order args for global query

		$args = array(
		    'orderby' => get_query_var( 'orderby' ),
		    'order'   => get_query_var( 'order' )
		);
		
		// Set orderby price if set
						    
		if( get_query_var( 'orderby' ) == 'price' ) {
		    $args['orderby']  = 'meta_value_num';
		    $args['meta_key'] = '_price';
		}
		
		// Add posts_per_page
		$args['posts_per_page'] = 12;
		
		// Merge with original query
		$args = wp_parse_args( $args, array_filter( $wp_query->query_vars ) );
		
		// Finally return $args
		return apply_filters( 'wpsight_author_query_args', $args, $wp_query->query_vars );
	
	}

}


/**
 * Set custom listing archive query
 *
 * @since 1.3.5
 */

add_filter( 'pre_get_posts', 'wpsight_author_query' );

function wpsight_author_query( $query ) {

	if( is_author() && $query->is_main_query() ) {
	
		// Get listing search query
		$args = wpsight_author_query_args();
		
		foreach( $args as $k => $v )		
			$query->set( $k, $v );
	
	}
    
    return $query;
}
