<?php
/**
 * Make new filters backwards compatible
 * replacing 'wpcasa' and 'property'
 *
 * @package wpSight
 * @subpackage wpCasa
 */
 
/**
 * Filter: wpcasa_the_404
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_the_404', 'wpsight_the_404_comp' );

function wpsight_the_404_comp( $output ) {
	return apply_filters( 'wpcasa_the_404', $output );
}

/**
 * Filter: wpcasa_author_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_author_title', 'wpsight_author_title_comp' );

function wpsight_author_title_comp( $output ) {
	return apply_filters( 'wpcasa_author_title', $output );
}

/**
 * Filter: wpcasa_category_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_category_title', 'wpsight_category_title_comp' );

function wpsight_category_title_comp( $output ) {
	return apply_filters( 'wpcasa_category_title', $output );
}

/**
 * Filter: wpcasa_comments_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_comments_title', 'wpsight_comments_title_comp' );

function wpsight_comments_title_comp( $output ) {
	return apply_filters( 'wpcasa_comments_title', $output );
}

/**
 * Filter: wpcasa_no_comments_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_no_comments_text', 'wpsight_no_comments_text_comp' );

function wpsight_no_comments_text_comp( $output ) {
	return apply_filters( 'wpcasa_no_comments_text', $output );
}

/**
 * Filter: wpcasa_comments_closed_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_comments_closed_text', 'wpsight_comments_closed_text_comp' );

function wpsight_comments_closed_text_comp( $output ) {
	return apply_filters( 'wpcasa_comments_closed_text', $output );
}

/**
 * Filter: wpcasa_pings_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_pings_title', 'wpsight_pings_title_comp' );

function wpsight_pings_title_comp( $output ) {
	return apply_filters( 'wpcasa_pings_title', $output );
}

/**
 * Filter: wpcasa_no_pings_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_no_pings_text', 'wpsight_no_pings_text_comp' );

function wpsight_no_pings_text_comp( $output ) {
	return apply_filters( 'wpcasa_no_pings_text', $output );
}

/**
 * Filter: wpcasa_comment_form_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_comment_form_args', 'wpsight_comment_form_args_comp', 10, 6 );

function wpsight_comment_form_args_comp( $args, $user_identity = false, $id = false, $commenter = false, $req = false, $aria_req = false ) {
	return apply_filters( 'wpcasa_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );
}

/**
 * Filter: wpcasa_attachment_full_width
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_attachment_full_width', 'wpsight_attachment_full_width_comp' );

function wpsight_attachment_full_width_comp( $output ) {
	return apply_filters( 'wpcasa_attachment_full_width', $output );
}

/**
 * Filter: wpcasa_attachment_image_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_attachment_image_args', 'wpsight_attachment_image_args_comp' );

function wpsight_attachment_image_args_comp( $args ) {
	return apply_filters( 'wpcasa_attachment_image_args', $args );
}

/**
 * Filter: wpcasa_options_general
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_options_general', 'wpsight_options_general_comp' );

function wpsight_options_general_comp( $options ) {
	return apply_filters( 'wpcasa_options_general', $options );
}

/**
 * Filter: wpcasa_options_layout
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_options_layout', 'wpsight_options_layout_comp' );

function wpsight_options_layout_comp( $options ) {
	return apply_filters( 'wpcasa_options_layout', $options );
}

/**
 * Filter: wpcasa_options_properties
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_options_listings', 'wpsight_options_listings_comp' );

function wpsight_options_listings_comp( $options ) {
	return apply_filters( 'wpcasa_options_properties', $options );
}

/**
 * Filter: wpcasa_options_search
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_options_search', 'wpsight_options_search_comp' );

function wpsight_options_search_comp( $options ) {
	return apply_filters( 'wpcasa_options_search', $options );
}

/**
 * Filter: wpcasa_options_social
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_options_social', 'wpsight_options_social_comp' );

function wpsight_options_social_comp( $options ) {
	return apply_filters( 'wpcasa_options_social', $options );
}

/**
 * Filter: wpcasa_options
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_options', 'wpsight_options_comp' );

function wpsight_options_comp( $options ) {
	return apply_filters( 'wpcasa_options', $options );
}

/**
 * Filter: wpcasa_widget_properties_search_filters_nr
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_search_filters_nr', 'wpsight_listing_search_filters_nr_comp' );

function wpsight_listing_search_filters_nr_comp( $nr ) {
	return apply_filters( 'wpcasa_widget_properties_search_filters_nr', $nr );
}

/**
 * Filter: wpcasa_social_icons_nr
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_social_icons_nr', 'wpsight_social_icons_nr_comp' );

function wpsight_social_icons_nr_comp( $nr ) {
	return apply_filters( 'wpcasa_social_icons_nr', $nr );
}

/**
 * Filter: wpcasa_property_price_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_price_labels', 'wpsight_listing_price_labels_comp' );

function wpsight_listing_price_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_property_price_labels', $labels );
}

/**
 * Filter: wpcasa_property_details_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_details_labels', 'wpsight_listing_details_labels_comp' );

function wpsight_listing_details_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_property_details_labels', $labels );
}

/**
 * Filter: wpcasa_property_location_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_location_labels', 'wpsight_listing_location_labels_comp' );

function wpsight_listing_location_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_property_location_labels', $labels );
}

/**
 * Filter: wpcasa_post_options_layouts
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_meta_box_post_layouts_layouts', 'wpsight_meta_box_layouts_layouts_comp' );
add_filter( 'wpsight_meta_box_listing_layouts_layouts', 'wpsight_meta_box_layouts_layouts_comp' );

function wpsight_meta_box_layouts_layouts_comp( $layouts ) {
	return apply_filters( 'wpcasa_post_options_layouts', $layouts );
}

/**
 * Filter: wpcasa_property_layout_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_layout_args', 'wpsight_listing_layout_args_comp' );

function wpsight_listing_layout_args_comp( $args ) {
	return apply_filters( 'wpcasa_property_layout_args', $args );
}

/**
 * Filter: wpcasa_get_comments_template_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_get_comments_template_args', 'wpsight_get_comments_template_args_comp' );

function wpsight_get_comments_template_args_comp( $args ) {
	return apply_filters( 'wpcasa_get_comments_template_args', $args );
}

/**
 * Filter: wpcasa_do_list_comments_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_list_comments_args', 'wpsight_do_list_comments_args_comp' );

function wpsight_do_list_comments_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_list_comments_args', $args );
}

/**
 * Filter: wpcasa_comment_awaiting_moderation
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_comment_awaiting_moderation', 'wpsight_comment_awaiting_moderation_comp' );

function wpsight_comment_awaiting_moderation_comp( $text ) {
	return apply_filters( 'wpcasa_comment_awaiting_moderation', $text );
}

/**
 * Filter: wpcasa_ping_list_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_ping_list_args', 'wpsight_ping_list_args_comp' );

function wpsight_ping_list_args_comp( $args ) {
	return apply_filters( 'wpcasa_ping_list_args', $args );
}

/**
 * Filter: wpcasa_property_contact_site
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_contact_site', 'wpsight_listing_contact_site_comp' );

function wpsight_listing_contact_site_comp( $output ) {
	return apply_filters( 'wpcasa_property_contact_site', $output );
}

/**
 * Filter: wpcasa_property_contact_email_subject
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_contact_email_subject', 'wpsight_contact_email_subject_comp' );

function wpsight_contact_email_subject_comp( $output ) {
	return apply_filters( 'wpcasa_property_contact_email_subject', $output );
}

/**
 * Filter: wpcasa_property_contact_email_body
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_contact_email_body', 'wpsight_contact_email_body_comp' );

function wpsight_contact_email_body_comp( $output ) {
	return apply_filters( 'wpcasa_property_contact_email_body', $output );
}

/**
 * Filter: wpcasa_do_title_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_title_args', 'wpsight_do_title_args_comp' );

function wpsight_do_title_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_title_args', $args );
}

/**
 * Filter: wpcasa_do_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_title', 'wpsight_do_title_comp' );

function wpsight_do_title_comp( $output ) {
	return apply_filters( 'wpcasa_do_title', $output );
}

/**
 * Filter: wpcasa_do_meta
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_meta', 'wpsight_do_meta_comp' );

function wpsight_do_meta_comp( $output ) {
	return apply_filters( 'wpcasa_do_meta', $output );
}

/**
 * Filter: wpcasa_feed_link_array
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_feed_link_array', 'wpsight_feed_link_array_comp' );

function wpsight_feed_link_array_comp( $array ) {
	return apply_filters( 'wpcasa_feed_link_array', $array );
}

/**
 * Filter: wpcasa_social_icons_top
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_social_icons_top', 'wpsight_social_icons_top_comp' );

function wpsight_social_icons_top_comp( $output ) {
	return apply_filters( 'wpcasa_social_icons_top', $output );
}

/**
 * Filter: wpcasa_custom_header_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_custom_header_args', 'wpsight_custom_header_args_comp' );

function wpsight_custom_header_args_comp( $args ) {
	return apply_filters( 'wpcasa_custom_header_args', $args );
}

/**
 * Filter: wpcasa_custom_background_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_custom_background_args', 'wpsight_custom_background_args_comp' );

function wpsight_custom_background_args_comp( $args ) {
	return apply_filters( 'wpcasa_custom_background_args', $args );
}

/**
 * Filter: wpcasa_do_logo
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_logo', 'wpsight_do_logo_comp' );

function wpsight_do_logo_comp( $output ) {
	return apply_filters( 'wpcasa_do_logo', $output );
}

/**
 * Filter: wpcasa_do_header_right
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_header_right', 'wpsight_do_header_right_comp' );

function wpsight_do_header_right_comp( $output ) {
	return apply_filters( 'wpcasa_do_header_right', $output );
}

/**
 * Filter: wpcasa_layout_wrap
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_layout_wrap', 'wpsight_layout_wrap_comp', 10, 3 );

function wpsight_layout_wrap_comp( $layout_wrap, $wrap_id = false, $close = false ) {
	return apply_filters( 'wpcasa_layout_wrap', $layout_wrap, $wrap_id, $close );
}

/**
 * Filter: wpcasa_do_main_top_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_main_top_args', 'wpsight_do_main_top_args_comp' );

function wpsight_do_main_top_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_main_top_args', $args );
}

/**
 * Filter: wpcasa_do_main_bottom_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_main_bottom_args', 'wpsight_do_main_bottom_args_comp' );

function wpsight_do_main_bottom_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_main_bottom_args', $args );
}

/**
 * Filter: wpcasa_welcome_screen
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_welcome_screen', 'wpsight_welcome_screen_comp' );

function wpsight_welcome_screen_comp( $output ) {
	return apply_filters( 'wpcasa_welcome_screen', $output );
}

/**
 * Filter: wpcasa_example_xml_name
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_example_xml_name', 'wpsight_example_xml_name_comp' );

function wpsight_example_xml_name_comp( $output ) {
	return apply_filters( 'wpcasa_example_xml_name', $output );
}

/**
 * Filter: wpcasa_home_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_home_query_args', 'wpsight_home_query_args_comp' );

function wpsight_home_query_args_comp( $output ) {
	return apply_filters( 'wpcasa_home_query_args', $output );
}

/**
 * Filter: wpcasa_button_class_contact
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_button_class_contact', 'wpsight_button_class_contact_comp' );

function wpsight_button_class_contact_comp( $output ) {
	return apply_filters( 'wpcasa_button_class_contact', $output );
}

/**
 * Filter: wpcasa_button_class_comment
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_button_class_comment', 'wpsight_button_class_comment_comp' );

function wpsight_button_class_comment_comp( $output ) {
	return apply_filters( 'wpcasa_button_class_comment', $output );
}

/**
 * Filter: wpcasa_button_class_search
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_button_class_search', 'wpsight_button_class_search_comp' );

function wpsight_button_class_search_comp( $output ) {
	return apply_filters( 'wpcasa_button_class_search', $output );
}

/**
 * Filter: wpcasa_button_class_search_default
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_button_class_search_default', 'wpsight_button_class_search_default_comp' );

function wpsight_button_class_search_default_comp( $output ) {
	return apply_filters( 'wpcasa_button_class_search_default', $output );
}

/**
 * Filter: wpcasa_button_class_calltoaction
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_button_class_calltoaction', 'wpsight_button_class_calltoaction_comp' );

function wpsight_button_class_calltoaction_comp( $output ) {
	return apply_filters( 'wpcasa_button_class_calltoaction', $output );
}

/**
 * Filter: wpcasa_button_class_agent
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_button_class_agent', 'wpsight_button_class_agent_comp' );

function wpsight_button_class_agent_comp( $output ) {
	return apply_filters( 'wpcasa_button_class_agent', $output );
}

/**
 * Filter: wpcasa_post_sticky
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_sticky', 'wpsight_post_sticky_comp' );

function wpsight_post_sticky_comp( $output ) {
	return apply_filters( 'wpcasa_post_sticky', $output );
}

/**
 * Filter: wpcasa_do_post_meta
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_post_meta', 'wpsight_do_post_meta_comp' );

function wpsight_do_post_meta_comp( $output ) {
	return apply_filters( 'wpcasa_do_post_meta', $output );
}

/**
 * Filter: wpcasa_do_widget_post_meta
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_widget_post_meta', 'wpsight_do_widget_post_meta_comp' );

function wpsight_do_widget_post_meta_comp( $output ) {
	return apply_filters( 'wpcasa_do_widget_post_meta', $output );
}

/**
 * Filter: wpcasa_do_attachment_meta
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_attachment_meta', 'wpsight_do_attachment_meta_comp' );

function wpsight_do_attachment_meta_comp( $output ) {
	return apply_filters( 'wpcasa_do_attachment_meta', $output );
}

/**
 * Filter: wpcasa_post_image_overlay
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_image_overlay', 'wpsight_post_image_overlay_comp' );

function wpsight_post_image_overlay_comp( $output ) {
	return apply_filters( 'wpcasa_post_image_overlay', $output );
}

add_filter( 'wpsight_listing_image_overlay', 'wpsight_listing_image_overlay_comp' );

function wpsight_listing_image_overlay_comp( $output ) {

	if( get_post_type() != wpsight_listing_post_type() )
		return false;

	return apply_filters( 'wpcasa_post_image_overlay', $output );
}

/**
 * Filter: wpcasa_do_link_pages_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_link_pages_args', 'wpsight_do_link_pages_args_comp' );

function wpsight_do_link_pages_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_link_pages_args', $args );
}

/**
 * Filter: wpcasa_do_link_pages
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_link_pages', 'wpsight_do_link_pages_comp' );

function wpsight_do_link_pages_comp( $output ) {
	return apply_filters( 'wpcasa_do_link_pages', $output );
}

/**
 * Filter: wpcasa_do_post_navigation_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_post_navigation_args', 'wpsight_do_post_navigation_args_comp' );

function wpsight_do_post_navigation_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_post_navigation_args', $args );
}

/**
 * Filter: wpcasa_do_post_navigation
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_post_navigation', 'wpsight_do_post_navigation_comp' );

function wpsight_do_post_navigation_comp( $output ) {
	return apply_filters( 'wpcasa_do_post_navigation', $output );
}

/**
 * Filter: wpcasa_do_attachment_navigation
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_attachment_navigation', 'wpsight_do_attachment_navigation_comp' );

function wpsight_do_attachment_navigation_comp( $output ) {
	return apply_filters( 'wpcasa_do_attachment_navigation', $output );
}

/**
 * Filter: wpcasa_place_property_search
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_place_listing_search', 'wpsight_place_listing_search_comp' );

function wpsight_place_listing_search_comp( $output ) {
	return apply_filters( 'wpcasa_place_property_search', $output );
}

/**
 * Filter: wpcasa_property_search_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_search_labels', 'wpsight_listing_search_labels_comp' );

function wpsight_listing_search_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_property_search_labels', $labels );
}

/**
 * Filter: wpcasa_search_cookie
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_search_cookie', 'wpsight_search_cookie_comp' );

function wpsight_search_cookie_comp( $cookie ) {
	return apply_filters( 'wpcasa_search_cookie', $cookie );
}

/**
 * Filter: wpcasa_do_property_search_form_action
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_search_form_action', 'wpsight_do_listing_search_form_action_comp' );

function wpsight_do_listing_search_form_action_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_search_form_action', $output );
}

/**
 * Filter: wpcasa_property_search_status
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_search_status', 'wpsight_listing_search_status_comp' );

function wpsight_listing_search_status_comp( $output ) {
	return apply_filters( 'wpcasa_property_search_status', $output );
}

/**
 * Filter: wpcasa_do_property_title_actions_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_title_actions_labels', 'wpsight_do_listing_title_actions_labels_comp' );

function wpsight_do_listing_title_actions_labels_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_title_actions_labels', $output );
}

/**
 * Filter: wpcasa_do_property_title_actions_print_link
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_title_actions_print_link', 'wpsight_do_listing_title_actions_print_link_comp' );

function wpsight_do_listing_title_actions_print_link_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_title_actions_print_link', $output );
}

/**
 * Filter: wpcasa_property_agent_contact_link
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_agent_contact_link', 'wpsight_listing_agent_contact_link_comp' );

function wpsight_listing_agent_contact_link_comp( $output ) {
	return apply_filters( 'wpcasa_property_agent_contact_link', $output );
}

/**
 * Filter: wpcasa_do_property_agent_title_actions
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_agent_title_actions', 'wpsight_do_listing_agent_title_actions_comp' );

function wpsight_do_listing_agent_title_actions_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_agent_title_actions', $output );
}

/**
 * Filter: wpcasa_do_property_image_size
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_image_size', 'wpsight_do_listing_image_size_comp' );

function wpsight_do_listing_image_size_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_image_size', $output );
}

/**
 * Filter: wpcasa_do_property_image_align
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_image_align', 'wpsight_do_listing_image_align_comp' );

function wpsight_do_listing_image_align_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_image_align', $output );
}

/**
 * Filter: wpcasa_do_property_navigation_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_navigation_args', 'wpsight_do_listing_navigation_args_comp' );

function wpsight_do_listing_navigation_args_comp( $args ) {
	return apply_filters( 'wpcasa_do_property_navigation_args', $args );
}

/**
 * Filter: wpcasa_do_property_navigation
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_listing_navigation', 'wpsight_do_listing_navigation_comp' );

function wpsight_do_listing_navigation_comp( $output ) {
	return apply_filters( 'wpcasa_do_property_navigation', $output );
}

/**
 * Filter: wpcasa_place_property_title_order
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_place_listing_title_order', 'wpsight_place_listing_title_order_comp' );

function wpsight_place_listing_title_order_comp( $output ) {
	return apply_filters( 'wpcasa_place_property_title_order', $output );
}

/**
 * Filter: wpcasa_property_archive_title_order_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_title_order_args', 'wpsight_listing_title_order_args_comp' );

function wpsight_listing_title_order_args_comp( $args ) {
	return apply_filters( 'wpcasa_property_archive_title_order_args', $args );
}

/**
 * Filter: wpcasa_place_property_search_map
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_place_listing_search_map', 'wpsight_place_listing_search_map_comp' );

function wpsight_place_listing_search_map_comp( $output ) {
	return apply_filters( 'wpcasa_place_property_search_map', $output );
}

/**
 * Filter: wpcasa_properties_map_nr
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listings_map_nr', 'wpsight_listings_map_nr_comp' );

function wpsight_listings_map_nr_comp( $nr ) {
	return apply_filters( 'wpcasa_properties_map_nr', $nr );
}

/**
 * Filter: wpcasa_map_search_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_map_search_query_args', 'wpsight_map_search_query_args_comp' );

function wpsight_map_search_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_map_search_query_args', $args );
}

/**
 * Filter: wpcasa_do_print_logo
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_do_print_logo', 'wpsight_do_print_logo_comp' );

function wpsight_do_print_logo_comp( $output ) {
	return apply_filters( 'wpcasa_do_print_logo', $output );
}

/**
 * Filter: wpcasa_layout
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_layout', 'wpsight_layout_comp' );

function wpsight_layout_comp( $output ) {
	return apply_filters( 'wpcasa_layout', $output );
}

/**
 * Filter: wpcasa_content_width
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_content_width', 'wpsight_content_width_comp' );

function wpsight_content_width_comp( $output ) {
	return apply_filters( 'wpcasa_content_width', $output );
}

/**
 * Filter: wpcasa_post_formats
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_formats', 'wpsight_post_formats_comp' );

function wpsight_post_formats_comp( $formats ) {
	return apply_filters( 'wpcasa_post_formats', $formats );
}

/**
 * Filter: wpcasa_image_sizes
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_image_sizes', 'wpsight_image_sizes_comp' );

function wpsight_image_sizes_comp( $sizes ) {
	return apply_filters( 'wpcasa_image_sizes', $sizes );
}

/**
 * Filter: wpcasa_more_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_more_text', 'wpsight_more_text_comp' );

function wpsight_more_text_comp( $output ) {
	return apply_filters( 'wpcasa_more_text', $output );
}

/**
 * Filter: wpcasa_excerpt_more
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_excerpt_more', 'wpsight_excerpt_more_comp' );

function wpsight_excerpt_more_comp( $output ) {
	return apply_filters( 'wpcasa_excerpt_more', $output );
}

/**
 * Filter: wpcasa_spans
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_spans', 'wpsight_spans_comp' );

function wpsight_spans_comp( $output ) {
	return apply_filters( 'wpcasa_spans', $output );
}

/**
 * Filter: wpcasa_archive_layouts
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_archive_layouts', 'wpsight_archive_layouts_comp' );

function wpsight_archive_layouts_comp( $layouts ) {
	return apply_filters( 'wpcasa_archive_layouts', $layouts );
}

/**
 * Filter: wpcasa_layout_images
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_layout_images', 'wpsight_layout_images_comp' );

function wpsight_layout_images_comp( $images ) {
	return apply_filters( 'wpcasa_layout_images', $images );
}

/**
 * Filter: wpcasa_social_icons
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_social_icons', 'wpsight_social_icons_comp' );

function wpsight_social_icons_comp( $icons ) {
	return apply_filters( 'wpcasa_social_icons', $icons );
}

/**
 * Filter: wpcasa_post_format_icons
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_format_icons', 'wpsight_post_format_icons_comp' );

function wpsight_post_format_icons_comp( $icons ) {
	return apply_filters( 'wpcasa_post_format_icons', $icons );
}

/**
 * Filter: wpcasa_bootstrap_icons
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_bootstrap_icons', 'wpsight_bootstrap_icons_comp' );

function wpsight_bootstrap_icons_comp( $icons ) {
	return apply_filters( 'wpcasa_bootstrap_icons', $icons );
}

/**
 * Filter: wpcasa_post_spaces
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_spaces', 'wpsight_post_spaces_comp' );

function wpsight_post_spaces_comp( $spaces ) {
	return apply_filters( 'wpcasa_post_spaces', $spaces );
}

/**
 * Filter: wpcasa_pagination_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_pagination_args', 'wpsight_pagination_args_comp' );

function wpsight_pagination_args_comp( $args ) {
	return apply_filters( 'wpcasa_pagination_args', $args );
}

/**
 * Filter: wpcasa_pagination
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_pagination', 'wpsight_pagination_comp' );

function wpsight_pagination_comp( $output ) {
	return apply_filters( 'wpcasa_pagination', $output );
}

/**
 * Filter: wpcasa_password_form
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_password_form', 'wpsight_password_form_comp' );

function wpsight_password_form_comp( $output ) {
	return apply_filters( 'wpcasa_password_form', $output );
}

/**
 * Filter: wpcasa_empty_post_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_empty_post_title', 'wpsight_empty_post_title_comp' );

function wpsight_empty_post_title_comp( $output ) {
	return apply_filters( 'wpcasa_empty_post_title', $output );
}

/**
 * Filter: wpcasa_search_post_types
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_search_post_types', 'wpsight_search_post_types_comp' );

function wpsight_search_post_types_comp( $types ) {
	return apply_filters( 'wpcasa_search_post_types', $types );
}

/**
 * Filter: wpcasa_menus
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_menus', 'wpsight_menus_comp' );

function wpsight_menus_comp( $menus ) {
	return apply_filters( 'wpcasa_menus', $menus );
}

/**
 * Filter: wpcasa_post_type_labels_property
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_type_labels_listing', 'wpsight_post_type_labels_listing_comp' );

function wpsight_post_type_labels_listing_comp( $labels ) {
	return apply_filters( 'wpcasa_post_type_labels_property', $labels );
}

/**
 * Filter: wpcasa_rewrite_properties_slug
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_rewrite_listings_slug', 'wpsight_rewrite_listings_slug_comp' );

function wpsight_rewrite_listings_slug_comp( $slug ) {
	$slug = apply_filters( 'wpsight_rewrite_properties_slug', $slug );
	return apply_filters( 'wpcasa_rewrite_properties_slug', $slug );
}

/**
 * Filter: wpcasa_post_type_args_property
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_type_args_listing', 'wpsight_post_type_args_listing_comp' );

function wpsight_post_type_args_listing_comp( $args ) {
	return apply_filters( 'wpcasa_post_type_args_property', $args );
}

/**
 * Filter: wpcasa_search_form_details
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_search_form_details', 'wpsight_search_form_details_comp' );

function wpsight_search_form_details_comp( $details ) {
	return apply_filters( 'wpcasa_search_form_details', $details );
}

/**
 * Filter: wpcasa_standard_details
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_standard_details', 'wpsight_standard_details_comp' );

function wpsight_standard_details_comp( $details ) {
	return apply_filters( 'wpcasa_standard_details', $details );
}

/**
 * Filter: wpcasa_get_property_details_nr
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_get_listing_details_nr', 'wpsight_get_listing_details_nr_comp' );

function wpsight_get_listing_details_nr_comp( $nr ) {
	return apply_filters( 'wpcasa_get_property_details_nr', $nr );
}

/**
 * Filter: wpcasa_property_details
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_details', 'wpsight_listing_details_comp' );

function wpsight_listing_details_comp( $details ) {
	return apply_filters( 'wpcasa_property_details', $details );
}

/**
 * Filter: wpcasa_property_id
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_id', 'wpsight_listing_id_comp' );

function wpsight_listing_id_comp( $output ) {
	return apply_filters( 'wpcasa_property_id', $output );
}

/**
 * Filter: wpcasa_get_price_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_get_price_labels', 'wpsight_get_price_labels_comp' );

function wpsight_get_price_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_get_price_labels', $labels );
}

/**
 * Filter: wpcasa_property_price
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_price', 'wpsight_listing_price_comp' );

function wpsight_listing_price_comp( $output ) {
	return apply_filters( 'wpcasa_property_price', $output );
}

/**
 * Filter: wpcasa_rental_periods
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_rental_periods', 'wpsight_rental_periods_comp' );

function wpsight_rental_periods_comp( $periods ) {
	return apply_filters( 'wpcasa_rental_periods', $periods );
}

/**
 * Filter: wpcasa_property_statuses
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_statuses', 'wpsight_listing_statuses_comp' );

function wpsight_listing_statuses_comp( $statuses ) {
	return apply_filters( 'wpcasa_property_statuses', $statuses );
}

/**
 * Filter: wpcasa_measurement_units
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_measurement_units', 'wpsight_measurement_units_comp' );

function wpsight_measurement_units_comp( $units ) {
	return apply_filters( 'wpcasa_measurement_units', $units );
}

/**
 * Filter: wpcasa_currencies
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_currencies', 'wpsight_currencies_comp' );

function wpsight_currencies_comp( $currencies ) {
	return apply_filters( 'wpcasa_currencies', $currencies );
}

/**
 * Filter: wpcasa_currency
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_currency', 'wpsight_currency_comp' );

function wpsight_currency_comp( $output ) {
	return apply_filters( 'wpcasa_currency', $output );
}

/**
 * Filter: wpcasa_property_spaces
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_spaces', 'wpsight_listing_spaces_comp' );

function wpsight_listing_spaces_comp( $spaces ) {
	return apply_filters( 'wpcasa_property_spaces', $spaces );
}

/**
 * Filter: wpcasa_feed_post_types
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_feed_post_types', 'wpsight_feed_post_types_comp' );

function wpsight_feed_post_types_comp( $types ) {
	return apply_filters( 'wpcasa_feed_post_types', $types );
}

/**
 * Filter: wpcasa_author_slug
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_author_slug', 'wpsight_author_slug_comp' );

function wpsight_author_slug_comp( $slug ) {
	return apply_filters( 'wpcasa_author_slug', $slug );
}

/**
 * Filter: wpcasa_profile_contact_fields
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_profile_contact_fields', 'wpsight_profile_contact_fields_comp' );

function wpsight_profile_contact_fields_comp( $fields ) {
	return apply_filters( 'wpcasa_profile_contact_fields', $fields );
}

/**
 * Filter: wpcasa_profile_contact_info
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_profile_contact_info', 'wpsight_profile_contact_info_comp' );

function wpsight_profile_contact_info_comp( $output ) {
	return apply_filters( 'wpcasa_profile_contact_info', $output );
}

/**
 * Filter: wpcasa_property_loop_title_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_loop_title_labels', 'wpsight_listing_loop_title_labels_comp' );

function wpsight_listing_loop_title_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_property_loop_title_labels', $labels );
}

/**
 * Filter: wpcasa_property_loop_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_loop_title', 'wpsight_listing_loop_title_comp' );

function wpsight_listing_loop_title_comp( $output ) {
	return apply_filters( 'wpcasa_property_loop_title', $output );
}

/**
 * Filter: wpcasa_exclude_sold_rented
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_exclude_sold_rented', 'wpsight_exclude_sold_rented_comp' );

function wpsight_exclude_sold_rented_comp( $output ) {
	return apply_filters( 'wpcasa_exclude_sold_rented', $output );
}

/**
 * Filter: wpcasa_property_search_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_search_args', 'wpsight_listing_search_args_comp' );

function wpsight_listing_search_args_comp( $args ) {
	return apply_filters( 'wpcasa_property_search_args', $args );
}

/**
 * Filter: wpcasa_property_contact_fields
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_contact_fields', 'wpsight_contact_fields_comp' );

function wpsight_contact_fields_comp( $fields ) {
	return apply_filters( 'wpcasa_property_contact_fields', $fields );
}

/**
 * Filter: wpcasa_property_contact_labels
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_contact_labels', 'wpsight_contact_labels_comp' );

function wpsight_contact_labels_comp( $labels ) {
	return apply_filters( 'wpcasa_property_contact_labels', $labels );
}

/**
 * Filter: wpcasa_taxonomy_locations_name
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_locations_name', 'wpsight_taxonomy_locations_name_comp' );

function wpsight_taxonomy_locations_name_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_locations_name', $output );
}

/**
 * Filter: wpcasa_taxonomy_locations_singular
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_locations_singular', 'wpsight_taxonomy_locations_singular_comp' );

function wpsight_taxonomy_locations_singular_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_locations_singular', $output );
}

/**
 * Filter: wpcasa_rewrite_loctions_slug
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_rewrite_loctions_slug', 'wpsight_rewrite_loctions_slug_comp' );

function wpsight_rewrite_loctions_slug_comp( $output ) {
	return apply_filters( 'wpcasa_rewrite_loctions_slug', $output );
}

/**
 * Filter: wpcasa_taxonomy_locations_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_locations_args', 'wpsight_taxonomy_locations_args_comp' );

function wpsight_taxonomy_locations_args_comp( $args ) {
	return apply_filters( 'wpcasa_taxonomy_locations_args', $args );
}

/**
 * Filter: wpcasa_taxonomy_types_name
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_types_name', 'wpsight_taxonomy_types_name_comp' );

function wpsight_taxonomy_types_name_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_types_name', $output );
}

/**
 * Filter: wpcasa_taxonomy_types_singular
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_types_singular', 'wpsight_taxonomy_types_singular_comp' );

function wpsight_taxonomy_types_singular_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_types_singular', $output );
}

/**
 * Filter: wpcasa_rewrite_types_slug
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_rewrite_types_slug', 'wpsight_rewrite_types_slug_comp' );

function wpsight_rewrite_types_slug_comp( $output ) {
	return apply_filters( 'wpcasa_rewrite_types_slug', $output );
}

/**
 * Filter: wpcasa_taxonomy_types_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_types_args', 'wpsight_taxonomy_types_args_comp' );

function wpsight_taxonomy_types_args_comp( $args ) {
	return apply_filters( 'wpcasa_taxonomy_types_args', $args );
}

/**
 * Filter: wpcasa_taxonomy_features_name
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_features_name', 'wpsight_taxonomy_features_name_comp' );

function wpsight_taxonomy_features_name_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_features_name', $output );
}

/**
 * Filter: wpcasa_taxonomy_features_singular
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_features_singular', 'wpsight_taxonomy_features_singular_comp' );

function wpsight_taxonomy_features_singular_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_features_singular', $output );
}

/**
 * Filter: wpcasa_rewrite_features_slug
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_rewrite_features_slug', 'wpsight_rewrite_features_slug_comp' );

function wpsight_rewrite_features_slug_comp( $output ) {
	return apply_filters( 'wpcasa_rewrite_features_slug', $output );
}

/**
 * Filter: wpcasa_taxonomy_features_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_features_args', 'wpsight_taxonomy_features_args_comp' );

function wpsight_taxonomy_features_args_comp( $args ) {
	return apply_filters( 'wpcasa_taxonomy_features_args', $args );
}

/**
 * Filter: wpcasa_taxonomy_categories_name
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_categories_name', 'wpsight_taxonomy_categories_name_comp' );

function wpsight_taxonomy_categories_name_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_categories_name', $output );
}

/**
 * Filter: wpcasa_taxonomy_categories_singular
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_categories_singular', 'wpsight_taxonomy_categories_singular_comp' );

function wpsight_taxonomy_categories_singular_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_categories_singular', $output );
}

/**
 * Filter: wpcasa_rewrite_categories_slug
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_rewrite_categories_slug', 'wpsight_rewrite_categories_slug_comp' );

function wpsight_rewrite_categories_slug_comp( $output ) {
	return apply_filters( 'wpcasa_rewrite_categories_slug', $output );
}

/**
 * Filter: wpcasa_taxonomy_categories_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_categories_args', 'wpsight_taxonomy_categories_args_comp' );

function wpsight_taxonomy_categories_args_comp( $args ) {
	return apply_filters( 'wpcasa_taxonomy_categories_args', $args );
}

/**
 * Filter: wpcasa_year_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_year_shortcode', 'wpsight_year_shortcode_comp', 10, 2 );

function wpsight_year_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_year_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_site_link_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_site_link_shortcode', 'wpsight_site_link_shortcode_comp', 10, 2 );

function wpsight_site_link_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_site_link_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_wordpress_link_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_wordpress_link_shortcode', 'wpsight_wordpress_link_shortcode_comp', 10, 2 );

function wpsight_wordpress_link_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_wordpress_link_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_loginout_link_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_loginout_link_shortcode', 'wpsight_loginout_link_shortcode_comp', 10, 2 );

function wpsight_loginout_link_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_loginout_link_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_alert_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_alert_shortcode', 'wpsight_alert_shortcode_comp', 10, 2 );

function wpsight_alert_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_alert_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_date_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_date_shortcode', 'wpsight_post_date_shortcode_comp', 10, 2 );

function wpsight_post_date_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_date_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_categories_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_categories_shortcode', 'wpsight_post_categories_shortcode_comp', 10, 2 );

function wpsight_post_categories_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_categories_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_author_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_author_shortcode', 'wpsight_post_author_shortcode_comp', 10, 2 );

function wpsight_post_author_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_author_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_author_link_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_author_link_shortcode', 'wpsight_post_author_link_shortcode_comp', 10, 2 );

function wpsight_post_author_link_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_author_link_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_author_posts_link_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_author_posts_link_shortcode', 'wpsight_post_author_posts_link_shortcode_comp', 10, 2 );

function wpsight_post_author_posts_link_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_author_posts_link_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_comments_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_comments_shortcode', 'wpsight_post_comments_shortcode_comp', 10, 2 );

function wpsight_post_comments_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_comments_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_tags_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_tags_shortcode', 'wpsight_post_tags_shortcode_comp', 10, 2 );

function wpsight_post_tags_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_tags_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_terms_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_terms_shortcode', 'wpsight_post_terms_shortcode_comp', 10, 2 );

function wpsight_post_terms_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_terms_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_edit_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_edit_shortcode', 'wpsight_post_edit_shortcode_comp', 10, 2 );

function wpsight_post_edit_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_edit_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_parent_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_parent_shortcode', 'wpsight_post_parent_shortcode_comp', 10, 2 );

function wpsight_post_parent_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_parent_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_gallery_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_gallery_args', 'wpsight_post_gallery_args_comp' );

function wpsight_post_gallery_args_comp( $args ) {
	return apply_filters( 'wpcasa_post_gallery_args', $args );
}

/**
 * Filter: wpcasa_post_gallery_lightbox_size
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_gallery_lightbox_size', 'wpsight_post_gallery_lightbox_size_comp' );

function wpsight_post_gallery_lightbox_size_comp( $output ) {
	return apply_filters( 'wpcasa_post_gallery_lightbox_size', $output );
}

/**
 * Filter: wpcasa_post_gallery_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_gallery_shortcode', 'wpsight_post_gallery_shortcode_comp', 10, 2 );

function wpsight_post_gallery_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_gallery_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_post_slider_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_slider_args', 'wpsight_post_slider_args_comp' );

function wpsight_post_slider_args_comp( $args ) {
	return apply_filters( 'wpcasa_post_slider_args', $args );
}

/**
 * Filter: wpcasa_post_slider_options_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_slider_options_args', 'wpsight_post_slider_options_args_comp' );

function wpsight_post_slider_options_args_comp( $args ) {
	return apply_filters( 'wpcasa_post_slider_options_args', $args );
}

/**
 * Filter: wpcasa_post_slider_lightbox_size
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_slider_lightbox_size', 'wpsight_post_slider_lightbox_size_comp' );

function wpsight_post_slider_lightbox_size_comp( $args ) {
	return apply_filters( 'wpcasa_post_slider_lightbox_size', $args );
}

/**
 * Filter: wpcasa_post_slider_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_post_slider_shortcode', 'wpsight_post_slider_shortcode_comp', 10, 2 );

function wpsight_post_slider_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_post_slider_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_id_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_id_shortcode', 'wpsight_listing_id_shortcode_comp', 10, 2 );

function wpsight_listing_id_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_id_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_title_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_title_shortcode', 'wpsight_listing_title_shortcode_comp', 10, 2 );

function wpsight_listing_title_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_title_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_image_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_image_shortcode', 'wpsight_listing_image_shortcode_comp', 10, 2 );

function wpsight_listing_image_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_image_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_price_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_price_shortcode', 'wpsight_listing_price_shortcode_comp', 10, 2 );

function wpsight_listing_price_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_price_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_details_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_details_shortcode', 'wpsight_listing_details_shortcode_comp', 10, 2 );

function wpsight_listing_details_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_details_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_details_short_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_details_short_shortcode', 'wpsight_listing_details_short_shortcode_comp', 10, 2 );

function wpsight_listing_details_short_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_details_short_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_url_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_url_shortcode', 'wpsight_listing_url_shortcode_comp', 10, 2 );

function wpsight_listing_url_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_url_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_qr_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_qr_shortcode', 'wpsight_listing_qr_shortcode_comp', 10, 2 );

function wpsight_listing_qr_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_qr_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_terms_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_terms_shortcode', 'wpsight_listing_terms_shortcode_comp', 10, 2 );

function wpsight_listing_terms_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_terms_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_property_map_shortcode
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_map_shortcode', 'wpsight_listing_map_shortcode_comp', 10, 2 );

function wpsight_listing_map_shortcode_comp( $args, $atts = false ) {
	return apply_filters( 'wpcasa_property_map_shortcode', $args, $atts );
}

/**
 * Filter: wpcasa_widget_latest_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_latest_query_args', 'wpsight_widget_latest_query_args_comp' );

function wpsight_widget_latest_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_widget_latest_query_args', $args );
}

/**
 * Filter: wpcasa_widget_latest_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_latest_title', 'wpsight_widget_latest_title_comp' );

function wpsight_widget_latest_title_comp( $output ) {
	return apply_filters( 'wpcasa_widget_latest_title', $output );
}

/**
 * Filter: wpcasa_widget_properties_latest_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listings_latest_query_args', 'wpsight_widget_listings_latest_query_args_comp' );

function wpsight_widget_listings_latest_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_widget_properties_latest_query_args', $args );
}

/**
 * Filter: wpcasa_widget_properties_latest_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listings_latest_title', 'wpsight_widget_listings_latest_title_comp' );

function wpsight_widget_listings_latest_title_comp( $output ) {
	return apply_filters( 'wpcasa_widget_properties_latest_title', $output );
}

/**
 * Filter: wpcasa_widget_slider_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_slider_query_args', 'wpsight_widget_slider_query_args_comp' );

function wpsight_widget_slider_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_widget_slider_query_args', $args );
}

/**
 * Filter: wpcasa_widget_slider_image_size
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_slider_image_size', 'wpsight_widget_slider_image_size_comp' );

function wpsight_widget_slider_image_size_comp( $output ) {
	return apply_filters( 'wpcasa_widget_slider_image_size', $output );
}

/**
 * Filter: wpcasa_widget_slider_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_slider_title', 'wpsight_widget_slider_title_comp' );

function wpsight_widget_slider_title_comp( $output ) {
	return apply_filters( 'wpcasa_widget_slider_title', $output );
}

/**
 * Filter: wpcasa_widget_slider_options_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_slider_options_args', 'wpsight_widget_slider_options_args_comp' );

function wpsight_widget_slider_options_args_comp( $args ) {
	return apply_filters( 'wpcasa_widget_slider_options_args', $args );
}

/**
 * Filter: wpcasa_widget_property_description
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_description', 'wpsight_widget_listing_description_comp' );

function wpsight_widget_listing_description_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_description', $output );
}

/**
 * Filter: wpcasa_property_details_id
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_details_id', 'wpsight_listing_details_id_comp' );

function wpsight_listing_details_id_comp( $output ) {
	return apply_filters( 'wpcasa_property_details_id', $output );
}

/**
 * Filter: wpcasa_widget_property_details
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_details', 'wpsight_widget_listing_details_comp' );

function wpsight_widget_listing_details_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_details', $output );
}

/**
 * Filter: wpcasa_widget_property_features
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_features', 'wpsight_widget_listing_features_comp' );

function wpsight_widget_listing_features_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_features', $output );
}

/**
 * Filter: wpcasa_property_gallery_shortcode_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_gallery_shortcode_args', 'wpsight_listing_gallery_shortcode_args_comp' );

function wpsight_listing_gallery_shortcode_args_comp( $args ) {
	return apply_filters( 'wpcasa_property_gallery_shortcode_args', $args );
}

/**
 * Filter: wpcasa_widget_property_gallery
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_gallery', 'wpsight_widget_listing_gallery_comp' );

function wpsight_widget_listing_gallery_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_gallery', $output );
}

/**
 * Filter: wpcasa_widget_property_image
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_image', 'wpsight_widget_listing_image_comp' );

function wpsight_widget_listing_image_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_image', $output );
}

/**
 * Filter: wpcasa_widget_property_location_map_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_location_map_args', 'wpsight_widget_listing_location_map_args_comp' );

function wpsight_widget_listing_location_map_args_comp( $args ) {
	return apply_filters( 'wpcasa_widget_property_location_map_args', $args );
}

/**
 * Filter: wpcasa_widget_property_location
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_location', 'wpsight_widget_listing_location_comp' );

function wpsight_widget_listing_location_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_location', $output );
}

/**
 * Filter: wpcasa_widget_property_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_listing_title', 'wpsight_widget_listing_title_comp' );

function wpsight_widget_listing_title_comp( $output ) {
	return apply_filters( 'wpcasa_widget_property_title', $output );
}

/**
 * Filter: wpcasa_space_image_overlay
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_space_image_overlay', 'wpsight_space_image_overlay_comp' );

function wpsight_space_image_overlay_comp( $output ) {
	return apply_filters( 'wpcasa_space_image_overlay', $output );
}

/**
 * Filter: wpcasa_widget_spaces
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_spaces', 'wpsight_widget_spaces_comp' );

function wpsight_widget_spaces_comp( $output ) {
	return apply_filters( 'wpcasa_widget_spaces', $output );
}

/**
 * Filter: wpcasa_widget_areas
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_areas', 'wpsight_widget_areas_comp' );

function wpsight_widget_areas_comp( $areas ) {
	return apply_filters( 'wpcasa_widget_areas', $areas );
}

/**
 * Filter: wpcasa_widget_widths
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_widget_widths', 'wpsight_widget_widths_comp' );

function wpsight_widget_widths_comp( $widths ) {
	return apply_filters( 'wpcasa_widget_widths', $widths );
}

/**
 * Filter: wpcasa_property_agent_info_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_agent_info_args', 'wpsight_listing_agent_info_args_comp' );

function wpsight_listing_agent_info_args_comp( $args ) {
	return apply_filters( 'wpcasa_property_agent_info_args', $args );
}

/**
 * Filter: wpcasa_property_agent_info
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_agent_info', 'wpsight_listing_agent_info_comp' );

function wpsight_listing_agent_info_comp( $output ) {
	return apply_filters( 'wpcasa_property_agent_info', $output );
}

/**
 * Filter: wpcasa_loop_map_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_loop_map_args', 'wpsight_loop_map_args_comp' );

function wpsight_loop_map_args_comp( $args ) {
	return apply_filters( 'wpcasa_loop_map_args', $args );
}

/**
 * Filter: wpcasa_no_posts_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_no_posts_text', 'wpsight_no_posts_text_comp' );

function wpsight_no_posts_text_comp( $output ) {
	return apply_filters( 'wpcasa_no_posts_text', $output );
}

/**
 * Filter: wpcasa_excerpt_length_subpages
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_excerpt_length_subpages', 'wpsight_excerpt_length_subpages_comp' );

function wpsight_excerpt_length_subpages_comp( $output ) {
	return apply_filters( 'wpcasa_excerpt_length_subpages', $output );
}

/**
 * Filter: wpcasa_no_authors_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_no_authors_text', 'wpsight_no_authors_text_comp' );

function wpsight_no_authors_text_comp( $output ) {
	return apply_filters( 'wpcasa_no_authors_text', $output );
}

/**
 * Filter: wpcasa_blog_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_blog_query_args', 'wpsight_blog_query_args_comp' );

function wpsight_blog_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_blog_query_args', $args );
}

/**
 * Filter: wpcasa_property_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_query_args', 'wpsight_listing_query_args_comp' );

function wpsight_listing_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_property_query_args', $args );
}

/**
 * Filter: wpcasa_no_favorites_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_no_favorites_text', 'wpsight_no_favorites_text_comp' );

function wpsight_no_favorites_text_comp( $output ) {
	return apply_filters( 'wpcasa_no_favorites_text', $output );
}

/**
 * Filter: wpcasa_properties_map_nr
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_listing_map_nr', 'wpsight_listing_map_nr_comp' );

function wpsight_listing_map_nr_comp( $output ) {
	return apply_filters( 'wpcasa_properties_map_nr', $output );
}

/**
 * Filter: wpcasa_map_query_args
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_map_query_args', 'wpsight_map_query_args_comp' );

function wpsight_map_query_args_comp( $args ) {
	return apply_filters( 'wpcasa_map_query_args', $args );
}

/**
 * Filter: wpcasa_no_properties_text
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_no_listings_text', 'wpsight_no_listings_text_comp' );

function wpsight_no_listings_text_comp( $output ) {
	return apply_filters( 'wpcasa_no_properties_text', $output );
}

/**
 * Filter: wpcasa_taxonomy_title
 *
 * @since 1.2
 */
 
add_filter( 'wpsight_taxonomy_title', 'wpsight_taxonomy_title_comp' );

function wpsight_taxonomy_title_comp( $output ) {
	return apply_filters( 'wpcasa_taxonomy_title', $output );
}
