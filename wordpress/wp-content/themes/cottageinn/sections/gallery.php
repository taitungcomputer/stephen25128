<?php
/**
 * Gallery Section
 *
 * @package Hotell
 */

$ed_section         = get_theme_mod( 'ed_gallery_section', false );
$gallery_subtitle   = get_theme_mod( 'gallery_subtitle', esc_html__( 'OUR COLLECTION', 'cottageinn' ) );
$gallery_title      = get_theme_mod( 'gallery_title', esc_html__( 'Our Featured Gallery', 'cottageinn' ) );
$gallery_content    = get_theme_mod( 'gallery_content' );
$gallery_one        = get_theme_mod( 'gallery_select_one' );
$gallery_two        = get_theme_mod( 'gallery_select_two' );
$gallery_three      = get_theme_mod( 'gallery_select_three' );
$gallery_four       = get_theme_mod( 'gallery_select_four' );

if( $ed_section && ( $gallery_subtitle || $gallery_title || $gallery_content || $gallery_one || $gallery_two || $gallery_three || $gallery_four ) ) { ?>
    <section class="gallery-archive gallery-main section-padding" id="gallery-section">
        <div class="container">
            <?php hotell_section_header( $gallery_title, $gallery_subtitle, $gallery_content );
            if( $gallery_one || $gallery_two || $gallery_three || $gallery_four ) {
                $image_size = 'hotell-gallery-large';
                $gallery_args = array(
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
                    'post__in'       => array( $gallery_one, $gallery_two, $gallery_three, $gallery_four ),
                    'orderby'        => 'post__in',
                    'posts_per_page' => -1,
                );
                $gallery_qry = new WP_Query( $gallery_args );
                if( $gallery_qry->have_posts() ) { ?>
                    <div class="gallery">
                        <?php while( $gallery_qry->have_posts() ) {
                            $gallery_qry->the_post();
                            if ($gallery_qry->current_post < 3) {
                                $wrapper_class = 'gallery-big'; // First 3 posts
                            } else {
                                $wrapper_class = 'gallery-small'; // Last post
                            } 

                            // Open the wrapper for the 1st post and the 4th post. 
                            if( $gallery_qry->current_post == 0 || $gallery_qry->current_post == 3 ) : ?>
                                <div class="<?php echo esc_attr($wrapper_class); ?>">
                            <?php endif; ?>
                                <!-- Open the gallery-top for the 1st and gallery-bottom for 2nd post -->
                                <?php if( $gallery_qry->current_post == 0 || $gallery_qry->current_post == 1 ) : ?>
                                   <div class="<?php echo esc_attr( ( $gallery_qry->current_post == 0 ) ? 'gallery-top' : 'gallery-bottom' ); ?>">
                                <?php endif; ?>
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
                                            <a href="<?php the_permalink(); ?>">
                                                <svg width="48" height="47" viewBox="0 0 48 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.5584 13.3157C16.731 13.3157 15.9374 13.6444 15.3523 14.2295C14.7671 14.8146 14.4384 15.6082 14.4384 16.4357C14.4384 17.2632 14.7671 18.0567 15.3523 18.6418C15.9374 19.227 16.731 19.5557 17.5584 19.5557H17.5776C18.4051 19.5557 19.1987 19.227 19.7838 18.6418C20.3689 18.0567 20.6976 17.2632 20.6976 16.4357C20.6976 15.6082 20.3689 14.8146 19.7838 14.2295C19.1987 13.6444 18.4051 13.3157 17.5776 13.3157H17.5584Z" fill="#FEFEFE"/>
                                                    <path d="M7.2 10.5602C7.2 9.4145 7.65514 8.31569 8.4653 7.50553C9.27545 6.69538 10.3743 6.24023 11.52 6.24023H36.48C37.6257 6.24023 38.7245 6.69538 39.5347 7.50553C40.3449 8.31569 40.8 9.4145 40.8 10.5602V35.5202C40.8 36.666 40.3449 37.7648 39.5347 38.5749C38.7245 39.3851 37.6257 39.8402 36.48 39.8402H11.52C10.3743 39.8402 9.27545 39.3851 8.4653 38.5749C7.65514 37.7648 7.2 36.666 7.2 35.5202V10.5602ZM11.52 9.12023C11.1381 9.12023 10.7718 9.27195 10.5018 9.542C10.2317 9.81205 10.08 10.1783 10.08 10.5602V29.9138L12.8659 26.2658C13.2703 25.7362 13.7918 25.3074 14.3895 25.0128C14.9872 24.7182 15.645 24.5659 16.3113 24.5678C16.9777 24.5696 17.6346 24.7256 18.2306 25.0235C18.8267 25.3214 19.3457 25.7532 19.7472 26.285L22.08 29.3762C22.2332 29.5793 22.4374 29.7381 22.6719 29.8366C22.9064 29.9351 23.1629 29.9698 23.4151 29.937C23.6673 29.9042 23.9064 29.8052 24.1079 29.6501C24.3095 29.4949 24.4663 29.2891 24.5626 29.0537L28.3603 19.7474C29.641 16.6082 33.8746 16.0994 35.8598 18.8489L37.92 21.6982V10.5602C37.92 10.1783 37.7683 9.81205 37.4982 9.542C37.2282 9.27195 36.8619 9.12023 36.48 9.12023H11.52ZM10.08 35.5202C10.08 36.3151 10.7251 36.9602 11.52 36.9602H36.48C36.8619 36.9602 37.2282 36.8085 37.4982 36.5385C37.7683 36.2684 37.92 35.9022 37.92 35.5202V26.6114L33.527 20.5366C33.3765 20.3285 33.1731 20.1644 32.9378 20.0614C32.7025 19.9584 32.444 19.9202 32.189 19.9508C31.934 19.9813 31.6918 20.0795 31.4875 20.2352C31.2832 20.3908 31.1243 20.5983 31.0272 20.8361L27.2294 30.1404C25.9622 33.2431 21.8016 33.7865 19.7818 31.1119L17.449 28.0207C17.3151 27.8434 17.142 27.6994 16.9432 27.6001C16.7445 27.5007 16.5254 27.4488 16.3032 27.4482C16.081 27.4476 15.8617 27.4985 15.6624 27.5968C15.4631 27.6952 15.2893 27.8383 15.1546 28.015L10.3699 34.2818C10.2863 34.389 10.1888 34.4845 10.08 34.566V35.5202Z" fill="#FEFEFE"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <!-- close the gallery-top and bottom when post is 1 and 3rd  -->
                                <?php if( $gallery_qry->current_post == 0 || $gallery_qry->current_post == 2 ) : ?>
                                    </div>
                                <?php endif; ?>
                            <!-- close the wrapper after 3rd post and fourth post  -->
                            <?php if( $gallery_qry->current_post == 2 || $gallery_qry->current_post == 3 ) : ?>
                                </div>
                            <?php endif; ?>
                            <?php
                        wp_reset_query();
                        }?>
                    </div>
            <?php }
            } ?>
        </div>
    </section>
<?php } 