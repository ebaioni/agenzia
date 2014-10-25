<?php
/**
 * Helper function to replace
 * the_content filter
 *
 * @since 1.3
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_format_content' ) ) {

	function wpsight_format_content( $content ) {
	
		if( ! $content )
			return;
			
		$content = do_shortcode( shortcode_unautop( wpautop( convert_chars( convert_smilies( wptexturize( $content ) ) ) ) ) );
		
		return apply_filters( 'wpsight_format_content', $content );
	
	}

}

/**
 * Helper function to convert
 * underscores into dashes
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_dashes' ) ) {

	function wpsight_dashes( $string ) {
	
		$string = str_replace( '_', '-', $string );
		
		return $string;
	
	}

}

/**
 * Helper function to convert
 * dashes into underscores
 *
 * @since 1.3.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_underscores' ) ) {

	function wpsight_underscores( $string ) {
	
		$string = str_replace( '-', '_', $string );
		
		return $string;
	
	}

}

/**
 * Helper function to get correct widget
 * areas (wpCasa: property instead of listing)
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_sidebar' ) ) {

	function wpsight_get_sidebar( $area ) {
	
		if( WPSIGHT_DOMAIN == 'wpcasa' )
			$area = str_replace( 'listing', 'property', $area );
		
		return $area;
	
	}

}

/**
 * Helper functions to check if a
 * special page template is active
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'is_pagetemplate_active' ) ) {

	function is_pagetemplate_active( $pagetemplate = '' ) {

	    global $wpdb;
	    
		$results = $wpdb->query( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s", '_wp_page_template', $pagetemplate ) );

	    if ( $results )
	        return true;

        return false;
	}

}


/**
 * Helper function to get the
 * permalink of a page template
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'get_pagetemplate_permalink' ) ) {

	function get_pagetemplate_permalink( $pagetemplate = '' ) {

	    global $wpdb;
	    
	    $results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s", '_wp_page_template', $pagetemplate ) );
	
	    if ( $results )
	        return get_permalink( $results[0]->post_id );
	        
		return false;
	}

}

/**
 * Helper function to
 * check multi-dimensional arrays
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'array_empty' ) ) {

	function array_empty( $mixed ) {
	    if ( is_array( $mixed ) ) {
	        foreach ( $mixed as $value ) {
	            if ( ! array_empty( $value ) ) {
	                return false;
	            }
	        }
	    }
	    elseif ( ! empty( $mixed ) ) {
	        return false;
	    }
	    return true;
	}

}

// Make function pluggable/overwritable
if ( ! function_exists( 'in_multiarray' ) ) {

	function in_multiarray( $elem, $array ) {

	    // if the $array is an array or is an object
	     if( is_array( $array ) || is_object( $array ) )
	     {
	         // if $elem is in $array object
	         if( is_object( $array ) )
	         {
	             $temp_array = get_object_vars( $array );
	             if( in_array( $elem, $temp_array ) )
	                 return TRUE;
	         }
	       
	         // if $elem is in $array return true
	         if( is_array( $array ) && in_array( $elem, $array ) )
	             return TRUE;
	           
	       
	         // if $elem isn't in $array, then check foreach element
	         foreach( $array as $array_element )
	         {
	             // if $array_element is an array or is an object call the in_multiarray function to this element
	             // if in_multiarray returns TRUE, than the element is in array, else check next element
	             if( ( is_array( $array_element ) || is_object( $array_element ) ) && in_multiarray( $elem, $array_element ) )
	             {
	                 return TRUE;
	                 exit;
	             }
	         }
	     }
	   
	     // if isn't in array return FALSE
	     return FALSE;
	}

}

/**
 * Helper function to
 * sort array by position key
 *
 * @since 1.1
 * @docs http://docs.php.net/manual/en/function.array-multisort.php
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_sort_array_by_position' ) ) {

	function wpsight_sort_array_by_position( $array = array(), $order = SORT_NUMERIC ) {
	
		if( ! is_array( $array ) )
			return;
	
		// Sort array by position
	        
	    $position = array();
	    
		foreach ( $array as $key => $row ) {
			
			if( empty( $row['position'] ) )
				$row['position'] = 1000;
			
			$position[$key] = $row['position'];
		}
		
		array_multisort( $position, $order, $array );
		
		return $array;
	
	}

}

/**
 * Helper functions to return taxonomy
 * terms ordered by hierarchy
 *
 * @since 1.2
 * @credit http://pluginus.net/get-the-term-list-ordered-by-hierarchy/
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_the_term_list' ) ) {

	function wpsight_get_the_term_list( $post_id, $taxonomy, $sep = ' &rsaquo; ', $term_before = '', $term_after = '', $linked = 'true', $reverse = false ) {
	
		// Rename listing type for wpCasa
			
		if( WPSIGHT_DOMAIN == 'wpcasa' && $taxonomy == 'listing-type' )
			$taxonomy = 'property-type';
	
		// Check taxonomy
		if( ! taxonomy_exists( $taxonomy ) )
			return;
	
	    $object_terms = get_the_terms( $post_id, $taxonomy );
	    
	    // If there are more than one terms, sort them
	    
		if( count( $object_terms ) > 1 ) {
	    
	    	$parents_assembled_array = array();
	    	
	    	if ( ! empty( $object_terms ) ) {
	    	    foreach ( $object_terms as $term ) {	        	
	    	        $parents_assembled_array[$term->parent][] = $term;
	    	    }
	    	}
	    	
	    	$object_terms = wpsight_sort_taxonomies_by_parents( $parents_assembled_array );
	    
	    }

		// Create terms list
	    $term_list = wpsight_get_the_term_list_links( $taxonomy, $object_terms, $term_before, $term_after, $linked );
	    
	    // Reorder if required
	    if ( $reverse )
	        $term_list = array_reverse( $term_list );
	
	    $result = implode( $sep, $term_list );
	
	    return $result;
	}

}

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_sort_taxonomies_by_parents' ) ) {

	function wpsight_sort_taxonomies_by_parents( $data, $parent_id = 0 ) {
	
	    if ( isset( $data[$parent_id] ) ) {
	
	        if ( ! empty( $data[$parent_id] ) ) {
	            foreach ( $data[$parent_id] as $key => $taxonomy_object ) {
	                if ( isset( $data[$taxonomy_object->term_id] ) ) {
	                    $data[$parent_id][$key]->childs = wpsight_sort_taxonomies_by_parents( $data, $taxonomy_object->term_id );
	                }
	            }
	            return $data[$parent_id];
	        }
	    }
	
	    return array();
	}

}

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_the_term_list_links' ) ) {

	function wpsight_get_the_term_list_links( $taxonomy, $data, $term_before = '', $term_after = '', $linked = 'true' ) {
		
		$result = array();
		
	    if ( ! empty( $data ) ) {
	
	        foreach ( $data as $term ) {
	        
	        	if( $linked != 'false' ) {
	            	$result[] = $term_before . '<a rel="tag" class="listing-term listing-term-' . $term->slug . '" href="' . get_term_link( $term->slug, $taxonomy ) . '">' . $term->name . '</a>' . $term_after;
	            } else {
	            	$result[] = $term_before . '<span class="listing-term listing-term-' . $term->slug . '">' . $term->name . '</span>' . $term_after;
	            }
	            
	            if ( ! empty( $term->childs ) ) {
	
	                $res = wpsight_get_the_term_list_links( $taxonomy, $term->childs, $term_before, $term_after, $linked );
	                
	                if ( ! empty( $res ) ) {
	
	                    foreach ($res as $val) {
	                        if (!is_array($val)) {
	                            $result[] = $val;
	                        }
	                    } // endforeach
	
	                } // endif
	
	            } // endif
	
	        } // endforeach
	
	    } // endif
	
	    return $result;
	}

}
        

/**
 * Implode an array with the key and value pair
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_implode_array' ) ) {

	function wpsight_implode_array( $glue, $arr ) {
	
	   	$arr_keys   = array_keys( $arr ); 
	   	$arr_values = array_values( $arr );
	   	
	   	$keys 	= implode( $glue, $arr_keys );
	   	$values = implode( $glue, $arr_values );
	
	   	return( $keys . $glue . $values ); 
	
	}

}

/**
 * Explode string to associative array
 *
 * @since 1.0
 */
 
// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_explode_array' ) ) {

	function wpsight_explode_array( $glue, $str ) {
	 
	   	$arr  = explode( $glue, $str );
	   	$size = count( $arr ); 
	
	   	for ( $i=0; $i < $size/2; $i++ ) 
	   	    $out[$arr[$i]] = $arr[$i+($size/2)]; 
	   	
	   	return( $out ); 
	}

}

/**
 * Remove recent comments inline CSS
 *
 * @since 1.0
 */
 
add_action( 'widgets_init', 'wpsight_remove_recent_comments_style' );

function wpsight_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'  ) );
}

/**
 * Remove image dimensions from post
 * thumbnail for responsive layout.
 *
 * @since 1.0
 */

add_filter( 'post_thumbnail_html', 'wpsight_remove_thumbnail_dimensions' );
add_filter( 'image_send_to_editor', 'wpsight_remove_thumbnail_dimensions' );

function wpsight_remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

/**
 * If empty post title, display
 * [Untitled].
 *
 * @since 1.0
 */
 
add_filter( 'the_title', 'wpsight_empty_post_title' );

function wpsight_empty_post_title( $title ) {
	
	if( empty( $title ) )
		$title = apply_filters( 'wpsight_empty_post_title', '[' . __( 'Untitled', 'wpsight' ) . ']' );
		
	return $title;
}

