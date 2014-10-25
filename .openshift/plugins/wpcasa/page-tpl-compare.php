<?php

/**
 * Template Name: Listings (compare)
 * This page template shows
 * the users' favorite listings
 * in a comparison table.
 *
 * @package wpSight
 * @since 1.2
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

			<script type="text/javascript">
				jQuery(document).ready(function($){
					
    				var removeValue = function(list, value) {
					  var values = list.split(",");
					  for(var i = 0 ; i < values.length ; i++) {
					    if(values[i] == value) {
					      values.splice(i, 1);
					      return values.join(",");
					    }
					  }
					  return list;
					};
					
					$('.favorites-remove').click(function() {
					
						var cookie_favs = '<?php echo WPSIGHT_COOKIE_FAVORITES; ?>';
						var favID = $(this).attr('id');
						var favs = removeValue($.cookie(cookie_favs), favID);
						
						$.cookie(cookie_favs, favs,{ expires: 60, path: '<?php echo COOKIEPATH; ?>' });
						
						$('.post-'+favID).fadeOut(150, function() {
							if($.cookie(cookie_favs)=='') {
								$('.title-favorites-contact').fadeOut(150);
								$('.title-search-map').fadeOut(150);
								$('.title-actions-order').fadeOut(150);
								$('.title-actions-contact').fadeOut(150);
								$('#nofavs').fadeIn(150);
							}
						});
						
						return false;				
						
					});
      				   			
				});
			</script>
	    
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
                
                // Get listing IDs stored in cookie
                $favorites = explode( ',', $_COOKIE[WPSIGHT_COOKIE_FAVORITES] );
				
				// Set args for blog custom query
	    		$args = array(
	    			'post_type'		 => array( wpsight_listing_post_type() ),
				    'posts_per_page' => 12,
				    'post__in' 		 => $favorites,
				    'paged'			 => $paged
				);
				
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
				
				$args = apply_filters( 'wpsight_listing_favorites_query_args', $args );
				
				// Action hook to add content after archive title
				do_action( 'wpsight_listing_archive_title_after', $args, $content_class );
				
				$favorites_query = new WP_Query( $args );
	    	
	    		if ( $favorites_query->have_posts() ) { ?>
				
					<div class="row">
	    			
	    			    <?php
	    			    	// Create loop counter
					    	$counter = 0;
	    			    	
	    			    	while ( $favorites_query->have_posts() ) {
							
								// Increase loop counter
	    						$counter++;
	    			    	
	    			    		$favorites_query->the_post();
	    			    				
	    			        	// Include listing loop template
					    		get_template_part( 'loop', 'listing-compare' );
					    	
					    	} // endwhile have_posts()
	    			    ?>
	    			
	    			</div><!-- .row --><?php
	    			
	    			wpsight_pagination( $favorites_query->max_num_pages );
	    			
	    			// Action hook to add content after favorites content
					do_action( 'wpsight_listing_favorites_after', $_COOKIE[WPSIGHT_COOKIE_FAVORITES] );
	    			    		
	    		} else { ?>
	    		
	    			<div class="post no-posts">
	    	
                        <div class="alert">
                        	<?php echo apply_filters( 'wpsight_no_favorites_text', __( '<strong>Sorry!</strong> You have no favorites at the moment.', 'wpsight' ) ); ?>
                        </div>
                    
                    </div><!-- .post --><?php
                    
                } // endif have_posts() ?>
                
                <div id="nofavs" class="post no-posts">
	    	
                    <div class="alert">
                    	<?php echo apply_filters( 'wpsight_no_favorites_text', __( '<strong>Sorry!</strong> You have no favorites at the moment.', 'wpsight' ) ); ?>
                    </div>
                
                </div><!-- .post -->
	    
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