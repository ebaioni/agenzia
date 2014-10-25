<?php
/**
 * Make new actions backwards compatible
 * replacing 'wpcasa' and 'property'
 *
 * @package wpSight
 * @subpackage wpCasa
 */
 
/**
 * Action: wpcasa_pre
 *
 * @since 1.2
 */

add_action( 'wpsight_pre', 'wpsight_pre_comp' );

function wpsight_pre_comp() {
	do_action( 'wpcasa_pre' );
}

/**
 * Action: wpcasa_pre_framework
 *
 * @since 1.2
 */

add_action( 'wpsight_pre_framework', 'wpsight_pre_framework_comp' );

function wpsight_pre_framework_comp() {
	do_action( 'wpcasa_pre_framework' );
}

/**
 * Action: wpcasa_init
 *
 * @since 1.2
 */

add_action( 'wpsight_init', 'wpsight_init_comp' );

function wpsight_init_comp() {
	do_action( 'wpcasa_init' );
}

/**
 * Action: wpcasa_setup
 *
 * @since 1.2
 */

add_action( 'wpsight_setup', 'wpsight_setup_comp' );

function wpsight_setup_comp() {
	do_action( 'wpcasa_setup' );
}

/**
 * Action: wpsight_before
 *
 * @since 1.2
 */

add_action( 'wpsight_before', 'wpsight_before_comp' );

function wpsight_before_comp() {
	do_action( 'wpcasa_before' );
}

/**
 * Action: wpcasa_after
 *
 * @since 1.2
 */

add_action( 'wpsight_after', 'wpsight_after_comp' );

function wpsight_after_comp() {
	do_action( 'wpcasa_after' );
}

/**
 * Action: wpcasa_head
 *
 * @since 1.2
 */

add_action( 'wpsight_head', 'wpsight_head_comp' );

function wpsight_head_comp() {
	do_action( 'wpcasa_head' );
}

/**
 * Action: wpcasa_header_before
 *
 * @since 1.2
 */

add_action( 'wpsight_header_before', 'wpsight_header_before_comp' );

function wpsight_header_before_comp() {
	do_action( 'wpcasa_header_before' );
}

/**
 * Action: wpcasa_header_after
 *
 * @since 1.2
 */

add_action( 'wpsight_header_after', 'wpsight_header_after_comp' );

function wpsight_header_after_comp() {
	do_action( 'wpcasa_header_after' );
}

/**
 * Action: wpcasa_logo
 *
 * @since 1.2
 */

add_action( 'wpsight_logo', 'wpsight_logo_comp' );

function wpsight_logo_comp() {
	do_action( 'wpcasa_logo' );
}

/**
 * Action: wpcasa_header_right
 *
 * @since 1.2
 */

add_action( 'wpsight_header_right', 'wpsight_header_right_comp' );

function wpsight_header_right_comp() {
	do_action( 'wpcasa_header_right' );
}

/**
 * Action: wpcasa_main_before
 *
 * @since 1.2
 */

add_action( 'wpsight_main_before', 'wpsight_main_before_comp' );

function wpsight_main_before_comp() {
	do_action( 'wpcasa_main_before' );
}

/**
 * Action: wpcasa_main_after
 *
 * @since 1.2
 */

add_action( 'wpsight_main_after', 'wpsight_main_after_comp' );

function wpsight_main_after_comp() {
	do_action( 'wpcasa_main_after' );
}

/**
 * Action: wpcasa_footer_before
 *
 * @since 1.2
 */

add_action( 'wpsight_footer_before', 'wpsight_footer_before_comp' );

function wpsight_footer_before_comp() {
	do_action( 'wpcasa_footer_before' );
}

/**
 * Action: wpcasa_footer_after
 *
 * @since 1.2
 */

add_action( 'wpsight_footer_after', 'wpsight_footer_after_comp' );

function wpsight_footer_after_comp() {
	do_action( 'wpcasa_footer_after' );
}

/**
 * Action: wpcasa_loop_title_actions
 *
 * @since 1.2
 */

add_action( 'wpsight_loop_title_actions', 'wpsight_loop_title_actions_comp' );

function wpsight_loop_title_actions_comp() {
	do_action( 'wpcasa_loop_title_actions' );
}

