<?php
/**
 * Site Title Setting
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register' ) ) :

function hotell_customize_register( $wp_customize ) {
	
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'refresh';
    $wp_customize->get_setting( 'background_image' )->transport = 'refresh';
	
	if( isset( $wp_customize->selective_refresh ) ){
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'hotell_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'hotell_customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_setting(
        'colors_note_control',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );

    $wp_customize->add_control(
        new Hotell_Note_Control( 
			$wp_customize,
			'colors_note_control',
			array(
				'section'	  => 'colors',
                'description' => sprintf( __( 'More Color Options: %1$sKnow More.%2$s', 'hotell' ), '<a href="' . esc_url( 'https://glthemes.com/wordpress-theme/hotell-pro/' ) . '" target="_blank">', '</a>' ),
			)
		)
    );

	$wp_customize->add_section( 
        'typo_settings', 
        array(
            'title'       => __( 'Typography Settings', 'hotell' ),
            'priority'    => 100,
			'panel'	      => 'appearance_settings'
        ) 
    );

	$wp_customize->add_setting(
        'typo_note_control',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );

    $wp_customize->add_control(
        new Hotell_Note_Control( 
			$wp_customize,
			'typo_note_control',
			array(
				'section'	  => 'typo_settings',
                'description' => sprintf( __( 'More Typography Options: %1$sKnow More.%2$s', 'hotell' ), '<a href="' . esc_url( 'https://glthemes.com/wordpress-theme/hotell-pro/' ) . '" target="_blank">', '</a>' ),
			)
		)
    );
    
}
endif;
add_action( 'customize_register', 'hotell_customize_register' );