<?php
/**
 * Add theme listing features
 *
 * @since 1.2
 */

add_action( 'wpsight_setup', 'wpsight_theme_support_listings' );
 
function wpsight_theme_support_listings() {

	// Add listing images meta box
	add_theme_support( 'listing-images' );
	
	// Add listing price meta box
	add_theme_support( 'listing-price' );
	
	// Add listing details meta box
	add_theme_support( 'listing-details' );
	
	// Add listing location meta box
	add_theme_support( 'listing-location' );
	
	// Add listing layout meta box
	add_theme_support( 'listing-layout' );
	
	// Add listing spaces meta box
	add_theme_support( 'listing-spaces' );

}

/**
 * Add listing title actions on single listing pages to
 * wpsight_listing_title_inside hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_title_inside', 'wpsight_do_listing_title_actions', 10, 2 );

function wpsight_do_listing_title_actions( $args = false, $instance = false ) {

	// Only on single listing page
	if( ! is_listing_single() )
		return;
	
	// Stop if no link is enabled	
	if( ! $instance['title_favorites'] && ! $instance['title_print'] )
		return;
		
	$wpsight_do_listing_title_actions_labels = array(
		'favorites_add' => __( 'Save', 'wpsight' ),
		'favorites_see' => __( 'Favorites', 'wpsight' ),
		'print' 		=> __( 'Print', 'wpsight' )
	);
	
	$wpsight_do_listing_title_actions_labels = apply_filters( 'wpsight_do_listing_title_actions_labels', $wpsight_do_listing_title_actions_labels );
	
	// Check if listings are still published
	
	$favorites_removed = array();
	
	if( isset( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) ) {
	
		$favorites = explode( ',', $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ); 
		
		foreach( $favorites as $favorite ) {
			if( get_post_status( $favorite ) != 'publish' )
				$favorites_removed[] = $favorite;
		}
	
	} ?>
		
	<script type="text/javascript">
	    jQuery(document).ready(function($){	   
	    	
	    	var cookie_favs = '<?php echo WPSIGHT_COOKIE_FAVORITES; ?>';
	    	
	    	var removeValue = function(list, value) {
			  var values = list.split(",");
			  for(var i = 0 ; i < values.length ; i++) {
			    if(values[i] == value) {
			      values.splice(i, 1);
			      return values.join(",");
			    }
			  }
			  return list;
			}; <?php
			
			// Remove unpublished listings from cookie
			
			if( ! array_empty( $favorites_removed ) ) {
			
				foreach( $favorites_removed as $favorite_removed ) {
					echo 'var favs = removeValue($.cookie(cookie_favs), ' . $favorite_removed . ');';
				}
				
				echo '$.cookie(cookie_favs, favs,{ expires: 60, path: \'' . COOKIEPATH . '\' });';
			
			} ?>
	    	 	
	    	if($.cookie(cookie_favs)!=null) {
	    		if($.cookie(cookie_favs).search('<?php the_ID(); ?>')!=-1) {
	    			$('.actions-favorites').hide();
	    			$('.actions-favorites-link').show();
	    			if($('.actions-favorites-link small').length == 0) {
	    				$('.actions-favorites-link').append(' <span class="badge badge-important">' + $.cookie(cookie_favs).split(',').length + '</span>');
	    			}
	    		}
	    	}	    	    	
	    	$('.actions-favorites').click(function() {
	    		if($.cookie(cookie_favs)==null || $.cookie(cookie_favs)=='') {
	    			$.cookie(cookie_favs, <?php the_ID(); ?>,{ expires: 60, path: '<?php echo COOKIEPATH; ?>' });
	    		} else {
	    			var fav = $.cookie(cookie_favs);
	    			$.cookie(cookie_favs, fav + ',' + <?php the_ID(); ?>,{ expires: 60, path: '<?php echo COOKIEPATH; ?>' });
	    		}
	    		$(this).fadeOut(150, function() {
	    		  $('.actions-favorites-link').fadeIn(150);
	    		  $('.actions-favorites-link').append(' <span class="badge badge-important">' + $.cookie(cookie_favs).split(',').length + '</span>');
	    		});	    		  				
	    	}); 	    	   			
	    });
	</script>
	
	<div class="title-actions title-actions-fav-print"><?php
	
		if( $instance['title_favorites'] && is_pagetemplate_active( 'page-tpl-favorites.php' ) ) { ?>
		
			<div class="title-actions-favorites">
		    
				<button class="btn btn-mini actions-favorites action-link"><i class="icon-star"></i> <?php echo $wpsight_do_listing_title_actions_labels['favorites_add']; ?></button>
				<a href="<?php echo get_pagetemplate_permalink( 'page-tpl-favorites.php' ); ?>" class="btn btn-mini actions-favorites-link action-link" style="display:none"><i class="icon-star"></i> <?php echo $wpsight_do_listing_title_actions_labels['favorites_see']; ?></a>
			
			</div><?php
		
		}	
		    
		if( $instance['title_print'] ) {
		
			// Set print link
			$title_print_link = apply_filters( 'wpsight_do_listing_title_actions_print_link', add_query_arg( array(  'pid' => get_the_ID(), 'print' => '1' ), get_permalink() ) );
		
		    echo '<div class="title-actions-print"><a href="' . $title_print_link . '" class="btn btn-mini"><i class="icon-print"></i> ' . $wpsight_do_listing_title_actions_labels['print'] . '</a></div>';
		    
		} ?>
    
    </div><!-- .title-actions --><?php
	
}

/**
 * Add listing title actions on single listing pages to
 * wpsight_listing_details_title_inside hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_details_title_inside', 'wpsight_do_listing_details_title_actions', 10, 2 );

function wpsight_do_listing_details_title_actions( $args = '', $instance = '' ) {

	// Only on single listing page
	if( ! is_listing_single() )
		return;
		
	// Get taxonomies
	
	$location = wpsight_get_the_term_list( get_the_ID(), 'location' );
	$type = wpsight_get_the_term_list( get_the_ID() , 'listing-type' );
	
	// Get correct instance settings
	
	if( isset( $instance['listing_type'] ) ) {
		$listing_type = $instance['listing_type'];
	} elseif( isset( $instance['property_type'] ) ) {
		$listing_type = $instance['property_type'];
	} else {
		$listing_type = false;
	}
	
	if( isset( $instance['listing_location'] ) ) {
		$listing_location = $instance['listing_location'];
	} elseif( isset( $instance['property_location'] ) ) {
		$listing_location = $instance['property_location'];
	} else {
		$listing_location = false;
	}
	
	// Display taxonomies in title
	
	$title_actions = '';
					
	if( $listing_type || $listing_location ) {						
	    $title_actions .= '<div class="title-actions">' . "\n";
	    if( $listing_location && ! empty( $location ) )
	    	$title_actions .= '<div class="title-listing-location">' . $location . '</div><!-- .title-listing-location -->' . "\n";
	    if( $listing_type && ! empty( $type ) )
	    	$title_actions .= '<div class="title-listing-type">' . $type . '</div><!-- .title-listing-type -->' . "\n";
	    $title_actions .= '</div><!-- .title-actions -->' . "\n";						
	}
	
	echo $title_actions;
	
}

/**
 * Add single listing contact form jump link to
 * wpsight_listing_agent_title_inside hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_agent_title_inside', 'wpsight_do_listing_agent_title_actions', 10, 2 );

function wpsight_do_listing_agent_title_actions( $args = '', $instance = '' ) {

	// Only on single listing page
	if( ! is_listing_single() )
		return;
		
	// Stop if title link not active
	if ( ! $instance['title_contact'] )
		return;
	
	// Display contact link
	
	$contact_link = apply_filters( 'wpsight_listing_agent_contact_link', '#contact' );
						
	$title_contact  = '<div class="title-actions title-actions-contact">' . "\n";
	$title_contact .= '<a href="' . $contact_link . '" class="btn btn-mini smooth"><i class="icon-envelope-alt"></i> ' . __( 'Contact', 'wpsight' ) . '</a>' . "\n";
	$title_contact .= '</div>' . "\n";
	
	echo apply_filters( 'wpsight_do_listing_agent_title_actions', $title_contact );
	
}

/**
 * Add link to contact form in featured agent widget
 * wpsight_featured_agent_title_inside hook
 *
 * @since 1.2
 */
 
