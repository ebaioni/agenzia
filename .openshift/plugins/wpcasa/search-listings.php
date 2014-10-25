<?php
/**
 * The template for displaying search results archive pages.
 *
 * @package wpSight
 * @since 1.0
 */
 
global $counter, $wp_query;
 
// Check search term for listing ID

if( ! empty( $_GET['s'] ) ) {
  	
  	// Built ID search query
  	
  	$id_args = array(    
    	'post_type'  => wpsight_listing_post_type(),
    	'meta_query' => array(    	
    		'relation' => 'OR',
			array(
			    'key' 	  => '_listing_id',
			    'value'   => $_GET['s'],
			    'compare' => 'LIKE'
			),
			array(
			    'key' 	  => '_property_id',
			    'value'   => $_GET['s'],
			    'compare' => 'LIKE'
			)
    	)
    );
    
    // Execute ID search query
    $id_query = new WP_Query( $id_args );
    
    // If only one result, redirect to single listing page
    
    if( $id_query->post_count == 1 ) {
    
    	// Get post ID of single search result
    	$id_post = $id_query->posts[0]->ID;
    	
    	// Redirect to single listing page
        wp_redirect( get_permalink( $id_post ) ); exit;
    }					    

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
		?>
	
	    <div id="content" class="<?php echo $content_class; ?>">
	    
			<div class="title title-archive clearfix"><?php
			
				echo apply_filters( 'wpsight_search_title', wpsight_listing_loop_title() );
			    	
			    // Action hook to add content to title
			    do_action( 'wpsight_loop_title_actions', $wp_query ); ?>
			
			</div><!-- .title --><?php
			
			// Action hook to add content after archive title
			do_action( 'wpsight_listing_archive_title_after', wpsight_listing_search_query_args(), $content_class );
			
			if ( have_posts() ) { ?>
				
				<div class="row">
	    		
	    			<?php
	    			    // Create loop counter
					    $counter = 0;
	    			    
	    			    while ( have_posts() ) {
					    
					    	// Increase loop counter
	    			    	$counter++;
	    			    
	    			    	the_post();
	    			    			
	    			    	// Include listing loop template
					    	get_template_part( 'loop', 'listing' );
					    
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