<?php

/**
 * Create shortcodes for
 * post-related stuff
 *
 * @package wpSight
 */
 
/**
 * Shortcode to output post date
 *
 * @since 1.0
 */
 
add_shortcode( 'post_date', 'wpsight_post_date_shortcode' );
 
function wpsight_post_date_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
		'format' => get_option( 'date_format' ),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$output = sprintf( '<%4$s class="post-date updated">%1$s%3$s%2$s</%4$s>', $before, $after, get_the_time( $format ), $wrap );

	return apply_filters( 'wpsight_post_date_shortcode', $output, $atts );

}

/**
 * Shortcode to output post categories
 *
 * @since 1.0
 */

add_shortcode( 'post_categories', 'wpsight_post_categories_shortcode' );

function wpsight_post_categories_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
		'sep'    => ', ',
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$cats = get_the_category_list( $sep );

	$output = sprintf( '<%4$s class="post-categories">%2$s%1$s%3$s</%4$s> ', $cats, $before, $after, $wrap );

	return apply_filters( 'wpsight_post_categories_shortcode', $output, $atts );

}

/**
 * Shortcode to output post author
 *
 * @since 1.0
 */
 
add_shortcode( 'post_author', 'wpsight_post_author_shortcode' );

function wpsight_post_author_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$output = sprintf( '<%4$s class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</%4$s>', esc_html( get_the_author() ), $before, $after, $wrap );

	return apply_filters( 'wpsight_post_author_shortcode', $output, $atts );

}

/**
 * Shortcode to output post author link (website)
 *
 * @since 1.0
 */
 
add_shortcode( 'post_author_link', 'wpsight_post_author_link_shortcode' );

function wpsight_post_author_link_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
		'before'   => '',
		'after'    => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$author = get_the_author();

	if ( get_the_author_meta( 'url' ) )
		$author = '<a href="' . get_the_author_meta( 'url' ) . '" title="' . esc_attr( sprintf( __( "Visit %s&#8217;s website", 'wpsight' ), $author ) ) . '" rel="external">' . $author . '</a>';

	$output = sprintf( '<%4$s class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</%4$s>', $author, $before, $after, $wrap );

	return apply_filters( 'wpsight_post_author_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output post author link (posts)
 *
 * @since 1.0
 */
 
add_shortcode( 'post_author_posts_link', 'wpsight_post_author_posts_link_shortcode' );

function wpsight_post_author_posts_link_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	global $authordata;
	if ( !is_object( $authordata ) )
		return false;

	$link = sprintf(
	        '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
	        get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
	        esc_attr( sprintf( __( 'Posts by %s', 'wpsight' ), get_the_author() ) ),
	        get_the_author()
	);
	$link = apply_filters( 'the_author_posts_link', $link );

	$output = sprintf( '<%4$s class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</%4$s>', $link, $before, $after, $wrap );

	return apply_filters( 'wpsight_post_author_posts_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output post
 * comments number with link
 *
 * @since 1.0
 */

add_shortcode( 'post_comments', 'wpsight_post_comments_shortcode' );

function wpsight_post_comments_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
		'zero'   => __( 'Leave a Comment', 'wpsight' ),
		'one'    => __( '1 Comment', 'wpsight' ),
		'more'   => ' ' . __( 'Comments', 'wpsight' ),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	if ( ! comments_open() )
		return;

	$comments_number = get_comments_number();

	if( $comments_number == 0 ){
	    $comments = $zero;
	}
	elseif( $comments_number > 1 ){
	    $comments = $comments_number . $more;
	}
	else {
	     $comments = $one;
	}

	// Replace #comments with #respond (there's no filter yet)
	$comments_link = ( $comments_number == 0 ) ? str_replace( '#comments', '#respond', get_comments_link() ) : get_comments_link();

	$comments = sprintf( '<a href="%1$s">%2$s</a>', $comments_link, $comments );

	$output = sprintf( '<%4$s class="post-comments">%2$s%1$s%3$s</%4$s>', $comments, $before, $after, $wrap );

	return apply_filters( 'wpsight_post_comments_shortcode', $output, $atts );

}

/**
 * Shortcode to output post tags
 *
 * @since 1.0
 */

add_shortcode( 'post_tags', 'wpsight_post_tags_shortcode' );

function wpsight_post_tags_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
	    'sep'    => ', ',
	    'before' => __( 'Tags', 'wpsight' ) . ': ',
	    'after'  => '',
	    'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$tags = get_the_tag_list( $before, $sep, $after );

	if ( ! $tags )
		return;

	$output = sprintf( '<%2$s class="post-tags">%1$s</%2$s> ', $tags, $wrap );

	return apply_filters( 'wpsight_post_tags_shortcode', $output, $atts );

}

/**
 * Shortcode to output post terms
 *
 * @since 1.0
 */

add_shortcode( 'post_terms', 'wpsight_post_terms_shortcode' );

function wpsight_post_terms_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$defaults = array(
	    'sep'      => ', ',
	    'before'   => __( 'Terms', 'wpsight' ) . ': ',
	    'after'    => '',
	    'taxonomy' => 'category',
	    'wrap'	   => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$terms = get_the_term_list( get_the_ID(), $taxonomy, $before, $sep, $after );

	if ( is_wp_error( $terms ) || empty( $terms ) )
		return false;

	$output = sprintf( '<%2$s class="post-terms">%1$s</%2$s>', $terms, $wrap );

	return apply_filters( 'wpsight_post_terms_shortcode', $output, $terms, $atts );

}

/**
 * Shortcode to output the post edit link
 *
 * @since 1.0
 */

add_shortcode( 'post_edit', 'wpsight_post_edit_shortcode' );

function wpsight_post_edit_shortcode( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	$link = get_edit_post_link();

	if( empty( $link ) )
		return;

	$defaults = array(
		'label'  => __( '[Edit]', 'wpsight' ),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$output = sprintf( '<%5$s class="post-edit">%3$s<a href="%1$s">%2$s</a>%4$s</%5$s> ', $link, $label, $before, $after, $wrap );

	return apply_filters( 'wpsight_post_edit_shortcode', $output, $atts );

}

/**
 * Shortcode to output the post parent link
 *
 * @since 1.0
 */

add_shortcode( 'post_parent', 'wpsight_post_parent' );

function wpsight_post_parent( $atts ) {

	$post_id = get_the_ID();	
	if( empty( $post_id ) )
		return;

	// Check if parent exists		
	$post = get_post( get_the_ID() );
	if( empty( $post->post_parent ) )
		return;

	// Get parent post
	$parent = get_post( $post->post_parent );

	$defaults = array(
		'label'   => get_the_title( $parent->ID ),
		'before' => '- ' . __( 'Attached to', 'wpsight' ) . ': ',
		'after'  => '',
		'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$output = sprintf( '<%5$s class="post-parent">%3$s<a href="%1$s">%2$s</a>%4$s</%5$s> ', get_permalink( $parent->ID ), $label, $before, $after, $wrap );

	return apply_filters( 'wpsight_post_parent_shortcode', $output, $atts );

}