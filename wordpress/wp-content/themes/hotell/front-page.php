<?php
/**
 * Front Page
 *
 * @package Hotell
 */

$home_sections = array( 'about', 'cta', 'gallery', 'video', 'blog', 'footer-top' );

if ( 'posts' == get_option( 'show_on_front' ) ) { //Show Static Blog Page
    include( get_home_template() );
}elseif( $home_sections ){
    get_header();
    //If any one section are enabled then show custom home page.
    foreach( $home_sections as $section ){
        get_template_part( 'sections/' . $section );
    }
    get_footer();
}else{
    //If all section are disabled then show respective page template.
    include( get_page_template() );
}