<?php
/**
 * The template for displaying taxonomy pages.
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
		?>
	
	    <div id="content" class="<?php echo $content_class; ?>">
	    
			<div class="title title-archive clearfix">
			
				<h1>
					<?php
						// Display post type
						post_type_archive_title();
    				?>
    			</h1>
			
			    <?php			    	
			    	// Action hook to add content to title
			    	do_action( 'wpsight_loop_title_actions' );
			    ?>
			
			</div><!-- .title --><?php
			    
			// Action hook to add content after archive title
			do_action( 'wpsight_listing_archive_title_after', wpsight_listing_archive_query_args(), $content_class ); ?>
	    
	    	<?php	    	
	    		if( have_posts() ) { ?>
				
					<div class="row">
	    			
	    			    <?php
	    			    	// Create loop counter
					    	$counter = 0;
	    			    	
	    			    	while ( have_posts() ) {
							
								// Increase loop counter
	    						$counter++;
	    			    	
	    			    		the_post();
	    			    				
	    			        	// Include listing loop template
					    		// get_template_part( 'loop', 'listing' );
					    		
					    		/**
					    		 * For some reason get_template_part
					    		 * with global $counter doesn't work here,
					    		 * let's use include() with locate_template()
					    		 */
					    		include( locate_template( 'loop-listing.php' ) );
					    	
					    	} // endwhile have_posts()
	    			    ?>
	    			
	    			</div><!-- .row --><?php
	    			
	    			wpsight_pagination();
	    			    		
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