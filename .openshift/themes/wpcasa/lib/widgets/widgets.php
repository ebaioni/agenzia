<?php

/**
 * Register widget areas and
 * require widget files.
 *
 * @package wpSight
 */
 
/**
 * Create widget areas array
 *
 * @since 1.0
 */
 
function wpsight_widget_areas() {

	$wpsight_widget_areas = array(
	
		'sidebar' => array(
			'name' 			=> __( 'General Sidebar', 'wpsight' ),
			'description' 	=> __( 'This is the primary sidebar to display the same widgets on all pages.', 'wpsight' ),
			'id' 			=> 'sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 10
		),
		
		'sidebar-archive' => array(
			'name'			=> __( 'Archive Sidebar', 'wpsight' ),
			'description' 	=> __( 'This is the sidebar on category, tag, author, date and search pages. If empty, archives will be displayed without sidebar.', 'wpsight' ),
			'id' 			=> 'sidebar-archive',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 20
		),
		
		'sidebar-post' => array(
			'name' 			=> __( 'Post Sidebar', 'wpsight' ),
			'description' 	=> __( 'This is the sidebar on single post pages. If empty, posts will be displayed without sidebar.', 'wpsight' ),
			'id' 			=> 'sidebar-post',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 30
		),
		
		'sidebar-page' => array(
			'name' 			=> __( 'Page Sidebar', 'wpsight' ),
			'description' 	=> __( 'This is the sidebar on static pages. If empty, pages will be displayed without sidebar.', 'wpsight' ),
			'id' 			=> 'sidebar-page',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 40
		),
		
		'home-top' => array(
			'name' 			=> __( 'Home Page Top', 'wpsight' ),
			'description' 	=> __( 'Top Content on the home page', 'wpsight' ),
			'id' 			=> 'home-top',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 50
		),
		
		'home' => array(
			'name' 			=> __( 'Home Page Content', 'wpsight' ),
			'description' 	=> __( 'Main Content on the home page', 'wpsight' ),
			'id' 			=> 'home',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 60
		),
		
		'sidebar-home' => array(
			'name' 			=> __( 'Home Page Sidebar', 'wpsight' ),
			'description' 	=> __( 'The sidebar on the home page', 'wpsight' ),
			'id' 			=> 'sidebar-home',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 70
		),
		
		'home-bottom' => array(
			'name' 			=> __( 'Home Page Bottom', 'wpsight' ),
			'description' 	=> __( 'Bottom Content on the home page', 'wpsight' ),
			'id' 			=> 'home-bottom',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 80
		),
		
		'listing' => array(
			'name' 			=> __( 'Listing Single Content', 'wpsight' ),
			'description' 	=> __( 'Main content on single listing pages', 'wpsight' ),
			'id' 			=> 'listing',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h3 class="title">',
			'after_title' 	=> '</h3>',
			'position'		=> 85
		),
		
		'sidebar-listing' => array(
			'name' 			=> __( 'Listing Single Sidebar', 'wpsight' ),
			'description'	=> __( 'Sidebar on single listing pages', 'wpsight' ),
			'id' 			=> 'sidebar-listing',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 86
		),
		
		'sidebar-listing-archive' => array(
			'name' 			=> __( 'Listing Archive Sidebar', 'wpsight' ),
			'description' 	=> __( 'Sidebar on listing archive pages', 'wpsight' ),
			'id' 			=> 'sidebar-listing-archive',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 87
		),
		
		'footer' => array(
			'name' 			=> __( 'Footer', 'wpsight' ),
			'description' 	=> __( 'Footer widget area', 'wpsight' ),
			'id' 			=> 'ffooter',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h4 class="title">',
			'after_title' 	=> '</h4>',
			'position'		=> 90
		)
	
	);
	
	// Sort array by position        
    $wpsight_widget_areas = wpsight_sort_array_by_position( $wpsight_widget_areas );
	
	return apply_filters( 'wpsight_widget_areas', $wpsight_widget_areas );

}

/**
 * Register widget areas
 *
 * @since 1.0
 */
 
add_action( 'wpsight_setup', 'wpsight_register_widget_areas' );

function wpsight_register_widget_areas() {

	foreach( wpsight_widget_areas() as $widget_area ) {
	
		register_sidebar( $widget_area );
	
	}
}

/**
 * Set up widgets array
 *
 * @since 1.2
 */
 
