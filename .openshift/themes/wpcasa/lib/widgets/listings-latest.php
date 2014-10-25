<?php

/**
 * Create lastest listings widget
 *
 * @package wpSight
 * @subpackage Widgets
 * @since 1.0
 */
 
/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_register_widget_listings_latest' );
 
function wpsight_register_widget_listings_latest() {

	register_widget( 'wpSight_Latest_Listings' );

}

class wpSight_Latest_Listings extends WP_Widget {
 
	function __construct() {
		$widget_ops = array( 'description' => __( 'Latest listings teaser', 'wpsight' ) );
		parent::__construct( 'wpSight_Latest_Listings', ':: ' . WPSIGHT_NAME . ' ' . __( 'Latest Listings', 'wpsight' ), $widget_ops );
    }
 
    function widget( $args, $instance ) {
    
    	extract( $args, EXTR_SKIP );
        
        $title 	   	= isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
        $filter	   	= isset( $instance['filter'] ) ? strip_tags( $instance['filter'] ) : false;
        if ( ! $number = (int) $instance['number'] )
			$number = 1;
		else if ( $number < 1 )
			$number = 1;
		if ( ! $length = (int) $instance['length'] )
			$length = 25;
		else if ( $length < 1 )
			$length = 25;        
        $width 		= ( isset( $instance['width'] ) ) ? $instance['width'] : wpsight_get_span( 'small' );
        
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
            'post_type' 	 => array( 'listing' ),
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
            	
            } elseif( $filter == 'latest-new' ) {
            	
            	// Set meta_query
            	
            	$meta_query = array(
            	    array(
            	    	'key' 	=> '_price_status',
            	    	'value' => 'new'
            	    )
            	);
            	
            	$query_args = array_merge( $query_args, array( 'meta_query' => $meta_query ) );
            	
            } elseif( $filter == 'latest-used' ) {
            	
            	// Set meta_query
            	
            	$meta_query = array(
            	    array(
            	    	'key' 	=> '_price_status',
            	    	'value' => 'used'
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
            	    	'field'    => 'slug',
            	    	'terms'    => array( $term )
            	    )
            	);
            	
            	$query_args = array_merge( $query_args, array( 'tax_query' => $tax_query ) );
            
            }
            
        }
        
        $query_args = apply_filters( 'wpsight_widget_listings_latest_query_args', $query_args, $args, $instance );
        
        // Check if transients are active
		$transients = apply_filters( 'wpsight_transients_queries', false, 'widget', $query_args, $this->id );
		
		// If query transients are active

		if( $transients === true ) {
		
			// If transient does not exist
			
			if ( false === ( $latest = get_transient( 'wpsight_query_' . $this->id ) ) || ( isset( $query_args['orderby'] ) && $query_args['orderby'] == 'rand' ) ) {
			
				// Create listing query
			 	$latest = new WP_Query( $query_args );
			 	
			 	// Set transient for this query
			 	set_transient( 'wpsight_query_' . $this->id, $latest, DAY_IN_SECONDS );		
			}

		// If query transients are not active
		
		} else {
		
			// Create listing query
			$latest = new WP_Query( $query_args );
		
		}
        
        if ( $latest->have_posts() ) {
        
        	// Create loop counter
        	$counter = 1; ?>
		
			<div id="<?php echo wpsight_dashes( $widget_id ); ?>-wrap" class="widget-wrap widget-latest-wrap">
			
				<div id="<?php echo wpsight_dashes( $widget_id ); ?>" class="widget widget-latest widget-latest-listings row"><?php
					
					// Display widget title
					if( ! empty( $title ) ) { ?>
						
						<div class="title title-widget clearfix">
						
						    <?php
						    	echo apply_filters( 'wpsight_widget_listings_latest_title', '<h2>' . $title . '</h2>', $args, $instance );
						    	do_action( 'wpsight_widget_listings_latest_title_actions', $args, $instance );
						    ?>
						
						</div><?php
					
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
					    	} elseif( $id == 'sidebar' || $id == 'sidebar-home' || $id == wpsight_get_sidebar( 'sidebar-listing' ) || $id == 'sidebar-post' || $id == 'sidebar-page' || $id == wpsight_get_sidebar( 'sidebar-listing-archive' ) ) {
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
					    	} elseif( $id == 'sidebar' || $id == 'sidebar-home' || $id == wpsight_get_sidebar( 'sidebar-listing' ) || $id == 'sidebar-post' || $id == 'sidebar-page' || $id == wpsight_get_sidebar( 'sidebar-listing-archive' ) ) {
					    		$widget_width = 'span4';
					    		$clear = ' clear';					
					    	}
					    
					    } ?>
					    
					    <div <?php post_class( $widget_width . $clear . ' clearfix' ); ?>>
					    
					    	<div class="widget-inner">
					        
					    		<?php
					    			// Action hook before listing title (widget)
					    		    do_action( 'wpsight_widget_listing_title_before', $width, $id );
					    		?>
					    		
					    		<h3 class="post-title">
    				    			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
    				    				<?php
    				    					// Action hook listing title inside (widget)
    				    		    		do_action( 'wpsight_widget_listing_title_inside', $width, $id );
    				    					the_title();
    				    				?>
    				    			</a>
    				    		</h3>
					    		    
					    		<?php
					    			// Action hook after listing title (widget)   
					    		    do_action( 'wpsight_widget_listing_title_after', $width, $id );
					    		    
					    		    // Action hook before listing content (widget)
					    		    do_action( 'wpsight_widget_listing_content_before', $width, $id );
					    		?>
					        		
					    		<div class="post-teaser">
					    			<?php wpsight_the_excerpt( get_the_ID(), true, $length ); ?>
					        	</div>
					        	
					        	<?php
					        		// Action hook after listing content (widget)
					        		do_action( 'wpsight_widget_listing_content_after', $width, $id );
					        	?>
					        	
					        </div><!-- .widget-inner -->
					        			
					    </div><!-- .post-<?php the_ID(); ?> --><?php
					    
					    // Increase loop counter
					    $counter++;
					    
					} // endwhile have_posts() ?>
				
				</div><!-- .widget -->
			
			</div><!-- .widget-wrap --><?php
		
		} // endif have_posts()
		
		// Reset query
		wp_reset_query();

    }

    function update( $new_instance, $old_instance ) {  
    
    	$instance['title'] 	= strip_tags($new_instance['title']);
    	$instance['filter']	= strip_tags( $new_instance['filter'] );
    	$instance['number'] = (int) $new_instance['number'];
    	$instance['length'] = (int) $new_instance['length'];
        $instance['width'] 	= $new_instance['width'];
        
        // Remove transient when settings are edited
        delete_transient( 'wpsight_query_' . $this->id );
                  
        return $new_instance;
    }
 
    function form( $instance ) {
             
		$instance	= wp_parse_args( (array) $instance, array( 'title' => '', 'cat' => '', 'number' => '3', 'length' => 25 ) );
		$title 	   	= isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : false;
		$filter	   	= isset( $instance['filter'] ) ? $instance['filter'] : false;
		if ( ! isset($instance['number'] ) || ! $number = (int) $instance['number'] )
			$number = 3;
		if ( !isset($instance['length']) || !$length = (int) $instance['length'] )
			$length = 25;
        $width 		= ( isset( $instance['width'] ) ) ? $instance['width'] : wpsight_get_span( 'small' ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpsight' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Filter', 'wpsight' ); ?>:</label>
			<?php do_action( 'wpsight_widget_listings_latest_filter', $this->get_field_id( 'filter' ), $this->get_field_name( 'filter' ), $instance ); ?>
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

} // end class wpSight_Latest_Listings