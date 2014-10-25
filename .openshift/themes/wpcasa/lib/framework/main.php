<?php

/**
 * Add basic framework features and
 * HTML strucure
 *
 * @package wpSight
 *
 */
 
/**
 * Start localization
 *
 * @since 1.0
 */
 
add_action( 'after_setup_theme', 'wpsight_load_textdomain' );

function wpsight_load_textdomain() {
	load_theme_textdomain( 'wpsight', WPSIGHT_DIR . '/lang' );
}

/**
 * Add theme features
 *
 * @since 1.2
 */

add_action( 'wpsight_setup', 'wpsight_theme_support' );
 
function wpsight_theme_support() {

	// Add custom menus
	add_theme_support( 'menus' );
	
	// Add feed links
	add_theme_support( 'automatic-feed-links' );
	
	// Add post thumbnails
	add_theme_support( 'post-thumbnails' );
	
	// Add post layout meta box
	add_theme_support( 'post-layout' );
	
	// Add post spaces meta box
	add_theme_support( 'post-spaces' );
	
	// Add layout theme options
	add_theme_support( 'options-contact' );
	
	// Add layout theme options
	add_theme_support( 'options-layout' );
	
	// Add social theme options
	add_theme_support( 'options-social' );
	
	// Add PhotoSwipe script
	add_theme_support( 'PhotoSwipe' );
	
	// Add Flexslider script
	add_theme_support( 'FlexSlider' );
	
	// Add prettify script
	add_theme_support( 'prettify' );
	
	// Add Google Maps script
	add_theme_support( 'gmaps' );
	
	// Add post editor style
	add_editor_style( 'style-editor.css' );

}

/**
 * Add theme image sizes
 *
 * @since 1.0
 */
 
add_action( 'wpsight_setup', 'wpsight_add_image_sizes' );
 
function wpsight_add_image_sizes() {

	foreach( wpsight_image_sizes() as $image_size => $v ) {	
		if( $image_size == 'post-thumbnail' ) {		
			set_post_thumbnail_size( $v['size']['w'], $v['size']['h'], $v['crop'] );		
		} else {		
			add_image_size( $image_size, $v['size']['w'], $v['size']['h'], $v['crop'] );		
		}	
	}

}

/**
 * Add layout classes to body class
 *
 * @since 1.0
 */
 
add_filter( 'body_class', 'wpsight_body_class' );

function wpsight_body_class( $classes ) {
	
	// Set boxed layout
	$classes[] = 'boxed';
	
	if( is_singular() )	{
		$layout = get_post_meta( get_the_ID(), '_layout', true );
		$layout_attachments = apply_filters( 'wpsight_attachment_full_width', false );
		if( $layout == 'full-width' || $layout_attachments == true ) {
			$classes[] = 'no-sidebar';
		} elseif( $layout == 'sidebar-left' ) {
			$classes[] = 'sidebar-left';
		}
	}
	
	if( defined( 'WPSIGHT_LAYOUT' ) )
		$classes[] = 'layout-' . WPSIGHT_LAYOUT;
	
	return apply_filters( 'wpsight_body_class', $classes );
}

/**
 * Function to add structural wraps around
 * basic layout elements.
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_layout_wrap' ) ) {

	function wpsight_layout_wrap( $wrap_id = '', $close = '' ) {
	
		if ( empty( $wrap_id ) )
			return;
			
		$layout_wrap = '';
			
		if ( $close != 'close' ) {
		
			// Action hook outsite wrap start
			do_action( 'wpsight_layout_wrap_' . $wrap_id . '_start_outside' );
		
			$layout_wrap .= '<div id="' . $wrap_id . '" class="wrap">' . "\n";		
			$layout_wrap .= "\t" . '<div class="container">' . "\n";
			
			echo apply_filters( 'wpsight_layout_wrap', $layout_wrap, $wrap_id, $close );
			
			// Action hook inside wrap start
			do_action( 'wpsight_layout_wrap_' . $wrap_id . '_start_inside' );
			
		} else {
		
			// Action hook inside wrap end
			do_action( 'wpsight_layout_wrap_' . $wrap_id . '_end_inside' );
		
			$layout_wrap .= "\t" . '</div><!-- .container -->' . "\n";		
			$layout_wrap .= '</div><!-- #' . $wrap_id . ' -->' . "\n\n";
			
			echo apply_filters( 'wpsight_layout_wrap', $layout_wrap, $wrap_id, $close );
			
			// Action hook outside wrap end
			do_action( 'wpsight_layout_wrap_' . $wrap_id . '_end_outside' );
	
		}
	
	}

}

/**
 * Built main top widget area
 * currently only on home page.
 *
 * @since 1.0
 */
 
