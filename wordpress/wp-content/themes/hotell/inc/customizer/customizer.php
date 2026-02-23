<?php
/**
 * Hotell Theme Customizer
 *
 * @package Hotell
 */

/**
 * Requiring customizer panels & sections
*/
$hotell_panels 		 = array( 'home', 'layout', 'general', 'contact', 'appearance' );
$hotell_sections     = array( 'info', 'site', 'footer' );
$hotell_sub_sections = array(
	'home'		  => array( 'about', 'cta', 'video', 'blog', 'footer-top', 'gallery' ),
    'general'     => array( 'header', 'social', 'seo', 'post-page', 'misc' ),
    'contact'     => array( 'form', 'map', 'info' ),
);

foreach( $hotell_sections as $s ){
    require get_template_directory() . '/inc/customizer/sections/' . $s . '.php';
}

foreach( $hotell_panels as $p ){
   require get_template_directory() . '/inc/customizer/panels/' . $p . '.php';
}

foreach( $hotell_sub_sections as $k => $v ){
    foreach( $v as $w ){        
        require get_template_directory() . '/inc/customizer/panels/' . $k . '/' . $w . '.php';
    }
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

if ( ! function_exists( 'hotell_customize_preview_js' ) ) :
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hotell_customize_preview_js() {
	wp_enqueue_script( 'hotell-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), HOTELL_THEME_VERSION, true );
}
endif;
add_action( 'customize_preview_init', 'hotell_customize_preview_js' );

if ( ! function_exists( 'hotell_customize_script' ) ) :

function hotell_customize_script(){
    $array = array(
        'home'                => get_permalink( get_option( 'page_on_front' ) ),
        'contact'             => hotell_get_page_template_url( 'templates/contact.php' ),
    );
    
    wp_enqueue_style( 'hotell-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), HOTELL_THEME_VERSION );
    wp_enqueue_script( 'hotell-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), HOTELL_THEME_VERSION, true );
    wp_localize_script( 'hotell-customize', 'hotell_cdata', $array );

    wp_localize_script( 'hotell-repeater', 'hotell_customize',
		array(
			'nonce' => wp_create_nonce( 'hotell_customize_nonce' )
		)
	);
}
endif;
add_action( 'customize_controls_enqueue_scripts', 'hotell_customize_script' );