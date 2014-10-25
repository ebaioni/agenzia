<?php

/**
 * Template Name: Listings (map)
 * This page template shows a map with all listings
 *
 * @package wpSight
 * @since 1.0
 */
 
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
				
				// Set args for blog custom query
				
	    		$args = array(
	    			'post_type'		 => array( wpsight_listing_post_type() ),
				    'posts_per_page' => apply_filters( 'wpsight_listings_map_nr', -1 ),
				    'paged'			 => $paged
				);
				
				// Exclude sold and rented
				
				$post_ids_sold_rented = $wpdb->get_col( $wpdb->prepare( "
                    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
                    WHERE meta_key = '%s'
                    AND meta_value = '%s'
                ", '_price_sold_rented', '1' ) );
                
                // Exclude from post options
                
                $post_ids_options = $wpdb->get_col( $wpdb->prepare( "
                    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
                    WHERE meta_key = '%s'
                    AND meta_value = '%s'
                ", '_map_exclude', '1' ) );
                
                // Merge arrays for exclude
                
                $post_ids_exclude = array_merge(
                	(array) $post_ids_sold_rented,
                	(array) $post_ids_options
                );
                
                if( ! empty( $post_ids_exclude ) )
                	$args = array_merge( $args, array( 'post__not_in' => $post_ids_exclude ) );
				
				$args = apply_filters( 'wpsight_map_query_args', $args );
				
				$map_query = new WP_Query( $args );
	    	
	    		if ( $map_query->have_posts() ) {
	    		
	    			get_template_part( 'loop', 'map' );
	    			    		
	    		} else { 
	    		
	    			get_template_part( 'listing', 'no' );
	    		
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