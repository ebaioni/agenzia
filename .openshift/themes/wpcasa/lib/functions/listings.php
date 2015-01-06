<?php
/**
 * Create standard features array
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_standard_details' ) ) {

	function wpsight_standard_details() {
	
		// Set standard details
	
		$standard_details = array(
		
	    	'details_1' => array(
	    		'id' 		  => 'details_1',
	    		'label'		  => __( 'Detail', 'wpsight' ) . ' #1',
	    		'unit'		  => false,
	    		'data' 		  => false,
	    		'description' => '',
	    		'position'	  => 10
	    	),
	    	'details_2'	=> array(
	    		'id' 		  => 'details_2',
	    		'label'		  => __( 'Detail', 'wpsight' ) . ' #2',
	    		'unit'		  => false,
	    		'data' 		  => false,
	    		'description' => '',
	    		'position'	  => 20
	    	),
	    	'details_3' => array(
	    		'id' 		  => 'details_3',
	    		'label'		  => __( 'Detail', 'wpsight' ) . ' #3',
	    		'unit'		  => false,
	    		'data'		  => false,
	    		'description' => '',
	    		'position'	  => 30
	    	)
	    	
	    );
	    
	    // Apply filter to array    
	    $standard_details = apply_filters( 'wpsight_standard_details', $standard_details );
	    
	    // Sort array by position        
	    $standard_details = wpsight_sort_array_by_position( $standard_details );
		
		// Return array    
	    return $standard_details;
	
	}

}

/**
 * Get standard detail value from key
 *
 * @since 1.1
 */
 
function wpsight_get_standard_detail( $detail ) {

	$standard_details = wpsight_standard_details();
	
	return $standard_details[$detail];
	
}

/**
 * Filter standard details and update if
 * label and/or unit have been updated on options page
 *
 * @since 1.0
 */

add_filter( 'wpsight_standard_details', 'wpsight_check_standard_details', 20 );

function wpsight_check_standard_details( $standard_details ) {

	// Just return originals on reset

	if( isset( $_POST['reset'] ) )
		return $standard_details;
		
	// Loop through details and check against database

	foreach( $standard_details as $detail => $value ) {
	
		$standard_details_option = wpsight_get_option( $detail );
		
		if( ! empty( $standard_details_option ) ) {
			$standard_details[$detail]['label'] = $standard_details_option['label'];
			$standard_details[$detail]['unit'] = $standard_details_option['unit'];
		}
	
	}
	
	return $standard_details;

}

/**
 * Create listing details
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_listing_details' ) ) {

	function wpsight_get_listing_details( $post_id = '', $details_nr = '', $details = false ) {
	
		// Get post ID from $post_id
	
		if( empty( $post_id ) )
			$post_id = get_the_ID();	
		
		// If still empty, return false
		
		if( empty( $post_id ) )
			return false;
	
		// Get post custom data
	
		$post_custom = get_post_custom( $post_id );
		
		// Get standard details
		
		$standard_details = wpsight_standard_details();
		
		// Create markup
		
		$listing_details  = '<div class="listing-details-overview clearfix">';
		
		// Loop through details
		
		if( empty( $details_nr ) )
			$details_nr = apply_filters( 'wpsight_get_listing_details_nr', 3 );
			
		// Check if specific details
		
		$details = apply_filters( 'wpsight_get_listing_details', $details );
		
		if( is_array( $details ) ) {
		
			foreach( $details as $detail ) {
			
				$pos = strpos( $detail, '_' );
				
				if ( $pos !== false && $pos == 0 )
    				$detail = substr_replace( $detail, '', $pos, strlen( '_' ) );
			
				if( ! empty( $post_custom['_' . $detail][0] ) ) {
				
					$i = 1;
				
					// Get listing detail
					$listing_detail   = wpsight_get_standard_detail( $detail );
					
					$listing_details .= '<span class="listing-' . wpsight_dashes( $detail ) . ' listing-details-detail" title="' . $listing_detail['label'] . '">';
					$listing_details .= $post_custom['_' . $detail][0] . ' ';
					$listing_details .= wpsight_get_measurement_units( $standard_details[$detail]['unit'] );
					$listing_details .= '</span><!-- .listing-' . wpsight_dashes( $detail ) . ' -->' . "\n";
					
					$i++;

				}
			
			}
		
		} else {
		
			for( $i = 1; $i <= $details_nr; $i++ ) {
			
				if( ! isset( $post_custom['_details_' . $i][0] ) )
					continue;
				
				$listing_detail_value = $post_custom['_details_' . $i][0];
				
				if( ! empty( $listing_detail_value ) ) {
				
					// Get listing detail
					$listing_detail   = wpsight_get_standard_detail( 'details_' . $i );
					
					$listing_details .= '<span class="listing-details-' . $i . ' listing-details-detail" title="' . $listing_detail['label'] . '">';
					
					// Check if value is data key
					
					if( ! empty( $listing_detail['data'] ) )
						$listing_detail_value = $listing_detail['data'][$listing_detail_value];
					
					$listing_details .= $listing_detail_value . ' ';
					$listing_details .= wpsight_get_measurement_units( $standard_details['details_' . $i]['unit'] );
					$listing_details .= '</span><!-- .listing-details-' . $i . ' -->' . "\n";

				}
			
			}
		
		}
			
		// Display formatted listing price
				    
		$listing_details .= '<span class="listing-price">' . wpsight_get_price( $post_id ) . '</span><!-- .listing-price -->' . "\n";
		
		// Close markup
		
		$listing_details .= '</div><!-- .listing-details -->';
		
		return apply_filters( 'wpsight_listing_details', $listing_details );
	
	}

}

/**
 * Echo listing details
 *
 * @since 1.0
 */
 
