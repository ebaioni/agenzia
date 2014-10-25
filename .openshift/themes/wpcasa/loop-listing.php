<?php
/**
 * The default template to display a listing
 *
 * @package wpSight
 * @since 1.0
 */
 
if( ! isset( $counter ) )
	global $counter;
	
if( ! isset( $parent_id ) )
	global $parent_id;
		
/**
 * Create post classes for different layouts.
 * Find wpsight_archive_listing_class() in
 * /lib/functions/listings.php
 */

$post_class = wpsight_archive_listing_class( $counter, $parent_id ); ?>

<div <?php post_class( $post_class ); ?>>
    
    <?php
    	// Action hook before listing title
        do_action( 'wpsight_listing_title_before' );
    ?>
    
    <h2 class="post-title entry-title">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
    		<?php
    			the_title();
    			
    			// Action hook listing title inside
        		do_action( 'wpsight_listing_title_inside' );    			
    		?>
    	</a>
    </h2>
    
    <?php
        // Action hook after listing title
        do_action( 'wpsight_listing_title_after' );
        
        // Action hook before listing content
        do_action( 'wpsight_listing_content_before' );
    ?>
    	
    <div class="post-teaser clearfix">
    	<?php wpsight_the_excerpt( get_the_ID(), true, apply_filters( 'wpsight_excerpt_length', 25 ) ); ?>
    </div>
    
    <?php
    	// Action hook after listing content
    	do_action( 'wpsight_listing_content_after' );
    ?>
    			
</div><!-- .post-<?php the_ID(); ?> -->
