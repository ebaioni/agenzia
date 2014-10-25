<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'rwmb_Hidden_Field' ) )
{
	class rwmb_Hidden_Field
	{
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
			return sprintf(
				'<input type="hidden" class="rwmb-hidden" name="%s" id="%s" value="%s" />',
				$field['field_name'],
				$field['id'],
				$meta
			);
		}
	}
}