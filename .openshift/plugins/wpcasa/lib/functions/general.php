<?php
/**
 * Return listing post type
 *
 * @since 1.2
 */
 
function wpsight_listing_post_type() {
	return apply_filters( 'wpsight_listing_post_type', 'listing' );
}

/**
 * Set image sizes
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_image_sizes' ) ) {

	function wpsight_image_sizes() {
	
		// Image sizes when layout is set to four columns
	
		if( WPSIGHT_LAYOUT == 'four' ) {
	
			$image_sizes = array(
				'post-thumbnail' => array(
					'size' => array(
						'w' => 215,
						'h' => 120
					),
					'crop'  => true,
					'label' => __( 'small', 'wpsight' )
				),
				'half' => array(
					'size' => array(
						'w' => 470,
						'h' => 265
					),
					'crop'  => true,
					'label' => __( 'half', 'wpsight' )
				),
				'big' => array(
					'size' => array(
						'w' => 725,
						'h' => 410
					),
					'crop'  => true,
					'label' => __( 'big', 'wpsight' )
				),
				'full' => array(
					'size' => array(
						'w' => 980,
						'h' => 450
					),
					'crop'  => true,
					'label' => __( 'full', 'wpsight' )
				)
			);
			
		// Image sizes when layout is set to three columns
		
		} else {
		
			$image_sizes = array(
				'post-thumbnail' => array(
					'size' => array(
						'w' => 300,
						'h' => 167
					),
					'crop'  => true,
					'label' => __( 'small', 'wpsight' )
				),
				'half' => array(
					'size' => array(
						'w' => 470,
						'h' => 265
					),
					'crop'  => true,
					'label' => __( 'half', 'wpsight' )
				),
				'big' => array(
					'size' => array(
						'w' => 640,
						'h' => 360
					),
					'crop'  => true,
					'label' => __( 'big', 'wpsight' )
				),
				'full' => array(
					'size' => array(
						'w' => 980,
						'h' => 450
					),
					'crop'  => true,
					'label' => __( 'full', 'wpsight' )
				)
			);	
		
		}
		
		return apply_filters( 'wpsight_image_sizes', $image_sizes );
	
	}

}

function wpsight_get_image_size( $image_size ) {

	$image_sizes = wpsight_image_sizes();
	
	return $image_sizes[$image_size];

}

/**
 * Get option
 *
 * Return the theme option value.
 * If no value has been saved, it returns $default.
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_get_option' ) ) {

	function wpsight_get_option( $name, $default = false ) {
	
	    $options = get_option( WPSIGHT_DOMAIN );

	    // Get std value if default set TRUE and no options set
	    
	    if( $default === true && ( empty( $options[$name] ) || array_empty( $options[$name] ) ) ) {
	    	require_once( WPSIGHT_ADMIN_DIR . '/options.php' );
	    	$options = wpsight_options();
	    	if( ! empty( $options[$name]['std'] ) )
	    		return $options[$name]['std'];
	    }

	    if ( array_empty( $options ) )
	    	return $default;
	    
	    if ( isset( $options[$name] ) )
	    	return $options[$name];
	    
	    return $default;
	}

}

/**
 * Custom excerpt and more link
 *
 * @since 1.0
 */
 
add_filter( 'excerpt_more', 'wpsight_excerpt_more' );

function wpsight_excerpt_more() {

	$excerpt_more = ' <a class="moretag" href="'. get_permalink( get_the_ID() ) . '">' . apply_filters( 'wpsight_more_text', '&rarr; ' . __( 'Read more', 'wpsight' ) ) . '</a>';

	return apply_filters( 'wpsight_excerpt_more', $excerpt_more );
	
}