function wpsight_listing_details( $post_id = '', $details_nr = '' ) {

	echo wpsight_get_listing_details( $post_id, $details_nr );

}

/**
 * Get listing ID
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_listing_id' ) ) {

	function wpsight_get_listing_id( $post_id = '' ) {
	
		// Get post ID from $post_id
	
		if( empty( $post_id ) )
			$post_id = get_the_ID();	
		
		// If still empty, return false
		
		if( empty( $post_id ) )
			return false;
			
		// Get listing ID prefix
		
		$prefix = wpsight_get_option( 'listing_id' );
		
		if( ! isset( $prefix ) )
			$prefix = wpsight_get_option( 'listing_id', true );
		
		//$prefix = "Rif. ";
		// Built listing ID
		
		$listing_id = $prefix . $post_id;
		
		// Get old wpCasa option
		
		$property_id = wpsight_get_option( 'property_id' );
		if( ! empty( $property_id ) )
			$listing_id = $property_id . $post_id;
		
		// Use custom ID if set			
		$listing_id_meta = get_post_meta( $post_id, '_listing_id', true );
		
		// Get old wpCasa meta		
		$property_id_meta = get_post_meta( $post_id, '_property_id', true );
		
		if( ! empty( $property_id_meta ) && empty( $listing_id_meta ) )
			$listing_id_meta = $property_id_meta;
		
		if( ! empty( $listing_id_meta ) )
			$listing_id = $listing_id_meta;
			
		return apply_filters( 'wpsight_listing_id', $listing_id );
	
	}

}

/**
 * Echo listing ID
 *
 * @since 1.0
 */
 
function wpsight_listing_id( $post_id = '' ) {

	echo wpsight_get_listing_id( $post_id );

}

/**
 * Get listing price value
 *
 * @since 1.1
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_price_value' ) ) {

	function wpsight_get_price_value( $post_id = '', $number_format = true, $currency = true, $show_period = true ) {
	
		// Get post ID from $post_id
	
		if( empty( $post_id ) )
			$post_id = get_the_ID();	
		
		// If still empty, return false
		
		if( empty( $post_id ) )
			return false;
			
		// Get custom fields
			
		$custom_fields 	= get_post_custom( $post_id );
		$listing_price 	= isset( $custom_fields['_price'][0] ) ? $custom_fields['_price'][0] : false;
		$listing_status = isset( $custom_fields['_price_status'][0] ) ? $custom_fields['_price_status'][0] : false;
		$rental_period	= isset( $custom_fields['_price_period'][0] ) ? $custom_fields['_price_period'][0] : false;
		
		// Return false if no price
		
		if( empty( $listing_price ) )
			return false;
		
		if( $number_format == true ) {
		
			$listing_price_arr = false;
			
			// Remove white spaces
			$listing_price = preg_replace( '/\s+/', '', $listing_price );
		
			if( strpos( $listing_price, ',' ) )
				$listing_price_arr = explode( ',', $listing_price );
				
			if( strpos( $listing_price, '.' ) )
				$listing_price_arr = explode( '.', $listing_price );
				
			if( is_array( $listing_price_arr ) )
				$listing_price = $listing_price_arr[0];
			
			// remove dots and commas
			
			$listing_price = str_replace( '.', '', $listing_price );
			$listing_price = str_replace( ',', '', $listing_price );
			
			if( is_numeric( $listing_price ) ) {
				
				// Get thousands separator
				$listing_price_format = wpsight_get_option( 'currency_separator', true );
				
				// Add thousands separators
			
				if( $listing_price_format == 'dot' ) {			
					$listing_price = number_format( $listing_price, 0, ',', '.' );				
					if( is_array( $listing_price_arr ) )
						$listing_price .= ',' . $listing_price_arr[1];
				} else {			
					$listing_price = number_format( $listing_price, 0, '.', ',' );
					if( is_array( $listing_price_arr ) )
						$listing_price .= '.' . $listing_price_arr[1];
				}
				
			}
		
		} // endif $number_format	
				
		// Get currency symbol and place before or after value			
		$currency_symbol = wpsight_get_option( 'currency_symbol', true );
		
		// Create price markup and place currency before or after value
		
		if( $currency_symbol == 'after' ) {			
		    $listing_price_symbol  = '<span class="listing-price-value">' . $listing_price . '</span><!-- .listing-price-value -->';
		    
		    // Optionally add currency symbol
		    
		    if( $currency == true )
		    	$listing_price_symbol .= '<span class="listing-price-symbol">' . wpsight_get_currency() . '</span><!-- .listing-price-symbol -->';
		    
		} else {
		
			// Optionally add currency symbol
		
			if( $currency == true )
		    	$listing_price_symbol  = '<span class="listing-price-symbol">' . wpsight_get_currency() . '</span><!-- .listing-price-symbol -->';
		    	
		    $listing_price_symbol .= '<span class="listing-price-value">' . $listing_price . '</span><!-- .listing-price-value -->';
		    
		} // endif $currency_symbol
		
		// Merge price with markup and currency			
		$listing_price = $listing_price_symbol;
		
		// Add period if listing is for rent and period is set
		
		if( $show_period == true ) {
		
			$rental_period = get_post_meta( $post_id, '_price_period', true );
		
			if( $listing_status == 'rent' && ! empty( $rental_period ) ) {
			
			    $listing_price = $listing_price . ' <span class="listing-rental-period">/ ' . wpsight_get_rental_period( $rental_period ) . '</span><!-- .listing-rental-period -->';
			
			}
		
		} // endif $show_period
		
		// Return price value
		return apply_filters( 'wpsight_listing_price_value', $listing_price );
	
	}

}

/**
 * Echo listing price value
 *
 * @since 1.1
 */

