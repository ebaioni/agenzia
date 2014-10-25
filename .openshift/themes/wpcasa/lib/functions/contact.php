<?php
/**
 * Create custom contact form fields array
 *
 * @since 1.1
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_contact_fields' ) ) {
 
	function wpsight_contact_fields() {
	
		// Get labels
		$contact_labels = wpsight_contact_labels();
		
		// Extract labels
		extract( $contact_labels, EXTR_SKIP );
	
		// Set contact fields
			
		$contact_fields = array(
		
		    'fields_1' => array(
		    	'id' 		  	 => 'contact_name',
		    	'label'		  	 => $name,
		    	'label_email'  	 => $name_email,
		    	'required'	  	 => true,
		    	'type'		  	 => 'text',
		    	'placeholder' 	 => true,
		    	'before'		 => false,
		    	'after'			 => false,
		    	'value'			 => false,
		    	'position'	  	 => 10
		    ),
		    'fields_2' => array(
		    	'id' 		  	 => 'contact_email',
		    	'label'		  	 => $email,
		    	'label_email'  	 => $email_email,
		    	'required'	  	 => 'email',
		    	'type'		  	 => 'text',
		    	'placeholder' 	 => true,
		    	'before'		 => false,
		    	'after'			 => false,
		    	'value'			 => false,
		    	'position'	  	 => 20
		    ),
		    'fields_3' => array(
		    	'id' 		  	 => 'contact_phone',
		    	'label'		  	 => $phone,
		    	'label_email'  	 => $phone_email,
		    	'required'	  	 => false,
		    	'type'		  	 => 'numbers',
		    	'placeholder' 	 => true,
		    	'before'		 => false,
		    	'after'			 => false,
		    	'value'			 => false,
		    	'position'	  	 => 30
		    ),
		    'fields_4' => array(
		    	'id' 		  	 => 'contact_message',
		    	'label'		  	 => $message,
		    	'label_email' 	 => $message_email,
		    	'required'	  	 => true,
		    	'type'		  	 => 'textarea',
		    	'placeholder' 	 => true,
		    	'before'		 => false,
		    	'after'			 => false,
		    	'value'			 => false,
		    	'position'	  	 => 40
		    ),
		    'captcha' => array(
		    	'show' 		  	 => true,
		    	'type'			 => 'string', // can be 'math'
		    	'placeholder' 	 => false,
		    	'case_sensitive' => false,
		    	'code_length'	 => 4,
		    	'image_width' 	 => 150,
		    	'image_height'	 => 60,
		    	'perturbation' 	 => .5,
		    	'bg_color' 		 => '#ffffff',
		    	'text_color' 	 => '#606060',
		    	'num_lines' 	 => 6,
		    	'line_color' 	 => '#6e6e6e',
		    	'font'		  	 => './AHGBold.ttf',
		    	'before'		 => false,
		    	'after'			 => false,
		    	'value'			 => false,
		    	'position'		 => false // will be placed at the end
		    ),
		    'copy'	  => array(
		    	'show' 			 => true,
		    	'placeholder' 	 => false,
		    	'position'		 => false // will be placed at the end
		    )
		
		);
	    
	    // Apply filter to array    
	    $contact_fields = apply_filters( 'wpsight_contact_fields', $contact_fields );
	    
	    // Sort array by position        
	    $contact_fields = wpsight_sort_array_by_position( $contact_fields );
		
		// Return array    
	    return $contact_fields;
	
	}

}

/**
 * Create custom contact form labels array
 *
 * @since 1.1
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_contact_labels' ) ) {
 
	function wpsight_contact_labels() {
	
		// Set labels
	
		$contact_labels = array(
		    'name' 		  		=> __( 'Your name', 'wpsight' ),
		    'name_email'  		=> __( 'Name', 'wpsight' ),
			'email' 	  		=> __( 'Your email', 'wpsight' ),
			'email_email' 	  	=> __( 'Email', 'wpsight' ),
			'phone' 	  		=> __( 'Your phone', 'wpsight' ),
			'phone_email' 		=> __( 'Phone', 'wpsight' ),
			'message' 	  		=> __( 'Your message', 'wpsight' ),
			'message_email' 	=> __( 'Message', 'wpsight' ),
			'submit' 	  		=> __( 'Submit message', 'wpsight' ),
			'copy' 		  		=> __( 'Send copy to your email', 'wpsight' ),        	
			'field_error' 		=> __( 'This field is required!', 'wpsight' ),
			'email_error' 		=> __( 'Please enter a valid email!', 'wpsight' ),
			'number_error' 		=> __( 'Please enter numbers only!', 'wpsight' ),
			'captcha_error' 	=> __( 'The security code entered is not correct.', 'wpsight' ),
			'argument_error' 	=> __( 'There is a problem with the captcha.', 'wpsight' ),
			'confirm' 	  		=> __( '<strong>Thanks!</strong> Your email has been sent successfully.', 'wpsight' ),
			'error' 	  		=> __( 'There was an error submitting the form!', 'wpsight' ),
			'email_subject_pre' => '[' . __( 'Contact', 'wpsight' ) . '] ',
			'email_note'		=> __( 'sent you a message via the contact form.', 'wpsight' ),
			'email_name'		=> __( 'Name', 'wpsight' ),
			'email_email'		=> __( 'Email', 'wpsight' ),
			'email_phone'		=> __( 'Phone', 'wpsight' ),
			'email_message'		=> __( 'Message', 'wpsight' ),
			'email_listing'		=> __( 'Listing', 'wpsight' )
		);
		
		$contact_labels = apply_filters( 'wpsight_contact_labels', $contact_labels );
		
		return $contact_labels;
	
	}

}

/**
 * Create contact form email
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_contact_email' ) ) {
 
	function wpsight_contact_email( $get_post = false, $location, $fields ) {
	
		// Get contact fields
		$contact_fields = wpsight_contact_fields();
	
		// Get contact labels
		$contact_labels = wpsight_contact_labels();
	
		// Get placeholders
		$placeholders = wpsight_contact_placeholders( $fields );
		
		/**
		 * Create email for contact form
		 * on single listing pages
		 */
		
		if( $location == 'listing' ) {
		
			// Set default email subject
			$subject = '[[site]] [listing_title] ([listing_id])';
			
			// Apply filter
			$subject = apply_filters( 'wpsight_do_contact_email_listing_subject', $subject );
			
			// Get email template
			
			ob_start();
			$template = locate_template( '/contact/email-listing.php', true, true );
			$body = ob_get_contents();
			ob_end_clean();
			
			// Apply filter
			$body = apply_filters( 'wpsight_do_contact_email_listing_body', $body );
		
		/**
		 * Create email for contact form
		 * on contact page with favorites
		 */
		
		} elseif( $location == 'favorites' ) {
		
			// Set default email subject
			$subject = '[[site]] ' . __( 'Message from', 'wpsight' ) . ' [contact_name]';
			
			// Apply filter
			$subject = apply_filters( 'wpsight_do_contact_email_favorites_subject', $subject );
			
			// Get email template
			
			ob_start();
			$template = locate_template( '/contact/email-favorites.php', true, true );
			$body = ob_get_contents();
			ob_end_clean();
			
			// Add favorites
			
			$favorites = '';
			$counter = 1;
		
			if( isset( $get_post['favorites'] ) ) {
			    
			    // Loop through favorites
			    
			    foreach( $get_post['favorites'] as $favorite ) {
			    	$break = ( $counter == 1 ) ? false : "\n";
			    	$favorites .= $break . '<p>&bull; <strong>[listing_id id="' . $favorite . '"]</strong> - <a href="[listing_url_raw id="' . $favorite . '"]">[listing_title id="' . $favorite . '"]</a></p>';
			    	$counter++;
			    }
			
			}
			
			// Replace favorites shortcode
			$body = str_replace( '[favorites]', $favorites, $body );
			
			// Apply filter
			$body = apply_filters( 'wpsight_do_contact_email_favorites_body', $body );
		
		/**
		 * Create email for contact form
		 * on general contact
		 */
		
		} else {
	 		 
	 		 // Set default email subject
			$subject = '[[site]] ' . __( 'Message from', 'wpsight' ) . ' [contact_name]';
			
			// Apply filter
			$subject = apply_filters( 'wpsight_do_contact_email_general_subject', $subject );
			
			// Get email template
			
			ob_start();
			$template = locate_template( '/contact/email-general.php', true, true );
			$body = ob_get_contents();
			ob_end_clean();
			
			// Apply filter
			$body = apply_filters( 'wpsight_do_contact_email_general_body', $body );
		
		} // endif $location
		
		// Replace placeholders with data
		
		foreach( $placeholders as $dummy => $replace ) {						    	
		    $body	 = str_replace( $dummy, $replace, $body );
		    $body	 = str_replace( 'contact_' . $dummy, $replace, $body );
		    $subject = str_replace( $dummy, $replace, $subject );
		    $subject = str_replace( 'contact_' . $dummy, $replace, $subject );
		}
		
		// Filter subject and body
		
		$subject = apply_filters( 'wpsight_contact_email_subject', $subject );
		$body 	 = apply_filters( 'wpsight_contact_email_body', $body );
		
		// Enable shortcodes
		
		$subject = do_shortcode( $subject );
		$body	 = do_shortcode( $body );
		
		// Do some encoding
		
		$subject = html_entity_decode( strip_tags( $subject ) );
		// $body 	 = strip_tags( nl2br( $body ) );
		
		// Filter parameters
		
		$email_args = array(
		    'subject' 	  => $subject,
		    'body'	  	  => $body
		);
		
		return apply_filters( 'wpsight_contact_email', $email_args );
	
	}

}