/**
 * Echo custom excerpt
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_the_excerpt' ) ) {

	function wpsight_the_excerpt( $post_id = '', $excerpt = false, $length = '' ) {
	
		global $post, $more;
		$more = false;
	
		if( empty( $post_id ) )
		    $post_id = get_the_ID();
		
		// Get post object	
		$post = get_post( $post_id );
		
		/**
		 * If length parameter provided,
		 * create custom excerpt.
		 */
			
		if( ! empty( $length ) ) {
		
			// Clean up excerpt
			$output = trim( strip_tags( strip_shortcodes( $post->post_content ) ) );
			
			// Respect post excerpt
			if( ! empty( $post->post_excerpt ) )
				$output = trim( strip_tags( strip_shortcodes( $post->post_excerpt ) ) );
			
			// Stop if no content
			if( empty( $output ) )
				return;
			
			// Get post word count	
			$count = count( explode( ' ', $output ) );
			
			// Respect more tag
			
			if( strpos( $post->post_content, '<!--more-->' ) ) {
				$output = get_the_content( '', true );
			} else {		
				// Get excerpt depening on $length		
				preg_match( '/^\s*+(?:\S++\s*+){1,' . $length . '}/', $output, $matches );	  
				$output = $matches[0];
			}
			
			// If content longer than excerpt, display more	
			if( $length <= $count )
				$output .= wpsight_excerpt_more();
			
			// Respect the_excerpt filter	
			$output = apply_filters( 'the_excerpt', $output );
			
			// Finally display custom excerpt
			echo $output;
			
			return;
		
		}
		
		/**
		 * Check if only the_excerpt or
		 * the_content with more.
		 */
			
		if( $excerpt == true || ! empty( $post->post_excerpt ) ) {
			the_excerpt();
		} else {	
			the_content( wpsight_excerpt_more() );	
		}
	
	}

}

/**
 * Map wpSight layouts with
 * Bootstrap classes
 *
 * @since 1.0
 */
 
// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_spans' ) ) {

	function wpsight_spans() {
	
		/**
		 * Switch layouts and map
		 * Bootstrap span classes
		 */
	
		if( WPSIGHT_LAYOUT == 'four' ) {
	
			$spans = array(
				'small' => 'span3',
				'half' 	=> 'span6',
				'big' 	=> 'span9',
				'full' 	=> 'span12'
			);
		
		} else {
		
			$spans = array(
				'small' => 'span4',
				'half' 	=> 'span6',
				'big' 	=> 'span8',
				'full' 	=> 'span12'
			);
		
		}
		
		return apply_filters( 'wpsight_spans', $spans );
	
	}

}

/**
 * Return specific layout
 *
 * @since 1.0
 */
 
function wpsight_get_span( $span ) {

	if( empty( $span ) )
		return;

	$spans = wpsight_spans();
	
	return $spans[$span];

}

