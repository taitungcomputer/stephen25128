<?php 
/**
 * Cottageinn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cottageinn
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cottageinn_setuptheme(){

	load_theme_textdomain( 'cottageinn', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'cottageinn_setuptheme' );

function cottageinn_enqueue_assets() {
	$my_theme = wp_get_theme();
	$version  = $my_theme['Version'];

	wp_enqueue_style( 'hotell', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'cottageinn-child-custom', get_stylesheet_directory_uri() . '/assets/js/child-custom.js', array('jquery'), $version, true );
}
add_action( 'wp_enqueue_scripts', 'cottageinn_enqueue_assets' );


/**
* Customizer settings
*/ 	
require get_stylesheet_directory() . '/inc/customizer.php';

/**
* Extra Functions
*/
require get_stylesheet_directory() . '/inc/extra-functions.php';

/**
 * Summary of cottageinn_enqueue_editor_style , customizer css
 * @return void
 */
function cottageinn_enqueue_editor_style(){
    $style = '
        <style id="cottage-editor-style">
            .customize-pane-parent #accordion-section-hotell_view_pro h3 a {
                background-color: #4A6145 !important;
                border-color: #4A6145 !important;
            }
            .customize-pane-parent #accordion-section-hotell_view_pro h3 a:hover {
                background-color: #6E816A !important;
                border-color: #6E816A !important;
            }
            .customize-pane-parent #accordion-section-hotell_view_pro h3:after {
                opacity: 0;
            }
        </style>
    ';
    echo wp_kses( 
            $style, 
            array(
                'style' => array(
                    'id' => true,
                ),
            ) 
        );
}
add_action( 'customize_controls_print_styles', 'cottageinn_enqueue_editor_style' );




