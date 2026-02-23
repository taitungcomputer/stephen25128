<?php
/**
 * Contact Page Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_contact_map' ) ) :

function hotell_customize_register_contact_map( $wp_customize ) {
    
    /** Google Map Settings */
    $wp_customize->add_section(
        'google_map_settings',
        array(
            'title'    => __( 'Google Map Settings', 'hotell' ),
            'priority' => 20,
            'panel'    => 'contact_page_setting',
        )
    );
    
    /** Enable Google Map */
    $wp_customize->add_setting(
        'ed_google_map',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Hotell_Toggle_Control( 
			$wp_customize,
			'ed_google_map',
			array(
				'section'	  => 'google_map_settings',
				'label'		  => __( 'Enable Google Map', 'hotell' ),
				'description' => __( 'If disabled the featured image of the page will be displayed if set.', 'hotell' ),
			)
		)
	);
    
    /** Google Map Iframe  */
    $wp_customize->add_setting(
        'google_map',
        array(
            'default'           => '',
            'sanitize_callback' => 'hotell_sanitize_google_map_iframe',
        )
    );
    
    $wp_customize->add_control(
        'google_map',
        array(
            'label'       => __( 'Google Map Iframe', 'hotell' ),
            'section'     => 'google_map_settings',
            'type'        => 'text',                                 
        )
    );
        
}
endif;
add_action( 'customize_register', 'hotell_customize_register_contact_map' );