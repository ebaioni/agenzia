<?php
/**
 * Create the following custom taxonomies with all
 * the labels and rewrite rules.
 *
 * - Location
 * - Type
 * - Feature
 * - Category (not post category)
 *
 * @package wpSight
 */

/**
 * This function adds the location taxonomy
 *
 * @uses register_taxonomy()
 *
 * @since 1.0
 */
 
add_action( 'init', 'wpsight_taxonomy_locations_register' );

function wpsight_taxonomy_locations_register() {

	// Set labels and localize them

	$locations_name		= apply_filters( 'wpsight_taxonomy_locations_name', __( 'Locations', 'wpsight' ) );
	$locations_singular	= apply_filters( 'wpsight_taxonomy_locations_singular', __( 'Location', 'wpsight' ) );

	$locations_labels = array(
		'name' 				 		 => $locations_name,
		'singular_name' 	 		 => $locations_singular,
        'menu_name' 		 		 => _x( 'Locations', 'taxonomy locations', 'wpsight' ),
        'all_items' 		 		 => _x( 'All Locations', 'taxonomy locations', 'wpsight' ),
        'edit_item' 		 		 => _x( 'Edit Location', 'taxonomy locations', 'wpsight' ),
        'view_item' 		 		 => _x( 'View Location', 'taxonomy locations', 'wpsight' ),
        'update_item' 		 		 => _x( 'Update Location', 'taxonomy locations', 'wpsight' ),
        'add_new_item' 		 		 => _x( 'Add New Location', 'taxonomy locations', 'wpsight' ),
        'new_item_name' 	 		 => _x( 'New Location Name', 'taxonomy locations', 'wpsight' ),
        'parent_item'  		 		 => _x( 'Parent Location', 'taxonomy locations', 'wpsight' ),
        'parent_item_colon'  		 => _x( 'Parent Location:', 'taxonomy locations', 'wpsight' ),
        'search_items' 		 		 => _x( 'Search locations', 'taxonomy locations', 'wpsight' ),
        'popular_items' 	 		 => _x( 'Popular Locations', 'taxonomy locations', 'wpsight' ),
        'separate_items_with_commas' => _x( 'Separate locations with commas', 'taxonomy locations', 'wpsight' ),
        'add_or_remove_items' 		 => _x( 'Add or remove locations', 'taxonomy locations', 'wpsight' ),
        'choose_from_most_used' 	 => _x( 'Choose from the most used locations', 'taxonomy locations', 'wpsight' ),
        'not_found' 		 		 => _x( 'No location found', 'taxonomy locations', 'wpsight' )
	);
	
	// Set args incl rewrite rules

	$locations_args = array(
		'labels' 		=> $locations_labels,
		'hierarchical' 	=> true,
		'capabilities'  => array(
			'manage_terms' => 'edit_others_listings',
            'edit_terms'   => 'edit_others_listings',
            'delete_terms' => 'edit_others_listings',
			'assign_terms' => 'edit_listings'
		),
		'rewrite' 		=> array(
			'slug' 		   => apply_filters( 'wpsight_rewrite_loctions_slug', 'location' ),
			'with_front'   => false,
			'hierarchical' => true
		)
	);
	
	$locations_args = apply_filters( 'wpsight_taxonomy_locations_args', $locations_args );
	
	// Register taxonomy
	
	register_taxonomy( 'location', array( wpsight_listing_post_type() ), $locations_args );

}

/**
 * This function adds the property type taxonomy
 *
 * @uses register_taxonomy()
 *
 * @since 1.0
 */
 
add_action( 'init', 'wpsight_taxonomy_types_register' );