function wpsight_price_value( $post_id = '', $number_format = true, $currency = true, $show_period = true ) {

	echo wpsight_get_price_value( $post_id, $number_format, $currency, $show_period );

}

/**
 * Get raw listing price value (no HTML)
 *
 * @since 1.1
 */
 
function wpsight_get_price_value_raw( $post_id = '', $number_format = true, $currency = true, $show_period = true ) {

	return strip_tags( wpsight_get_price_value( $post_id, $number_format, $currency, $show_period ) );

}

/**
 * Echo raw listing price value (no HTML)
 *
 * @since 1.1
 */
 
function wpsight_price_value_raw( $post_id = '', $number_format = true, $currency = true, $show_period = true ) {

	echo wpsight_get_price_value_raw( $post_id, $number_format, $currency, $show_period );

}

/**
 * Set listing price format
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_price' ) ) {

	function wpsight_get_price( $post_id = '' ) {
	
		// Get post ID from $post_id
	
		if( empty( $post_id ) )
			$post_id = get_the_ID();	
		
		// If still empty, return false
		
		if( empty( $post_id ) )
			return false;
			
		// Set listing price labels
		
		$listing_price_labels = array(
			'sold' 	  => __( 'Sold', 'wpsight'  ),
			'rented'  => __( 'Rented', 'wpsight'  ),
			'request' => __( 'Price on request', 'wpsight' )
		);
		
		$listing_price_labels = apply_filters( 'wpsight_get_price_labels', $listing_price_labels );
			
		// Get listing price
		$listing_price = wpsight_get_price_value();
			
		// Get custom fields
			
		$custom_fields 			= get_post_custom( $post_id );
		$listing_status 		= isset( $custom_fields['_price_status'][0] ) ? $custom_fields['_price_status'][0] : false;
		$listing_availability 	= isset( $custom_fields['_price_sold_rented'][0] ) ? $custom_fields['_price_sold_rented'][0] : false;
		
		// Create price output
		
		if( ! empty( $listing_availability ) ) {
		
			// When listing is not available
			
			$sold_rented = ( $listing_status == 'sale' ) ? $listing_price_labels['sold'] : $listing_price_labels['rented'];
			
			// Display sold/rented bold red in admin
			$style = is_admin() ? ' style="color:red;font-weight:bold"' : false;
			
			$listing_price = '<span class="listing-price-sold-rented"' . $style . '>' . $sold_rented . '</span><!-- .listing-price-sold-rented -->';
			
			if( is_admin() )
				$listing_price .= '<br />' . wpsight_get_price_value();
			
		} elseif( empty( $listing_price ) ) {
			
			// When no price available Price on request
			$listing_price = '<span class="listing-price-on-request">' . $listing_price_labels['request'] . '</span><!-- .listing-price-on-request -->';
		
		}
	
		return apply_filters( 'wpsight_listing_price', $listing_price );
	
	}

}

/**
 * Echo formatted listing price
 *
 * @since 1.0
 */

function wpsight_price( $post_id = '' ) {

	echo wpsight_get_price( $post_id );

}

/**
 * Create rental periods array
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_rental_periods' ) ) {

	function wpsight_rental_periods() {
	
		// Set rental periods
	
		$rental_periods = array(
			
	    	'rental_period_1' => __( 'per Month', 'wpsight' ),
	    	'rental_period_2' => __( 'per Week', 'wpsight' ),
	    	'rental_period_3' => __( 'per Year', 'wpsight' ),
	    	'rental_period_4' => __( 'per Day', 'wpsight' )
	    	
	    );
	    
	    return apply_filters( 'wpsight_rental_periods', $rental_periods );
	
	}

}

/**
 * Filter standard rental periods and update if
 * label has been updated on options page
 *
 * @since 1.0
 */

