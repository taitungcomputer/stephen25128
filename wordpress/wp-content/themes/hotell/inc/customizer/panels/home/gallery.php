<?php
/**
 * Gallery Section Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_home_gallery_settings' ) ) :

function hotell_customize_register_home_gallery_settings( $wp_customize ) {
    
    /** Gallery Section Settings */
    $wp_customize->add_section(
        'gallery_section',
        array(
            'title'    => __( 'Gallery Section', 'hotell' ),
            'priority' => 25,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable Blog section */
    $wp_customize->add_setting(
        'ed_gallery_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_gallery_section',
            array(
                'section'       => 'gallery_section',
                'label'         => __( 'Enable Gallery Section', 'hotell' ),
            )
        )
    );

    /** Subtitle Text */
    $wp_customize->add_setting( 
        'gallery_subtitle', 
        array(
            'default'           => esc_html__( 'OUR COLLECTION', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
        'gallery_subtitle',
        array(
            'section'         => 'gallery_section',
            'label'           => __( 'Section Subtitle', 'hotell' ),
            'type'            => 'text',
        )   
    );
    
    $wp_customize->selective_refresh->add_partial( 'gallery_subtitle', array(
        'selector'          => '.home .gallery-archive .section-header span.section-header__tag',
        'render_callback'   => 'hotell_get_gallery_subtitle',
    ) );

    /** Title Text */
    $wp_customize->add_setting( 
        'gallery_title', 
        array(
            'default'           => esc_html__( 'Our Featured Gallery', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
        'gallery_title',
        array(
            'section'         => 'gallery_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->selective_refresh->add_partial( 'gallery_title', array(
        'selector'          => '.home .gallery-archive .section-header h2.section-header__title',
        'render_callback'   => 'hotell_get_gallery_title',
    ) );

    /** Content Text */
    $wp_customize->add_setting( 
        'gallery_content', 
        array(
            'default'           => '', 
            'sanitize_callback' => 'wp_kses_post',
        ) 
    );
    
    $wp_customize->add_control(
        'gallery_content',
        array(
            'section'         => 'gallery_section',
            'label'           => __( 'Section Content', 'hotell' ),
            'type'            => 'textarea',
        )   
    );

    $wp_customize->add_setting(
		'gallery_select_one',
		array(
			'default'			=> '',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'gallery_select_one',
        array(
            'label'	      => __( 'Gallery Select One', 'hotell' ),
            'section'     => 'gallery_section',
            'type'        => 'select',
            'choices'     => hotell_get_posts(),
        )            
	);

    $wp_customize->add_setting(
		'gallery_select_two',
		array(
			'default'			=> '',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'gallery_select_two',
        array(
            'label'	      => __( 'Gallery Select Two', 'hotell' ),
            'section'     => 'gallery_section',
            'type'        => 'select',
            'choices'     => hotell_get_posts(),
        )            
	);

    $wp_customize->add_setting(
		'gallery_select_three',
		array(
			'default'			=> '',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'gallery_select_three',
        array(
            'label'	      => __( 'Gallery Select Three', 'hotell' ),
            'section'     => 'gallery_section',
            'type'        => 'select',
            'choices'     => hotell_get_posts(),
        )            
	);

    $wp_customize->add_setting(
		'gallery_select_four',
		array(
			'default'			=> '',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'gallery_select_four',
        array(
            'label'	      => __( 'Gallery Select Four', 'hotell' ),
            'section'     => 'gallery_section',
            'type'        => 'select',
            'choices'     => hotell_get_posts(),
        )            
	);

    $wp_customize->add_setting(
		'gallery_select_five',
		array(
			'default'			=> '',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'gallery_select_five',
        array(
            'label'	      => __( 'Gallery Select Five', 'hotell' ),
            'section'     => 'gallery_section',
            'type'        => 'select',
            'choices'     => hotell_get_posts(),
        )            
	);
    
}
endif;
add_action( 'customize_register', 'hotell_customize_register_home_gallery_settings' );