add_action( 'wpsight_featured_agent_title_inside', 'wpsight_do_featured_agent_title_actions', 10, 2 );

function wpsight_do_featured_agent_title_actions( $args = '', $instance = '' ) {

	// Stop if contact form page template not active
	if( ! is_pagetemplate_active( 'page-tpl-contact.php' ) )
		return;
		
	// Stop if title link not active
	if ( ! $instance['title_contact'] )
		return;
	
	// Display contact link
	
	$author_slug  = apply_filters( 'wpsight_author_slug', 'agent' );	
	$contact_link = add_query_arg( array( $author_slug => $instance['agent'] ), get_pagetemplate_permalink( 'page-tpl-contact.php' ) );
	$contact_link = apply_filters( 'wpsight_featured_agent_contact_link', $contact_link );
						
	$title_contact  = '<div class="title-actions title-actions-contact">' . "\n";
	$title_contact .= '<a href="' . $contact_link . '" class="btn btn-mini"><i class="icon-envelope-alt"></i> ' . __( 'Contact', 'wpsight' ) . '</a>' . "\n";
	$title_contact .= '</div>' . "\n";
	
	echo apply_filters( 'wpsight_do_featured_agent_title_actions', $title_contact );
	
}

/**
 * Add featured image to
 * wpsight_post_content_before hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_title_before', 'wpsight_do_listing_image' );
add_action( 'wpsight_widget_listing_title_before', 'wpsight_do_listing_image', 10, 2 );

function wpsight_do_listing_image( $widget_width = '', $widget_location = '' ) {

	// Get post id	
	$post_id = get_the_ID();
	
	if( empty( $post_id ) )
		return;
		
	// Go on if there is a featured image

	if( has_post_thumbnail( get_the_ID() ) ) {
	
		if( ! empty( $widget_width ) ) {
		
			// In case of a widget (lastest properties)
		
			$image_size = wpsight_get_layout_image( 'size_widget' );
			$image_align = wpsight_get_layout_image( 'align_widget' );
			
			// Set image size
	    		
	    	if( $widget_width == wpsight_get_span( 'half' ) )
	    		$image_size = 'half';
	    		
	    	if( $widget_width == wpsight_get_span( 'big' ) )
	    		$image_size = 'big';
	    		
	    	if( $widget_width == wpsight_get_span( 'full' ) )
	    		$image_size = 'full';
			
			if( $widget_width == wpsight_get_span( 'small' ) || $widget_location == 'sidebar' || $widget_location == 'sidebar-home' || $widget_location == 'sidebar-page' || $widget_location == 'sidebar-post' || $widget_location == wpsight_get_sidebar( 'sidebar-listing' ) || $widget_location == wpsight_get_sidebar( 'sidebar-listing-archive' ) )
		    	$image_size = 'post-thumbnail';
	    	
	    	// Remove image align	
	    	$image_align = 'none';
				
			// Limit images to box width and remove align
			
			if( $widget_width == wpsight_get_span( 'half' ) && ( $image_size == 'half' || $image_size == 'big' || $image_size == 'full' ) )
				$image_align = 'none';
				
			if( ( $widget_width == 'full' || $widget_width == wpsight_get_span( 'big' ) ) && ( $image_size == 'full' || $image_size == 'big' ) && $widget_location == 'home' )
				$image_align = 'none';
				
			if( $widget_location == 'sidebar' || $widget_location == 'sidebar-home' || $widget_width == wpsight_get_span( 'small' ) )
				$image_align = 'none';
		
		} else {
	    
	    	// Not in a widget but on archive pages
	    
	    	$image_size = wpsight_get_layout_image( 'size_archive_listings' );
	    	$image_align = wpsight_get_layout_image( 'align_archive_listings' );
	    
			// Get archive layout
			$archive_layout = wpsight_get_archive_layout( 'listing' );
			
			// Correct archive layout depending on sidebars
			
			if( ( $archive_layout == wpsight_get_span( 'half' ) || $archive_layout == wpsight_get_span( 'full' ) ) && is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing-archive' ) ) )
				$archive_layout = wpsight_get_span( 'big' );
				
			if( $archive_layout == wpsight_get_span( 'big' ) && ! is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing-archive' ) ) )
				$archive_layout = wpsight_get_span( 'full' );
	    
	    	// Limit images to box width and remove align
	    	
	    	if( $archive_layout == wpsight_get_span( 'small' ) )
		    	$image_size = 'post-thumbnail';
	    		
	    	if( $archive_layout == wpsight_get_span( 'half' ) )
	    		$image_size = 'half';
	    		
	    	if( $archive_layout == wpsight_get_span( 'big' ) )
	    		$image_size = 'big';
	    		
	    	if( $archive_layout == wpsight_get_span( 'full' ) )
	    		$image_size = 'full';
	    	
	    }
	    
	    // Filter image size	    
	    $image_size = apply_filters( 'wpsight_do_listing_image_size', $image_size );
	    
	    // Filter image align
	    $image_align = apply_filters( 'wpsight_do_listing_image_align', $image_align );
	    
	    // Create optional image overlay	    
	    $overlay = apply_filters( 'wpsight_listing_image_overlay', false );
	    
	    // Remove link for favorites
	    $remove = is_page_template( 'page-tpl-favorites.php' ) && empty( $widget_location ) ? '<span id="' . get_the_ID() . '" class="favorites-remove" title="' . __( 'Remove', 'wpsight' ) . '">' .  __( 'Remove', 'wpsight' ) . '</span>' : '';
	    
	    // Limit image size on properties map	    
	    if( is_page_template( 'page-tpl-map.php' ) )
	    	$image_size = 'post-thumbnail';
	    
	    // Fincally output post image	    
	    $image = '<div class="post-image listing-image align' . $image_align . '"><a href="' . get_permalink( $post_id ) . '">' . get_the_post_thumbnail( $post_id, $image_size, array( 'alt' => the_title_attribute('echo=0'), 'title' => the_title_attribute('echo=0') ) ) . $overlay . $remove . '</a></div><!-- .post-image -->' . "\n";
	    
	    echo $image = preg_replace( '/\s+/', ' ', $image );
	    
	}

}

/**
 * Add listing details overview to
 * wpsight_listing_title_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_title_after', 'wpsight_do_listing_details_overview' );
add_action( 'wpsight_widget_listing_title_after', 'wpsight_do_listing_details_overview', 10, 2 );

function wpsight_do_listing_details_overview( $args = '', $instance = '' ) {
	
	// Stop if on listing single page
	if( is_listing_single() && ! is_page_template( 'page-tpl-listings.php' ) && ! is_page_template( 'page-tpl-properties.php' ) && ! is_page_template( 'page-tpl-favorites.php' ) && ! is_page_template( 'page-tpl-map.php' ) && empty( $instance ) )
		return;
		
	echo preg_replace( '/\s+/', ' ', wpsight_get_listing_details() );
	
}

/**
 * Add status not on listings map with
 * wpsight_listing_title_after hook
 *
 * @since 1.0
 */
 
