<?php

/**
 * Gallery Section
 *
 * @package Hotell
 */

$ed_section         = get_theme_mod( 'ed_gallery_section', false );
$gallery_subtitle   = get_theme_mod( 'gallery_subtitle', esc_html__( 'OUR COLLECTION', 'hotell' ) );
$gallery_title      = get_theme_mod( 'gallery_title', esc_html__( 'Our Featured Gallery', 'hotell' ) );
$gallery_content    = get_theme_mod( 'gallery_content' );
$gallery_one        = get_theme_mod( 'gallery_select_one' );
$gallery_two        = get_theme_mod( 'gallery_select_two' );
$gallery_three      = get_theme_mod( 'gallery_select_three' );
$gallery_four       = get_theme_mod( 'gallery_select_four' );
$gallery_five       = get_theme_mod( 'gallery_select_five' );

if( $ed_section && ( $gallery_subtitle || $gallery_title || $gallery_content || $gallery_one || $gallery_two || $gallery_three || $gallery_four || $gallery_five ) ) { ?>
    <section class="gallery-archive gallery-main section-padding" id="gallery-section">
        <div class="container">
            <?php hotell_section_header( $gallery_title, $gallery_subtitle, $gallery_content );
            if( $gallery_one || $gallery_two || $gallery_three || $gallery_four || $gallery_five ) {
                $gallery_args = array(
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
                    'post__in'       => array( $gallery_one, $gallery_two, $gallery_three, $gallery_four, $gallery_five ),
                    'orderby'        => 'post__in',
                    'posts_per_page' => -1,
                );
                $gallery_qry = new WP_Query( $gallery_args );
                if( $gallery_qry->have_posts() ) { ?>
                    <div class="gallery">
                        <?php while( $gallery_qry->have_posts() ) {
                            $gallery_qry->the_post();
                            if( $gallery_qry->current_post == 2 ) {
                                $image_size = 'hotell-gallery-large';
                                $class_name = 'large-post';
                            } else {
                                $image_size = 'hotell-gallery-small';
                                $class_name = 'small-post';
                            }
                            if( $gallery_qry->current_post == 0 || $gallery_qry->current_post == 2 || $gallery_qry->current_post == 3 ) echo '<div class="' . esc_attr( $class_name ) . '">' ?>
                            <div class="card gallery-item">
                                <div class="image">
                                    <a href="<?php the_permalink(); ?>">
                                        <figure class="card__img post-thumbnail">
                                            <?php if ( has_post_thumbnail() ) { ?>
                                            <?php the_post_thumbnail( $image_size, array('itemprop' => 'image' ) );
                                            } else {
                                                hotell_get_fallback_svg( $image_size );
                                            } ?>
                                        </figure>
                                    </a>
                                </div>
                                <div class="card__content">
                                    <?php the_title('<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>'); ?>
                                </div>
                            </div>
                        <?php if ($gallery_qry->current_post == 1 || $gallery_qry->current_post == 2 || $gallery_qry->current_post == 4) echo '</div>';
                        }
                        wp_reset_query(); ?>
                    </div>
            <?php }
            } ?>
        </div>
    </section>
<?php }