/**
 * Enable iframes and videos for slider
 *
 * @since 1.0
 */
 
global $allowedposttags;

$allowedposttags["iframe"] = array(
 	"src" => array(),
 	"height" => array(),
 	"width" => array()
);

$allowedposttags["object"] = array(
 	"height" => array(),
 	"width" => array()
);

$allowedposttags["param"] = array(
 	"name" => array(),
 	"value" => array()
);

$allowedposttags["embed"] = array(
 	"src" => array(),
 	"type" => array(),
 	"allowfullscreen" => array(),
 	"allowscriptaccess" => array(),
 	"height" => array(),
 	"width" => array()
);

/**
 * Exclude pages from search
 *
 * @since 1.0
 */
 
add_filter( 'pre_get_posts', 'wpsight_search_filter' );
 
function wpsight_search_filter( $query ) {

    if ( ! $query->is_admin && $query->is_search ) {
    
    	$post_types = apply_filters( 'wpsight_search_post_types', array( 'post' ) );
    	
    	if( is_array( $post_types ) )
    		$query->set( 'post_type', $post_types );
        
    }
    return $query;
}

/**
 * Remove 10px extra margin from
 * image caption shortcode
 *
 * @since 1.0
 */
 
add_filter( 'img_caption_shortcode', 'wpsight_fix_caption_shortcode', 10, 3 );

function wpsight_fix_caption_shortcode( $x = null, $attr, $content ) {

        extract(shortcode_atts(array(
                'id'    => '',
                'align'    => 'alignnone',
                'width'    => '',
                'caption' => ''
            ), $attr));

        if ( 1 > (int) $width || empty( $caption ) ) {
            return $content;
        }

        if ( $id ) $id = 'id="' . $id . '" ';

    return '<div ' . $id . 'class="wp-caption ' . $align . '" style="width: ' . ( (int) $width ) . 'px">'
    . $content . '<p class="wp-caption-text">' . $caption . '</p></div>';
    
}

/**
 * WPMU signup page
 *
 * @since 1.0
 */
 
add_action( 'before_signup_form', 'wpsight_before_signup' );

function wpsight_before_signup() {
	
	// Open layout wrap
	wpsight_layout_wrap( 'main-middle-wrap' ); 
	
	echo '<div id="main-middle" class="row"><div class="span12">';
}

