<?php
/**
 * The template for displaying author info
 * on author archive pages.
 *
 * @package wpSight
 * @since 1.1
 */
 
/**
 * Queue the first post, that way we know
 * what author we're dealing with.
 */
the_post();

// Get author loop template
get_template_part( 'loop', 'author' );
	
/**
 * Since we called the_post() above, we need to
 * rewind the loop back to the beginning.
 */
rewind_posts();