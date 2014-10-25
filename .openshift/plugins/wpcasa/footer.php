<?php
/**
 * Built theme footer with widget area,
 * and wp_footer(). The widget area is called
 * ffooter because 'footer' causes issues.
 *
 * @package wpSight
 * @since 1.0
 */

// Action hook before footer
do_action( 'wpsight_footer_before' );

// Display footer widget area if active

if( is_active_sidebar( 'ffooter' ) ) {

    // Open layout wrap			
    wpsight_layout_wrap( 'footer-wrap' ); ?>
    
    <div id="footer" class="clearfix">
    	<?php dynamic_sidebar( 'ffooter' ); ?>
    </div><!-- #footer--><?php
    
    // Close layout wrap			
    wpsight_layout_wrap( 'footer-wrap', 'close' );

} // endif is_active_sidebar()

// Action hook after footer
do_action( 'wpsight_footer_after' ); ?>

</div><!-- #outer -->

<?php
    do_action( 'wpsight_after' );
    wp_footer();
?>

</body>
</html>