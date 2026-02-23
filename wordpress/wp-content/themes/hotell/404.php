<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * 
 * @package Hotell
 */
$image      = get_theme_mod( '404_image' );
$alt_image  = attachment_url_to_postid( $image );

get_header();

    /**
     * Before Posts hook
     * @hooked hotell_content_wrapper_start
    */
    do_action( 'hotell_before_posts_content' ); ?>

    <section class="error-404 not-found">
        <figure>
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_post_meta( $alt_image, '_wp_attachment_image_alt', true ) ); ?>">
        </figure>
        <header class="page-header">
            <?php 
                echo '<h1 class="page-title">' . esc_html__( 'Ooops!', 'hotell' ) . '</h1>';
                echo '<div class="subtitle"><p>' . esc_html__( 'We can’t seem to find the page you are looking for.', 'hotell' ) . '</p></div>';
            ?>
            <div class="error404-search">
                <?php get_search_form(); ?>
            </div>
        </header>
    </section>
    <?php
    /**
     * @see hotell_latest_posts
    */
    do_action( 'hotell_latest_posts' );
     
    hotell_content_wrapper_end();
    
get_footer();