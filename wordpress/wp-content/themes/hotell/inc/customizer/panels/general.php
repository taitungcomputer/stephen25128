<?php
/**
 * General Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_general' ) ) :

function hotell_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'hotell' ),
            'description' => __( 'Customize Banner, Social, SEO, Post/Page, and Miscellaneous settings.', 'hotell' ),
        ) 
    );
    
    $wp_customize->get_section( 'header_image' )->panel                    = 'frontpage_settings';
    $wp_customize->get_section( 'header_image' )->title                    = __( 'Banner Section', 'hotell' );
    $wp_customize->get_section( 'header_image' )->priority                 = 10;
    $wp_customize->get_control( 'header_image' )->active_callback          = 'hotell_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback          = 'hotell_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'hotell_banner_ac';
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport                = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport                = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport       = 'refresh';
    
    /** Banner Options */
    $wp_customize->add_setting(
		'ed_banner_section',
		array(
			'default'			=> 'static_banner',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'ed_banner_section',
        array(
            'label'	      => __( 'Banner Options', 'hotell' ),
            'description' => __( 'Choose banner as static image/video or as a slider.', 'hotell' ),
            'section'     => 'header_image',
            'type'        => 'select',
            'choices'     => array(
                'no_banner'        => __( 'Disable Banner Section', 'hotell' ),
                'static_banner'    => __( 'Static/Video CTA Banner', 'hotell' ),
            ),
            'priority' => 5	
        )            
	);
    
    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_title',
        array(
            'label'           => __( 'Title', 'hotell' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'hotell_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_title', array(
        'selector' => '.home .banner .banner__wrap h2.banner__title',
        'render_callback' => 'hotell_get_banner_title',
    ) );
    
    /** Sub Title */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label'           => __( 'Sub Title', 'hotell' ),
            'section'         => 'header_image',
            'type'            => 'textarea',
            'active_callback' => 'hotell_banner_ac'
        )
    );

    $wp_customize->add_setting(
        'banner_caption_overlay',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Hotell_Toggle_Control( 
			$wp_customize,
			'banner_caption_overlay',
			array(
				'section'         => 'header_image',
				'label'           => __( 'Add overlay for caption', 'hotell' ),
			)
		)
    );

    /** Read More Text */
    $wp_customize->add_setting(
        'slider_btn_lbl',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'slider_btn_lbl',
        array(
            'type'            => 'text',
            'section'         => 'header_image',
            'label'           => __( 'Banner Button label', 'hotell' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'slider_btn_lbl', array(
        'selector' => '.home .banner .banner__wrap .btn-wrap a.btn-primary',
        'render_callback' => 'hotell_get_slider_btn_lbl',
    ) );

    $wp_customize->add_setting(
        'slider_btn_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'slider_btn_link',
        array(
            'label'           => __( 'Banner Button Link', 'hotell' ),
            'section'         => 'header_image',
            'type'            => 'text',
        )
    );

    $wp_customize->add_setting(
        'slider_readmore',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'slider_readmore',
        array(
            'type'            => 'text',
            'section'         => 'header_image',
            'label'           => __( 'Banner Button Two', 'hotell' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'slider_readmore', array(
        'selector'        => '.home .banner .banner__wrap .btn-wrap a.btn-outline',
        'render_callback' => 'hotell_get_slider_readmore',
    ) );

    $wp_customize->add_setting(
        'banner_readmore_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'banner_readmore_link',
        array(
            'label'           => __( 'Banner Button Link Two', 'hotell' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'hotell_banner_ac'
        )
    );

    $wp_customize->add_setting(
        'slider_btn_new_tab',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Hotell_Toggle_Control( 
			$wp_customize,
			'slider_btn_new_tab',
			array(
				'section'     => 'header_image',
				'label'       => __( 'Open in a new tab', 'hotell' ),
                'description' => __( 'Enable to open the link in a new tab.', 'hotell' ),
                'active_callback' => 'hotell_banner_ac'
			)
		)
	);
    
}
endif;
add_action( 'customize_register', 'hotell_customize_register_general' );