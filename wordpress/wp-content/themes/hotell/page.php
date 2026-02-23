<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hotell
 */

get_header(); ?>

	<?php
        /**
         * Before Posts hook
		 * @hooked hotell_content_wrapper_start
        */
        do_action( 'hotell_before_posts_content' );

		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'page' );

			/**
			 * Comment Template
			 * 
			 * @hooked hotell_comment
			*/
			do_action( 'hotell_after_page_content' );

		endwhile; // End of the loop.
		
		hotell_content_wrapper_end();

get_footer();