add_filter( 'wpsight_rental_periods', 'wpsight_check_rental_periods', 10 );

function wpsight_check_rental_periods( $rental_periods ) {

	// Just return originals on reset

	if( isset( $_POST['reset'] ) )
		return $rental_periods;
		
	// Loop through periods and check against database

	foreach( $rental_periods as $period => $value ) {
	
		$rental_periods_option = wpsight_get_option( $period );
		
		if( ! empty( $rental_periods_option ) )
			$rental_periods[$period] = $rental_periods_option;
	
	}
	
	return $rental_periods;

}

/**
 * Get rental period value from period key
 *
 * @since 1.0
 */
 
function wpsight_get_rental_period( $period ) {

	$rental_periods = wpsight_rental_periods();
	
	return $rental_periods[$period];
	
}

/**
 * Create listing statuses array
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_listing_statuses' ) ) {

	function wpsight_listing_statuses() {
	
		// Set listing statuses
	
		$listing_statuses = array(
		
	    	'sale' => __( 'for Sale', 'wpsight' ),
	    	'rent' => __( 'for Rent', 'wpsight' )
	    	
	    );
	    
	    return apply_filters( 'wpsight_listing_statuses', $listing_statuses );
	
	}

}

/**
 * Get listing status value from status key
 *
 * @since 1.0
 */
 
function wpsight_get_listing_status( $status ) {

	$listing_statuses = wpsight_listing_statuses();
	
	return $listing_statuses[$status];
	
}

/**
 * Filter standard listing statuses and update if
 * label has been updated on options page
 *
 * @since 1.0
 */

add_filter( 'wpsight_listing_statuses', 'wpsight_check_listing_statuses', 10 );

function wpsight_check_listing_statuses( $listing_statuses ) {

	// Just return originals on reset

	if( isset( $_POST['reset'] ) )
		return $listing_statuses;
		
	// Loop through statuses and check against database

	foreach( $listing_statuses as $status => $value ) {
	
		$listing_status_option = wpsight_get_option( $status );
		
		if( ! empty( $listing_status_option ) )
			$listing_statuses[$status] = $listing_status_option;
	
	}
	
	return $listing_statuses;

}

/**
 * Set measurement units
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_measurement_units' ) ) {

	function wpsight_measurement_units() {
	
		$default = array(
			'' 		=> '',
			'm2' 	=> 'm&sup2;',
			'sqft'  => 'sq ft',
			'sqyd' 	=> 'sq yd',
			'acres' => 'acre(s)'
		);
		
		return apply_filters( 'wpsight_measurement_units', $default );
		
	}

}

/**
 * Get measurement value from unit key
 *
 * @since 1.0
 */
 
function wpsight_get_measurement_units( $unit ) {

	$measurements = wpsight_measurement_units();
	
	return $measurements[$unit];
	
}