function wpsight_widgets() {

	$widgets = array(
		'slider' 			  => array(
			'wid' => 'wpSight_Slider',
			'tpl' => '/lib/widgets/slider.php',
		),
		'latest' 			  => array(
			'wid' => 'wpSight_Latest',
			'tpl' => '/lib/widgets/latest.php'
		),
		'spaces' 			  => array(
			'wid' => 'wpSight_Spaces',
			'tpl' => '/lib/widgets/spaces.php'
		),
		'post-spaces' 			  => array(
			'wid' => 'wpSight_Post_Spaces',
			'tpl' => '/lib/widgets/post-spaces.php'
		),
		'divider' 			  => array(
			'wid' => 'wpSight_Divider',
			'tpl' => '/lib/widgets/divider.php'
		),
		'calltoaction' 		  => array(
			'wid' => 'wpSight_Call_to_Action',
			'tpl' => '/lib/widgets/calltoaction.php'
		),
		'calltoaction' 		  => array(
			'wid' => 'wpSight_Call_to_Action',
			'tpl' => '/lib/widgets/calltoaction.php'
		),
		'agent' 			  => array(
			'wid' => 'wpSight_Featured_Agent',
			'tpl' => '/lib/widgets/agent.php'
		),
		'listings-slider' 	  => array(
			'wid' => 'wpSight_Listing_Slider',
			'tpl' => '/lib/widgets/listings-slider.php'
		),
		'listings-search' 	  => array(
			'wid' => 'wpSight_Listing_Search',
			'tpl' => '/lib/widgets/listings-search.php'
		),
		'listings-latest' 	  => array(
			'wid' => 'wpSight_Latest_Listings',
			'tpl' => '/lib/widgets/listings-latest.php'
		),
		'listing-title' 	  => array(
			'wid' => 'wpSight_Listing_Title',
			'tpl' => '/lib/widgets/listing-title.php'
		),
		'listing-image' 	  => array(
			'wid' => 'wpSight_Listing_Image',
			'tpl' => '/lib/widgets/listing-image.php'
		),
		'listing-details' 	  => array(
			'wid' => 'wpSight_Listing_Details',
			'tpl' => '/lib/widgets/listing-details.php'
		),
		'listing-features' 	  => array(
			'wid' => 'wpSight_Listing_Features',
			'tpl' => '/lib/widgets/listing-features.php'
		),
		'listing-description' => array(
			'wid' => 'wpSight_Listing_Description',
			'tpl' => '/lib/widgets/listing-description.php'
		),
		'listing-gallery' 	  => array(
			'wid' => 'wpSight_Listing_Gallery',
			'tpl' => '/lib/widgets/listing-gallery.php'
		),
		'listing-contact' 	  => array(
			'wid' => 'wpSight_Listing_Contact',
			'tpl' => '/lib/widgets/listing-contact.php'
		),
		'listing-agent' 		=> array(
			'wid' => 'wpSight_Listing_Agent',
			'tpl' => '/lib/widgets/listing-agent.php'
		),
		'listing-location' 	  => array(
			'wid' => 'wpSight_Listing_Location',
			'tpl' => '/lib/widgets/listing-location.php'
		)
	);
	
	return apply_filters( 'wpsight_widgets', $widgets );

}

// Load template files

foreach( wpsight_widgets() as $k => $v )
	locate_template( $v['tpl'], true, true );

/**
 * Create widths for widget settings.
 *
 * Array keys are bootstrap classes.
 * Array values are labels for widget settings.
 *
 * @since 1.0
 */
 
function wpsight_widget_widths() {

	if( WPSIGHT_LAYOUT == 'four' ) {

		$widget_widths = array(	
			'span12' => '4/4',
			'span9'  => '3/4',
			'span6'  => '2/4',
			'span3'  => '1/4'	
		);
	
	} else {
		
		$widget_widths = array(	
			'span12' => '3/3',
			'span8'  => '2/3',
			'span4'  => '1/3'	
		);
		
	}
	
	return apply_filters( 'wpsight_widget_widths', $widget_widths );

}

/**
 * Activate shortcodes in widgets
 *
 * @since 1.0
 */

add_filter( 'widget_text', 'do_shortcode' );

/**
 * Backward compatibility for wpCasa widgets
 *
 * @since 1.2
 */

if( file_exists( WPSIGHT_LIB_DIR . '/wpcasa/widgets/_deprecated/widgets.php' ) )
	require_once( WPSIGHT_LIB_DIR . '/wpcasa/widgets/_deprecated/widgets.php' );
