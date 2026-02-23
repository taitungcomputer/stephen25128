<?php
/**
 * Active Callback
 * 
 * @package Hotell
*/

if ( ! function_exists( 'hotell_banner_ac' ) ) :
/**
 * Active Callback for Banner Slider
*/
function hotell_banner_ac( $control ){
    $banner        = $control->manager->get_setting( 'ed_banner_section' )->value();
    $control_id    = $control->id;
    
    if ( $control_id == 'header_image' && $banner == 'static_banner'  ) return true;
    if ( $control_id == 'header_video' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'external_header_video' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_title' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_subtitle' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_readmore_link' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'slider_btn_new_tab' && $banner != 'static_banner'  ) return true;
    
    return false; 
}
endif;

if ( ! function_exists( 'hotell_post_page_ac' ) ) :
/**
 * Active Callback for post/page
*/
function hotell_post_page_ac( $control ){
    
    $ed_related    = $control->manager->get_setting( 'ed_related' )->value();
    $control_id    = $control->id;
    
    if ( $control_id == 'related_post_title' && $ed_related == true ) return true;
    
    return false;
}
endif;