/**
 * Set currencies
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_currencies' ) ) {

	function wpsight_currencies() {
	
		$currencies = array(		
		    'aed' => __( 'AED => United Arab Emirates Dirham', 'wpsight'  ),
		    'ang' => __( 'ANG => Netherlands Antillean Guilder', 'wpsight'  ),
		    'ars' => __( 'ARS => Argentine Peso', 'wpsight'  ),
		    'aud' => __( 'AUD => Australian Dollar', 'wpsight'  ),
		    'bdt' => __( 'BDT => Bangladeshi Taka', 'wpsight'  ),
		    'bgn' => __( 'BGN => Bulgarian Lev', 'wpsight'  ),
		    'bhd' => __( 'BHD => Bahraini Dinar', 'wpsight'  ),
		    'bnd' => __( 'BND => Brunei Dollar', 'wpsight'  ),
		    'bob' => __( 'BOB => Bolivian Boliviano', 'wpsight'  ),
		    'brl' => __( 'BRL => Brazilian Real', 'wpsight'  ),
		    'bwp' => __( 'BWP => Botswanan Pula', 'wpsight'  ),
		    'cad' => __( 'CAD => Canadian Dollar', 'wpsight'  ),
		    'chf' => __( 'CHF => Swiss Franc', 'wpsight'  ),
		    'clp' => __( 'CLP => Chilean Peso', 'wpsight'  ),
		    'cny' => __( 'CNY => Chinese Yuan', 'wpsight'  ),
		    'cop' => __( 'COP => Colombian Peso', 'wpsight'  ),
		    'crc' => __( 'CRC => Costa Rican Colon', 'wpsight'  ),
		    'czk' => __( 'CZK => Czech Republic Koruna', 'wpsight'  ),
		    'dkk' => __( 'DKK => Danish Krone', 'wpsight'  ),
		    'dop' => __( 'DOP => Dominican Peso', 'wpsight'  ),
		    'dzd' => __( 'DZD => Algerian Dinar', 'wpsight'  ),
		    'eek' => __( 'EEK => Estonian Kroon', 'wpsight'  ),
		    'egp' => __( 'EGP => Egyptian Pound', 'wpsight'  ),
		    'eur' => __( 'EUR => Euro', 'wpsight'  ),
		    'fjd' => __( 'FJD => Fijian Dollar', 'wpsight'  ),
		    'gbp' => __( 'GBP => British Pound', 'wpsight'  ),
		    'hkd' => __( 'HKD => Hong Kong Dollar', 'wpsight'  ),
		    'hnl' => __( 'HNL => Honduran Lempira', 'wpsight'  ),
		    'hrk' => __( 'HRK => Croatian Kuna', 'wpsight'  ),
		    'huf' => __( 'HUF => Hungarian Forint', 'wpsight'  ),
		    'idr' => __( 'IDR => Indonesian Rupiah', 'wpsight'  ),
		    'ils' => __( 'ILS => Israeli New Sheqel', 'wpsight'  ),
		    'inr' => __( 'INR => Indian Rupee', 'wpsight'  ),
		    'jmd' => __( 'JMD => Jamaican Dollar', 'wpsight'  ),
		    'jod' => __( 'JOD => Jordanian Dinar', 'wpsight'  ),
		    'jpy' => __( 'JPY => Japanese Yen', 'wpsight'  ),
		    'kes' => __( 'KES => Kenyan Shilling', 'wpsight'  ),
		    'krw' => __( 'KRW => South Korean Won', 'wpsight'  ),
		    'kwd' => __( 'KWD => Kuwaiti Dinar', 'wpsight'  ),
		    'kyd' => __( 'KYD => Cayman Islands Dollar', 'wpsight'  ),
		    'kzt' => __( 'KZT => Kazakhstani Tenge', 'wpsight'  ),
		    'lbp' => __( 'LBP => Lebanese Pound', 'wpsight'  ),
		    'lkr' => __( 'LKR => Sri Lankan Rupee', 'wpsight'  ),
		    'ltl' => __( 'LTL => Lithuanian Litas', 'wpsight'  ),
		    'lvl' => __( 'LVL => Latvian Lats', 'wpsight'  ),
		    'mad' => __( 'MAD => Moroccan Dirham', 'wpsight'  ),
		    'mdl' => __( 'MDL => Moldovan Leu', 'wpsight'  ),
		    'mkd' => __( 'MKD => Macedonian Denar', 'wpsight'  ),
		    'mur' => __( 'MUR => Mauritian Rupee', 'wpsight'  ), 
		    'mvr' => __( 'MVR => Maldivian Rufiyaa', 'wpsight'  ),
		    'mxn' => __( 'MXN => Mexican Peso', 'wpsight'  ),
		    'myr' => __( 'MYR => Malaysian Ringgit', 'wpsight'  ),
		    'nad' => __( 'NAD => Namibian Dollar', 'wpsight'  ),
		    'ngn' => __( 'NGN => Nigerian Naira', 'wpsight'  ),
		    'nio' => __( 'NIO => Nicaraguan Cordoba', 'wpsight'  ),
		    'nok' => __( 'NOK => Norwegian Krone', 'wpsight'  ),
		    'npr' => __( 'NPR => Nepalese Rupee', 'wpsight'  ),
		    'nzd' => __( 'NZD => New Zealand Dollar', 'wpsight'  ),
		    'omr' => __( 'OMR => Omani Rial', 'wpsight'  ),
		    'pen' => __( 'PEN => Peruvian Nuevo Sol', 'wpsight'  ),
		    'pgk' => __( 'PGK => Papua New Guinean Kina', 'wpsight'  ),
		    'php' => __( 'PHP => Philippine Peso', 'wpsight'  ),
		    'pkr' => __( 'PKR => Pakistani Rupee', 'wpsight'  ),
		    'pln' => __( 'PLN => Polish Zloty', 'wpsight'  ),
		    'pyg' => __( 'PYG => Paraguayan Guarani', 'wpsight'  ),
		    'qar' => __( 'QAR => Qatari Rial', 'wpsight'  ),
		    'ron' => __( 'RON => Romanian Leu', 'wpsight'  ),
		    'rsd' => __( 'RSD => Serbian Dinar', 'wpsight'  ),
		    'rub' => __( 'RUB => Russian Ruble', 'wpsight'  ),
		    'sar' => __( 'SAR => Saudi Riyal', 'wpsight'  ), 
		    'scr' => __( 'SCR => Seychellois Rupee', 'wpsight'  ),
		    'sek' => __( 'SEK => Swedish Krona', 'wpsight'  ),
		    'sgd' => __( 'SGD => Singapore Dollar', 'wpsight'  ),
		    'skk' => __( 'SKK => Slovak Koruna', 'wpsight'  ),
		    'sll' => __( 'SLL => Sierra Leonean Leone', 'wpsight'  ),
		    'svc' => __( 'SVC => Salvadoran Colon', 'wpsight'  ),
		    'thb' => __( 'THB => Thai Baht', 'wpsight'  ),
		    'tnd' => __( 'TND => Tunisian Dinar', 'wpsight'  ),
		    'try' => __( 'TRY => Turkish Lira', 'wpsight'  ),
		    'ttd' => __( 'TTD => Trinidad and Tobago Dollar', 'wpsight'  ),
		    'twd' => __( 'TWD => New Taiwan Dollar', 'wpsight'  ),
		    'tzs' => __( 'TZS => Tanzanian Shilling', 'wpsight'  ),
		    'uah' => __( 'UAH => Ukrainian Hryvnia', 'wpsight'  ),
		    'ugx' => __( 'UGX => Ugandan Shilling', 'wpsight'  ),
		    'usd' => __( 'USD => US Dollar', 'wpsight'  ),
		    'uyu' => __( 'UYU => Uruguayan Peso', 'wpsight'  ),
		    'uzs' => __( 'UZS => Uzbekistan Som', 'wpsight'  ),
		    'vef' => __( 'VEF => Venezuelan Bolivar', 'wpsight'  ),
		    'vnd' => __( 'VND => Vietnamese Dong', 'wpsight'  ),
		    'xof' => __( 'XOF => CFA Franc BCEAO', 'wpsight'  ),
		    'yer' => __( 'YER => Yemeni Rial', 'wpsight'  ),
		    'zar' => __( 'ZAR => South African Rand', 'wpsight'  ),
		    'zmk' => __( 'ZMK => Zambian Kwacha', 'wpsight'  )		
		);
		
		return apply_filters( 'wpsight_currencies', $currencies );
		
	}

}

/**
 * Get currency abbreviation from theme options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_currency_abbr' ) ) {

	function wpsight_get_currency_abbr( $currency = '' ) {
	
		if( empty( $currency ) )
			$currency = wpsight_get_option( 'currency', 'eur' );
		
		// Check if there is a custom currency
		
		if( $currency != 'other' ) {
		
			return strtoupper( $currency );
		
		} else {
		
			return wpsight_get_option( 'currency_other' );
		
		}
		
	}

}

/**
 * Get currency HTML entity from theme options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_currency' ) ) {

	function wpsight_get_currency( $currency = '' ) {
	
		// Get currency from theme options
	
		if( empty( $currency ) )
			$currency = wpsight_get_option( 'currency', 'eur' );
			
		// Check if there is a custom currency
		
		if( $currency != 'other' ) {
			
			// Get currency abbreviation
		
			$currency = wpsight_get_currency_abbr( $currency );	
		
			// Create HTML entities
			
			if( $currency == 'EUR' ) {
				$currency_ent = '&euro;';
			}
			elseif( $currency == 'USD' ) {
				$currency_ent = '&#36;';
			}
			elseif( $currency == 'CAD' ) {
				$currency_ent = 'C&#36;';
			}
			elseif( $currency == 'GBP' ) {
				$currency_ent = '&pound;';
			}
			elseif( $currency == 'AUD' ) {
				$currency_ent = 'AU&#36;';
			}
			elseif( $currency == 'JPY' ) {
				$currency_ent = '&yen;';
			}
			elseif( $currency == 'CHF' ) {
				$currency_ent = ' SFr. ';
			}
			elseif( $currency == 'ILS' ) {
				$currency_ent = '&#8362;';
			}
			elseif( $currency == 'THB' ) {
				$currency_ent = '&#3647;';
			}
			
		} else {
		
			$currency_ent = wpsight_get_option( 'currency_other_ent' );
		
		}
		
		// If no entity, set three letter code
		
		if( empty( $currency_ent ) )
			$currency_ent = ' ' . $currency . ' ';
		
		return apply_filters( 'wpsight_currency', $currency_ent );
	
	}

}

/**
 * Echo currency HTML entity from theme options
 *
 * @since 1.0
 */

