<?php
/**
 * Hotell Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Hotell
 */

if( ! function_exists( 'hotell_doctype' ) ) :
/**
 * Doctype Declaration
*/
function hotell_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'hotell_doctype', 'hotell_doctype' );

if( ! function_exists( 'hotell_head' ) ) :
/**
 * Before wp_head 
*/
function hotell_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'hotell_before_wp_head', 'hotell_head' );

if( ! function_exists( 'hotell_page_start' ) ) :
/**
 * Page Start
*/
function hotell_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'hotell' ); ?></a>
    <?php
}
endif;
add_action( 'hotell_before_header', 'hotell_page_start', 20 );

if( ! function_exists( 'hotell_header' ) ) :
/**
 * Header Start
*/
function hotell_header(){ 
    $btn_lbl      = get_theme_mod( 'header_btn_lbl' );
    $btn_link     = get_theme_mod( 'header_btn_link' );
    $open_new_tab = get_theme_mod( 'header_new_tab', false );
    $new_tab      = ( $open_new_tab ) ? 'target=_blank' : '';
    $social_links = get_theme_mod( 'social_links' );
    $ed_social    = get_theme_mod( 'ed_social_links', false );
    $location     = get_theme_mod( 'header_location' );
    $email        = get_theme_mod( 'email' ); ?>
    
    <header id="masthead" class="site-header header-two" itemscope itemtype="http://schema.org/WPHeader">
        <?php if( $location || $email || ( $ed_social && $social_links ) ){ ?> 
            <div class="header-top clearfix">
                <div class="container">
                    <div class="header-top-left"> 
                        <?php hotell_header_info(); ?>
                    </div>
                    <div class="header-top-right">
                        <?php hotell_social_links( true ); ?>
                    </div>
                </div>
            </div>
        <?php } ?>    
            <div class="desktop-header">
                <div class="header-bottom">
                    <div class="container">
                        <div class="header-wrapper">
                                <?php hotell_site_branding(); ?>
                            <div class="nav-wrap">
                                <div class="header-left">
                                <?php hotell_primary_nagivation(); ?>
                                </div>
                                <div class="header-right">
                                    <?php if( $btn_lbl && $btn_link ) echo '<div class="book-btn"><a href="' . esc_url( $btn_link ) . '" class="btn btn-sm btn-primary"' . esc_attr( $new_tab ) . '>' . esc_html( $btn_lbl ) . '</a></div>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            /**
             * Mobile Navigation
            */
            hotell_mobile_navigation();
        ?>
    </header>
<?php 
}
endif;
add_action( 'hotell_header', 'hotell_header', 20 );

if( ! function_exists( 'hotell_content_start' ) ) :
/**
 * Content Start
*/
function hotell_content_start(){ ?>
    <div id="content" class="site-content">
<?php }
endif;
add_action( 'hotell_after_header', 'hotell_content_start', 40 );

if( ! function_exists( 'hotell_banner' ) ) :
/**
 * Banner Section 
*/
function hotell_banner(){
    if( is_front_page() ) hotell_get_banner();   
}
endif;
add_action( 'hotell_after_header', 'hotell_banner', 15 );

if( ! function_exists( 'hotell_top_bar' ) ) :
/**
 * Top bar for single page and post
 * 
*/
function hotell_top_bar(){
    if( ( is_home() || is_singular() || is_archive() || is_search() || is_404() ) && ! is_front_page() ){  
        $image_url = hotell_get_breadcrumb_image_url(); ?>
        <div class="breadcrumb-wrapper" <?php if( $image_url ) echo 'style="background-image: url(' . esc_url( $image_url ) . ')"'; ?>>
    		<div class="container">
                <div class="breadcrumb-text">
                    <?php
                        hotell_breadcrumb_entry_header();
                        //Breadcrumb
                        hotell_breadcrumb();
                    ?>
                </div>
    		</div>
    	</div>   
        <?php 
    }    
}
endif;
add_action( 'hotell_after_header', 'hotell_top_bar', 30 );

