<?php
/**
 * About Section Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_home_about_settings' ) ) :

function hotell_customize_register_home_about_settings( $wp_customize ) {
    
    /** About Section Settings */
    $wp_customize->add_section(
        'about_section',
        array(
            'title'    => __( 'About Section', 'hotell' ),
            'priority' => 20,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable About section */
    $wp_customize->add_setting(
        'ed_about_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_about_section',
            array(
                'section'       => 'about_section',
                'label'         => __( 'Enable About Section', 'hotell' ),
            )
        )
    );
        
    /** Subtitle Text */
    $wp_customize->add_setting( 
        'about_subtitle', 
        array(
            'default'           => esc_html__( 'ABOUT US', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
        'about_subtitle',
        array(
            'section'         => 'about_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );
    
    $wp_customize->selective_refresh->add_partial( 'about_subtitle', array(
        'selector'          => '.home .about .section-header span.section-header__tag',
        'render_callback'   => 'hotell_get_about_subtitle',
    ) );

    /** Title Text */
    $wp_customize->add_setting( 
        'about_title', 
        array(
            'default'           => esc_html__( 'Delicious Interior With The Pinch Of Everything', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
        'about_title',
        array(
            'section'         => 'about_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->selective_refresh->add_partial( 'about_title', array(
        'selector'          => '.home .about .section-header h2.section-header__title',
        'render_callback'   => 'hotell_get_about_title',
    ) );

    /** Content Text */
    $wp_customize->add_setting( 
        'about_content', 
        array(
            'default'           => '', 
            'sanitize_callback' => 'wp_kses_post',
        ) 
    );
    
    $wp_customize->add_control(
        'about_content',
        array(
            'section'         => 'about_section',
            'label'           => __( 'Section Content', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->add_setting(
        'abt_btn_lbl',
        array(
            'default'           => esc_html__( 'Learn More', 'hotell' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'abt_btn_lbl',
        array(
            'type'            => 'text',
            'section'         => 'about_section',
            'label'           => __( 'Button label', 'hotell' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'abt_btn_lbl', array(
        'selector'          => '.home .about a.btn-primary',
        'render_callback'   => 'hotell_get_abt_btn_lbl',
    ) );

    $wp_customize->add_setting(
        'abt_btn_link',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'abt_btn_link',
        array(
            'label'           => __( 'Button Link', 'hotell' ),
            'section'         => 'about_section',
            'type'            => 'url',
        )
    );

    $wp_customize->add_setting(
        'abt_image_one',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'abt_image_one',
            array(
                'label'           => __( 'Upload Image One', 'hotell' ),
                'section'         => 'about_section',
            )
        )
    );

}
endif;
add_action( 'customize_register', 'hotell_customize_register_home_about_settings' );