/**
 * Action: wpcasa_property_archive_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_archive_title_after', 'wpsight_listing_archive_title_after_comp' );

function wpsight_listing_archive_title_after_comp() {
	do_action( 'wpcasa_property_archive_title_after' );
}

/**
 * Action: wpcasa_comments_before
 *
 * @since 1.2
 */

add_action( 'wpsight_comments_before', 'wpsight_comments_before_comp' );

function wpsight_comments_before_comp() {
	do_action( 'wpcasa_comments_before' );
}

/**
 * Action: wpcasa_comments_list_before
 *
 * @since 1.2
 */

add_action( 'wpsight_comments_list_before', 'wpsight_comments_list_before_comp' );

function wpsight_comments_list_before_comp() {
	do_action( 'wpcasa_comments_list_before' );
}

/**
 * Action: wpcasa_list_comments
 *
 * @since 1.2
 */

add_action( 'wpsight_list_comments', 'wpsight_list_comments_comp' );

function wpsight_list_comments_comp() {
	do_action( 'wpcasa_list_comments' );
}

/**
 * Action: wpcasa_comments_list_after
 *
 * @since 1.2
 */

add_action( 'wpsight_comments_list_after', 'wpsight_comments_list_after_comp' );

function wpsight_comments_list_after_comp() {
	do_action( 'wpcasa_comments_list_after' );
}

/**
 * Action: wpcasa_comments_after
 *
 * @since 1.2
 */

add_action( 'wpsight_comments_after', 'wpsight_comments_after_comp' );

function wpsight_comments_after_comp() {
	do_action( 'wpcasa_comments_after' );
}

/**
 * Action: wpcasa_comment_before
 *
 * @since 1.2
 */

add_action( 'wpsight_comment_before', 'wpsight_comment_before_comp' );

function wpsight_comment_before_comp() {
	do_action( 'wpcasa_comment_before' );
}

/**
 * Action: wpcasa_comment_after
 *
 * @since 1.2
 */

add_action( 'wpsight_comment_after', 'wpsight_comment_after_comp' );

function wpsight_comment_after_comp() {
	do_action( 'wpcasa_comment_after' );
}

/**
 * Action: wpcasa_pings_before
 *
 * @since 1.2
 */

add_action( 'wpsight_pings_before', 'wpsight_pings_before_comp' );

function wpsight_pings_before_comp() {
	do_action( 'wpcasa_pings_before' );
}

/**
 * Action: wpcasa_pings_list_before
 *
 * @since 1.2
 */

add_action( 'wpsight_pings_list_before', 'wpsight_pings_list_before_comp' );

function wpsight_pings_list_before_comp() {
	do_action( 'wpcasa_pings_list_before' );
}

/**
 * Action: wpcasa_list_pings
 *
 * @since 1.2
 */

add_action( 'wpsight_list_pings', 'wpsight_list_pings_comp' );

function wpsight_list_pings_comp() {
	do_action( 'wpcasa_list_pings' );
}

/**
 * Action: wpcasa_pings_list_after
 *
 * @since 1.2
 */

add_action( 'wpsight_pings_list_after', 'wpsight_pings_list_after_comp' );

function wpsight_pings_list_after_comp() {
	do_action( 'wpcasa_pings_list_after' );
}

/**
 * Action: wpcasa_pings_after
 *
 * @since 1.2
 */

add_action( 'wpsight_pings_after', 'wpsight_pings_after_comp' );

function wpsight_pings_after_comp() {
	do_action( 'wpcasa_pings_after' );
}

/**
 * Action: wpcasa_ping_before
 *
 * @since 1.2
 */

add_action( 'wpsight_ping_before', 'wpsight_ping_before_comp' );

function wpsight_ping_before_comp() {
	do_action( 'wpcasa_ping_before' );
}

/**
 * Action: wpcasa_ping_after
 *
 * @since 1.2
 */

add_action( 'wpsight_ping_after', 'wpsight_ping_after_comp' );

function wpsight_ping_after_comp() {
	do_action( 'wpcasa_ping_after' );
}

/**
 * Action: wpcasa_comment_form_before
 *
 * @since 1.2
 */

add_action( 'wpsight_comment_form_before', 'wpsight_comment_form_before_comp' );

function wpsight_comment_form_before_comp() {
	do_action( 'wpcasa_comment_form_before' );
}

/**
 * Action: wpcasa_comment_form_after
 *
 * @since 1.2
 */

add_action( 'wpsight_comment_form_after', 'wpsight_comment_form_after_comp' );

