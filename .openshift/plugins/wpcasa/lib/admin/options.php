<?php

/**
 * Create theme options arrays
 * for different tabs and merge
 * to return wpsight_options()
 *
 * @package wpSight
 */
 
function wpsight_option_name() {
	$wpsight_options_settings = get_option( WPSIGHT_DOMAIN );
	$wpsight_options_settings['id'] = WPSIGHT_DOMAIN;
	update_option( WPSIGHT_DOMAIN, $wpsight_options_settings );
}
 
/**
 * Create theme options array
 * General options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_options_general' ) ) {

	function wpsight_options_general() {
			
		$options_general = array();
			
		$options_general['heading_general'] = array(
			'name' => __( 'General', 'wpsight' ),
			'id'   => 'heading_general',
			'type' => 'heading'
		);
		
		$options_general['logo'] = array( 
			'name' => __( 'Logo', 'wpsight' ),
			'desc' => __( 'Please enter a URL or upload an image.', 'wpsight' ),
			'id'   => 'logo',
			'std'  => WPSIGHT_IMAGES . '/logo.png',
			'type' => 'upload'
		);
		
		$options_general['logo_text'] = array( 
			'name' => __( 'Text Logo', 'wpsight' ),
			'desc' => __( 'Please enter a text logo that will be displayed instead of the above image logo.', 'wpsight' ),
			'id'   => 'logo_text',
			'type' => 'text'
		);
		
		$options_general['favicon'] = array( 
			'name' => __( 'Favicon', 'wpsight' ),
			'desc' => __( 'Please enter a URL or upload an image.', 'wpsight' ),
			'id'   => 'favicon',
			'type' => 'upload'
		);
								
		$options_general['custom_rss'] = array( 
			'name' => __( 'Custom RSS', 'wpsight' ),
			'desc' => __( 'Please enter a custom RSS URL (e.g. Feedburner).', 'wpsight' ),
			'id'   => 'custom_rss',
			'type' => 'text'
		);	
								
		$options_general['custom_css'] = array( 
			'name' => __( 'Custom CSS', 'wpsight' ),
			'desc' => __( 'Add custom css to the head of your theme.', 'wpsight' ),
			'id'   => 'custom_css',
			'type' => 'textarea'
		); 
		
		$options_general['tracking'] = array( 
			'name' => __( 'Tracking Code', 'wpsight' ),
			'desc' => __( 'Insert your tracking code here (e.g. Google Analytics). This code will be added to the footer of the theme.', 'wpsight' ),
			'id'   => 'tracking',
			'type' => 'textarea'
		);
				
		return apply_filters( 'wpsight_options_general', $options_general );
		
	}

}

/**
 * Create theme options array
 * Layout options
 *
 * @since 1.0
 */
 
// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_options_layout' ) ) {

	function wpsight_options_layout() {
	
		/** Check theme support of layout options */
	
		if( ! current_theme_supports( 'options-layout' ) )
			return;
		
		/** Create options array */
			
		$options_layout = array();
			
		$options_layout['heading_layout'] = array(
			'name' => __( 'Layout', 'wpsight' ),
			'id'   => 'heading_layout',
			'type' => 'heading'
		);
		
		$options_layout['header_right'] = array( 
			'name' 	   => __( 'Header Area', 'wpsight' ),
			'desc' 	   => __( 'You can add custom HTML and/or shortcodes, which will be automatically inserted into your theme.', 'wpsight' ),
			'std'  	   => __( 'Need expert advice? Call us now - 555 555 555', 'wpsight' ),
			'id'   	   => 'header_right',
			'settings' => array( 'textarea_rows' => 5 ),
			'type' 	   => 'editor'
		);
		
		if( WPSIGHT_LAYOUT == 'four' ) {
		
			$options_layout['archive_layout'] = array(
				'name' 	  => __( 'Archive Layout', 'wpsight' ),
				'desc' 	  => __( 'Please remember that the layout is also limited through the sidebar. If the archive sidebar is active, only option #1 and #3 will be possible.', 'wpsight' ),
				'id' 	  => 'archive_layout',
				'std' 	  => 'span9',
				'type' 	  => 'images',
				'options' => array(
					'span3'  => WPSIGHT_ADMIN_IMG_URL . '/archive-three.png',
					'span6'  => WPSIGHT_ADMIN_IMG_URL . '/archive-six.png',
					'span9'  => WPSIGHT_ADMIN_IMG_URL . '/archive-nine.png',
					'span12' => WPSIGHT_ADMIN_IMG_URL . '/archive-twelve.png'
				)
			);
		
		} else {
		
			$options_layout['archive_layout'] = array(
				'name' 	  => __( 'Archive Layout', 'wpsight' ),
				'desc' 	  => __( 'Please remember that the layout is also limited through the sidebar. If the archive sidebar is active, only option #1 and #3 will be possible.', 'wpsight' ),
				'id' 	  => 'archive_layout',
				'std' 	  => 'span8',
				'type' 	  => 'images',
				'options' => array(
					'span4'  => WPSIGHT_ADMIN_IMG_URL . '/archive-four.png',
					'span6'  => WPSIGHT_ADMIN_IMG_URL . '/archive-six.png',
					'span8'  => WPSIGHT_ADMIN_IMG_URL . '/archive-eight.png',
					'span12' => WPSIGHT_ADMIN_IMG_URL . '/archive-twelve.png'
				)
			);	
		
		}
		
		if( WPSIGHT_LAYOUT == 'four' ) {
		
			// Check if old property_archive_layout option was active
			$listing_archive_layout_std = wpsight_get_option( 'property_archive_layout' ) ? wpsight_get_option( 'property_archive_layout' ) : 'span3';
		
			$options_layout['listing_archive_layout'] = array(
				'name' 	  => __( 'Listing Archive Layout', 'wpsight' ),
				'desc' 	  => __( 'Please remember that the layout is also limited through the sidebar. If the listing archive sidebar is active, only option #1 and #3 will be possible.', 'wpsight' ),
				'id' 	  => 'listing_archive_layout',
				'std' 	  => $listing_archive_layout_std,
				'type' 	  => 'images',
				'options' => array(
					'span3'  => WPSIGHT_ADMIN_IMG_URL . '/archive-three.png',
					'span6'  => WPSIGHT_ADMIN_IMG_URL . '/archive-six.png',
					'span9'  => WPSIGHT_ADMIN_IMG_URL . '/archive-nine.png',
					'span12' => WPSIGHT_ADMIN_IMG_URL . '/archive-twelve.png'
				)
			);
		
		} else {
			
			// Check if old property_archive_layout option was active
			$listing_archive_layout_std = wpsight_get_option( 'property_archive_layout' ) ? wpsight_get_option( 'property_archive_layout' ) : 'span4';
		
			$options_layout['listing_archive_layout'] = array(
				'name' 	  => __( 'Listing Archive Layout', 'wpsight' ),
				'desc' 	  => __( 'Please remember that the layout is also limited through the sidebar. If the listing archive sidebar is active, only option #1 and #3 will be possible.', 'wpsight' ),
				'id' 	  => 'listing_archive_layout',
				'std' 	  => $listing_archive_layout_std,
				'type' 	  => 'images',
				'options' => array(
					'span4'  => WPSIGHT_ADMIN_IMG_URL . '/archive-four.png',
					'span6'  => WPSIGHT_ADMIN_IMG_URL . '/archive-six.png',
					'span8'  => WPSIGHT_ADMIN_IMG_URL . '/archive-eight.png',
					'span12' => WPSIGHT_ADMIN_IMG_URL . '/archive-twelve.png'
				)
			);	
		
		}
		
		$options_layout['credit'] = array( 
			'name' 	   => __( 'Credit', 'wpsight' ),
			'desc' 	   => __( 'You can add custom HTML and/or shortcodes, which will be automatically inserted into your theme.', 'wpsight' ) . ' ' . __(' Available shortcodes', 'wpsight' ) . ': <code>[the_year]</code>, <code>[site_link]</code>, <code>[wordpress_link]</code>, <code>[wpcasa_link]</code>, <code>[loginout_link]</code>',
			'std'  	   => '<div class="credit-left"><p>[the_year] - [site_link]</p></div>' . "\n" . '<div class="credit-right"><p>Powered by [wordpress_link] - Built on [wpcasa_link]</p></div>',
			'id'   	   => 'credit',
			'settings' => array( 'textarea_rows' => 5 ),
			'type' 	   => 'editor'
		);
				
		return apply_filters( 'wpsight_options_layout', $options_layout );
		
	}

}

