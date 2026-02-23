<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hotell
 */
    
    /**
     * After Content
     * 
     * @hooked hotell_content_end - 20
    */
    do_action( 'hotell_before_footer' );
    
    /**
     * Footer
     * 
     * @hooked hotell_footer_start  - 20
     * @hooked hotell_footer_top    - 30
     * @hooked hotell_footer_bottom - 40
     * @hooked hotell_footer_end    - 50
    */
    do_action( 'hotell_footer' );
    
    /**
     * After Footer
     * 
     * @hooked hotell_back_to_top - 15
     * @hooked hotell_page_end    - 20
    */
    do_action( 'hotell_after_footer' );

    wp_footer(); ?>

</body>
</html>
