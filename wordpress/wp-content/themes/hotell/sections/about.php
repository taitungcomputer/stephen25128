<?php
/**
 * About Section
 * 
 * @package Hotell
 */

$ed_about           = get_theme_mod( 'ed_about_section', false );
$about_subtitle     = get_theme_mod( 'about_subtitle', esc_html__( 'ABOUT US', 'hotell' ) );
$about_title        = get_theme_mod( 'about_title', esc_html__( 'Delicious Interior With The Pinch Of Everything', 'hotell' ) );
$about_content      = get_theme_mod( 'about_content' );
$abt_btn_lbl        = get_theme_mod( 'abt_btn_lbl', esc_html__( 'Learn More', 'hotell' ) );
$abt_btn_link       = get_theme_mod( 'abt_btn_link', '#' );
$abt_image_one      = get_theme_mod( 'abt_image_one' );
$alt_image_one      = attachment_url_to_postid( $abt_image_one );

if( $ed_about && ( $about_title || $about_subtitle || $about_content || $abt_image_one || ( $abt_btn_lbl && $abt_btn_link ) ) ) { ?>
    <section class="about two-col" id="about-section">
        <div class="container">
            <div class="two-col__wrap">
                <?php if( $about_subtitle || $about_title || $about_content || ( $abt_btn_lbl && $abt_btn_link ) ){ ?>
                    <div class="two-col__intro">
                        <?php if( $about_subtitle || $about_title ) { ?>
                            <div class="section-header">
                                <?php 
                                    if( $about_subtitle ) echo '<span class="section-header__tag">' . esc_html( $about_subtitle ) . '</span>';
                                    if( $about_title ) echo '<h2 class="section-header__title section-header__title-2">' . esc_html( $about_title ) . '</h2>';
                                ?>
                            </div>
                        <?php }
                        if( $about_content ) echo wp_kses_post( wpautop( $about_content ) );
                        if( $abt_btn_lbl && $abt_btn_link ) echo '<a href="' . esc_url( $abt_btn_link ) . '" class="btn btn-lg btn-primary">' . esc_html( $abt_btn_lbl ) . '</a>'; ?>
                    </div>
                <?php } 
                if( $abt_image_one ) { ?> 
                    <div class="two-col__img">
                        <?php 
                            if( $abt_image_one ) echo '<figure class="m-0"><img src="' . esc_url( $abt_image_one ) . '" alt="' . esc_attr( get_post_meta( $alt_image_one, '_wp_attachment_image_alt', true ) ) . '" height="440" width="267"></figure>';
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<!-- About Section Ends -->
<?php }