function wpsight_taxonomy_types_register() {

	// Set labels and localize them
	
	$types_name		= apply_filters( 'wpsight_taxonomy_types_name', __( 'Listing Types', 'wpsight' ) );
	$types_singular	= apply_filters( 'wpsight_taxonomy_types_singular', __( 'Listing Type', 'wpsight' ) );
	
	$types_labels = array(
		'name' 						 => $types_name,
		'singular_name' 			 => $types_singular,
		'menu_name' 		 		 => _x( 'Listing Types', 'taxonomy types', 'wpsight' ),
        'all_items' 		 		 => _x( 'All Listing Types', 'taxonomy types', 'wpsight' ),
        'edit_item' 		 		 => _x( 'Edit Listing Type', 'taxonomy types', 'wpsight' ),
        'view_item' 		 		 => _x( 'View Listing Type', 'taxonomy types', 'wpsight' ),
        'update_item' 		 		 => _x( 'Update Listing Type', 'taxonomy types', 'wpsight' ),
        'add_new_item' 		 		 => _x( 'Add New Listing Type', 'taxonomy types', 'wpsight' ),
        'new_item_name' 	 		 => _x( 'New Listing Type Name', 'taxonomy types', 'wpsight' ),
        'parent_item'  		 		 => _x( 'Parent Listing Type', 'taxonomy types', 'wpsight' ),
        'parent_item_colon'  		 => _x( 'Parent Listing Type:', 'taxonomy types', 'wpsight' ),
        'search_items' 		 		 => _x( 'Search listing types', 'taxonomy types', 'wpsight' ),
        'popular_items' 	 		 => _x( 'Popular Listing Types', 'taxonomy types', 'wpsight' ),
        'separate_items_with_commas' => _x( 'Separate listing types with commas', 'taxonomy types', 'wpsight' ),
        'add_or_remove_items' 		 => _x( 'Add or remove listing types', 'taxonomy types', 'wpsight' ),
        'choose_from_most_used' 	 => _x( 'Choose from the most used listing types', 'taxonomy types', 'wpsight' ),
        'not_found' 		 		 => _x( 'No listing type found', 'taxonomy types', 'wpsight' )
	);
	
	// Set args incl rewrite rules

	$types_args = array(
		'labels' 	   => $types_labels,
		'hierarchical' => false,
		'capabilities'  => array(
			'manage_terms' => 'edit_others_listings',
            'edit_terms'   => 'edit_others_listings',
            'delete_terms' => 'edit_others_listings',
			'assign_terms' => 'edit_listings'
		),
		'rewrite' 	   => array( 
			'slug' 		 => apply_filters( 'wpsight_rewrite_types_slug', 'type' ),
			'with_front' => false
		)
	);
	
	$types_args = apply_filters( 'wpsight_taxonomy_types_args', $types_args );
	
	// Register taxonomy
	
	register_taxonomy( 'listing-type', array( wpsight_listing_post_type() ), $types_args );

}

/**
 * This function adds the features taxonomy
 *
 * @uses register_taxonomy()
 *
 * @since 1.0
 */
 
add_action( 'init', 'wpsight_taxonomy_features_register' );

function wpsight_taxonomy_features_register() {

	// Set labels and localize them
	
	$features_name	   = apply_filters( 'wpsight_taxonomy_features_name', __( 'Features', 'wpsight' ) );
	$features_singular = apply_filters( 'wpsight_taxonomy_features_singular', __( 'Feature', 'wpsight' ) );
	
	$features_labels = array(
		'name' 						 => $features_name,
		'singular_name' 			 => $features_singular,
		'menu_name' 		 		 => _x( 'Features', 'taxonomy features', 'wpsight' ),
        'all_items' 		 		 => _x( 'All Features', 'taxonomy features', 'wpsight' ),
        'edit_item' 		 		 => _x( 'Edit Feature', 'taxonomy features', 'wpsight' ),
        'view_item' 		 		 => _x( 'View Feature', 'taxonomy features', 'wpsight' ),
        'update_item' 		 		 => _x( 'Update Feature', 'taxonomy features', 'wpsight' ),
        'add_new_item' 		 		 => _x( 'Add New Feature', 'taxonomy features', 'wpsight' ),
        'new_item_name' 	 		 => _x( 'New Feature Name', 'taxonomy features', 'wpsight' ),
        'parent_item'  		 		 => _x( 'Parent Feature', 'taxonomy features', 'wpsight' ),
        'parent_item_colon'  		 => _x( 'Parent Feature:', 'taxonomy features', 'wpsight' ),
        'search_items' 		 		 => _x( 'Search features', 'taxonomy features', 'wpsight' ),
        'popular_items' 	 		 => _x( 'Popular Features', 'taxonomy features', 'wpsight' ),
        'separate_items_with_commas' => _x( 'Separate features with commas', 'taxonomy features', 'wpsight' ),
        'add_or_remove_items' 		 => _x( 'Add or remove features', 'taxonomy features', 'wpsight' ),
        'choose_from_most_used' 	 => _x( 'Choose from the most used features', 'taxonomy features', 'wpsight' ),
        'not_found' 		 		 => _x( 'No feature found', 'taxonomy features', 'wpsight' )
	);
	
	// Set args incl rewrite rules

	$features_args = array(
		'labels' 	   => $features_labels,
		'hierarchical' => false,
		'capabilities'  => array(
			'manage_terms' => 'edit_others_listings',
            'edit_terms'   => 'edit_others_listings',
            'delete_terms' => 'edit_others_listings',
			'assign_terms' => 'edit_listings'
		),
		'rewrite' 	   => array(
			'slug' 		 => apply_filters( 'wpsight_rewrite_features_slug', 'feature' ),
			'with_front' => false
		)
	);
	
	$features_args = apply_filters( 'wpsight_taxonomy_features_args', $features_args );
	
	// Register taxonomy
	
	register_taxonomy( 'feature', array( wpsight_listing_post_type() ), $features_args );

}

