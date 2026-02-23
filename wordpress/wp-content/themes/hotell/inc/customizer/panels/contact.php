<?php
/**
 * Contact Page Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_contact' ) ) :

function hotell_customize_register_contact( $wp_customize ) {
    
    $wp_customize->add_panel( 
        'contact_page_setting', 
        array(
            'title'       => __( 'Contact Page Settings', 'hotell' ),
            'priority'    => 65,
            'capability'  => 'edit_theme_options',
            'description' => __( 'Contact Form, Google Map and Contact Details settings.', 'hotell' ),
        ) 
    );
        
}
endif;
add_action( 'customize_register', 'hotell_customize_register_contact' );