<?php

// Save parent post ID				
$page_id = get_the_ID();

$subpages_args = array(
	'post_type' 	 => 'page',
	'post_parent' 	 => $page_id,
	'orderby'  		 => 'menu_order',
	'order'  		 => 'ASC',
	'posts_per_page' => -1
);

$subpages_args = apply_filters( 'wpsight_loop_subpages_args', $subpages_args );

$subpages = new WP_Query( $subpages_args ); 
    
if( ! empty( $subpages ) ) { ?>

	<div id="subpages" class="clear">
	
	    <div class="row"><?php
	    
	    	// Set counter
			$i=0;
			
			while ( $subpages->have_posts() ) {
			
			    $subpages->the_post();
			    
			    // Set clear depending on page layout			    
			    if( get_post_meta( $page_id, '_layout', true ) == 'full-width' || ( ! is_active_sidebar( 'sidebar' ) && ! is_active_sidebar( 'sidebar-page' ) ) ) {
			    	$clear = ( WPSIGHT_LAYOUT == 'four' ) ? 4 : 3;
			    } else {
			    	$clear = ( WPSIGHT_LAYOUT == 'four' ) ? 3 : 2;
			    } ?>
			
			    <div class="<?php echo wpsight_get_span( 'small' ); ?> page hentry<?php if( $i%$clear == 0 ) echo ' clear'; ?>">
			    
			       <?php if( has_post_thumbnail() ) : ?>
			    
			    	<div class="post-image">	
			    			    	
			    	    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?></a>
			    	    			    
			    	</div>
			    	
			    	<?php endif; ?>
			    	
			    	<div class="post-title">
			    				
			    	    <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			    	
			    	</div>	    	
			    	
			    	<?php
			    		// Set custom excerpt length on parent page
			    		$custom_excerpt_length = get_post_meta( $page_id, 'excerpt_length', true );
			    		
			    		// If custom excerpt length empty, set it to 25 (filtrable)
			    		$excerpt_length = $custom_excerpt_length ? $custom_excerpt_length : apply_filters( 'wpsight_excerpt_length_subpages', 25 );
			    		
			    		// Display page excerpt
			    		wpsight_the_excerpt( get_the_ID(), false, $excerpt_length );
			    	?>
			
			    </div><!-- .page --><?php
			    
			    // Increase counter
			    $i++;
			
			} // endwhile $subpages ?>
	    
	    </div><!-- .row -->
	
	</div><!-- #subpages --><?php

} // endif $subpages
    
// Restore original query
wp_reset_query(); 