function wpsight_comment_form_after_comp() {
	do_action( 'wpcasa_comment_form_after' );
}

/**
 * Action: wpcasa_post_title_before
 *
 * @since 1.2
 */

add_action( 'wpsight_post_title_before', 'wpsight_post_title_before_comp' );

function wpsight_post_title_before_comp() {
	do_action( 'wpcasa_post_title_before' );
}

/**
 * Action: wpcasa_post_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_post_title_after', 'wpsight_post_title_after_comp' );

function wpsight_post_title_after_comp() {
	do_action( 'wpcasa_post_title_after' );
}

/**
 * Action: wpcasa_post_content_before
 *
 * @since 1.2
 */

add_action( 'wpsight_post_content_before', 'wpsight_post_content_before_comp' );

function wpsight_post_content_before_comp() {
	do_action( 'wpcasa_post_content_before' );
}

/**
 * Action: wpcasa_post_content_after
 *
 * @since 1.2
 */

add_action( 'wpsight_post_content_after', 'wpsight_post_content_after_comp' );

function wpsight_post_content_after_comp() {
	do_action( 'wpcasa_post_content_after' );
}

/**
 * Action: wpcasa_start_screen
 *
 * @since 1.2
 */

add_action( 'wpsight_start_screen', 'wpsight_start_screen_comp' );

function wpsight_start_screen_comp() {
	do_action( 'wpcasa_start_screen' );
}

/**
 * Action: wpcasa_custom_scripts
 *
 * @since 1.2
 */

add_action( 'wpsight_options_custom_scripts', 'wpsight_options_custom_scripts_comp' );

function wpsight_options_custom_scripts_comp() {
	do_action( 'wpcasa_custom_scripts' );
}

/**
 * Action: wpcasa_property_contact_fields_before
 *
 * @since 1.2
 */

add_action( 'wpsight_contact_fields_before', 'wpsight_contact_fields_before_comp', 10, 2 );

function wpsight_contact_fields_before_comp( $get_post = false, $location = false ) {
	do_action( 'wpcasa_property_contact_fields_before', $get_post, $location );
}

/**
 * Action: wpcasa_property_contact_fields_after
 *
 * @since 1.2
 */

add_action( 'wpsight_contact_fields_after', 'wpsight_contact_fields_after_comp', 10, 2 );

function wpsight_contact_fields_after_comp( $get_post = false, $location = false ) {
	do_action( 'wpcasa_property_contact_fields_after', $get_post, $location );
}

/**
 * Action: wpcasa_widget_latest_title_actions
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_latest_title_actions', 'wpsight_widget_latest_title_actions_comp', 10, 2 );

function wpsight_widget_latest_title_actions_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_widget_latest_title_actions', $args, $instance );
}

/**
 * Action: wpcasa_widget_post_title_before
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_post_title_before', 'wpsight_widget_post_title_before_comp', 10, 2 );

function wpsight_widget_post_title_before_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_post_title_before', $width, $id );
}

/**
 * Action: wpcasa_widget_post_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_post_title_inside', 'wpsight_widget_post_title_inside_comp', 10, 2 );

function wpsight_widget_post_title_inside_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_post_title_inside', $width, $id );
}

/**
 * Action: wpcasa_widget_post_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_post_title_after', 'wpsight_widget_post_title_after_comp', 10, 2 );

function wpsight_widget_post_title_after_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_post_title_after', $width, $id );
}

/**
 * Action: wpcasa_widget_post_content_before
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_post_content_before', 'wpsight_widget_post_content_before_comp', 10, 2 );

function wpsight_widget_post_content_before_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_post_content_before', $width, $id );
}

/**
 * Action: wpcasa_widget_post_content_after
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_post_content_after', 'wpsight_widget_post_content_after_comp', 10, 2 );

function wpsight_widget_post_content_after_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_post_content_after', $width, $id );
}

/**
 * Action: wpcasa_widget_properties_latest_title_actions
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listings_latest_title_actions', 'wpsight_widget_listings_latest_title_actions_comp', 10, 2 );

function wpsight_widget_listings_latest_title_actions_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_properties_latest_title_actions', $width, $id );
}

/**
 * Action: wpcasa_widget_property_title_before
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listing_title_before', 'wpsight_widget_listing_title_before_comp', 10, 2 );

function wpsight_widget_listing_title_before_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_property_title_before', $width, $id );
}

/**
 * Action: wpcasa_widget_property_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listing_title_inside', 'wpsight_widget_listing_title_inside_comp', 10, 2 );

function wpsight_widget_listing_title_inside_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_property_title_inside', $width, $id );
}

/**
 * Action: wpcasa_widget_property_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listing_title_after', 'wpsight_widget_listing_title_after_comp', 10, 2 );

function wpsight_widget_listing_title_after_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_property_title_after', $width, $id );
}

/**
 * Action: wpcasa_widget_property_content_before
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listing_content_before', 'wpsight_widget_listing_content_before_comp', 10, 2 );

function wpsight_widget_listing_content_before_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_property_content_before', $width, $id );
}

/**
 * Action: wpcasa_widget_property_content_after
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listing_content_after', 'wpsight_widget_listing_content_after_comp', 10, 2 );

function wpsight_widget_listing_content_after_comp( $width = false, $id = false ) {
	do_action( 'wpcasa_widget_property_content_after', $width, $id );
}

/**
 * Action: wpcasa_property_search_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listings_search_title_inside', 'wpsight_listings_search_title_inside_comp', 10, 2 );

function wpsight_listings_search_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_search_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_search
 *
 * @since 1.2
 */

