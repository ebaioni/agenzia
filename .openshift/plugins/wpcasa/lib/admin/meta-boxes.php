<?php
/**
 * Custom meta boxes for
 * listings, posts and pages
 */

/**
 * Add listing meta boxes
 *
 * @since 1.2
 */

add_action( 'admin_init', 'wpsight_register_meta_boxes' );

function wpsight_register_meta_boxes() {

	if ( ! class_exists( 'RW_Meta_Box' ) )
		return;
		
	$meta_boxes = array();
	
	if( current_theme_supports( 'listing-images' ) )
		$meta_boxes[] = wpsight_meta_box_listing_images();

	if( current_theme_supports( 'listing-price' ) )
		$meta_boxes[] = wpsight_meta_box_listing_price();

	if( current_theme_supports( 'listing-details' ) )
		$meta_boxes[] = wpsight_meta_box_listing_details();

	if( current_theme_supports( 'listing-location' ) )
		$meta_boxes[] = wpsight_meta_box_listing_location();

	if( current_theme_supports( 'listing-spaces' ) )
		$meta_boxes[] = wpsight_meta_box_listing_spaces();

	if( current_theme_supports( 'listing-layout' ) )
		$meta_boxes[] = wpsight_meta_box_listing_layouts();
		
	if( current_theme_supports( 'post-spaces' ) )
		$meta_boxes[] = wpsight_meta_box_post_spaces();
		
	if( current_theme_supports( 'post-layout' ) )
		$meta_boxes[] = wpsight_meta_box_post_layouts();

    foreach ( $meta_boxes as $meta_box )
    	new RW_Meta_Box( $meta_box );

}