/**
 * Create post class depending
 * on layout and active sidebars
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_archive_post_class' ) ) {

	function wpsight_archive_post_class( $counter, $parent_id = '' ) {
	
		if( is_home() ) {
			$archive = 'home';
		} elseif( is_category() || is_page_template( 'page-tpl-blog.php' ) ) {
			$archive = 'category';
		} elseif( is_tag() ) {
			$archive = 'tag';
		} elseif( is_author() ) {
			$archive = 'author';
		} elseif( is_date() ) {
			$archive = 'date';
		} elseif( is_search() ) {
			$archive = 'search';
		} else {
			$archive = 'category';
		}
		
		$archive_layout = wpsight_get_archive_layout( $archive );
	
		$post_class = $archive_layout;
		
		if( WPSIGHT_LAYOUT == 'four' ) {
		
			if( is_active_sidebar( 'sidebar' ) || is_active_sidebar( 'sidebar-archive' ) ) {
			
				// Respect full width layout on blog template
			
				if( is_singular() && get_post_meta( $parent_id, '_layout', true ) == 'full-width' ) {
				
					// Correct column width depending on layout
			    	if( $archive_layout == 'span9' )
			    		$archive_layout = 'span12';
			    		
			    	if( $archive_layout == 'span3' ) {
			    		if( $counter == 1 || $counter%4 + 1 == 2 ) {
			    			$post_class = $post_class . ' clear';
			    		}
			    	} elseif( $archive_layout == 'span6' ) {
			    		if( $counter == 1 || $counter%2 != 0 ) {
							$post_class = $post_class . ' clear';
						}
			    	} elseif( $archive_layout == 'span12' ) {
			    		$post_class = 'clearfix';
			    	}
				
				} else {
				
					// Correct column width depending on layout
					if( $archive_layout == 'span6' || $archive_layout == 'span12' )
					    $archive_layout = 'span9';
					
					if( $archive_layout == 'span3' ) {
						$n = get_post_meta( $parent_id, '_layout', true ) == 'full-width' ? 4 : 3;
						if( $counter == 1 || $counter%$n + 1 == 2 ) {
						    $post_class = $post_class . ' clear';
						}				
					} elseif( $archive_layout == 'span9' ) {
					    $post_class = 'span9 clear';
					}
				
				}
				
			} else {
			
			    // Correct column width depending on layout
			    if( $archive_layout == 'span9' )
			    	$archive_layout = 'span12';
			    	
			    if( $archive_layout == 'span3' ) {
			    	if( $counter == 1 || $counter%4 + 1 == 2 ) {
			    		$post_class = $post_class . ' clear';
			    	}
			    } elseif( $archive_layout == 'span6' ) {
			    	if( $counter == 1 || $counter%2 != 0 ) {
						$post_class = $post_class . ' clear';
					}
			    } elseif( $archive_layout == 'span12' ) {
			    	$post_class = 'span12';
			    }
			
			}
		
		} else {
		
			if( is_active_sidebar( 'sidebar' ) || is_active_sidebar( 'sidebar-archive' ) ) {
			
				// Respect full width layout on blog template
			
				if( is_singular() && get_post_meta( $parent_id, '_layout', true ) == 'full-width' ) {
				
					// Correct column width depending on layout
			    	if( $archive_layout == 'span9' )
			    		$archive_layout = 'span12';
			    		
			    	if( $archive_layout == 'span3' ) {
			    		if( $counter == 1 || $counter%4 + 1 == 2 ) {
			    			$post_class = $post_class . ' clear';
			    		}
			    	} elseif( $archive_layout == 'span6' ) {
			    		if( $counter == 1 || $counter%2 != 0 ) {
							$post_class = $post_class . ' clear';
						}
			    	} elseif( $archive_layout == 'span12' ) {
			    		$post_class = 'clearfix';
			    	}
				
				} else {   
				
					// Correct column width depending on layout
					if( $archive_layout == 'span6' || $archive_layout == 'span12' )
					    $archive_layout = 'span8';
					
					if( $archive_layout == 'span4' ) {
						if( $counter == 1 || $counter%2 != 0 ) {
						    $post_class = $post_class . ' clear';
						}				
					} elseif( $archive_layout == 'span8' ) {
					    $post_class = 'span8';
					}
				
				}
			    
			} else {
			
			    // Correct column width depending on layout
			    if( $archive_layout == 'span8' )
			    	$archive_layout = 'span12';
			    	
			    if( $archive_layout == 'span4' ) {
			    	if( $counter == 1 || $counter%3 - 1 == 0 ) {
			    		$post_class = $post_class . ' clear';
			    	}
			    } elseif( $archive_layout == 'span6' ) {
			    	if( $counter == 1 || $counter%2 != 0 ) {
						$post_class = $post_class . ' clear';
					}
			    } elseif( $archive_layout == 'span12' ) {
			    	$post_class = 'span12';
			    }
			
			}
		
		}
		
		return $post_class;
			
	}

}

/**
 * Create archive layouts array
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_archive_layouts' ) ) {

	function wpsight_archive_layouts() {
	
		/**
		 * Map archives with Bootstrap classes
		 */
			
		$archive_layouts = array(	
			'home' 	   => wpsight_get_option( 'archive_layout', true ),
			'category' => wpsight_get_option( 'archive_layout', true ),
			'tag' 	   => wpsight_get_option( 'archive_layout', true ),
			'date' 	   => wpsight_get_option( 'archive_layout', true ),
			'author'   => wpsight_get_option( 'listing_archive_layout', true ),
			'search'   => wpsight_get_option( 'listing_archive_layout', true ),
			'listing'  => wpsight_get_option( 'listing_archive_layout', true )
		);
		
		return apply_filters( 'wpsight_archive_layouts', $archive_layouts );
	
	}

}

function wpsight_get_archive_layout( $archive ) {

	if( empty( $archive ) )
		return;
	
	$archive_layouts = wpsight_archive_layouts();
	
	return $archive_layouts[$archive];

}

