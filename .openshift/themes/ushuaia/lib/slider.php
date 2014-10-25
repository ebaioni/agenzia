<?php
/**
 * Add full width slider options
 *
 * @since 1.0
 */

add_filter( 'wpsight_options', 'ushuaia_slider_options' );

function ushuaia_slider_options( $options ) {
		
    // Create options array
    	
    $options_slider = array();
    	
    $options_slider['heading_slider_home'] = array(
    	'name' => __( 'Slider', 'wpsight' ),
    	'id'   => 'heading_slider_home',
    	'type' => 'heading'
    );
    
    $options_slider['slider_home_dsp'] = array(
		'name' => __( 'Activate', 'wpsight' ),
		'desc' => __( 'Please check the box to display the full width home page slider', 'wpcasa-ushuaia' ),
		'id'   => 'slider_home_dsp',
		'std'  => '0',
		'type' => 'checkbox'
	);
	
	$slider_filter_options = array(
		'latest'	  => __( 'Latest listings', 'wpsight' ),
		'latest-sale' => __( 'Latest listings (for sale)', 'wpsight' ),
		'latest-rent' => __( 'Latest listings (for rent)', 'wpsight' )
	);
	
	// Add property categories
	
	$slider_filter_options['categories_disabled'] = '===== ' . __( 'Categories', 'wpsight' ) . ' =====';
	
	$terms_category = get_terms( array( 'property-category' ), array( 'hide_empty' => 0 ) );
	
	foreach( $terms_category as $term )
	    $slider_filter_options[$term->taxonomy . ',' . $term->slug] = $term->name;
	
	// Add property features
	
	$slider_filter_options['features_disabled'] = '===== ' . __( 'Features', 'wpsight' ) . ' =====';
	
	$terms_feature = get_terms( array( 'feature' ), array( 'hide_empty' => 0 ) );
	
	foreach( $terms_feature as $term )
	    $slider_filter_options[$term->taxonomy . ',' . $term->slug] = $term->name;
	
	// Add property locations
	
	$slider_filter_options['locations_disabled'] = '===== ' . __( 'Locations', 'wpsight' ) . ' =====';
	
	$terms_location = get_terms( array( 'location' ), array( 'hide_empty' => 0 ) );
	
	foreach( $terms_location as $term )
	    $slider_filter_options[$term->taxonomy . ',' . $term->slug] = $term->name;
	
	// Add property type
	
	$slider_filter_options['type_disabled'] = '===== ' . __( 'Types', 'wpsight' ) . ' =====';
	
	$terms_type = get_terms( array( 'property-type' ), array( 'hide_empty' => 0 ) );
	
	foreach( $terms_type as $term )
	    $slider_filter_options[$term->taxonomy . ',' . $term->slug] = $term->name;
	    
	// Add custom field 'slider => 1' option
	
	$slider_filter_options['customfield_disabled'] = '===== ' . __( 'Custom', 'wpsight' ) . ' =====';
	
	$slider_filter_options['custom'] = __( 'Custom field', 'wpsight' ) . ' => slider';
    
	$options_slider['slider_home_filter'] = array(
	    'name' 	  => __( 'Filter', 'wpsight' ),
	    'desc' 	  => __( 'Please select the slider content.', 'wpcasa-ushuaia' ),
	    'id' 	  => 'slider_home_filter',
	    'std' 	  => 'latest',
	    'type' 	  => 'select',
	    'options' => $slider_filter_options
	);
	
	$slider_timer_options = array(
		'0' => __( 'off', 'wpsight' )
	);
	
	for( $i = 1; $i <= 10; $i++ )	
		$slider_timer_options[$i] = $i  . ' ' . __( 'seconds', 'wpsight' );
	
	$options_slider['slider_home_timer'] = array(
	    'name' 	  => __( 'Timer', 'wpsight' ),
	    'desc' 	  => __( 'Please select the time between transitions.', 'wpcasa-ushuaia' ),
	    'id' 	  => 'slider_home_timer',
	    'std' 	  => '0',
	    'type' 	  => 'select',
	    'options' => $slider_timer_options
	);
	
	$options_slider['slider_home_prevnext'] = array(
		'name' 	=> __( 'Navigation', 'wpsight' ),
		'desc' 	=> __( 'Please check the box to display next & previous buttons', 'wpcasa-ushuaia' ),
		'id'   	=> 'slider_home_prevnext',
		'std'  	=> '1',
		'type' 	=> 'checkbox'
	);
	
	$options_slider['slider_home_overlay'] = array(
		'name' 	=> __( 'Overlay', 'wpsight' ),
		'desc' 	=> __( 'Please check the box to display the slider overlay', 'wpcasa-ushuaia' ),
		'id'   	=> 'slider_home_overlay',
		'std'  	=> '1',
		'type' 	=> 'checkbox'
	);
	
	$options_slider['slider_home_overlay_align'] = array(
		'name' 	  => __( 'Alignment', 'wpsight' ),
		'desc' 	  => __( 'Please select the default slider overlay alignment. Creating a custom field called <code>slider_overlay_align</code> with <code>left</code> or <code>right</code> you can set a custom alignment for a single property.', 'wpcasa-ushuaia' ),
		'id'   	  => 'slider_home_overlay_align',
		'std'  	  => 'left',
		'type' 	  => 'select',
		'options' => array(
			'left' 	=> __( 'left', 'wpsight' ),
			'right' => __( 'right', 'wpsight' )
		)
	);
	
	$slider_elements = array(
		'details'  => __( 'Listing details', 'wpsight' ),
		'teaser'   => __( 'Listing teaser', 'wpsight' )
	);
	
	$slider_elements_defaults = array(
		'details'  => '1',
		'teaser'   => '1'
	);
	
	$options_slider['slider_home_elements'] = array(
		'name' 	  => __( 'Elements', 'wpsight' ),
		'desc' 	  => __( 'Please select the slider elements to show.', 'wpsight' ),
		'id' 	  => 'slider_home_elements',
		'std' 	  => $slider_elements_defaults,
		'type' 	  => 'multicheck',
		'options' => $slider_elements
	);
	
	$slider_features = array(
		'keynav'   => __( 'Keyboard navigation', 'wpsight' ),
		'mousenav' => __( 'Mouse wheel navigation', 'wpsight' ),
		'random'   => __( 'Random order', 'wpsight' ),
		'unlink'   => __( 'Remove links', 'wpsight' )
	);
	
	$slider_features_defaults = array(
		'keynav'   => '1'
	);
	
	$options_slider['slider_home_features'] = array(
		'name' 	  => __( 'Features', 'wpsight' ),
		'desc' 	  => __( 'Please select additional slider features.', 'wpsight' ),
		'id' 	  => 'slider_home_features',
		'std' 	  => $slider_features_defaults,
		'type' 	  => 'multicheck',
		'options' => $slider_features
	);
	
	$options_slider['slider_home_number'] = array( 
	    'name' 	=> __( 'Number of entries', 'wpsight' ),
	    'desc' 	=> __( 'Please enter the number of properties to show.', 'wpsight' ),
	    'id'   	=> 'slider_home_number',
	    'std'	=> 10,
	    'type' 	=> 'text'
	);
	
	$options_slider['slider_home_length'] = array( 
	    'name' 	=> __( 'Number of words in teaser', 'wpsight' ),
	    'desc' 	=> __( 'Please enter number of words in property teaser.', 'wpsight' ),
	    'id'   	=> 'slider_home_length',
	    'std'	=> 15,
	    'type' 	=> 'text'
	);
    		
    $options_slider = apply_filters( 'ushuaia_slider_options', $options_slider );
    
    $options = array_merge(
		(array) $options,
		(array) $options_slider
	);
	
	return $options;
    
}