add_action( 'wpsight_listings_search', 'wpsight_listings_search_comp', 10, 2 );

function wpsight_listings_search_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_search', $args, $instance );
}

/**
 * Action: wpcasa_widget_slider_title_actions
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_slider_title_actions', 'wpsight_widget_slider_title_actions_comp', 10, 2 );

function wpsight_widget_slider_title_actions_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_widget_slider_title_actions', $args, $instance );
}

/**
 * Action: wpcasa_widget_property_slider_title_before
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listings_slider_title_before', 'wpsight_widget_listings_slider_title_before_comp', 10, 2 );

function wpsight_widget_listings_slider_title_before_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_widget_property_slider_title_before', $args, $instance );
}

/**
 * Action: wpcasa_widget_property_slider_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listings_slider_title_after', 'wpsight_widget_listings_slider_title_after_comp', 10, 2 );

function wpsight_widget_listings_slider_title_after_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_widget_property_slider_title_after', $args, $instance );
}

/**
 * Action: wpcasa_widget_property_slider_teaser_after
 *
 * @since 1.2
 */

add_action( 'wpsight_widget_listings_slider_teaser_after', 'wpsight_widget_listings_slider_teaser_after_comp', 10, 2 );

function wpsight_widget_listings_slider_teaser_after_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_widget_property_slider_teaser_after', $args, $instance );
}

/**
 * Action: wpcasa_property_agent_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_agent_title_inside', 'wpsight_listing_agent_title_inside_comp', 10, 2 );

function wpsight_listing_agent_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_agent_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_contact_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_contact_title_inside', 'wpsight_listing_contact_title_inside_comp', 10, 2 );

function wpsight_listing_contact_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_contact_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_contact_form
 *
 * @since 1.2
 */

add_action( 'wpsight_contact_form', 'wpsight_contact_form_comp', 10, 2 );

function wpsight_contact_form_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_contact_form', $args, $instance );
}

