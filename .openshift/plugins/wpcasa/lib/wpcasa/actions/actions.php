<?php
/**
 * Add wpCasa-specific actions
 *
 * @package wpSight
 */
 
/**
 * This functions add the custom
 * post type property
 *
 * @since 1.0
 */

// Remove general listing post type
remove_action( 'init', 'wpsight_register_listing' );

// Add property post type
add_action( 'init', 'wpsight_register_property' );

function wpsight_register_property() {

	global $wp_version;
	
	// Set menu icon
	
	$menu_icon = ( $wp_version < '3.8' ) ? WPSIGHT_ADMIN_IMG_URL . '/menu-properties.png' : 'dashicons-admin-home';

	// Set post type labels

    $labels = array( 
        'name' 				 => _x( 'Properties', 'property', 'wpsight' ),
        'singular_name' 	 => _x( 'Property', 'property', 'wpsight' ),
        'add_new' 			 => _x( 'Add New', 'property', 'wpsight' ),
        'add_new_item' 		 => _x( 'Add New Property', 'property', 'wpsight' ),
        'edit_item' 		 => _x( 'Edit Property', 'property', 'wpsight' ),
        'new_item' 			 => _x( 'New Property', 'property', 'wpsight' ),
        'view_item' 		 => _x( 'View Property', 'property', 'wpsight' ),
        'search_items' 		 => _x( 'Search Properties', 'property', 'wpsight' ),
        'not_found' 		 => _x( 'No properties found', 'property', 'wpsight' ),
        'not_found_in_trash' => _x( 'No properties found in Trash', 'property', 'wpsight' ),
        'menu_name' 		 => _x( 'Properties', 'property', 'wpsight' ),
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
        'menu_icon' 	  	  => $menu_icon,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive' 		  => true,
        'query_var' 		  => true,
        'can_export' 		  => true,
        'rewrite' 			  => array( 'slug' => apply_filters( 'wpsight_rewrite_properties_slug', 'property' ), 'with_front' => false ),
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

    register_post_type( 'property', $args );
    
}

/**
 * This function sets the post type icon of
 * the headline on property edit screen
 *
 * @since 1.0
 */

// Remove general post type header
remove_action( 'admin_head', 'wpsight_post_type_header' );

// Add property post type header
add_action( 'admin_head', 'wpsight_wpcasa_post_type_header' );

function wpsight_wpcasa_post_type_header() {

	global $post_type;
	
	$output = '<style>#icon-edit { background:transparent url(' . home_url() . '/wp-admin/images/icons32.png) no-repeat -137px -5px; } tr.type-property td { padding: 12px 0 } .column-listing_image img { padding:9px; border:1px solid #e4e4e4; background: #fcfcfc } .alternate .column-listing_image img { background: #f9f9f9 } .widefat tbody th input { margin-top: 3px } tr.type-listing td.column-listing_features { padding-right: 15px }</style>';
	
	if( $post_type == 'property' )
		echo $output;
	
}

/**
 * Redirect property post type archive
 * to archive-listing.php
 *
 * @since 1.2
 */

add_action( 'template_redirect', 'wpsight_post_type_archive_redirect' );

function wpsight_post_type_archive_redirect() {
    
    if( is_post_type_archive( 'property' ) ) {    
		locate_template( '/archive-listing.php', true, true );
		exit();	
	}
    
}
 
/**
 * This function adds the property type taxonomy
 *
 * @uses register_taxonomy()
 *
 * @since 1.2
 */

// Remove general types taxonomy
remove_action( 'init', 'wpsight_taxonomy_types_register' );

// Add property types taxonomy
add_action( 'init', 'wpsight_wpcasa_taxonomy_types_register' );

function wpsight_wpcasa_taxonomy_types_register() {

	// Set labels and localize them
	
	$types_name		= apply_filters( 'wpsight_taxonomy_types_name', __( 'Property Types', 'wpsight' ) );
	$types_singular	= apply_filters( 'wpsight_taxonomy_types_singular', __( 'Property Type', 'wpsight' ) );
	
	$types_labels = array(
		'name' 						 => $types_name,
		'singular_name' 			 => $types_singular,
		'menu_name' 		 		 => _x( 'Property Types', 'taxonomy types', 'wpsight' ),
        'all_items' 		 		 => _x( 'All Property Types', 'taxonomy types', 'wpsight' ),
        'edit_item' 		 		 => _x( 'Edit Property Type', 'taxonomy types', 'wpsight' ),
        'view_item' 		 		 => _x( 'View Property Type', 'taxonomy types', 'wpsight' ),
        'update_item' 		 		 => _x( 'Update Property Type', 'taxonomy types', 'wpsight' ),
        'add_new_item' 		 		 => _x( 'Add New Property Type', 'taxonomy types', 'wpsight' ),
        'new_item_name' 	 		 => _x( 'New Property Type Name', 'taxonomy types', 'wpsight' ),
        'parent_item'  		 		 => _x( 'Parent Property Type', 'taxonomy types', 'wpsight' ),
        'parent_item_colon'  		 => _x( 'Parent Property Type:', 'taxonomy types', 'wpsight' ),
        'search_items' 		 		 => _x( 'Search property types', 'taxonomy types', 'wpsight' ),
        'popular_items' 	 		 => _x( 'Popular Property Types', 'taxonomy types', 'wpsight' ),
        'separate_items_with_commas' => _x( 'Separate property types with commas', 'taxonomy types', 'wpsight' ),
        'add_or_remove_items' 		 => _x( 'Add or remove property types', 'taxonomy types', 'wpsight' ),
        'choose_from_most_used' 	 => _x( 'Choose from the most used property types', 'taxonomy types', 'wpsight' ),
        'not_found' 		 		 => _x( 'No property type found', 'taxonomy types', 'wpsight' )
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
	
	register_taxonomy( 'property-type', array( 'property' ), $types_args );

}

/**
 * This function adds the property category taxonomy
 *
 * @uses register_taxonomy()
 *
 * @since 1.2
 */

// Remove general categories taxonomy
remove_action( 'init', 'wpsight_taxonomy_categories_register' );

// Add property category taxonomy
add_action( 'init', 'wpsight_wpcasa_taxonomy_categories_register' );

function wpsight_wpcasa_taxonomy_categories_register() {

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
			'manage_terms' => 'manage_options',
            'edit_terms'   => 'manage_options',
            'delete_terms' => 'manage_options',
			'assign_terms' => 'edit_listings'
		),
		'rewrite' 	   => array( 
			'slug' 		   => apply_filters( 'wpsight_rewrite_categories_slug', 'property-category' ), 
			'with_front'   => false,
			'hierarchical' => true
		)
	);
	
	$categories_args = apply_filters( 'wpsight_taxonomy_categories_args', $categories_args );
	
	// Register taxonomy
	
	register_taxonomy( 'property-category', array( 'property' ), $categories_args );

}