function wpsight_currency( $currency = '' ) {
	echo wpsight_get_currency( $currency );
}

/**
 * Author contact fields
 *
 * @since 1.1
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_profile_contact_fields' ) ) {

	function wpsight_profile_contact_fields() {
	
		$fields = array(
			'phone'    => array(
				'label' => __( 'Phone', 'wpsight' ),
				'icon'  => '<i class="icon-phone"></i> ',
				'url'	=> false
			),
			'facebook' => array(
				'label' => 'Facebook',
				'icon'  => '<i class="icon-facebook"></i> ',
				'url'	=> 'http://www.facebook.com/'
			),
			'twitter'  => array(
				'label' => 'Twitter',
				'icon'  => '<i class="icon-twitter"></i> ',
				'url'	=> 'http://twitter.com/'
			)
		);
		
		return apply_filters( 'wpsight_profile_contact_fields', $fields );
	
	}

}

/**
 * Custom author profile contact fields
 *
 * @since 1.1
 */
 
add_filter( 'user_contactmethods', 'wpsight_profile_contact_info' );
 
function wpsight_profile_contact_info( $fields ) {

	// Remove unnecessary fields
	
	unset( $fields['aim'] );
	unset( $fields['yim'] );
	unset( $fields['jabber'] );
	
	// Add custom fields
	
	foreach( wpsight_profile_contact_fields() as $k => $v ) {
		$fields[$k]	= $v['label'];
	}
	
	return apply_filters( 'wpsight_profile_contact_info', $fields );
}

/**
 * Add list listing option to profile
 *
 * @since 1.1
 */
 
