<?php 
/**
 * Information links.
 * 
 * It's a pluggable function inherited from parent theme
*/
function hotell_customizer_theme_info( $wp_customize ) {

	$wp_customize->add_section(
		'theme_info',
		array(
			'title'    => __( 'Information Links', 'cottageinn' ),
			'priority' => 6,
		)
	);

	/** Important Links */
	$wp_customize->add_setting(
		'theme_info_theme',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$theme_info  = '<ul>';
	$theme_info .= sprintf( __( '<li>View demo: %1$sClick here.%2$s</li>', 'cottageinn' ), '<a href="' . esc_url( 'https://glthemes.com/live-demo/?theme=cottageinn' ) . '" target="_blank">', '</a>' );
	$theme_info .= sprintf( __( '<li>View documentation: %1$sClick here.%2$s</li>', 'cottageinn' ), '<a href="' . esc_url( 'https://glthemes.com/documentation/resort-one/' ) . '" target="_blank">', '</a>' );
	$theme_info .= sprintf( __( '<li>Theme info: %1$sClick here.%2$s</li>', 'cottageinn' ), '<a href="' . esc_url( 'https://glthemes.com/wordpress-themes/cottageinn/' ) . '" target="_blank">', '</a>' );
	$theme_info .= sprintf( __( '<li>Support ticket: %1$sClick here.%2$s</li>', 'cottageinn' ), '<a href="' . esc_url( 'https://glthemes.com/support/' ) . '" target="_blank">', '</a>' );
	$theme_info .= sprintf( __( '<li>More WordPress Themes: %1$sClick here.%2$s</li>', 'cottageinn' ), '<a href="' . esc_url( 'https://glthemes.com/wordpress-theme/' ) . '" target="_blank">', '</a>' );
	$theme_info .= sprintf( __( '<li>Go Premium: %1$sClick here.%2$s</li>', 'cottageinn' ), '<a href="' . esc_url( 'https://glthemes.com/wordpress-theme/hotell-pro/' ) . '" target="_blank">', '</a>' );
	$theme_info .= '</ul>';

	$wp_customize->add_control(
		new Hotell_Note_Control(
			$wp_customize,
			'theme_info_theme',
			array(
				'label'       => __( 'Important Links', 'cottageinn' ),
				'section'     => 'theme_info',
				'description' => $theme_info,
			)
		)
	);
}

function cottageinn_customizer_controls( $wp_customize ){

    $wp_customize->add_setting(
		'gallery_select_six',
		array(
			'default'			=> '',
			'sanitize_callback' => 'hotell_sanitize_select'
		)
	);

	$wp_customize->add_control(
        'gallery_select_six',
        array(
            'label'	      => __( 'Gallery Select Six', 'cottageinn' ),
            'section'     => 'gallery_section',
            'type'        => 'select',
            'choices'     => hotell_get_posts(),
        )            
	);

      //Changing the Piorities
    $wp_customize->get_section( 'cta_section' )->priority = 40;
    $wp_customize->get_section( 'video_block_section' )->priority = 20;
 
    //Changing the text to textarea of about us section
    $wp_customize->get_control( 'about_content' )->type    = 'textarea';
   
    //banner default values set true
    $wp_customize->get_setting( 'ed_blog_section' )->default = true;

    // Changing/adding default values
    $wp_customize->get_control( 'ed_footer_section' )->label     = esc_html__( 'Enable Why Us Section', 'cottageinn' );
    $wp_customize->get_control( 'about_subtitle' )->label        = esc_html__( 'Section Subtitle', 'cottageinn' );

    //Adding the Default values For the Banner
	$wp_customize->get_setting( 'banner_subtitle' )->default      = esc_html__( 'WELCOME TO OUR COTTAGE', 'cottageinn' );
    $wp_customize->get_setting( 'banner_title' )->default         = esc_html__( 'Find Your Cozy Retreat in Nature\'s Embrace', 'cottageinn' );
    $wp_customize->get_setting( 'slider_readmore' )->default      = esc_html__( "Learn More", "cottageinn" );
    $wp_customize->get_setting( 'banner_readmore_link' )->default = "#";
    $wp_customize->get_setting( 'slider_btn_lbl' )->default       = esc_html__( "Take A Tour", "cottageinn" );
    $wp_customize->get_setting( 'slider_btn_link' )->default      = "#";

    //Adding the Default values For the about us
    $wp_customize->get_setting( 'about_title' )->default          = esc_html__( "Discover the Heart and Soul Behind Our Cottages", "cottageinn" );

    //Adding the Default values For the video 
    $wp_customize->get_setting( 'video_block_title' )->default    = esc_html__( "Experience the Magic of Our Cottages", "cottageinn" );

    //Adding the Default values For the gallery 
    $wp_customize->get_setting( 'gallery_subtitle' )->default     = esc_html__( "Our Gallery", "cottageinn" );
    $wp_customize->get_setting( 'gallery_title' )->default        = esc_html__( "A Glimpse of Serenity", "cottageinn" );

    //Adding the Default values For the cta 
    $wp_customize->get_setting( 'cta_title' )->default            = esc_html__( "Ready to Find Your Perfect Escape?", "cottageinn" );
    $wp_customize->get_setting( 'cta_subtitle' )->default         = esc_html__( "Whether you\’re looking for a peaceful retreat, a cozy hideaway, or an adventure in nature, our cottages are the perfect escape. Discover your ideal getaway now.", "cottageinn" );
    $wp_customize->get_setting( 'cta_contact_lbl' )->default      = esc_html__( "Plan Your Escape", "cottageinn" );
    $wp_customize->get_setting( 'cta_contact_link' )->default     = "#";

    //Adding the Default values For the blog section
    $wp_customize->get_setting( 'blog_title' )->default           = esc_html__( "Stories from the Cottage", "cottageinn" );

    //Removing all the settings and controls 
    $wp_customize->remove_control('banner_caption_overlay');  // Removing the Overlay toggle button
    $wp_customize->remove_setting('banner_caption_overlay');
    $wp_customize->remove_control('blog_btn_lbl');  // Removing the readmore button fromt he blog
    $wp_customize->remove_setting('blog_btn_lbl');
	
	// remove settings and control for the gallery select 5th and 6th
	$wp_customize->remove_setting('gallery_select_five');
	$wp_customize->remove_setting('gallery_select_six');
	$wp_customize->remove_control('gallery_select_five');
	$wp_customize->remove_control('gallery_select_six');
}
add_action( 'customize_register','cottageinn_customizer_controls',999 );
function hotell_customize_register_home_footer_top_settings( $wp_customize ) {
    
    /** Footer Top Section Settings */
    $wp_customize->add_section(
        'footer_top_section',
        array(
            'title'    => __( 'Footer Top Section', 'cottageinn' ),
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
                'label'         => __( 'Enable Footer Top Section', 'cottageinn' ),
            )
        )
    );

    /** Title Text */
    $wp_customize->add_setting( 
        'footer_top_title', 
        array(
            'default'           => esc_html__( 'Book Through Your Preferred Platform', 'cottageinn' ), 
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
        'footer_top_title',
        array(
            'section'         => 'footer_top_section',
            'label'           => __( 'Section Title', 'cottageinn' ),
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
				'label'	  => __( 'Travel Platforms', 'cottageinn' ),
				'fields'  => array(
                    'image' => array(
                        'type'    => 'image',
                        'label'   => __( 'Select Image', 'cottageinn' ),
					),
                    'link' => array(
                        'type'    => 'url',
                        'label'   => __( 'Link', 'cottageinn' ),
                        'description' => __( 'Example: https://facebook.com', 'cottageinn' ),
                    ),
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => esc_html__( 'links', 'cottageinn' ),
                    'field' => 'link'
                ),   
				'choices'   => array(
                    'limit' => 4
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
                'label'       => __( 'Enable to open link in a new tab', 'cottageinn' ),
            )
        )
    );
}
