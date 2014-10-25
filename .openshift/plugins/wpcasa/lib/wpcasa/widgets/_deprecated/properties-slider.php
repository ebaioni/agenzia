<?php

/**
 * Create FlexSlider widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_property_slider' );
 
function wpcasa_register_widget_property_slider() {

	if( current_theme_supports( 'FlexSlider' ) )
		register_widget( 'wpCasa_Property_Slider' );

}

class wpCasa_Property_Slider extends WP_Widget {
 
	function __construct() {
		$widget_ops = array( 'description' => __( 'jQuery property slider', 'wpsight' ) );
		parent::__construct( 'wpCasa_Property_Slider', WPSIGHT_NAME . ' ' . _x( 'Property Slider', 'listing widget', 'wpsight' ), $widget_ops );
    }
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
        
        $title 	   = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $filter	   = isset( $instance['filter'] ) ? strip_tags( $instance['filter'] ) : false;        		   
        $effect	   = isset( $instance['effect'] ) ? $instance['effect'] : 'fade';
        $direction = isset( $instance['direction'] ) ? $instance['direction'] : 'horizontal';
        $timer	   = isset( $instance['timer'] ) ? (int) $instance['timer'] : 0;
        $prevnext  = isset( $instance['prevnext'] ) ? $instance['prevnext'] : true;
        $overlay   = isset( $instance['overlay'] ) ? $instance['overlay'] : true;
        $details   = isset( $instance['details'] ) ? $instance['details'] : true;
        $teaser    = isset( $instance['teaser'] ) ? $instance['teaser'] : true;
        $keynav    = isset( $instance['keynav'] ) ? $instance['keynav'] : true;
        $mousenav  = isset( $instance['mousenav'] ) ? $instance['mousenav'] : false;
        $random    = isset( $instance['random'] ) ? $instance['random'] : false;
        $unlink    = isset( $instance['unlink'] ) ? $instance['unlink'] : false;
        $number	   = isset( $instance['number'] ) ? (int) $instance['number'] : 10;
        $length	   = isset( $instance['length'] ) ? (int) $instance['length'] : 15;
        
        /**
         * Only show slider on first page
         * if blog template on front page
         */
        
		global $page;
		if( isset( $page ) && $page != 1 )
			return;
		
		// Create query args

		if( $filter != 'custom' ) {
        	
        	$query_args = array(
        		'post_type' => array( 'property' ),
        		'posts_per_page' => $number
        	);
        	
        	// Add filter to query args if required
        	
        	if( ! empty( $filter ) ) {
        	
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
        		'post_type' 	 => array( 'property' ),
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
        
        $query_args = apply_filters( 'wpsight_widget_slider_query_args', $query_args );
        
        // Set slider query        
        $slider = new WP_Query( $query_args );
		
		if ( $slider->have_posts() ) {
        
        	// Create loop counter
        	$counter = 1;
        	
        	// Set image size depending on widget area
        	
        	if( $id == 'home' ) {
        		$image_size = 'big';
        	} elseif( $id == 'sidebar' || $id == 'sidebar-home' || $id == 'sidebar-archive' || $id == 'sidebar-page' || $id == 'sidebar-post' || $id == 'sidebar-property' || $id == 'sidebar-property-archive' ) {
        		$image_size = 'post-thumbnail';
        	} else {
        		$image_size = 'full';
        	}
        	
        	$image_size = apply_filters( 'wpsight_widget_slider_image_size', $image_size, $args, $instance );
		
			// Create widget output ?>
			
			<div id="<?php echo wpsight_dashes( $widget_id ); ?>" class="widget widget-slider widget-property-slider widget-listing-slider clearfix">
			
				<div class="widget-inner">
        	
        			<?php
        			
        			// Display widget title
					if( ! empty( $title ) ) { ?>
							
						<div class="title title-widget clearfix">
					
						    <?php
						    	echo apply_filters( 'wpsight_widget_slider_title', '<h2>' . $title . '</h2>' );
						    	do_action( 'wpsight_widget_slider_title_actions' );
						    ?>
						
						</div><?php
					
					} // endif $title
					
					// Convert boolean to strings for Javascript options
					
					$prevnext = ( $prevnext == true ) ? 'true' : 'false';
					$keynav   = ( $keynav 	== true ) ? 'true' : 'false';
					$mousenav = ( $mousenav == true ) ? 'true' : 'false';
					$random   = ( $random 	== true ) ? 'true' : 'false';
					
					// Correct timer and slideshow = true
					$slideshow = ( $timer == 0 ) ? 'false' : 'true';					
					
					$slider_args = array(
						'animation'			=> '"' . $effect . '",',
						'direction' 		=> '"' . $direction . '",',
						'slideshow'			=> "$slideshow,",
						'slideshowSpeed' 	=> "$timer,",
						'animationDuration' => '300,',
						'directionNav' 		=> "$prevnext,",
						'controlNav' 		=> 'false,',
						'keyboardNav' 		=> "$keynav,",
						'mousewheel' 		=> "$mousenav,",
						'prevText' 			=> '"' . __( 'Previous', 'wpsight' ) . '",',
						'nextText' 			=> '"' . __( 'Next', 'wpsight' ) . '",',
						'pausePlay'			=> 'false,',
						'pauseText'			=> '"' . __( 'Pause', 'wpsight' ) . '",',
						'playText'			=> '"' . __( 'Play', 'wpsight' ) . '",',
						'randomize'			=> "$random,",
						'animationLoop'		=> 'true,',
						'pauseOnAction'		=> 'true,',
						'pauseOnHover'		=> 'true'
					);
					
					$slider_args = apply_filters( 'wpsight_widget_slider_options_args', $slider_args );
					
					?>
					
					<script type="text/javascript">
					jQuery(document).ready(function($){
					    $(function(){
					    	$('.flexslider').flexslider({
					    		<?php
					    			foreach( $slider_args as $k => $v ) {
					    				echo $k . ': ' . $v . "\n";
					    			}
					    		?>
							});
					    });	            
					});
					</script>
					
					<?php 
						/**
						 * Set fixed height on slider container
						 * to avoid layout jump on load
						 */						
						$img = wpsight_get_image_size( $image_size );
						$height = $img['size']['h'];
					?>
        			
        			<div class="flexslider height-<?php echo $height; ?>">
        			
					  	<ul class="slides">
					  	
					  		<?php				  	
					  			// Loop through posts
					  			
					  			while( $slider->have_posts() ) {
					  			
					  				$slider->the_post();
					  			
					  				// Check if slider_embed is active
					  				
					  				$slider_embed = get_post_meta( get_the_ID(), 'slider_embed', true );
					  				
					  				if( ! empty( $slider_embed ) ) {
					  				
					  					echo '<li>' . wp_kses_post( $slider_embed ) . '</li>';
					  				
					  				} elseif( has_post_thumbnail() ) { ?>
					  				
					  				<li>
					  					<?php
					  						if( $unlink == false ) {
					  							echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size, array( 'alt' => get_the_title(), 'title' => get_the_title() ) ) . '</a>';
					  						} else {
					  							echo get_the_post_thumbnail( get_the_ID(), $image_size, array( 'alt' => get_the_title(), 'title' => get_the_title() ) );
					  						}
					  						if( $overlay == true ) {
					  					?>
					  						<div class="overlay<?php if( $teaser == false ) echo ' no-teaser'; ?>">
					  							<?php
					  								// Action hook to add content before overlay title
					  								do_action( 'wpsight_widget_listings_slider_title_before', $args, $instance );
					  							?>
					  							<h3>
					  								<?php
					  									if( $unlink == false ) {
					  										echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
					  									} else {
					  										echo get_the_title();
					  									}
					  								?>
					  							</h3>
					  							<?php
					  								// Action hook to add content after overlay title
					  								do_action( 'wpsight_widget_listings_slider_title_after', $args, $instance );
					  								
					  								if( $teaser == true ) {
					  									if( $unlink == false ) {
					  										wpsight_the_excerpt( get_the_ID(), false, $length );
					  									} else {
					  										echo wpsight_format_content( get_the_content( false ) );
					  									}					  								
					  									// Action hook to add content after overlay teaser
					  									do_action( 'wpsight_widget_listings_slider_teaser_after', $args, $instance );
					  								}
					  							?>
					  						</div>
					  					<?php } ?>
					  				</li>
					  				
					  				<?php } // endif has_post_thumbnail()
					  			
					  			} // endwhile have_posts()
					  		?>
					  	</ul>
					  	
					</div><!-- .flexslider -->
				
				</div><!-- .widget-inner -->
				
			</div><!-- .widget-slider --><?php
        	
        } // endif have_posts()
        
    }

    function update( $new_instance, $old_instance ) {
    
    	$new_instance = (array) $new_instance;
    	
    	$instance = array(
			'overlay'  => 0,
			'details'  => 0,
			'teaser'   => 0,
			'prevnext' => 0,
			'keynav'   => 0,
			'mousenav' => 0,
			'random'   => 0,
			'unlink'   => 0
		);
		
		foreach ( $instance as $field => $val ) {
			if ( isset( $new_instance[$field] ) )
				$instance[$field] = 1;
		}
    
    	$instance['title'] 	   = strip_tags( $new_instance['title'] );
		$instance['filter']	   = strip_tags( $new_instance['filter'] );
		$instance['effect']	   = $new_instance['effect'];
		$instance['direction'] = $new_instance['direction'];
    	$instance['timer'] 	   = (int) $new_instance['timer'];		
		$instance['number']	   = ( ! empty( $new_instance['number'] ) && $new_instance['number'] != 0 ) ? (int) $new_instance['number'] : 10;
		$instance['length']	   = ( ! empty( $new_instance['length'] ) && $new_instance['length'] != 0 ) ? abs( $new_instance['length'] ) : 15;
        
        // Remove transient when settings are edited
        delete_transient( $this->id . '_query' );
                  
        return $instance;
    }
 
    function form( $instance ) {
        
        $defaults = array(
			'overlay'  => true,
			'details'  => true,
			'teaser'   => true,
			'prevnext' => true,
			'keynav'   => true,
			'mousenav' => false,
			'random'   => false,
			'unlink'   => false
		);
        
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title	   = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$filter	   = isset( $instance['filter'] ) ? $instance['filter'] : false;
        $effect	   = isset( $instance['effect'] ) ? $instance['effect'] : 'fade';
        $direction = isset( $instance['direction'] ) ? $instance['direction'] : 'horizontal';
        $timer	   = isset( $instance['timer'] ) ? (int) $instance['timer'] : 0;
        $number	   = isset( $instance['number'] ) ? (int) $instance['number'] : 10;
        $length	   = isset( $instance['length'] ) ? (int) $instance['length'] : 15;
?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Filter', 'wpsight' ); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>">
				<option value="" <?php selected( '', $filter ); ?>><?php _e( 'Latest properties', 'wpsight' ); ?></option>
				<option value="latest-sale" <?php selected( 'latest-sale', $filter ); ?>><?php _e( 'Latest properties (for sale)', 'wpsight' ); ?></option>
				<option value="latest-rent" <?php selected( 'latest-rent', $filter ); ?>><?php _e( 'Latest properties (for rent)', 'wpsight' ); ?></option>
				<option value="">--- <?php _e( 'Categories', 'wpsight' ); ?>---</option>				
				<?php
					// Add property categories
					$terms_category = get_terms( array( 'property-category' ), array( 'hide_empty' => 0 ) );
					foreach( $terms_category as $term ) {
						echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
					}
				?>
				<option value="">--- <?php _e( 'Features', 'wpsight' ); ?>---</option>
				<?php
					// Add property features
					$terms_feature = get_terms( array( 'feature' ), array( 'hide_empty' => 0 ) );
					foreach( $terms_feature as $term ) {
						echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
					}
				?>
				<option value="">--- <?php _e( 'Locations', 'wpsight' ); ?>---</option>
				<?php
					// Add property features
					$terms_location = get_terms( array( 'location' ), array( 'hide_empty' => 0 ) );
					foreach( $terms_location as $term ) {
						echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
					}
				?>
				<option value="">--- <?php _e( 'Types', 'wpsight' ); ?>---</option>
				<?php
					// Add property features
					$terms_type = get_terms( array( 'property-type' ), array( 'hide_empty' => 0 ) );
					foreach( $terms_type as $term ) {
						echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
					}
				?>
				<option value="">--- <?php _e( 'Custom', 'wpsight' ); ?>---</option>
				<option value="custom" <?php selected( 'custom', $filter ); ?>><?php _e( 'Custom field', 'wpsight' ); ?> => slider</option>			
			</select>
			
		</p>
		
		<p>
		    <label for="<?php echo $this->get_field_id( 'effect' ); ?>"><?php _e( 'Effect', 'wpsight' ); ?>:</label><br />
		    <select class="widefat" id="<?php echo $this->get_field_id( 'effect' ); ?>" name="<?php echo $this->get_field_name( 'effect' ); ?>">
		    	<option value="fade"<?php selected( $effect, 'fade' ); ?>><?php _e( 'fade', 'wpsight' ); ?></option>
		    	<option value="slide"<?php selected( $effect, 'slide' ); ?>><?php _e( 'slide', 'wpsight' ); ?></option>				 
		    </select>			
		</p>
		
		<p<?php if( $effect != 'slide' ) echo ' style="display:none"'; ?>>
		    <label for="<?php echo $this->get_field_id( 'direction' ); ?>"><?php _e( 'Direction', 'wpsight' ); ?>:</label><br />
		    <select class="widefat" id="<?php echo $this->get_field_id( 'direction' ); ?>" name="<?php echo $this->get_field_name( 'direction' ); ?>">
		    	<option value="horizontal"<?php selected( $direction, 'horizontal' ); ?>><?php _e( 'horizontal', 'wpsight' ); ?></option>
		    	<option value="vertical"<?php selected( $direction, 'vertical' ); ?>><?php _e( 'vertical', 'wpsight' ); ?></option>				 
		    </select>			
		</p>
		
		<p>
		    <label for="<?php echo $this->get_field_id( 'timer' ); ?>"><?php _e( 'Timer', 'wpsight' ); ?>:</label><br />
		    <select class="widefat" id="<?php echo $this->get_field_id( 'timer' ); ?>" name="<?php echo $this->get_field_name( 'timer' ); ?>">	
		    	<option value="0"<?php selected( $timer, '0' ); ?>><?php _e( 'off', 'wpsight' ); ?></option>					
		    	<?php for( $i = 1; $i <= 10; $i++ ) { ?>					
		    	<option value="<?php echo $i; ?>000"<?php selected( $timer, $i . '000' ); ?>><?php echo $i . ' ' . __( 'seconds', 'wpsight' ); ?></option>
		    	<?php } ?>
		    </select>			
		</p>
		
		<p>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'overlay' ); ?>" name="<?php echo $this->get_field_name( 'overlay' ); ?>" <?php checked( $instance['overlay'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'overlay' ); ?>"><?php _e( 'Overlay', 'wpsight' ); ?></label>		
		</p>
		
		<p<?php if( $instance['overlay'] == false ) echo ' style="display:none"'; ?>>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'details' ); ?>" name="<?php echo $this->get_field_name( 'details' ); ?>" <?php checked( $instance['details'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'details' ); ?>"><?php _e( 'Property details', 'wpsight' ); ?></label>		
		</p>
		
		<p<?php if( $instance['overlay'] == false ) echo ' style="display:none"'; ?>>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'teaser' ); ?>" name="<?php echo $this->get_field_name( 'teaser' ); ?>" <?php checked( $instance['teaser'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'teaser' ); ?>"><?php _e( 'Property teaser', 'wpsight' ); ?></label>		
		</p>
		
		<p>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'prevnext' ); ?>" name="<?php echo $this->get_field_name( 'prevnext' ); ?>" <?php checked( $instance['prevnext'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'prevnext' ); ?>"><?php _e( 'Previous & next buttons', 'wpsight' ); ?></label>		
		</p>
		
		<p>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'keynav' ); ?>" name="<?php echo $this->get_field_name( 'keynav' ); ?>" <?php checked( $instance['keynav'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'keynav' ); ?>"><?php _e( 'Keyboard navigation', 'wpsight' ); ?></label>		
		</p>
		
		<p>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'mousenav' ); ?>" name="<?php echo $this->get_field_name( 'mousenav' ); ?>" <?php checked( $instance['mousenav'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'mousenav' ); ?>"><?php _e( 'Mouse wheel navigation', 'wpsight' ); ?></label>		
		</p>
		
		<p>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" <?php checked( $instance['random'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Random order', 'wpsight' ); ?></label>		
		</p>
		
		<p>
		    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'unlink' ); ?>" name="<?php echo $this->get_field_name( 'unlink' ); ?>" <?php checked( $instance['unlink'], true ) ?> />
		    <label for="<?php echo $this->get_field_id( 'unlink' ); ?>"><?php _e( 'Remove links', 'wpsight' ); ?></label>		
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of entries', 'wpsight' ); ?>:</label><br />
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'length' ); ?>"><?php _e( 'Number of words in teaser', 'wpsight' ); ?>:</label><br />
			<input id="<?php echo $this->get_field_id( 'length' ); ?>" name="<?php echo $this->get_field_name( 'length' ); ?>" type="text" value="<?php echo $length; ?>" size="3" />
			
		</p><?php

	}

} // class wpCasa_Property_Slider