// add_action( 'wpsight_listing_title_after', 'wpsight_do_listing_map_status' );

function wpsight_do_listing_map_status() {

	// Only on map page template
	if( ! is_page_template( 'page-tpl-map.php' ) )
		return;

	$status = get_post_meta( get_the_ID(), '_price_status', true );
	
	if( ! empty( $status ) )
		echo '<span class="listing-map-status">' . __( 'Status', 'wpsight' ) . ': ' . wpsight_get_listing_status( $status ) . '</span>';
	
}

/**
 * Add address note on listings map with
 * wpsight_listing_title_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_title_after', 'wpsight_do_listing_map_note' );

function wpsight_do_listing_map_note( $location = false ) {

	// Only on map page template
	if( $location != 'map' )
		return;

	$note = get_post_meta( get_the_ID(), '_map_note', true );
	
	if( ! empty( $note ) )
		echo '<div class="listing-address-note alert clear">' . esc_html( $note ) . '</div>';
	
}

/**
 * Add post paging for <!--nextpage--> quicktag to
 * wpsight_post_content_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_content_after', 'wpsight_do_listing_link_pages', 10 );

function wpsight_do_listing_link_pages() {

	// Stop if not on single posts or pages
	if( ! is_singular() || is_page_template( 'page-tpl-blog.php' ) )
		return;

	$args = array(
    	'before'           => '<div class="pagination post-pagination"><ul>',
    	'after'            => '</ul></div>',
    	'link_before'      => '<span>',
    	'link_after'       => '</span>',
    	'next_or_number'   => 'number',
    	'nextpagelink'     => __( 'Next page', 'wpsight' ),
    	'previouspagelink' => __( 'Previous page', 'wpsight' ),
    	'pagelink'         => '%',
    	'echo'             => 0
    );
    
    $args = apply_filters( 'wpsight_do_listing_link_pages_args', $args );
    
    /**
     * Hacky way to create a list of wp_link_pages()
     * Unfortunately you cannot place anything before and after a tags
     */
    
    $output = str_replace( '<a', '<li><a', wp_link_pages( $args ) );
    $output = str_replace( '</a>', '</a></li>', $output );
    $output = str_replace( ' <span>', ' <li class="active"><a href="#">', $output );
    $output = str_replace( '</span> ', '</a></li> ', $output );
    
    echo apply_filters( 'wpsight_do_listing_link_pages', $output );

}

