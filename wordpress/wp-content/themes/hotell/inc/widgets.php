<?php
/**
 * Hotell Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Hotell
 */
if ( ! function_exists( 'hotell_widgets_init' ) ) :

function hotell_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'hotell' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'hotell' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'hotell' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'hotell' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'hotell' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'hotell' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'hotell' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'hotell' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'hotell' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'hotell' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }
}
endif;
add_action( 'widgets_init', 'hotell_widgets_init' );