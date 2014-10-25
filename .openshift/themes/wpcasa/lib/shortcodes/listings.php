<?php
/**
 * Shortcode to output listing search
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_search', 'wpsight_get_listing_search' );

/**
 * Shortcode to output listing id
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_id', 'wpsight_listing_id_shortcode' );

function wpsight_listing_id_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$listing_id = wpsight_get_listing_id( $id );

	$output = sprintf( '<%4$s class="listing-id-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $listing_id, $wrap );

	return apply_filters( 'wpsight_listing_id_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing title
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_title', 'wpsight_listing_title_shortcode' );

function wpsight_listing_title_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Get title by ID
	$title = apply_filters( 'the_title', get_the_title( $id ) );

	$output = sprintf( '<%4$s class="listing-title-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $title, $wrap );

	return apply_filters( 'wpsight_listing_title_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing image
 *
 * @since 1.1
 */
 
add_shortcode( 'listing_image', 'wpsight_listing_image_shortcode' );

function wpsight_listing_image_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'size'	 => 'full',
		'wrap'	 => 'div'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$image = get_the_post_thumbnail( $id, $size );
	
	// Stop if no image
	if( empty( $image ) )
		return;

	$output = sprintf( '<%4$s class="listing-image-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $image, $wrap );

	return apply_filters( 'wpsight_listing_image_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing description
 *
 * @since 1.1
 */
 
add_shortcode( 'listing_description', 'wpsight_listing_description_shortcode' );

function wpsight_listing_description_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'filter' => 'the_content',
		'wrap'	 => 'div'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Get post object
	$listing = get_post( $id );
	
	// Get description
	$description = $listing->post_content;
	
	// Stop if no description
	if( empty( $description ) )
		return;
	
	// Apply filter
	if( ! empty( $filter ) && $filter != 'false' )
		$description = apply_filters( $filter, $description );
		
	// Apply filter
	if( $filter === true )
		$description = wpsight_format_content( $description );

	$output = sprintf( '<%4$s class="listing-image-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $description, $wrap );

	return apply_filters( 'wpsight_listing_description_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing price
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_price', 'wpsight_listing_price_shortcode' );
 
function wpsight_listing_price_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$price = wpsight_get_price( $id );

	$output = sprintf( '<%4$s class="listing-price-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $price, $wrap );

	return apply_filters( 'wpsight_listing_price_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing status
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_status', 'wpsight_listing_status_shortcode' );

function wpsight_listing_status_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$listing_status = wpsight_get_listing_status( get_post_meta( $id, '_price_status', true ) );

	$output = sprintf( '<%4$s class="listing-status-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $listing_status, $wrap );

	return apply_filters( 'wpsight_listing_status_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing details
 *
 * @since 1.1
 */
 
add_shortcode( 'listing_details', 'wpsight_listing_details_shortcode' );
 
function wpsight_listing_details_shortcode( $atts ) {

	$defaults = array(
		'id'	 	=> get_the_ID(),
		'detail_id' => '',
		'before' 	=> '',
		'after'  	=> '',
		'wrap'	 	=> 'div'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Create details	
	$details = '';
	
	// Loop through standard details
	
	foreach( wpsight_standard_details() as $detail => $v ) {
	
		// Don't show detail if label is emtpy in options
		
		$standard_details_option = wpsight_get_option( $detail );
		
		// Set default value if option has not been set
	
		if( wpsight_get_option( $detail ) === false )
			$standard_details_option = wpsight_get_option( $detail, true );
		
		if( empty( $standard_details_option['label'] ) )
			continue;
	
		$value = get_post_meta( $id, '_' . $detail, true );
		
		// Check if value is data key
				    		
		if( ! empty( $v['data'] ) )
		    $value = $v['data'][$value];
		
		// Continue if no value

		if( empty( $value ) )
			continue;
	
		$details .= '<span class="listing-details-sc-detail ' . $detail . '">';
		$details .= '<span class="detail-label">' . $v['label'] . '</span>';
		$details .= '<span class="detail-value">' . $value . ' ' . wpsight_get_measurement_units( $v['unit'] ) . '</span>';
		$details .= '</span><!-- .listing-details-sc-' . $detail . ' -->';
		
	}

	$output = sprintf( '<%4$s class="listing-details-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $details, $wrap );
	
	// Display an individual detail if required
	
	if( ! empty( $detail_id ) ) {
	
		$detail_data = wpsight_get_standard_detail( $detail_id );
		
		$detail_single = '';
			
		$detail_single .= '<span class="listing-details-sc-detail ' . $detail_data['id'] . '">';
		$detail_single .= '<span class="label">' . $detail_data['label'] . '</span>';
		$detail_single .= '<span class="value">' . get_post_meta( $id, '_' . $detail_data['id'], true ) . ' ' . wpsight_get_measurement_units( $detail_data['unit'] ) . '</span>';
		$detail_single .= '</span><!-- .listing-details-sc-' . $detail_data['id'] . ' -->';
		
		if( ! empty( $detail_single ) )
			$output = sprintf( '<%4$s class="listing-details-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $detail_single, $wrap );
	
	}

	return apply_filters( 'wpsight_listing_details_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing details overview
 *
 * @since 1.1
 */
 
add_shortcode( 'listing_details_short', 'wpsight_listing_details_short_shortcode' );
 
function wpsight_listing_details_short_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'nr'	 => apply_filters( 'wpsight_get_listing_details_nr', 3 ),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'div'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Get details	
	$details = wpsight_get_listing_details( $id, $nr );

	$output = sprintf( '<%4$s class="listing-details-short-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $details, $wrap );

	return apply_filters( 'wpsight_listing_details_short_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing details table
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_details_table', 'wpsight_listing_details_table_shortcode' );
 
function wpsight_listing_details_table_shortcode( $atts ) {

	$defaults = array(
		'id'	 	=> get_the_ID(),
		'before' 	=> '',
		'after'  	=> '',
		'empty'		=> 'true',
		'wrap'	 	=> 'div'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Open table
	$details = '<table class="table table-striped table-compare">';
	
	// Add listing ID first
	
	$details .= '<tr class="listing-details-sc-detail table-compare-id">';
	$details .= '<td class="table-compare-label">' . __( 'ID', 'wpsight' ) . ':</td>';
	$details .= '<td class="table-compare-value">' . wpsight_get_listing_id() . '</td>';
	$details .= '</tr><!-- .table-compare-id -->';
	
	// Loop through standard details
	
	foreach( wpsight_standard_details() as $detail => $v ) {
	
		// Don't show detail if label is emtpy in options
		
		$standard_details_option = wpsight_get_option( $detail );
		
		if( empty( $standard_details_option['label'] ) )
			continue;
	
		// Apply filter to optionally deactivate single detail
		if( apply_filters( 'wpsight_listing_details_table_' . $detail, true ) != true )
			continue;
	
		$detail_meta = get_post_meta( $id, '_' . $detail, true );
		
		if( ! $detail_meta && $empty != 'true' )
			continue;
		
		$detail_value = $detail_meta ? $detail_meta . ' ' . wpsight_get_measurement_units( $v['unit'] ) : __( 'n/d', 'wpsight' );
	
		$details .= '<tr class="listing-details-sc-detail ' . $detail . '">';
		$details .= '<td class="table-compare-label">' . $v['label'] . ':</td>';
		$details .= '<td class="table-compare-value">' . $detail_value . '</td>';
		$details .= '</tr><!-- .listing-details-sc-' . $detail . ' -->';
		
	}
	
	// Add listing price at the end
	
	$details .= '<tr class="listing-details-sc-detail table-compare-price">';
	$details .= '<td class="table-compare-value" colspan="2">' . wpsight_get_price() . '</td>';
	$details .= '</tr><!-- .table-compare-price -->';
	
	// Close table
	$details .= '</table><!-- .table-compare -->';

	$output = sprintf( '<%4$s class="listing-details-table-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $details, $wrap );

	return apply_filters( 'wpsight_listing_details_table_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing URL
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_url', 'wpsight_listing_url_shortcode' );
 
function wpsight_listing_url_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$url = get_permalink( $id );

	$output = sprintf( '<%4$s class="listing-url-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $url, $wrap );

	return apply_filters( 'wpsight_listing_url_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing raw URL
 *
 * @since 1.2
 */
 
add_shortcode( 'listing_url_raw', 'wpsight_listing_url_raw_shortcode' );
 
function wpsight_listing_url_raw_shortcode( $atts ) {

	$defaults = array(
		'id' => get_the_ID()
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	$url = get_permalink( $id );

	return apply_filters( 'wpsight_listing_url_raw_shortcode', $url, $atts );

}

/**
 * Shortcode to output listing QR
 *
 * @since 1.1
 */
 
add_shortcode( 'listing_qr', 'wpsight_listing_qr_shortcode' );
 
function wpsight_listing_qr_shortcode( $atts ) {

	$defaults = array(
		'id'	 => get_the_ID(),
		'size' 	 => '150',
		'image'	 => 'true',
		'before' => '',
		'after'  => '',
		'wrap'	 => 'span'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Get QR url
	$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=' . $size . 'x' . $size . '&chld=H|0&chl=' . urlencode( get_permalink( $id ) );
	
	// Create image tag
	if( $image == 'true' )
		$qr = '<img src="' . $qr . '" width="' . $size . '" height="' . $size . '" alt="" />';

	$output = sprintf( '<%4$s class="listing-qr-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $qr, $wrap );

	return apply_filters( 'wpsight_listing_qr_shortcode', $output, $atts );

}

/**
 * Shortcode to output listing terms
 *
 * @since 1.1
 */

add_shortcode( 'listing_terms', 'wpsight_listing_terms_shortcode' );

function wpsight_listing_terms_shortcode( $atts ) {

	$defaults = array(
		'id'	   	  => get_the_ID(),
		'link'	 	  => 'true',
	    'sep'	 	  => ' &rsaquo; ',
		'term_before' => '',
		'term_after'  => '',
	    'before'   	  => '',
	    'after'    	  => '',
	    'taxonomy' 	  => 'feature',
	    'wrap'	   	  => 'span'
	);

	extract( shortcode_atts( $defaults, $atts ) );
	
	// Set property-type
	
	if( WPSIGHT_DOMAIN == 'wpcasa' && $taxonomy == 'listing-type' )
		$taxonomy = 'property-type';
		
	// Set property-category
	
	if( WPSIGHT_DOMAIN == 'wpcasa' && $taxonomy == 'listing-category' )
		$taxonomy = 'property-category';
	
	// Get terms
	$terms = wpsight_get_the_term_list( $id, $taxonomy, $sep, $term_before, $term_after, $link );
	
	// Stop if no terms
	if ( is_wp_error( $terms ) || empty( $terms ) )
		return false;

	$output = sprintf( '<%4$s class="listing-%5$s-terms-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $terms, $wrap, $taxonomy );

	return apply_filters( 'wpsight_listing_terms_shortcode', $output, $terms, $atts );

}

/**
 * Shortcode to output listing map
 *
 * @since 1.1
 */
 
add_shortcode( 'listing_map', 'wpsight_listing_map_shortcode' );
 
function wpsight_listing_map_shortcode( $atts ) {

	$defaults = array(
		'id'	 	   => get_the_ID(),
		'map_type' 	   => 'ROADMAP',
		'zoom' 		   => '14',
		'streetview'   => 'true',
		'control_type' => 'false',
		'control_nav'  => 'true',
        'scrollwheel'  => 'false',
        'before'	   => '',
		'after'  	   => '',
		'wrap'	 	   => 'div'
	);
	
	extract( shortcode_atts( $defaults, $atts ) );
	
	// Get post custom data
        
	$custom = get_post_custom( $id );
	
	// Get marker address or geo code
	
	if( ! empty( $custom['_map_geo'][0] ) ) {
	    $marker = 'latLng:[' . $custom['_map_geo'][0] . ']';        		
	} elseif( ! empty( $custom['_map_address'][0] ) ) {        	
	    $marker = 'address: "' . $custom['_map_address'][0] . '"';        		
	}
	
	if( empty( $marker ) || ! current_theme_supports( 'gmaps' ) )
		return;
	
	$listing_location = '<script type="text/javascript">
	    jQuery(document).ready(function($){
	        $(".listing-location-map").gmap3({
	    		' . $marker . ',
	    		map:{
	    		  options:{
	    	  	  	zoom: ' . $zoom . ',
	    	  	  	mapTypeId: google.maps.MapTypeId.' . $map_type . ',
	    		  	mapTypeControl: ' . $control_type . ',
	    		  	navigationControl: ' . $control_nav . ',
	    		  	scrollwheel: ' . $scrollwheel . ',
	    		  	streetViewControl: ' . $streetview . '
	    		  }
	    		}
	    	});	            
	    });
	</script>';
	    
	$listing_location .= '<div class="listing-location-map"></div>';

	$output = sprintf( '<%4$s class="listing-map-sc">%1$s%3$s%2$s</%4$s>', $before, $after, $listing_location, $wrap );

	return apply_filters( 'wpsight_listing_map_shortcode', $output, $atts );

}

/**
 * Run shortcodes at priority 7 not 11 (default)
 * to make sure wpautop() works properly.
 *
 * @since 1.2
 * @see http://www.viper007bond.com/2009/11/22/wordpress-code-earlier-shortcodes/
 */
 
add_filter( 'the_content', 'wpsight_run_listing_shortcodes_earlier', 7 );

function wpsight_run_listing_shortcodes_earlier( $content ) {

    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
    
    // Register listing shortcodes
 
    add_shortcode( 'listing_id', 'wpsight_listing_id_shortcode' );
    add_shortcode( 'listing_title', 'wpsight_listing_title_shortcode' );
    add_shortcode( 'listing_image', 'wpsight_listing_image_shortcode' );
    add_shortcode( 'listing_description', 'wpsight_listing_description_shortcode' );
    add_shortcode( 'listing_price', 'wpsight_listing_price_shortcode' );
    add_shortcode( 'listing_status', 'wpsight_listing_status_shortcode' );
    add_shortcode( 'listing_details', 'wpsight_listing_details_shortcode' );
    add_shortcode( 'listing_details_short', 'wpsight_listing_details_short_shortcode' );
    add_shortcode( 'listing_terms', 'wpsight_listing_terms_shortcode' );
    add_shortcode( 'listing_url', 'wpsight_listing_url_shortcode' );
    add_shortcode( 'listing_url_raw', 'wpsight_listing_url_raw_shortcode' );
    add_shortcode( 'listing_qr', 'wpsight_listing_qr_shortcode' );
    add_shortcode( 'listing_map', 'wpsight_listing_map_shortcode' );
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}