/**
 * Add post navigation to single posts using
 * wpsight_listing_widgets_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_listing_widgets_after', 'wpsight_do_listing_navigation' );

function wpsight_do_listing_navigation() {

	if( ! is_listing_single() )
		return;
		
	$args = array(
		'in_same_cat' => false,
		'excluded_categories' => false
	);
	
	$args = apply_filters( 'wpsight_do_listing_navigation_args', $args );
	
	// Extract $args
	extract( $args, EXTR_SKIP );

	$previous = get_adjacent_post( $in_same_cat, $excluded_categories, false );
	$next = get_adjacent_post( $in_same_cat, $excluded_categories, true );

	if( ! empty( $previous ) || ! empty( $next ) ) {
	
		$navigation = '<div class="post-navigation clearfix">';
		
		if( ! empty( $previous ) )
			$navigation .= '<div class="previous"><a href="' . get_permalink( $previous->ID ) . '" title="">&larr; ' . get_the_title( $previous->ID ) . '</a></div>';
		
		if( ! empty( $next ) )
			$navigation .= '<div class="next"><a href="' . get_permalink( $next->ID ) . '" title="">' . get_the_title( $next->ID ) . ' &rarr;</a></div>';
		
		$navigation .= '</div><!-- .post-pagination -->';
		
		echo apply_filters( 'wpsight_do_listing_navigation', $navigation );
	
	}

}

/**
 * Helper function for listing
 * archive order actions
 *
 * @since 1.1
 */

function wpsight_place_listing_title_order() {

	$order_show = array(
		'search' 	   => true,
		'tax_location' => true,
		'tax_feature'  => true,
		'tax_type' 	   => true,
		'tax_category' => true,
		'templates'    => true,
		'author' 	   => true,
		'archive' 	   => true,
		'favorites'	   => true
	);
	
	if( $order_show['search'] && is_search() && ! isset( $_GET['stype'] ) ) {
		$show = true;
	} elseif( $order_show['tax_location'] && is_tax( 'location' ) ) {
		$show = true;
	} elseif( $order_show['tax_feature'] && is_tax( 'feature' ) ) {
		$show = true;
	} elseif( $order_show['tax_type'] && ( is_tax( 'listing-type' ) || is_tax( 'property-type' ) ) ) {
		$show = true;
	} elseif( $order_show['tax_category'] && ( is_tax( 'listing-category' ) || is_tax( 'property-category' ) ) ) {
		$show = true;
	} elseif( $order_show['templates'] && ( is_page_template( 'page-tpl-listings.php' ) || is_page_template( 'page-tpl-properties.php' ) ) ) {
		$show = true;
	} elseif( $order_show['author'] && is_author() ) {
		$show = true;
	} elseif( $order_show['archive'] && is_post_type_archive( wpsight_listing_post_type() ) ) {
		$show = true;
	} elseif( $order_show['favorites'] && ( is_page_template( 'page-tpl-favorites.php' ) || is_page_template( 'page-tpl-compare.php' ) ) ) {
		$show = true;
	} else {
		$show = false;
	}
	
	$show = apply_filters( 'wpsight_place_listing_title_order', $show );
	
	return $show;

}