/**
 * Display home slider
 *
 * @since 1.0
 */
 
add_action( 'wpsight_main_before', 'ushuaia_slider_home' );

function ushuaia_slider_home() {

	// Check if slider is enabled
	$activate  = wpsight_get_option( 'slider_home_dsp', '0' );

	// Show only on front page and if active
	if( ! is_front_page() || $activate == '0' )
		return;
		
	// Get slider options
	
	$filter	   = wpsight_get_option( 'slider_home_filter', 'latest' );
	$timer	   = wpsight_get_option( 'slider_home_timer', 0 );
	
	$prevnext   = wpsight_get_option( 'slider_home_prevnext' );
	
	$overlay   = wpsight_get_option( 'slider_home_overlay' );
	
	$elements  = wpsight_get_option( 'slider_home_elements' );
	$details   = $elements['details'];
	$teaser    = $elements['teaser'];
	
	$features  = wpsight_get_option( 'slider_home_features' );
	$keynav    = $features['keynav'];
	$mousenav  = $features['mousenav'];
	$random    = $features['random'];
	$unlink    = $features['unlink'];
	
	$number	   = wpsight_get_option( 'slider_home_number', 10 );
	$length	   = wpsight_get_option( 'slider_home_length', 15 );

	// Create query args

	if( $filter != 'custom' ) {
		
		$query_args = array(
			'post_type' => array( wpsight_listing_post_type() ),
			'posts_per_page' => $number
		);
		
		// Add filter to query args if required
		
		if( ! empty( $filter ) && $filter != 'latest' ) {
		
			if( $filter == 'latest-sale' ) {
			
				// Set meta_query
	    		
	    		$meta_query = array(
	    		    array(
	    		    	'key' 	=> '_price_status',
	    		    	'value' => 'sale'
	    		    )
	    		);
	    		
	    		$query_args = array_merge( $query_args, array( 'meta_query' => $meta_query ) );	        		
	    		
			} elseif( $filter == 'latest-rent' ) {
	    		
	    		// Set meta_query
	    		
	    		$meta_query = array(
	    		    array(
	    		    	'key' 	=> '_price_status',
	    		    	'value' => 'rent'
	    		    )
	    		);
	    		
	    		$query_args = array_merge( $query_args, array( 'meta_query' => $meta_query ) );
	    		
			} else {
	
	    		// Get taxonomy and term from filter (comma-separated value)
	    		
	    		$get_taxonomy = explode( ',', $filter );
	    		$taxonomy 	  = $get_taxonomy[0];
	    		$term 		  = $get_taxonomy[1];
	    		
	    		// Set tax_query
	    		
	    		$tax_query = array(
	    		    array(
	    		    	'taxonomy' => $taxonomy,
	    		    	'field' => 'slug',
	    		    	'terms' => array( $term )
	    		    )
	    		);
	    		
	    		$query_args = array_merge( $query_args, array( 'tax_query' => $tax_query ) );
			
			}
			
		}
	
	} else {
	
		// If filter is custom, create meta query (slider => 1)
	
		$query_args = array(
			'post_type' 	 => 'any',
			'posts_per_page' => $number,
			'meta_query'     => array(
	    		array(
	    			'key' 	=> 'slider',
	    			'value' => '1'						
	    		)
	    	)
		);
	        	
	}
	
	// Add random order to query args if required	
	if( $random == true )
		$query_args = array_merge( $query_args, array( 'orderby' => 'random' ) );
	
	// Applay query filter
	$query_args = apply_filters( 'wpsight_home_slider_query_args', $query_args );
	
	// Set slider query        
	$slider = new WP_Query( $query_args );
	
	if ( $slider->have_posts() ) {
	
		// Create loop counter
		$counter = 1;
		
		// Set image size
		$image_size = 'slider';
	
	    // Create widget output ?>
	    
	    <div id="ushuaia-slider-home" class="clearfix"><?php
	    		
			// Convert boolean to strings for Javascript options
			
			$keynav   = ( $keynav 	== '1' ) ? 'true' : 'false';
			$mousenav = ( $mousenav == '1' ) ? 'true' : 'false';
			$random   = ( $random 	== '1' ) ? 'true' : 'false';
			
			// Correct timer and slideshow = true
			$slideshow = ( $timer == 0 ) ? 'false' : 'true';
			$timer = $timer . '000';
			
			$slider_args = array(
			    'animation'			=> '"fade",',
			    'direction' 		=> '"horizontal",',
			    'slideshow'			=> "$slideshow,",
			    'slideshowSpeed' 	=> "$timer,",
			    'animationDuration' => '300,',
			    'directionNav' 		=> 'false,',
			    'controlNav' 		=> 'false,',
			    'keyboardNav' 		=> "$keynav,",
			    'mousewheel' 		=> "$mousenav,",
			    'randomize'			=> "$random,",
			    'animationLoop'		=> 'true,',
			    'pauseOnAction'		=> 'true,',
			    'pauseOnHover'		=> 'true'
			);
			
			$slider_args = apply_filters( 'wpsight_home_slider_options_args', $slider_args ); ?>
			
			<script type="text/javascript">
			jQuery(document).ready(function($){
			    $(function(){
			    	$('#ushuaia-slider-home .flexslider').flexslider({
			    		<?php
			    			foreach( $slider_args as $k => $v ) {
			    				echo $k . ': ' . $v . "\n";
			    			}
			    		?>,
			    		start: function(slider) {
			    		    $('.next').click(function() {
			    		        $('.flexslider').show();
			    		        var totalSlides = slider.count-1;
			        		    var currSlide = slider.currentSlide;
			        		    if (currSlide != totalSlides){
			        		        var next = currSlide+1;
			        		        slider.flexAnimate(next);
			        		    }
			        		    else{
			        		        next = 0;
			        		        slider.flexAnimate(0);
			        		    }
			    		    });
			    		    $('.prev').click(function() {
			    		        $('.flexslider').show();
			            		var currSlide = slider.currentSlide;
			            		if (currSlide !== 0){
			            		    var prev = currSlide-1;
			            		    slider.flexAnimate(prev);
			            		}
			            		else{
			            		    prev = slider.count - 1;
			            		    slider.flexAnimate(prev);
			            		}
			    		    });
			    		}
			    	});
			    });
			});
			</script>
				
			<div class="flexslider">
			
	    	  	<ul class="slides"><?php
	    	  	
	    	  		// Loop through posts
	    	  		
	    	  		while( $slider->have_posts() ) {
	    	  		
	    	  		    $slider->the_post();
	    	  		
	    	  		    // Check if slider_embed is active
	    	  		    
	    	  		    $slider_embed = get_post_meta( get_the_ID(), 'slider_embed', true );
	    	  		    
	    	  		    if( ! empty( $slider_embed ) ) {
	    	  		    
	    	  		    	echo '<li>' . wp_kses_post( $slider_embed ) . '</li>';
	    	  		    
	    	  		    } elseif( has_post_thumbnail() ) {
	    	  		    	
	    	  		    	// Get default align
	    	  		    	$align_options = wpsight_get_option( 'slider_home_overlay_align', 'left' );
	    	  		    
	    	  		    	// Set custom align
	    	  		    	$align = get_post_meta( get_the_ID(), 'slider_overlay_align', true );

			    	    	// Set overlay align via custom field
	    	    	    	$align = $align ? $align : $align_options;
	    	    	    	
	    	    	    	// Allow custom link
	    	    	    	$link = apply_filters( 'wpsight_home_listings_slider_link', get_permalink(), $query_args ); ?>
	    	  		    
	    	  		    	<li id="slide-<?php the_ID(); ?>" class="slide-<?php echo $counter; ?> slide-align-<?php echo $align; ?>"><?php
	    	  		    	
	    	  		    		if( $unlink == false ) {
	    	  		    		    echo '<a href="' . $link . '">' . get_the_post_thumbnail( get_the_ID(), $image_size, array( 'alt' => get_the_title(), 'title' => get_the_title() ) ) . '</a>';
	    	  		    		} else {
	    	  		    		    echo get_the_post_thumbnail( get_the_ID(), $image_size, array( 'alt' => get_the_title(), 'title' => get_the_title() ) );
	    	  		    		}
	    	  		    		
	    	  		    		if( $overlay == '1' || ( $prevnext == '1' && $slider->post_count > 1 ) ) { ?>
	    	  		    					    
	    	  		    			<table cellpadding="0" cellspacing="0">	    		  								    
	    	  		    			    <tr>	    		  								    	
	    	  		    			    	<td class="overlay-wrap-left">&nbsp;</td>
	    	  		    			    	<td class="overlay-wrap-center">
	    	  		    			    		<div class="overlay-wrap-center-inner">
	    	  		    			    		
	    	  		    			    		<div class="overlay-wrap clearfix<?php if( $overlay == '0' ) echo ' no-overlay'; ?>"><?php
	    	  		    			    	
	    	  		    			    			if( $overlay == '1' ) { ?>
	    	  		    			    			
	    	  		    					    	<div class="overlay<?php if( $teaser == '0' ) echo ' no-teaser'; if( $prevnext == '0' || $slider->post_count < 2 ) echo ' no-prevnext'; ?>">
	    	  		    					    	    
	    	  		    					    	    <?php
	    	  		    					    	        // Action hook to add content before overlay title
	    	  		    					    	        do_action( 'wpsight_home_listings_slider_title_before', $query_args );
	    	  		    					    	    ?>
	    	  		    					    	    <h3>
	    	  		    					    	        <?php
	    	  		    					    	        	if( $unlink == false ) {
	    	  		    					    	        		echo '<a href="' . $link . '">' . get_the_title() . '</a>';
	    	  		    					    	        	} else {
	    	  		    					    	        		echo get_the_title();
	    	  		    					    	        	}
	    	  		    					    	        ?>
	    	  		    					    	    </h3>
	    	  		    					    	    <?php
	    	  		    					    	        // Action hook to add content after overlay title
	    	  		    					    	        do_action( 'wpsight_home_listings_slider_title_after', $query_args );
	    	  		    					    	        
	    	  		    					    	        if( $teaser == true ) {
	    	  		    					    	        	if( $unlink == false ) {
	    	  		    					    	        		wpsight_the_excerpt( get_the_ID(), false, $length );
	    	  		    					    	        	} else {
	    	  		    					    	        		echo apply_filters( 'the_content', get_the_content( false ) );
	    	  		    					    	        	}
	    	  		    					    	        }
	    	  		    					    	        // Action hook to add content after overlay teaser
	    	  		    					    	        do_action( 'wpsight_home_listings_slider_teaser_after', $query_args );
	    	  		    					    	    ?> 
	    	  		    					    	    
	    	  		    					    	</div><!-- .overylay --><?php
	    	  		    					    	
	    	  		    					    	} // endif $overlay ?>
	    	  		    					    
	    	  		    					    </div><?php
	    	  		    					    
	    	  		    					   	if( $prevnext == '1' && $slider->post_count > 1 ) { ?>	    		  								    
	    	  		    					       		  								    		
	    	  		    							<div id="ushuaia-slider-home-nav-wrap">
	    	  		    							
	    	  		    							    <div id="ushuaia-slider-home-nav">
	    	  		    							        <span class="next"><?php _e( 'Next', 'wpsight' ); ?></span>
	    	  		    							        <span class="prev"><?php _e( 'Previous', 'wpsight' ); ?></span>
	    	  		    							    </div>
	    	  		    							
	    	  		    							</div><?php
	    	  		    						
	    	  		    						} // endif $prevnext ?>
	    	  		    					    
	    	  		    					    </div><!-- .overlay-wrap-center-inner -->
	    	  		    					</td><!-- .overlay-wrap -->	    		  								    
	    	  		    			    	<td class="overlay-wrap-right">&nbsp;</td>	    		  								    
	    	  		    			    </tr>	    		  								    
	    	  		    			</table><?php
	    	  		    			
	    	  		    		} // endif $overlay || $prevnext ?>
			    			
	    	  		    	</li><?php
	    	  		    	
	    	  		    	// Increase loop counter
							$counter++;
	    	  		    
	    	  		    } // endif has_post_thumbnail()
	    	  		
	    	  		} // endwhile have_posts() ?>
	    	  		
	    	  	</ul>
	    	  	
	    	</div><!-- .flexslider -->
	    	
	    </div><!-- #ushuaia-slider-home --><?php
		
	} // endif have_posts()

}

/**
 * Display listing details overview
 * after property teaser in home slider
 *
 * @since 1.0
 */
 
add_action( 'wpsight_home_listings_slider_teaser_after', 'ushuaia_do_listing_details_overview_slider' );

function ushuaia_do_listing_details_overview_slider( $query_args = '' ) {
	
	// Stop if details disabled
	
	$elements  = wpsight_get_option( 'slider_home_elements' );
	$details   = $elements['details'];
	
	// Stop if post type != listing
	$post_type = get_post_type( get_the_ID() );
	
	if( $details != '1' || $post_type != wpsight_listing_post_type() )
		return;
		
	echo preg_replace( '/\s+/', ' ', wpsight_get_listing_details() );
	
}
