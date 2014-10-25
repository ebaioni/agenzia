<?php
/**
 * Catch ajax request and check captcha
 *
 * @important This code has to be located at the top of this file.
 * @since 1.1
 */
	
if( isset( $_POST['from_js'] ) ) {
    
    session_start();
    if ( isset( $_POST['captcha_code_js'] ) ) {
    	if( strtolower( $_POST['captcha_code_js'] ) != $_SESSION['securimage_code_value']['default'] ) {
            echo json_encode( -1 ); //code wrong
        } else {
            echo json_encode( 1 ); //code correct
        }
     } else {
        echo json_encode( -2 ); //argument error
     }
     exit();
}

/**
 * Built the contact form
 *
 * @since 1.1
 */
 
add_action( 'wpsight_contact_form', 'wpsight_do_contact_form', 10, 2 );

function wpsight_do_contact_form( $location = false, $args = false ) {
        	
	// Get contact fields
	$contact_fields = wpsight_contact_fields();
	
	// Get contact labels
	$contact_labels = wpsight_contact_labels();
	
	// Get captcha image class
	require_once WPSIGHT_ADMIN_DIR . '/captcha/securimage.php';
	    
	$field_errors = array();

	// Create contact form
					
	if( isset( $_POST['submitted'] ) ) {
	
	    global $post, $securimage;
	    
	    if( $contact_fields['captcha']['show'] == true ) {
	    
	    	if( isset( $_POST['captcha_code'] ) ) {
	    	    
	    	    $securimage = new Securimage();
	    	    
	    	    if( strtolower( $_POST['captcha_code'] ) != $securimage->getCode() ){
	    	        $has_error = true; //code wrong
	    	        $has_captcha_error = true;
	    	        $captcha_text_error = '<div class="form-field-error">'. $contact_labels['captcha_error'] . '</div>';
	    	        $field_errors['captcha'] = $captcha_text_error;
	    	    }
	    	    
	    	} else {
	    	    $has_error = true; //argument error
	    	    $has_captcha_error = true;
	    	    $captcha_text_error = '<div class="form-field-error">'. $contact_labels['argument_error'] . '</div>';
	    	    $field_errors['captcha'] = $captcha_text_error;
	    	}
	    
	    } // endif $contact_fields['captcha']['show']
	    
	    /**
	     * Create $fields array
	     * and loop through contact fields
	     */
	    
	    $fields = array();
	    
	    // Validate form fields	    
	    
	    foreach( $contact_fields as $k => $v ) {
	    
		    if( $k == 'captcha' || $k == 'copy' )
		    	continue;
		
		    $field = $v['id'];
		
		    if( $v['required'] === true ) {
		    	
		    	if( trim( $_POST[$field] ) === '' ) {
		    		$field_error[$field] = '<div class="form-field-error">'. $contact_labels['field_error'] . '</div>';
		    		$field_errors[$field] = $field_error[$field];
		    		$has_error = true;
		    	} else {
		    		if( ! is_array( $_POST[$field] ) ) {
		    			$fields[$field] = stripslashes( trim( nl2br( $_POST[$field] ) ) );
		    		} else {
		    			$fields[$field] = array_map( 'trim', $_POST[$field] );
		    			foreach ( $_POST[$field] as $key => $value ) {
		    				$_POST[$field][$key] = stripslashes( $value );
		    			}
		    		}
		    	}				    			
		    
		    } elseif( $v['type'] === 'numbers' && ! empty( $_POST[$field] ) ) {
		    
		    	if( is_numeric( str_replace( ' ', '', $_POST[$field] ) ) === false ) {		    	
		    		$field_error[$field] = '<div class="form-field-error">'. $contact_labels['number_error']. '</div>';
		    		$field_errors[$field] = $field_error[$field];
		    		$has_error = true;
		    	} else {
		    		$fields[$field] = trim( $_POST[$field] );
		    	}
		    
		    } elseif( $v['required'] === 'email' ) {
		    
		    	if( trim( $_POST[$field] ) === '' ) {
		    		$field_error[$field] = '<div class="form-field-error">'. $contact_labels['field_error'] . '</div>';
		    		$field_errors[$field] = $field_error[$field];
		    		$has_error = true;
		    	} elseif( filter_var( trim( $_POST[$field] ), FILTER_VALIDATE_EMAIL ) === false ) {		    	
		    		$field_error[$field] = '<div class="form-field-error">'. $contact_labels['email_error'] . '</div>';
		    		$field_errors[$field] = $field_error[$field];
		    		$has_error = true;
		    	} else {
		    		$fields[$field] = trim( $_POST[$field] );
		    	}
		    
		    } else {
		    
		    	if( ! is_array( $_POST[$field] ) ) {
		    	    $fields[$field] = stripslashes( trim( nl2br( $_POST[$field] ) ) );
		    	} else {
		    	    $fields[$field] = array_map( 'trim', $_POST[$field] );
		    	    foreach ( $_POST[$field] as $key => $value ) {
		    		    $_POST[$field][$key] = stripslashes( $value );
		    		}
		    	}
		    
		    }
		    
		} // end foreach
	        
	    // Send email if no error
	    
	    if( ! isset( $has_error ) ) {
	    
	    	// Create email message
	    	$email = wpsight_contact_email( $_POST, $location, $fields );
	    
	    	// Set email to	(post author)
			$email_to = get_the_author_meta( 'email' );	
			
			// Set email to (custom field)
			
			$email_meta = get_post_meta( get_the_ID(), 'contact_email', true );
			
			if( ! empty( $email_meta ) )
			    $email_to = sanitize_email( $email_meta );
			
			// Set email to (widget settings)
			    
			if( ! empty( $args['email'] ) )
				$email_to = sanitize_email( $args['email'] );
				
			// Set email to (featured agent)
			if( ! empty( $fields['contact_agent'] ) )
				$email_to = $fields['contact_agent'];
				
			// Filter final $email_to
			$email_to = apply_filters( 'wpsight_contact_email_to', $email_to, $_POST, $location, $fields );
			    
			// Set from for copy
			$site = apply_filters( 'wpsight_listing_contact_site', get_bloginfo( 'name' ) );
	    	
	    	// Set email headers
	    				    			
			$headers 	  = 'From: ' . $fields['contact_name'] . ' <' . $fields['contact_email'] . '>' . "\r\n" . 'Reply-To: ' . $fields['contact_email'] . "\r\n" . 'Content-type: text/html';
			$headers_copy = 'From: ' . $site . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email_to . "\r\n" . 'Content-type: text/html';
			
			// Filter email headers
			
			$headers 	  = apply_filters( 'wpsight_contact_form_headers', $headers );
			$headers_copy = apply_filters( 'wpsight_contact_form_headers_copy', $headers_copy );
	        
	        // Set HTML content type
	        add_filter( 'wp_mail_content_type', 'wpsight_set_html_content_type' );            
	        
	        // Send email with wp_mail()	        
	        wp_mail( $email_to, $email['subject'], $email['body'], $headers );
	        
	        // Optionally send copy			    		
	        
	        $send_copy = isset( $_POST['copy'] ) ? trim( $_POST['copy'] ) : false;
	    
	        if( $send_copy == true )
	        	wp_mail( $fields['contact_email'], $email['subject'], $email['body'], $headers_copy );
	        
	        // Remove HTML content type	
	        remove_filter( 'wp_mail_content_type', 'wpsight_set_html_content_type' );
	    
	        $email_sent = true;      
	        
	        // Actions hook after email has been sent
	        do_action( 'wpsight_contact_form_sent', get_the_ID(), $email_to, $email, $location, $fields, $headers, $_POST );
	
	    } // endif ! isset( $has_error )
	
	} // isset( $_POST['submitted'] )
	
	// Validate contact form with AJAX
	do_action( 'wpsight_contact_validate_ajax', $_POST, $location );
	
	if( isset( $email_sent ) && $email_sent == true ) { ?>
	
	    <div class="form-field-confirm">
	    	<p><?php echo $contact_labels['confirm']; ?></p>
	    </div>
	
	<?php } else { ?>
	    
	    <?php if( isset( $has_error ) || isset( $captcha_error ) ) { ?>
	        <div class="form-error form-field-error">
	        	<?php echo $contact_labels['error']; ?>
	        </div>
	    <?php }
	    
	    // Add form fields
	    do_action( 'wpsight_contact_form_fields', $_POST, $location, $field_errors );
					    
	}

}