/**
 * Add orderby links to listing archives
 *
 * @since 1.0
 */
 
// add_action( 'wpsight_loop_title_actions', 'wpsight_do_listing_archive_order_links', 20 );

function wpsight_do_listing_archive_order_links() {

	if( wpsight_place_listing_title_order() == false )
		return;
	
    $args = array(
    
    	'orderby' => true,
    	'order'   => true,
    	'labels'  => array(	
    		'orderby'	  => _x( 'Order by', 'listing title actions', 'wpsight' ),
    		'date'		  => _x( 'Date', 'listing title actions', 'wpsight' ),
    		'orderby_sep' => _x( 'or', 'listing title actions', 'wpsight' ),
    		'price'		  => _x( 'Price', 'listing title actions', 'wpsight' ),
    		'order'		  => _x( 'Order', 'listing title actions', 'wpsight' ),
    		'desc'		  => _x( 'DESC', 'listing title actions', 'wpsight' ),
    		'order_sep'   => _x( 'or', 'listing title actions', 'wpsight' ),
    		'asc'		  => _x( 'ASC', 'listing title actions', 'wpsight' )		
    	)
    
    );
    
    $args = apply_filters( 'wpsight_listing_title_order_args', $args );
    
    if( $args['orderby'] || $args['order'] ) { ?>

    <div class="title-actions">
    
    	<?php if( $args['orderby'] ) { ?>

    	<div class="title-orderby">
    	
    		<span class="title-orderby-label"><?php echo $args['labels']['orderby']; ?></span>
    		
    		<?php			
    			// Check if order var set
    			if( get_query_var('order') )
    			    $vars_order = array( 'order' => get_query_var('order') );				    
    		?>
    			
    		<span class="title-orderby-date">
    			<a href="<?php echo add_query_arg( array_merge( array( 'orderby' => 'date' ), (array) $vars_order ) ); ?>"><?php echo $args['labels']['date']; ?></a>
    		</span>
    		
    		<span class="title-orderby-separator"><?php echo $args['labels']['orderby_sep']; ?></span>
    		
    		<span class="title-orderby-price">
    			<a href="<?php echo add_query_arg( array_merge( array( 'orderby' => 'price' ), (array) $vars_order ) ); ?>"><?php echo $args['labels']['price']; ?></a>
    		</span>
    		
    	</div><!-- .title-orderby -->
    	
    	<?php } ?>
    	
    	<?php if( $args['order'] ) { ?>
    	
    	<div class="title-order">
    	
    		<span class="title-order-label"><?php echo $args['labels']['order']; ?></span>
    		
    		<?php	
    			// Check if orderby var set
    			$vars_orderby = get_query_var('orderby') == 'price' ? array( 'orderby' => 'price' ) : false;
    		?>
    		
    		<span class="title-order-desc">
    			<a href="<?php echo add_query_arg( array_merge( (array) $vars_orderby, array( 'order' => 'DESC' ) ) ); ?>"><?php echo $args['labels']['desc']; ?></a>
    		</span>
    		
    		<span class="title-order-separator"><?php echo $args['labels']['order_sep']; ?></span>
    		
    		<span class="title-order-asc">
    			<a href="<?php echo add_query_arg( array_merge( (array) $vars_orderby, array( 'order' => 'ASC' ) ) ); ?>"><?php echo $args['labels']['asc']; ?></a>
    		</span>
    		
    	</div><!-- .title-order -->
    	
    	<?php } ?>
    	
    </div><!-- .title-actions --><?php
    
    }

}

/**
 * Add orderby select to listing archives
 *
 * @since 1.2
 */
 
// add_action( 'wpsight_loop_title_actions', 'wpsight_do_listing_archive_order_select', 20 );

