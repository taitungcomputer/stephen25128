<?php
/**
 * Homepage Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_homepage_settings' ) ) :

function hotell_customize_register_homepage_settings( $wp_customize ) {
    
    /** Homepage Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 45,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Frontpage Settings', 'hotell' ),
        ) 
    );
}
endif;
add_action( 'customize_register', 'hotell_customize_register_homepage_settings' );