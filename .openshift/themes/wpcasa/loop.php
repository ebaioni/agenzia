<?php
/**
 * The default template for displaying main content.
 *
 * @package wpSight
 * @since 1.0
 */
 
global $counter, $parent_id;
		
/**
 * Create post classes for different layouts.
 * Find wpsight_archive_post_class() in
 * /lib/functions/general.php
 */

$post_class = wpsight_archive_post_class( $counter, $parent_id );

?>

<div <?php post_class( $post_class ); ?>>
    
    <?php
    	// Action hook before post title
        do_action( 'wpsight_post_title_before' );
    ?>
    
    <h2 class="post-title entry-title">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
    		<?php
    			// Action hook post title inside
        		do_action( 'wpsight_post_title_inside' );
    			the_title();
    		?>
    	</a>
    </h2>
    
    <?php
        // Action hook after post title
        do_action( 'wpsight_post_title_after' );
        
        // Action hook before post content
        do_action( 'wpsight_post_content_before' );
    ?>
    	
    <div class="post-teaser clearfix">
    	<?php wpsight_the_excerpt( get_the_ID(), true, apply_filters( 'wpsight_excerpt_length', 25 ) ); ?>
    </div>
    
    <?php
    	// Action hook after post content
    	do_action( 'wpsight_post_content_after' );
    ?>
    			
</div><!-- .post-<?php the_ID(); ?> -->