function wpsight_do_listing_archive_order_select() {

	if( wpsight_place_listing_title_order() == false )
		return;
	
    $args = array(
    
    	'orderby' => true,
    	'order'   => true,
    	'labels'  => array(	
    		'orderby'	  => _x( 'Order by', 'listing title actions', 'wpsight' ),
    		'date'		  => _x( 'Date', 'listing title actions', 'wpsight' ),
    		'price'		  => _x( 'Price', 'listing title actions', 'wpsight' ),
    		'order'		  => _x( 'Order', 'listing title actions', 'wpsight' ),
    		'desc'		  => _x( 'desc', 'listing title actions', 'wpsight' ),
    		'asc'		  => _x( 'asc', 'listing title actions', 'wpsight' ),
    		'title'		  => _x( 'Title', 'listing title actions', 'wpsight' )
    	)
    
    );
    
    $args = apply_filters( 'wpsight_listing_title_order_args', $args );
    
    if( $args['orderby'] || $args['order'] ) { ?>

    <div class="title-actions title-actions-order">
    
    	<select name="title-order">
    		
    		<option value=""><?php echo $args['labels']['orderby']; ?></option>?>
    		
    		<option<?php if ( get_query_var( 'orderby' ) == 'date' && get_query_var( 'order' ) == 'asc' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( array( 'orderby' => 'date', 'order' => 'asc' ) ); ?>"><?php echo $args['labels']['date']; ?> (<?php echo $args['labels']['asc']; ?>)</option>
    		
    		<option<?php if ( get_query_var( 'orderby' ) == 'date' && get_query_var( 'order' ) == 'desc' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( array( 'orderby' => 'date', 'order' => 'desc' ) ); ?>"><?php echo $args['labels']['date']; ?> (<?php echo $args['labels']['desc']; ?>)</option>
    		
    		<option<?php if ( get_query_var( 'meta_key' ) == '_price' && get_query_var( 'order' ) == 'asc' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( array( 'orderby' => 'price', 'order' => 'asc' ) ); ?>"><?php echo $args['labels']['price']; ?> (<?php echo $args['labels']['asc']; ?>)</option>
    		
    		<option<?php if ( get_query_var( 'meta_key' ) == '_price' && get_query_var( 'order' ) == 'desc' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( array( 'orderby' => 'price', 'order' => 'desc' ) ); ?>"><?php echo $args['labels']['price']; ?> (<?php echo $args['labels']['desc']; ?>)</option>
    		
    		<option<?php if ( get_query_var( 'orderby' ) == 'title' && get_query_var( 'order' ) == 'asc' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( array( 'orderby' => 'title', 'order' => 'asc' ) ); ?>"><?php echo $args['labels']['title']; ?> (<?php echo $args['labels']['asc']; ?>)</option>
    		
    		<option<?php if ( get_query_var( 'orderby' ) == 'title' && get_query_var( 'order' ) == 'desc' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( array( 'orderby' => 'title', 'order' => 'desc' ) ); ?>"><?php echo $args['labels']['title']; ?> (<?php echo $args['labels']['desc']; ?>)</option>
    	
    	</select>
    	
    </div><!-- .title-actions --><?php
    
    }

}

/**
 * Add orderby dropdown links to listing archives
 *
 * @since 1.2
 */
 
add_action( 'wpsight_loop_title_actions', 'wpsight_do_listing_archive_order_dropdown', 20 );

function wpsight_do_listing_archive_order_dropdown( $query = false ) {

	if( wpsight_place_listing_title_order() == false )
		return;
		
	if( is_page_template( 'page-tpl-favorites.php' ) && empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) )
		return;
		
	if( $query != false && $query->found_posts == 0 )
		return;
	
    $args = array(
    
    	'orderby' => true,
    	'order'   => true,
    	'labels'  => array(	
    		'orderby'	  => _x( 'Order by', 'listing title actions', 'wpsight' ),
    		'date'		  => _x( 'Date', 'listing title actions', 'wpsight' ),
    		'price'		  => _x( 'Price', 'listing title actions', 'wpsight' ),
    		'order'		  => _x( 'Order', 'listing title actions', 'wpsight' ),
    		'desc'		  => _x( 'desc', 'listing title actions', 'wpsight' ),
    		'asc'		  => _x( 'asc', 'listing title actions', 'wpsight' ),
    		'title'		  => _x( 'Title', 'listing title actions', 'wpsight' )
    	)
    
    );
    
    $args = apply_filters( 'wpsight_listing_title_order_args', $args );
    
    if( $args['orderby'] || $args['order'] ) { ?>

    <div class="title-actions title-actions-order">
    
		<div class="btn-group">
		  	
		  	<button class="btn btn-mini dropdown-toggle" data-toggle="dropdown"><?php echo $args['labels']['orderby']; ?> <span class="caret"></span></button>
		  
		  	<ul class="dropdown-menu pull-right">
		    	<li><a href="<?php echo add_query_arg( array( 'orderby' => 'date', 'order' => 'asc' ) ); ?>"><?php echo $args['labels']['date']; ?> (<?php echo $args['labels']['asc']; ?>)</a></li>
		    	<li><a href="<?php echo add_query_arg( array( 'orderby' => 'date', 'order' => 'desc' ) ); ?>"><?php echo $args['labels']['date']; ?> (<?php echo $args['labels']['desc']; ?>)</a></li>
		    	<li class="divider"></li>
		    	<li><a href="<?php echo add_query_arg( array( 'orderby' => 'price', 'order' => 'asc' ) ); ?>"><?php echo $args['labels']['price']; ?> (<?php echo $args['labels']['asc']; ?>)</a></li>
		    	<li><a href="<?php echo add_query_arg( array( 'orderby' => 'price', 'order' => 'desc' ) ); ?>"><?php echo $args['labels']['price']; ?> (<?php echo $args['labels']['desc']; ?>)</a></li>
		    	<li class="divider"></li>
		    	<li><a href="<?php echo add_query_arg( array( 'orderby' => 'title', 'order' => 'asc' ) ); ?>"><?php echo $args['labels']['title']; ?> (<?php echo $args['labels']['asc']; ?>)</a></li>
		    	<li><a href="<?php echo add_query_arg( array( 'orderby' => 'title', 'order' => 'desc' ) ); ?>"><?php echo $args['labels']['title']; ?> (<?php echo $args['labels']['desc']; ?>)</a></li>
			</ul>
			
		</div>
    	
    </div><!-- .title-actions --><?php
    
    }

}

/**
 * Helper function for listing
 * search map locations
 *
 * @since 1.1
 */

function wpsight_place_listing_search_map() {

	$map_show = array(
		'search' 	   => true,
		'tax_location' => true,
		'tax_feature'  => true,
		'tax_type' 	   => true,
		'tax_category' => true,
		'templates'    => true,
		'author' 	   => true,
		'archive' 	   => true,
		'favorites'	   => true
	);
	
	if( $map_show['search'] && is_search() && ! isset( $_GET['stype'] ) ) {
		$show = true;
	} elseif( $map_show['tax_location'] && is_tax( 'location' ) ) {
		$show = true;
	} elseif( $map_show['tax_feature'] && is_tax( 'feature' ) ) {
		$show = true;
	} elseif( $map_show['tax_type'] && ( is_tax( 'listing-type' ) || is_tax( 'property-type' ) ) ) {
		$show = true;
	} elseif( $map_show['tax_category'] && ( is_tax( 'listing-category' ) || is_tax( 'property-category' ) ) ) {
		$show = true;
	} elseif( $map_show['templates'] && ( is_page_template( 'page-tpl-listings.php' ) || is_page_template( 'page-tpl-properties.php' ) ) ) {
		$show = true;
	} elseif( $map_show['archive'] && is_post_type_archive( wpsight_listing_post_type() ) ) {
		$show = true;
	} elseif( $map_show['author'] && is_author() ) {
		$show = true;
	} elseif( $map_show['favorites'] && is_page_template( 'page-tpl-favorites.php' ) ) {
		$show = true;
	} else {
		$show = false;
	}
	
	$show = apply_filters( 'wpsight_place_listing_search_map', $show );
	
	return $show;

}

/**
 * Add link to search results on map to
 * wpsight_loop_title_actions
 *
 * @since 1.1
 */
 
add_action( 'wpsight_loop_title_actions', 'wpsight_do_listing_search_map_link', 10 );

function wpsight_do_listing_search_map_link( $query = false ) {

	if( wpsight_place_listing_search_map() == false )
		return;
		
	if( is_page_template( 'page-tpl-favorites.php' ) && empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) )
		return;
		
	if( $query != false && $query->found_posts == 0 )
		return; ?>

	<div class="title-actions title-search-map">
		<button class="btn btn-mini"><i class="icon-map-marker"></i> <?php _e( 'Map', 'wpsight' ); ?></button>
	</div><?php

}

/**
 * Add listing map on search results page via
 * wpsight_listing_archive_title_after hook
 *
 * @since 1.1
 */
 
add_action( 'wpsight_listing_archive_title_after', 'wpsight_do_listing_search_map', 10, 2 );

function wpsight_do_listing_search_map( $args, $content_class ) {
	global $map_query;

	if( wpsight_place_listing_search_map() == false )
		return;
		
	if( is_page_template( 'page-tpl-favorites.php' ) && empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) )
		return;
	
	// Set custom $args
	
	$map_args = array(
		'posts_per_page' => apply_filters( 'wpsight_properties_map_nr', -1 )
	);
	
	// Merge with $args
	$args = wp_parse_args( $map_args, $args );
	
	// Apply filter
	$args = apply_filters( 'wpsight_map_search_query_args', $args );
				
	// Create map query
	$map_query = new WP_Query( $args );
	
	get_template_part( 'loop', 'map' );

}

/**
 * Add link to comparison table to
 * wpsight_loop_title_actions
 *
 * @since 1.2
 */

add_action( 'wpsight_loop_title_actions', 'wpsight_do_listing_favorites_compare_btn' );

function wpsight_do_listing_favorites_compare_btn() {

	if( ! is_page_template( 'page-tpl-favorites.php' ) || empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) )
		return; ?>

	<div class="title-actions title-actions-compare">
		<button id="favorites-compare" class="btn btn-mini"><i class="icon-th"></i> <?php _e( 'Compare', 'wpsight' ); ?></button>
	</div><?php

}

/**
 * Add comparison table on favorites page to
 * wpsight_loop_title_actions
 *
 * @since 1.2
 */
 
add_action( 'wpsight_listing_content_after', 'wpsight_do_listing_favorites_compare' );

function wpsight_do_listing_favorites_compare() {

	if( ! is_page_template( 'page-tpl-favorites.php' ) || empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) )
		return;
		
	echo do_shortcode( '[listing_details_table]' );

}

/**
 * Add link to favorites contact form to
 * wpsight_loop_title_actions
 *
 * @since 1.2
 */
 
add_action( 'wpsight_loop_title_actions', 'wpsight_do_listing_favorites_contact_link', 9 );

function wpsight_do_listing_favorites_contact_link() {

	if( ! is_page_template( 'page-tpl-favorites.php' ) || empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) || ! is_pagetemplate_active( 'page-tpl-contact.php' ) )
		return; ?>

	<div class="title-actions title-actions-contact">
		<a href="<?php echo add_query_arg( array( 'fav' => '1' ), get_pagetemplate_permalink( 'page-tpl-contact.php' ) ); ?>" class="btn btn-mini"><i class="icon-envelope-alt"></i> <?php _e( 'Contact', 'wpsight' ); ?></a>
	</div><?php

}

