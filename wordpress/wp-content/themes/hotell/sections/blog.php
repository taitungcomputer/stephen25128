<?php
/**
 * Amneties Section
 * 
 * @package Hotell
 */

$ed_section         = get_theme_mod( 'ed_blog_section', false );
$blog_subtitle      = get_theme_mod( 'blog_subtitle', esc_html__( 'OUR BLOG', 'hotell' ) );
$blog_title         = get_theme_mod( 'blog_title', esc_html__( 'Our News And Blogs', 'hotell' ) );
$blog_content       = get_theme_mod( 'blog_content' );
$blog_btn_lbl       = get_theme_mod( 'blog_btn_lbl', esc_html__( 'Read More', 'hotell' ) );

$args = array(  
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3, 
);
$blog_qry = new WP_Query( $args );

if( $ed_section && ( $blog_qry->have_posts() || $blog_title || $blog_subtitle || $blog_content ) ){ ?>
    <section class="news-and-blogs section-padding" id="blog-section">
        <div class="container">
            <?php hotell_section_header( $blog_title, $blog_subtitle, $blog_content ); 
            if( $blog_qry->have_posts() ){ ?>
                <div class="margin-fixed">
                    <div class="news-and-blogs__slider owl-carousel">
                        <?php while( $blog_qry->have_posts() ){
                            $blog_qry->the_post(); ?>
                            <article class="post">
                                <div class="card blog-card">
                                    <figure class="card__img">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if( has_post_thumbnail() ){
                                                the_post_thumbnail( 'hotell-blog-section', array( 'itemprop' => 'image' ) );
                                            }else{
                                                hotell_get_fallback_svg( 'hotell-blog-section' );
                                            } ?>
                                        </a>
                                    </figure>
                                    <?php hotell_card_content(); ?>
                                </div>
                            </article>
                        <?php } wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php }