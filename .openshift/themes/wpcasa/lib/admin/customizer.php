<?php
/**
 * Add theme customizer options
 *
 * @package wpSight
 */
 
/**
 * Register custom customizer logo options
 *
 * @since 1.2
 */

add_action( 'customize_register', 'wpsight_customize_register_logo' );

function wpsight_customize_register_logo( $wp_customize ) {
	
	// Add setting logo
	
	$wp_customize->add_setting(
		WPSIGHT_DOMAIN . '[logo]',
		array(
			'default' 		=> wpsight_get_option( 'logo', WPSIGHT_IMAGES . '/logo.png' ),
			'type' 			=> 'option'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'customize_logo',
			array(
			    'label'    => __( 'Logo', 'wpsight' ),
			    'section'  => 'title_tagline',
			    'settings' => WPSIGHT_DOMAIN . '[logo]',
			)
		)
	);
	
	// Add setting favicon
	
	$wp_customize->add_setting(
		WPSIGHT_DOMAIN . '[favicon]',
		array(
			'default' 		=> '',
			'type' 			=> 'option'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'customize_favicon',
			array(
			    'label'    => __( 'Favicon', 'wpsight' ),
			    'section'  => 'title_tagline',
			    'settings' => WPSIGHT_DOMAIN . '[favicon]',
			)
		)
	);

}

/**
 * Register custom customizer color options
 *
 * @since 1.2
 */

add_action( 'customize_register', 'wpsight_customize_register_color' );

function wpsight_customize_register_color( $wp_customize ) {
	
	// Add setting link color
	
	$wp_customize->add_setting(
		'link_color',
		array(
			'default' 		=> '#3da754',
			'type' 			=> 'theme_mod'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'customize_link_color',
			array(
			    'label'    => __( 'Link Color', 'wpsight' ),
			    'section'  => 'colors',
			    'settings' => 'link_color',
			)
		)
	);

}

/**
 * Remove static front page section
 *
 * @since 1.2
 */

add_action( 'customize_register', 'wpsight_customize_remove_static' );

function wpsight_customize_remove_static( $wp_customize ) {	
	$wp_customize->remove_section( 'static_front_page' );
}