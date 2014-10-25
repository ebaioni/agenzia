<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'rwmb_Common' ) )
{
	/**
	 * Common functions for the plugin
	 * Independent from meta box/field classes
	 */
	class rwmb_Common
	{
		/**
		 * Do actions when class is loaded
		 *
		 * @return void
		 */
		static function on_load()
		{

		}
	}

	rwmb_Common::on_load();
}