<div id="sidebar" class="<?php echo wpsight_get_span( 'small' ); ?>"><?php

	do_action( 'wpsight_sidebar_listing_widgets_before' );
	
	if( is_singular() && get_post_type() == wpsight_listing_post_type() && ! is_page_template( 'page-tpl-listings.php' ) && ! is_page_template( 'page-tpl-properties.php' ) && ! is_page_template( 'page-tpl-favorites.php' ) && ! is_page_template( 'page-tpl-compare.php' ) && ! is_page_template( 'page-tpl-map.php' ) && is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing' ) ) ) {
			
		dynamic_sidebar( wpsight_get_sidebar( 'sidebar-listing' ) );
	
	} else {
			
		dynamic_sidebar( wpsight_get_sidebar( 'sidebar-listing-archive' ) );
		
	}
	
	do_action( 'wpsight_sidebar_listing_widgets_after' ); ?>

</div><!-- #sidebar -->