/**
 * Create contact form fields
 *
 * @since 1.2
 */
 
add_action( 'wpsight_contact_form_fields', 'wpsight_do_contact_form_fields', 10, 3 );

function wpsight_do_contact_form_fields( $get_post, $location = false, $field_errors = false ) {

	// Get contact fields
	$contact_fields = wpsight_contact_fields();

	// Get contact labels
	$contact_labels = wpsight_contact_labels();
	
	// Set URL optionally with fav=1
	$permalink = $location == 'favorites' ? add_query_arg( array( 'fav' => '1' ) ) : get_permalink(); ?>

	<form action="<?php echo $permalink; ?>" id="wpsight-contact-form" method="post">
	
	    <?php					    	
	    	// Add action hook before form fields
	    	do_action( 'wpsight_contact_fields_before', $get_post, $location );
	    
	    	// Build form output
	    	$form = '';
	    
	    	foreach( $contact_fields as $field => $v ) {
	    	
	    		if( $field == 'captcha' || $field == 'copy' )
	    			continue;
	    			
	    		// Set field parameters
	    	
	    		$field 		  = isset( $v['id'] ) ? $v['id'] : false;

	    		$field_value  = isset( $get_post[$field] ) ? $get_post[$field] : false;
	    		$field_value  = ( isset( $v['value'] ) && ! empty( $v['value'] ) ) ? $v['value'] : $field_value;

	    		$field_req      = ( isset( $v['required'] ) && $v['required'] ) ? ' required' : '';
	    		$field_disabled = ( isset( $v['disabled'] ) && $v['disabled'] ) ? ' disabled' : '';
	    		$field_hidden   = ( isset( $v['type'] ) && $v['type'] == 'hidden' ) ? ' hidden' : false;
	    			
	    		// Add action hook before form field
	    		do_action( 'wpsight_listing_contact_field_' . $field . '_before', $field, $v, $get_post, $location );
	
	    		// Set indexes
	
	    		$v['type'] 	 	 = isset( $v['type'] ) ? $v['type'] : false;
	    		$v['before'] 	 = isset( $v['before'] ) ? $v['before'] : false;
	    		$v['label']  	 = isset( $v['label'] ) ? $v['label'] : false;
	    		$v['after']  	 = isset( $v['after'] ) ? $v['after'] : false;
	    		$v['class']  	 = isset( $v['class'] ) ? ' ' . $v['class'] : false;
	    		$v['class_wrap'] = isset( $v['class_wrap'] ) ? ' ' . $v['class_wrap'] : false;
	    		
	    		// Create form field
	    
	    		$form .= '<div class="wrap-field wrap-field-type-' . $v['type'] . ' wrap-' . $field . $field_hidden . $v['class_wrap'] . '">';
	    		
	    			if( $v['before'] )
	    				$form .= $v['before'];
	    		
	    			if( $v['label'] )
	    				$form .= '<label for="' . $field . '">' . $v['label'] . ':</label>' . "\n";
	    			
	    			if( $v['type'] == 'text' || $v['type'] == 'numbers' ) {
	    				
	    				$class = $v['type'] == 'numbers' ? ' numbers' : false;
	    				$email = $v['required'] === 'email' ? ' email' : false;

	    				$form .= '<input type="text" name="' . $field . '" value="' . $field_value . '" id="id-' . $field . '" class="' . $field . ' text' . $class . $email . $field_req . $field_disabled . $v['class'] . '" ' . $field_disabled . ' />' . "\n";

	    			} elseif( $v['type'] == 'select' ) {
	    			
	    				if( ! empty( $v['data'] ) ) {
	    			
	    					$form .= '<select name="' . $field . '" id="id-' . $field . '" class="' . $field . ' select' . $field_req . $field_disabled . $v['class'] . '" ' . $field_disabled . ' />' . "\n";    					
	    					
	    						foreach( $v['data'] as $option => $label ) {
	    						
	    							$form .= '<option value="' . $option . '" ' . selected( $option, $field_value, false ) . '>' . $label . '</option>';
	    						
	    						} // endforeach
	    					
	    					$form .= '</select>' . "\n";
	    				
	    				} // endif
	    			
	    			} elseif( $v['type'] == 'checkbox' ) {
	    			
	    				if( ! empty( $v['data'] ) ) {
	    				
	    					// Set counter
	    					$counter = 1;
	    					
	    					foreach( $v['data'] as $option => $label ) {
	    					
	    						$field_req = ( $counter == 1 ) ? $field_req : false;
	    						$field_defaults = is_array( $field_value ) && in_array( $option, $field_value ) ? $option : $field_value;
	    					
	    					    $form .= '<div class="wrap-field-checkbox wrap-field-checkbox-' . $field . $field_req . '"><label>';
	    					    $form .= '<input type="checkbox" name="' . $field . '[]" id="id-' . $field . '-' . $counter . '" class="' . $field . ' checkbox' . $v['class'] . '" value="' . $option . '" ' . checked( $option, $field_defaults, false ) . '>' . $label;
	    					    $form .= '</label></div><!-- .wrap-field-checkbox wrap-field-checkbox-' . $field . ' -->';
	    					    
	    					    // Increase counter
	    					    $counter++;
	    					
	    					} // endforeach
	    				
	    				} // endif
	    			
	    			} elseif( $v['type'] == 'radio' ) {
	    			
	    				if( ! empty( $v['data'] ) ) {
	    				
	    					// Set counter
	    					$counter = 1;
	    					
	    					foreach( $v['data'] as $option => $label ) {
	    					
	    						$field_req = ( $counter == 1 ) ? $field_req : false;
	    						$field_checked = ( $field_value == false && $counter == 1 ) ? checked( 1, 1, false ) : checked( $option, $field_value, false );
	    					
	    					    $form .= '<div class="wrap-field-radio wrap-field-radio-' . $field . $field_req . '"><label>';
	    					    $form .= '<input type="radio" name="' . $field . '[]" id="id-' . $field . '-' . $counter . '" class="' . $field . ' radio' . $v['class'] . '" value="' . $option . '" ' . $field_checked . '>' . $label;
	    					    $form .= '</label></div><!-- .wrap-field-radio wrap-field-radio-' . $field . ' -->';
	    					    
	    					    // Increase counter
	    					    $counter++;
	    					
	    					} // endforeach
	    				
	    				} // endif
	    			
	    			} elseif( $v['type'] == 'textarea' ) {
	    				$form .= '<textarea name="' . $field . '" rows="20" cols="30" id="id-' . $field . '" class="' . $field . ' text' . $field_req . $field_disabled . $v['class'] . '" ' . $field_disabled . '>' . $field_value . '</textarea>' . "\n";
	    			} elseif( $v['type'] == 'hidden' ) {
	    				$form .= '<input type="hidden" name="' . $field . '" id="id-' . $field . '" value="' . $field_value . '" />' . "\n";
	    			}
	    			
	    			if( isset( $field_errors[$field] ) )
	    				$form .= $field_errors[$field];
	    				
	    			if( $v['after'] )
	    				$form .= $v['after'];
	    		
	    		$form .= '</div><!-- .wrap-' . $field . ' -->';
	    		
	    		// Add action hook after form field
	    		do_action( 'wpsight_listing_contact_field_' . $field . '_after', $field, $v, $get_post, $location );
	    	
	    	}
	    	
	    	echo $form;
	    
	    ?>
	    
	    <?php if( isset( $contact_fields['captcha'] ) && $contact_fields['captcha']['show'] == true ) { ?>
	    
	    <div class="wrap-field wrap-captcha clearfix">
	
	    	<?php
	    	    $captcha_width = $contact_fields['captcha']['image_width'];
	    	    $captcha_height = $contact_fields['captcha']['image_height'];
	    	?>
	    	
	    	<div class="captcha-image">
	    	
	    		<img id="captcha" src="<?php echo WPSIGHT_ADMIN_URL; ?>/captcha/securimage_show.php" width="<?php echo $captcha_width; ?>" height="<?php echo $captcha_height; ?>" alt="Captcha" />
	    		<a href="#" onclick="document.getElementById('captcha').src = '<?php echo WPSIGHT_ADMIN_URL; ?>/captcha/securimage_show.php?' + Math.random(); return false">[ <?php _e( 'Reload Image', 'wpsight' ); ?> ]</a>
	    	
	    	</div>
	    	
	    	<div class="captcha-input">
	    	
	    		<input type="text" name="captcha_code" id="captcha_code" size="5" maxlength="6" class="input-captcha required" />
	    	
	    		<?php if( isset( $field_errors['captcha'] ) ) echo $field_errors['captcha']; ?>
	    	
	    	</div>
	
	    </div><!-- .wrap-captcha -->
	    
	    <?php } // endif $contact_fields['captcha']['show'] ?>
	    
	    <div id="contact-footer" class="wrap-field clearfix">
	        
	        <div class="contact-buttons">
	        	<input type="hidden" name="submitted" id="submitted" value="true" />
	        	<input type="submit" class="<?php echo apply_filters( 'wpsight_button_class_contact', 'btn btn-large' ); ?>" value="<?php echo $contact_labels['submit']; ?>" />
	        </div><?php
	
	        if( isset( $contact_fields['copy'] ) && $contact_fields['copy']['show'] == true ) {
	
	        $get_post['copy'] = isset( $get_post['copy'] ) ? $get_post['copy'] : false; ?>
	    
	        <div class="contact-copy">
	        	<label class="checkbox">
	        		<input type="checkbox" name="copy" value="true"<?php checked( $get_post['copy'], true ); ?> />
	        		<?php echo $contact_labels['copy']; ?>
	        	</label>
	        </div>
	        
	        <?php } // endif $contact_fields['copy']['show'] ?>
	    
	    </div><!-- #contact-footer -->
	    
	    <?php
	    	// Add action hook after form fields
	    	do_action( 'wpsight_contact_fields_after', $get_post, $location );
	    ?>
	
	</form><?php

}

