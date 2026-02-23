<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Hotell
 */

get_header();

    /**
     * Before Posts hook
     * @hooked hotell_content_wrapper_start
    */
    do_action( 'hotell_before_posts_content' );

    while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', get_post_type() );

    endwhile; // End of the loop.

    hotell_content_wrapper_end();
        
get_footer();