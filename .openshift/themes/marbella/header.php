<?php
/**
 * Custom Marbella child theme header template
 *
 * @package wpCasa
 * @subpackage Marbella
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
    
    	<div id="header-top">
    	
    		<?php
    			// Action hook for logo output
    			do_action( 'wpsight_logo' );
    		?>
    		
    	</div><!-- #header-top -->
    	
    	<div id="header-bottom">
    	
    		<?php
    			// Action hook for header right section
    			do_action( 'wpsight_header_right' );
    		?>
    		
    	</div><!-- #header-bottom -->
    	
    </div><!-- #header --><?php
    
    // Close layout wrap		
    wpsight_layout_wrap( 'header-wrap', 'close' );
	
	// Action hook after header
	do_action( 'wpsight_header_after' );
?>