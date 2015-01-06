<?php

/**
 * This template shows a print-friendly
 * version of a single listing page
 *
 * @package wpSight
 * @since 1.0
 */

$listing_id = $_GET['pid'];
$listing = get_post( $listing_id ); ?>

<html>
	
<head>
	<title><?php echo apply_filters( 'the_title', $listing->post_title ); ?></title>
	<?php
		// Action hook for print head
		do_action( 'wpsight_head_print' );
	?>
</head>

<body class="print">

	<div id="wrap">

		<?php
			// Action hook before print output
			do_action( 'wpsight_listing_print_before', $listing_id );
		?>
	
		<div class="print-title">
	
			<?php		
				// Display title wrapped by H1
				echo do_shortcode( '[listing_title wrap="h1"]' );
			?>
		
		</div><!-- .print-title -->
		
		<?php
			// Action hook after print title
			do_action( 'wpsight_listing_print_title_after', $listing_id );
		?>
		
		<div class="print-image">
		
			<?php
				// Display listing image
				echo do_shortcode( '[listing_image]' );
			?>
			
		</div><!-- .print-image -->
		
		<?php
			// Action hook after print image
			do_action( 'wpsight_listing_print_image_after', $listing_id );
		?>
		
		<div class="print-info clearfix">
		
			<?php
			
				// Display listing ID
				echo do_shortcode( 'Rif. [listing_id after=" - "]' );
				
				// Display listing price
				echo do_shortcode( '[listing_price]' );
				
				// Display listing location
				echo do_shortcode( '[listing_terms taxonomy="location" link="false" term_before="&rsaquo; " sep=""]' );
				
				// Display listing type
				echo do_shortcode( '[listing_terms taxonomy="listing-type" link="false" term_before="&rsaquo; " sep=""]' );
			
			?>
			
		</div><!-- .print-info -->
		
		<?php
			// Action hook after print info
			do_action( 'wpsight_listing_print_info_after', $listing_id );
		?>
		
		<div class="print-details">
		
			<!-- <h2><?php _ex( 'Listing Details', 'listing print', 'wpsight' ); ?></h2> -->
		
			<?php
				// Display listing details
				echo do_shortcode( '[listing_details]' );			
			?>
			
		</div><!-- .print-details -->

		<?php
			// Action hook after print details
			do_action( 'wpsight_listing_print_details_after', $listing_id );
		?>
		
		<div class="print-description">
			
			<?php
				// Display listing description
				echo do_shortcode( '[listing_description]' );
			?>
			
		</div><!-- .print-description -->
		
		<?php
			// Action hook after print description
			do_action( 'wpsight_listing_print_description_after', $listing_id );
		?>
		
		<div class="print-features">
		
			<!-- <h2><?php _ex( 'Listing Features', 'listing print', 'wpsight' ); ?></h2> -->
			
			<?php
				// Display listing features
				echo do_shortcode( '[listing_terms taxonomy="feature" link="false" term_before="&rsaquo; " sep=""]' );			
			?>
			
		</div><!-- .print-features -->
		
		<?php
			// Action hook after print features
			do_action( 'wpsight_listing_print_features_after', $listing_id );
		?>
		
		<div class="print-qr">
		
			<!-- <h2><?php _ex( 'QR Code', 'listing print', 'wpsight' ); ?></h2> -->
			
			<?php
				// Display listing QR
				echo do_shortcode( '[listing_qr]' );
			?>
			
		</div><!-- .print-qr -->
	
		<?php
			// Action hook after print output
			do_action( 'wpsight_listing_print_after', $listing_id );
		?>
	
	</div><!-- #wrap -->
	
<?php
    // Action hook for print footer
    do_action( 'wpsight_footer_print' );
?>

</body>
</html>