/**
 * Create layouts images array
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_layout_images' ) ) {

	function wpsight_layout_images() {
	
		$layout_images = array(
			'show_on_single' 		 => true,
			'size_archive' 	 		 => 'post-thumbnail',
			'align_archive'	 		 => 'left',
			'size_single' 	 		 => 'post-thumbnail',
			'align_single'	 		 => 'left',
			'size_widget' 	 		 => 'post-thumbnail',
			'align_widget'	 		 => 'left',
			'size_archive_listings'  => 'big',
			'align_archive_listings' => 'none',
		);
		
		return apply_filters( 'wpsight_layout_images', $layout_images );
	
	}

}

function wpsight_get_layout_image( $context ) {

	if( empty( $context ) )
		return;

	$layout_images = wpsight_layout_images();
	
	return $layout_images[$context];

}

/**
 * Create social icons array
 *
 * @since 1.0
 */
 
// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_social_icons' ) ) {

	function wpsight_social_icons() {
	
		$social_icons = array(
		
			'rss' => array(
				'id' => 'rss',
				'name' => __( 'RSS', 'wpsight' ),
				'title' => __( 'Subscribe to RSS', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/rss.png'
			),
			'twitter' => array(
				'id' => 'twitter',
				'name'  => __( 'Twitter', 'wpsight' ),
				'title' => __( 'Follow us on Twitter', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/twitter.png'
			),
			'facebook' => array(
				'id' => 'facebook',
				'name'  => __( 'Facebook', 'wpsight' ),
				'title' => __( 'Friend us on Facebook', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/facebook.png'
			),
			'gplus' => array(
				'id' => 'gplus',
				'name'  => __( 'Google+', 'wpsight' ),
				'title' => __( 'Follow us on Google+', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/google+.png'
			),
			'skype' => array(
				'id' => 'skype',
				'name'  => __( 'Skype', 'wpsight' ),
				'title' => __( 'Connect with us on Skype', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/skype.png'
			),
			'vimeo' => array(
				'id' => 'vimeo',
				'name'  => __( 'Vimeo', 'wpsight' ),
				'title' => __( 'See our videos on Vimeo', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/vimeo.png'
			),
			'youtube' => array(
				'id' => 'youtube',
				'name'  => __( 'YouTube', 'wpsight' ),
				'title' => __( 'See our video on YouTube', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/youtube.png'
			),
			'delicious' => array(
				'id' => 'delicious',
				'name'  => __( 'Delicious', 'wpsight' ),
				'title' => __( 'Find us on Delicious', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/delicious.png'
			),
			'digg' => array(
				'id' => 'digg',
				'name'  => __( 'Digg', 'wpsight' ),
				'title' => __( 'Find us on Digg', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/digg.png'
			),
			'technorati' => array(
				'id' => 'technorati',
				'name'  => __( 'Technorati', 'wpsight' ),
				'title' => __( 'Find us on Technorati', 'wpsight' ),
				'icon'  => WPSIGHT_ICONS . '/social/technorati.png'
			),
			'linkedin' => array(
			    'id' 	=> 'linkedin',
			    'name'  => __( 'Linkedin', 'wpsight' ),
			    'title' => __( 'Find us on Linkedin', 'wpsight' ),
			    'icon'  => WPSIGHT_ICONS . '/social/linkedin.png'
			)
		
		);
		
		return apply_filters( 'wpsight_social_icons', $social_icons );
	
	}

}

/**
 * Return specific social icon
 *
 * @since 1.0
 */

function wpsight_get_social_icon( $social_icon ) {

	if( empty( $social_icon ) )
		return;

	$social_icons = wpsight_social_icons();
	
	return $social_icons[$social_icon];

}

/**
 * Return post format icon
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_post_format_icons' ) ) {

	function wpsight_post_format_icons() {
	
		$format_icons = array(
			'post' 	  => '',
			'aside'   => '<i class="icon-file"></i>',
			'chat' 	  => '<i class="icon-comments"></i>',
			'gallery' => '<i class="icon-camera-retro"></i>',
			'image'   => '<i class="icon-picture"></i>',
			'link' 	  => '<i class="icon-external-link"></i>',
			'quote'   => '<i class="icon-comment"></i>',
			'status'  => '<i class="icon-pushpin"></i>',
			'video'   => '<i class="icon-facetime-video"></i>',
			'audio'   => '<i class="icon-volume-up"></i>'
		);
		
		return apply_filters( 'wpsight_post_format_icons', $format_icons );
	
	}

}

/**
 * Return specific post format icon
 *
 * @since 1.0
 */

function wpsight_get_post_format_icon( $post_format ) {

	if( empty( $post_format ) )
		return;

	$format_icons = wpsight_post_format_icons();
	
	return $format_icons[$post_format];

}

/**
 * Return Bootstrap icons
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_bootstrap_icons' ) ) {

	function wpsight_bootstrap_icons() {
	
		$bootstrap_icons = array(
		
			'icon-glass',
			'icon-music',
			'icon-search',
			'icon-envelope',
			'icon-heart',
			'icon-star',
			'icon-star-empty',
			'icon-user',
			'icon-film',
			'icon-th-large',
			'icon-th',
			'icon-th-list',
			'icon-ok',
			'icon-remove',
			'icon-zoom-in',
			'icon-zoom-out',
			'icon-off',
			'icon-signal',
			'icon-cog',
			'icon-trash',
			'icon-home',
			'icon-file',
			'icon-time',
			'icon-road',
			'icon-download-alt',
			'icon-download',
			'icon-upload',
			'icon-inbox',
			'icon-play-circle',
			'icon-repeat',
			'icon-refresh',
			'icon-list-alt',
			'icon-lock',
			'icon-flag',
			'icon-headphones',
			'icon-volume-off',
			'icon-volume-down',
			'icon-volume-up',
			'icon-qrcode',
			'icon-barcode',
			'icon-tag',
			'icon-tags',
			'icon-book',
			'icon-bookmark',
			'icon-print',
			'icon-camera',
			'icon-font',
			'icon-bold',
			'icon-italic',
			'icon-text-height',
			'icon-text-width',
			'icon-align-left',
			'icon-align-center',
			'icon-align-right',
			'icon-align-justify',
			'icon-list',
			'icon-indent-left',
			'icon-indent-right',
			'icon-facetime-video',
			'icon-picture',
			'icon-pencil',
			'icon-map-marker',
			'icon-adjust',
			'icon-tint',
			'icon-edit',
			'icon-share',
			'icon-check',
			'icon-move',
			'icon-step-backward',
			'icon-fast-backward',
			'icon-backward',
			'icon-play',
			'icon-pause',
			'icon-stop',
			'icon-forward',
			'icon-fast-forward',
			'icon-step-forward',
			'icon-eject',
			'icon-chevron-left',
			'icon-chevron-right',
			'icon-plus-sign',
			'icon-minus-sign',
			'icon-remove-sign',
			'icon-ok-sign',
			'icon-question-sign',
			'icon-info-sign',
			'icon-screenshot',
			'icon-remove-circle',
			'icon-ok-circle',
			'icon-ban-circle',
			'icon-arrow-left',
			'icon-arrow-right',
			'icon-arrow-up',
			'icon-arrow-down',
			'icon-share-alt',
			'icon-resize-full',
			'icon-resize-small',
			'icon-plus',
			'icon-minus',
			'icon-asterisk',
			'icon-exclamation-sign',
			'icon-gift',
			'icon-leaf',
			'icon-fire',
			'icon-eye-open',
			'icon-eye-close',
			'icon-warning-sign',
			'icon-plane',
			'icon-calendar',
			'icon-random',
			'icon-comment',
			'icon-magnet',
			'icon-chevron-up',
			'icon-chevron-down',
			'icon-retweet',
			'icon-shopping-cart',
			'icon-folder-close',
			'icon-folder-open',
			'icon-resize-vertical',
			'icon-resize-horizontal',
			'icon-camera-retro',
			'icon-bar-chart',
			'icon-cogs',
			'icon-external-link',
			'icon-pushpin',
			'icon-facebook-sign',
			'icon-twitter-sign',
			'icon-linkedin-sign',
			'icon-github-sign',
			'icon-key',
			'icon-thumbs-up',
			'icon-thumbs-down',
			'icon-comments',
			'icon-trophy',
			'icon-upload-alt',
			'icon-signin',
			'icon-signout',
			'icon-star-half',
			'icon-heart-empty',
			'icon-lemon'
		
		);
		
		// Order alphabetically
		sort( $bootstrap_icons );
		
		return apply_filters( 'wpsight_bootstrap_icons', $bootstrap_icons );
	
	}

}

/**
 * Return specific Bootstrap icon
 *
 * @since 1.0
 */

function wpsight_get_bootstrap_icon( $bootstrap_icon ) {

	if( empty( $bootstrap_icon ) )
		return;

	$bootstrap_icons = wpsight_bootstrap_icons();
	
	return $bootstrap_icons[$bootstrap_icon];

}

/**
 * Create post spaces for use of 
 * custom content in widgets
 *
 * @since 1.0
 */
 
// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_post_spaces' ) ) {

	function wpsight_post_spaces() {
	
		$spaces = array(
		
	    	'space' => array(
	    		'title'		  => __( 'Spaces', 'wpsight' ),
	    		'label' 	  => __( 'Sidebar Space', 'wpsight' ),
	    		'key'		  => '_space',
	    		'description' => __( 'Add some custom content to this post. Then drag the Post Space widget to the Post Sidebar widget area.', 'wpsight' ),
	    		'type' 	   	  => 'textarea',
	    		'rows' 		  => 5,
	    		'post_type'   => array( 'post', 'page' )
	    	)
		
		);
		
		return apply_filters( 'wpsight_post_spaces', $spaces );
	
	}

}

/**
 * Create pagination for archive pages
 *
 * @since 1.0
 */

// Make function pluggable/overwritable
if ( ! function_exists( 'wpsight_pagination' ) ) {

	function wpsight_pagination( $max_num_pages = '' ) {
	
		if( empty( $max_num_pages ) ) {
			global $wp_query;
			$total = $wp_query->max_num_pages;
		} else {
			$total = $max_num_pages;
		}
	
		// need an unlikely integer
	    $big = 999999999;
	    
	    // Make sure paging works
					
		if ( get_query_var( 'paged' ) ) {
		        $paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
		        $paged = get_query_var( 'page' );
		} else {
		        $paged = 1;
		}
	    
	    $args = array(
	    	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $total,
			'mid_size' => 4,
			'prev_text'    => '&larr; ' . __( 'Previous', 'wpsight' ),
			'next_text'    => __( 'Next', 'wpsight' ) . ' &rarr;',
			'type' => 'list'
		);
		
		$pagination = apply_filters( 'wpsight_pagination_args', paginate_links( $args ) );
		
		if( empty( $pagination ) )
			return;
			
		// Create pagination output
		
		$pagination = '<div class="pagination pagination-numbers">' . "\n";		
		$pagination .= paginate_links( $args );		
		$pagination .= '</div><!-- .pagination -->' . "\n";
		
		// Place active class on li
		
		$pagination = str_replace( '<li><span class=\'page-numbers current\'>', '<li class="active"><a href="#"><span class=\'page-numbers current\'>', $pagination );
		$pagination = str_replace( '</span>', '</span></a>', $pagination );
		
		// Place disabled class on li
		
		$pagination = str_replace( '<li><span class="page-numbers dots">', '<li class="disabled"><a href="#"><span class="page-numbers dots">', $pagination );
		
		echo apply_filters( 'wpsight_pagination', $pagination );
	 
	}

}

/**
 * Create custom search form
 *
 * @since 1.0
 */
 
add_filter( 'get_search_form', 'wpsight_search_form' );

function wpsight_search_form( $form ) {
    
    $form = '
    <form class="searchform form-inline clearfix" method="get" action="' . home_url( '/' ) . '">
    	<input type="text" name="s" class="search-text required" value="' . get_search_query() . '" />
    	<input type="submit" class="' . apply_filters( 'wpsight_button_class_search_default', 'btn submit search-submit' ) . '" value="' . __( 'Ok', 'wpsight' ) . '" />
    	<input type="hidden" name="stype" value="default" />
    </form>';

    return $form;
}

/**
 * Custom password form for protected posts
 *
 * @since 1.0
 */

add_filter( 'the_password_form', 'wpsight_password_form' );

function wpsight_password_form() {

	global $post;
	
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
	$output = '<form action="' . get_option( 'siteurl' ) . '/wp-login.php?action=postpass" method="post" class="form-password form-inline">
	<p>' . __( 'This post is password protected. To view it please enter your password below', 'wpsight' ) . ':</p>
	<label for="' . $label . '">' . __( 'Password', 'wpsight' ) . '<input name="post_password" id="' . $label . '" type="password" size="20" class="password span3" /></label><button type="submit" name="Submit" class="btn">' . esc_attr__( 'Submit', 'wpsight' ) . '</button>
	</form>
	';
	
	return apply_filters( 'wpsight_password_form', $output );
}