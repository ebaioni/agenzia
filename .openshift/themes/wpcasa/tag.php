<?php
/**
 * The template for displaying tag archive pages.
 *
 * @package wpSight
 * @since 1.3.4
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
		?>
	
	    <div id="content" class="<?php echo $content_class; ?>">
	    
	    	<?php if ( have_posts() ) { ?>
	    
				<div class="title title-archive clearfix">
				
				    <?php
				    	echo apply_filters( 'wpsight_category_title', '<h1>' . single_cat_title( '', false ) . '</h1>' );
				    	
				    	// Action hook to add content to title
				    	do_action( 'wpsight_loop_title_actions' );
				    	
				    	// Display category description
				    	if( tag_description() )
				    	    echo '<div class="category-description clearfix">' . wpsight_format_content( tag_description() ) . '</div>';
				    ?>
				
				</div><!-- .title --><?php
			    
				// Action hook to add content after archive title
				do_action( 'wpsight_archive_title_after', $content_class ); ?>
				
				<div class="row">
	    		
	    			<?php
	    				// Create loop counter
						$counter = 0;
	    				
	    				while ( have_posts() ) {
							
							// Increase loop counter
	    					$counter++;
	    				
	    					the_post();
	    							
	    			    	/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called loop-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'loop', get_post_format() );
						
						} // endwhile have_posts()
	    			?>
	    		
	    		</div><!-- .row --><?php
	    		
	    		wpsight_pagination();
	    		
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