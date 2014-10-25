<?php

/**
 * Create the listing post type with all
 * the labels and rewrite rules and add
 * the headline icon of listing edit screen.
 *
 * @package wpSight
 */
  
/**
 * This functions add the custom
 * post type listing
 *
 * @since 1.0
 */

add_action( 'init', 'wpsight_register_listing' );

function wpsight_register_listing() {

	// Set post type labels

    $labels = array( 
        'name' 				 => _x( 'Listings', 'listing', 'wpsight' ),
        'singular_name' 	 => _x( 'Listing', 'listing', 'wpsight' ),
        'add_new' 			 => _x( 'Add New', 'listing', 'wpsight' ),
        'add_new_item' 		 => _x( 'Add New Listing', 'listing', 'wpsight' ),
        'edit_item' 		 => _x( 'Edit Listing', 'listing', 'wpsight' ),
        'new_item' 			 => _x( 'New Listing', 'listing', 'wpsight' ),
        'view_item' 		 => _x( 'View Listing', 'listing', 'wpsight' ),
        'search_items' 		 => _x( 'Search Listings', 'listing', 'wpsight' ),
        'not_found' 		 => _x( 'No listings found', 'listing', 'wpsight' ),
        'not_found_in_trash' => _x( 'No listings found in Trash', 'listing', 'wpsight' ),
        'menu_name' 		 => _x( 'Listings', 'listing', 'wpsight' ),
    );
    
    $labels = apply_filters( 'wpsight_post_type_labels_listing', $labels );
    
    // Set post type arguments

    $args = array( 
        'labels' 			  => $labels,
        'hierarchical' 		  => false,        
        'supports' 			  => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'revisions', 'excerpt' ),
        'public' 			  => true,
        'show_ui' 			  => true,
        'show_in_menu' 		  => true,
        'menu_position' 	  => 5,
        'menu_icon' 		  => false,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive' 		  => true,
        'query_var' 		  => true,
        'can_export' 		  => true,
        'rewrite' 			  => array( 'slug' => apply_filters( 'wpsight_rewrite_listings_slug', 'listing' ), 'with_front' => false ),
        'capability_type' 	  => 'listing',
		'capabilities' 		  => array(
		    'publish_posts' 	  => 'publish_listings',
		    'edit_posts' 		  => 'edit_listings',
		    'edit_others_posts'   => 'edit_others_listings',
		    'delete_posts' 		  => 'delete_listings',
		    'delete_others_posts' => 'delete_others_listings',
		    'read_private_posts'  => 'read_private_listings',
		    'edit_post' 		  => 'edit_listing',
		    'delete_post' 		  => 'delete_listing',
		    'read_post' 		  => 'read_listing'
		)
    );
    
    $args = apply_filters( 'wpsight_post_type_args_listing', $args );
    
    // Register post type

    register_post_type( 'listing', $args );
    
}

/**
 * This function sets the post type icon of
 * the headline on property edit screen
 *
 * @since 1.0
 */

add_action( 'admin_head', 'wpsight_post_type_header' );

function wpsight_post_type_header() {

	global $post_type;
	
	$output = '<style>#icon-edit { background:transparent url(' . home_url() . '/wp-admin/images/icons32.png) no-repeat -137px -5px; } tr.type-property td { padding: 12px 0 } .column-listing_image img { padding:9px; border:1px solid #e4e4e4; background: #fcfcfc } .alternate .column-listing_image img { background: #f9f9f9 } .widefat tbody th input { margin-top: 3px } tr.type-listing td.column-listing_features { padding-right: 15px }</style>';
	
	if( $post_type == 'listing' )
		echo $output;
	
}