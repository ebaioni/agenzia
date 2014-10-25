<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'rwmb_Map_Field' ) )
{
	class rwmb_Map_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), '', true );
			wp_enqueue_script( 'rwmb-map', RWMB_JS_URL . 'map.js', array( 'jquery', 'jquery-ui-autocomplete', 'googlemap' ), RWMB_VER, true );
			
			$map_icon_args = array(
				'map_icon'		    => apply_filters( 'wpsight_map_listing_icon', WPSIGHT_ASSETS_IMG_URL . '/map-listing.png' ),
				'map_icon_w'	    => 24,
				'map_icon_h'	    => 37,
				'map_icon_x'	    => 12,
				'map_icon_y'	    => 37,
				'map_icon_shadow'   => apply_filters( 'wpsight_map_listing_icon_shadow', WPSIGHT_ASSETS_IMG_URL . '/map-listing-shadow.png' ),
				'map_icon_shadow_w' => 24,
				'map_icon_shadow_h' => 17,
				'map_icon_shadow_x' => 12,
				'map_icon_shadow_y' => 8,
				'map_center_lat'	=> 36.509937,
				'map_center_long'	=> -4.886352,
				'map_streetview'	=> 1
			);
			
			$map_icon_args = apply_filters( 'wpsight_admin_listing_location_map_args', $map_icon_args );
			
			wp_localize_script( 'rwmb-map', 'wpsight_localize_map', $map_icon_args );
			
		}

		/**
		 * Add actions
		 *
		 * @return void
		 */
		static function add_actions()
		{
			
			// Save _map_address via Ajax
			add_action( 'wp_ajax_rwmb_save_map', array( __CLASS__, 'wp_ajax_save_map' ) );
		}

		static function wp_ajax_save_map(){

			$post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
			$map_address = isset( $_POST['map_address'] ) ? $_POST['map_address'] : '';
			$map_location = isset( $_POST['map_location'] ) ? $_POST['map_location'] : '';

			if( $post_id ){
					
				if( ! empty( $map_location ) ) {
					update_post_meta( $post_id, '_map_geo', $map_location );
					update_post_meta( $post_id, '_map_location', $map_location );
				}

				if( ! empty( $map_address ) )
					update_post_meta( $post_id, '_map_address', $map_address );

				RW_Meta_Box::ajax_response( __( 'Map Address saved', 'wpsight' ), 'success' );

			}else{

				RW_Meta_Box::ajax_response( __( 'Map Address saving fail', 'wpsight' ), 'error' );

			}

		}

		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$address = isset( $field['address_field'] ) ? $field['address_field'] : false;

			$html = sprintf(
				'<div class="rwmb-map-canvas" style="%s"></div>
				<input type="hidden" name="%s" id="rwmb-map-coordinate" value="%s" />',
				isset( $field['style'] ) ? $field['style'] : '',
				$field['field_name'],
				$meta
			);
			
			if ( $address )
			{
				$html .= sprintf(
					'<button class="button" type="button" id="rwmb-map-goto-address-button" value="%s" onclick="geocodeAddress(this.value);">%s</button>',
					is_array( $address ) ? implode( ',', $address ) : $address,
					__( 'Find Address', 'wpsight' )
				);
			}
			
			return $html;
		}
	}
}