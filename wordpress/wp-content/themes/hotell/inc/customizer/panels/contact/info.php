<?php
/**
 * Contact Form Settings
 * 
 * @package Hotell
 */

if ( ! function_exists( 'hotell_contact_page_info' ) ) :

function hotell_contact_page_info( $wp_customize ){
    
	$wp_customize->add_section( 'contact_info_section', 
	    array(
	        'title'         => esc_html__( 'Contact Details Section', 'hotell' ),
	        'priority'      => 10,
            'panel'         => 'contact_page_setting',
	    ) 
	);

	 /** Title Text */
    $wp_customize->add_setting( 
        'contact_title', 
        array(
            'default'           => '', 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'			=> 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        'contact_title',
        array(
            'section'         => 'contact_info_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );

	$wp_customize->selective_refresh->add_partial( 'contact_title', array(
        'selector'        => '.page-template-contact .contact h2.section-header__title',
        'render_callback' => 'hotell_contact_title',
    ) );

	/** Subtitle Text */
    $wp_customize->add_setting( 
        'contact_subtitle', 
        array(
            'default'           => '', 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'			=> 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        'contact_subtitle',
        array(
            'section'         => 'contact_info_section',
            'label'           => __( 'Section Subtitle', 'hotell' ),
            'type'            => 'text',
        )   
    );

	$wp_customize->selective_refresh->add_partial( 'contact_subtitle', array(
        'selector'        => '.page-template-contact .contact span.section-header__tag',
        'render_callback' => 'hotell_contact_subtitle',
    ) );

	/** Content Text */
    $wp_customize->add_setting( 
        'contact_content', 
        array(
            'default'           => '', 
            'sanitize_callback' => 'wp_kses_post',
        ) 
    );
    
    $wp_customize->add_control(
        'contact_content',
        array(
            'section'         => 'contact_info_section',
            'label'           => __( 'Section Content', 'hotell' ),
            'type'            => 'textarea',
        )   
    );

    $wp_customize->add_setting(
		'phone_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'phone_title',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Phone Us Title', 'hotell' ),
			'type'              => 'text',
		)
	);

	$wp_customize->selective_refresh->add_partial( 'phone_title', array(
        'selector'        => '.page-template-contact .contact .contact__wrapper h5.contact-title.phone',
        'render_callback' => 'hotell_phone_title',
    ) );

	$wp_customize->add_setting(
		'phone_number',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control(
		'phone_number',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Phone Number', 'hotell' ),
			'description'       => __( 'You can add multiple phone number seperating with comma', 'hotell' ),
			'type'              => 'text',
		)
	);

    $wp_customize->add_setting(
		'mail_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'mail_title',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Mail Title', 'hotell' ),
			'type'              => 'text',
		)
	);

	$wp_customize->selective_refresh->add_partial( 'mail_title', array(
        'selector'        => '.page-template-contact .contact .contact__wrapper h5.contact-title.email',
        'render_callback' => 'hotell_mail_title',
    ) );

	$wp_customize->add_setting(
		'mail_description',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	
	$wp_customize->add_control(
		'mail_description',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Email Address', 'hotell' ),
			'description'		=> __( 'You can add multiple emails by seperating it with comma. For example: xyz@gmail.com, abc@yahoo.com', 'hotell' ), 
			'type'              => 'text',
		)
	);

	$wp_customize->add_setting(
		'location_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'location_title',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Location Title', 'hotell' ),
			'type'              => 'text',
		)
	);

	$wp_customize->selective_refresh->add_partial( 'location_title', array(
        'selector'        => '.page-template-contact .contact .contact__wrapper h5.contact-title.location',
        'render_callback' => 'hotell_location_title',
    ) );

	$wp_customize->add_setting(
		'location',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control(
		'location',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Location Description', 'hotell' ),
			'type'              => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'contact_hours',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'contact_hours',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Contact Timing Title', 'hotell' ),
			'type'              => 'text',
		)
	);

	$wp_customize->selective_refresh->add_partial( 'contact_hours', array(
        'selector'        => '.page-template-contact .contact .contact__wrapper h5.contact-title.timing',
        'render_callback' => 'hotell_contact_hours',
    ) );

	$wp_customize->add_setting(
		'contact_hrs_content',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control(
		'contact_hrs_content',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Contact Timing Content', 'hotell' ),
			'description'       => __( 'You can add multiple contact hours seperating with comma. For example: Monday - Friday: 09.00 - 20.00, Sunday & Saturday: 10.30 - 22.30', 'hotell' ),
			'type'              => 'text',
		)
	);

	/** Enable Social */
    $wp_customize->add_setting(
        'ed_social_contact',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_social_contact',
            array(
                'section'       => 'contact_info_section',
                'label'         => __( 'Enable Social Section', 'hotell' ),
            )
        )
    );

	$wp_customize->add_setting(
		'social_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'social_title',
		array(
			'section'           => 'contact_info_section',
			'label'             => __( 'Social Title', 'hotell' ),
			'type'              => 'text',
		)
	);

	$wp_customize->selective_refresh->add_partial( 'social_title', array(
        'selector'        => '.page-template-contact .contact .contact__wrapper .social-networks h4',
        'render_callback' => 'hotell_social_title',
    ) );
}
endif;
add_action( 'customize_register', 'hotell_contact_page_info' );