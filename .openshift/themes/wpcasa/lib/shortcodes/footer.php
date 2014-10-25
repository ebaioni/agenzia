<?php

/**
 * Create shortcodes for
 * footer-related stuff
 *
 * @package wpSight
 */
 
/**
 * Shortcode to output the year
 *
 * @since 1.0
 */
 
add_shortcode( 'the_year', 'wpsight_year_shortcode' );

function wpsight_year_shortcode( $atts ) {

	$defaults = array( 
	    'before' => '&copy; ',
	    'after'  => '',
	    'first'  => '',
	    'wrap'	 => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$first_year = ( ! empty( $first ) && $first != date( 'Y' ) ) ? $first . ' &ndash; ' : false;

	$output = sprintf( '<%5$s class="the-year">%1$s%4$s%3$s%2$s</%5$s>', $before, $after, date( 'Y' ), $first_year, $wrap );

	return apply_filters( 'wpsight_year_shortcode', $output, $atts );

}

/**
 * Shortcode to output the site link
 *
 * @since 1.0
 */
 
add_shortcode( 'site_link', 'wpsight_site_link_shortcode' );

function wpsight_site_link_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'url' 	 => home_url(),
		'label'  => get_bloginfo( 'name' ),
		'title'  => get_bloginfo( 'description' ),
		'target' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$target = ( ! empty( $target ) ) ? ' target="' . $target . '"' : false;

	$output = sprintf( '%1$s<a href="%3$s" title="%5$s"%6$s>%4$s</a>%2$s', $before, $after, $url, $label, $title, $target );

	return apply_filters( 'wpsight_site_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output WordPress link
 *
 * @since 1.0
 */
 
add_shortcode( 'wordpress_link', 'wpsight_wordpress_link_shortcode' );

function wpsight_wordpress_link_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'url' 	 => 'http://wordpress.org',
		'label'  => 'WordPress',
		'title'  => 'WordPress',
		'target' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$target = ( ! empty( $target ) ) ? ' target="' . $target . '"' : false;

	$output = sprintf( '%1$s<a href="%3$s" title="%5$s"%6$s>%4$s</a>%2$s', $before, $after, $url, $label, $title, $target );

	return apply_filters( 'wpsight_wordpress_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output wpCasa link
 *
 * @since 1.0
 */
 
add_shortcode( 'wpcasa_link', 'wpcasa_link_shortcode' );

function wpcasa_link_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'url' 	 => 'http://wpcasa.com',
		'label'  => 'wpCasa',
		'title'  => 'Real Estate WordPress Theme Framework',
		'target' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$target = ( ! empty( $target ) ) ? ' target="' . $target . '"' : false;

	$output = sprintf( '%1$s<a href="%3$s" title="%5$s"%6$s>%4$s</a>%2$s', $before, $after, $url, $label, $title, $target );

	return apply_filters( 'wpcasa_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output wpShaft link
 *
 * @since 1.2
 */
 
add_shortcode( 'wpshaft_link', 'wpshaft_link_shortcode' );

function wpshaft_link_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'url' 	 => 'http://wpshaft.com',
		'label'  => 'wpShaft',
		'title'  => 'Car Dealer WordPress Theme Framework',
		'target' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$target = ( ! empty( $target ) ) ? ' target="' . $target . '"' : false;

	$output = sprintf( '%1$s<a href="%3$s" title="%5$s"%6$s>%4$s</a>%2$s', $before, $after, $url, $label, $title, $target );

	return apply_filters( 'wpshaft_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output wpShaft link
 *
 * @since 1.2
 */
 
add_shortcode( 'wpyacht_link', 'wpyacht_link_shortcode' );

function wpyacht_link_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'url' 	 => 'http://wpyacht.com',
		'label'  => 'wpYacht',
		'title'  => 'Boat Dealer WordPress Theme Framework',
		'target' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$target = ( ! empty( $target ) ) ? ' target="' . $target . '"' : false;

	$output = sprintf( '%1$s<a href="%3$s" title="%5$s"%6$s>%4$s</a>%2$s', $before, $after, $url, $label, $title, $target );

	return apply_filters( 'wpyacht_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output wpSight link
 *
 * @since 1.2
 */
 
add_shortcode( 'wpsight_link', 'wpsight_link_shortcode' );

function wpsight_link_shortcode( $atts ) {

	$defaults = array( 
		'before' => '',
		'after'  => '',
		'url' 	 => 'http://wpsight.com',
		'label'  => 'wpSight',
		'title'  => 'Network of WordPress Theme Frameworks',
		'target' => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$target = ( ! empty( $target ) ) ? ' target="' . $target . '"' : false;

	$output = sprintf( '%1$s<a href="%3$s" title="%5$s"%6$s>%4$s</a>%2$s', $before, $after, $url, $label, $title, $target );

	return apply_filters( 'wpsight_link_shortcode', $output, $atts );

}

/**
 * Shortcode to output login/out link
 *
 * @since 1.0
 */

add_shortcode( 'loginout_link', 'wpsight_loginout_link_shortcode' );

function wpsight_loginout_link_shortcode( $atts ) {
	
	$defaults = array(
		'redirect' => wp_get_referer(),
		'before'   => '',
		'after'    => ''
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	if ( ! is_user_logged_in() ) {
		$link = '<a href="' . esc_url( wp_login_url( $redirect ) ) . '">' . __( 'Log in', 'wpsight' ) . '</a>';
	} else {
		$link = '<a href="' . esc_url( wp_logout_url( $redirect ) ) . '">' . __( 'Log out', 'wpsight' ) . '</a>';
	}
	
	$output = sprintf( '%1$s<span>%3$s</span>%2$s', $before, $after, apply_filters( 'loginout', $link ) );

	return apply_filters( 'wpsight_loginout_link_shortcode', $output, $atts );

}