/**
 * Custom wpCasa welcome panel
 *
 * @since 1.2
*/

// Remove default WordPress panel
remove_action( 'welcome_panel', 'wp_welcome_panel' );

add_action( 'welcome_panel', 'wpsight_wpcasa_welcome_panel' );

function wpsight_wpcasa_welcome_panel() { ?>

	<div class="welcome-panel-content">
	
		<h3><?php _e( 'Thanks for using wpCasa!', 'wpsight' ); ?></h3>
		<p class="about-description"><?php _e( 'Here are some quick links to help you find your way', 'wpsight' ); ?>:</p>
	
		<div class="welcome-panel-column-container">
		
			<div class="welcome-panel-column">
			
				<h4><?php _e( 'Customize It', 'wpsight' ); ?></h4>
				<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Customize Your Site', 'wpsight' ); ?></a>
				<a class="button button-primary button-hero hide-if-customize" href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Customize Your Site', 'wpsight' ); ?></a>
				<p class="hide-if-no-customize"><?php printf( __( 'or <a href="%s">change theme settings</a>', 'wpsight' ), admin_url( 'themes.php?page=wpcasa' ) ); ?></p>
				
			</div><!-- .welcome-panel-column -->
			
			<div class="welcome-panel-column">
			
				<h4><?php _e( 'Get Started', 'wpsight' ); ?></h4>
				<ul>
					<li><a href="<?php echo admin_url( 'post-new.php?post_type=property' ); ?>" class="welcome-icon welcome-write-blog"><?php _e( 'Create a listing', 'wpsight' ); ?></a></li>
					<li><div class="welcome-icon welcome-add-page"><?php printf( __( 'Example data (<a href="%1$s" target="_blank">read tutorial</a> or <a href="%2$s" target="_blank">download XML</a>)', 'wpsight' ), 'http://support.wpcasa.com/article/example-content', 'http://wpcasa.com/download/wpcasa.xml' ); ?></div></li>
					<li><div class="welcome-icon welcome-widgets-menus"><?php printf( __( 'Manage <a href="%1$s">widgets</a> or <a href="%2$s">menus</a>', 'wpsight' ), admin_url( 'widgets.php' ), admin_url( 'nav-menus.php' ) ); ?></div></li>
				</ul>
				
			</div><!-- .welcome-panel-column -->
			
			<div class="welcome-panel-column welcome-panel-last">
			
				<h4><?php _e( 'Get Assistance', 'wpsight' ); ?></h4>
				<p><?php _e( 'Please check your PayPal email inbox for your member account credentials.', 'wpsight' ); ?></p>
				<ul>			
					<li><a href="http://support.wpcasa.com" class="welcome-icon welcome-learn-more" target="_blank"><?php _e( 'Visit our support center', 'wpsight' ); ?></a></li>
				</ul>
			</div><!-- .welcome-panel-column -->
		
		</div>
		
	</div><!-- .welcome-panel-content --><?php

}