/**
 * Add listing details in listing slider to
 * wpsight_widget_listings_slider_title_after hook
 *
 * @since 1.0
 */

add_action( 'wpsight_widget_listings_slider_title_after', 'wpsight_do_listings_slider_details', 10, 2 );

function wpsight_do_listings_slider_details( $args = '', $instance = '' ) {
	
	if( $instance['details'] == 0 )
		return;
	
	wpsight_listing_details();
	
}

/**
 * Add listing print top bar to
 * wpsight_listing_print_after hook
 *
 * @since 1.1
 */
 
add_action( 'wpsight_listing_print_after', 'wpsight_do_listing_print_after' );
 
function wpsight_do_listing_print_after( $listing_id ) {

	$id = $listing_id ? $listing_id : get_the_ID(); ?>

	<div id="top-wrap">
	
		<div id="top">
		
			<div id="back">
				<a href="<?php the_permalink( $id ); ?>">&larr; <?php echo do_shortcode( '[listing_title]' ) ?></a>
			</div>
		
			<div id="actions">
				<a href="#" onclick="window.print();return false"><?php _e( 'Print now', 'wpsight' ); ?></a>
			</div>
			
			<div class="clear"></div>
		
		</div><!-- #top -->
	
	</div><!-- #top-wrap --><?php

}

