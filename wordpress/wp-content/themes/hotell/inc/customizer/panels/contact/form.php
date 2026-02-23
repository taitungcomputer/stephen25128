<?php
/**
 * Contact Form Settings
 * 
 * @package Hotell
 */

if ( ! function_exists( 'hotell_contact_page_form' ) ) :

function hotell_contact_page_form( $wp_customize ){
    
	$wp_customize->add_section( 'contact_page_form', 
	    array(
	        'title'         => esc_html__( 'Contact Form Section', 'hotell' ),
	        'priority'      => 20,
            'panel'         => 'contact_page_setting',
	    ) 
	);

	$wp_customize->add_setting(
		'contact_form_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	
	$wp_customize->add_control(
		'contact_form_shortcode',
		array(
			'section'           => 'contact_page_form',
			'label'             => __( 'Contact Form Shortcode', 'hotell' ),
            'description'       => __( 'Please generate the shortcode from contact form 7 widget', 'hotell' ),
			'type'              => 'text',
		)
	);
}
endif;
add_action( 'customize_register', 'hotell_contact_page_form' );