<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hotell
 */
    /**
     * Doctype Hook
     * 
     * @hooked hotell_doctype
    */
    do_action( 'hotell_doctype' );
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<?php 
    /**
     * Before wp_head
     * 
     * @hooked hotell_head
    */
    do_action( 'hotell_before_wp_head' );
    
    wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php
    wp_body_open();
    
    /**
     * Before Header
     * 
     * @hooked hotell_page_start - 20 
    */
    do_action( 'hotell_before_header' );
    
    /**
     * Header
     * 
     * @hooked hotell_header - 20     
    */
    do_action( 'hotell_header' );
    
    /**
     * Before Content
     * 
     * @hooked hotell_banner             - 15
     * @hooked hotell_top_bar            - 30
     * @hooked hotell_content_start      - 40
    */
    do_action( 'hotell_after_header' );