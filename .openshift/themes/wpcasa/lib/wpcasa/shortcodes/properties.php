<?php
/**
 * Make sure old wpCasa property
 * shortcodes keep on working
 *
 * @since 1.2
 */
 
add_shortcode( 'property_id', 'wpsight_listing_id_shortcode' );
add_shortcode( 'property_title', 'wpsight_listing_title_shortcode' );
add_shortcode( 'property_image', 'wpsight_listing_image_shortcode' );
add_shortcode( 'property_description', 'wpsight_listing_description_shortcode' );
add_shortcode( 'property_price', 'wpsight_listing_price_shortcode' );
add_shortcode( 'property_status', 'wpsight_listing_status_shortcode' );
add_shortcode( 'property_details', 'wpsight_listing_details_shortcode' );
add_shortcode( 'property_details_short', 'wpsight_listing_details_short_shortcode' );
add_shortcode( 'property_terms', 'wpsight_listing_terms_shortcode' );
add_shortcode( 'property_url', 'wpsight_listing_url_shortcode' );
add_shortcode( 'property_url_raw', 'wpsight_listing_url_raw_shortcode' );
add_shortcode( 'property_qr', 'wpsight_listing_qr_shortcode' );
add_shortcode( 'property_map', 'wpsight_listing_map_shortcode' );