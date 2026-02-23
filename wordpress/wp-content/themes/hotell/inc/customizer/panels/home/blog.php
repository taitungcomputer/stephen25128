<?php
/**
 * Blog Settings For Homepage
 * 
 * @package Hotell
 */

if ( ! function_exists( 'hotell_customize_register_home_blog_section' ) ) :

function hotell_customize_register_home_blog_section( $wp_customize ){
    
	$wp_customize->add_section( 
        'blog_sec_home', 
	    array(
	        'title'         => esc_html__( 'Blog Section', 'hotell' ),
	        'priority'      => 140,
	        'panel'         => 'frontpage_settings'
	    ) 
	);

    /** Enable Blog section */
    $wp_customize->add_setting(
        'ed_blog_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_blog_section',
            array(
                'section'       => 'blog_sec_home',
                'label'         => __( 'Enable Blog Section', 'hotell' ),
            )
        )
    );

    $wp_customize->add_setting(
        'blog_subtitle',
        array(
            'default'           => __( 'OUR BLOG', 'hotell' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_subtitle',
        array(
            'section'           => 'blog_sec_home',
            'label'             => __( 'Section Subtitle', 'hotell' ),
            'type'              => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_subtitle', array(
        'selector'        => '.home .news-and-blogs .container .section-header span.section-header__tag',
        'render_callback' => 'hotell_get_blog_subtitle',
    ) );

    $wp_customize->add_setting(
        'blog_title',
        array(
            'default'           => __( 'Our News And Blogs', 'hotell' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_title',
        array(
            'section'           => 'blog_sec_home',
            'label'             => __( 'Section Title', 'hotell' ),
            'type'              => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_title', array(
        'selector'        => '.home .news-and-blogs .container .section-header h2.section-header__title',
        'render_callback' => 'hotell_get_blog_title',
    ) );

    /** Content Text */
    $wp_customize->add_setting( 
        'blog_content', 
        array(
            'default'           => '', 
            'sanitize_callback' => 'sanitize_text_field',
        ) 
    );
    
    $wp_customize->add_control(
        'blog_content',
        array(
            'section'         => 'blog_sec_home',
            'label'           => __( 'Section Content', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->add_setting(
        'blog_btn_lbl',
        array(
            'default'           => esc_html__( 'Read More', 'hotell' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_btn_lbl',
        array(
            'type'            => 'text',
            'section'         => 'blog_sec_home',
            'label'           => __( 'Button label', 'hotell' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_btn_lbl', array(
        'selector'          => '.home .news-and-blogs .container .card a.btn-text',
        'render_callback'   => 'hotell_get_blog_btn_lbl',
    ) );

}
endif;
add_action( 'customize_register', 'hotell_customize_register_home_blog_section' );