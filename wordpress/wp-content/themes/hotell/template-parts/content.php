<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hotell
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); if( ! is_single() ) echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
    <?php if( 'post' == get_post_type()  && !is_single() ) echo '<div class="card blog-card">';
         
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
        
    if( 'post' == get_post_type()  && !is_single() ) echo '</div>'; ?>
</article><!-- #post-<?php the_ID(); ?> -->
