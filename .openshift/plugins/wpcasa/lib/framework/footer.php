<?php

/**
 * Built the footer with widget area and
 * credit bottom line with copyright etc.
 *
 * @package wpSight
 *
 */

/**
 * Built credit area and add to
 * wpsight_footer_after hook
 *
 * @since 1.0
 */
 
add_action( 'wpsight_footer_after', 'wpsight_do_credit' );
 
function wpsight_do_credit() {

	$credit = wpsight_get_option( 'credit' );
	
	// Set default value if option has not been set
	
	if( wpsight_get_option( 'credit' ) === false )
		$credit = wpsight_get_option( 'credit', true );
	
	if( empty( $credit ) )
		return;

	// Open layout wrap
	wpsight_layout_wrap( 'credit-wrap' ); ?>

	<div id="credit" class="clearfix">			    
	    <?php echo do_shortcode( $credit ); ?>
	</div><!-- #credit --><?php
    
    // Close layout wrap	
	wpsight_layout_wrap( 'credit-wrap', 'close' );

}

/**
 * Add tracking to theme footer
 *
 * @since 1.0
 */

add_action( 'wpsight_after', 'wpsight_do_tracking' );

function wpsight_do_tracking() {

	$tracking = wpsight_get_option( 'tracking' );

	if( ! empty( $tracking ) )
		echo stripslashes( $tracking ) . "\n\n";
	
}