/**
 * Create listing images meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_listing_images' ) ) {

	function wpsight_meta_box_listing_images() {
			
		// Listing price labels
		
		$labels_images = array(
		    'title' => __( 'Listing Images', 'wpsight' )
		);
		
		$labels_images = apply_filters( 'wpsight_listing_images_labels', $labels_images );
		
		// Get existing attachments
		
		if( wpsight_get_listing_edit_id() != false ) {
		
			$attachments = get_posts(
				array(
					'post_type' 	 => 'attachment',
					'posts_per_page' => -1,
					'post_parent' 	 => wpsight_get_listing_edit_id(),
					'post_mime_type' => 'image'
				)
			);
			
			$attachment_ids = array();
			
			foreach( $attachments as $attachment )
				$attachment_ids[] = $attachment->ID;
		
		}
			
		$attachment_ids = ! empty( $attachment_ids ) ? $attachment_ids : false;
	
		// Set meta box
	
		$meta_box = array(
		
			'id' 		  => 'listing_images',
			'title'		  => $labels_images['title'],
			'pages'		  => array( wpsight_listing_post_type() ),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				'images' => array(
					'name'             => false,
					'id'               => '_images',
					'type'             => 'plupload_image',
					'max_file_uploads' => 12,
					'std'				=> $attachment_ids,
					'force_delete'     => true
				)
			)
	
	    );
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_listing_images', $meta_box );
		
		return $meta_box;
	
	}

}

/**
 * Create listing price meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_listing_price' ) ) {

	function wpsight_meta_box_listing_price() {
			
		// Listing price labels
		
		$labels_price = array(
		    'title' 		=> __( 'Listing Price', 'wpsight' ),
		    'price' 		=> __( 'Price', 'wpsight' ),
		    'price_note'	=> __( 'No currency symbols or thousands separators', 'wpsight' ),
		    'status' 		=> __( 'Status', 'wpsight' ),
		    'period' 		=> __( 'Period', 'wpsight' ),
		    'availability'	=> __( 'Availability', 'wpsight' ),
		    'not_available'	=> __( 'Item is no longer available', 'wpsight' )
		);
		
		$labels_price = apply_filters( 'wpsight_listing_price_labels', $labels_price );
	
		// Set meta box
	
		$meta_box = array(
		
			'id' 		  => 'listing_price',
			'title'		  => $labels_price['title'],
			'pages'		  => array( wpsight_listing_post_type() ),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
			    'price' => array(
			    	'name'  => $labels_price['price'],
			    	'id'    => '_price',
			    	'type'  => 'text',
			    	'desc'	=> $labels_price['price_note']
			    ),
			    'status' => array(
			    	'name'  => $labels_price['status'],
			    	'id'    => '_price_status',
			    	'type'  => 'select',
			    	'options' => wpsight_listing_statuses()
			    ),
			    'period' => array(
			    	'name'  => $labels_price['period'],
			    	'id'    => '_price_period',
			    	'type'  => 'radio',
			    	'options' => array_merge( array( '' => __( 'None', 'wpsight' ) ), wpsight_rental_periods() )
			    ),
			    'availability' => array(
			    	'name'  => $labels_price['availability'],
			    	'id'    => '_price_sold_rented',
			    	'type'  => 'checkbox',
			    	'desc'  => $labels_price['not_available']
			    )
			)
	    	
	    );
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_listing_price', $meta_box );
	
		return $meta_box;
	
	}

}

/**
 * Create listing details meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_listing_details' ) ) {

	function wpsight_meta_box_listing_details() {	
		
		$details_labels = array(
		    'title'	=> __( 'Listing Details', 'wpsight' ),
		    'id'	=> __( 'ID', 'wpsight' )
		);
		
		// Get standard features and merge with title
		
		$details_labels = array_merge(
		    $details_labels,
		    wpsight_standard_details()
		);
		
		$details_labels = apply_filters( 'wpsight_listing_details_labels', $details_labels );
			
		/**
		 * Add backward compatibility
		 * for old wpCasa _property_id
		 * custom field value
		 */
		 
		$listing_id = false;
		
		if( wpsight_get_listing_edit_id() ) {
			
			// Get old wpCasa _property_id	
			$property_id_meta = get_post_meta( wpsight_get_listing_edit_id(), '_property_id', true );
			
			// Get new wpSight _listing_id
			$listing_id_meta = get_post_meta( wpsight_get_listing_edit_id(), '_listing_id', true );
			
			if( ! empty( $property_id_meta ) && empty( $listing_id_meta ) )
				update_post_meta( wpsight_get_listing_edit_id(), '_listing_id', $property_id_meta, '' );
				
			if( empty( $property_id_meta ) && empty( $listing_id_meta ) )
				$listing_id = wpsight_get_listing_id( wpsight_get_listing_edit_id() );
		
		}
	
		// Set meta box
	
		$meta_box = array(
		
			'id' 		  => 'listing_details',
			'title'		  => $details_labels['title'],
			'pages'		  => array( wpsight_listing_post_type() ),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
			    'id' => array(
			    	'name'  => $details_labels['id'],
			    	'id'    => '_listing_id',
			    	'type'  => 'text',
			    	'std'	=> $listing_id
			    )    		
			)
	    	
	    );
		
		/**
		 * Add standard details
		 */
		 
		$units = wpsight_measurement_units();
		
		foreach( wpsight_standard_details() as $detail => $value ) {
		
			$standard_details_option = wpsight_get_option( $detail );
			
			// If details hasn't been set before, display default
							
			if( ! isset( $standard_details_option['label'] ) )
			    $standard_details_option = wpsight_get_option( $detail, true );
		
			// Don't show detail if label is emtpy in options
			
			if( empty( $standard_details_option['label'] ) )
				continue;
		
		    if( ! empty( $details_labels[$detail] ) ) {
		    
		    	// Optionally add measurement label to title
		       	$unit  = '';
		    	
		    	if( ! empty( $details_labels[$detail]['unit'] ) ) {
		    		$unit = $details_labels[$detail]['unit'];
		    		$unit = $units[$unit];
		    		$unit = ' (' . $unit . ')';
		    	}
		    	
		    	// If there is select data, create select fields else text
		    	
		    	if( ! empty( $details_labels[$detail]['data'] ) ) {
		    	
		    		$meta_box['fields'][$detail] = array(
		    		    'name'    => $details_labels[$detail]['label'] . $unit,
		    		    'id' 	  => '_' . $detail,
		    		    'type'	  => 'select',
		    		    'options' => $details_labels[$detail]['data'],
		    		    'desc'	  => $details_labels[$detail]['description']
		    		);
		    	
		    	} else {
		
		    		$meta_box['fields'][$detail] = array(
		    		    'name'    => $details_labels[$detail]['label'] . $unit,
		    		    'id' 	  => '_' . $detail,
		    		    'type'	  => 'text',
		    		    'desc'	  => $details_labels[$detail]['description']
		    		);
		    	
		    	} // end if
		    
		    } // end if
		
		} // end foreach
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_listing_details', $meta_box );
	
		return $meta_box;
	
	}

}

