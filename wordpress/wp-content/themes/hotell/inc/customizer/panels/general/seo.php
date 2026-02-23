<?php
/**
 * SEO Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_general_seo' ) ) :

function hotell_customize_register_general_seo( $wp_customize ) {
    
    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'hotell' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'hotell_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Hotell_Toggle_Control( 
			$wp_customize,
			'ed_breadcrumb',
			array(
				'section'     => 'seo_settings',
				'label'	      => __( 'Enable Breadcrumb', 'hotell' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'hotell' ),
			)
		)
	);
    
    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'hotell' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'hotell' ),
        )
    );  

}
endif;
add_action( 'customize_register', 'hotell_customize_register_general_seo' );