/**
 * Validate contact form with AJAX
 *
 * @since 1.2
 */
 
add_action( 'wpsight_contact_validate_ajax', 'wpsight_do_contact_validate_ajax', 10, 2 );

function wpsight_do_contact_validate_ajax( $get_post, $location = false ) {

	// Get contact fields
	$contact_fields = wpsight_contact_fields();

	// Get contact labels
	$contact_labels = wpsight_contact_labels(); ?>

	<script type="text/javascript">
	
	    var hasError = false;
	    var errorAjaxCaptcha = 0;
	
	    jQuery(document).ready(function($){
	        $('#wpsight-contact-form').submit(function() {
	        
	        	$('#wpsight-contact-form .form-field-error').remove();
	        	hasError = false;
	        	$('#wpsight-contact-form .required, #wpsight-contact-form .numbers').each(function() {
	        	
	        		if( $(this).hasClass('wrap-field-checkbox') ) {
	        			var name = $(this).find('.checkbox').attr('name');
	        			if( $('input[name="' + name + '"]:checked').length == 0 ) {
	        				$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['field_error']; ?></div>');
	        				hasError = true;
	        			}
	        		}
	        		
	        		if( $(this).hasClass('wrap-field-radio') ) {
	        			var name = $(this).find('.radio').attr('name');
	        			if( $('input[name="' + name + '"]:checked').length == 0 ) {
	        				$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['field_error']; ?></div>');
	        				hasError = true;
	        			}
	        		}
	        		
	        		if($.trim($(this).val()) == '' && $(this).hasClass('required') && typeof $(this).attr('name') != 'undefined') {
	        			$('.listing-contact').height('auto');
	        			var labelText = $(this).prev().prev('label').text();
	        			$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['field_error']; ?></div>');
	        			hasError = true;
	        		} else if($(this).hasClass('email')) {
	        			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	        			if(!emailReg.test(jQuery.trim($(this).val()))) {
	        				$('.listing-contact').height('auto');
	        				var labelText = $(this).prev().prev('label').text();
	        				$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['email_error'] ?></div>');
	        				hasError = true;
	        			}
	        		} else if($(this).hasClass('numbers') && $.trim($(this).val()) != '') {
	        			var numReg = /[^0-9\.]/g;	        			
	        			if(numReg.test(jQuery.trim($(this).val().replace(/ /g,'')))) {
	        				$('.listing-contact').height('auto');
	        				var labelText = $(this).prev().prev('label').text();
	        				$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['number_error'] ?></div>');
	        				hasError = true;
	        			}
	        		}
	        		<?php if( isset( $contact_fields['captcha'] ) && $contact_fields['captcha']['show'] == true ) { ?>
	        		else if($(this).hasClass('input-captcha')) {
	        			if($('#captcha_code').val() == '') {
	    	    			$('.listing-contact').height('auto');
	    	    			var labelText = $(this).prev().prev('label').text();
	    	    			$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['field_error']; ?></div>');
	    	    			hasError = true;
	        			} else {
	    					var params = 'from_js=ok&captcha_code_js=' + $('#captcha_code').val();
	    	    			$.ajax({
	    			          	type: "POST",
	    			          	url: "<?php echo WPSIGHT_LIB_URL.'/framework/contact.php'; ?>",
	    			          	dataType: 'text' ,
	    			          	data: params ,
	    			          	async: false ,
	    			            success: function( res ){
	    			            	errorAjaxCaptcha = res;
	    			            }
	    			        });
	    			        if(errorAjaxCaptcha < 0 ){
	    						hasError = true;
	    						$('.listing-contact').height('auto');
	    		    			var labelText = $(this).prev().prev('label').text();
	    		    			$(this).parent().append('<div class="form-field-error"><?php echo $contact_labels['captcha_error']; ?></div>');
	    					}
	    				}
	        		}
	        		<?php } // endif $contact_fields['captcha']['show'] ?>
	        	});
	        	if(!hasError) {
	        		$('#contact-footer').fadeOut('normal', function() {
	        			$(this).parent().append('<p><img src="<?php echo WPSIGHT_ADMIN_IMG_URL; ?>/loading.gif" alt="<?php _e( 'Loading', 'wpsight' ); ?>&hellip;" height="22" width="22" /></p>');
	        		});
	        		var formInput = $(this).serialize();
	        		$.post($(this).attr('action'),formInput, function(data){
	        			$('#wpsight-contact-form').slideUp(150, function() {
	        				$('.listing-contact').height('auto');			   
	        				$(this).before('<div class="form-field-confirm"><p><?php echo $contact_labels['confirm']; ?></p></div>');
	        			});
	        		});
	        	}
	        	
	        	return false;
	        	
	        });	            
	    });
	</script><?php	

}