/**
 * Create listing location meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_listing_location' ) ) {

	function wpsight_meta_box_listing_location() {
	
			
		// Listing location labels
		
		$labels_location = array(
		    'title'	  => __( 'Listing Location', 'wpsight' ),
		    'address' => array(
		    	'label' 	  => __( 'Address', 'wpsight' ),
		    	'description' => __( 'e.g. <code>Marbella, Spain</code> or <code>Platz der Republik 1, 10557 Berlin</code>', 'wpsight' )
		    ),
		    'note'  => array(
		    	'label' 	  => __( 'Public Note', 'wpsight' ),
		    	'description' => __( 'e.g. <code>Location is not the exact address of the listing</code>', 'wpsight' )
		    ),
		    'geo'	  => array(
		    	'label' 	  => __( 'Geo code', 'wpsight' ),
		    	'description' => __( 'Latitude and longitude (e.g. <code>36.509937, -4.886352</code>)', 'wpsight' )
		    ),
		    'secret' => array(
		    	'label' 	  => __( 'Secret Note', 'wpsight' ),
		    	'description' => __( 'Will not be displayed on the website (e.g. complete address)', 'wpsight' )
		    ),
		    'exclude' => array(
		    	'title' 	  => __( 'Exclude', 'wpsight' ),
		    	'label' 	  => __( 'Exclude from general listings map', 'wpsight' )
		    ),
		    'notice_title'  => '<strong>' . __( 'Please notice!', 'wpsight' ) . '</strong>'
		);
	    	
	    $labels_location = apply_filters( 'wpsight_listing_location_labels', $labels_location );
	
		// Get old geo code
		
		$map_geo = false;
		
		if( wpsight_get_listing_edit_id() != false ) {
			
			$map_geo = get_post_meta( wpsight_get_listing_edit_id(), '_map_geo', true );		
			$map_address = get_post_meta( wpsight_get_listing_edit_id(), '_map_address', true );
			
			if( ! empty( $map_geo ) && empty( $map_address ) ) {
				update_post_meta( wpsight_get_listing_edit_id(), '_map_location', $map_geo );
				update_post_meta( wpsight_get_listing_edit_id(), '_map_address', $map_geo );
			}
		
		}
		
		// Set meta box
	
		$meta_box = array(
		
			'id' 		  => 'listing_location',
			'title'		  => $labels_location['title'],
			'pages'		  => array( wpsight_listing_post_type() ),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
			    'address' => array(
			    	'name'  => $labels_location['address']['label'],
			    	'id'    => '_map_address',
			    	'type'  => 'text',
			    	'std'	=> $map_geo,
			    	'desc'	=> $labels_location['address']['description']
			    ),
			    'note' => array(
			    	'name'  => $labels_location['note']['label'],
			    	'id'    => '_map_note',
			    	'type'  => 'text',
			    	'desc'	=> $labels_location['note']['description']
			    ),
				'location' => array(
					'id'            => '_map_location',
					'name'          => __( 'Location', 'wpsight' ),
					'type'          => 'map',
					'std'           => $map_geo,
					'style'         => 'width: 100%; height: 400px',
					'address_field' => '_map_address'
				),
			    'geo' => array(
			    	'name'  => false,
			    	'id'    => '_map_geo',
			    	'type'  => 'hidden',
			    	'desc'  => false
			    ),
			    'secret' => array(
			    	'name'  => $labels_location['secret']['label'],
			    	'id'    => '_map_secret',
			    	'type'  => 'textarea',
			    	'desc'	=> $labels_location['secret']['description']
			    ),
			    'exclude' => array(
			    	'name'  => $labels_location['exclude']['title'],
			    	'id'    => '_map_exclude',
			    	'type'  => 'checkbox',
			    	'desc'  => $labels_location['exclude']['label']
			    )
			)
	    	
	    );
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_listing_location', $meta_box );
	
		return $meta_box;
	
	}

}

/**
 * Create listing spaces meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_listing_spaces' ) ) {

	function wpsight_meta_box_listing_spaces() {
		
		// Get listing spaces
		$spaces = wpsight_listing_spaces();
		
		if( empty( $spaces ) )
			return;
			
		// Loop through existing spaces
			
		foreach( $spaces as $space => $v ) {		
		
			// Set meta box
	
			$meta_box = array(
			
				'id' 		  => $space,
				'title'		  => $v['title'],
				'pages'		  => $v['post_type'],
				'context'	  => 'normal',
				'priority'	  => 'high',
				'fields'	  => array(    		
				    $v['key'] => array(
				    	'name'  => $v['label'],
				    	'id'    => $v['key'],
				    	'type'  => $v['type'],
				    	'desc'	=> $v['description'],
				    	'rows'	=> $v['rows']
				    )    		
				)
	    		
	    	);
		
		} // endforeach
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_listing_spaces', $meta_box );
	
		return $meta_box;
	
	}

}

/**
 * Create listing layout meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_listing_layouts' ) ) {

	function wpsight_meta_box_listing_layouts() {
		
		$layouts = array(
			'sidebar-right' => __( 'Right sidebar', 'wpsight' ) . '<br /><img src="' . WPSIGHT_ADMIN_IMG_URL . '/sidebar-right.png' . '" class="layout-img" />',
			'full-width' 	=> __( 'No sidebar', 'wpsight' ) . '<br /><img src="' . WPSIGHT_ADMIN_IMG_URL . '/full-width.png' . '" class="layout-img" />',
			'sidebar-left'  => __( 'Left sidebar', 'wpsight' ) . '<br /><img src="' . WPSIGHT_ADMIN_IMG_URL . '/sidebar-left.png' . '" class="layout-img" />'
		);
		
		$layouts = apply_filters( 'wpsight_meta_box_listing_layouts_layouts', $layouts );
		
		if( empty( $layouts ) )
			return;
			
		// Set meta box
		
		$meta_box = array(
		
		    'id' 		  => 'listing_layout',
		    'title'		  => wpsight_listing_layout_options( 'title' ),
		    'pages'		  => array( wpsight_listing_post_type() ),
		    'context'	  => 'normal',
		    'priority'	  => 'high',
		    'fields'	  => array(    		
		        'sidebar' => array(
		        	'name'  => wpsight_listing_layout_options( 'sidebar_label' ),
		        	'id'    => '_layout',
		        	'type'  => 'radio',
		        	'options' => $layouts,
		        	'std'	=> 'sidebar-right'
		        )    		
		    )
		    
		);
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_listing_layouts', $meta_box );
	
		return $meta_box;
		
	}

}

/**
 * Create post spaces meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_post_spaces' ) ) {

	function wpsight_meta_box_post_spaces() {
		
		// Get listing spaces
		$spaces = wpsight_post_spaces();
		
		if( empty( $spaces ) )
			return;
			
		// Loop through existing spaces
			
		foreach( $spaces as $space => $v ) {		
		
			// Set meta box
	
			$meta_box = array(
			
				'id' 		  => $space,
				'title'		  => $v['title'],
				'pages'		  => $v['post_type'],
				'context'	  => 'normal',
				'priority'	  => 'high',
				'fields'	  => array(    		
				    $v['key'] => array(
				    	'name'  => $v['label'],
				    	'id'    => $v['key'],
				    	'type'  => $v['type'],
				    	'desc'	=> $v['description'],
				    	'rows'	=> $v['rows']
				    )    		
				)
	    		
	    	);
		
		} // endforeach
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_post_spaces', $meta_box );
	
		return $meta_box;
	
	}

}

/**
 * Create listing layout meta box
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_meta_box_post_layouts' ) ) {

	function wpsight_meta_box_post_layouts() {
	
		// Post layouts labels
		
		$labels_layouts = array(
		    'image_size_label' 		  => __( 'Image Size', 'wpsight' ),
		    'image_size_description'  => __( 'Keep in mind that the image size is limited by the layout', 'wpsight' ),
		    'image_align_label' 	  => __( 'Image Align', 'wpsight' ),
		    'image_align_description' => __( 'Select your preferred image alignment', 'wpsight' )
		);
		
		$labels_layouts = apply_filters( 'wpsight_meta_box_post_layouts_labels', $labels_layouts );
		
		$layouts = array(
			'sidebar-right' 	  => __( 'Right sidebar', 'wpsight' ) . '<br /><img src="' . WPSIGHT_ADMIN_IMG_URL . '/sidebar-right.png' . '" class="layout-img" />',
			'full-width' 		  => __( 'No sidebar', 'wpsight' ) . '<br /><img src="' . WPSIGHT_ADMIN_IMG_URL . '/full-width.png' . '" class="layout-img" />',
			'sidebar-left'  	  => __( 'Left sidebar', 'wpsight' ) . '<br /><img src="' . WPSIGHT_ADMIN_IMG_URL . '/sidebar-left.png' . '" class="layout-img" />'
		);
		
		$layouts = apply_filters( 'wpsight_meta_box_post_layouts_layouts', $layouts );
		
		if( empty( $layouts ) )
			return;
			
		// Get image sizes and create select data
		
		$image_sizes = array();		
		foreach ( wpsight_image_sizes() as $k => $v ) {		
			$image_sizes[$k] = $v['label'] . ' (' . $v['size']['w'] . 'x' . $v['size']['h'] . 'px)';		
		}
		
		// Set image aligns
		
		$image_aligns = array(
		    'left'  => __( 'left', 'wpsight' ),
		    'right' => __( 'right', 'wpsight' ),
		    'none'  => __( 'none', 'wpsight' )
		);
		
		$image_aligns = apply_filters( 'wpsight_meta_box_post_layouts_aligns', $image_aligns );
			
		// Set meta box
		
		$meta_box = array(
		
		    'id' 		  => 'listing_layout',
		    'title'		  => wpsight_listing_layout_options( 'title' ),
		    'pages'		  => array( 'post', 'page' ),
		    'context'	  => 'normal',
		    'priority'	  => 'high',
		    'fields'	  => array(    		
		        'layout' => array(
		        	'name'  => wpsight_listing_layout_options( 'sidebar_label' ),
		        	'id'    => '_layout',
		        	'type'  => 'radio',
		        	'options' => $layouts,
		        	'std'	=> 'sidebar-right'
		        ),
			    'size' => array(
			    	'name'  => $labels_layouts['image_size_label'],
			    	'id'    => '_image_size',
			    	'type'  => 'select',
			    	'options' => $image_sizes,
			    	'std'	=> 'big'
			    ),
			    'align' => array(
			    	'name'  => $labels_layouts['image_align_label'],
			    	'id'    => '_image_align',
			    	'type'  => 'select',
			    	'options' => $image_aligns,
			    	'std'	=> wpsight_get_layout_image( 'align_single' )
			    )
		    )
		    
		);
	    
	    // Apply filter to array    
	    $meta_box = apply_filters( 'wpsight_meta_box_post_layouts', $meta_box );
	
		return $meta_box;
		
	}

}

/**
 * Helper function to get
 * post layout options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_post_layout_options' ) ) {

	function wpsight_post_layout_options( $option = '' ) {
	
		$layout_args = array(
		    'title' 				  => __( 'Layout', 'wpsight' ),
		    'post_types' 			  => array( 'post', 'page' ),
		    'sidebar_label' 		  => __( 'Sidebar', 'wpsight' ),
		    'image_size_label' 		  => __( 'Image Size', 'wpsight' ),
		    'image_size_description'  => __( 'Keep in mind that the image size is limited by the layout.', 'wpsight' ),
		    'image_align_label' 	  => __( 'Image Align', 'wpsight' ),
		    'image_align_description' => __( 'Select your preferred image alignment.', 'wpsight' ),
		    'image_align_options'	  => array(
		    	'left'  => __( 'left', 'wpsight' ),
		    	'right' => __( 'right', 'wpsight' ),
		    	'none'  => __( 'none', 'wpsight' )
		    )
		);
		
		$layout_args = apply_filters( 'wpsight_post_layout_args', $layout_args );
		
		if( ! empty( $option ) ) {
			return $layout_args[$option];
		} else {
			return $layout_args;
		}
	
	}

}

/**
 * Helper function to get
 * listing layout options
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_listing_layout_options' ) ) {

	function wpsight_listing_layout_options( $option = '' ) {
	
		$layout_args = array(
		    'title' 	     => __( 'Layout', 'wpsight' ),
		    'post_types'     => array( wpsight_listing_post_type() ),
		    'sidebar_label'  => __( 'Sidebar', 'wpsight' )
		);
		
		$layout_args = apply_filters( 'wpsight_listing_layout_args', $layout_args );
		
		if( ! empty( $option ) ) {
			return $layout_args[$option];
		} else {
			return $layout_args;
		}
	
	}

}

/**
 * Helper function to get the post ID
 * on single listing edit screen
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_listing_edit_id' ) ) {

	function wpsight_get_listing_edit_id() {
		
		global $post;
	
		if ( isset( $_GET['post'] ) ) {
			$post_id = $_GET['post'];
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		} else {
			$post_id = '';
		}
		
		if( isset( $post->ID ) )
			$post_id = $post->ID;
		
		return $post_id;
	
	}

}

/**
 * Helper function to get
 * post meta from RWMB
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_meta' ) ) {

	function wpsight_get_meta( $key, $args = array(), $post_id = null ) {
	
		$meta = rwmb_meta( $key, $args, $post_id );
	
		return apply_filters( 'wpsight_get_meta', $meta, $key, $args, $post_id );
	
	}

}

/**
 * Helper function to get
 * file info from RWMB
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_file_info' ) ) {

	function wpsight_get_file_info( $id ) {
	
		if( empty( $id ) )
			$id = get_the_ID();
	
		$info = rwmb_file_info( $id );
		
		return apply_filters( 'wpsight_get_file_info', $info, $id );
	
	}

}

/**
 * Helper function to get
 * image info from RWMB
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_image_info' ) ) {

	function wpsight_get_image_info( $id, $args = array() ) {
	
		if( empty( $id ) )
			$id = get_the_ID();
	
		$info = rwmb_image_info( $id, $args );
		
		return apply_filters( 'wpsight_get_image_info', $info, $id, $args );
	
	}

}