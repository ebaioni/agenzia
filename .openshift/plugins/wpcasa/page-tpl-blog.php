<?php

/**
 * Template Name: Blog (latest posts)
 * This page template shows the latest posts.
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
	    	$content_class = ( is_active_sidebar( 'sidebar-archive' ) || is_active_sidebar( 'sidebar' ) ) ? wpsight_get_span( 'big' ) : wpsight_get_span( 'full' );
	    	
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
	    			'cat'			 => -0,
				    'posts_per_page' => get_option( 'posts_per_page' ),
				    'paged'			 => $paged
				);
				
				$args = apply_filters( 'wpsight_blog_query_args', $args );
				
				// Get existing copy of our transient data
	
				if ( false === ( $blog_query = get_transient( 'wpsight_query_blog_' . get_the_ID() . '_' . $paged ) ) ) {	
				 	$blog_query = new WP_Query( $args );				
				 	set_transient( 'wpsight_query_blog_' . get_the_ID() . '_' . $paged, $blog_query, DAY_IN_SECONDS );				
				}
	    	
	    		if ( $blog_query->have_posts() ) { ?>
				
					<div class="row">
	    			
	    			    <?php
	    			    	// Create loop counter
					    	$counter = 0;
	    			    	
	    			    	while ( $blog_query->have_posts() ) {
							
								// Increase loop counter
	    						$counter++;
	    			    	
	    			    		$blog_query->the_post();
	    			    				
	    			        	/* Include the Post-Format-specific template for the content.
					    		 * If you want to overload this in a child theme then include a file
					    		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					    		 */
					    		get_template_part( 'loop', get_post_format() );
					    	
					    	} // endwhile have_posts()
	    			    ?>
	    			
	    			</div><!-- .row --><?php
	    			
	    			wpsight_pagination( $blog_query->max_num_pages );
	    			    		
	    		} else { 
	    		
	    			get_template_part( 'loop', 'no' );
	    		
	    		} // endif have_posts() ?>
	    
	    </div><!-- #content -->
	    
	    <?php get_sidebar(); ?>
	
	</div><!-- #main-middle -->
	
	<?php	    
	    // Close layout wrap
	    wpsight_layout_wrap( 'main-middle-wrap', 'close' );
	    
	    // Action hook to add content after main
	    do_action( 'wpsight_main_after' );	
	?>	

</div><!-- #main-wrap -->

<?php get_footer(); ?>