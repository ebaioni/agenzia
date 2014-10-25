<?php

/**
 * Create lastest posts widget.
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpcasa_register_widget_properties_latest' );
 
function wpcasa_register_widget_properties_latest() {
	register_widget( 'wpCasa_Latest_Properties' );
}

class wpCasa_Latest_Properties extends WP_Widget {
 
	function __construct() {
		$widget_ops = array( 'description' => __( 'Latest properties teaser', 'wpsight' ) );
		parent::__construct( 'wpCasa_Latest_Properties', WPSIGHT_NAME . ' ' . __( 'Latest Properties', 'wpsight' ), $widget_ops );
    }
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
        
        $title 	   = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $filter	   = isset( $instance['filter'] ) ? strip_tags( $instance['filter'] ) : false;
        if ( !$number = (int) $instance['number'] )
			$number = 1;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 20 )
			$number = 20;
		if ( !$length = (int) $instance['length'] )
			$length = 25;
		else if ( $length < 1 )
			$length = 25;        
        $width 		= ( isset( $instance['width'] ) ) ? $instance['width'] : 'full';
        
        // Correct width
        if( $width == wpsight_get_span( 'big' ) && ( $id == 'home-top' || $id == 'home-bottom' || $id == 'ffooter' ) )
        	$width = wpsight_get_span( 'full' );
        if( ( $width == wpsight_get_span( 'full' ) || $width == wpsight_get_span( 'half' ) ) && $id == 'home' )
        	$width = wpsight_get_span( 'big' );
        
        // Check widget width
        
        if( $width != 'full' ) {
       		$widget_width = $width;
        } else {
        	$widget_width = '';
       		if( $id == 'home-top' || $id == 'home-bottom' || $id == 'ffooter' ) {
       			$clear = ' clearfix';
       		}        	
        }
		    
		if( ( $id == 'sidebar' || $id == 'sidebar-home' ) || ( $id == 'home' && ( $width == 'span12' || $width == 'full' ) ) ) {
		    $widget_width = '';
		    $clear = ' clearfix';
		}
        
        // Create query args
        	
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
        
        $query_args = apply_filters( 'wpsight_widget_listings_latest_query_args', $query_args );
        
        $latest = new WP_Query( $query_args );
        
        if ( $latest->have_posts() ) {
        
        	// Create loop counter
        	$counter = 1;
		
			?>
		
			<div id="<?php echo wpsight_dashes( $widget_id ); ?>-wrap" class="widget-wrap widget-latest-wrap">
			
				<div id="<?php echo wpsight_dashes( $widget_id ); ?>" class="widget widget-latest row">
				
					<?php
						// Display widget title
						if( ! empty( $title ) ) {
					?>
						
					<div class="title title-widget clearfix">
		
					    <?php
					    	echo apply_filters( 'wpsight_widget_listings_latest_title', '<h2>' . $title . '</h2>' );
					    	do_action( 'wpsight_widget_listings_latest_title_actions' );
					    ?>
					
					</div>
		
					<?php
						} // endif $title
									    
						// Begin to loop through posts
						    
						while( $latest->have_posts() ) {
						
							// Set up post data
							$latest->the_post();
						
							$clear = '';
						
							// Add .clear to post class with if madness
							
							if( WPSIGHT_LAYOUT == 'four' ) {
							
								if( $id == 'home-top' || $id == 'home-bottom' || $id == 'ffooter' ) {
									if( $width == 'span3' ) {
										if( $counter == 1 || ($counter-1)%4 == 0 ) {								
											$clear = ' clear';									
										} else {								
											$clear = '';							
										}
									} elseif( $width == 'span6' ) {
										if( $counter == 1 || $counter%2 != 0 ) {								
											$clear = ' clear';									
										} else {								
											$clear = '';							
										}								
									}
								} elseif( $id == 'home' ) {
									if( $width == 'span3' ) {
										if( $counter == 1 || ($counter-1)%3 == 0 ) {								
											$clear = ' clear';									
										} else {								
											$clear = '';							
										}
									}						
								} elseif( $id == 'sidebar' || $id == 'sidebar-home' || $id == 'sidebar-property' || $id == 'sidebar-post' || $id == 'sidebar-page' || $id == 'sidebar-property-archive' ) {
									$widget_width = 'span3';
									$clear = ' clear';					
								}
							
							} else {
							
								if( $id == 'home-top' || $id == 'home-bottom' || $id == 'ffooter' ) {
									if( $width == 'span4' ) {
										if( $counter == 1 || ($counter-1)%3 == 0 ) {								
											$clear = ' clear';									
										} else {								
											$clear = '';							
										}
									} elseif( $width == 'span6' ) {
										if( $counter == 1 || $counter%2 != 0 ) {								
											$clear = ' clear';									
										} else {								
											$clear = '';							
										}								
									}
								} elseif( $id == 'home' ) {
									if( $width == 'span4' ) {
										if( $counter == 1 || $counter%2 != 0 ) {								
											$clear = ' clear';									
										} else {								
											$clear = '';							
										}
									}						
								} elseif( $id == 'sidebar' || $id == 'sidebar-home' || $id == 'sidebar-property' || $id == 'sidebar-post' || $id == 'sidebar-page' || $id == 'sidebar-property-archive' ) {
									$widget_width = 'span4';
									$clear = ' clear';					
								}
							
							}
						
							?>
						    
						    <div <?php post_class( $widget_width . $clear . ' clearfix' ); ?>>
						    
						    	<div class="widget-inner">
						        
						    		<?php
						    			// Action hook before property title (widget)
						    		    do_action( 'wpsight_widget_listing_title_before', $width, $id );
						    		?>
						    		
						    		<h3 class="post-title">
    									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
    										<?php
    											// Action hook post title inside
    								    		do_action( 'wpsight_widget_listing_title_inside' );
    											the_title();
    										?>
    									</a>
    								</h3>
						    		    
						    		<?php
						    			// Action hook after property title (widget)   
						    		    do_action( 'wpsight_widget_listing_title_after', $width, $id );
						    		    
						    		    // Action hook before property content (widget)
						    		    do_action( 'wpsight_widget_listing_content_before', $width, $id );
						    		?>
						        		
						    		<div class="post-teaser">
						    			<?php wpsight_the_excerpt( get_the_ID(), false, $length ); ?>
						        	</div>
						        	
						        	<?php
						        		// Action hook after property content (widget)
						        		do_action( 'wpsight_widget_listing_content_after', $width, $id );
						        	?>
						        	
						        </div><!-- .widget-inner -->
						        			
						    </div><!-- .post-<?php the_ID(); ?> --><?php
						    
							// Increase loop counter
							$counter++;
						    
						} // endwhile have_posts()						
					?>
				
				</div><!-- .widget -->
			
			</div><!-- .widget-wrap --><?php
		
		} // endif have_posts()
    }

    function update($new_instance, $old_instance) {  
    
    	$instance['title'] 	= strip_tags($new_instance['title']);
    	$instance['filter']	= strip_tags( $new_instance['filter'] );
    	$instance['number'] = (int) $new_instance['number'];
    	$instance['length'] = (int) $new_instance['length'];
        $instance['width'] 	= $new_instance['width'];
        
        // Remove transient when settings are edited
        delete_transient( $this->id . '_query' );
                  
        return $new_instance;
    }
 
    function form($instance) {
        
        global $options;
        
		$instance		= wp_parse_args( (array) $instance, array( 'title' => '', 'cat' => '', 'number' => '3', 'length' => 25 ) );
		$title 	   = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$filter	   = isset( $instance['filter'] ) ? $instance['filter'] : false;
		if ( ! isset($instance['number'] ) || ! $number = (int) $instance['number'] )
			$number 	= 3;
		if ( !isset($instance['length']) || !$length = (int) $instance['length'] )
			$length 	= 25;
        $width 			= ( isset( $instance['width'] ) ) ? $instance['width'] : 'full'; ?>

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
			</select>
			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show', 'wpsight' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br /><small><?php _e( '(at most 20)', 'wpsight' ); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'length' ); ?>"><?php _e( 'Number of words in excerpt', 'wpsight' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'length' ); ?>" name="<?php echo $this->get_field_name( 'length' ); ?>" type="text" value="<?php echo $length; ?>" size="3" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', 'wpsight' ); ?>:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>">
				<?php
					foreach( wpsight_widget_widths() as $k => $v ) {
						echo '<option value="' . $k . '"' . selected( $k, $width, false ) . '>' . $v . '</option>';
					}
				?>
			</select>
		</p><?php

	}

} // end class wpCasa_Latest_Properties