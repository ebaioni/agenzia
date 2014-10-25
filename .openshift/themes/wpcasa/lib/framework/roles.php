<?php
/**
 * Create roles and capabilities
 * for listings agents
 */
 
/**
 * Create roles array
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_roles' ) ) {

	function wpsight_roles() {
	
		$roles = array(
			'listing_admin' => array(
				'id'   => 'listing_admin',
				'name' => __( 'Listing Admin', 'wpsight' ),
				'caps' => array(
					'read' 		   	  		   		    => true,
					'upload_files' 		   	   		    => true,
					'wpsight_add_tax_locations'		    => true,
					'wpsight_edit_tax_locations'	    => true,
					'wpsight_add_tax_types'			    => true,
					'wpsight_edit_tax_types'		    => true,
					'wpsight_add_tax_features'		    => true,
					'wpsight_edit_tax_features'		    => true,
					'wpsight_add_tax_categories'	    => true,
					'wpsight_edit_tax_categories'	    => true,
					'wpsight_edit_listing_title'	    => true,
					'wpsight_edit_listing_description'  => true,
					'wpsight_edit_listing_price'	    => true,
					'wpsight_edit_listing_details' 	    => true,
					'wpsight_edit_listing_id' 	   	    => true,
					'wpsight_edit_listing_location'     => true,
					'wpsight_edit_listing_spaces'	    => true,
					'wpsight_edit_listing_images'	    => true,
					'wpsight_edit_listing_featured'	    => true,
					'wpsight_edit_listing_layout'	    => true,
					'wpsight_edit_profile'			    => true,
					'wpsight_edit_profile_display_name' => true,
					'wpsight_edit_profile_image'	    => true,
					'wpsight_edit_profile_password'	    => true,
			    	'edit_listings'   		   		    => true,
			    	'delete_listings' 		   		    => true,
			    	'publish_listings'   	   		    => true,
			    	'edit_others_listings' 	   		    => true,
			    	'delete_others_listings'   		    => true,
			    	'read_private_listings'    		    => true
				)
			),
			'listing_agent' => array(
				'id'   => 'listing_agent',
				'name' => __( 'Listing Agent', 'wpsight' ),
				'caps' => array(
					'read' 		   	  		   		    => true,
					'upload_files' 		   	   		    => false,
					'wpsight_add_tax_locations'		    => true,
					'wpsight_edit_tax_locations'	    => true,
					'wpsight_add_tax_types'			    => true,
					'wpsight_edit_tax_types'		    => true,
					'wpsight_add_tax_features'		    => true,
					'wpsight_edit_tax_features'		    => true,
					'wpsight_add_tax_categories'	    => true,
					'wpsight_edit_tax_categories'	    => true,
					'wpsight_edit_listing_title'	    => true,
					'wpsight_edit_listing_description'  => true,
					'wpsight_edit_listing_price'	    => true,
					'wpsight_edit_listing_details' 	    => true,
					'wpsight_edit_listing_id' 	   	    => true,
					'wpsight_edit_listing_location'     => true,
					'wpsight_edit_listing_spaces'	    => true,
					'wpsight_edit_listing_images'	    => true,
					'wpsight_edit_listing_featured'	    => true,
					'wpsight_edit_listing_layout'	    => true,
					'wpsight_edit_profile'			    => true,
					'wpsight_edit_profile_display_name' => true,
					'wpsight_edit_profile_image'	    => true,
					'wpsight_edit_profile_password'	    => true,
			    	'edit_listings'   		   		    => true,
			    	'delete_listings' 		   		    => true,
			    	'publish_listings'   	   		    => false,
			    	'edit_others_listings' 	   		    => false,
			    	'delete_others_listings'   		    => false,
			    	'read_private_listings'    		    => false
				)
			),
			'listing_subscriber' => array(
				'id'   => 'listing_subscriber',
				'name' => __( 'Listing Subscriber', 'wpsight' ),
				'caps' => array(
					'read' => true
				)
			)
		);
	
		return apply_filters( 'wpsight_roles', $roles );
	
	}

}

/**
 * Create roles and capabilities
 * for listings agents
 *
 * @since 1.2
 */
 
add_action( 'wpsight_setup', 'wpsight_add_roles' );
 
function wpsight_add_roles() {
	
	// Create roles
	
	foreach( wpsight_roles() as $k => $v ) {
	
		// Get role
		$role = get_role( $v['id'] );
	
		// If role exists, next
		if( ! empty( $role ) )
			continue;
	
		// Add role
		add_role( $v['id'], $v['name'], $v['caps'] );
	}

}

/**
 * Add listing capabilities
 * to admin
 *
 * @since 1.2
 */
 
add_action( 'wpsight_setup', 'wpsight_admin_add_caps' );

