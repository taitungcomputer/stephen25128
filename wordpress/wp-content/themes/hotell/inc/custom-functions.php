<?php
/**
 * Hotell Custom functions and definitions
 *
 * @package Hotell
 */

/**
 * Show/Hide Admin Bar in frontend.
*/

if ( ! function_exists( 'hotell_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hotell_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Hotell, use a find and replace
	 * to change 'hotell' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hotell', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary', 'hotell' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    // Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hotell_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
        'custom-logo',
        array(
            'header-text' => array( 'site-title', 'site-description' )
        )
    );

    /**
     * Add support for custom header.
    */
    add_theme_support(
        'custom-header',
        apply_filters(
            'hotell_custom_header_args',
            array(
                'default-image' => '',
                'video'         => true,
                'width'         => 1920,
                'height'        => 650,
                'header-text'   => false
            )
        )
    );

	add_image_size( 'hotell-breadcrumb', 1440, 287, true );
	add_image_size( 'hotell-offers-section', 373, 293, true );
    add_image_size( 'hotell-blog-section', 280, 305, true );
	add_image_size( 'hotell-gallery-large', 390, 636, true );
    add_image_size( 'hotell-gallery-small', 390, 293, true );
	add_image_size( 'hotell-related-post', 490, 295, true );
	add_image_size( 'hotell-footer-top', 210, 35, true );

    // Add theme support for Responsive Videos.
    add_theme_support( 'jetpack-responsive-videos' );

}
endif;
add_action( 'after_setup_theme', 'hotell_setup' );

if( ! function_exists( 'hotell_content_width' ) ) :
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hotell_content_width() {

    $GLOBALS['content_width'] = apply_filters( 'hotell_content_width', 824 );
}
endif;
add_action( 'after_setup_theme', 'hotell_content_width', 0 );

if( ! function_exists( 'hotell_template_redirect_content_width' ) ) :
/**
* Adjust content_width value according to template.
*
* @return void
*/
function hotell_template_redirect_content_width(){
	$sidebar = hotell_sidebar();
    if( $sidebar !== 'full-width' ){
		$GLOBALS['content_width'] = 824;
	}else{
		$GLOBALS['content_width'] = 1320;
	}
}
endif;
add_action( 'template_redirect', 'hotell_template_redirect_content_width' );

if( ! function_exists( 'hotell_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function hotell_scripts() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_style( 'hotell-style', get_stylesheet_uri(), array(), HOTELL_THEME_VERSION );

	// Add styles inline.
	wp_add_inline_style( 'hotell-style', hotell_get_font_face_styles() );
    wp_style_add_data( 'hotell-style', 'rtl', 'replace' );

    if ( hotell_is_jetpack_activated( true ) ) {
        wp_enqueue_style( 'tiled-gallery', plugins_url() . '/jetpack/modules/tiled-gallery/tiled-gallery/tiled-gallery.css' );
    }

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    if( is_front_page() ){
        wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css', array(), '2.3.4' );
	    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.3.4', true );
    }

	wp_enqueue_script( 'hotell-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array(), HOTELL_THEME_VERSION, true );
	wp_enqueue_script( 'hotell', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery' ), HOTELL_THEME_VERSION, true );

    $array = array(
        'rtl'           => is_rtl(),
    );

    wp_localize_script( 'hotell', 'hotell_data', $array );
}
endif;
add_action( 'wp_enqueue_scripts', 'hotell_scripts' );

if( ! function_exists( 'hotell_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hotell_body_classes( $classes ) {
    $ed_banner  = get_theme_mod( 'ed_banner_section', 'static_banner' );

    // Adds a banner class.
    if ( is_front_page() && ! is_home() ) {
        $classes[] = $ed_banner;
    }

    // Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    // Adds a class of custom-background-image to sites with a custom background image.
	if( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }

    // Adds a class of custom-background-color to sites with a custom background color.
    if( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}

    if ( is_home() && ! is_front_page() ) {
        $classes[] = 'archive-style-one';
    }

    $classes[] = hotell_sidebar( true );

	return $classes;
}
endif;
add_filter( 'body_class', 'hotell_body_classes' );

if ( ! function_exists( 'hotell_pingback_header' ) ) :
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function hotell_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
endif;
add_action( 'wp_head', 'hotell_pingback_header' );

if ( ! function_exists( 'hotell_admin_scripts' ) ) :
	/**
	 * Enqueue admin css
	*/
	function hotell_admin_scripts() {
		wp_enqueue_style( 'hotell-admin-style', get_template_directory_uri() . '/inc/css/admin.css', array(), HOTELL_THEME_VERSION );
	}
endif;
add_action( 'admin_enqueue_scripts', 'hotell_admin_scripts' );