/**
 * This function adds the property category taxonomy
 *
 * @uses register_taxonomy()
 *
 * @since 1.0
 */
 
add_action( 'init', 'wpsight_taxonomy_categories_register' );

function wpsight_taxonomy_categories_register() {

	// Set labels and localize them
	
	$categories_name	 = apply_filters( 'wpsight_taxonomy_categories_name', __( 'Categories', 'wpsight' ) );
	$categories_singular = apply_filters( 'wpsight_taxonomy_categories_singular', __( 'Category', 'wpsight' ) );	
	
	$categories_labels = array(
		'name' 			=> $categories_name,
		'singular_name' => $categories_singular
	);
	
	// Set args incl rewrite rules

	$categories_args = array(
		'labels' 	   => $categories_labels,
		'hierarchical' => true,
		'capabilities'  => array(
			'manage_terms' => 'edit_others_listings',
            'edit_terms'   => 'edit_others_listings',
            'delete_terms' => 'edit_others_listings',
			'assign_terms' => 'edit_listings'
		),
		'rewrite' 	   => array( 
			'slug' 		   => apply_filters( 'wpsight_rewrite_categories_slug', 'listing-category' ), 
			'with_front'   => false,
			'hierarchical' => true
		)
	);
	
	$categories_args = apply_filters( 'wpsight_taxonomy_categories_args', $categories_args );
	
	// Register taxonomy
	
	register_taxonomy( 'listing-category', array( wpsight_listing_post_type() ), $categories_args );

}

/**
 * Set columns of properties list
 *
 * @since 1.0
 */
 
add_filter( 'manage_edit-listing_columns', 'wpsight_listings_edit_columns' );
add_filter( 'manage_edit-property_columns', 'wpsight_listings_edit_columns' );

function wpsight_listings_edit_columns( $columns ) {
	
  	$columns = array(
    	'cb' 			   => '<input type="checkbox" />',
    	'title' 		   => __( 'Title', 'wpsight' ),
    	'listing_details'  => __( 'Details', 'wpsight' ),
    	'listing_price'    => __( 'Price', 'wpsight' ) . ' (' . wpsight_get_currency() . ')', 
    	'listing_features' => __( 'Features', 'wpsight' ),
    	'listing_image'    => __( 'Image', 'wpsight' ),
    	'listing_agent'    => __( 'Agent', 'wpsight' ),
    	'date' 			   => __( 'Published', 'wpsight' )
	);
 
	return $columns;
}

add_action( 'manage_posts_custom_column',  'wpsight_listings_custom_columns' );

function wpsight_listings_custom_columns( $column ) {

	$post_id = get_the_ID();
  	
  	switch ( $column ) {
  	
  	  	case 'listing_details':
  	  		echo '<strong>ID: </strong>' . wpsight_get_listing_id( $post_id ) . '<br />';  	  		
  	  		echo __( 'Location', 'wpsight' ) . ': ' . get_the_term_list( $post_id, 'location', '', ', ','' ) . '<br />';
  	  		if( taxonomy_exists( 'property-type' ) )
  	  	  		echo __( 'Type', 'wpsight' ) . ': ' . get_the_term_list( $post_id, 'property-type', '', ', ','' ) . '<br />';
  	  	  	if( has_term( '', 'listing-category', $post_id ) )
  	  			echo __( 'Category', 'wpsight' ).': ' . get_the_term_list( $post_id, 'listing-category', '', ', ','' );
  	  		if( has_term( '', 'property-category', $post_id ) )
  	  			echo __( 'Category', 'wpsight' ).': ' . get_the_term_list( $post_id, 'property-category', '', ', ','' );
  	  	  	break;
  	  	  	
		case 'listing_price':			
  	  	  	echo wpsight_get_price();
  	  	  	break;
  	  	  	
  	  	case 'listing_agent':
  	  	  	echo get_the_author();
  	  	  	if( current_user_can( 'edit_users' ) )
  	  	  		echo '<br /><a href="' . admin_url( 'user-edit.php?user_id=' . get_the_author_meta( 'ID' ), 'http' ) . '">' . __ ( 'See profile', 'wpsight' ) . '</a>';
  	  	  	break;
  	  	  	
  	  	case 'listing_features':
  	  		echo get_the_term_list( $post_id, 'feature', '', ', ','' ) . '<br />';  			
  	  	  	break;
  	  	  	
  	  	case 'listing_image':
  	  	  	echo get_the_post_thumbnail( $post_id, 'thumbnail' );  	  	  	
  	  	  	break;
  	}
  	
}

