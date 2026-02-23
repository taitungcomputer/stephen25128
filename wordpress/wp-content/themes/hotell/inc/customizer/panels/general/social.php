<?php
/**
 * Social Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_general_social' ) ) :

function hotell_customize_register_general_social( $wp_customize ) {
    
    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'hotell' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Hotell_Toggle_Control( 
			$wp_customize,
			'ed_social_links',
			array(
				'section'     => 'social_media_settings',
				'label'	      => __( 'Enable Social Links', 'hotell' ),
                'description' => __( 'Enable to show social links at header.', 'hotell' ),
			)
		)
	);
    
    $wp_customize->add_setting( 
        new Hotell_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Hotell_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
		new Hotell_Control_Repeater(
			$wp_customize,
			'social_links',
			array(
				'section' => 'social_media_settings',				
				'label'	  => __( 'Social Links', 'hotell' ),
				'fields'  => array(
                    'hp_icon' => array(
                        'type'        => 'select',
                        'label'       => esc_html__( 'Social Media', 'hotell' ),
                        'choices'     => hotell_get_svg_icons()
                    ),
                    'hp_link' => array(
                        'type'        => 'url',
                        'label'       => esc_html__( 'Link', 'hotell' ),
                        'description' => esc_html__( 'Example: https://facebook.com', 'hotell' ),
                    ),
                    'hp_checkbox' => array(
                        'type'        => 'checkbox',
                        'label'       => esc_html__( 'Open link in new tab', 'hotell' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'hotell' ),
                    'field' => 'link'
                )                        
			)
		)
	);
    /** Social Media Settings Ends */
    
}
endif;
add_action( 'customize_register', 'hotell_customize_register_general_social' );