/**
 * Create theme options array
 * Listings options
 *
 * @since 0.8
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_options_listings' ) ) {

	function wpsight_options_listings() {
	
		/** Define data arrays */
			
		$options_listings = array();
		
		$options_listings['heading_listings'] = array(
			'name' => __( 'Listings', 'wpsight' ),
			'id'   => 'heading_listings',
			'type' => 'heading'
		);
		
		// Check of old 'property_id' options was active
		$listing_id_std = wpsight_get_option( 'property_id' ) ? wpsight_get_option( 'property_id' ) : __( 'ID-', 'wpsight' );
		
		$options_listings['listing_id'] = array( 
			'name'  => __( 'Listing ID Prefix', 'wpsight' ),
			'id'    => 'listing_id',
			'desc'  => __( 'The listing ID will be this prefix plus post ID. You can optionally set individual IDs on the listing edit screen.', 'wpsight' ),
			'std'   => $listing_id_std,
			'class' => 'mini',
			'type'  => 'text'
		);
		
		$options_listings['measurement_unit'] = array( 
			'name' 	  => __( 'Measurement Unit', 'wpsight' ),
			'desc' 	  => __( 'Please select the general measurement unit. The unit for the listing standard features can be defined separately below.', 'wpsight' ),
			'id'   	  => 'measurement_unit',
			'std'  	  => 'm2',
			'class'   => 'mini',
			'type' 	  => 'select',
			'options' => array_filter( wpsight_measurement_units() )
		);
		
		$options_listings['currency'] = array( 
			'name' 	  => __( 'Currency', 'wpsight' ),
			'desc' 	  => __( 'Please select the currency for the listing prices. If your currency is not listed, please select <code>Other</code>.', 'wpsight' ),
			'id' 	  => 'currency',
			'std' 	  => 'usd',
			'class'   => 'mini',
			'type' 	  => 'select',
			'options' => array_merge( array_filter( wpsight_currencies() ), array( 'other' => __( 'Other', 'wpsight'  ) ) )
		);
		
		$options_listings['currency_other'] = array( 
			'name'  => __( 'Other Currency', 'wpsight' ) . ' (' . __( 'Abbreviation', 'wpsight' ) . ')',
			'id'    => 'currency_other',
			'desc'  => __( 'Please insert the abbreviation of your currency (e.g. <code>EUR</code>).', 'wpsight' ),
			'class' => 'hidden mini',
			'type'  => 'text'
		);
		
		$options_listings['currency_other_ent'] = array( 
			'name' 	=> __( 'Other Currency', 'wpsight' ) . ' (' . __( 'Symbol', 'wpsight' ) . ')',
			'id' 	=> 'currency_other_ent',
			'desc' 	=> __( 'Please insert the currency symbol or HTML entity (e.g. <code>&amp;euro;</code>).', 'wpsight' ),
			'class' => 'hidden mini',
			'type' 	=> 'text'
		);
		
		$options_listings['currency_symbol'] = array( 
			'name'    => __( 'Currency Symbol', 'wpsight' ),
			'desc'    => __( 'Please select the position of the currency symbol.', 'wpsight' ),
			'id'      => 'currency_symbol',
			'std'     => 'before',
			'type'    => 'radio',
			'options' => array( 'before' => __( 'Before the value', 'wpsight' ), 'after' => __( 'After the value', 'wpsight' ) )
		);
		
		$options_listings['currency_separator'] = array( 
			'name' 	  => __( 'Thousands Separator', 'wpsight' ),
			'desc' 	  => __( 'Please select the thousands separator for your listing prices.', 'wpsight' ),
			'id' 	  => 'currency_separator',
			'std' 	  => 'comma',
			'type' 	  => 'radio',
			'options' => array( 'comma' => __( 'Comma (e.g. 1,000,000)', 'wpsight' ), 'dot' => __( 'Period (e.g. 1.000.000)', 'wpsight' ) )
		);
		
		/** Toggle standard features */
		
		$options_listings['listing_features'] = array(
			'name' => __( 'Listing Features', 'wpsight' ),
			'desc' => __( 'Please check the box to edit the listing standard features.', 'wpsight' ),
			'id'   => 'listing_features',
			'std'  => '0',
			'type' => 'checkbox'
		);
		
		/** Loop through standard features */
		
		$i=1;
		
		foreach( wpsight_standard_details() as $feature_id => $value ) {
		
			$options_listings[$feature_id] = array(
			    'name' 	=> __( 'Standard Feature', 'wpsight' ) . ' #' . $i,
			    'id' 	=> $feature_id,
			    'desc' 	=> $value['description'],
			    'std'  	=> array( 'label' => $value['label'], 'unit' => $value['unit'] ),
			    'class' => 'hidden',
			    'type' 	=> 'measurement'
			);
		
			$i++;
		
		}
		
		/** Toggle rental periods */
		
		$options_listings['rental_periods'] = array( 
			'name' => __( 'Rental Periods', 'wpsight' ),
			'desc' => __( 'Please check the box to edit the rental periods.', 'wpsight' ),
			'id'   => 'rental_periods',
			'std'  => '0',
			'type' => 'checkbox'
		);
		
		/** Loop through rental periods */
		
		$i=1;
		
		foreach( wpsight_rental_periods() as $period_id => $value ) {
		
			$options_listings[$period_id] = array(
			    'name'  => __( 'Rental Period', 'wpsight' ) . ' #' . $i,
			    'id' 	=> $period_id,
			    'std'  	=> $value,
			    'class' => 'hidden',
			    'type' 	=> 'text'
			);
		
			$i++;
		
		}
				
		return apply_filters( 'wpsight_options_listings', $options_listings );
		
	}

}

