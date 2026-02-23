<?php
/**
 * Template Name: Contact Page
 * 
 * @package Hotell
 */

get_header(); 
    /**
     * Before Posts hook
     * @hooked hotell_content_wrapper_start
    */
    do_action( 'hotell_before_posts_content' );

    echo '<section class="contact"><div class="container">';

    /**
     * Contact Page Hook
     * 
     * @hooked hotell_contact_top_section         - 10
    */
    do_action( 'hotell_contact_page' ); ?>

    <div class="contact__wrapper row">
        <div class="contact__blocks col">
            <?php
            /**
             * Contact page sections
             * 
             * @hooked hotell_phone_details          - 10
             * @hooked hotell_email_details          - 20
             * @hooked hotell_address_details        - 30
             * @hooked hotell_timing_details         - 40
             * @hooked hotell_contact_social_details - 45
             */
            do_action( 'hotell_contact_page_details' ); ?>
        </div>
        <?php hotell_contact_form(); ?>
    </div>

    <?php hotell_google_maps();
    
    echo '</section></div>';

    hotell_content_wrapper_end();
    
get_footer();