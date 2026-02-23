<?php
/**
 * Video Block Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_home_video_block' ) ) :

function hotell_customize_register_home_video_block( $wp_customize ){

    /** Video Block Section Settings  */
    $wp_customize->add_section(
        'video_block_section',
        array(
            'title'    => __( 'Video Block Section', 'hotell' ),
            'priority' => 80,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable Video section */
    $wp_customize->add_setting(
        'ed_video_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_video_section',
            array(
                'section'       => 'video_block_section',
                'label'         => __( 'Enable Video Section', 'hotell' ),
            )
        )
    );

    /** Title Text */
    $wp_customize->add_setting( 
        'video_block_title', 
        array(
            'default'           => esc_html__( 'Relax & Enjoy with us your holidays', 'hotell' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'			=> 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        'video_block_title',
        array(
            'section'         => 'video_block_section',
            'label'           => __( 'Section Title', 'hotell' ),
            'type'            => 'text',
        )   
    );

    $wp_customize->selective_refresh->add_partial( 'video_block_title', array(
        'selector'        => '.home .video-block .video-block__wrap .video-block__text h2',
        'render_callback' => 'hotell_get_video_block_title',
    ) );

    // Video block link
    $wp_customize->add_setting(
        'video_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'video_link',
        array(
            'label'           => __( 'Enter Video Link', 'hotell' ),
            'section'         => 'video_block_section',
            'type'            => 'url',
        )
    );

    $wp_customize->add_setting( 
		'video_block_img', 
		array(
			'default' 			=> '',
			'sanitize_callback' => 'esc_url_raw'
    	)
	);
 
    $wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'video_block_img', 
			array(
				'label'      => __( 'Upload a background image', 'hotell' ),
				'section'    => 'video_block_section',
			)
    	)
	);

}
endif;
add_action( 'customize_register', 'hotell_customize_register_home_video_block' );