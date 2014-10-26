<?php
/**
 * The template used for displaying home page content.
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
			// Display widget area home when active
	    	if( false && is_active_sidebar( 'home' ) && is_front_page() ) {
			    
	    		// Set class of #content div depending on active sidebars
	    		$content_class = ( is_front_page() && is_active_sidebar( 'home' ) ) ? wpsight_get_span( 'big' ) : wpsight_get_span( 'full' );
	    		
	    		// Set class of #content div on home depending on active sidebars
	    		if( is_home() && ( is_active_sidebar( 'sidebar' ) || is_active_sidebar( 'sidebar-archive' ) ) )
	    			$content_class = wpsight_get_span( 'big' ); ?>
	
	    		<div id="content" class="<?php echo $content_class; ?>">
	    			
	    			<?php dynamic_sidebar( 'home' ); ?>				
	    			
	    		</div><!-- #content --><?php 
	    		
	    		get_sidebar();
	    		
	    	} elseif( ! is_active_sidebar( 'home-top' ) && ! is_active_sidebar( 'home-bottom' ) ) {
	    	
	    		do_action( 'wpsight_start_screen' );
	    	
	    	} // endif is_active_sidebar()
	    		
	    ?>
    	
	</div><!-- #main-middle -->	
		
	<?php	
		// Close layout wrap
		wpsight_layout_wrap( 'main-middle-wrap', 'close' );
		
	    // Action hook to add content after main
	    do_action( 'wpsight_main_after' );	    
	?>

</div><!-- #main-wrap -->

<?php get_footer(); ?>