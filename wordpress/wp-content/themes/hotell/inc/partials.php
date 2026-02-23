<?php
/**
 * Hotell Customizer Partials
 *
 * @package Hotell
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hotell_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hotell_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'hotell_get_slider_readmore' ) ) :
/**
 * Slider Read More
*/
function hotell_get_slider_readmore(){
    return get_theme_mod( 'slider_readmore' );
}
endif;

if( ! function_exists( 'hotell_get_read_more' ) ) :
/**
 * Display blog readmore button
*/
function hotell_get_read_more(){
    return get_theme_mod( 'read_more_text', __( 'Read More', 'hotell' ) );    
}
endif;

if( ! function_exists( 'hotell_get_author_title' ) ) :
/**
 * Display blog readmore button
*/
function hotell_get_author_title(){
    return get_theme_mod( 'author_title' );
}
endif;

if( ! function_exists( 'hotell_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function hotell_get_related_title(){
    return get_theme_mod( 'related_post_title', __( 'You may also like', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function hotell_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'hotell' );
        echo date_i18n( esc_html__( 'Y', 'hotell' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved.', 'hotell' );
    }
    echo '</span>'; 
}
endif;

if( ! function_exists( 'hotell_ed_author_link' ) ) :
/**
 * Author link in footer
*/
function hotell_ed_author_link(){  
    esc_html_e( ' | Developed By ', 'hotell' );
    echo '<span class="author-link"><a href="' . esc_url( 'https://glthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Good Looking Themes', 'hotell' ) . '</a></span>.';  
}
endif;

if( ! function_exists( 'hotell_ed_wp_link' ) ) :
/**
 * WordPress link in footer
*/
function hotell_ed_wp_link(){  
    printf( esc_html__( '%1$s Powered by %2$s%3$s.', 'hotell' ), '<span class="wp-link">', '<a href="'. esc_url( __( 'https://wordpress.org/', 'hotell' ) ) .'" target="_blank">WordPress</a>', '</span>' );
}
endif;

if( ! function_exists( 'hotell_contact_title' ) ) :
/**
 * Contact Title
*/
function hotell_contact_title(){
    return get_theme_mod( 'contact_title' );
}
endif;

if( ! function_exists( 'hotell_contact_subtitle' ) ) :
/**
 * Contact Title
*/
function hotell_contact_subtitle(){
    return get_theme_mod( 'contact_subtitle' );
}
endif;

if( ! function_exists( 'hotell_phone_title' ) ) :
/**
 * Contact Phone Label
*/
function hotell_phone_title(){
    return get_theme_mod( 'phone_title' );
}
endif;

if( ! function_exists( 'hotell_mail_title' ) ) :
/**
 * Contact Email Label
*/
function hotell_mail_title(){
    return get_theme_mod( 'mail_title' );
}
endif;

if( ! function_exists( 'hotell_location_title' ) ) :
/**
 * Contact Address Label
*/
function hotell_location_title(){
    return get_theme_mod( 'location_title' );
}
endif;

if( ! function_exists( 'hotell_contact_hours' ) ) :
/**
 * Contact Timing label
*/
function hotell_contact_hours(){
    return get_theme_mod( 'contact_hours' );
}
endif;

if( ! function_exists( 'hotell_social_title' ) ) :
/**
 * Social Label
*/
function hotell_social_title(){
    return get_theme_mod( 'social_title' );
}
endif;
 
if( ! function_exists( 'hotell_get_about_subtitle' ) ) :
/**
 * About Subtitle
*/
function hotell_get_about_subtitle(){
    return get_theme_mod( 'about_subtitle', esc_html__( 'ABOUT US', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_about_title' ) ) :
/**
 * About title
*/
function hotell_get_about_title(){
    return get_theme_mod( 'about_title', esc_html__( 'Delicious Interior With The Pinch Of Everything', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_abt_btn_lbl' ) ) :
/**
 * About section button label
*/
function hotell_get_abt_btn_lbl(){
    return get_theme_mod( 'abt_btn_lbl', esc_html__( 'Learn More', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_cta_title' ) ) :
/**
 * CTA title
*/
function hotell_get_cta_title(){
    return get_theme_mod( 'cta_title', esc_html__( 'Make room for adventure', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_cta_subtitle' ) ) :
/**
 * CTA subtitle
*/
function hotell_get_cta_subtitle(){
    return get_theme_mod( 'cta_subtitle', esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id parturient aliquam egestas auctor in volutpat nulla purus.', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_cta_contact_lbl' ) ) :
/**
 * CTA button label
*/
function hotell_get_cta_contact_lbl(){
    return get_theme_mod( 'cta_contact_lbl', esc_html__( 'Online Booking', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_video_block_title' ) ) :
/**
 * Video Block title
*/
function hotell_get_video_block_title(){
    return get_theme_mod( 'video_block_title', esc_html__( 'Relax & Enjoy with us your holidays', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_blog_subtitle' ) ) :
/**
 * Blog subtitle
*/
function hotell_get_blog_subtitle(){
    return get_theme_mod( 'blog_subtitle', esc_html__( 'OUR BLOG', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_blog_title' ) ) :
/**
 * Blog title
*/
function hotell_get_blog_title(){
    return get_theme_mod( 'blog_title', esc_html__( 'Our News And Blogs', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_blog_btn_lbl' ) ) :
/**
 * Blog button label
*/
function hotell_get_blog_btn_lbl(){
    return get_theme_mod( 'blog_btn_lbl', esc_html__( 'Read More', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_banner_title' ) ) : 
/**
 * Banner title
 */
function hotell_get_banner_title(){
    return get_theme_mod( 'banner_title' );
}
endif;

if( ! function_exists( 'hotell_get_slider_btn_lbl' ) ) : 
/**
 * Banner btn lable
 */
function hotell_get_slider_btn_lbl(){
    return get_theme_mod( 'slider_btn_lbl' );
}
endif;

if( ! function_exists( 'hotell_get_gallery_title' ) ) : 
/**
 * Homepage Gallery title
 */
function hotell_get_gallery_title(){
    return get_theme_mod( 'gallery_title', __( 'Our Featured Gallery', 'hotell' ) );
}
endif;

if( ! function_exists( 'hotell_get_gallery_subtitle' ) ) : 
/**
 * Homepage Gallery subtitle
 */
function hotell_get_gallery_subtitle(){
    return get_theme_mod( 'gallery_subtitle', __( 'OUR COLLECTION', 'hotell' ) );
}
endif;