/**
 * Add list of favorite listings
 * to form on contact page template
 *
 * @since 1.2 
 */
 
add_filter( 'wpsight_contact_fields', 'wpsight_contact_field_favorites' );

function wpsight_contact_field_favorites( $fields ) {

	if( ! isset( $_GET['fav'] ) || $_GET['fav'] != '1' || empty( $_COOKIE[WPSIGHT_COOKIE_FAVORITES] ) )
		return $fields;
		
	// Get listing IDs stored in cookie
	$favorites = explode( ',', $_COOKIE[WPSIGHT_COOKIE_FAVORITES] );
	
	$data = array();
	
	foreach( $favorites as $favorite ) {
		// Check if listing publish
		if( get_post_status( $favorite ) != 'publish' )
		    continue;
		$data[$favorite] = '<strong>' . wpsight_get_listing_id( $favorite ) . ':</strong> <a href="' . get_permalink( $favorite ) . '">' . get_the_title( $favorite ) . '</a>';
	}

	$fields['favorites'] = array(		
		'id'            => 'favorites',
        'label'         => __( 'Your favorites', 'wpsight' ),
        'required'      => false,
        'type'          => 'checkbox',
        'placeholder'   => false,
        'before'        => false,
        'after'         => '<div class="description">' . __( 'Please check the listings you wish to receive information about', 'wpsight' ) . '</div>',
        'value'         => $favorites,
        'data'          => $data,
        'position'      => 35
	);
	
	return $fields;

}

