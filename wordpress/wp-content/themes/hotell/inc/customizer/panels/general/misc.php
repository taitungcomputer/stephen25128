<?php
/**
 * Miscellaneous Settings
 *
 * @package Hotell
 */
if ( ! function_exists( 'hotell_customize_register_general_misc' ) ) :

function hotell_customize_register_general_misc( $wp_customize ) {
    
    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __( 'Misc Settings', 'hotell' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );

	/** Enable Author Image */
    $wp_customize->add_setting(
        'ed_author_img',
        array(
            'default'           => false,
            'sanitize_callback' => 'hotell_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Hotell_Toggle_Control( 
            $wp_customize,
            'ed_author_img',
            array(
                'section'       => 'misc_settings',
                'label'         => __( 'Enable Author Image in logos', 'hotell' ),
            )
        )
    );

	/** 404 Image */
	$wp_customize->add_setting( 
		'404_image', 
		array(
			'default' 			=> '',
			'sanitize_callback' => 'esc_url_raw'
    	)
	);
 
    $wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'404_image', 
			array(
				'label'      => __( 'Upload an image for error page', 'hotell' ),
				'section'    => 'misc_settings',
			)
    	)
	);
        
}
endif;
add_action( 'customize_register', 'hotell_customize_register_general_misc' );