/**
 * Action: wpcasa_property_description_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_description_title_inside', 'wpsight_listing_description_title_inside_comp', 10, 2 );

function wpsight_listing_description_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_description_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_details_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_details_title_inside', 'wpsight_listing_details_title_inside_comp', 10, 2 );

function wpsight_listing_details_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_details_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_features_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_features_title_inside', 'wpsight_listing_features_title_inside_comp', 10, 2 );

function wpsight_listing_features_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_features_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_gallery_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_gallery_title_inside', 'wpsight_listing_gallery_title_inside_comp', 10, 2 );

function wpsight_listing_gallery_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_gallery_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_image_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_image_title_inside', 'wpsight_listing_image_title_inside_comp', 10, 2 );

function wpsight_listing_image_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_image_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_location_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_location_title_inside', 'wpsight_listing_location_title_inside_comp', 10, 2 );

function wpsight_listing_location_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_location_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_title_inside
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_title_inside', 'wpsight_listing_title_inside_comp', 10, 2 );

function wpsight_listing_title_inside_comp( $args = false, $instance = false ) {
	do_action( 'wpcasa_property_title_inside', $args, $instance );
}

/**
 * Action: wpcasa_property_title_before
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_title_before', 'wpsight_listing_title_before_comp' );

function wpsight_listing_title_before_comp() {
	do_action( 'wpcasa_property_title_before' );
}

/**
 * Action: wpcasa_property_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_title_after', 'wpsight_listing_title_after_comp' );

function wpsight_listing_title_after_comp() {
	do_action( 'wpcasa_property_title_after' );
}

/**
 * Action: wpcasa_property_map_content
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_map_content', 'wpsight_listing_map_content_comp' );

function wpsight_listing_map_content_comp() {
	do_action( 'wpcasa_property_map_content' );
}

/**
 * Action: wpcasa_property_content_before
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_content_before', 'wpsight_listing_content_before_comp' );

function wpsight_listing_content_before_comp() {
	do_action( 'wpcasa_property_content_before' );
}

/**
 * Action: wpcasa_property_archive_title_after
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_archive_title_after', 'wpsight_listing_archive_title_after_comp', 10, 2 );

function wpsight_listing_content_after_comp( $args = false, $content_class = false ) {
	do_action( 'wpcasa_property_archive_title_after', $args, $content_class );
}

/**
 * Action: wpcasa_property_favorites_after
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_favorites_after', 'wpsight_listing_favorites_after_comp' );

function wpsight_listing_favorites_after_comp( $cookie = false ) {
	do_action( 'wpcasa_property_favorites_after', $cookie );
}

/**
 * Action: wpcasa_head_print
 *
 * @since 1.2
 */

add_action( 'wpsight_head_print', 'wpsight_head_print_comp' );

function wpsight_head_print_comp() {
	do_action( 'wpcasa_head_print' );
}

/**
 * Action: wpcasa_property_print_before
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_print_before', 'wpsight_listing_print_before_comp' );

function wpsight_listing_print_before_comp( $property_id = false ) {
	do_action( 'wpcasa_property_print_before', $property_id );
}

/**
 * Action: wpcasa_property_print_after
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_print_after', 'wpsight_listing_print_after_comp' );

function wpsight_listing_print_after_comp( $property_id = false ) {
	do_action( 'wpcasa_property_print_after', $property_id );
}

/**
 * Action: wpcasa_footer_print
 *
 * @since 1.2
 */

add_action( 'wpsight_footer_print', 'wpsight_footer_print_comp' );

function wpsight_footer_print_comp() {
	do_action( 'wpcasa_footer_print' );
}

/**
 * Action: wpcasa_property_widgets_before
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_widgets_before', 'wpsight_listing_widgets_before_comp' );

function wpsight_listing_widgets_before_comp() {
	do_action( 'wpcasa_property_widgets_before' );
}

/**
 * Action: wpcasa_property_widgets_after
 *
 * @since 1.2
 */

add_action( 'wpsight_listing_widgets_after', 'wpsight_listing_widgets_after_comp', 9 );

function wpsight_listing_widgets_after_comp() {
	do_action( 'wpcasa_property_widgets_after' );
}

/**
 * Action: wpcasa_sidebar_property_widgets_before
 *
 * @since 1.2
 */

add_action( 'wpsight_sidebar_listing_widgets_before', 'wpsight_sidebar_listing_widgets_before_comp' );

function wpsight_sidebar_listing_widgets_before_comp() {
	do_action( 'wpcasa_sidebar_property_widgets_before' );
}

/**
 * Action: wpcasa_sidebar_property_widgets_after
 *
 * @since 1.2
 */

add_action( 'wpsight_sidebar_listing_widgets_after', 'wpsight_sidebar_listing_widgets_after_comp' );

function wpsight_sidebar_listing_widgets_after_comp() {
	do_action( 'wpcasa_sidebar_property_widgets_after' );
}

/**
 * Action: wpcasa_sidebar_widgets_before
 *
 * @since 1.2
 */

add_action( 'wpsight_sidebar_widgets_before', 'wpsight_sidebar_widgets_before_comp' );

function wpsight_sidebar_widgets_before_comp() {
	do_action( 'wpcasa_sidebar_widgets_before' );
}

/**
 * Action: wpcasa_sidebar_widgets_after
 *
 * @since 1.2
 */

add_action( 'wpsight_sidebar_widgets_after', 'wpsight_sidebar_widgets_after_comp' );

function wpsight_sidebar_widgets_after_comp() {
	do_action( 'wpcasa_sidebar_widgets_after' );
}
