<?php
/**
 * Footer Top Section Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_home_footer_top_settings' ) ) :

function hotell_customize_register_home_footer_top_settings( $wp_customize ) {
    
    /** Footer Top Section Settings */
    $wp_customize->add_section(
        'footer_top_section',
        array(
            'title'    => __( 'Footer Top Section', 'hotell' ),
            'priority' => 150,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable Footer Top section */
    $wp_customize->add_setting(
        'ed_footer_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_footer_section',
            array(
                'section'       => 'footer_top_section',
                'label'         => __( 'Enable Footer Top Section', 'hotell' ),
            )
        )
    );

    /** Title Text */
    $wp_customize->add_setting( 
        'footer_top_title', 
        array(
            'default'           => esc_html__( 'Book With a Hotel Specialist On', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
        'footer_top_title',
        array(
            'section'         => 'footer_top_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->selective_refresh->add_partial( 'footer_top_title', array(
        'selector'          => '.home .amenities .container .section-header h2.section-header__title',
        'render_callback'   => 'hotell_get_footer_top_title',
    ) );

    /** Footer Top */
    $wp_customize->add_setting( 
        new Hotell_Repeater_Setting( 
            $wp_customize, 
            'footer_top_repeater', 
            array(
                'default'           => '',
                'sanitize_callback' => array( 'Hotell_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
		new Hotell_Control_Repeater(
			$wp_customize,
			'footer_top_repeater',
			array(
				'section' => 'footer_top_section',				
				'label'	  => __( 'Travel Platforms', 'hotell' ),
				'fields'  => array(
                    'image' => array(
                        'type'    => 'image',
                        'label'   => __( 'Select Image', 'hotell' ),
					),
                    'link' => array(
                        'type'    => 'url',
                        'label'   => __( 'Link', 'hotell' ),
                        'description' => __( 'Example: https://facebook.com', 'hotell' ),
                    ),
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => esc_html__( 'links', 'hotell' ),
                    'field' => 'link'
                ),                      
			)
		)
	);

    $wp_customize->add_setting( 
        'footer_top_new_tab', 
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'footer_top_new_tab',
            array(
                'section'     => 'footer_top_section',
                'label'       => __( 'Enable to open link in a new tab', 'hotell' ),
            )
        )
    );
}
endif;
add_action( 'customize_register', 'hotell_customize_register_home_footer_top_settings' );