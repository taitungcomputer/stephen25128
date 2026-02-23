<?php
/**
 * Footer Top Section
 * 
 * @package Hotell
 */

$ed_section     = get_theme_mod( 'ed_footer_section', false );
$sec_title      = get_theme_mod( 'footer_top_title', esc_html__( 'Book With a Hotel Specialist On', 'hotell' ) );
$footer_top     = get_theme_mod( 'footer_top_repeater' );
$open_new_tab   = get_theme_mod( 'footer_top_new_tab', false );
$new_tab        = ( $open_new_tab ) ? 'target=_blank' : '';

if( $ed_section && ( $sec_title || $footer_top ) ){ ?>
    <section class="foot-top section-padding" id="footer-top-section">
        <div class="container">
            <div class="foot-top__wrap">
                <div class="foot-top__title">
                    <div class="section-header">
                        <?php if( $sec_title ) echo '<h2 class="section-header__title">' . esc_html( $sec_title ) . '</h2>';?>
                    </div>
                </div>
                <?php
                if( $footer_top ){
                    echo '<div class="foot-top__right owl-carousel">';
                        foreach( $footer_top as $footer ){
                            $footer_img   = ( isset( $footer['image'] ) && $footer['image'] ) ? $footer['image'] : '';
                            $footer_link  = ( isset( $footer['link'] ) && $footer['link'] ) ? $footer['link'] : '';
                            echo '<a href="' . esc_url( $footer_link ) . '" ' . esc_attr( $new_tab ) . '><img src=' . wp_get_attachment_image_url( $footer_img, 'hotell-footer-top' ) . '></a>';
                        }
                    echo '</div>';
                } ?>
            </div> 
        </div>
    </section>
<?php }