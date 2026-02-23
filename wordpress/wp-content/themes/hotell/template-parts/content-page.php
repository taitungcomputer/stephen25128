<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hotell
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php 
        /**
         * @hooked hotell_post_thumbnail - 10
         * @hooked hotell_entry_header   - 20 
        */
        do_action( 'hotell_before_post_entry_content' );
    
        /**
         * Entry Content
         * @hooked hotell_entry_content - 15
         * @hooked hotell_entry_footer  - 20
        */
        do_action( 'hotell_post_entry_content' );
    ?>
</article><!-- #post-<?php the_ID(); ?> -->