if( ! function_exists( 'hotell_entry_header' ) ) :
/**
 * Entry Header
*/
function hotell_entry_header(){ 
    if( ! is_singular() ) echo '<div class="card__content">'; ?>
        <?php             
            if( 'post' === get_post_type() ){
                hotell_posts_meta();
            }
            if( is_home() && ! is_front_page() ){
                the_title( '<h5><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
                if( has_excerpt() ){
                    the_excerpt(); 
                }else{
                    echo wpautop( wp_trim_words( get_the_content(),10,'..' ) );
                }
            }elseif( is_archive() || is_search() ){
                the_title( sprintf( '<h5><a href="%s" rel="bookmark">',  esc_url( get_permalink() ) ), '</a></h5>' );            
            }
        ?>
    <?php    
}
endif;
add_action( 'hotell_before_post_entry_content', 'hotell_entry_header', 20 );

if ( ! function_exists( 'hotell_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element.
 */
function hotell_post_thumbnail() {
    if ( is_singular() ) return false; 
    
    if( is_home() || is_archive() || is_search() ){        
        echo '<figure class="card__img"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
        if( has_post_thumbnail() ){                                   
            the_post_thumbnail( 'hotell-offers-section', array( 'itemprop' => 'image' ) );               
        }else{
            hotell_get_fallback_svg( 'hotell-offers-section' );//fallback   
        }        
        echo '</a></figure>';
    }
}
endif;
add_action( 'hotell_before_post_entry_content', 'hotell_post_thumbnail', 10 );

if( ! function_exists( 'hotell_entry_content' ) ) :
/**
 * Entry Content
*/
function hotell_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); ?>
    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hotell' ),
    				'after'  => '</div>',
    			) );
            }elseif( ! is_home() ){
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'hotell_page_entry_content', 'hotell_entry_content', 15 );
add_action( 'hotell_post_entry_content', 'hotell_entry_content', 15 );