add_action( 'show_user_profile', 'wpsight_profile_agent_exclude' );
add_action( 'edit_user_profile', 'wpsight_profile_agent_exclude' );
 
function wpsight_profile_agent_exclude( $user ) { ?>

    <table class="form-table">
        <tr>
            <th><label for="agent_exclude"><?php _e( 'Agent lists', 'wpsight' ); ?></label></th>
            <td>
                <input type="checkbox" value="1" name="agent_exclude" id="agent_exclude" style="margin-right:5px" <?php checked( get_the_author_meta( 'agent_exclude', $user->ID ), 1 ); ?>> <?php _e( 'Hide this user from agent list.', 'wpsight' ); ?>
            </td>
        </tr>
    </table><?php
    
}

add_action( 'personal_options_update', 'wpsight_profile_agent_exclude_save' );
add_action( 'edit_user_profile_update', 'wpsight_profile_agent_exclude_save' );

function wpsight_profile_agent_exclude_save( $user_id ) {

    if ( ! current_user_can( 'edit_user', $user_id ) )
        return false;
        
	$_POST['agent_exclude'] = isset( $_POST['agent_exclude'] ) ? $_POST['agent_exclude'] : false;

    update_user_meta( $user_id, 'agent_exclude', $_POST['agent_exclude'] );

}