add_action( 'wpsight_main_before', 'wpsight_do_main_top' );
 
function wpsight_do_main_top() {

	$args = array(
		'only_front' => true
	);
	
	$args = apply_filters( 'wpsight_do_main_top_args', $args );

	// Only on home page?
	if( ! is_front_page() && $args['only_front'] == true )
		return;
	
	// Only if widget area active
	if( ! is_active_sidebar( 'home-top') )
		return;

	// Open layout wrap
	wpsight_layout_wrap( 'main-top-wrap' ); ?>

	<div id="main-top" class="clearfix">
		<?php dynamic_sidebar( 'home-top' ); ?>
	</div><!-- #main-top --><?php
    
    // Close layout wrap
	wpsight_layout_wrap( 'main-top-wrap', 'close' );

}

/**
 * Built main bottom widget area
 * currently only on home page.
 *
 * @since 1.0
 */
 
add_action( 'wpsight_main_after', 'wpsight_do_main_bottom' );
 
function wpsight_do_main_bottom() {

	$args = array(
		'only_front' => true
	);
	
	$args = apply_filters( 'wpsight_do_main_bottom_args', $args );

	// Only on home page?
	if( ! is_front_page() && $args['only_front'] == true )
		return;
	
	// Only if widget area active
	if( ! is_active_sidebar( 'home-bottom' ) )
		return;	

	// Open layout wrap
	wpsight_layout_wrap( 'main-bottom-wrap' ); ?>

	<div id="main-bottom" class="clearfix">
		<?php dynamic_sidebar( 'home-bottom' ); ?>
	</div><!-- #main-bottom --><?php
    
    // Close layout wrap
	wpsight_layout_wrap( 'main-bottom-wrap', 'close' );

}

/**
 * Add theme post formats
 *
 * @since 1.2
 */

add_action( 'wpsight_setup', 'wpsight_post_formats' );
 
function wpsight_post_formats() {

	$post_formats = array(
		'aside',
		'chat',
		'gallery',
		'image',
		'link',
		'quote',
		'status',
		'video',
		'audio'
	);
	
	$post_formats = apply_filters( 'wpsight_post_formats', $post_formats );
	
	add_theme_support( 'post-formats', $post_formats );

}

/**
 * Hook in welcome screen on front page
 * when widget area home is not active
 *
 * @since 1.0
 */
 
add_action( 'wpsight_start_screen', 'wpsight_do_start_screen' );

