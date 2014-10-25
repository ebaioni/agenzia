<?php
/**
 * Manage listing agents
 *
 * @package wpSight
 */
 
/**
 * Display author/listing agent information
 * depending on location
 *
 * @package wpSight
 * @since 1.2
 */
 
add_action( 'wpsight_listing_agent', 'wpsight_do_listing_agent', 10, 3 );

function wpsight_do_listing_agent( $location = false, $widget = false, $instance = false ) {
	 
	/**
	 * Check location and set
	 * $args accordingly
	 */
	 
	if( $location == 'archive' ) {	
	
		// Set agent ID
		
		$agent 	  = get_userdata( get_query_var( 'author' ) );
		$agent_id = $agent->ID;
		
		// Set contact link
		$contact_link = is_pagetemplate_active( 'page-tpl-contact.php' ) ? add_query_arg( array( apply_filters( 'wpsight_author_slug', 'agent' ) => $agent_id ), get_pagetemplate_permalink( 'page-tpl-contact.php' ) ) : false;
		
		// Set $args
		
		$args = array(
		    'title'  => $agent->display_name,
		    'contact'=> $contact_link,
		    'image'  => array(
		    	'show' 	 => true,
		    	'align'  => 'right',
		    	'linked' => true
		    ),
		    'bio' 	 => true,
		    'email'  => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-envelope"></i> ',
		    	'linked' => true
		    ),
		    'url' 	 => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-external-link"></i> ',
		    	'linked' => true
		    ),
		    'custom' => array(
		    	'fields' => wpsight_profile_contact_fields( $location ),
		    	'icon' 	 => true,
		    	'linked' => true
		    ),
		    'button' => false
		);
		
		$args = apply_filters( 'wpsight_listing_agent_info_args_archive', $args, $agent_id );
		
	} elseif( $location == 'listing' ) {
		
		// Set agent ID
		$agent_id = get_the_author_meta( 'ID' );
		
		// Set $args
		
		$args = array(
		    'title'  => get_the_author(),
		    'image'  => array(
		    	'show' 	 => true,
		    	'align'  => 'left',
		    	'linked' => true
		    ),
		    'bio' 	 => true,
		    'email'  => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-envelope"></i> ',
		    	'linked' => true
		    ),
		    'url' 	 => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-external-link"></i> ',
		    	'linked' => true
		    ),
		    'custom' => array(
		    	'fields' => wpsight_profile_contact_fields( $location ),
		    	'icon' 	 => true,
		    	'linked' => true
		    ),
		    'button' => true
		);
		
		$args = apply_filters( 'wpsight_listing_agent_info_args_listing', $args, $widget, $instance, $agent_id );
		
	} elseif( $location == 'featured' ) {
		
		// Set agent ID
		$agent_id = $instance['agent'];
		
		// Set $args
		
		$args = array(
		    'title'  => false,
		    'image'  => array(
		    	'show' 	 => true,
		    	'align'  => 'left',
		    	'linked' => true
		    ),
		    'bio' 	 => true,
		    'email'  => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-envelope"></i> ',
		    	'linked' => true
		    ),
		    'url' 	 => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-external-link"></i> ',
		    	'linked' => true
		    ),
		    'custom' => array(
		    	'fields' => wpsight_profile_contact_fields( $location ),
		    	'icon' 	 => true,
		    	'linked' => true
		    ),
		    'button' => true
		);
		
		$args = apply_filters( 'wpsight_listing_agent_info_args_featured', $args, $widget, $instance, $agent_id );
		
	} elseif( $location == 'list' ) {
		
		// Set agent ID
		global $agent_id;
		
		// Set $args
		
		$args = array(
		    'title'  => true,
		    'image'  => array(
		    	'show' 	 => true,
		    	'align'  => 'left',
		    	'linked' => true
		    ),
		    'bio' 	 => true,
		    'email'  => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-envelope"></i> ',
		    	'linked' => true
		    ),
		    'url' 	 => array(
		    	'show' 	 => true,
		    	'icon' 	 => '<i class="icon-external-link"></i> ',
		    	'linked' => true
		    ),
		    'custom' => array(
		    	'fields' => wpsight_profile_contact_fields( $location ),
		    	'icon' 	 => true,
		    	'linked' => true
		    ),
		    'button' => true
		);
		
		$args = apply_filters( 'wpsight_listing_agent_info_args_list', $args, $agent_id );
		
	}
	
	$args = apply_filters( 'wpsight_listing_agent_info_args', $args );
	
	// Extract $args
	extract( $args, EXTR_SKIP );
	
	// Create listing agent info
	
	$listing_agent = '<div class="listing-agent listing-agent-' . $agent_id . ' author-info clearfix">';
	
	if( $title && ! is_singular() ) {
	
	    $listing_agent .= '<div class="title title-author clearfix">';
	    $listing_agent .= '<h2>' . $title . '</h2>';
	    
	    if( isset( $contact ) && $contact != false ) {
	    
	    	$listing_agent .= '<div class="title-actions title-actions-contact">' . "\n";
			$listing_agent .= '<a href="' . $contact_link . '" class="btn btn-mini"><i class="icon-envelope-alt"></i>' . __( 'Contact', 'wpsight' ) . '</a>' . "\n";
			$listing_agent .= '</div>' . "\n";
		
		}
	    
	    $listing_agent .= '</div><!-- .title -->';
	
	}			
	    
	// Get profile image or avatar
	
	if( $image['show'] == true ) {
	
	    $author_image = get_the_author_meta( 'profile_image', $agent_id );
	    				
	    if( ! empty( $author_image ) ) {					
	    	$agent_image = '<img src="' . $author_image['url'] . '" class="avatar avatar-align-' . $image['align'] . '" />';
	    } else {						
	    	$agent_image = '<span class="avatar-align-' . $image['align'] . '">' . get_avatar( get_the_author_meta( 'email', $agent_id ), '80' ) . '</span>';
	    }
	    
	    if( $image['linked'] == true ) {
	    	$listing_agent .= '<a href="' . get_author_posts_url( $agent_id ) . '" title="' . __( 'See my listings', 'wpsight' ) . '" class="avatar-wrap avatar-wrap-align-' . $image['align'] . '">';
	    } else {
	    	$listing_agent .= '<div class="avatar-wrap avatar-wrap-align-' . $image['align'] . '">';
	    }
	    
	    $listing_agent .= $agent_image;
	    
	    if( $image['linked'] == true ) {
	    	$listing_agent .= '</a><!-- .avatar-wrap -->';
	    } else {
	    	$listing_agent .= '</div><!-- .avatar-wrap -->';
	    }
	
	}
	
	// Put text next to image in extra div
	
	$listing_agent .= '<div class="listing-agent-info">';
	
	// Display agent name on agent list
	
	if( $title && $location == 'list' )
	    $listing_agent .= '<h2>' . get_the_author_meta( 'display_name', $agent_id ) . '</h2>';
	
	// Get profile description/bio
	
	if( $bio == true ) {
	
	    $listing_agent .= '<div class="listing-agent-bio">';
	    
	    $listing_agent .= wpsight_format_content( get_the_author_meta( 'description', $agent_id ) );
	    $listing_agent .= '</div><!-- .listing-agent-bio -->';
	
	}
	
	// Get profile contact email
	
	if( $email['show'] == true ) {
	
	    $agent_email = get_the_author_meta( 'email', $agent_id );
	    
	    if( ! empty( $agent_email ) ) {
	
	    	$listing_agent .= '<div class="listing-agent-email">';
	    	
	    	if( ! empty( $email['icon'] ) )
	    		$listing_agent .= $email['icon'];
	    		
	    	$listing_agent .= '<strong>' . __( 'Email', 'wpsight' ) . ':</strong> ';
	    	
	    	if( $email['linked'] == true )
	    		$listing_agent .= '<a href="mailto:' . antispambot( $agent_email ) . '">';
	    		
	    	$listing_agent .= antispambot( $agent_email );
	    	
	    	if( $email['linked'] == true )
	    		$listing_agent .= '</a>';
	    		
	    	$listing_agent .= '</div><!-- .listing-agent-email -->';
	    
	    }
	
	}
	
	// Get profile contact website
	
	if( $url['show'] == true ) {
	
	    $agent_url = get_the_author_meta( 'url', $agent_id );
	    
	    if( ! empty( $agent_url ) ) {
	
	    	$listing_agent .= '<div class="listing-agent-url">';
	    	
	    	if( ! empty( $url['icon'] ) )
	    		$listing_agent .= $url['icon'];
	    		
	    	$listing_agent .= '<strong>' . __( 'Website', 'wpsight' ) . ':</strong> ';
	    	
	    	if( $url['linked'] == true )
	    		$listing_agent .= '<a href="' . $agent_url . '" target="_blank">';
	    		
	    	$listing_agent .= $agent_url;
	    	
	    	if( $email['linked'] == true )
	    		$listing_agent .= '</a>';
	    		
	    	$listing_agent .= '</div><!-- .listing-agent-url -->';
	    
	    }
	
	}
	
	// Get profile contact custom fields
	
	foreach( $custom['fields'] as $k => $v ) {
	
	    $agent_meta = get_the_author_meta( $k, $agent_id );
	
	    if( ! empty( $agent_meta ) ) {
	
	    	$listing_agent .= '<div class="listing-agent-' . $k . '">';
	    	
	    	if( ! empty( $v['icon'] ) && $custom['icon'] !== false )
	    		$listing_agent .= $v['icon'];
	    		
	    	$listing_agent .= '<strong>' . $v['label'] . ':</strong> ';
	    	
	    	if( $custom['linked'] == true && $v['url'] != false ) {
	    	
	    		$url = $v['url'] . $agent_meta;	    			
	    		
	    		if( $v['url'] === true )
	    			$url = $agent_meta;
	    	
	    		$listing_agent .= '<a href="' . $url . '" target="_blank">';
	    	}
	    		
	    	$listing_agent .= $agent_meta;
	    		
	    	if( $custom['linked'] == true && $v['url'] != false )
	    		$listing_agent .= '</a>';
	    	
	    	$listing_agent .= '</div><!-- .listing-agent-' . $k . ' -->';
	    
	    }
	
	}
	
	// Add link to profile for admins
	
	if( current_user_can( 'edit_users' ) ) {
	
		$listing_agent .= '<div class="listing-agent-profile">';
		$listing_agent .= '<i class="icon-user"></i> <strong>' . __ ( 'Admin', 'wpsight' ) . ':</strong> ';
		$listing_agent .= '<a href="' . admin_url( 'user-edit.php?user_id=' . $agent_id, is_ssl() ? 'https' : 'http' ) . '" class="wpsight-listing-agent-profile">' . __ ( 'See profile', 'wpsight' ) . '</a>';
		$listing_agent .= '</div><!-- .listing-agent-profile -->';
	
	}
	
	// Create author archive button
	
	if( $button == true && ! is_author() ) {
	
	    $listing_agent .= '<a href="' . get_author_posts_url( $agent_id ) . '" class="' . apply_filters( 'wpsight_button_class_agent', 'btn' ) . '">';
	    $listing_agent .= __( 'See my listings', 'wpsight' );
	    $listing_agent .= '</a>';
	
	}
	
	// Put text next to image in extra div
	
	$listing_agent .= '</div><!-- .listing-agent-info -->';
	
	// Create listing agent info
	
	$listing_agent .= '</div><!-- .listing-agent -->';
	
	// Filter and output
	
	echo apply_filters( 'wpsight_listing_agent_info', $listing_agent );

}
 