/**
 * Create post class depending
 * on layout and active sidebars
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_archive_listing_class' ) ) {

	function wpsight_archive_listing_class( $counter, $parent_id = '' ) {
	
		$archive_layout = wpsight_get_archive_layout( 'listing' );
	
		$post_class = $archive_layout;
		
		if( WPSIGHT_LAYOUT == 'four' ) {
		
			if( is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing-archive' ) ) ) {
			
				// Respect full width layout
			
				if( is_singular() && get_post_meta( $parent_id, '_layout', true ) == 'full-width' && ! is_page_template( 'page-tpl-listings.php' ) && ! is_page_template( 'page-tpl-properties.php' ) && ! is_page_template( 'page-tpl-favorites.php' ) ) {
				
					// Correct column width depending on layout
					
			    	if( $archive_layout == 'span9' )
			    		$archive_layout = 'span12';
			    		
			    	if( $archive_layout == 'span3' ) {
			    		if( $counter == 1 || $counter%4 + 1 == 2 ) {
			    			$post_class = $post_class . ' clear';
			    		}
			    	} elseif( $archive_layout == 'span6' ) {
			    		if( $counter == 1 || $counter%2 != 0 ) {
							$post_class = $post_class . ' clear';
						}
			    	} elseif( $archive_layout == 'span12' ) {
			    		$post_class = 'clearfix';
			    	}
				
				} else {
				
					// Correct column width depending on layout
					
					if( $archive_layout == 'span6' || $archive_layout == 'span12' )
					    $archive_layout = 'span9';
					
					if( $archive_layout == 'span3' ) {
						$n = get_post_meta( $parent_id, '_layout', true ) == 'full-width' ? 4 : 3;
						if( $counter == 1 || $counter%$n + 1 == 2 ) {
						    $post_class = $post_class . ' clear';
						}				
					} elseif( $archive_layout == 'span9' ) {
					    $post_class = 'span9 clear';
					}
				
				}
				
			} else {
			
			    // Correct column width depending on layout
			    if( $archive_layout == 'span9' )
			    	$archive_layout = 'span12';
			    	
			    if( $archive_layout == 'span3' ) {
			    	if( $counter == 1 || $counter%4 + 1 == 2 ) {
			    		$post_class = $post_class . ' clear';
			    	}
			    } elseif( $archive_layout == 'span6' ) {
			    	if( $counter == 1 || $counter%2 != 0 ) {
						$post_class = $post_class . ' clear';
					}
			    } elseif( $archive_layout == 'span12' ) {
			    	$post_class = 'span12';
			    }
			
			}
		
		} else {
		
			if( is_active_sidebar( wpsight_get_sidebar( 'sidebar-listing-archive' ) ) ) {
			
				// Respect full width layout
			
				if( is_singular() && get_post_meta( $parent_id, '_layout', true ) == 'full-width' && ! is_page_template( 'page-tpl-listings.php' ) && ! is_page_template( 'page-tpl-properties.php' ) && ! is_page_template( 'page-tpl-favorites.php' ) ) {
				
					// Correct column width depending on layout
			    	if( $archive_layout == 'span9' )
			    		$archive_layout = 'span12';
			    		
			    	if( $archive_layout == 'span3' ) {
			    		if( $counter == 1 || $counter%4 + 1 == 2 ) {
			    			$post_class = $post_class . ' clear';
			    		}
			    	} elseif( $archive_layout == 'span6' ) {
			    		if( $counter == 1 || $counter%2 != 0 ) {
							$post_class = $post_class . ' clear';
						}
			    	} elseif( $archive_layout == 'span12' ) {
			    		$post_class = 'clearfix';
			    	}
				
				} else {
				
					// Correct column width depending on layout
					if( $archive_layout == 'span6' || $archive_layout == 'span12' )
					    $archive_layout = 'span8';
					
					if( $archive_layout == 'span4' ) {
						
						if(
							( get_post_meta( $parent_id, '_layout', true ) == 'full-width' && $counter%3 - 1 == 0 ) ||
						    ( get_post_meta( $parent_id, '_layout', true ) != 'full-width' && $counter%2 != 0 ) ||
							$counter == 1
						) {
						    $post_class = $post_class . ' clear';	
						}
											
					} elseif( $archive_layout == 'span8' ) {
					    $post_class = 'span8 clear';
					}
				
				}
			    
			} else {
			
			    // Correct column width depending on layout
			    if( $archive_layout == 'span8' )
			    	$archive_layout = 'span12';
			    	
			    if( $archive_layout == 'span4' ) {
			    	if( $counter == 1 || $counter%3 - 1 == 0 ) {
			    		$post_class = $post_class . ' clear';
			    	}
			    } elseif( $archive_layout == 'span6' ) {
			    	if( $counter == 1 || $counter%2 != 0 ) {
						$post_class = $post_class . ' clear';
					}
			    } elseif( $archive_layout == 'span12' ) {
			    	$post_class = 'span12';
			    }
			
			}
		
		}
		
		return $post_class;
			
	}

}

/**
 * Porperty loop title
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_listing_loop_title' ) ) {

	function wpsight_listing_loop_title() {
	
		global $wp_query, $post;
		
		$labels = array(	
			'search' 	   		=> __( 'Search Results', 'wpsight' ) . ': ',
			'tax_type_listing'  => __( 'Listing Type', 'wpsight' ) . ': ',
			'tax_type_property' => __( 'Property Type', 'wpsight' ) . ': ',
			'tax_feature'  		=> __( 'Feature', 'wpsight' ) . ': ',
			'tax_location' 		=> __( 'Location', 'wpsight' ) . ': ',
			'agent' 	   		=> __( 'Listing Agent', 'wpsight' ) . ': '	
		);
		
		$labels = apply_filters( 'wpsight_listing_loop_title_labels', $labels );
	
		if( is_search() ) {
		
		    $found = $wp_query->found_posts == 1 ? __( 'Listing', 'wpsight' ) : __( 'Listings', 'wpsight' );
		    $title = '<h2>' . $labels['search'] . ' ' . $wp_query->found_posts . ' ' . $found . '</h2>';
		
		} elseif( is_tax() ) {
		
		    if( is_tax( 'listing-type' ) ) {
		    	$title_tax = $labels['tax_type_listing'];
		    } elseif( is_tax( 'property-type' ) ) {
		    	$title_tax = $labels['tax_type_property'];
		    } elseif( is_tax( 'feature' ) ) {
		    	$title_tax = $labels['tax_feature'];
		    } elseif( is_tax( 'location' ) ) {
		    	$title_tax = $labels['tax_location'];
		    } else {
		    	$title_tax = false;
		    }
		    
		    $title = '<h1>' . $title_tax . ' ' . wpsight_get_tax_name() . '</h1>';
		
		} elseif( is_author() ) {
		
		    $author = $wp_query->get_queried_object();	    
		    $title  = '<h2>' . $labels['agent'] . ' ' . $author->display_name . '</h2>';
		
		} else {
		
		    $title = '<h1>' . get_the_title() . '</h1>';
		
		}
		
		if( ! empty( $title ) )
			return apply_filters( 'wpsight_listing_loop_title', $title );
			
	}

}

/**
 * Helper function to get taxonomy name
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_tax_name' ) ) {

	function wpsight_get_tax_name() {
	
		global $post;
	
		// loop through custom taxonomies	
		
		$current_term = array();
		
		$args = array(
		  'public'   => true,
		  '_builtin' => false		  
		);
		
		foreach( get_taxonomies( $args ) as $taxonomy ) {
		    $current_term[] = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
		}
		
		// remove empty to get current taxonomy	
		
		foreach( $current_term as $key => $value ) {
		    if( $value == '' ) {
		    	unset( $current_term[$key] );
		    }
		}
		
		$current_term = array_values( $current_term );
		
		return $current_term[0]->name;
		
	}

}

/**
 * Create print-friendly version
 *
 * @version 1.0
 */

// Add print to query vars

add_filter( 'query_vars', 'wpsight_print_query_vars' );

function wpsight_print_query_vars( $vars ) {

    $new_vars = array( 'print', 'pid' );
    $vars = array_merge( $new_vars, $vars );
    
    return $vars;
}

// Template redirect when print is set

add_action( 'template_redirect', 'wpsight_print_redirect' );

function wpsight_print_redirect() {
    
    global $wp, $wp_query;
    
    if( isset( $wp->query_vars['print'] ) ) {
        locate_template( '/listing-print.php', true, true );
        exit();
    }
    
}

/**
 * Helper function is_listing_single()
 *
 * @version 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'is_listing_single' ) ) {

	function is_listing_single() {
	
		if( is_singular() && get_post_type() == wpsight_listing_post_type() )
			return true;
		
		return false;
	
	}

}
