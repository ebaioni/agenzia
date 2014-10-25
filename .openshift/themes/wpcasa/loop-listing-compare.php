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
    
    <?php echo do_shortcode( '[listing_details_table]' ); ?>
    			
</div><!-- .post-<?php the_ID(); ?> -->