/**
 * Make columns sortable
 *
 * @since 1.0
 */
 
// Register sortable column details
 
add_filter( 'manage_edit-listing_sortable_columns', 'wpsight_wpcasa_id_column_register_sortable' );
add_filter( 'manage_edit-property_sortable_columns', 'wpsight_wpcasa_id_column_register_sortable' );

function wpsight_wpcasa_id_column_register_sortable( $columns ) {
	$columns['listing_details'] = 'listing_details';	
	return $columns;	
}

// Make sortable by ID

add_filter( 'request', 'wpsight_wpcasa_id_column_orderby' );

function wpsight_wpcasa_id_column_orderby( $vars ) {
	if ( isset( $vars['orderby'] ) && 'listing_details' == $vars['orderby'] )	
		$vars = array_merge( $vars, array( 'orderby' => 'id' ) ); 
	return $vars;
	
}

// Register sortable column price

add_filter( 'manage_edit-listing_sortable_columns', 'wpsight_wpcasa_price_column_register_sortable' );
add_filter( 'manage_edit-property_sortable_columns', 'wpsight_wpcasa_price_column_register_sortable' );

function wpsight_wpcasa_price_column_register_sortable( $columns ) {
	$columns['listing_price'] = 'listing_price';	
	return $columns;	
}

// Make sortable by custom field _price

add_filter( 'request', 'wpsight_wpcasa_price_column_orderby' );

function wpsight_wpcasa_price_column_orderby( $vars ) {
	if ( isset( $vars['orderby'] ) && 'listing_price' == $vars['orderby'] )	
		$vars = array_merge( $vars, array( 'meta_key' => '_price', 'orderby'  => 'meta_value_num' ) ); 
	return $vars;	
}

// Register sortable column agent

add_filter( 'manage_edit-listing_sortable_columns', 'wpsight_wpcasa_agent_column_register_sortable' );
add_filter( 'manage_edit-property_sortable_columns', 'wpsight_wpcasa_agent_column_register_sortable' );

function wpsight_wpcasa_agent_column_register_sortable( $columns ) {
	$columns['listing_agent'] = 'listing_agent';	
	return $columns;	
}

/**
 * Add filter by status to
 * listing filters
 *
 * @since 1.2
 */

add_filter( 'parse_query', 'wpsight_parse_query_status' );

function wpsight_parse_query_status( $query ) {

    global $pagenow, $typenow;
    
    if( $typenow != wpsight_listing_post_type() )
		return;

    if ( $pagenow == 'edit.php' ) {
    
    	if( isset( $_GET['wpsight-status'] ) && $_GET['wpsight-status'] != '' && $_GET['wpsight-status'] != 'soldrented' ) {
    		$query->query_vars['meta_key'] = '_price_status';
    		$query->query_vars['meta_value'] = $_GET['wpsight-status'];
        }
        
        if( isset( $_GET['wpsight-status'] ) && $_GET['wpsight-status'] == 'soldrented' ) {
			$query->query_vars['meta_key'] = '_price_sold_rented';
    		$query->query_vars['meta_value'] = '1';
		}
		
	}			
		
}

add_action( 'restrict_manage_posts', 'wpsight_restrict_manage_posts_status' );

function wpsight_restrict_manage_posts_status() {

    global $wpdb, $typenow;
    
     if( $typenow != wpsight_listing_post_type() )
		return;
    
    $statuses = wpsight_listing_statuses(); ?>

	<select name="wpsight-status">
		<option value=""><?php _e( 'Statuses', 'wpsight' ); ?></option><?php
		
		$current = isset( $_GET['wpsight-status'] ) ? $_GET['wpsight-status'] : false;

		foreach ( $statuses as $status => $label )
			echo '<option value="' . $status . '"' . selected( $status, $current, false ) . '>' . $label . '</option>'; ?>

		<option value="soldrented"<?php selected( 'soldrented', $current ); ?>><?php echo __( 'Sold', 'wpsight'  ) . ' / ' . __( 'Rented', 'wpsight'  ); ?></option>
	</select><?php

}

/**
 * Add filter by taxonomy to
 * listing filters
 *
 * @since 1.1
 */
 
// Create filters with custom taxonomies
 
add_action( 'restrict_manage_posts', 'wpsight_restrict_manage_posts_taxonomy' );

