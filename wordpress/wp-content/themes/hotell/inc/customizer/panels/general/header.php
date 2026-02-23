<?php
/**
 * Header Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_general_header' ) ) :

function hotell_customize_register_general_header( $wp_customize ) {   
    
    /** Header Settings */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'hotell' ),
            'priority' => 20,
            'panel'    => 'general_settings',
        )
    );

    /** Location  */
    $wp_customize->add_setting(
        'header_location',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) 
    );

    $wp_customize->add_control(
        'header_location',
        array(
            'label'       => __( 'Location', 'hotell' ),
            'section'     => 'header_settings',
            'type'        => 'text',
        )
    );

    /** Email */
    $wp_customize->add_setting(
        'email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
        )
    );
    

    $wp_customize->add_control(
        'email',
        array(
            'label'       => __( 'Email', 'hotell' ),
            'description' => __( 'Add email in header.', 'hotell' ),
            'section'     => 'header_settings',
            'type'        => 'text',
        )
    );

    $wp_customize->add_setting(
        'header_btn_lbl',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'header_btn_lbl',
        array(
            'label'             => __( 'Top Header Button Label', 'hotell' ),
            'section'           => 'header_settings',
            'type'              => 'text',
        )
    );

    $wp_customize->add_setting(
        'header_btn_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'header_btn_link',
        array(
            'label'           => __( 'Top Header Button Link', 'hotell' ),
            'section'         => 'header_settings',
            'type'            => 'url',
        )
    );

    $wp_customize->add_setting(
        'header_new_tab',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Hotell_Toggle_Control( 
			$wp_customize,
			'header_new_tab',
			array(
				'section'         => 'header_settings',
				'label'           => __( 'Show link in a new tab', 'hotell' ),
			)
		)
    );
}
endif;
add_action( 'customize_register', 'hotell_customize_register_general_header' );