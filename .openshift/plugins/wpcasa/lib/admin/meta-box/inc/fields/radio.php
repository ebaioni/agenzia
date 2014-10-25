<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'rwmb_Radio_Field' ) )
{
	class rwmb_Radio_Field
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
			$html = '';
			$tpl = '<label><input type="radio" class="rwmb-radio" name="%s" value="%s" %s /> %s</label>';

			foreach ( $field['options'] as $value => $label )
			{
				$html .= sprintf(
					$tpl,
					$field['field_name'],
					$value,
					checked( $value, $meta, false ),
					$label
				);
			}

			return $html;
		}
	}
}