if( ! function_exists( 'hotell_entry_footer' ) ) :
/**
 * Entry Footer
*/
function hotell_entry_footer(){ 
    $readmore = get_theme_mod( 'read_more_text', __( 'Read More', 'hotell' ) ); ?>
	<footer class="entry-footer">
		<?php
			if( is_single() ){
			    hotell_tag();
			}
            
            if( is_front_page() || is_home() ){
                echo '<a href="' . esc_url( get_the_permalink() ) . '" class="btn-readmore">' . esc_html( $readmore ) . '
                <span>' . hotell_misc_svg( 'arrow' ) . '</span></a>';    
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'hotell' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
    <?php if( ! is_singular() ) echo '</div>'; ?><!-- .card__content -->
	<?php 
}
endif;
add_action( 'hotell_page_entry_content', 'hotell_entry_footer', 20 );
add_action( 'hotell_post_entry_content', 'hotell_entry_footer', 20 );

if( ! function_exists( 'hotell_content_wrapper_start' ) ) :
/**
 * Content Wrapper
*/
function hotell_content_wrapper_start(){ ?>
    <div id="primary" class="content-area">
		<div class="container">
            <?php if( is_author() ) hotell_author_box();
            if ( ! is_page_template( 'templates/contact.php' ) ) echo '<div class="page-grid">';
				echo '<main id="main" class="site-main">';
					if( ! is_singular() && ! is_404() ) echo '<div class="grid-layout-wrap"><div class="row">';
}
endif;
add_action( 'hotell_before_posts_content', 'hotell_content_wrapper_start' );

if( ! function_exists( 'hotell_content_wrapper_end' ) ) :
/**
 * Content Wrapper
*/
function hotell_content_wrapper_end(){ ?>
                    <?php if( ! is_singular() && ! is_404() ) echo '</div></div>';
                    if( is_archive() || is_home() ) hotell_navigation();
                if( is_single() ) hotell_single_entry_footer_sections();
            echo '</main>';   
            if( !( 'mphb_room_type' == get_post_type() || is_404() || is_page_template( 'templates/contact.php' ) ) ) get_sidebar();
        if ( ! is_page_template( 'templates/contact.php' ) ) echo '</div>';
    echo '</div>';
}
endif;
add_action( 'hotell_after_posts_content', 'hotell_content_wrapper_end', 10 );

if( ! function_exists( 'hotell_navigation' ) ) :
/**
 * Navigation
*/
function hotell_navigation(){
    if( is_singular() ){ 
        $next_post	= get_next_post();
        $prev_post  = get_previous_post();
        
        if( $next_post || $prev_post ){ ?>
            <nav class="post-navigation">
                <div class="nav-links">
                    <?php if( $prev_post ){ ?>
                        <div class="nav-previous">
                            <a href="<?php the_permalink( $prev_post->ID ); ?>" rel="prev">
                                    <div class="pagination-details">
                                        <header class="entry-header">
                                            <h3 class="entry-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h3>  
                                        </header>
                                        <span class="meta-nav"><?php echo esc_html__( 'Prev', 'hotell' ); ?></span>
                                    </div>
                                </article>
                            </a>
                        </div>
                    <?php }
                    if( $next_post ){ ?>
                        <div class="nav-next">
                            <a href="<?php the_permalink( $next_post->ID ); ?>" rel="next">
                                <article class="post">
                                    <div class="pagination-details">
                                        <header class="entry-header">
                                            <h3 class="entry-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h3>
                                        </header>
                                        <span class="meta-nav"><?php echo esc_html__( 'Next', 'hotell' ); ?></span>
                                    </div>
                                </article>
                            </a>
                        </div>
                    <?php } ?>
                </div>	
            </nav>
        <?php }
    }else{
        echo '<div class="default">';
        
        the_posts_navigation();
        
        echo '</div>';       
    }
}
endif;
add_action( 'hotell_after_posts_content', 'hotell_navigation', 15 );

if( ! function_exists( 'hotell_related_posts' ) ) :
/**
 * Related Posts 
*/
function hotell_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    
    if( $ed_related_post ){
        hotell_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'hotell_after_posts_content', 'hotell_related_posts', 35 );

if( ! function_exists( 'hotell_latest_posts' ) ) :
/**
 * Latest Posts
*/
function hotell_latest_posts(){ 
    hotell_get_posts_list( 'latest' );
}
endif;
add_action( 'hotell_latest_posts', 'hotell_latest_posts' );

if( ! function_exists( 'hotell_comment' ) ) :
/**
 * Comments Template 
*/
function hotell_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;
add_action( 'hotell_after_posts_content', 'hotell_comment', 20 );
add_action( 'hotell_after_page_content', 'hotell_comment' );

if( ! function_exists( 'hotell_contact_top_section' ) ) :
/**
 * Contact Top Section
*/
function hotell_contact_top_section(){ 
    $contact_page_subtitle  = get_theme_mod( 'contact_subtitle' );
    $contact_page_title     = get_theme_mod( 'contact_title' );
    $page_content           = get_theme_mod( 'contact_content' );
    
    if( $contact_page_title || $contact_page_subtitle || $page_content ){
        echo '<div class="section-header section-header--fixed-width">';
        echo '<span class="section-header__tag section-header__tag--sideLine">' . esc_html( $contact_page_subtitle ) . '</span>';
        echo '<h2 class="section-header__title section-header__title-2">' . esc_html( $contact_page_title ) . '</h2>';
        echo wp_kses_post( wpautop( $page_content ) );
        echo '</div>';
    }
}
endif;
add_action( 'hotell_contact_page', 'hotell_contact_top_section', 10 );

if( ! function_exists( 'hotell_phone_details' ) ) :
/**
 * Contact Phone details
*/
function hotell_phone_details(){
    $contact_phone   = get_theme_mod( 'phone_number' );
    $phone_label     = get_theme_mod( 'phone_title' );
    $numbers         = explode( ',', $contact_phone );

    if( $phone_label || $contact_phone ){ ?>
        <div class="contact__info">
            <div class="icon">
               <?php echo hotell_social_icons_svg_list( 'phone' ); ?>
            </div>
            <div class="contact__details">
                <?php 
                    if( $phone_label ) echo '<h5 class="contact-title phone">' . esc_html( $phone_label ) . '</h5>';
                    if( $contact_phone ) {
                        foreach( $numbers as $phone ){ ?>
                            <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ); ?>" class="tel-link">
                                <?php echo esc_html( $phone ); ?>
                            </a>
                        <?php }
                    }
                ?>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'hotell_contact_page_details', 'hotell_phone_details', 10 );

if( ! function_exists( 'hotell_email_details' ) ) :
/**
 * Contact Email details
*/
function hotell_email_details(){
    $contact_email   = get_theme_mod( 'mail_description' );
    $email_label     = get_theme_mod( 'mail_title' );
    $emails          = explode( ',', $contact_email);

    if( $email_label || $contact_email ){ ?>
        <div class="contact__info">
            <div class="icon">
                <?php echo hotell_misc_svg( 'email-contact' ); ?>
            </div>
            <div class="contact__details">
                <?php 
                    if( $email_label ) echo '<h5 class="contact-title email">' . esc_html( $email_label ) . '</h5>';
                    if( $contact_email ) {
                        foreach( $emails as $email ){ ?>
                            <a href="<?php echo esc_url( 'mailto:' . sanitize_email( $email ) ); ?>" class="email-link">
                                <?php echo esc_html( $email ); ?>
                            </a>
                        <?php }
                    }
                ?>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'hotell_contact_page_details', 'hotell_email_details', 20 );

if( ! function_exists( 'hotell_address_details' ) ) :
/**
 * Contact address details
*/
function hotell_address_details(){
    $contact_address = get_theme_mod( 'location' );
    $address_label   = get_theme_mod( 'location_title' );

    if( $address_label || $contact_address ){ ?>
        <div class="contact__info">
            <div class="icon">
                <?php echo hotell_misc_svg( 'location-contact' ); ?>
            </div>
            <div class="contact__details">
                <?php 
                    if( $address_label ) echo '<h5 class="contact-title location">' . esc_html( $address_label ) . '</h5>';
                    if( $contact_address ) echo '<span>' . esc_html( $contact_address ) . '</span>';
                ?>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'hotell_contact_page_details', 'hotell_address_details', 30 );


if( ! function_exists( 'hotell_timing_details' ) ) :
/**
 * Contact timing details
*/
function hotell_timing_details(){
    $contact_hours   = get_theme_mod( 'contact_hours' );
    $timing          = get_theme_mod( 'contact_hrs_content' );
    $hours           = explode( ',', $timing );

    if( $contact_hours || $timing ){ ?>
        <div class="contact__info">
            <div class="icon">
                <?php echo hotell_misc_svg( 'time-contact' ); ?>  
            </div>
            <div class="contact__details">
                <?php 
                    if( $contact_hours ) echo '<h5 class="contact-title timing">' . esc_html( $contact_hours ) . '</h5>';
                    if( $timing ){
                        foreach( $hours as $hour ){ ?>
                            <span><?php echo esc_html( $hour ); ?></span>
                        <?php }
                    }
                ?>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'hotell_contact_page_details', 'hotell_timing_details', 40 );

if( ! function_exists( 'hotell_contact_social_details' ) ) :
/**
 * Contact social details
*/
function hotell_contact_social_details(){
    $ed_social       = get_theme_mod( 'ed_social_contact', false );
    $contact_label   = get_theme_mod( 'social_title' );
    if( $ed_social ){ ?>
        <div class="contact__social">
            <h4><?php echo esc_html( $contact_label ); ?></h4>
            <?php hotell_social_links(); ?>
        </div>
    <?php } 
}
endif;
add_action( 'hotell_contact_page_details', 'hotell_contact_social_details', 45 );

if( ! function_exists( 'hotell_content_end' ) ) :
/**
 * Content End
*/
function hotell_content_end(){ 
    if( ! is_front_page() ){        
        if( ! is_404() ) echo '</div><!-- .row -->'; ?>            
        </div><!-- .container/ -->        
    </div><!-- .error-holder/site-content -->
    <?php } ?>
<?php
}
endif;
add_action( 'hotell_before_footer', 'hotell_content_end', 20 );

if( ! function_exists( 'hotell_footer_start' ) ) :
/**
 * Footer Start
*/
function hotell_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'hotell_footer', 'hotell_footer_start', 20 );

if( ! function_exists( 'hotell_footer_top' ) ) :
/**
 * Footer Top
*/
function hotell_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-top">
    		<div class="container">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
    				<div class="col">
    				   <?php dynamic_sidebar( $active ); ?>	
    				</div>
                <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }   
}
endif;
add_action( 'hotell_footer', 'hotell_footer_top', 30 );

if( ! function_exists( 'hotell_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function hotell_footer_bottom(){ ?>
    <div class="footer-bottom">
		<div class="container">
			<div class="site-info">            
            <?php
                hotell_get_footer_copyright();
                hotell_ed_author_link();
                hotell_ed_wp_link();
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>               
            </div>
		</div>
	</div>
    <?php
}
endif;
add_action( 'hotell_footer', 'hotell_footer_bottom', 40 );

if( ! function_exists( 'hotell_footer_end' ) ) :
/**
 * Footer End 
*/
function hotell_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'hotell_footer', 'hotell_footer_end', 50 );

if( ! function_exists( 'hotell_back_to_top' ) ) :
/**
 * Back to top
*/
function hotell_back_to_top(){ ?>
    <div id="back-to-top">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g transform="translate(-1789 -1176)"><rect width="24" height="2.667" transform="translate(1789 1176)" fill="#fff"></rect><path d="M-215.453,382.373-221.427,372l-5.973,10.373h4.64v8.293h2.667v-8.293Z" transform="translate(2022.427 809.333)" fill="#fff"></path></g></svg>
	</div>
    <?php
}
endif;
add_action( 'hotell_after_footer', 'hotell_back_to_top', 15 );

if( ! function_exists( 'hotell_page_end' ) ) :
/**
 * Page End
*/
function hotell_page_end(){ ?>
        </div><!-- #content -->    
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'hotell_after_footer', 'hotell_page_end', 20 );

if( ! function_exists( 'hotell_author_box' ) ) :
/**
 * Author Section
*/
function hotell_author_box(){ 
    $ed_author    = get_theme_mod( 'ed_author', true );
    $author_title = get_theme_mod( 'author_title' );
    if( $ed_author ){ ?>
        <div class="author-section">
            <div class="author-wrapper">
                <figure class="author-img">
                    <?php 
                        echo get_avatar( get_the_author_meta( 'ID' ), 172 );
                        echo '<span class="author-count">';
                        printf( __( '%s Post', 'hotell' ), count_user_posts( get_the_author_meta( 'ID' ) ) ); 
                        echo '</span>'; 
                    ?>
                </figure>
                <div class="author-wrap">
                    <?php 
                        if( $author_title ) echo '<span>' . esc_html( $author_title ) . '</span>';
                        echo '<h4 class="author-name">';
                        the_author();
                        echo '</h4>';
                        echo '<div class="author-content">' . wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ) . '</div>';
                    ?>		
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'hotell_after_posts_content', 'hotell_author_box', 10 );