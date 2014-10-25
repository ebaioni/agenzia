<?php

/**
 * Media Uploader Using the WordPress Media Library.
 *
 * Parameters:
 * - string $_id - A token to identify this field (the name).
 * - string $_value - The value of the field, if present.
 * - string $_desc - An optional description of the field.
 *
 */

if ( ! function_exists( 'optionsframework_uploader' ) ) :

function wpsight_options_uploader( $_id, $_value, $_desc = '', $_name = '' ) {

	$wpsight_options_settings = get_option( WPSIGHT_DOMAIN );
	
	// Gets the unique option id
	if ( isset( $wpsight_options_settings['id'] ) ) {
		$option_name = $wpsight_options_settings['id'];
	}
	else {
		$option_name = WPSIGHT_DOMAIN;
	};

	$output = '';
	$id = '';
	$class = '';
	$int = '';
	$value = '';
	$name = '';
	
	$id = strip_tags( strtolower( $_id ) );
	
	// If a value is passed and we don't have a stored value, use the value that's passed through.
	if ( $_value != '' && $value == '' ) {
		$value = $_value;
	}
	
	if ( $_name != '' ) {
		$name = $_name;
	}
	else {
		$name = $option_name.'['.$id.']';
	}
	
	if ( $value ) {
		$class = ' has-file';
	}
	
	$output .= '<div class="screenshot' . $class . '" id="' . $id . '-image">' . "\n";
	
	if ( $value != '' ) { 
		$remove = '<a class="remove-image">Remove</a>';
		$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
		if ( $image ) {
			$output .= '<img src="' . $value . '" alt="" />';
		} else {
			$parts = explode( "/", $value );
			for( $i = 0; $i < sizeof( $parts ); ++$i ) {
				$title = $parts[$i];
			}

			// No output preview if it's not an image.			
			$output .= '';
		
			// Standard generic output if it's not an image.	
			$title = __( 'View File', 'wpsight' );
			$output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span></div>';
		}	
	}
	
	$output .= '</div>' . "\n";
	
	$output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="'.$name.'" value="' . $value . '" placeholder="' . __('No file chosen', 'wpsight') .'" />' . "\n";
	if ( function_exists( 'wp_enqueue_media' ) ) {
		if ( ( $value == '' ) ) {
			$output .= '<input id="upload-' . $id . '" class="upload-button button" type="button" value="' . __( 'Upload', 'wpsight' ) . '" />' . "\n";
		} else {
			$output .= '<input id="remove-' . $id . '" class="remove-file button" type="button" value="' . __( 'Remove', 'wpsight' ) . '" />' . "\n";
		}
	} else {
		$output .= '<p><i>' . __( 'Upgrade your version of WordPress for full media support.', 'wpsight' ) . '</i></p>';
	}
	
	if ( $_desc != '' ) {
		$output .= '<span class="of-metabox-desc">' . $_desc . '</span>' . "\n";
	}
	
	return $output;
}

endif;

/**
 * Enqueue scripts for file uploader
 */
 
if ( ! function_exists( 'wpsight_options_media_scripts' ) ) :

add_action( 'admin_enqueue_scripts', 'wpsight_options_media_scripts' );

function wpsight_options_media_scripts( $hook ){

	if( $hook != 'appearance_page_' . WPSIGHT_DOMAIN )
		return;

	if ( function_exists( 'wp_enqueue_media' ) )
		wp_enqueue_media();
	wp_register_script( 'of-media-uploader', WPSIGHT_OPTIONS_DIR .'js/media-uploader.js', array( 'jquery' ) );
	wp_enqueue_script( 'of-media-uploader' );
	wp_localize_script( 'of-media-uploader', 'optionsframework_l10n', array(
		'upload' => __( 'Upload', 'wpsight' ),
		'remove' => __( 'Remove', 'wpsight' )
	) );
}

endif;
