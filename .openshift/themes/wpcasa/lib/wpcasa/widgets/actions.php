<?php

/**
 * Apply action hooks for
 * wpCasa-specific widgets
 *
 * @package wpSight
 */
 
/**
 * Define filter for
 * latest listings widget
 *
 * @since 1.2
 */
 
add_action( 'wpsight_widget_listings_latest_filter', 'wpsight_wpcasa_widget_listings_latest_filter', 10, 3 );

function wpsight_wpcasa_widget_listings_latest_filter( $field_id, $field_name, $instance ) {

	$filter = isset( $instance['filter'] ) ? $instance['filter'] : false; ?>

	<select class="widefat" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>">
	    <option value="" <?php selected( '', $filter ); ?>><?php _e( 'Latest properties', 'wpsight' ); ?></option>
	    <option value="latest-sale" <?php selected( 'latest-sale', $filter ); ?>><?php _e( 'Latest properties (for sale)', 'wpsight' ); ?></option>
	    <option value="latest-rent" <?php selected( 'latest-rent', $filter ); ?>><?php _e( 'Latest properties (for rent)', 'wpsight' ); ?></option>
	    <option disabled>===== <?php _e( 'Categories', 'wpsight' ); ?> =====</option>				
	    <?php
	    	// Add property categories
	    	$terms_category = get_terms( array( 'property-category' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_category as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Features', 'wpsight' ); ?> =====</option>
	    <?php
	    	// Add property features
	    	$terms_feature = get_terms( array( 'feature' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_feature as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Locations', 'wpsight' ); ?> =====</option>
	    <?php
	    	// Add property features
	    	$terms_location = get_terms( array( 'location' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_location as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Types', 'wpsight' ); ?> =====</option>
	    <?php
	    	// Add property features
	    	$terms_type = get_terms( array( 'property-type' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_type as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>			
	</select><?php

}

/**
 * Define filter for
 * listings slider widget
 *
 * @since 1.2
 */
 
add_action( 'wpsight_widget_listings_slider_filter', 'wpsight_wpcasa_widget_listings_slider_filter', 10, 3 );

function wpsight_wpcasa_widget_listings_slider_filter( $field_id, $field_name, $instance ) {

	$filter = isset( $instance['filter'] ) ? $instance['filter'] : false; ?>

	<select class="widefat" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>">
	    <option value="" <?php selected( '', $filter ); ?>><?php _e( 'Latest properties', 'wpsight' ); ?></option>
	    <option value="latest-sale" <?php selected( 'latest-sale', $filter ); ?>><?php _e( 'Latest properties (for sale)', 'wpsight' ); ?></option>
	    <option value="latest-rent" <?php selected( 'latest-rent', $filter ); ?>><?php _e( 'Latest properties (for rent)', 'wpsight' ); ?></option>
	    <option disabled>===== <?php _e( 'Categories', 'wpsight' ); ?> =====</option>				
	    <?php
	    	// Add property categories
	    	$terms_category = get_terms( array( 'property-category' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_category as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Features', 'wpsight' ); ?> =====</option>
	    <?php
	    	// Add property features
	    	$terms_feature = get_terms( array( 'feature' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_feature as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Locations', 'wpsight' ); ?> =====</option>
	    <?php
	    	// Add property features
	    	$terms_location = get_terms( array( 'location' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_location as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Types', 'wpsight' ); ?> =====</option>
	    <?php
	    	// Add property features
	    	$terms_type = get_terms( array( 'property-type' ), array( 'hide_empty' => 0 ) );
	    	foreach( $terms_type as $term ) {
	    		echo '<option value="' . $term->taxonomy . ',' . $term->slug . '"'.selected( $term->taxonomy . ',' . $term->slug, $filter ) . '>' . $term->name . '</option>';
	    	}
	    ?>
	    <option disabled>===== <?php _e( 'Custom', 'wpsight' ); ?> =====</option>
	    <option value="custom" <?php selected( 'custom', $filter ); ?>><?php _e( 'Custom field', 'wpsight' ); ?> => slider</option>			
	</select><?php

}