/**
 * Create placeholders for contact fields
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_contact_placeholders' ) ) {

	function wpsight_contact_placeholders( $fields ) {
	
		// Get contact fields
		$contact_fields = wpsight_contact_fields();
	
		// Get contact labels
		$contact_labels = wpsight_contact_labels();
		
		// Set body placeholders	        
		$placeholders = array();
		
		// Set site place holder	
		$placeholders['[site]'] = apply_filters( 'wpsight_listing_contact_site', get_bloginfo( 'name' ) );
	
		foreach( $contact_fields as $k => $v ) {
		
			// Set placeholder to false by default
			$v['placeholder'] = isset( $v['placeholder'] ) ? $v['placeholder'] : false;
		
		    if( $k == 'captcha' || $k == 'copy' )
		    	continue;
		
		    $field = $v['id'];
		    	
		    // Create placeholder for each field
		    
		    if( $v['placeholder'] == true ) {
		    
		    	if( ! empty( $v['data'] ) ) {
		    	
		    		$key = $fields[$field];
		    		
		    		if( ! is_array( $key ) ) {	        		
		    		
		    			$label = $v['data'][$key];						
		    			$placeholders['[' . str_replace( 'contact-', '', $field ) . ']'] = $label;
		    		
		    		} else {
		    		
		    			/**
		    			 * For checkboxes and radio buttons
		    			 * we have to deal with arrays in $get_post
		    			 */				
		    		
		    			$values  = '';
		    			$counter = 1;
		    			
		    			// Create comma list of values
		    			
		    			foreach( $key as $value ) {
		    				if( $counter > 1 )
		    					$values .= ', ';
		    				$values .= $v['data'][$value];
		    				$counter++;
		    			}
		    		
		    			$placeholders['[' . str_replace( 'contact-', '', $field ) . ']'] = $values;
		    		
		    		}
		    	
		    	} else {
		    	
		    		$placeholders['[' . str_replace( 'contact-', '', $field ) . ']'] = $fields[$field];
		    		
		    	}
		    	
		    }
		
		}
		
		return apply_filters( 'wpsight_contact_placeholders', $placeholders, $fields );
	
	}

}

/**
 * Set HTML content type for emails
 *
 * @since 1.2
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_set_html_content_type' ) ) {

	function wpsight_set_html_content_type() {
		return 'text/html';
	}

}