/**
 * Create theme options array
 * Search options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_options_search' ) ) {

	function wpsight_options_search() {
		
		/** Create options array */
			
		$options_search = array();
			
		$options_search['heading_search'] = array(
			'name' => _x( 'Search', 'options', 'wpsight' ),
			'id'   => 'heading_search',
			'type' => 'heading'
		);
		
		$listing_search_show = array(
			'search'  	=> __( 'Listing search results', 'wpsight' ),
			'archive' 	=> __( 'Listing archive pages', 'wpsight' ),
			'templates' => __( 'Listing page templates', 'wpsight' ),
			'author' 	=> __( 'Listing agent archive pages', 'wpsight' )
		);
		
		$listing_search_show_defaults = array(
			'search'  	=> '1',
			'archive' 	=> '1',
			'templates' => '1'
		);
		
		$options_search['search_show'] = array(
			'name' 	  => __( 'Show Search on', 'wpsight' ),
			'desc' 	  => __( 'Please select where to display the listing search form. Keep in mind that there is also a widget to place the search form in widget areas.', 'wpsight' ),
			'id' 	  => 'search_show',
			'std' 	  => $listing_search_show_defaults,
			'type' 	  => 'multicheck',
			'options' => $listing_search_show
		);
		
		/** Loop through search form details */
		
		$listing_search_options 		 = array();
		$listing_search_options_defaults = array();
		
		foreach( wpsight_search_form_details() as $detail => $value ) {
		
			// Check if advanced search field
			if( $value['advanced'] == true )
				continue;
		
			$listing_search_options[$detail] 		  = $value['label'];
			$listing_search_options_defaults[$detail] = '1';
		
		}
		
		$options_search['search_details'] = array(
			'name' 	  => __( 'Options', 'wpsight' ),
			'desc' 	  => __( 'Please select the main search options to display in the search form.', 'wpsight' ),
			'id' 	  => 'search_details',
			'std' 	  => $listing_search_options_defaults,
			'type' 	  => 'multicheck',
			'options' => $listing_search_options
		);
		
		/** Toggle advanced search */
		
		$options_search['search_advanced'] = array(
			'name' => __( 'Advanced Search', 'wpsight' ),
			'desc' => __( 'Please check the box to enable advanced search.', 'wpsight' ),
			'id'   => 'search_advanced',
			'std'  => '1',
			'type' => 'checkbox'
		);
		
		/** Loop through search form details */
		
		$listing_search_options 		 = array();
		$listing_search_options_defaults = array();
		
		foreach( wpsight_search_form_details() as $detail => $value ) {
		
			// Check if advanced search field
			if( $value['advanced'] == false )
				continue;
		
			$listing_search_options[$detail] 		  		   = $value['label'];
			$listing_search_advanced_options_defaults[$detail] = '1';
		
		}
		
		$options_search['search_advanced_options'] = array(
			'name' 	  => __( 'Advanced Options', 'wpsight' ),
			'desc' 	  => __( 'Please select the advanced search options to display in the search form.', 'wpsight' ),
			'id' 	  => 'search_advanced_options',
			'std' 	  => $listing_search_advanced_options_defaults,
			'type' 	  => 'multicheck',
			'class'   => 'hidden',
			'options' => $listing_search_options
		);
		
		if( taxonomy_exists( 'feature' ) ) {
		
			/** Toggle advanced filters */
			
			$options_search['search_filters'] = array(
				'name' 	=> __( 'Advanced Filters', 'wpsight' ),
				'desc' 	=> __( 'Please check the box to enable advanced filters.', 'wpsight' ),
				'id' 	=> 'search_filters',
				'std' 	=> '0',
				'class' => 'hidden',
				'type' 	=> 'checkbox'
			);
			
			/** Loop through feature terms */
			
			$listing_search_filters = array();
			
			foreach( get_terms( 'feature' ) as $feature ) {							
			
				$feature_name = $feature->term_id . ',' . $feature->name;
				$listing_search_filters[$feature_name] = $feature->name;
								
			}
			
			/** Add empty element */
			
			array_unshift( $listing_search_filters, '' );
			
			$filters_nr = apply_filters( 'wpsight_listing_search_filters_nr', 8 );
			
			for( $i = 1; $i <= $filters_nr; $i++ ) {
			
				$options_search['filter_' . $i] = array( 
					'name' 	  => __( 'Filter', 'wpsight' ) . ' #' . $i,
					'desc' 	  => __( 'Please select a feature.', 'wpsight' ),
					'id' 	  => 'filter_' . $i,
					'type' 	  => 'select',
					'class'   => 'hidden',
					'options' => $listing_search_filters
				);
				
			}
		
		}
				
		return apply_filters( 'wpsight_options_search', $options_search );
		
	}

}

