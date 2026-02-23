<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Hotell
 */

get_header();

	/**
	 * Before Posts hook
	*/
	do_action( 'hotell_before_posts_content' );

	if ( have_posts() ) : 
	
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;

	hotell_content_wrapper_end(); 

get_sidebar();
get_footer();