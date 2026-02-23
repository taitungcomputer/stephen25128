<?php
/**
 * Hotell functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hotell
 */

$hotell_theme_data = wp_get_theme();
if( ! defined( 'HOTELL_THEME_VERSION' ) ) define( 'HOTELL_THEME_VERSION', $hotell_theme_data->get( 'Version' ) );
if( ! defined( 'HOTELL_THEME_NAME' ) ) define( 'HOTELL_THEME_NAME', $hotell_theme_data->get( 'Name' ) );

/**
 * Custom Functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Standalone Functions.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions for selective refresh.
 */
require get_template_directory() . '/inc/partials.php';

/**
 * Custom Controls
 */
require get_template_directory() . '/inc/custom-controls/custom-control.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Metabox
 */
require get_template_directory() . '/inc/metabox/metabox.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';