/**
 * Create theme options array
 * Social options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_options_social' ) ) {

	function wpsight_options_social() {
	
		/** Check theme support of social options */
	
		if( ! current_theme_supports( 'options-social' ) )
			return;
		
		/** Create options array */
			
		$options_social = array();
			
		$options_social['heading_social'] = array(
			'name' => __( 'Social', 'wpsight' ),
			'id'   => 'heading_social',
			'type' => 'heading'
		);
		
		/** Loop through social icons for info */
		
		$social_icons = array();
		foreach( wpsight_social_icons() as $k => $v ) {
			$social_icons[$k] = '<img src="' . $v['icon'] . '" alt="" />';
		}
		
		$social_icons = implode( '&nbsp;&nbsp;', $social_icons );
		
		$options_social['icon_info'] = array( 
		    'name' => __( 'Available Icons', 'wpsight' ),
		    'desc' => $social_icons,
		    'type' => 'info'
		);
		
		/** Loop through social icons for icons and links */
		
		$social_icons = array();
		foreach( wpsight_social_icons() as $k => $v ) {
			$social_icons[$k] = $v['name'];
		}
		
		array_unshift( $social_icons, '' );
		
		$nr = apply_filters( 'wpsight_social_icons_nr', 5 );
		
		for( $i = 1; $i <= $nr; $i++ ) {
		
			$std_icon = '';
			$std_link = '';
		
			/** Set first default to RSS */	
			
			if( $i == 1 ) {
				$std_icon = 'rss';
				$std_link = get_bloginfo_rss( 'rss2_url' );
			}
		
			$options_social['icon_' . $i] = array( 
				'name' 	  => __( 'Social', 'wpsight' ) . ' #' . $i . ' ' . __( 'Icon', 'wpsight' ),
				'desc' 	  => __( 'Please select an icon.', 'wpsight' ),
				'std' 	  => $std_icon,
				'id' 	  => 'icon_' . $i,
				'type' 	  => 'select',
				'options' => $social_icons
			);
			
			$options_social['icon_' . $i . '_link'] = array( 
				'name' => __( 'Social', 'wpsight' ) . ' #' . $i . ' ' . __( 'Link', 'wpsight' ),
				'desc' => __( 'Please enter the URL to your social account.', 'wpsight' ),
				'std'  => $std_link,
				'id'   => 'icon_' . $i . '_link',
				'type' => 'text'
			);	
		
		}
				
		return apply_filters( 'wpsight_options_social', $options_social );
		
	}

}
 
/**
 * Merge option tabs and
 * return wpsight_options()
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_options' ) ) {

	function wpsight_options() {
	
		if( is_array( wpsight_options_general() ) )
			$options_general = wpsight_options_general();
			
		if( is_array( wpsight_options_layout() ) )
			$options_layout = wpsight_options_layout();
			
		if( is_array( wpsight_options_listings() ) )
			$options_listings = wpsight_options_listings();
			
		if( is_array( wpsight_options_search() ) )
			$options_search = wpsight_options_search();
			
		if( is_array( wpsight_options_social() ) )
			$options_social = wpsight_options_social();
		
	    $options = array_merge(
	    	(array) $options_general,
	    	(array) $options_layout,
	    	(array) $options_listings,
	    	(array) $options_search,
	    	(array) $options_social
	    );
	    
	    return apply_filters( 'wpsight_options', $options );
	
	}

}

/* 
 * Show/hide options when checkbox is clicked
 */

