<?php
/**
 * Sanitization Functions
 * 
 * @package Hotell
*/

if( ! function_exists( 'hotell_sanitize_checkbox' ) ) :

function hotell_sanitize_checkbox( $checked ){
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
endif;

if( ! function_exists( 'hotell_sanitize_select' ) ) :

function hotell_sanitize_select( $value ){    
    if ( is_array( $value ) ) {
		foreach ( $value as $key => $subvalue ) {
			$value[ $key ] = sanitize_text_field( $subvalue );
		}
		return $value;
	}
	return sanitize_text_field( $value );    
}
endif;

if( ! function_exists( 'hotell_sanitize_radio' ) ) :

function hotell_sanitize_radio( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if( ! function_exists( 'hotell_sanitize_google_map_iframe' ) ) :

function hotell_sanitize_google_map_iframe( $input, $setting ) {
    $allowedtags = array(
        'iframe' => array(
            'src' => array(),
            'width' => array(),
            'height' => array(),
            'frameborder' => array(),
            'style'     => array(),
            'marginwidth' => array(),
            'marginheight' => array(),
        )
    );

    $input = wp_kses( $input, $allowedtags );

    return $input;
}
endif;

if( ! function_exists( 'hotell_get_kses_extended_ruleset' ) ) :

function hotell_get_kses_extended_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );

    $svg_args = array(
        'svg'   => array(
            'class'           => true,
            'aria-hidden'     => true,
            'aria-labelledby' => true,
            'role'            => true,
            'xmlns'           => true,
            'width'           => true,
            'height'          => true,
            'viewbox'         => true, // <= Must be lower case!
        ),
        'g'     => array( 'fill' => true ),
        'title' => array( 'title' => true ),
        'path'  => array(
            'd'    => true,
            'fill' => true,
        ),
    );
    return array_merge( $kses_defaults, $svg_args );
}
endif;