/**
 * Author template
 *
 * Limit author and search archive to listings
 * when stype (default WP search) not set.
 *
 * @since 1.0
 */

add_filter( 'pre_get_posts', 'wpsight_author_listings' );

function wpsight_author_listings( $query ) {

	if( is_admin() )
		return;

    if ( $query->is_author || ( $query->is_search && ! isset( $_GET['stype'] ) ) )
    	$query->set( 'post_type', array( wpsight_listing_post_type() ) );

}

/**
 * Author permalinks
 *
 * Customize author base and
 * set default to agent
 *
 * @since 1.0
 * @author Jeff Farthing
 * @credit http://www.jfarthing.com/wordpress-plugins/custom-author-base
 */
 
add_action( 'init', 'wpsight_author_rewrite' );

function wpsight_author_rewrite() {

	global $wp_rewrite;
	$author_base = get_option( 'author_base' );
	$wp_rewrite->author_base = empty( $author_base ) ? apply_filters( 'wpsight_author_slug', 'agent' ) : $author_base;
	
}

// Add author base to permalink settings
 
add_action( 'load-options-permalink.php', 'wpsight_author_permalink_options' );
 
function wpsight_author_permalink_options() {

	if ( isset( $_POST['author_base'] ) ) {
	
		$author_base = $_POST['author_base'];
		
		if ( !empty( $author_base ) )
			$author_base = preg_replace( '#/+#', '/', '/' . $author_base );
			
		wpsight_set_author_base( $author_base );
	}

	add_settings_field( 'author_base', __( 'Author base', 'wpsight'  ), 'wpsight_author_settings_field', 'permalink', 'optional', array( 'label_for' => 'author_base' ) );
	
}

// Displays author base settings field
 
function wpsight_author_settings_field() {

	$author_option = get_option( 'author_base' );
	$author_base = empty( $author_option ) ? apply_filters( 'wpsight_author_slug', 'agent' ) : $author_option;
	echo '<input name="author_base" id="author_base" type="text" value="' . esc_attr( $author_base ) . '" class="regular-text code" />';
	
}

// Set the base for the author permalink
 
add_filter( 'option_author_base', '_wp_filter_taxonomy_base' );

function wpsight_set_author_base( $author_base ) {

	global $wp_rewrite;

	if ( $author_base != $wp_rewrite->author_base ) {
		update_option( 'author_base', $author_base );
		$wp_rewrite->init();
		$wp_rewrite->author_base = empty( $author_base ) ? apply_filters( 'wpsight_author_slug', 'agent' ) : $author_base;
	}
}