/**
 * Add agent info before form
 * fields on contact page template
 *
 * @since 1.2 
 */
 
add_action( 'wpsight_contact_fields_before', 'wpsight_contact_fields_agent_info' );

function wpsight_contact_fields_agent_info() {

	$author_slug = apply_filters( 'wpsight_author_slug', 'agent' );
	
	if( isset( $_GET[$author_slug] ) )
		$agent = get_userdata( $_GET[$author_slug] );
	
	if( isset( $agent ) && is_object( $agent ) )
		echo '<div class="alert">' . sprintf( __( 'Your message will be sent to %s', 'wpsight' ), $agent->display_name ) . '</div>';

}

/**
 * Add featured agent email
 * to form on contact page template
 *
 * @since 1.2 
 */
 
add_filter( 'wpsight_contact_fields', 'wpsight_contact_field_agent' );

function wpsight_contact_field_agent( $fields ) {

	$author_slug = apply_filters( 'wpsight_author_slug', 'agent' );

	if( ! isset( $_GET[$author_slug] ) )
		return $fields;
		
	$agent = get_userdata( $_GET[$author_slug] );
	
	if( ! is_object( $agent ) )
		return $fields;

	$fields['contact_agent'] = array(		
		'id'            => 'contact_agent',
        'label'         => false,
        'type'          => 'hidden',
        'value'         => $agent->ID,
        'position'      => 50
	);
	
	return $fields;

}