function wpsight_admin_add_caps() {
	
	$admin = get_role( 'administrator' );
	
	// Add listings capabilities
	
	$admin->add_cap( 'publish_listings' );
	$admin->add_cap( 'edit_listings' );
	$admin->add_cap( 'edit_others_listings' );
	$admin->add_cap( 'delete_listings' );
	$admin->add_cap( 'delete_others_listings' );
	$admin->add_cap( 'read_private_listings' );
	
	// Check if admin has listing caps
	
	if( isset( $admin->capabilities['edit_listings'] ) ) {
		
		// Add custom capabilities
		
		$admin->add_cap( 'wpsight_add_tax_locations' );
		$admin->add_cap( 'wpsight_edit_tax_locations' );
		$admin->add_cap( 'wpsight_add_tax_types' );
		$admin->add_cap( 'wpsight_edit_tax_types' );
		$admin->add_cap( 'wpsight_add_tax_features' );
		$admin->add_cap( 'wpsight_edit_tax_features' );
		$admin->add_cap( 'wpsight_add_tax_categories' );
		$admin->add_cap( 'wpsight_edit_tax_categories' );
		$admin->add_cap( 'wpsight_edit_listing_title' );
		$admin->add_cap( 'wpsight_edit_listing_description' );
		$admin->add_cap( 'wpsight_edit_listing_price' );
		$admin->add_cap( 'wpsight_edit_listing_details' );
		$admin->add_cap( 'wpsight_edit_listing_id' );
		$admin->add_cap( 'wpsight_edit_listing_location' );
		$admin->add_cap( 'wpsight_edit_listing_spaces' );
		$admin->add_cap( 'wpsight_edit_listing_images' );
		$admin->add_cap( 'wpsight_edit_listing_featured' );
		$admin->add_cap( 'wpsight_edit_listing_layout' );
		$admin->add_cap( 'wpsight_edit_profile'	);
		$admin->add_cap( 'wpsight_edit_profile_display_name' );
		$admin->add_cap( 'wpsight_edit_profile_image' );
		$admin->add_cap( 'wpsight_edit_profile_password' );

	}
	
}

/**
 * Custom user caps mapping
 *
 * @since 1.2
 */

add_filter( 'map_meta_cap', 'wpsight_map_meta_cap', 10, 4 );

function wpsight_map_meta_cap( $caps, $cap, $user_id, $args ) {

	/* If editing, deleting, or reading a listing, get the post and post type object. */
	if ( 'edit_listing' == $cap || 'delete_listing' == $cap || 'read_listing' == $cap ) {
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a listing, assign the required capability. */
	if ( 'edit_listing' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	/* If deleting a listing, assign the required capability. */
	elseif ( 'delete_listing' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	/* If reading a private listing, assign the required capability. */
	elseif ( 'read_listing' == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[] = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}

/**
 * Make sure listing admins can edit
 * and delete images (also from other users)
 *
 * @since 1.3
 * @credit http://wordpress.stackexchange.com/a/57373
 */
 
add_filter( 'user_has_cap', 'wpsight_user_has_cap', 10, 3 );

function wpsight_user_has_cap( $user_caps, $req_cap, $args ) {

	if( ! isset( $args[2] ) )
		return $user_caps;

    $post = get_post( $args[2] );

    if ( ! is_object( $post ) || 'attachment' != $post->post_type )
        return $user_caps;

    if ( 'delete_post' == $args[0] ) {

        if ( ! isset( $user_caps['delete_listings'] ) or ! $user_caps['delete_listings'] )
            return $user_caps;
            
        if ( get_current_user_id() != $post->post_author && ( ! isset( $user_caps['delete_others_listings'] ) or ! $user_caps['delete_others_listings'] ) )
            return $user_caps;

        $user_caps[$req_cap[0]] = true;

    }

    if ( 'edit_post' == $args[0] ) {

        if ( ! isset( $user_caps['edit_listings'] ) or ! $user_caps['edit_listings'] )
            return $user_caps;
            
        if ( get_current_user_id() != $post->post_author && ( ! isset( $user_caps['edit_others_listings'] ) or ! $user_caps['edit_others_listings'] ) )
            return $user_caps;

        $user_caps[$req_cap[0]] = true;

    }

    return $user_caps;

}

/**
 * Limit image gallery to images
 * "Uploaded to this post" for non-admins
 *
 * @since 1.2.2
 */
 
add_action( 'admin_footer-post-new.php', 'wpsight_lock_uploaded' );
add_action( 'admin_footer-post.php', 'wpsight_lock_uploaded' );

function wpsight_lock_uploaded() {

	if( current_user_can( 'manage_options' ) )
		return; ?>

  <script type="text/javascript">
    jQuery(document).on("DOMNodeInserted", function(){
        jQuery('select.attachment-filters').hide();
        // Lock uploads to "Uploaded to this post"
        jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
    });
  </script>
<?php }

/**
 * Show admins, listing admins and
 * agents in author meta box on property
 * and attachment edit screens
 *
 * @since 1.3
 */

add_action( 'admin_menu', 'wpsight_author_meta_boxes' );
 
function wpsight_author_meta_boxes() {

	if( ! current_user_can( 'edit_others_listings' ) )
		return;

	remove_meta_box( 'authordiv', 'property', 'normal' );
	add_meta_box( 'wpsight_authordiv', __( 'Author', 'wpsight' ), 'wpsight_post_author_meta_box', 'property', 'normal', 'core' );
	remove_meta_box( 'authordiv', 'attachment', 'normal' );
	add_meta_box( 'wpsight_authordiv', __( 'Author', 'wpsight' ), 'wpsight_post_author_meta_box', 'attachment', 'normal', 'core' );

}
 
function wpsight_post_author_meta_box( $post ) {
 
	global $user_ID;
	
	$admins_query = new WP_User_Query( array( 'role' => 'administrator' ) );
	$admins = $admins_query->get_results();
	
	$listing_admins = new WP_User_Query( array( 'role' => 'listing_admin' ) );
	$listing_admins = $listing_admins->get_results();
	
	$listing_agents = new WP_User_Query( array( 'role' => 'listing_agent' ) );
	$listing_agents = $listing_agents->get_results();
	
	$authors = array_merge( $admins, $listing_admins, $listing_agents );
	
	$include = array();
	
	foreach( $authors as $author )
		$include[] = $author->ID;
		
	$includes = implode( ',', $include ); ?>
	
	<label class="screen-reader-text" for="post_author_override"><?php _e( 'Author', 'wpsight' ); ?></label>
	<?php
	wp_dropdown_users( array(
		'include' 		   => $includes,
		'name' 			   => 'post_author_override',
		'selected' 		   => empty($post->ID) ? $user_ID : $post->post_author,
		'include_selected' => true
	) );
}