add_action( 'wpsight_options_custom_scripts', 'wpsight_toggle_options' );

function wpsight_toggle_options() { ?>

<script type='text/javascript'>
jQuery(document).ready(function($) {

	var totoggle_currency = '#section-currency_other, #section-currency_other_ent';	
	
	$('#currency').change(function() {
	  	if( $(this).val() == 'other' ) {
  			$(totoggle_currency).fadeIn(150);
		} else {
			$(totoggle_currency).fadeOut(150);
		}
	});
	
	<?php
		// Gets the unique option id
		$wpsight_settings = get_option( WPSIGHT_DOMAIN );
		
		if ( isset( $wpsight_settings['id'] ) ) {
			$option_name = $wpsight_settings['id'];
		}
		else {
			$option_name = WPSIGHT_DOMAIN;
		};
	?>

	$('#<?php echo $option_name; ?>-currency-other').click(function() {
  		$(totoggle_currency).fadeToggle(150);
	});
	
	if ($('#<?php echo $option_name; ?>-currency-other:checked').val() !== undefined) {
		$(totoggle_currency).show();
	}

	<?php
		/** Loop through standard details and hide them */
		$totoggle_details = array();
		foreach( wpsight_standard_details() as $feature => $value ) {
			$totoggle_details[] = '#section-' . $feature;
		}
		$totoggle_details = implode( ', ' , $totoggle_details );		
	?>

	var totoggle_details = '<?php echo $totoggle_details; ?>';

	$('#listing_features').click(function() {
  		$(totoggle_details).fadeToggle(150);
	});
	
	if ($('#listing_features:checked').val() !== undefined) {
		$(totoggle_details).show();
	}
	
	<?php
		/** Loop through standard details and hide them */
		$totoggle_periods = array();
		foreach( wpsight_rental_periods() as $period_id => $value ) {
			$totoggle_periods[] = '#section-' . $period_id;
		}
		$totoggle_periods = implode( ', ' , $totoggle_periods );		
	?>
	
	var totoggle_periods = '<?php echo $totoggle_periods; ?>';

	$('#rental_periods').click(function() {
  		$(totoggle_periods).fadeToggle(150);
	});
	
	if ($('#rental_periods:checked').val() !== undefined) {
		$(totoggle_periods).show();
	}
	
	var totoggle_template = '#section-email_subject, #section-email_body';

	$('#email_template').click(function() {
  		$(totoggle_template).fadeToggle(150);
	});
	
	if ($('#email_template:checked').val() !== undefined) {
		$(totoggle_template).show();
	}
	
	var totoggle_template_general = '#section-email_subject_general, #section-email_body_general';

	$('#email_template_general').click(function() {
  		$(totoggle_template_general).fadeToggle(150);
	});
	
	if ($('#email_template_general:checked').val() !== undefined) {
		$(totoggle_template_general).show();
	}
	
	var totoggle_template_favorites = '#section-email_subject_favorites, #section-email_body_favorites';

	$('#email_template_favorites').click(function() {
  		$(totoggle_template_favorites).fadeToggle(150);
	});
	
	if ($('#email_template_favorites:checked').val() !== undefined) {
		$(totoggle_template_favorites).show();
	}
	
	<?php
		/** Loop through number of filters */
		$totoggle_filters = array();
		$filters_nr = apply_filters( 'wpsight_listing_search_filters_nr', 8 );
		for( $i = 1; $i <= $filters_nr; $i++ ) {
			$totoggle_filters[] = '#section-filter_' . $i;
		}
		$totoggle_filters = implode( ', ' , $totoggle_filters );		
	?>
	
	var totoggle_filters = '<?php echo $totoggle_filters; ?>';
	
	var totoggle_search = '#section-search_advanced_options, #section-search_filters';

	$('#search_advanced').click(function() {
  		$(totoggle_search).fadeToggle(150);
  		if ($('#search_filters:checked').val() !== undefined) {
  			$(totoggle_filters).fadeToggle(150);
  		}
	});
	
	if ($('#search_advanced:checked').val() !== undefined) {
		$(totoggle_search).show();
	}

	$('#search_filters').click(function() {
  		$(totoggle_filters).fadeToggle(150);
	});
	
	if ($('#search_filters:checked').val() !== undefined && $('#search_advanced:checked').val() !== undefined) {
		$(totoggle_filters).show();
	}
	
});
</script><?php

}