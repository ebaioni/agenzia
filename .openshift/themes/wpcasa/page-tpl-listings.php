<?php

/**
 * Template Name: Listings (latest)
 * This page template shows the latest listings.
 *
 * @package wpSight
 * @since 1.0
 */

// Save parent page ID
$parent_id = get_the_ID();

// Make sure paging works

if ( get_query_var( 'paged' ) ) {
        $paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
        $paged = get_query_var( 'page' );
} else {
        $paged = 1;
}                	

// Set args for listings custom query
$args = array(
    'post_type'		 => array( wpsight_listing_post_type() ),
    'posts_per_page' => 12,
    'paged'			 => $paged
);				

// Check if custom field listing_filter

$filter = get_post_meta( $parent_id, 'listing_filter', true );

foreach( wpsight_listing_statuses() as $k => $v ) {
	if( $filter == $k ) {
		$meta_query = array(
    		array(
    			'key' 	=> '_price_status',
    			'value' => $k
    		)
    	);
    } 		
}

// When filter merge with other $args

if( ! empty( $meta_query ) )
    $args = array_merge( $args, array( 'meta_query' => $meta_query ) );
    
// Set order args for global query

$order = array(
    'orderby' => get_query_var( 'orderby' ),
    'order'   => get_query_var( 'order' )
);

// Set orderby price if set
    
if( get_query_var( 'orderby' ) == 'price' ) {
    $order['orderby']  = 'meta_value_num';
    $order['meta_key'] = '_price';
}

// Merge order with args
$args = array_merge( $args, $order );
    	
$args = apply_filters( 'wpsight_listing_query_args', $args );

// Check if transients are active
$transients = apply_filters( 'wpsight_transients_queries', false, 'page-template', $args, $parent_id );

// If query transients are active

if( $transients === true ) {

	// If transient does not exist

	if ( false === ( $listing_query = get_transient( 'wpsight_query_listings_' . get_the_ID() . '_' . $paged ) ) || get_query_var( 'orderby' ) ) {
	
		// Create listing query
	 	$listing_query = new WP_Query( $args );
	 	
	 	// Set transient for this query
	 	set_transient( 'wpsight_query_listings_' . get_the_ID() . '_' . $paged, $listing_query, DAY_IN_SECONDS );

	}

// If query transients are not active

} else {

	// Create listing query
	$listing_query = new WP_Query( $args );

}
 
get_header(); ?>

<div id="main-wrap" class="wrap">	

	<?php	
	    // Action hook to add content before main
	    do_action( 'wpsight_main_before' );
	    
	    // Open layout wrap
	    wpsight_layout_wrap( 'main-middle-wrap' );	    
	?>
	
	<div id="main-middle" class="row">
	
		<?php
	    	// Set class of #content div depending on active sidebars
	    	$content_class = is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing-archive' ) ) ? wpsight_get_span( 'big' ) : wpsight_get_span( 'full' );
	    	
	    	// Set class depending on individual page layout
	    	if( get_post_meta( get_the_ID(), '_layout', true ) == 'full-width' )
	    		$content_class = wpsight_get_span( 'full' );
		?>
	
	    <div id="content" class="<?php echo $content_class; ?>">
	    
	    	<?php
	    		// Set up post data
	    		the_post();
	    	?>
	    
			<div class="title title-archive clearfix">
			
				<h1><?php the_title(); ?></h1>
			
			    <?php			    	
			    	// Action hook to add content to title
			    	do_action( 'wpsight_loop_title_actions' );
			    	
			    	// Display post content like category description
				    if( ! empty( $post->post_content ) )
				   		echo '<div class="category-description clearfix">' . wpsight_format_content( $post->post_content ) . '</div>';
			    ?>
			
			</div><!-- .title -->
	    
	    	<?php				
				// Action hook to add content after archive title
				do_action( 'wpsight_listing_archive_title_after', $args, $content_class );
	    	
	    		if ( $listing_query->have_posts() ) { ?>
				
					<div class="row">
	    			
	    			    <?php
	    			    	// Create loop counter
					    	$counter = 0;
	    			    	
	    			    	while ( $listing_query->have_posts() ) {
							
								// Increase loop counter
	    						$counter++;
	    			    	
	    			    		$listing_query->the_post();
	    			    				
	    			        	// Include listing loop template
					    		get_template_part( 'loop', 'listing' );
					    	
					    	} // endwhile have_posts()
	    			    ?>
	    			
	    			</div><!-- .row --><?php
	    			
	    			wpsight_pagination( $listing_query->max_num_pages );
	    			    		
	    		} else { 
	    		
	    			get_template_part( 'loop', 'no' );
	    		
	    		} // endif have_posts() ?>
	    
	    </div><!-- #content -->
	    
	    <?php get_sidebar( 'listing' ); ?>
	
	</div><!-- #main-middle -->
	
	<?php	    
	    // Close layout wrap
	    wpsight_layout_wrap( 'main-middle-wrap', 'close' );
	    
	    // Action hook to add content after main
	    do_action( 'wpsight_main_after' );	
	?>	

</div><!-- #main-wrap -->

<?php get_footer(); ?>