function wpsight_restrict_manage_posts_taxonomy() {

    global $typenow;
	
	if( $typenow != wpsight_listing_post_type() )
		return;
    
    $filters = get_object_taxonomies( $typenow );
    
	foreach( $filters as $tax_slug ) {
	
	    $tax_obj = get_taxonomy( $tax_slug );
	               
	    if( count( get_terms( $tax_slug ) ) > 0 ) {
	    
	    	$selected = isset( $_GET[$tax_obj->query_var] ) ? $_GET[$tax_obj->query_var] : false;
	              
	    	wp_dropdown_categories(
	    		array(
	    	    	'show_option_all' => $tax_obj->label,
	    	    	'taxonomy' 		  => $tax_slug,
	    	    	'name' 			  => $tax_obj->name,
	    	    	'selected' 		  => $selected,
	    	    	'hierarchical' 	  => $tax_obj->hierarchical,
	    	    	'show_count' 	  => false,
	    	    	'hide_empty' 	  => true,
	    	    	'orderby'		  => 'NAME',
	    	    	'walker'		  => new wpSight_Walker_TaxonomyDropdown()
	    		)
	    	);            
	    }
	}
}

// Manipulate query of listings list

add_filter( 'parse_query', 'wpsight_parse_query_taxonomy' );

function wpsight_parse_query_taxonomy( $query ) {

    global $pagenow, $typenow;
    
    if ( $pagenow == 'edit.php' ) {
    
        $filters = get_object_taxonomies( $typenow );
        
        foreach( $filters as $tax_slug ) {
        
            $var = &$query->query_vars[$tax_slug];
            
            if ( isset( $var ) ) {
                $term = get_term_by( 'id', $var, $tax_slug );
                if( ! empty( $term ) )
                	$var = $term->slug;
            }
        }
    }
}

/**
 * Add filter by agent to
 * listing filters
 *
 * @since 1.2
 */

add_action( 'restrict_manage_posts', 'wpsight_restrict_manage_posts_author' );

function wpsight_restrict_manage_posts_author() {

	global $typenow;
	
	if( $typenow != wpsight_listing_post_type() )
		return;

    $args = array( 'name' => 'author', 'show_option_all' => __( 'Agents', 'wpsight' ) );
    
    if ( isset( $_GET['user'] ) )
        $args['selected'] = $_GET['user'];

    wp_dropdown_users( $args );
}

/**
 * Add filter by details to
 * listing filters
 *
 * @since 1.2
 */

add_filter( 'parse_query', 'wpsight_parse_query_detail' );

function wpsight_parse_query_detail( $query ) {

    global $pagenow, $typenow;
    
    if( $typenow != wpsight_listing_post_type() )
		return;

    if ( $pagenow == 'edit.php' && isset( $_GET['wpsight-details'] ) && $_GET['wpsight-details'] != '' ) {
    
    	$query->query_vars['meta_key'] = '_' . $_GET['wpsight-details'];
    	
    	if ( isset( $_GET['wpsight-details-value'] ) && $_GET['wpsight-details-value'] != '' )
        	$query->query_vars['meta_value'] = $_GET['wpsight-details-value'];
    	
    	// Check data_compare of search form details
    	
    	/**
    	
    	$search_details = wpsight_search_form_details();
    	$meta_key = $_GET['wpsight-details'];
    	
    	if( isset( $search_details[$meta_key] ) && isset( $search_details[$meta_key]['data_compare'] ) )
    		$query->query_vars['meta_compare'] = $search_details[$meta_key]['data_compare'];
    		
    	*/
    		
    }
}

add_action( 'restrict_manage_posts', 'wpsight_restrict_manage_posts_detail' );

function wpsight_restrict_manage_posts_detail() {

    global $wpdb, $typenow;
    
     if( $typenow != wpsight_listing_post_type() )
		return;
    
    $standard_details = wpsight_standard_details(); ?>

	<select name="wpsight-details">
		<option value=""><?php _e( 'Listing Details', 'wpsight' ); ?></option><?php
		
		$current = isset( $_GET['wpsight-details'] ) ? $_GET['wpsight-details'] : false;
		$current_v = isset( $_GET['wpsight-details-value'] ) ? $_GET['wpsight-details-value'] : false;

		foreach ( $standard_details as $detail )
			echo '<option value="' . $detail['id'] . '"' . selected( $detail['id'], $current, false ) . '>' . $detail['label'] . '</option>'; ?>

	</select>
	<input type="text" name="wpsight-details-value" size="8" value="<?php echo $current_v; ?>" style="margin-right:15px" /><?php

}