add_action( 'after_signup_form', 'wpsight_after_signup' );

function wpsight_after_signup() {
	
	echo '</div></div><!-- #main-middle -->';

	// Close layout wrap
	wpsight_layout_wrap( 'main-middle-wrap', 'close' );
}

add_action( 'get_header', 'remove_wpmu_style' );

function remove_wpmu_style() {

	remove_action( 'wp_head', 'wpmu_signup_stylesheet' );
	
}

/**
 * Helper function to create unique token
 *
 * @since 1.0
 */
 
function wpsight_nonce( $expires=86400, $str ) {
    return sha1( date( 'Y-m-d', ceil( time() / $expires ) * $expires ) . $str );
}

add_filter( 'tuc_request_update_query_args-' . WPSIGHT_DOMAIN, 'tuc_request_update_query_args' );

function tuc_request_update_query_args( $args ) {

	$args['theme'] = WPSIGHT_DOMAIN;
	$args['token'] = wpsight_nonce( 86400, WPSIGHT_DOMAIN );
	
	return $args;

}

$example_update_checker = new ThemeUpdateChecker(
	WPSIGHT_DOMAIN,
	'http://update.wpcasa.com/api.php'
);

/**
 * Helper function to count posts
 * by user and post type
 *
 * @since 1.1
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_count_user_posts_by_type' ) ) {

	function wpsight_count_user_posts_by_type( $userid, $post_type = 'post' ) {
	
		global $wpdb;
		
		// Author SQL
		$where = get_posts_by_author_sql( $post_type, TRUE, $userid );
		
		// Set SQL query
		$query = "SELECT COUNT(*) FROM $wpdb->posts $where";
		
		// Get count var
		$count = $wpdb->get_var( $query );
		
		return apply_filters( 'get_usernumposts', $count, $userid );
	  
	}

}

/**
 * Pre-select images from this post
 * in WP 3.5 media uploader
 *
 * @since 1.1
 */

add_action( 'admin_footer-post-new.php', 'wpsight_preselect_gallery' );
add_action( 'admin_footer-post.php', 'wpsight_preselect_gallery' );

