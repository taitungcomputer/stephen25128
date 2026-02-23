<?php
/**
 * Cta Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_home_cta' ) ) :

function hotell_customize_register_home_cta( $wp_customize ){

    /** CTA Section Settings  */
    $wp_customize->add_section(
        'cta_section',
        array(
            'title'    => __( 'CTA Section', 'hotell' ),
            'priority' => 20,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable section */
    $wp_customize->add_setting(
        'ed_cta_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_cta_section',
            array(
                'section'       => 'cta_section',
                'label'         => __( 'Enable CTA Section', 'hotell' ),
            )
        )
    );

    /** Title Text */
    $wp_customize->add_setting( 
        'cta_title', 
        array(
            'default'           => esc_html__( 'Make room for adventure', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'			=> 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        'cta_title',
        array(
            'section'         => 'cta_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->selective_refresh->add_partial( 'cta_title', array(
        'selector'        => '.home .cta-image .section-header h2.section-header__title',
        'render_callback' => 'hotell_get_cta_title',
    ) );

    /** Description Text */
    $wp_customize->add_setting( 
        'cta_subtitle', 
        array(
            'default'           => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id parturient aliquam egestas auctor in volutpat nulla purus.', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'			=> 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        'cta_subtitle',
        array(
            'section'         => 'cta_section',
            'label'           => __( 'Section Subtitle', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->selective_refresh->add_partial( 'cta_subtitle', array(
        'selector'        => '.home .cta-image .section-header span.section-subtitle',
        'render_callback' => 'hotell_get_cta_subtitle',
    ) );

    /** Contact Button Label */
    $wp_customize->add_setting(
        'cta_contact_lbl',
        array(
            'default'           => esc_html__( 'Online Booking', 'hotell' ),
            'sanitize_callback' => 'sanitize_text_field', 
            'transport'			=> 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'cta_contact_lbl',
        array(
            'type'            => 'text',
            'section'         => 'cta_section',
            'label'           => __( 'Button Label', 'hotell' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'cta_contact_lbl', array(
        'selector'        => '.home .cta-image .cta-image__content a.btn-primary',
        'render_callback' => 'hotell_get_cta_contact_lbl',
    ) );

    /** View More Link */
    $wp_customize->add_setting(
        'cta_contact_link',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'cta_contact_link',
        array(
            'label'           => __( 'Button Link', 'hotell' ),
            'section'         => 'cta_section',
            'type'            => 'url',
        )
    );

    $wp_customize->add_setting( 
        'cta_new_tab', 
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'cta_new_tab',
            array(
                'section'     => 'cta_section',
                'label'       => __( 'Enable to open link in a new tab', 'hotell' ),
            )
        )
    );

    /** CTA Background Image */
	$wp_customize->add_setting( 
		'cta_background_image', 
		array(
			'default' 			=> '',
			'sanitize_callback' => 'esc_url_raw'
    	)
	);
 
    $wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'cta_background_image', 
			array(
				'label'      => __( 'Upload a background image', 'hotell' ),
				'section'    => 'cta_section',
			)
    	)
	);

}
endif;
add_action( 'customize_register', 'hotell_customize_register_home_cta' );