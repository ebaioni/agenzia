<?php

/**
 * Template Name: Agents (list)
 * This page template shows a list of all listing agents.
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
	    
	    	<div <?php post_class( 'clearfix' ); ?>>
    
			    <?php
			    	// Action hook before post title
			        do_action( 'wpsight_post_title_before' );
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
    			    // Action hook after post title
    			    do_action( 'wpsight_post_title_after' );
    			    
    			    // Action hook before post content
    			    do_action( 'wpsight_post_content_before' );
    			    
    			    // Set $args for agent list
    			    
    			    $args = array(
    			    	'exclude' 		  => array(),
    			    	'order'			  => 'asc',
    			    	'orderby' 		  => 'ID',
    			    	'agents_per_page' => get_option( 'posts_per_page' ),
    			    	'hide_empty'	  => true
    			    );
    			    
    			    $args = apply_filters( 'wpsight_agent_list_args', $args );
    			    
    			    // Extract $args
    			    extract( $args );
    			    
    			    // Get all users
    			    	    		
	    			global $wpdb;
	    			    				
    				$users = $wpdb->get_results( $wpdb->prepare( "SELECT ID, display_name FROM $wpdb->users ORDER BY %s %s", $orderby, $order ) );
    				
    				// Create agents array
    				$agents = array();
					
					foreach( $users as $user ) {
    				
    					// Get user ID
    					$user_id  = $user->ID;
    					
    					// If exclude, ignore
    					if( ( is_array( $exclude ) && in_array( $user_id, $exclude ) ) || get_the_author_meta( 'agent_exclude', $user_id ) )
    						continue;
    					
    					// Get number of listings
    					$numposts = wpsight_count_user_posts_by_type( $user->ID, wpsight_listing_post_type() );
    					
    					if( $hide_empty == true && $numposts == 0 )
    						continue;
    					
    					// Add user to agents array	
    					$agents[] = (array) $user;
    				
    				}
					
					// List agents if any
    				  				
    				if( count( $agents ) > 0 ) {
    					
    					// Get the current page
    					
						$paged = get_query_var( 'paged' );
						
						if ( ! $paged )
							$paged = 1;
						
						// Calculate total pages	
						$total_pages = ceil( count( $agents ) / $agents_per_page );
						
						// Calculate the starting and ending points
						
						$start = ( $paged - 1 ) * $agents_per_page;
						$end = $paged * $agents_per_page;
						
						if ( $end > count( $agents ) )
							$end = count( $agents );
						
						// Loop through the authors
						
						for ( $i = $start; $i < $end; $i++ ) {
						
							$agent = $agents[$i];
    					
    						$agent_id = $agent['ID'];
    						
    						// Get author/listing agent information
							do_action( 'wpsight_listing_agent', 'list' );
    					
    					}    					
					
						wpsight_pagination( $total_pages );
    				
    				} else { ?>
    				
    					<div class="alert">
    						<?php echo apply_filters( 'wpsight_no_authors_text', __( '<strong>Sorry!</strong> No agents found.', 'wpsight' ) ); ?>
    					</div><?php
    				    				
    				}				
    				
    				// Action hook after post content
    				do_action( 'wpsight_post_content_after' );
    			?>
			    			
			</div><!-- .post-<?php the_ID(); ?> -->
	    
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