function wpsight_preselect_gallery() { ?>

<script>
jQuery(function($) {
    var called = 0;
    $('#wpcontent').ajaxStop(function() {
        if ( 0 == called ) {
            $('[value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
            called = 1;
        }
    });
});
</script><?php

}

/**
 * Filter Gravityforms button
 *
 * @since 1.0
 */
 
add_filter( 'gform_submit_button', 'wpsight_form_submit_button', 10, 2 );

function wpsight_form_submit_button( $button, $form ){

	if( $form['button']['type'] != 'text' )
		return;
		
	$class = isset( $form['cssClass'] ) ? ' ' . $form['cssClass'] : false;

    return '<button class="btn btn-block btn-primary' . $class . '" id="gform_submit_button_' . $form["id"] . '"><span>' . $form["button"]["text"] . '</span></button>';

}

/**
 * Media library custom columns
 *
 * @since 1.2
 */
 
add_filter( 'manage_media_columns', 'wpsight_media_column' );

function wpsight_media_column( $cols ) {
	$cols['media_id']  = __( 'ID', 'wpsight' );
	$cols['media_url'] = __( 'URL', 'wpsight' );
	return $cols;
}

add_action( 'manage_media_custom_column', 'wpsight_media_column_value', 10, 2 );

function wpsight_media_column_value( $column_name, $id ) {		
	if ( $column_name == "media_id" )
		echo $id;
	if ( $column_name == "media_url" )
		echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="'. wp_get_attachment_url( $id ). '" />';
}

/**
 * Media library views
 *
 * @since 1.2
 */

add_filter( 'views_upload', 'wpsight_media_custom_views' );

function wpsight_media_custom_views( $views ) {

	global $wpdb, $wp_query, $pagenow;
	
	if( 'upload.php' != $pagenow )
        return;

    if( ! isset( $wp_query->query_vars['s'] ) )
        return $views;

    // Search custom fields for listing ID

    $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
    WHERE meta_value LIKE '%s'
    ", $wp_query->query_vars['s'] ) );
    
    if( ! empty( $post_ids_meta ) && isset( $_GET['s'] ) ) {
    	unset( $views );
    	$_num_posts = (array) wp_count_attachments();
		$_total_posts = array_sum($_num_posts) - $_num_posts['trash'];
		$views['all'] = '<a href="' . $pagenow . '">' . __( 'All', 'wpsight' ) . ' <span class="count">(' . $_total_posts . ')</span></a>';
		$views['found'] = '<a href="' . $pagenow . '?s=' . $_GET['s'] . '" class="current">' . $_GET['s'] . ' <span class="count">(' . $wp_query->found_posts . ')</span></a>';
	}

    return $views;
}

/**
 * Listing views
 *
 * @since 1.2
 */

add_filter( 'views_edit-listing', 'wpsight_listings_custom_views' );
add_filter( 'views_edit-property', 'wpsight_listings_custom_views' );

function wpsight_listings_custom_views( $views ) {

	global $wpdb, $wp_query, $pagenow;
	
	if( 'edit.php' != $pagenow )
        return;
  
    if( empty( $wp_query->query_vars['s'] ) )
        return $views;

    // Search custom fields for listing ID

    $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
    WHERE meta_value LIKE '%s'
    ", $wp_query->query_vars['s'] ) );
    
    if( empty( $post_ids_meta ) )
    	return $views;

}

/**
 * Show listing count
 * in user list
 *
 * @since 1.2
 */
 
add_filter( 'manage_users_columns', 'wpsight_manage_users_columns' );

function wpsight_manage_users_columns( $columns ) {
    $columns['listings_count'] = __('Listings', 'wpsight');
    return $columns;
}

add_action( 'manage_users_custom_column', 'wpsight_manage_users_custom_column', 10, 3 );

function wpsight_manage_users_custom_column( $value, $column_name, $user_id ) {
 
    if( $column_name != 'listings_count' )
        return $value;

    $listings = new WP_Query( array( 'post_type' => wpsight_listing_post_type(), 'author' => $user_id ) );
    $listings_count = '<a href="edit.php?author=' . $user_id . '&post_type=' . wpsight_listing_post_type() . '">' . $listings->found_posts . '</a>';
    
    return $listings_count;
}

/**
 * Helper function to display
 * theme_mods CSS
 *
 * @since 1.2
 */
 
function wpsight_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = false ) {

	$output = '';
	$mod = get_theme_mod( $mod_name );
	
	if ( ! empty( $mod ) ) {
	
	   $output = "\n\t" . sprintf( '%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix ) . "\n";
	   
	   if ( $echo )
	      echo $output;
	}
	
	return $output;

}

/**
 * Helper function to allow
 * DECIMAL precision (hacky)
 *
 * @since 1.2
 */

add_filter( 'get_meta_sql','wpsight_cast_decimal_precision' );

function wpsight_cast_decimal_precision( $sql ) {

    $sql['where'] = str_replace( 'DECIMAL','DECIMAL(10,2)', $sql['where'] );

    return $sql;
}

/**
 * Helper function to remove
 * Photoswipe from Jetpack galleries
 * if carousel is active
 *
 * @since 1.3
 */

add_filter( 'body_class','wpsight_jetpack_carousel_photoswipe' );

function wpsight_jetpack_carousel_photoswipe( $classes ) {

	// Get active Jetpack modules
	$jetpack_modules = get_option( 'jetpack_active_modules' );
	
	if ( class_exists( 'Jetpack', false ) && $jetpack_modules && in_array( 'carousel', $jetpack_modules ) )
		$classes[] = 'wpsight-jp-carousel';
		
	return $classes;

}

/**
 * Helper function to filter
 * Jetpack contact form fields
 *
 * @since 1.3
 */
 
add_filter( 'grunion_contact_form_field_html', 'wpsight_jetpack_contact_form_fields' );

function wpsight_jetpack_contact_form_fields( $r ) {

	if ( strpos( $r, "type='text'" ) !== false || strpos( $r, "<textarea" ) !== false )
		$r = str_replace( "class='", "class='text ", $r );
	
	return $r;

}

/**
 * Helper function to get transients
 *
 * @since 1.3.2
 * @credit https://wordpress.org/plugins/transients-manager/
 */
 
function wpsight_get_transients( $args = array() ) {

    global $wpdb;

    $defaults = array(
    	'offset' => 0,
    	'number' => 1000,
    	'search' => ''
    );

    $args       = wp_parse_args( $args, $defaults );
    $cache_key  = md5( serialize( $args ) );
    $transients = wp_cache_get( $cache_key );

    if( false === $transients ) {

    	$sql = "SELECT * FROM $wpdb->options WHERE option_name LIKE '\_transient\_%' AND option_name NOT LIKE '\_transient\_timeout%'";

    	if( ! empty( $args['search'] ) ) {

    		$search  = esc_sql( $args['search'] );
    		$sql    .= " AND option_name LIKE '%{$search}%'";

    	}

    	$offset = absint( $args['offset'] );
    	$number = absint( $args['number'] );
    	$sql .= " ORDER BY option_id DESC LIMIT $offset,$number;";

    	$transients = $wpdb->get_results( $sql );

    	wp_cache_set( $cache_key, $transients, '', 3600 );

    }

    return $transients;

}

/**
 * Helper function to get transient name
 *
 * @since 1.3.2
 * @credit https://wordpress.org/plugins/transients-manager/
 */

function wpsight_get_transient_name( $transient ) {

    return substr( $transient->option_name, 11, strlen( $transient->option_name ) );

}

/**
 * Delete query transients
 *
 * @since 1.3.1.1
 */

add_action( 'transition_post_status',  'wpsight_transients_delete_queries', 10, 3 );

function wpsight_transients_delete_queries( $new_status, $old_status, $post ) {

    if ( $new_status == $old_status )
    	return false;

    // Get all query transients	
	$transients = wpsight_get_transients( array( 'search' => 'wpsight_query_' ) );

	foreach( $transients as $t )
		delete_transient( wpsight_get_transient_name( $t ) );
    
}


/**
 * Delete term transients
 *
 * @since 1.3.1.1
 */

add_action( 'created_term', 'wpsight_transients_delete_terms', 10, 3 );
add_action( 'edited_term', 'wpsight_transients_delete_terms', 10, 3 );
add_action( 'delete_term', 'wpsight_transients_delete_terms', 10, 3 );

function wpsight_transients_delete_terms( $term_id, $tt_id, $taxonomy ) {
	
	// Delete terms transient
	delete_transient( 'wpsight_terms_' . $taxonomy );
	
	// Delete taxonomy dropdown transient
	delete_transient( 'wpsight_taxonomy_dropdown_' . $taxonomy );

    
}


class wpSight_Walker_TaxonomyDropdown extends Walker_CategoryDropdown {
 
    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
    
        $pad = str_repeat( '&#45;', $depth );
        $cat_name = apply_filters( 'list_cats', $category->name, $category );
 
        if( ! isset( $args['value'] ) ) {
            $args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
        }
 
        $value = ( $args['value']=='slug' ? $category->slug : $category->term_id );
 
        $output .= "\t<option class=\"level-$depth\" value=\"".$value."\"";
        if ( $value === (string) $args['selected'] ){ 
            $output .= ' selected="selected"';
        }
        $output .= '>';
        if( ! empty( $pad ) )
        	$pad = $pad . ' ';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;('. $category->count .')';
 
        $output .= "</option>\n";

	}
 
}

add_filter( 'wp_dropdown_cats', 'wpsight_wp_dropdown_cats', 20 );

function wpsight_wp_dropdown_cats( $output ) {
        
	$output = str_replace( "value='-1'", "value=''", $output );
	
	return $output;

}
