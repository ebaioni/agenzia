<?php
/**
 * The template used for displaying static page content.
 * For actions added to hooks see /lib/framework/main.php.
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
	    	$content_class = ( is_active_sidebar( 'sidebar-page' ) || is_active_sidebar( 'sidebar' ) ) ? wpsight_get_span( 'big' ) : wpsight_get_span( 'full' );
	    	
	    	// Set class depending on individual page layout
	    	if( get_post_meta( get_the_ID(), '_layout', true ) == 'full-width' )
	    		$content_class = wpsight_get_span( 'full' );	    	
		?>
	
	    <div id="content" class="<?php echo $content_class; ?>">				
	    
	    	<?php				
	    	    // Get page content from content-page.php
	    	    get_template_part( 'loop', 'page' );				
	    	?>				
	    
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