/**
 * Add listing print logo to
 * wpsight_listing_print_before hook
 *
 * @since 1.1
 */
 
add_action( 'wpsight_listing_print_before', 'wpsight_do_print_logo' );

function wpsight_do_print_logo() {

	// Get logo image from options
	$logo_image = apply_filters( 'wpsight_do_print_logo_image', wpsight_get_option( 'logo', true ) );
	
	// Get logo text from options
	$logo_text = apply_filters( 'wpsight_do_print_logo_text', wpsight_get_option( 'logo_text' ) );
	
	if( empty( $logo_text ) ) {
	
		// Create logo image
		$logo = '<div id="logo"><img src="' . $logo_image . '" alt="" /></div><!-- #logo -->';		
		
	} else {

		// Get text logo and set to blog name if emtpy
		$logo = '<div id="logo-text">' . $logo_text . '</div><!-- #logo-text -->';

	}
	
	// Get logo slogan	
	$logo_description = apply_filters( 'wpsight_do_print_logo_description', get_bloginfo( 'description' ) );
	
	if( ! empty( $logo_description ) ) {
	
		// Set slogan tag to H1 on front page
		$tag = ( is_front_page() ) ? 'h1' : 'div';
		$logo .= "\n" . '<' . $tag . ' id="logo-description">' . $logo_description . '</' . $tag . '>';
		
	}
		
	echo apply_filters( 'wpsight_do_print_logo', $logo );

}

/**
 * Add listing print header right info to
 * wpsight_listing_print_before hook
 *
 * @since 1.1
 */
 
add_action( 'wpsight_listing_print_before', 'wpsight_do_print_header_right' );

function wpsight_do_print_header_right() {

	// Get header right content from options
	$header_right = '<div class="print-header-right">' . wpsight_get_option( 'header_right', true ) . '</div>';
	
	if( ! empty( $header_right ) )
		echo apply_filters( 'wpsight_do_header_right', nl2br( $header_right ) );

}



/**
 * Create listing spaces for use of 
 * custom content in widgets
 *
 * @since 1.0
 */
 
function wpsight_listing_spaces() {

	$listing_spaces = array(
    	
    	'_space' => array(
    		'title'		  => __( 'Space', 'wpsight' ),
    		'label' 	  => __( 'Widget Space', 'wpsight' ),
    		'key'		  => '_space',
    		'description' => __( 'Add some custom content to this page. Then drag the Single Space widget to the Listing Content or Listing Sidebar widget area.', 'wpsight' ),
    		'type' 	   	  => 'textarea',
    		'rows' 		  => 5,
    		'post_type'   => array( wpsight_listing_post_type() )
    	)
	
	);
	
	return apply_filters( 'wpsight_listing_spaces', $listing_spaces );

}

/**
 * Listing RSS
 *
 * Set post types for rss feed
 *
 * @since 1.0
 */

add_filter( 'request', 'wpsight_feed_request' );

function wpsight_feed_request( $qv ) {

	$feed_post_types = array(
		'post',
		wpsight_listing_post_type()
	);
	
	$feed_post_types = apply_filters( 'wpsight_feed_post_types', $feed_post_types );

	if ( isset( $qv['feed'] ) && ! isset( $qv['post_type'] ) )
		$qv['post_type'] = $feed_post_types;
			
	return $qv;
}