<?php
/**
 * CTA Section
 * 
 * @package Hotell
 */

$ed_cta           = get_theme_mod( 'ed_cta_section', false );
$cta_title        = get_theme_mod( 'cta_title', esc_html__( 'Make room for adventure', 'hotell' ) );
$cta_subtitle     = get_theme_mod( 'cta_subtitle', esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id parturient aliquam egestas auctor in volutpat nulla purus.', 'hotell' ) );
$cta_btn          = get_theme_mod( 'cta_contact_lbl', esc_html__( 'Online Booking', 'hotell' ) );
$cta_btn_link     = get_theme_mod( 'cta_contact_link', '#' );
$background_image = get_theme_mod( 'cta_background_image' );
$open_new_tab     = get_theme_mod( 'cta_new_tab', false );
$new_tab          = ( $open_new_tab ) ? 'target=_blank' : '';

if( $ed_cta && ( $cta_title || $cta_subtitle || $background_image || ( $cta_btn && $cta_btn_link ) ) ){ ?>
    <div id="cta-section">
        <div class="cta-image">
            <div class="container">
                <div class="cta-image__content" <?php if ( $background_image ) echo 'style="background-image: url(' . esc_url( $background_image ) . ') "'; ?>>
                    <?php if( $cta_title || $cta_subtitle ){ ?>
                        <div class="section-header">
                            <?php 
                                if( $cta_title ) echo '<h2 class="section-header__title section-header__title-2">' . esc_html( $cta_title ) . '</h2>';
                                if( $cta_subtitle ) echo '<span class="section-subtitle">' . esc_html( $cta_subtitle ) . '</span>';
                            ?>
                        </div>
                    <?php }
                    if( $cta_btn && $cta_btn_link ) echo '<a href="' . esc_url( $cta_btn_link ) . '" class="btn btn-lg btn-primary" ' . esc_attr( $new_tab ) . '>' . esc_html( $cta_btn ) . '</a>'; ?>
                </div>
            </div>
        </div>
    </div>
<?php }