function wpsight_do_start_screen() {

	// Activate welcome screen
	$welcome = apply_filters( 'wpsight_welcome_screen', true );

	if( $welcome == true ) { ?>
	
		<div id="content" class="span12">
		
			<div id="welcome" class="post">
			
				<h1><?php _e( 'Thank You!', 'wpsight' ); ?></h1>
			
				<p><?php printf( __( 'Thank you very much for using the <strong>%1$s</strong> theme.', 'wpsight' ), WPSIGHT_NAME ); ?></p>
				
				<div class="row">
				
					<div class="span6">
				
						<h2 class="well" style="padding:5px 15px"><?php _e( 'What Next?', 'wpsight' ); ?></h2>	    					
						<ul>	   					    
	   					    <li><?php _e( 'Add some content', 'wpsight' ); ?> &rarr; <?php printf( __( 'Create a new %1$s, %2$s or %3$s',  'wpsight' ), '<a href="' . admin_url() . 'post-new.php">' . __( 'post',  'wpsight' ) . '</a>', '<a href="' . admin_url() . 'post-new.php?post_type=page">' . __( 'page',  'wpsight' ) . '</a>', '<a href="' . admin_url() . 'post-new.php?post_type=' . wpsight_listing_post_type() . '">' . __( 'listing',  'wpsight' ) . '</a>' ); ?></li>	    				    
	   					    <li><?php _e( 'Make your settings in the theme options', 'wpsight' ); ?> &rarr; <a href="<?php echo admin_url(); ?>admin.php?page=<?php echo WPSIGHT_DOMAIN; ?>"><?php _e( 'Theme options',  'wpsight' ); ?></a></li>	   					    
	   					    <li><?php _e( 'Drag widgets to the home page widget area', 'wpsight' ); ?> &rarr; <a href="<?php echo admin_url(); ?>widgets.php"><?php _e( 'Edit widgets',  'wpsight' ); ?></a></li>	   					    
	   					    <li><?php _e( 'Add items to the main menu', 'wpsight' ); ?> &rarr; <a href="<?php echo admin_url(); ?>nav-menus.php"><?php _e( 'Create a custom menu',  'wpsight' ); ?></a></li>	   					
	   					</ul>	   					
	   				</div>
	   				
	   				<div class="span6">	   				
	   					<h2 class="well" style="padding:5px 15px"><?php _e( 'Example Content?', 'wpsight' ); ?></h2>	    		
						<p><?php _e( 'To get started with the theme you may also want to upload some dummy content (also see <a href="http://codex.wordpress.org/Importing_Content#WordPress" target="_blank">codex</a> about importing content)', 'wpsight' ); ?></p>						
						<p><a href="http://wpcasa.com/download/<?php echo apply_filters( 'wpsight_example_xml_name', WPSIGHT_DOMAIN ); ?>.xml" class="btn btn-success btn-mini"><?php _e( 'Download XML', 'wpsight' ); ?></a></p>	   				
	   				</div>
	   			
	   			</div><!-- .row -->
	   			
	   			<h2><?php _e( 'Need Help?', 'wpsight' ); ?></h2>	   			
	   			<p><?php _e( 'If you need any help, please head over to the <a href="http://wpcasa.com/support/" target="_blank">support center</a>.', 'wpsight' ); ?></p>
			
			</div><!-- #welcome -->
		
		</div><!-- #content --><?php
		
	} else {
	
		// When welcome is false show latest posts

		// Set args for home custom query
		$home_query_args = array(
		    'posts_per_page' => get_option( 'posts_per_page' ),
		    'paged' => get_query_var( 'paged' )
		);
		
		$home_query_args = apply_filters( 'wpsight_home_query_args', $home_query_args );
		
		$home_query = new WP_Query( $home_query_args );
		
		if ( $home_query->have_posts() ) {
		
			// Set class of #content div on home depending on active sidebars
    	    $content_class = ( is_home() && ( is_active_sidebar( 'sidebar' ) || is_active_sidebar( 'sidebar-archive' ) ) ) ? wpsight_get_span( 'big' ) : wpsight_get_span( 'full' ); ?>
	    	    
	    	<div id="content" class="<?php echo $content_class; ?>">
									
		    	<div class="row">
		    	
		    		<?php
		    			// Create loop counter
		    			global $counter;
		    			$counter = 0;
		    			
		    			while ( $home_query->have_posts() ) {
		    				
		    				// Increase loop counter
		    				$counter++;
		    			
		    				$home_query->the_post();
		    						
		    		    	/* Include the Post-Format-specific template for the content.
		    				 * If you want to overload this in a child theme then include a file
		    				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		    				 */
		    				get_template_part( 'loop', get_post_format() );
		    			
		    			} // endwhile have_posts()
		    		?>
		    	
		    	</div><!-- .row --><?php		    	
		    
		    	wpsight_pagination( $home_query->max_num_pages ); ?>
		    
		    </div><!-- #content --><?php
		    
		    get_sidebar();
		    
		} else { 
		
			get_template_part( 'loop', 'no' );
		    
		} // endif have_posts()
	
	} // endif $welcome

}