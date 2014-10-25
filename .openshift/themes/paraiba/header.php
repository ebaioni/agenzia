<?php
/**
 * Built theme head with doctype, title
 * custom head, favicon and meta info.
 * 
 * Built header output with top bar,
 * main header section with logo and header right area
 * and main and sub menu.
 *
 * @package wpCasa
 * @since 1.0
 */
 
do_action( 'wpsight_head' );
wp_head();

?>

</head>

<body <?php body_class(); ?>>

<?php do_action( 'wpsight_before' ); ?>

<div id="outer">

<?php
	// Action hook before header
	do_action( 'wpsight_header_before' );
	
	// Open layout wrap		
    wpsight_layout_wrap( 'header-wrap' ); ?>
        		
    <div id="header" class="clearfix">
    	
		<?php
		    // Action hook for header right section
		    do_action( 'wpsight_header_right' );
		?>
    	
    </div><!-- #header --><?php
    
    // Close layout wrap		
    wpsight_layout_wrap( 'header-wrap', 'close' );
	
	// Action hook after header
	do_action( 'wpsight_header_after' );
?>