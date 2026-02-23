<?php
/**
 * Appearance Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_appearance_settings' ) ) :

function hotell_customize_register_appearance_settings( $wp_customize ) {

    $wp_customize->get_section( 'colors' )->panel               = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->panel     = 'appearance_settings';
    
    $wp_customize->add_panel( 
        'appearance_settings', 
        array(
            'title'       => __( 'Appearance Settings', 'hotell' ),
            'priority'    => 25,
            'capability'  => 'edit_theme_options',
            'description' => __( 'Change color and body background.', 'hotell' ),
        ) 
    );

}
endif;
add_action( 'customize_register', 'hotell_customize_register_appearance_settings' );