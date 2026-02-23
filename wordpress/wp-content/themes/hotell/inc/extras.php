<?php
/**
 * hotell pro Standalone Functions.
 *
 * @package Hotell
 */

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
    /**
     * Triggered after the opening <body> tag.
    */
    do_action( 'wp_body_open' );
}
endif;

if ( ! function_exists( 'hotell_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function hotell_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

    $posted_on =  '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'hotell_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author.
 */
function hotell_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( '%s', 'post author', 'hotell' ),
		'<span itemprop="name"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url">' . esc_html( get_the_author() ) . '</a></span>'
    );
	echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person">' . $byline . '</span>';
}
endif;

if( ! function_exists( 'hotell_comment_count' ) ) :
/**
 * Comment Count
*/
function hotell_comment_count(){
    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments"><i class="far fa-comment"></i>';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'hotell' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'hotell_category' ) ) :
/**
 * Prints categories
 */
function hotell_category(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'hotell' ) );
		if ( $categories_list ) {
			echo '<span class="cat-links banner__stitle" itemprop="about">' . $categories_list . '</span>';
		}
	}
}
endif;

if ( ! function_exists( 'hotell_tag' ) ) :
/**
 * Prints tags
 */
function hotell_tag(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<div class="tags" itemprop="about">' . esc_html__( '%1$sTags:%2$s %3$s', 'hotell' ) . '</div>', '<span>', '</span>', $tags_list );
		}
	}
}
endif;

if( ! function_exists( 'hotell_get_posts_list' ) ) :
/**
 * Returns Latest, Related & Popular Posts
*/
function hotell_get_posts_list( $status ){
    global $post;
    $readmore = get_theme_mod( 'read_more_text', __( 'Read More', 'hotell' ) );

    $args = array(
        'post_type'           => 'post',
        'posts_status'        => 'publish',
        'ignore_sticky_posts' => true
    );

    switch( $status ){
        case 'latest':
        $args['posts_per_page'] = 3;
        $title                  = __( 'You may also like', 'hotell' );
        $class                  = 'recent-posts';
        $image_size             = 'hotell-related-post';
        break;

        case 'related':
        $args['posts_per_page'] = 2;
        $args['post__not_in']   = array( $post->ID );
        $args['orderby']        = 'rand';
        $title                  = get_theme_mod( 'related_post_title', __( 'You may also like', 'hotell' ) );
        $class                  = 'related-posts';
        $image_size             = 'hotell-related-post';

        $cats = get_the_category( $post->ID );
        if( $cats ){
            $c = array();
            foreach( $cats as $cat ){
                $c[] = $cat->term_id;
            }
            $args['category__in'] = $c;
        }
        break;

    }

    $qry = new WP_Query( $args );

    if( $qry->have_posts() ){ ?>
        <div class="<?php echo esc_attr( $class ); ?> blog">
    		<?php
            if( $title ) echo '<div class="section-header"><h2 class="section-header__title">' . esc_html( $title ) . '</h2></div>';
            echo '<div class="grid-layout-wrap"><div class="row">';
            while( $qry->have_posts() ){ $qry->the_post(); ?>
                <article class="post">
                    <div class="card blog-card">
                        <figure class="card__img">
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                <?php
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                                    }else{
                                        hotell_get_fallback_svg( $image_size );//fallback
                                    }
                                ?>
                            </a>
                        </figure>
                        <?php
                            echo '<div class="card__content">';
                            if( ! is_singular( 'mphb_room_type' ) ) hotell_icon_meta();
                            the_title( sprintf( '<h5><a href="%s" rel="bookmark">',  esc_url( get_permalink() ) ), '</a></h5>' );
                            if( has_excerpt() ){
                                the_excerpt();
                            }else{
                                echo wpautop( wp_trim_words( get_the_content(),10,'..' ) );
                            }
                            echo '<a href="' . esc_url( get_permalink() ) . '" class="btn-text">' . esc_html( $readmore ) . '<span>' . hotell_misc_svg( 'arrow' ) . '</span></a>';
                            echo '</div>';
                        ?>
                    </div>
                </article>
			<?php } ?>
    	</div>
        <?php
        wp_reset_postdata();
    }
}
endif;

if( ! function_exists( 'hotell_site_branding' ) ) :
/**
 * Site Branding
*/
function hotell_site_branding( $is_mobile = false ){ ?>
    <div class="site-branding" itemscope itemtype="http://schema.org/Organization">
		<?php
            if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                the_custom_logo();
            }

            if( is_front_page() && !$is_mobile ){ ?>
                <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
        		<?php
            }else{ ?>
                <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
            <?php
            }
            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ){ ?>
                <p class="site-description" itemprop="description"><?php echo $description; ?></p>
            <?php

            }
        ?>
	</div>
    <?php
}
endif;

if( ! function_exists( 'hotell_social_links' ) ) {
    /**
     * Social Links
    */
    function hotell_social_links( $echo = true ){
        $social_links = get_theme_mod( 'social_links' );
        $ed_social    = get_theme_mod( 'ed_social_links', false );

        if( $ed_social && $social_links && $echo ){ ?>
        <div class="social-wrap">
            <ul class="social-networks">
                <?php
                foreach( $social_links as $link ){
                    $new_tab = isset( $link['hp_checkbox'] ) && $link['hp_checkbox'] ? '_blank' : '_self';
                    if( isset( $link['hp_link'] ) && $link['hp_link'] ){ ?>
                    <li>
                        <a href="<?php echo esc_url( $link['hp_link'] ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="nofollow noopener">
                            <?php echo wp_kses( hotell_social_icons_svg_list( $link['hp_icon'] ), hotell_get_kses_extended_ruleset() ); ?>
                        </a>
                    </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
        <?php
        }elseif( $ed_social && $social_links ){
            return true;
        }else{
            return false;
        }
        ?>
        <?php
    }
}

if( ! function_exists( 'hotell_primary_nagivation' ) ) :
/**
 * Primary Navigation.
*/
function hotell_primary_nagivation(){ ?>
    <div class="overlay"></div>
    <?php if ( current_user_can( 'manage_options' ) || has_nav_menu( 'primary' ) ) { ?>
        <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => 'hotell_primary_menu_fallback',
                ) );
            ?>
        </nav><!-- #site-navigation -->
    <?php }
}
endif;

if( ! function_exists( 'hotell_primary_menu_fallback' ) ) :
/**
 * Fallback for primary menu
*/
function hotell_primary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'hotell' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'hotell_breadcrumb' ) ) :
/**
 * Breadcrumbs
*/
function hotell_breadcrumb(){
    global $post;
    $post_page  = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front = get_option( 'show_on_front' ); //What to show on the front page
    $home       = get_theme_mod( 'home_text', __( 'Home', 'hotell' ) ); // text for the 'Home' link
    $delimiter  = '<span class="separator"> / </span>';
    $before     = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after      = '</span>'; // tag after the current crumb

    if( get_theme_mod( 'ed_breadcrumb', true ) ){
        $depth = 1;
        echo '<div id="crumbs" class="breadcrumb-nav" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="' . esc_url( home_url() ) . '" itemprop="item"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';

        if( is_home() ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="'. esc_url( get_the_permalink() ) .'"><span itemprop="name">' . esc_html( single_post_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( is_category() ){
            $depth = 2;
            $thisCat = get_category( get_query_var( 'cat' ), false );
            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            if( $thisCat->parent != 0 ){
                $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                $parent_categories = explode( ',', $parent_categories );
                foreach( $parent_categories as $parent_term ){
                    $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                    if( is_object( $parent_obj ) ){
                        $term_url  = get_term_link( $parent_obj->term_id );
                        $term_name = $parent_obj->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $thisCat->term_id) ) . '"><span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( is_tag() ){
            $depth          = 2;
            $queried_object = get_queried_object();
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( single_tag_title( '', false ) ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />'. $after;
        }elseif( is_author() ){
            global $author;
            $depth    = 2;
            $userdata = get_userdata( $author );
            echo $before . '<a itemprop="item" href="' . esc_url( get_author_posts_url( $author ) ) . '"><span itemprop="name">' . esc_html( $userdata->display_name ) .'</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_search() ){
            $depth       = 2;
            $request_uri = $_SERVER['REQUEST_URI'];
            echo $before . '<a itemprop="item" href="'. esc_url( $request_uri ) . '"><span itemprop="name">' . sprintf( __( 'Search Results for "%s"', 'hotell' ), esc_html( get_search_query() ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( is_day() ){
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'hotell' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'hotell' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'hotell' ) ), get_the_time( __( 'm', 'hotell' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'hotell' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_day_link( get_the_time( __( 'Y', 'hotell' ) ), get_the_time( __( 'm', 'hotell' ) ), get_the_time( __( 'd', 'hotell' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'd', 'hotell' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( is_month() ){
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'hotell' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'hotell' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'hotell' ) ), get_the_time( __( 'm', 'hotell' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'hotell' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( is_year() ){
            $depth = 2;
            echo $before .'<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'hotell' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'hotell' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_single() && !is_attachment() ){
            $depth = 2;
            if( get_post_type() != 'post' ){
                $post_type = get_post_type_object( get_post_type() );
                if( $post_type->has_archive == true ){// For CPT Archive Link
                   // Add support for a non-standard label of 'archive_title' (special use case).
                   $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
                   echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';
                   $depth++;
                }
                echo $before . '<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
            }else{ //For Post
                $cat_object       = get_the_category();
                $potential_parent = 0;

                if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                    $p = get_post( $post_page );
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';
                    $depth++;
                }

                if( $cat_object ){ //Getting category hierarchy if any
                    //Now try to find the deepest term of those that we know of
                    $use_term = key( $cat_object );
                    foreach( $cat_object as $key => $object ){
                        //Can't use the next($cat_object) trick since order is unknown
                        if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                            $use_term         = $key;
                            $potential_parent = $object->term_id;
                        }
                    }
                    $cat  = $cat_object[$use_term];
                    $cats = get_category_parents( $cat, false, ',' );
                    $cats = explode( ',', $cats );
                    foreach ( $cats as $cat ) {
                        $cat_obj = get_term_by( 'name', $cat, 'category' );
                        if( is_object( $cat_obj ) ){
                            $term_url  = get_term_link( $cat_obj->term_id );
                            $term_name = $cat_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
            }
        }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){ //For Custom Post Archive
            $depth     = 2;
            $post_type = get_post_type_object( get_post_type() );
            if( get_query_var('paged') ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '/</span>';
                echo $before . sprintf( __('Page %s', 'hotell'), get_query_var('paged') ) . $after;
            }else{
                echo $before . '<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
            }
        }elseif( is_attachment() ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && !$post->post_parent ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && $post->post_parent ){
            $depth       = 2;
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while( $parent_id ){
                $current_page  = get_post( $parent_id );
                $breadcrumbs[] = $current_page->ID;
                $parent_id     = $current_page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            echo $before . '<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" /></span>' . $after;
        }elseif( is_404() ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( home_url() ) . '"><span itemprop="name">' . esc_html__( '404 Error - Page Not Found', 'hotell' ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
        }

        if( get_query_var('paged') ) printf( __( ' (Page %s)', 'hotell' ), get_query_var('paged') );

        echo '</div><!-- .crumbs -->';

    }
}
endif;

if( ! function_exists( 'hotell_get_banner' ) ) :
/**
 * Prints Banner Section
 *
*/
function hotell_get_banner(){
    $ed_banner         = get_theme_mod( 'ed_banner_section', 'static_banner' );
    $read_more         = get_theme_mod( 'slider_readmore' );
    $read_more_link    = get_theme_mod( 'banner_readmore_link' );
    $btn_lbl           = get_theme_mod( 'slider_btn_lbl' );
    $btn_link          = get_theme_mod( 'slider_btn_link' );
    $slider_target     = get_theme_mod( 'slider_btn_new_tab', false ) ? 'target=_blank' : '';
    $banner_title      = get_theme_mod( 'banner_title' );
    $banner_subtitle   = get_theme_mod( 'banner_subtitle' );
    $caption_overlay   = get_theme_mod( 'banner_caption_overlay', false );

    ( $caption_overlay ) ? $overlay = ' caption-overlay' : $overlay = '';

    if( ( $ed_banner == 'static_banner' ) && has_custom_header() ){ ?>
        <div id="banner_section" class="banner left-align <?php if( has_header_video() ) echo esc_attr( ' banner-video ' ); ?>">
            <?php
            the_custom_header_markup();
            if( $ed_banner == 'static_banner' && ( $banner_title || $banner_subtitle || ( $btn_lbl && $btn_link ) ) ){ ?>
                <div class="banner__wrap">
                    <div class="container">
                        <div class="banner__text<?php echo esc_attr( $overlay ); ?>">
                            <?php
                                if( $banner_subtitle ) echo '<span class="banner__stitle">' . esc_html( $banner_subtitle ) . '</span>';
                                if ( $banner_title ) echo '<h2 class="banner__title">' . esc_html( $banner_title ) . '</h2>';
                                if( ( $btn_lbl && $btn_link ) || ( $read_more && $read_more_link ) ) { ?>
                                    <div class="btn-wrap">
                                        <?php
                                            if( $btn_lbl && $btn_link ) echo '<a href="' . esc_url( $btn_link ) . '" class="btn btn-lg btn-primary"' . esc_attr( $slider_target ) . '>' . esc_html( $btn_lbl ) . '</a>';
                                            if( $read_more && $read_more_link ) echo '<a href="' . esc_url( $read_more_link ) . '" class="btn btn-lg btn-outline btn-white"' . esc_attr( $slider_target ) . '>' . esc_html( $read_more ) . '</a>';
                                        ?>
                                    </div>
                                <?php }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'hotell_theme_comment' ) ) :
/**
 * Callback function for Comment List *
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments
 */
function hotell_theme_comment( $comment, $args, $depth ){
    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }?>
    <<?php echo esc_html( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">

    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
    <?php endif; ?>
        <article class="comment-body">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'hotell' ); ?></em>
                        <br />
                    <?php endif;
                    if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                    <?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b>', 'hotell' ), get_comment_author_link() ); ?>
                </div><!-- .comment-author vcard -->
                <div class="comment-metadata">
                    <?php esc_html_e( 'Posted on', 'hotell' );?>
                    <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
                        <time itemprop="commentTime" datetime="<?php echo esc_attr( get_gmt_from_date( get_comment_date() . get_comment_time(), 'Y-m-d H:i:s' ) ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'hotell' ), get_comment_date(),  get_comment_time() ); ?></time>
                    </a>
                </div>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
            </div>
        </article>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div><!-- .comment-body -->
    <?php endif;
}
endif;

if( ! function_exists( 'hotell_sidebar' ) ) :
/**
 * Return sidebar layouts for pages/posts
*/
function hotell_sidebar( $class = false ){
    global $post;
    $return       = $return = $class ? 'full-width' : false; //Fullwidth
    $layout       = get_theme_mod( 'layout_style', 'right-sidebar' ); //Default Layout Style for Styling Settings
    $page_layout  = get_theme_mod( 'page_sidebar_layout', 'right-sidebar' ); //Global Layout/Position for Pages
    $post_layout  = get_theme_mod( 'post_sidebar_layout', 'right-sidebar' ); //Global Layout/Position for Posts

    if ( is_404() ) return;

    if( is_singular() ){
        if( get_post_meta( $post->ID, '_hotell_sidebar_layout', true ) ){
            $sidebar_layout = get_post_meta( $post->ID, '_hotell_sidebar_layout', true );
        }else{
            $sidebar_layout = 'default-sidebar';
        }
        if( is_page() ){
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' ){
                    $return = 'full-width';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = 'rightsidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = 'leftsidebar';
                }elseif( $sidebar_layout == 'default-sidebar' && $page_layout == 'no-sidebar' ){
                    $return = 'full-width';
                }
            }else{
                $return = 'full-width';
            }
        }elseif( is_single() ){
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' ){
                    $return = 'full-width';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = 'rightsidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = 'leftsidebar';
                }elseif( $sidebar_layout == 'default-sidebar' && $post_layout == 'no-sidebar' ){
                    $return = 'full-width';
                }
            }else{
                $return = 'full-width';
            }
        }
    }elseif( is_archive() || is_search() ){
        if( is_tax( 'mphb_room_type_facility' ) ) return 'full-width';
        //archive page
        if( is_active_sidebar( 'sidebar' ) ){
            if( $layout == 'no-sidebar' ){
                $return = 'full-width';
            }elseif( $layout == 'right-sidebar' ){
                $return = 'rightsidebar';
            }elseif( $layout == 'left-sidebar' ) {
                $return = 'leftsidebar';
            }
        }else{
            $return = 'full-width';
        }
    }else{
        if( is_active_sidebar( 'sidebar' ) ){
            $return = 'rightsidebar';
        }else{
            $return = 'full-width';
        }
    }

    return $return;
}
endif;

if( ! function_exists( 'hotell_get_posts' ) ) :
/**
 * Fuction to list Custom Post Type
*/
function hotell_get_posts( $post_type = 'post', $slug = false ){
    $args = array(
    	'posts_per_page'   => -1,
    	'post_type'        => $post_type,
    	'post_status'      => 'publish',
    	'suppress_filters' => true
    );
    $posts_array = get_posts( $args );

    // Initate an empty array
    $post_options = array();
    $post_options[''] = __( ' -- Choose -- ', 'hotell' );
    if ( ! empty( $posts_array ) ) {
        foreach ( $posts_array as $posts ) {
            if( $slug ){
                $post_options[ $posts->post_title ] = $posts->post_title;
            }else{
                $post_options[ $posts->ID ] = $posts->post_title;
            }
        }
    }
    return $post_options;
    wp_reset_postdata();
}
endif;

if( ! function_exists( 'hotell_get_page_template_url' ) ) :
/**
 * Returns page template url if not found returns home page url
*/
function hotell_get_page_template_url( $page_template ){
    $args = array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => $page_template,
        'post_type'  => 'page',
        'fields'     => 'ids',
    );

    $posts_array = get_posts( $args );

    $url = ( $posts_array ) ? get_permalink( $posts_array[0] ) : get_permalink( get_option( 'page_on_front' ) );
    return $url;
}
endif;


if( ! function_exists( 'hotell_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function hotell_get_image_sizes( $size = '' ) {

    global $_wp_additional_image_sizes;

    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();

    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    }
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'hotell_get_fallback_svg' ) ) :
/**
 * Get Fallback SVG
*/
function hotell_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }

    $image_size = hotell_get_image_sizes( $post_thumbnail );

    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:var(--hotel-primary-color);opacity:0.40;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'hotell_header_info' ) ) :
/**
 * Header Info
 */
function hotell_header_info(){
$location           = get_theme_mod( 'header_location' );
$email              = get_theme_mod( 'email' );
    if( $location || $email ){ ?>
        <div class="info">
            <?php
                if( $location ) echo '<span class="location-link">' . hotell_social_icons_svg_list( 'location' ) . esc_html( $location ) . '</span>';
                if( $email ) echo '<a href="' . esc_url( 'mailto:' . sanitize_email( $email ) ) . '" class="email-link">' . hotell_social_icons_svg_list( 'email' ) . esc_html( $email ) . '</a>';
            ?>
        </div>
    <?php }
}
endif;

if( ! function_exists( 'hotell_breadcrumb_entry_header' ) ) :
/**
 * Breadcrumb Entry header
 */
function hotell_breadcrumb_entry_header(){ ?>
    <header class="entry-header">
        <?php if ( is_home() && ! is_front_page() ){
            echo '<h1 class="entry-title">';
            single_post_title();
            echo '</h1>';
        }

        if( is_archive() ){
            the_archive_title( '<h1 class="entry-title">', '</h1>' );
        }

        if( is_search() ){
            echo '<h1 class="entry-title">';
            esc_html_e( 'Search Results For ', 'hotell' );
            the_search_query();
            echo '</h1>';
        }

        if( is_single() ){
            the_title( '<h1 class="entry-title">', '</h1>' );
        }
        if( is_page() ){
            the_title( '<h1 class="entry-title">', '</h1>' );
        }
        if( is_404() ){
            echo '<h1 class="entry-title">';
            esc_html_e( 'Error Page', 'hotell' );
            echo '</h1>';
        } ?>
    </header>
<?php }
endif;

if( ! function_exists( 'hotell_posts_meta' ) ) :
/**
 * Breadcrumb Entry header
 */
function hotell_posts_meta(){
    $ed_category    = get_theme_mod( 'ed_category', false );
    $ed_post_date   = get_theme_mod( 'ed_post_date', false );

    if( is_single() ) {
        if( 'post' == get_post_type() ){
            if( !$ed_category ) {
                echo '<div class="category-wrap">';
                hotell_category();
                echo '</div>';
            }
            echo '<div class="entry-meta"><span class="author-details">';
            echo get_avatar( get_the_author_meta( 'ID' ), 32 );
            hotell_posted_by();
            echo '</span>';
            if( !$ed_post_date ) hotell_posted_on();
            echo '</div>';
        }
    }else{
        hotell_icon_meta();
    }
}
endif;

if( ! function_exists( 'hotell_icon_meta' ) ) :
/**
 * SVG meta values
 */
function hotell_icon_meta(){
    $ed_author_img = get_theme_mod( 'ed_author_img', false ); ?>
    <ul class="meta">
        <li>
            <?php
            if( $ed_author_img ){
                echo '<span class="author-details">';
                    echo get_avatar( get_the_author_meta( 'ID' ), 32 );
                echo '</span>';
            } else {
                echo hotell_misc_svg( 'admin' );
            }
            hotell_posted_by(); ?>
        </li>
        <li>
            <?php echo hotell_misc_svg( 'comment' ); ?>
            <span><?php echo esc_html( get_comments_number_text( '0 comments', '1 comment', '% comments', get_the_ID() ) ); ?></span>
        </li>
    </ul>
<?php }
endif;

if( ! function_exists( 'hotell_card_content' ) ) :
/**
 * Card content
*/
function hotell_card_content(){
    $blog_btn_lbl       = get_theme_mod( 'blog_btn_lbl', esc_html__( 'Read More', 'hotell' ) );
    echo '<div class="card__content">';
        hotell_posts_meta();
        the_title( '<h5><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
        if( has_excerpt() ){
            the_excerpt();
        }else{
            echo wpautop( wp_trim_words( get_the_content(),10,'..' ) );
        }
        if( $blog_btn_lbl ) echo '<a href="' . esc_url( get_permalink() ) . '" class="btn-text">' . esc_html( $blog_btn_lbl ) . '<span>' . hotell_misc_svg( 'arrow' ) . '</span></a>';
    echo '</div>';
}
endif;

if( ! function_exists( 'hotell_section_header' ) ) :
/**
 * Section header
*/
function hotell_section_header( $sec_title, $sec_subtitle, $sec_content ){
    if( $sec_title || $sec_subtitle || $sec_content ){ ?>
        <div class="section-header section-header--fixed-width">
            <?php
                if( $sec_subtitle ) echo '<span class="section-header__tag section-header__tag--sideLine">' . esc_html( $sec_subtitle ) . '</span>';
                if( $sec_title ) echo '<h2 class="section-header__title section-header__title-2">' . esc_html( $sec_title ) . '</h2>';
                if( $sec_content ) echo esc_html( $sec_content );
            ?>
        </div>
    <?php }
}
endif;

if ( ! function_exists( 'hotell_social_icons_svg_list' ) ) :
	/**
	 * Get SVG Image
	*/
	function hotell_social_icons_svg_list( $social ){

		if( !$social ){
			return;
		}
		switch ( $social ) {
			case 'facebook':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Facebook Icon">
					<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"/>
				</svg>';
			break;

			case 'twitter':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Twitter Icon">
					<path d="M20,3.8c-0.7,0.3-1.5,0.5-2.4,0.6c0.8-0.5,1.5-1.3,1.8-2.3c-0.8,0.5-1.7,0.8-2.6,1c-0.7-0.8-1.8-1.3-3-1.3c-2.3,0-4.1,1.8-4.1,4.1c0,0.3,0,0.6,0.1,0.9C6.4,6.7,3.4,5.1,1.4,2.6C1,3.2,0.8,3.9,0.8,4.7c0,1.4,0.7,2.7,1.8,3.4C2,8.1,1.4,7.9,0.8,7.6c0,0,0,0,0,0.1c0,2,1.4,3.6,3.3,4c-0.3,0.1-0.7,0.1-1.1,0.1c-0.3,0-0.5,0-0.8-0.1c0.5,1.6,2,2.8,3.8,2.8c-1.4,1.1-3.2,1.8-5.1,1.8c-0.3,0-0.7,0-1-0.1c1.8,1.2,4,1.8,6.3,1.8c7.5,0,11.7-6.3,11.7-11.7c0-0.2,0-0.4,0-0.5C18.8,5.3,19.4,4.6,20,3.8z"/>
				</svg>';
			break;

			case 'instagram':
				return '<svg width="20px" height="20px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" aria-label="Instagram Icon">
                <g>
                    <path d="M127.999746,23.06353 C162.177385,23.06353 166.225393,23.1936027 179.722476,23.8094161 C192.20235,24.3789926 198.979853,26.4642218 203.490736,28.2166477 C209.464938,30.5386501 213.729395,33.3128586 218.208268,37.7917319 C222.687141,42.2706052 225.46135,46.5350617 227.782844,52.5092638 C229.535778,57.0201472 231.621007,63.7976504 232.190584,76.277016 C232.806397,89.7746075 232.93647,93.8226147 232.93647,128.000254 C232.93647,162.177893 232.806397,166.225901 232.190584,179.722984 C231.621007,192.202858 229.535778,198.980361 227.782844,203.491244 C225.46135,209.465446 222.687141,213.729903 218.208268,218.208776 C213.729395,222.687649 209.464938,225.461858 203.490736,227.783352 C198.979853,229.536286 192.20235,231.621516 179.722476,232.191092 C166.227425,232.806905 162.179418,232.936978 127.999746,232.936978 C93.8200742,232.936978 89.772067,232.806905 76.277016,232.191092 C63.7971424,231.621516 57.0196391,229.536286 52.5092638,227.783352 C46.5345536,225.461858 42.2700971,222.687649 37.7912238,218.208776 C33.3123505,213.729903 30.538142,209.465446 28.2166477,203.491244 C26.4637138,198.980361 24.3784845,192.202858 23.808908,179.723492 C23.1930946,166.225901 23.0630219,162.177893 23.0630219,128.000254 C23.0630219,93.8226147 23.1930946,89.7746075 23.808908,76.2775241 C24.3784845,63.7976504 26.4637138,57.0201472 28.2166477,52.5092638 C30.538142,46.5350617 33.3123505,42.2706052 37.7912238,37.7917319 C42.2700971,33.3128586 46.5345536,30.5386501 52.5092638,28.2166477 C57.0196391,26.4642218 63.7971424,24.3789926 76.2765079,23.8094161 C89.7740994,23.1936027 93.8221066,23.06353 127.999746,23.06353 M127.999746,0 C93.2367791,0 88.8783247,0.147348072 75.2257637,0.770274749 C61.601148,1.39218523 52.2968794,3.55566141 44.1546281,6.72008828 C35.7374966,9.99121548 28.5992446,14.3679613 21.4833489,21.483857 C14.3674532,28.5997527 9.99070739,35.7380046 6.71958019,44.1551362 C3.55515331,52.2973875 1.39167714,61.6016561 0.769766653,75.2262718 C0.146839975,88.8783247 0,93.2372872 0,128.000254 C0,162.763221 0.146839975,167.122183 0.769766653,180.774236 C1.39167714,194.398852 3.55515331,203.703121 6.71958019,211.845372 C9.99070739,220.261995 14.3674532,227.400755 21.4833489,234.516651 C28.5992446,241.632547 35.7374966,246.009293 44.1546281,249.28042 C52.2968794,252.444847 61.601148,254.608323 75.2257637,255.230233 C88.8783247,255.85316 93.2367791,256 127.999746,256 C162.762713,256 167.121675,255.85316 180.773728,255.230233 C194.398344,254.608323 203.702613,252.444847 211.844864,249.28042 C220.261995,246.009293 227.400247,241.632547 234.516143,234.516651 C241.632039,227.400755 246.008785,220.262503 249.279912,211.845372 C252.444339,203.703121 254.607815,194.398852 255.229725,180.774236 C255.852652,167.122183 256,162.763221 256,128.000254 C256,93.2372872 255.852652,88.8783247 255.229725,75.2262718 C254.607815,61.6016561 252.444339,52.2973875 249.279912,44.1551362 C246.008785,35.7380046 241.632039,28.5997527 234.516143,21.483857 C227.400247,14.3679613 220.261995,9.99121548 211.844864,6.72008828 C203.702613,3.55566141 194.398344,1.39218523 180.773728,0.770274749 C167.121675,0.147348072 162.762713,0 127.999746,0 Z M127.999746,62.2703115 C91.698262,62.2703115 62.2698034,91.69877 62.2698034,128.000254 C62.2698034,164.301738 91.698262,193.730197 127.999746,193.730197 C164.30123,193.730197 193.729689,164.301738 193.729689,128.000254 C193.729689,91.69877 164.30123,62.2703115 127.999746,62.2703115 Z M127.999746,170.667175 C104.435741,170.667175 85.3328252,151.564259 85.3328252,128.000254 C85.3328252,104.436249 104.435741,85.3333333 127.999746,85.3333333 C151.563751,85.3333333 170.666667,104.436249 170.666667,128.000254 C170.666667,151.564259 151.563751,170.667175 127.999746,170.667175 Z M211.686338,59.6734287 C211.686338,68.1566129 204.809755,75.0337031 196.326571,75.0337031 C187.843387,75.0337031 180.966297,68.1566129 180.966297,59.6734287 C180.966297,51.1902445 187.843387,44.3136624 196.326571,44.3136624 C204.809755,44.3136624 211.686338,51.1902445 211.686338,59.6734287 Z"></path>
                </g>
                </svg>';
			break;

            case 'hotel':
                return '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_2240_353)">
                <path d="M17.2225 1.11082C16.6333 1.11082 16.0682 1.34489 15.6515 1.76153C15.2349 2.17818 15.0008 2.74327 15.0008 3.33249V6.94416L9.445 6.66666V2.77749C9.445 2.04074 9.15233 1.33417 8.63136 0.813206C8.1104 0.292245 7.40383 -0.000427246 6.66708 -0.000427246C5.93033 -0.000427246 5.22376 0.292245 4.7028 0.813206C4.18184 1.33417 3.88916 2.04074 3.88916 2.77749V17.2225C3.88916 18.7583 5.13166 20 6.66666 20C8.20166 20 9.445 18.7575 9.445 17.2225V12.7775H15.0008V17.2225C15.0008 17.5142 15.0583 17.8031 15.1699 18.0727C15.2816 18.3422 15.4452 18.5871 15.6515 18.7934C15.8578 18.9997 16.1028 19.1634 16.3723 19.275C16.6418 19.3867 16.9307 19.4442 17.2225 19.4442C17.5143 19.4442 17.8031 19.3867 18.0727 19.275C18.3422 19.1634 18.5872 18.9997 18.7935 18.7934C18.9998 18.5871 19.1634 18.3422 19.275 18.0727C19.3867 17.8031 19.4442 17.5142 19.4442 17.2225V3.33332C19.4442 2.7441 19.2101 2.17901 18.7935 1.76237C18.3768 1.34572 17.8117 1.11166 17.2225 1.11166V1.11082ZM3.33333 2.77749C3.33333 2.32916 3.42333 1.90166 3.585 1.51082C3.17094 1.75462 2.82753 2.10208 2.58862 2.51898C2.3497 2.93587 2.22352 3.40782 2.2225 3.88832V16.6675C2.2225 17.8608 2.97917 18.87 4.0375 19.2625C3.58164 18.6805 3.33374 17.9626 3.33333 17.2233V2.77749ZM1.91833 2.62166C1.50433 2.86552 1.16097 3.21299 0.922062 3.62987C0.683155 4.04676 0.556936 4.51867 0.555832 4.99916V15.5558C0.555832 16.5708 1.10583 17.4492 1.91833 17.9333C1.75197 17.5318 1.66644 17.1013 1.66667 16.6667V3.88832C1.66667 3.43999 1.75667 3.01332 1.91833 2.62166ZM14.445 3.33332C14.445 2.75166 14.6258 2.21332 14.9317 1.76666C14.4719 1.90025 14.0678 2.17916 13.7798 2.56163C13.4918 2.9441 13.3355 3.40956 13.3342 3.88832V6.30499L14.445 6.36082V3.33332ZM14.445 13.3333H13.3333V16.6667C13.3333 17.6758 14.01 18.5183 14.9308 18.7892C14.6137 18.3283 14.444 17.7819 14.4442 17.2225L14.445 13.3333ZM11.6667 16.1108C11.6667 17.12 12.3442 17.9625 13.2667 18.2333C12.9481 17.773 12.7775 17.2265 12.7775 16.6667V13.3333H11.6667V16.1108ZM12.7783 3.88832C12.7783 3.30749 12.9592 2.76832 13.265 2.32166C12.8051 2.45529 12.4009 2.73433 12.1129 3.11697C11.8249 3.49961 11.6686 3.96525 11.6675 4.44416V6.22166L12.7783 6.27749V3.88832Z" />
                </g>
                <defs>
                <clipPath id="clip0_2240_353">
                <rect width="20" height="20"/>
                </clipPath>
                </defs>
                </svg>';
                break;

			case 'pinterest':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Pinterest Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,4.1,2.5,7.6,6,9.2c0-0.7,0-1.5,0.2-2.3c0.2-0.8,1.3-5.4,1.3-5.4s-0.3-0.6-0.3-1.6c0-1.5,0.9-2.6,1.9-2.6c0.9,0,1.3,0.7,1.3,1.5c0,0.9-0.6,2.3-0.9,3.5c-0.3,1.1,0.5,1.9,1.6,1.9c1.9,0,3.2-2.4,3.2-5.3c0-2.2-1.5-3.8-4.2-3.8c-3,0-4.9,2.3-4.9,4.8c0,0.9,0.3,1.5,0.7,2C6,12,6.1,12.1,6,12.4c0,0.2-0.2,0.6-0.2,0.8c-0.1,0.3-0.3,0.3-0.5,0.3c-1.4-0.6-2-2.1-2-3.8c0-2.8,2.4-6.2,7.1-6.2c3.8,0,6.3,2.8,6.3,5.7c0,3.9-2.2,6.9-5.4,6.9c-1.1,0-2.1-0.6-2.4-1.2c0,0-0.6,2.3-0.7,2.7c-0.2,0.8-0.6,1.5-1,2.1C8.1,19.9,9,20,10,20c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0z"/>
				</svg>';
			break;

			case 'digg':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				aria-label="Digg Icon"
				viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M81.7 172.3H0V346.7H132.7V96H81.7V172.3V172.3ZM81.7 305.7H50.9V213.4H81.7V305.7ZM378.9 172.3V346.7H460.7V375.2H378.9V416H512V172.3H378.9V172.3ZM460.7 305.7H429.9V213.4H460.7V305.7ZM225.1 346.7H307.2V375.2H225.1V416H358.4V172.3H225.1V346.7ZM276.3 213.4H307.1V305.7H276.3V213.4ZM153.3 96H204.6V147H153.3V96ZM153.3 172.3H204.6V346.7H153.3V172.3Z" fill="black"/>
				</svg>';
			break;

			case 'telegram':
				return '<svg
				width="20px"
				height="20px"
				aria-label="Telegram Icon"
				viewBox="0 0 448 512" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M446.7 98.6L379.1 417.4C374 439.9 360.7 445.5 341.8 434.9L238.8 359L189.1 406.8C183.6 412.3 179 416.9 168.4 416.9L175.8 312L366.7 139.5C375 132.1 364.9 128 353.8 135.4L117.8 284L16.1998 252.2C-5.90022 245.3 -6.30022 230.1 20.7998 219.5L418.2 66.4C436.6 59.5 452.7 70.5 446.7 98.6V98.6Z" fill="black"/>
				</svg>';
			break;

			case 'getpocket':
				return '<svg
				width="20px"
				height="20px"
				aria-label="GetPocket Icon"
				viewBox="0 0 448 512" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M407.6 64H40.6C18.5 64 0 82.5 0 104.6V239.8C0 364.5 99.7 464 224.2 464C348.2 464 448 364.5 448 239.8V104.6C448 82.2 430.3 64 407.6 64V64ZM245.6 332.5C233.2 344.3 214.2 343.6 203.2 332.5C89.5 223.6 88.3 227.4 88.3 209.3C88.3 192.4 102.1 178.6 119 178.6C136 178.6 135.1 182.4 224.2 267.9C314.8 181 312.8 178.6 329.7 178.6C346.6 178.6 360.4 192.4 360.4 209.3C360.4 227.1 357.5 225 245.6 332.5V332.5Z" fill="black"/>
				</svg>';
			break;

			case 'dribbble':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Dribbble Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,5.5,4.5,10,10,10c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0 M16.1,5.2c1,1.2,1.6,2.8,1.7,4.4c-1.1-0.2-2.2-0.4-3.2-0.4v0h0c-0.8,0-1.6,0.1-2.3,0.2c-0.2-0.4-0.3-0.8-0.5-1.2C13.4,7.6,14.9,6.6,16.1,5.2 M10,2.2c1.8,0,3.5,0.6,4.9,1.7c-1,1.2-2.4,2.1-3.8,2.7c-1-2-2-3.4-2.7-4.3C8.9,2.3,9.4,2.2,10,2.2 M6.6,3c0.5,0.6,1.6,2,2.8,4.2C7,8,4.6,8.1,3.2,8.1c0,0-0.1,0-0.1,0h0c-0.2,0-0.4,0-0.6,0C3,5.9,4.5,4,6.6,3 M2.2,10c0,0,0-0.1,0-0.1c0.2,0,0.5,0,0.9,0h0c1.6,0,4.3-0.1,7.1-1c0.2,0.3,0.3,0.7,0.4,1c-1.9,0.6-3.3,1.6-4.4,2.6c-1,0.9-1.7,1.9-2.2,2.5C2.9,13.7,2.2,11.9,2.2,10 M10,17.8c-1.7,0-3.3-0.6-4.6-1.5c0.3-0.5,0.9-1.3,1.8-2.2c1-0.9,2.3-1.9,4.1-2.5c0.6,1.7,1.1,3.6,1.5,5.7C11.9,17.6,11,17.8,10,17.8M14.4,16.4c-0.4-1.9-0.9-3.7-1.4-5.2c0.5-0.1,1-0.1,1.6-0.1h0h0h0c0.9,0,2,0.1,3.1,0.4C17.3,13.5,16.1,15.3,14.4,16.4"/>
				</svg>';
			break;

			case 'behance':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Behance Icon">
					<path d="M15.2,10.3h-2.7c0,0,0.2-1.3,1.5-1.3C15.2,9,15.2,10.3,15.2,10.3z M7.7,10.3H5.3v2.2h2.2c0,0,0.1,0,0.2,0c0.3,0,1-0.1,1-1.1C8.6,10.3,7.7,10.3,7.7,10.3zM20,10c0,5.5-4.5,10-10,10C4.5,20,0,15.5,0,10S4.5,0,10,0C15.5,0,20,4.5,20,10zM12.1,7.2h3.4v-1h-3.4V7.2z M8.8,9.5c0,0,1.3-0.1,1.3-1.6S9,5.7,7.7,5.7H5.3H5.2H3.4V14h1.8h0.1h2.4c0,0,2.6,0.1,2.6-2.5C10.4,11.5,10.5,9.5,8.8,9.5zM13.9,7.8c-3.2,0-3.2,3.2-3.2,3.2s-0.2,3.2,3.2,3.2c0,0,2.9,0.2,2.9-2.2h-1.5c0,0,0,0.9-1.3,0.9c0,0-1.5,0.1-1.5-1.5h4.3C16.8,11.4,17.3,7.8,13.9,7.8z M8.3,8c0-0.9-0.6-0.9-0.6-0.9H7.4H5.3V9h2.3C8,9,8.3,8.9,8.3,8z"/>
				</svg>';
			break;

			case 'unsplash':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Unsplash Icon">
					<path d="M6.2 5.6V0h7.5v5.6H6.2zm7.6 3.2H20V20H0V8.8h6.2v5.6h7.5V8.8z"/>
				</svg>';
			break;

			case 'five-hundred-px':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="500PX Icon">
					<path d="M17.7 17.3c-.9.9-1.9 1.6-3 2-1.1.5-2.3.7-3.5.7-1.2 0-2.4-.2-3.5-.7-1.1-.5-2.1-1.1-2.9-2-.8-.8-1.5-1.8-2-2.9-.3-.8-.5-1.5-.6-2.1 0-.2.1-.3.5-.4.4-.1.6 0 .6.2.1.7.3 1.3.5 1.8.4.9.9 1.8 1.7 2.5.7.7 1.6 1.3 2.5 1.7 1 .4 2 .6 3.1.6s2.1-.2 3.1-.6c1-.4 1.8-1 2.5-1.7l.1-.1c.1-.1.2-.1.3-.1.1 0 .2.1.4.2.3.5.3.7.2.9zm-5.3-6.9l-.7.7.7.7c.2.2.1.3-.1.5-.1.1-.2.2-.4.2-.1 0-.1 0-.2-.1l-.7-.7-.7.7s-.1.1-.2.1-.2-.1-.3-.2c-.1-.1-.2-.2-.2-.3 0-.1 0-.1.1-.2l.7-.7-.7-.7c-.1-.1-.1-.3.2-.5.1-.1.2-.2.3-.2 0 0 .1 0 .1.1l.7.7.7-.7c.1-.1.3-.1.5.1.3.2.4.4.2.5zm5.3.6c0 .9-.2 1.7-.5 2.5s-.8 1.5-1.4 2.1c-.6.6-1.3 1.1-2.1 1.4-.8.3-1.6.5-2.5.5-.9 0-1.7-.2-2.5-.5s-1.5-.8-2.1-1.4c-.6-.6-1.1-1.3-1.4-2.1l-.2-.4c-.1-.2.1-.4.5-.5.4-.1.6-.1.7.1.3.7.6 1.4 1.1 1.9v-3.8c0-1 .4-1.9 1.1-2.6.8-.8 1.7-1.1 2.8-1.1 1.1 0 2 .4 2.8 1.1.8.8 1.2 1.7 1.2 2.8 0 1.1-.4 2-1.2 2.8-.8.8-1.7 1.2-2.8 1.2-.4 0-.8-.1-1.2-.2-.2-.1-.3-.3-.1-.7.1-.4.3-.5.5-.5h.2c.1 0 .2 0 .4.1s.3 0 .3 0c.8 0 1.4-.3 2-.8.5-.5.8-1.2.8-1.9 0-.8-.3-1.4-.8-1.9s-1.2-.8-2-.8-1.5.3-2 .9c-.7.6-.9 1.2-.9 1.8v4.6c.8.5 1.7.7 2.7.7.7 0 1.4-.1 2.1-.4.7-.3 1.2-.7 1.7-1.2s.9-1.1 1.2-1.7c.3-.7.4-1.3.4-2 0-1.5-.5-2.7-1.6-3.8-1-1-2.3-1.6-3.8-1.6s-2.8.5-3.8 1.6c-.4.4-.7.8-.8 1l-.2.2s-.1.1-.2.1h-.4c-.2 0-.3-.1-.4-.2S5 8.1 5 8V.4c0-.1 0-.2.1-.3s.2-.1.4-.1h9.8c.2 0 .3.2.3.6s-.1.6-.3.6H6.2v5.4c.3-.3.7-.6 1.2-.9.4-.3.8-.6 1.2-.7.8-.3 1.7-.5 2.6-.5.9 0 1.7.2 2.5.5s1.5.8 2.1 1.4c.6.6 1.1 1.3 1.4 2.1.3.8.5 1.7.5 2.5zm-.4-6.4c.1.1.1.1.1.2s0 .1-.1.2l-.2.2c-.2.2-.3.3-.4.3-.1 0-.1 0-.2-.1-.8-.7-1.6-1.2-2.3-1.5-1-.4-2-.6-3.1-.6-1 0-2 .2-2.9.5-.1.1-.3 0-.4-.4-.1-.2-.1-.3-.1-.4 0-.1.1-.2.2-.2 1-.4 2.1-.6 3.3-.6 1.2 0 2.4.2 3.5.7 1 .4 1.9 1 2.6 1.7z"/>
				</svg>';
			break;

			case 'linkedin':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="LinkedIn Icon">
					<path d="M18.6,0H1.4C0.6,0,0,0.6,0,1.4v17.1C0,19.4,0.6,20,1.4,20h17.1c0.8,0,1.4-0.6,1.4-1.4V1.4C20,0.6,19.4,0,18.6,0z M6,17.1h-3V7.6h3L6,17.1L6,17.1zM4.6,6.3c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c0.9,0,1.7,0.8,1.7,1.7C6.3,5.5,5.5,6.3,4.6,6.3z M17.2,17.1h-3v-4.6c0-1.1,0-2.5-1.5-2.5c-1.5,0-1.8,1.2-1.8,2.5v4.7h-3V7.6h2.8v1.3h0c0.4-0.8,1.4-1.5,2.8-1.5c3,0,3.6,2,3.6,4.5V17.1z"/>
				</svg>';
			break;

			case 'wordpress':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="WordPress Icon">
					<path d="M1.9 4.1C3.7 1.6 6.7 0 10 0c2.4 0 4.6.9 6.3 2.3-.7.2-1.2 1-1.2 1.7 0 .9.5 1.6 1 2.4.5.7.9 1.6.9 2.9 0 .9-.3 2-.8 3.4l-1 3.5-3.8-11.3c.6 0 1.2-.1 1.2-.1.6 0 .5-.8 0-.8 0 0-1.7.1-2.8.1-1 0-2.7-.1-2.7-.1-.6 0-.7.8-.1.8 0 0 .5.1 1.1.1l1.6 4.4-2.3 6.8L3.7 4.9c.6 0 1.2-.1 1.2-.1.5 0 .4-.8-.1-.8 0 0-1.7.1-2.9.1.1 0 .1 0 0 0zM.8 6.2C.3 7.4 0 8.6 0 10c0 3.9 2.2 7.2 5.4 8.9L.8 6.2zm9.4 4.5l-3 8.9c.9.3 1.8.4 2.8.4 1.2 0 2.3-.2 3.4-.6l-3.2-8.7zm9-4.6c0 1-.2 2.2-.8 3.6l-3 8.8c2.8-1.8 4.6-4.9 4.6-8.4 0-1.5-.3-2.8-.8-4z"/>
				</svg>';
			break;

			case 'parler':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Parler Icon">
					<path d="M11.7,16.7h-5V15c0-0.9,0.7-1.6,1.6-1.6h3.4c2.8,0,5-2.2,5-5s-2.2-5-5-5h0l-1.1,0H0C0,1.5,1.5,0,3.3,0h7.3l1.1,0C16.3,0,20,3.8,20,8.4S16.3,16.7,11.7,16.7z M3.3,20C1.5,20,0,18.5,0,16.7V9.9c0-1.8,1.4-3.2,3.2-3.2h8.4c0.9,0,1.7,0.7,1.7,1.7c0,0.9-0.7,1.7-1.7,1.7H5c-0.9,0-1.6,0.7-1.6,1.6V20z"/>
				</svg>';
			break;

			case 'mastodon':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Mastodon Icon">
					<path d="M19.3 6.6c0-4.3-2.8-5.6-2.8-5.6C13.7-.3 6.3-.3 3.5 1 3.5 1 .7 2.3.7 6.6c0 5.2-.3 11.6 4.7 12.9 1.8.5 3.4.6 4.6.5 2.3-.1 3.5-.8 3.5-.8l-.1-1.6s-1.6.5-3.4.5c-1.8-.1-3.7-.2-4-2.4v-.6c3.8.9 7.1.4 8 .3 2.5-.3 4.7-1.8 5-3.3.4-2.3.3-5.5.3-5.5zM16 12.2h-2.1V7.1c0-2.2-2.9-2.3-2.9.3v2.8H9V7.4c0-2.6-2.9-2.5-2.9-.3v5.1H4c0-5.4-.2-6.6.8-7.8C6 3.1 8.4 3 9.5 4.6l.5.9.5-.9c1.1-1.6 3.5-1.5 4.7-.3 1 1.3.8 2.4.8 7.9z"/>
				</svg>';
			break;

			case 'medium':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Medium Icon">
					<path d="M2.4,5.3c0-0.2-0.1-0.5-0.3-0.7L0.3,2.4V2.1H6l4.5,9.8l3.9-9.8H20v0.3l-1.6,1.5c-0.1,0.1-0.2,0.3-0.2,0.4v11.2c0,0.2,0,0.3,0.2,0.4l1.6,1.5v0.3h-7.8v-0.3l1.6-1.6c0.2-0.2,0.2-0.2,0.2-0.4V6.5L9.4,17.9H8.8L3.6,6.5v7.6c0,0.3,0.1,0.6,0.3,0.9L6,17.6v0.3H0v-0.3L2.1,15c0.2-0.2,0.3-0.6,0.3-0.9V5.3z"/>
				</svg>';
			break;

			case 'slack':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Slack Icon">
					<path d="M7.4,0C6.2,0,5.2,1,5.2,2.2s1,2.2,2.2,2.2h2.2V2.2C9.6,1,8.6,0,7.4,0zM12.6,0c-1.2,0-2.2,1-2.2,2.2v5.2c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2V2.2C14.8,1,13.8,0,12.6,0z M2.2,5.2C1,5.2,0,6.2,0,7.4s1,2.2,2.2,2.2h5.2c1.2,0,2.2-1,2.2-2.2s-1-2.2-2.2-2.2H2.2zM17.8,5.2c-1.2,0-2.2,1-2.2,2.2v2.2h2.2c1.2,0,2.2-1,2.2-2.2S19,5.2,17.8,5.2z M2.2,10.4c-1.2,0-2.2,1-2.2,2.2s1,2.2,2.2,2.2s2.2-1,2.2-2.2v-2.2H2.2zM7.4,10.4c-1.2,0-2.2,1-2.2,2.2v5.2c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2v-5.2C9.6,11.4,8.6,10.4,7.4,10.4z M12.6,10.4c-1.2,0-2.2,1-2.2,2.2s1,2.2,2.2,2.2h5.2c1.2,0,2.2-1,2.2-2.2s-1-2.2-2.2-2.2H12.6zM10.4,15.7v2.2c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2c0-1.2-1-2.2-2.2-2.2H10.4z"/>
				</svg>';
			break;

			case 'codepen':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="CodePen Icon">
					<path d="M10,0L0,6.4v7.3L10,20l10-6.4V6.4L10,0z M10,12l-2.8-2L10,8.1l2.8,1.9L10,12z M11,6.5V2.8l6.4,4.1l-2.9,2L11,6.5z M9,6.5L5.5,8.9l-2.9-2L9,2.8V6.5z M3.9,10l-1.9,1.3V8.7L3.9,10z M5.5,11.2L9,13.6v3.5l-6.4-4.1L5.5,11.2z M11,13.6l3.5-2.5l2.8,1.9L11,17.2V13.6z M16.1,10l1.9-1.4v2.7L16.1,10z"/>
				</svg>';
			break;

			case 'reddit':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Reddit Icon">
					<path d="M11.7,0.9c-0.9,0-2,0.7-2.1,3.9c0.1,0,0.3,0,0.4,0c0.2,0,0.3,0,0.5,0c0.1-1.9,0.6-3.1,1.3-3.1c0.3,0,0.5,0.2,0.8,0.5c0.4,0.4,0.9,0.9,1.8,1.1c0-0.1,0-0.2,0-0.4c0-0.2,0-0.4,0.1-0.5c-0.6-0.2-0.9-0.5-1.2-0.8C12.8,1.3,12.4,0.9,11.7,0.9z M16.9,1.3c-1,0-1.7,0.8-1.7,1.7s0.8,1.7,1.7,1.7s1.7-0.8,1.7-1.7S17.9,1.3,16.9,1.3z M10,5.7c-5.3,0-9.5,2.7-9.5,6.5s4.3,6.9,9.5,6.9s9.5-3.1,9.5-6.9S15.3,5.7,10,5.7z M2.4,6.1c-0.6,0-1.2,0.3-1.7,0.7C0,7.5-0.2,8.6,0.2,9.5C0.9,8.2,2,7.1,3.5,6.3C3.1,6.2,2.8,6.1,2.4,6.1z M17.6,6.1c-0.4,0-0.7,0.1-1.1,0.3c1.5,0.8,2.6,1.9,3.2,3.2c0.4-0.9,0.3-2-0.5-2.7C18.8,6.3,18.2,6.1,17.6,6.1z M6.5,9.6c0.7,0,1.3,0.6,1.3,1.3s-0.6,1.3-1.3,1.3s-1.3-0.6-1.3-1.3S5.8,9.6,6.5,9.6z M13.5,9.6c0.7,0,1.3,0.6,1.3,1.3s-0.6,1.3-1.3,1.3s-1.3-0.6-1.3-1.3S12.8,9.6,13.5,9.6z M6.1,14.3c0.1,0,0.2,0.1,0.3,0.2c0,0.1,1.1,1.4,3.6,1.4c2.6,0,3.6-1.4,3.6-1.4c0.1-0.2,0.4-0.2,0.6-0.1c0.2,0.1,0.2,0.4,0.1,0.6c-0.1,0.1-1.3,1.8-4.3,1.8c-3,0-4.2-1.7-4.3-1.8c-0.1-0.2-0.1-0.5,0.1-0.6C5.9,14.4,6,14.3,6.1,14.3z"/>
				</svg>';
			break;

			case 'twitch':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Twitch Icon">
					<path d="M1.5,0L0,4.1v12.8h4.6V20h2.1l3.8-3.1h4.1l5.4-5.8V0H1.5zM3.1,1.5h15.4v8.8l-3.3,3.5H9.5l-3.4,2.9v-2.9H3.1V1.5z M7.7,4.6v6.2h1.5V4.6H7.7z M12.3,4.6v6.2h1.5V4.6H12.3z"/>
				</svg>';
			break;

			case 'tiktok':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="TikTok Icon">
					<path d="M18.2 4.5c-2.3-.2-4.1-1.9-4.4-4.2V0h-3.4v13.8c0 1.4-1.2 2.6-2.8 2.6-1.4 0-2.6-1.1-2.6-2.6s1.1-2.6 2.6-2.6h.2l.5.1V7.5h-.7c-3.4 0-6.2 2.8-6.2 6.2S4.2 20 7.7 20s6.2-2.8 6.2-6.2v-7c1.1 1.1 2.4 1.6 3.9 1.6h.8V4.6l-.4-.1z"/>
				</svg>';
			break;

			case 'snapchat':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Snapchat Icon">
					<path d="M10,0.5c-6,0-6,6-6,6v1c0,0,0,0-0.1,0C3.6,7.5,2,7.6,2,8.9c0,1.5,1.7,1.6,2,1.6c0,0,0,0,0,0c0,1-1.7,2.2-2.7,2.4C0.3,13.3,0,14,0,14.5c0,0.3,0.1,0.5,0.1,0.6c0.4,0.9,1.5,1.3,2.6,1.3c0,1.4,1.1,2,1.8,2c0.8,0,1.6-0.4,1.6-0.4c0,0,1.3,1.4,3.9,1.4s3.9-1.4,3.9-1.4c0,0,0.8,0.4,1.6,0.4c0.7,0,1.7-0.6,1.8-2c1.1,0,2.2-0.5,2.6-1.3c0-0.1,0.1-0.3,0.1-0.6c0-0.5-0.3-1.2-1.3-1.6c-1.1-0.3-2.7-1.4-2.7-2.4c0,0,0,0,0,0c0.3,0,2-0.1,2-1.6c0-1.3-1.6-1.4-1.9-1.4c0,0-0.1,0-0.1,0v-1C16,6.5,16,0.5,10,0.5L10,0.5z"/>
				</svg>';
			break;

			case 'spotify':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Spotify Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10s4.5,10,10,10s10-4.5,10-10S15.5,0,10,0z M14.2,14.5c-0.1,0.2-0.3,0.3-0.5,0.3c-0.1,0-0.2,0-0.4-0.1c-1.1-0.7-2.9-1.2-4.4-1.2c-1.6,0-2.8,0.4-2.8,0.4c-0.3,0.1-0.7-0.1-0.8-0.4c-0.1-0.3,0.1-0.7,0.4-0.8c0.1,0,1.4-0.5,3.2-0.5c1.5,0,3.6,0.4,5.1,1.4C14.4,13.8,14.4,14.2,14.2,14.5z M15.5,11.8c-0.1,0.2-0.4,0.4-0.6,0.4c-0.1,0-0.3,0-0.4-0.1c-1.9-1.2-4-1.5-5.7-1.5c-1.9,0-3.5,0.4-3.5,0.4c-0.4,0.1-0.8-0.1-0.9-0.5c-0.1-0.4,0.1-0.8,0.5-0.9c0.1,0,1.7-0.4,3.8-0.4c1.9,0,4.4,0.3,6.6,1.7C15.6,11,15.8,11.5,15.5,11.8z M16.8,8.7c-0.2,0.3-0.5,0.4-0.8,0.4c-0.1,0-0.3,0-0.4-0.1c-2.3-1.3-5-1.6-6.9-1.6c0,0,0,0,0,0c-2.3,0-4.1,0.4-4.1,0.4c-0.5,0.1-0.9-0.2-1-0.6c-0.1-0.5,0.2-0.9,0.6-1c0.1,0,2-0.5,4.5-0.5c0,0,0,0,0,0c2.1,0,5.2,0.3,7.8,1.9C16.9,7.8,17.1,8.3,16.8,8.7z"/>
				</svg>';
			break;

			case 'soundcloud':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="SoundCloud Icon">
					<path d="M20 12.7c0 1.5-1.2 2.7-2.7 2.7h-6c-.4 0-.7-.3-.7-.7V5.3c0-.4.3-.7.7-.7h.7c3.3 0 6 2.7 4.7 5.3h.7c1.4.1 2.6 1.3 2.6 2.8zM.7 9.9c-.4 0-.7.3-.7.7v4.1c0 .4.3.7.7.7.4 0 .7-.3.7-.7v-4.1c-.1-.4-.4-.7-.7-.7zM6 5.3c-.4 0-.7.3-.7.7v8.7c0 .4.3.7.7.7s.7-.3.7-.7V6c0-.4-.3-.7-.7-.7zm2.7 2c-.4 0-.7.3-.7.7v6.7c0 .4.3.7.7.7.4 0 .7-.3.7-.7V8c-.1-.4-.4-.7-.7-.7zM3.3 8c-.3 0-.6.3-.6.7v6c0 .4.3.7.7.7.3-.1.6-.4.6-.7v-6c0-.4-.3-.7-.7-.7z"/>
				</svg>';
			break;

			case 'apple_podcast':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Apple Podcasts Icon">
					<path d="M10 0C5.1 0 1.1 4 1.1 8.9c0 2.9 1.4 5.5 3.6 7.1.3.2.5.4.8.5.3.2.8.1 1-.2.2-.3.1-.8-.2-1-.2-.1-.5-.3-.7-.5-1.8-1.4-3-3.6-3-6 0-4.2 3.4-7.5 7.5-7.5s7.5 3.4 7.5 7.5c0 2.5-1.2 4.7-3 6-.2.2-.5.3-.7.5-.3.2-.5.6-.3 1 .2.3.6.5 1 .3.3-.2.6-.4.8-.6 2.2-1.6 3.6-4.2 3.6-7.2C18.9 4 14.9 0 10 0zm0 2.8c-3.4 0-6.1 2.7-6.1 6.1 0 1.7.7 3.2 1.8 4.3.3.3.7.3 1 0s.3-.7 0-1c-.9-.9-1.4-2-1.4-3.3 0-2.6 2.1-4.7 4.7-4.7s4.7 2.1 4.7 4.7c0 1.3-.5 2.5-1.4 3.3-.3.3-.3.7 0 1 .3.3.7.3 1 0 1.1-1.1 1.8-2.6 1.8-4.3 0-3.3-2.7-6.1-6.1-6.1zm0 3.8C8.7 6.6 7.6 7.7 7.6 9s1.1 2.4 2.4 2.4 2.4-1.1 2.4-2.4-1.1-2.4-2.4-2.4zm0 5.6c-1.3 0-2.4 1.1-2.4 2.4v.5l.9 3.7c.2.7.8 1.2 1.5 1.2s1.3-.5 1.4-1.1l.9-3.7v-.1-.4c.1-1.4-1-2.5-2.3-2.5z"/>
				</svg>';
			break;


			case 'patreon':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Patreon Icon">
					<path d="M20,7.6c0,4-3.2,7.2-7.2,7.2c-4,0-7.2-3.2-7.2-7.2c0-4,3.2-7.2,7.2-7.2C16.8,0.4,20,3.6,20,7.6z M0,19.6h3.5V0.4H0V19.6z"/>
				</svg>';
			break;

			case 'alignable':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Alignable Icon">
					<path d="M19.5 6.7C18.1 2.8 14.3 0 9.9 0c-.7 0-1.4.1-2.1.3L6.6.6c.1.1.1.3.2.4.2.8.5 1.6.7 2.4.2.4.4.9.5 1.4.5 1.5 1.1 2.8 1.7 3.8.2.4.5.8.8 1.1.4.4.8.7 1.3.7.7 0 1.3-.6 1.9-1.4.5 1 1.1 2.3 1.5 3.5-.9.8-2 1.3-3.3 1.3-1 0-1.8-.3-2.6-.8-.3-.2-.7-.5-1-.8-1-.9-1.7-2.2-2.4-3.6-.3-.5-.5-1-.7-1.6C4.5 5.5 4 3.9 3.6 2.3c-.4.2-.7.6-1 .9C1 5 0 7.4 0 10c0 2.3.7 4.4 2 6.1.2.4.6.8.9 1.1.3-1.1.7-2.1 1-3.1.4-1.3.8-2.6 1.3-3.9.7 1.3 1.5 2.5 2.5 3.3-.2.6-.4 1.2-.6 1.7-.5 1.3-.9 2.7-1.4 4 .4.1.8.3 1.2.4 1 .3 2 .4 3 .4 2.7 0 5.2-1.1 7-2.8.4-.4.7-.7 1-1.1-.1-.3-.2-.7-.3-1-.3-.7-.5-1.5-.8-2.3-.2-.5-.3-.9-.5-1.4-.5-1.5-1.1-2.8-1.7-3.8-.2-.4-.5-.8-.8-1.1l-.3-.3c-.3-.3-.7-.4-1-.4-.7 0-1.3.6-1.9 1.4-.6-1-1.2-2.3-1.6-3.5.1-.1.2-.2.4-.3.9-.6 1.9-1 3-1 1 0 1.8.3 2.6.8.3.2.7.5 1 .8.9.9 1.7 2.2 2.3 3.5.3.5.5 1.1.7 1.6.3.7.6 1.4.8 2.1.2-.4.2-.8.2-1.2 0-1.1-.2-2.2-.5-3.3z"/>
				</svg>';
			break;


			case 'skype':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Skype Icon">
					<path d="M5.7 0C2.6 0 0 2.5 0 5.6c0 1 .2 1.9.7 2.7-.1.6-.2 1.2-.2 1.8 0 5.2 4.3 9.4 9.6 9.4.5 0 1.1 0 1.6-.1.8.4 1.7.6 2.6.6 3.1 0 5.7-2.5 5.7-5.6 0-.8-.2-1.6-.5-2.4.1-.6.2-1.2.2-1.9 0-5.2-4.3-9.4-9.6-9.4-.5 0-1 0-1.5.1C7.7.3 6.7 0 5.7 0zM10 3.8c.8 0 1.5.1 2.1.3.6.2 1.1.4 1.5.7.4.3.7.6.9 1 .2.3.3.7.3 1 0 .3-.1.6-.4.9s-.5.3-.8.3c-.3 0-.6-.1-.8-.2-.2-.2-.4-.4-.6-.7-.2-.4-.5-.8-.8-1-.3-.2-.8-.3-1.5-.3s-1.2.1-1.6.4c-.4.2-.6.5-.6.8 0 .2.1.4.2.5.1.2.3.3.5.4.3.1.5.2.8.3.3.1.7.2 1.3.3.7.2 1.4.3 2 .5.6.2 1.1.4 1.6.7.4.3.8.6 1 1.1s.4 1 .4 1.6c0 .7-.2 1.4-.6 2-.4.6-1.1 1.1-1.9 1.4-.8.3-1.8.5-2.9.5-1.3 0-2.4-.2-3.3-.7-.6-.3-1.1-.8-1.5-1.3-.4-.6-.6-1.1-.6-1.6 0-.3.1-.6.4-.9.3-.2.6-.3.9-.3.3 0 .6.1.8.3.2.2.4.4.5.8.2.4.3.7.5.9.2.2.4.4.8.6.3.2.8.2 1.3.2.8 0 1.4-.2 1.8-.5.5-.3.7-.7.7-1.1 0-.4-.1-.6-.4-.9-.2-.2-.6-.4-1-.5-.4-.1-1-.3-1.7-.4-.9-.2-1.8-.4-2.4-.7-.4-.3-1-.7-1.3-1.2-.4-.5-.7-1.1-.7-1.8s.2-1.3.6-1.8c.4-.5 1-.9 1.8-1.2.8-.3 1.7-.4 2.7-.4z"/>
				</svg>';
			break;

			case 'github':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="GitHub Icon">
					<path d="M8.9,0.4C4.3,0.9,0.6,4.6,0.1,9.1c-0.5,4.7,2.2,8.9,6.3,10.5C6.7,19.7,7,19.5,7,19.1v-1.6c0,0-0.4,0.1-0.9,0.1c-1.4,0-2-1.2-2.1-1.9c-0.1-0.4-0.3-0.7-0.6-1C3.1,14.6,3,14.6,3,14.5c0-0.2,0.3-0.2,0.4-0.2c0.6,0,1.1,0.7,1.3,1c0.5,0.8,1.1,1,1.4,1c0.4,0,0.7-0.1,0.9-0.2c0.1-0.7,0.4-1.4,1-1.8c-2.3-0.5-4-1.8-4-4c0-1.1,0.5-2.2,1.2-3C5.1,7.1,5,6.6,5,5.9c0-0.4,0-1,0.3-1.6c0,0,1.4,0,2.8,1.3C8.6,5.4,9.3,5.3,10,5.3s1.4,0.1,2,0.3c1.3-1.3,2.8-1.3,2.8-1.3C15,4.9,15,5.5,15,5.9c0,0.8-0.1,1.2-0.2,1.4c0.7,0.8,1.2,1.8,1.2,3c0,2.2-1.7,3.5-4,4c0.6,0.5,1,1.4,1,2.3v2.6c0,0.3,0.3,0.6,0.7,0.5c3.7-1.5,6.3-5.1,6.3-9.3C20,4.4,14.9-0.3,8.9,0.4z"/>
				</svg>';
			break;

			case 'gitlab':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="GitLab Icon">
					<path d="M15.7.9c-.2 0-.4.1-.4.3l-2.2 6.7H6.9L4.8 1.2C4.7 1 4.5.9 4.4.9c-.2 0-.4.1-.5.3l-2.6 7L0 11.6c0 .2 0 .4.2.5l9.6 7h.1l9.6-7c.5-.1.5-.3.5-.5l-1.3-3.5-2.6-7c-.1-.1-.3-.2-.4-.2zM2.6 8.7h3.7l2.5 7.8-6.2-7.8zm11.1 0h3.7l-6.2 7.8 2.5-7.8zm-11.8.4l5.8 7.3L1 11.6l.9-2.5zm16.2 0l.9 2.4-6.7 4.9 5.8-7.3z"/>
				</svg>';
			break;


			case 'youtube':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewbox="0 0 20 20"
				aria-label="YouTube Icon">
					<path d="M15,0H5C2.2,0,0,2.2,0,5v10c0,2.8,2.2,5,5,5h10c2.8,0,5-2.2,5-5V5C20,2.2,17.8,0,15,0z M14.5,10.9l-6.8,3.8c-0.1,0.1-0.3,0.1-0.5,0.1c-0.5,0-1-0.4-1-1l0,0V6.2c0-0.5,0.4-1,1-1c0.2,0,0.3,0,0.5,0.1l6.8,3.8c0.5,0.3,0.7,0.8,0.4,1.3C14.8,10.6,14.6,10.8,14.5,10.9z"/>
				</svg>';
			break;

			case 'vimeo':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Vimeo Icon">
					<path d="M20,5.3c-0.1,1.9-1.4,4.6-4.1,8c-2.7,3.5-5,5.3-6.9,5.3c-1.2,0-2.2-1.1-3-3.2C4.5,9.7,3.8,6.3,2.5,6.3c-0.2,0-0.7,0.3-1.6,0.9L0,6c2.3-2,4.5-4.3,5.9-4.4c1.6-0.2,2.5,0.9,2.9,3.2c1.3,8.1,1.8,9.3,4.2,5.7c0.8-1.3,1.3-2.3,1.3-3c0.2-2-1.6-1.9-2.8-1.4c1-3.2,2.9-4.8,5.6-4.7C19.1,1.4,20.1,2.7,20,5.3L20,5.3z"/>
				</svg>';
			break;

			case 'dtube':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="DTube Icon">
					<path d="M18.2,6c-0.4-1.2-1.1-2.3-1.9-3.2c-0.8-0.9-1.8-1.6-2.9-2C12.3,0.2,11,0,9.6,0H1.1v20h8.2c1.3,0,2.4-0.2,3.4-0.5c1-0.3,1.9-0.8,2.7-1.4c1.1-0.9,2-2,2.6-3.3c0.6-1.4,0.9-2.9,0.9-4.7C18.9,8.6,18.7,7.2,18.2,6z M6.1,14.5v-9l7.8,4.5L6.1,14.5z"/>
				</svg>';
			break;

			case 'vk':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="VKontakte Icon">
					<path d="M19.2,4.8H16c-0.3,0-0.5,0.1-0.6,0.4c0,0-1.3,2.4-1.7,3.2c-1.1,2.2-1.8,1.5-1.8,0.5V5.4c0-0.6-0.5-1.1-1.1-1.1H8.2C7.6,4.3,6.9,4.6,6.5,5.1c0,0,1.2-0.2,1.2,1.5c0,0.4,0,1.6,0,2.6c0,0.4-0.3,0.7-0.7,0.7c-0.2,0-0.4-0.1-0.6-0.2c-1-1.4-1.8-2.9-2.5-4.5C4,5,3.7,4.8,3.5,4.8c-0.7,0-2.1,0-2.9,0C0.2,4.8,0,5,0,5.3c0,0.1,0,0.1,0,0.2C0.9,8,4.8,15.7,9.2,15.7H11c0.4,0,0.7-0.3,0.7-0.7v-1.1c0-0.4,0.3-0.7,0.7-0.7c0.2,0,0.4,0.1,0.5,0.2l2.2,2.1c0.2,0.2,0.5,0.3,0.7,0.3h2.9c1.4,0,1.4-1,0.6-1.7c-0.5-0.5-2.5-2.6-2.5-2.6c-0.3-0.4-0.4-0.9-0.1-1.3c0.6-0.8,1.7-2.2,2.1-2.8C19.6,6.5,20.7,4.8,19.2,4.8z"/>
				</svg>';
			break;

			case 'ok':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Odnoklassniki Icon">
					<path d="M8.2,6.5c0-1,0.8-1.8,1.8-1.8s1.8,0.8,1.8,1.8c0,1-0.8,1.8-1.8,1.8S8.2,7.5,8.2,6.5L8.2,6.5z M20,2.1v15.7c0,1.2-1,2.1-2.1,2.1H2.1C1,20,0,19,0,17.9V2.1C0,1,1,0,2.1,0h15.7C19,0,20,1,20,2.1z M6.4,6.5c0,2,1.6,3.6,3.6,3.6s3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6S6.4,4.5,6.4,6.5z M14.2,10.5c-0.2-0.4-0.8-0.8-1.5-0.2c0,0-1,0.8-2.6,0.8s-2.6-0.8-2.6-0.8C6.6,9.8,6,10.1,5.8,10.5c-0.4,0.7,0,1.1,1,1.7c0.8,0.5,1.8,0.7,2.5,0.8l-0.6,0.6c-0.8,0.8-1.6,1.6-2.1,2.1c-0.8,0.8,0.5,2,1.3,1.3l2.1-2.1c0.8,0.8,1.6,1.6,2.1,2.1c0.8,0.8,2.1-0.5,1.3-1.3l-2.1-2.1l-0.6-0.6c0.7-0.1,1.7-0.3,2.5-0.8C14.1,11.6,14.5,11.2,14.2,10.5z"/>
				</svg>';
			break;

			case 'rss':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="RSS Icon">
					<path d="M17.9,0H2.1C1,0,0,1,0,2.1v15.7C0,19,1,20,2.1,20h15.7c1.2,0,2.1-1,2.1-2.1V2.1C20,1,19,0,17.9,0z M5,17.1c-1.2,0-2.1-1-2.1-2.1s1-2.1,2.1-2.1s2.1,1,2.1,2.1S6.2,17.1,5,17.1z M12,17.1h-1.5c-0.3,0-0.5-0.2-0.5-0.5c-0.2-3.6-3.1-6.4-6.7-6.7c-0.3,0-0.5-0.2-0.5-0.5V8c0-0.3,0.2-0.5,0.5-0.5c4.9,0.3,8.9,4.2,9.2,9.2C12.6,16.9,12.3,17.1,12,17.1L12,17.1z M16.6,17.1h-1.5c-0.3,0-0.5-0.2-0.5-0.5c-0.2-6.1-5.1-11-11.2-11.2c-0.3,0-0.5-0.2-0.5-0.5V3.4c0-0.3,0.2-0.5,0.5-0.5c7.5,0.3,13.5,6.3,13.8,13.8C17.2,16.9,16.9,17.1,16.6,17.1L16.6,17.1z"/>
				</svg>';
			break;

			case 'facebook_group':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Facebook Group Icon">
					<path d="M3.3,18.4c-0.2-0.5,0.3-2.8,0.7-3.7c0.5-1.1,1.6-2,2.5-2.3c0.6-0.2,0.7-0.2,2.1,0.5l1.4,0.7l1.4-0.7c0.8-0.4,1.5-0.7,1.8-0.7c0.5,0,1.8,0.9,2.4,1.6c0.6,0.9,1.1,2.3,1.2,3.7l0,1.1l-6.7,0C4,18.7,3.4,18.6,3.3,18.4z M0.1,12.8c-0.4-0.9,0.6-3.4,1.6-4.1c0.8-0.5,1.5-0.5,2.5,0.1c0.6,0.4,0.9,0.5,1.1,0.3C5.6,9,5.7,9,5.9,9.3c0.2,0.2,0.6,0.6,0.9,1c0.6,0.6,0.6,0.7-0.4,1.1c-0.4,0.1-1.1,0.5-1.6,1l-0.9,0.7H2.1C0.5,13.1,0.2,13,0.1,12.8z M15.3,12.4c-0.4-0.4-1.1-0.8-1.5-1c-1.1-0.4-1.1-0.5-0.5-1.1c0.3-0.3,0.7-0.7,0.9-1C14.4,9,14.5,9,14.8,9.1c0.2,0.1,0.5,0,1.1-0.3c0.5-0.3,1.1-0.5,1.4-0.5c1.3,0,2.6,1.8,2.7,3.7l0,1l-2,0l-2,0L15.3,12.4z M8.4,10.6C7,9.9,6,8.4,6,6.9c0-2.1,2-4.1,4.1-4.1s4.1,2,4.1,4.1S12.1,11,10,11C9.6,11,8.9,10.8,8.4,10.6z M3.5,6.8c-1.7-1-1.9-3.5-0.4-4.7c1.1-0.9,2.5-1,3.6-0.2c1,0.7,1,0.9,0.2,1.6c-0.8,0.7-1.4,1.8-1.5,3C5.2,7.2,5.2,7.3,4.7,7.3C4.4,7.3,3.9,7.1,3.5,6.8z M14.8,6.5c-0.2-1.2-0.7-2.3-1.5-3c-0.8-0.7-0.8-0.9,0.2-1.6C15.4,0.6,18,2,18,4.3c0,1.5-1.4,3-2.7,3C14.9,7.3,14.9,7.2,14.8,6.5z"/>
				</svg>';
			break;

			case 'discord':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Discord Icon">
					<path d="M17.2,4.2c-1.7-1.4-4.5-1.6-4.6-1.6c-0.2,0-0.4,0.1-0.4,0.3c0,0-0.1,0.1-0.1,0.4c1.1,0.2,2.6,0.6,3.8,1.4C16.1,4.7,16.2,5,16,5.2c-0.1,0.1-0.2,0.2-0.4,0.2c-0.1,0-0.2,0-0.2-0.1C13.3,4,10.5,3.9,10,3.9S6.7,4,4.6,5.3C4.4,5.5,4.1,5.4,4,5.2C3.8,5,3.9,4.7,4.1,4.6c1.3-0.8,2.7-1.2,3.8-1.4C7.9,3,7.8,2.9,7.8,2.9C7.7,2.7,7.5,2.6,7.4,2.6c-0.1,0-2.9,0.2-4.6,1.7C1.8,5.1,0,10.1,0,14.3c0,0.1,0,0.2,0.1,0.2c1.3,2.2,4.7,2.8,5.5,2.8c0,0,0,0,0,0c0.1,0,0.3-0.1,0.4-0.2l0.8-1.1c-2.1-0.6-3.2-1.5-3.3-1.6c-0.2-0.2-0.2-0.4,0-0.6c0.2-0.2,0.4-0.2,0.6,0c0,0,2,1.7,6,1.7c4,0,6-1.7,6-1.7c0.2-0.2,0.5-0.1,0.6,0c0.2,0.2,0.1,0.5,0,0.6c-0.1,0.1-1.2,1-3.3,1.6l0.8,1.1c0.1,0.1,0.2,0.2,0.4,0.2c0,0,0,0,0,0c0.8,0,4.2-0.6,5.5-2.8c0-0.1,0.1-0.1,0.1-0.2C20,10.1,18.2,5.1,17.2,4.2z M7.2,12.6c-0.8,0-1.5-0.8-1.5-1.7s0.7-1.7,1.5-1.7c0.8,0,1.5,0.8,1.5,1.7S8,12.6,7.2,12.6z M12.8,12.6c-0.8,0-1.5-0.8-1.5-1.7s0.7-1.7,1.5-1.7c0.8,0,1.5,0.8,1.5,1.7S13.7,12.6,12.8,12.6z"/>
				</svg>';
			break;

			case 'tripadvisor':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="TripAdvisor Icon">
					<path d="M5.9 10.7c0 .4-.4.8-.8.8s-.8-.4-.8-.8.4-.8.8-.8.8.3.8.8zm1.7 0c0 1.3-1.1 2.4-2.4 2.4S2.7 12 2.7 10.7c0-1.3 1.1-2.4 2.4-2.4s2.5 1 2.5 2.4zm-.9 0c0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6 0 .9.7 1.6 1.6 1.6.9 0 1.6-.7 1.6-1.6zm8.2-.8c-.4 0-.8.4-.8.8s.4.8.8.8.8-.4.8-.8c0-.5-.4-.8-.8-.8zm2.4.8c0 1.3-1.1 2.4-2.4 2.4s-2.4-1.1-2.4-2.4c0-1.3 1.1-2.4 2.4-2.4s2.4 1 2.4 2.4zm-.8 0c0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6 0 .9.7 1.6 1.6 1.6.9 0 1.6-.7 1.6-1.6zm1.6 4.1c-2.1 1.7-5.2 1.3-6.9-.8l-.9 1.5c0 .1-.1.1-.1.1-.2.1-.4.1-.6-.1L8.7 14c-1.7 2.1-4.7 2.5-6.9.8-2-1.7-2.4-4.8-.8-6.9-.1-.5-.4-1-.7-1.4 0-.1-.1-.2-.1-.3 0-.2.2-.4.4-.4h3.1c3.9-2.2 8.7-2.2 12.6 0h3.1c.1 0 .2 0 .3.1.2.1.2.4 0 .6-.3.4-.6.9-.8 1.4 1.7 2.1 1.3 5.2-.8 6.9zm-8.9-4.1c0-2.2-1.8-4.1-4.1-4.1h-1C2.3 7.1 1 8.8 1 10.7c0 2.2 1.9 4 4.1 4 2.3.1 4.1-1.8 4.1-4zm6.6-4h-.2c-.2 0-.5-.1-.7-.1-2.2 0-4 1.7-4.1 3.9 0 .7.2 1.4.5 2.1.1.1.1.2.2.3.8 1.1 2 1.8 3.4 1.8 1.9 0 3.5-1.3 3.9-3.1.5-2.1-.8-4.3-3-4.9z"/>
				</svg>';
			break;

			case 'foursquare':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Foursquare Icon">
					<path d="M14.8 2.9l-.4 2.3c-.1.3-.4.5-.7.5H9.5c-.5 0-.8.4-.8.8V7c0 .5.3.8.8.8H13c.3 0 .7.4.6.7l-.4 2.3c0 .2-.3.5-.7.5H9.6c-.5 0-.7.1-1 .5-.3.4-3.5 4.2-3.5 4.2H5V2.8c0-.3.3-.6.6-.6h8.6c.4 0 .7.3.6.7zm.3 9.1c.1-.5 1.5-7.3 1.9-9.5M15.4 0H4.7C3.3 0 2.8 1.1 2.8 1.8v16.9c0 .8.4 1.1.7 1.2.2.1.9.2 1.3-.3 0 0 5-5.8 5.1-5.9.1-.1.1-.1.3-.1h3.3c1.4 0 1.6-1 1.7-1.5.1-.5 1.5-7.3 1.9-9.5C17.4.9 17 0 15.4 0z"/>
				</svg>';
			break;

			case 'yelp':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Yelp Icon">
					<path d="M18.8 14.4c0 .4-.3.8-.3.9l-2.1 2.9-.1.1c-.1 0-.5.3-1 .3s-1-.6-1.1-.7l-2.7-4.2c-.3-.3-.3-1 .1-1.5.3-.3.5-.3.9-.3h.3l5 1.5c.3.1 1 .3 1 1zm-6.1-3.3l5-1.4c.2-.1.9-.3 1-.9.2-.5-.1-1-.2-1 0 0 0-.1-.1-.1L16 5.2c0-.1-.3-.5-1-.5s-1 .6-1 .7l-2.8 4.2c-.2.3-.3.8 0 1.2.3.2.6.3 1.1.3h.4zM9.9.2C9.3 0 8.9 0 8.6.1L4.4 1.4c-.1 0-.5.2-.9.6-.4.8.4 1.6.4 1.6l4.4 5.5c.1.1.4.4 1 .4h.3c.7-.2 1-.9 1-1.3V1.6c-.1-.2-.2-1.1-.7-1.4zM8 12.6c.3-.1.7-.3.7-1.1s-.8-1.1-.9-1.2L3.4 8.2c-.1 0-1-.3-1.3-.1-.2.1-.7.5-.7.9l-.3 3.3c0 .2 0 .7.2 1 .1.2.3.4.8.4.3 0 .6-.1.6-.1l5.1-1c.2.1.2 0 .2 0zm1.8.3c-.2-.1-.3-.1-.4-.1-.5 0-1 .3-1 .4l-3.5 3.6c-.1.2-.5.8-.3 1.3.2.4.3.7.8.9l3.5 1h.4c.2 0 .3 0 .4-.1.5-.2.7-.8.7-1.2l.1-4.9c0-.2-.2-.7-.7-.9z"/>
				</svg>';
			break;

			case 'hacker_news':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Hacker News Icon">
					<path d="M0,0v20h20V0H0z M11.2,11.8v4.7H8.8v-4.7L4.7,4.1h1.9l3.4,6l3.4-6h1.9L11.2,11.8z"/>
				</svg>';
			break;

			case 'xing':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Xing Icon">
					<path d="M16.8,0H3.2C1.4,0,0,1.4,0,3.2v13.6C0,18.6,1.4,20,3.2,20h13.6c1.8,0,3.2-1.4,3.2-3.2V3.2C20,1.4,18.6,0,16.8,0z M6.2,13.3H3.8c-0.2,0-0.3-0.3-0.3-0.4L6,8.4c0.1-0.1,0.1-0.2,0-0.3L4.5,5.4C4.4,5.3,4.5,5,4.7,5H7c0.1,0,0.2,0.1,0.3,0.2L9,8.2c0.1,0.1,0.1,0.2,0,0.3l-2.6,4.7C6.4,13.2,6.2,13.3,6.2,13.3z M16.3,2.9l-4.7,8.6c-0.1,0.1-0.1,0.2,0,0.3l3,5.3c0.1,0.2,0,0.4-0.3,0.4h-2.3c-0.1,0-0.2-0.1-0.3-0.2l-3.2-5.6c-0.1-0.1-0.1-0.2,0-0.3l4.8-8.9c0.1,0,0.3-0.1,0.3-0.1h2.3C16.3,2.5,16.4,2.8,16.3,2.9z"/>
				</svg>';
			break;

			case 'whatsapp':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="WhatsApp Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,1.9,0.5,3.6,1.4,5.1L0.1,20l5-1.3C6.5,19.5,8.2,20,10,20c5.5,0,10-4.5,10-10S15.5,0,10,0zM6.6,5.3c0.2,0,0.3,0,0.5,0c0.2,0,0.4,0,0.6,0.4c0.2,0.5,0.7,1.7,0.8,1.8c0.1,0.1,0.1,0.3,0,0.4C8.3,8.2,8.3,8.3,8.1,8.5C8,8.6,7.9,8.8,7.8,8.9C7.7,9,7.5,9.1,7.7,9.4c0.1,0.2,0.6,1.1,1.4,1.7c0.9,0.8,1.7,1.1,2,1.2c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.2,0.6-0.7,0.8-1c0.2-0.2,0.3-0.2,0.6-0.1c0.2,0.1,1.4,0.7,1.7,0.8s0.4,0.2,0.5,0.3c0.1,0.1,0.1,0.6-0.1,1.2c-0.2,0.6-1.2,1.1-1.7,1.2c-0.5,0-0.9,0.2-3-0.6c-2.5-1-4.1-3.6-4.2-3.7c-0.1-0.2-1-1.3-1-2.6c0-1.2,0.6-1.8,0.9-2.1C6.1,5.4,6.4,5.3,6.6,5.3z"/>
				</svg>';
			break;

			case 'flipboard':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Flipboard Icon">
					<path d="M0 0v20h20V0H0zm16 8h-4v4H8v4H4V4h12v4z"/>
				</svg>';
			break;

			case 'viber':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Viber Icon">
					<path d="M18.6,4.4c-0.3-1.2-1-2.2-2-2.9c-1.2-0.9-2.7-1.2-3.9-1.4C11,0,9.4-0.1,8,0.1C6.6,0.3,5.5,0.6,4.6,1c-1.9,0.9-3,2.2-3.3,4.1C1.1,6,1,6.9,0.9,7.6c-0.2,1.8,0,3.4,0.4,4.9c0.4,1.5,1.2,2.5,2.2,3.2c0.3,0.2,0.6,0.3,1,0.4c0.2,0.1,0.3,0.1,0.5,0.2v2.9C5,19.7,5.3,20,5.7,20l0,0c0.2,0,0.4-0.1,0.5-0.2l2.7-2.6C9,17,9,17,9.1,17c0.9,0,1.9-0.1,2.8-0.1c1.1-0.1,2.5-0.2,3.7-0.7c1.1-0.5,2-1.2,2.5-2.2c0.5-1.1,0.8-2.2,0.9-3.5C19.3,8.2,19.1,6.2,18.6,4.4z M13.9,13.1c-0.3,0.4-0.7,0.8-1.2,1c-0.4,0.1-0.7,0.1-1.1,0C8.8,12.8,6.5,10.9,5,8.1C4.7,7.5,4.5,6.9,4.2,6.3C4.2,6.2,4.2,6,4.2,5.9c0-1,0.8-1.5,1.5-1.7c0.3-0.1,0.5,0,0.8,0.2c0.6,0.6,1.1,1.2,1.4,2C8,6.7,8,7,7.7,7.2C7.6,7.3,7.6,7.3,7.5,7.4C6.9,7.8,6.8,8.2,7.2,8.9c0.5,1.2,1.5,1.9,2.6,2.4c0.3,0.1,0.6,0.1,0.8-0.2c0,0,0.1-0.1,0.1-0.1c0.5-0.8,1.1-0.7,1.8-0.3c0.4,0.3,0.8,0.6,1.2,0.9C14.3,12.1,14.3,12.5,13.9,13.1z M10.4,5.1c-0.2,0-0.3,0-0.5,0C9.7,5.2,9.5,5,9.4,4.8c0-0.3,0.1-0.5,0.4-0.5c0.2,0,0.4-0.1,0.6-0.1c2.1,0,3.7,1.7,3.7,3.7c0,0.2,0,0.4-0.1,0.6c0,0.2-0.2,0.4-0.5,0.4c0,0-0.1,0-0.1,0c-0.3,0-0.4-0.3-0.4-0.5c0-0.2,0-0.3,0-0.5C13.2,6.4,12,5.1,10.4,5.1z M12.5,8.2c0,0.3-0.2,0.5-0.5,0.5s-0.5-0.2-0.5-0.5c0-0.8-0.6-1.4-1.4-1.4c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5C11.4,5.8,12.5,6.9,12.5,8.2zM15.7,8.8c-0.1,0.2-0.2,0.4-0.5,0.4c0,0-0.1,0-0.1,0c-0.3-0.1-0.4-0.3-0.4-0.6c0.1-0.3,0.1-0.6,0.1-0.9c0-2.3-1.9-4.2-4.2-4.2c-0.3,0-0.6,0-0.9,0.1C9.5,3.6,9.2,3.5,9.2,3.2C9.1,2.9,9.3,2.7,9.5,2.6c0.4-0.1,0.8-0.1,1.1-0.1c2.8,0,5.2,2.3,5.2,5.2C15.8,8,15.8,8.4,15.7,8.8z"/>
				</svg>';
			break;

			case 'line':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Line Icon">
					<path d="M16.1 8.2c.3 0 .5.2.5.5s-.2.5-.5.5h-1.5v.9h1.5c.3 0 .5.2.5.5s-.2.5-.5.5h-2c-.3 0-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5h2c.3 0 .5.2.5.5s-.2.5-.5.5h-1.5V8h1.5zm-3.2 2.5c0 .2-.1.4-.4.5h-.2c-.2 0-.3-.1-.4-.2l-2-2.8v2.5c0 .3-.2.5-.5.5s-.5-.2-.5-.5v-4c0-.2.1-.4.4-.5h.2c.2 0 .3.1.4.2L12 9.2V6.8c0-.3.2-.5.5-.5s.5.2.5.5v3.9zm-4.8 0c0 .3-.2.5-.5.5s-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5s.5.2.5.5v4zm-2 .6h-2c-.3 0-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5s.5.2.5.5v3.5h1.5c.3 0 .5.2.5.5 0 .2-.2.5-.5.5M20 8.6C20 4.1 15.5.5 10 .5S0 4.1 0 8.6c0 4 3.6 7.4 8.4 8 .3.1.8.2.9.5.1.3.1.6 0 .9l-.1.9c0 .3-.2 1 .9.5 1.1-.4 5.8-3.4 7.9-5.8 1.3-1.6 2-3.2 2-5"/>
				</svg>';
			break;

			case 'weibo':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Weibo Icon">
					<path d="M15.9,7.6c0.3-0.9-0.5-1.8-1.5-1.6c-0.9,0.2-1.1-1.1-0.3-1.3c2-0.4,3.6,1.4,3,3.3C16.9,8.8,15.6,8.4,15.9,7.6z M8.4,18.1c-4.2,0-8.4-2-8.4-5.3C0,11,1.1,9,3,7.2c3.9-3.9,7.9-3.9,6.8-0.2c-0.2,0.5,0.5,0.2,0.5,0.2c3.1-1.3,5.5-0.7,4.5,2c-0.1,0.4,0,0.4,0.3,0.5C20.3,11.3,16.4,18.1,8.4,18.1L8.4,18.1zM14,12.4c-0.2-2.2-3.1-3.7-6.4-3.3C4.3,9.4,1.8,11.4,2,13.6s3.1,3.7,6.4,3.3C11.7,16.6,14.2,14.6,14,12.4zM13.6,2c-1,0.2-0.7,1.7,0.3,1.5c2.8-0.6,5.3,2.1,4.4,4.8c-0.3,0.9,1.1,1.4,1.5,0.5C21,4.9,17.6,1.2,13.6,2L13.6,2z M10.5,14.2c-0.7,1.5-2.6,2.3-4.3,1.8c-1.6-0.5-2.3-2.1-1.6-3.5c0.7-1.4,2.5-2.2,4-1.8C10.4,11.1,11.2,12.7,10.5,14.2zM7.2,13c-0.5-0.2-1.2,0-1.5,0.5C5.3,14,5.5,14.6,6,14.8c0.5,0.2,1.2,0,1.5-0.5C7.8,13.8,7.7,13.2,7.2,13zM8.4,12.5c-0.2-0.1-0.4,0-0.6,0.2c-0.1,0.2-0.1,0.4,0.1,0.5c0.2,0.1,0.5,0,0.6-0.2C8.7,12.8,8.6,12.6,8.4,12.5z"/>
				</svg>';
			break;

			case 'tumblr':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Tumblr Icon">
					<path d="M18,0H2C0.9,0,0,0.9,0,2v16c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V2C20,0.9,19.1,0,18,0z M15,15.9c0,0,0,0.1-0.1,0.1c0,0-1.4,1-3.9,1c-3,0-3-3.6-3-4V9H6.2C6.1,9,6,8.9,6,8.8V7.2C6,7.1,6,7,6.1,7C6.1,7,9,5.7,9,3.2C9,3.1,9.1,3,9.2,3h1.7C10.9,3,11,3.1,11,3.2V7h2.8C13.9,7,14,7.1,14,7.2v1.7C14,8.9,13.9,9,13.8,9H11v4c0,0.1-0.1,1.3,1.2,1.3c1.1,0,2.5-0.3,2.5-0.3c0.1,0,0.1,0,0.2,0c0.1,0,0.1,0.1,0.1,0.2V15.9z"/>
				</svg>';
			break;

			case 'qq':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="QQ Icon">
					<path d="M18.2,16.4c-0.5,0.1-1.8-2.1-1.8-2.1c0,1.2-0.6,2.8-2,4c0.7,0.2,2.1,0.7,1.8,1.3C16,20.2,11.3,20,10,19.8c-1.3,0.2-5.9,0.3-6.2-0.2c-0.4-0.6,1.1-1.1,1.8-1.3c-1.4-1.2-2-2.8-2-4c0,0-1.3,2.1-1.8,2.1c-0.2,0-0.5-1.2,0.4-3.9c0.4-1.3,0.9-2.4,1.6-4.1C3.6,3.8,5.5,0,10,0c4.4,0,6.4,3.8,6.3,8.4c0.7,1.8,1.2,2.8,1.6,4.1C18.7,15.3,18.4,16.4,18.2,16.4L18.2,16.4z"/>
				</svg>';
			break;

			case 'wechat':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="WeChat Icon">
					<path d="M13.5,6.8c0.2,0,0.5,0,0.7,0c-0.6-2.9-3.7-5-7.1-5C3.2,1.9,0,4.5,0,7.9c0,1.9,1.1,3.5,2.8,4.8l-0.7,2.1l2.5-1.2c0.9,0.2,1.6,0.4,2.5,0.4c0.2,0,0.4,0,0.7,0c-0.1-0.5-0.2-1-0.2-1.5C7.5,9.3,10.2,6.8,13.5,6.8L13.5,6.8zM9.7,4.9c0.5,0,0.9,0.4,0.9,0.9c0,0.5-0.4,0.9-0.9,0.9c-0.5,0-1.1-0.4-1.1-0.9C8.7,5.2,9.2,4.9,9.7,4.9zM4.8,6.6c-0.5,0-1.1-0.4-1.1-0.9c0-0.5,0.5-0.9,1.1-0.9c0.5,0,0.9,0.4,0.9,0.9C5.7,6.3,5.3,6.6,4.8,6.6z M20,12.3c0-2.8-2.8-5.1-6-5.1c-3.4,0-6,2.3-6,5.1s2.6,5.1,6,5.1c0.7,0,1.4-0.2,2.1-0.4l1.9,1.1l-0.5-1.8C18.9,15.3,20,13.9,20,12.3zM12,11.4c-0.4,0-0.7-0.4-0.7-0.7c0-0.4,0.4-0.7,0.7-0.7c0.5,0,0.9,0.4,0.9,0.7C12.9,11.1,12.6,11.4,12,11.4zM15.9,11.4c-0.4,0-0.7-0.4-0.7-0.7c0-0.4,0.4-0.7,0.7-0.7c0.5,0,0.9,0.4,0.9,0.7C16.8,11.1,16.5,11.4,15.9,11.4z"/>
				</svg>';
			break;

			case 'strava':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Strava Icon">
					<path d="M12.3,13.9l-1.4-2.7h2.8L12.3,13.9z M20,3v14c0,1.7-1.3,3-3,3H3c-1.7,0-3-1.3-3-3V3c0-1.7,1.3-3,3-3h14C18.7,0,20,1.3,20,3zM15.8,11.1h-2.1L9,2l-4.7,9.1H7L9,7.5l1.9,3.6H8.8l3.5,6.9L15.8,11.1z"/>
				</svg>';
			break;

			case 'flickr':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Flickr Icon">
					<path d="M4.7 14.7C2.1 14.8 0 12.6 0 10c0-2.5 2.1-4.7 4.8-4.7 2.6 0 4.7 2.1 4.7 4.8 0 2.6-2.2 4.7-4.8 4.6z"/>
					<path d="M15.3 5.3C18 5.3 20 7.5 20 10c0 2.6-2.1 4.7-4.7 4.7-2.5 0-4.7-2-4.7-4.7-.1-2.6 2-4.7 4.7-4.7z"/>
				</svg>';
			break;

			case 'phone':
				return '<svg width="26" height="25" viewBox="0 0 26 25" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.7611 22.9166C18.0378 22.9182 18.312 22.8646 18.5677 22.7591C18.8235 22.6536 19.0556 22.4982 19.2507 22.302L22.0736 19.4791C22.2676 19.2839 22.3765 19.0199 22.3765 18.7447C22.3765 18.4695 22.2676 18.2055 22.0736 18.0103L17.9069 13.8437C17.7118 13.6496 17.4478 13.5407 17.1726 13.5407C16.8974 13.5407 16.6334 13.6496 16.4382 13.8437L14.7715 15.4999C13.6176 15.1922 12.5489 14.6258 11.6465 13.8437C10.8664 12.9398 10.3003 11.8716 9.99027 10.7187L11.6465 9.05199C11.8405 8.85682 11.9494 8.59281 11.9494 8.31761C11.9494 8.04242 11.8405 7.77841 11.6465 7.58324L7.47985 3.41657C7.28468 3.22256 7.02067 3.11366 6.74548 3.11366C6.47028 3.11366 6.20627 3.22256 6.0111 3.41657L3.1986 6.2499C3.00239 6.44495 2.84698 6.67712 2.74146 6.93287C2.63594 7.18862 2.58242 7.46283 2.58402 7.73949C2.67852 11.7419 4.27785 15.5617 7.06319 18.4374C9.93893 21.2227 13.7587 22.8221 17.7611 22.9166V22.9166ZM6.75069 5.63532L9.4486 8.33324L8.10485 9.67699C7.97758 9.7962 7.88228 9.94546 7.82768 10.1111C7.77308 10.2767 7.76093 10.4534 7.79235 10.6249C8.1817 12.3649 9.00601 13.9777 10.1882 15.3124C11.5219 16.4961 13.1351 17.3206 14.8757 17.7082C15.0446 17.7436 15.2197 17.7363 15.3851 17.6873C15.5506 17.6382 15.7013 17.5487 15.8236 17.427L17.1674 16.052L19.8653 18.7499L17.7819 20.8332C14.3275 20.7443 11.0314 19.3657 8.54235 16.9687C6.13914 14.4786 4.75653 11.1781 4.66735 7.71865L6.75069 5.63532ZM21.334 11.4582H23.4174C23.4444 10.2197 23.2203 8.98851 22.7588 7.83887C22.2972 6.68923 21.6076 5.64495 20.7316 4.76896C19.8556 3.89297 18.8114 3.20341 17.6617 2.74183C16.5121 2.28026 15.2809 2.05622 14.0424 2.08324V4.16657C15.0089 4.13313 15.972 4.29887 16.8718 4.65348C17.7716 5.00809 18.5889 5.54399 19.2727 6.22786C19.9566 6.91174 20.4925 7.72897 20.8471 8.62876C21.2017 9.52855 21.3675 10.4917 21.334 11.4582Z"
                    fill="#AF9065" />
                <path
                    d="M14.041 8.33333C16.2285 8.33333 17.166 9.27083 17.166 11.4583H19.2493C19.2493 8.10417 17.3952 6.25 14.041 6.25V8.33333Z"
                    fill="#AF9065" />
                </svg>';
			break;

			case 'email':
				return '<svg width="19" height="14" viewbox="0 0 19 14" fill="#F7F7F7" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9448 4.79271C18.0768 4.68776 18.2732 4.78594 18.2732 4.95182V11.875C18.2732 12.7721 17.5453 13.5 16.6482 13.5H2.56482C1.66768 13.5 0.939819 12.7721 0.939819 11.875V4.95521C0.939819 4.78594 1.13279 4.69115 1.2682 4.79609C2.02654 5.38516 3.03201 6.13333 6.48513 8.64193C7.19946 9.16328 8.40466 10.2602 9.60649 10.2534C10.8151 10.2635 12.044 9.14297 12.7312 8.64193C16.1844 6.13333 17.1864 5.38177 17.9448 4.79271ZM9.60649 9.16667C10.3919 9.18021 11.5226 8.17813 12.0914 7.7651C16.5838 4.50495 16.9258 4.22057 17.9617 3.40807C18.158 3.25573 18.2732 3.01875 18.2732 2.76823V2.125C18.2732 1.22786 17.5453 0.5 16.6482 0.5H2.56482C1.66768 0.5 0.939819 1.22786 0.939819 2.125V2.76823C0.939819 3.01875 1.05492 3.25234 1.25128 3.40807C2.28722 4.21719 2.62914 4.50495 7.12159 7.7651C7.69034 8.17813 8.82107 9.18021 9.60649 9.16667Z" />
                </svg>';
			break;

            case 'location':
				return '<svg width="13" height="16" viewBox="0 0 13 16" fill="" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.22101 16C5.09851 15.0425 4.05805 13.9928 3.11051 12.8619C1.68856 11.1636 7.81087e-07 8.63433 7.81087e-07 6.22413C-0.000615897 4.99322 0.363937 3.7898 1.04752 2.76616C1.73111 1.74252 2.703 0.944677 3.8402 0.473603C4.9774 0.00252992 6.22878 -0.120599 7.43599 0.1198C8.64319 0.360199 9.75194 0.953319 10.6219 1.8241C11.2012 2.40075 11.6603 3.08655 11.9727 3.84181C12.2851 4.59708 12.4446 5.4068 12.442 6.22413C12.442 8.63433 10.7535 11.1636 9.33151 12.8619C8.38397 13.9928 7.34351 15.0425 6.22101 16ZM6.22101 3.55798C5.5139 3.55798 4.83576 3.83888 4.33576 4.33888C3.83576 4.83888 3.55486 5.51702 3.55486 6.22413C3.55486 6.93123 3.83576 7.60938 4.33576 8.10938C4.83576 8.60938 5.5139 8.89028 6.22101 8.89028C6.92812 8.89028 7.60626 8.60938 8.10626 8.10938C8.60626 7.60938 8.88716 6.93123 8.88716 6.22413C8.88716 5.51702 8.60626 4.83888 8.10626 4.33888C7.60626 3.83888 6.92812 3.55798 6.22101 3.55798Z"/>
                </svg>';
			break;

            case 'booking':
                return '<svg width="17" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.00152 16.6156L3.73579 16.6122V12.5886C3.73579 11.7289 4.05943 11.2815 4.77341 11.1793H7.00154C8.5905 11.1793 9.61837 12.2116 9.61837 13.8823C9.61837 15.5984 8.61652 16.6139 7.00154 16.6156H7.00152ZM3.73579 5.76309V4.70399C3.73579 3.77727 4.11635 3.33653 4.95068 3.27955H6.62259C8.05542 3.27955 8.91415 4.1627 8.91415 5.64244C8.91415 6.76857 8.32541 8.08408 6.67464 8.08408H3.73579V5.76309ZM11.1715 9.77832L10.5812 9.43646L11.0968 8.98231C11.6969 8.45107 12.702 7.25623 12.702 5.19499C12.702 2.03778 10.3258 0.00168281 6.64861 0.00168281H2.45257V0H1.97441C0.884745 0.0418995 0.0113829 0.955218 0 2.08472V19.999H6.73155C10.8186 19.999 13.4566 17.7065 13.4566 14.1555C13.4566 12.2434 12.6044 10.6095 11.1715 9.77832Z"/>
                <path d="M15.2097 17.5243C15.2097 16.1558 16.2809 15.0487 17.6007 15.0487C18.9238 15.0487 20 16.1558 20 17.5243C20 18.8911 18.9238 20 17.6006 20C16.2809 20 15.2097 18.8911 15.2097 17.5243" fill="white"/>
                </svg>';
            break;



			default:
				# code...
				break;
			}

	}
endif;

if( ! function_exists( 'hotell_misc_svg' ) ) :
    /**
     * Miscellaneous SVG
    */
    function hotell_misc_svg( $svg ){
		if( !$svg ){
			return;
		}
		switch ( $svg ) {

            case 'comment':
				return '<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.1177 13.0742C12.946 13.0742 14.3605 13.0742 15.2387 12.1952C16.1177 11.317 16.1177 9.90247 16.1177 7.07422C16.1177 4.24597 16.1177 2.83147 15.2387 1.95322C14.3605 1.07422 12.946 1.07422 10.1177 1.07422H7.11774C4.28949 1.07422 2.87499 1.07422 1.99674 1.95322C1.11774 2.83147 1.11774 4.24597 1.11774 7.07422C1.11774 9.90247 1.11774 11.317 1.99674 12.1952C2.48649 12.6857 3.14274 12.9025 4.11774 12.9977" stroke="#AF9065" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.1178 13.0737C9.19076 13.0737 8.16926 13.4487 7.23701 13.9325C5.73851 14.7102 4.98926 15.0995 4.62026 14.8512C4.25126 14.6037 4.32101 13.835 4.46126 12.2982L4.49276 11.9487" stroke="#AF9065" stroke-width="1.5" stroke-linecap="round"/>
                </svg>';
			break;

            case 'loadmore':
				return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" width="30px" height="30px" aria-label="Loadmore Icon">
                <g id="surface74754117">
                <path style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" d="M 15 3 C 12.03125 3 9.304688 4.082031 7.207031 5.875 C 6.921875 6.101562 6.78125 6.46875 6.84375 6.828125 C 6.90625 7.1875 7.160156 7.484375 7.507812 7.605469 C 7.855469 7.722656 8.238281 7.640625 8.503906 7.394531 C 10.253906 5.898438 12.515625 5 15 5 C 20.195312 5 24.449219 8.9375 24.949219 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.4375 7.851562 21.277344 3 15 3 Z M 4 10 L 0 16 L 3.050781 16 C 3.5625 22.148438 8.722656 27 15 27 C 17.96875 27 20.695312 25.917969 22.792969 24.125 C 23.078125 23.898438 23.21875 23.53125 23.15625 23.171875 C 23.09375 22.8125 22.839844 22.515625 22.492188 22.394531 C 22.144531 22.277344 21.761719 22.359375 21.496094 22.605469 C 19.746094 24.101562 17.484375 25 15 25 C 9.804688 25 5.550781 21.0625 5.046875 16 L 8 16 Z M 4 10 "/>
                </g>
                </svg>';
			break;

            case 'admin':
				return '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.5293 13.0184C14.153 12.1271 13.6069 11.3175 12.9216 10.6348C12.2383 9.95002 11.4288 9.40407 10.5379 9.02707C10.53 9.02308 10.522 9.02108 10.514 9.01709C11.7567 8.11949 12.5645 6.6574 12.5645 5.00781C12.5645 2.27512 10.3504 0.0610352 7.61774 0.0610352C4.88504 0.0610352 2.67096 2.27512 2.67096 5.00781C2.67096 6.6574 3.4788 8.11949 4.72148 9.01909C4.7135 9.02308 4.70552 9.02507 4.69754 9.02906C3.80393 9.40605 3.00208 9.94661 2.31392 10.6368C1.62917 11.3201 1.08321 12.1295 0.706214 13.0204C0.335848 13.8926 0.136102 14.8276 0.117787 15.775C0.117254 15.7963 0.120988 15.8175 0.128769 15.8373C0.13655 15.8571 0.148219 15.8752 0.16309 15.8904C0.177961 15.9057 0.195733 15.9178 0.215358 15.9261C0.234983 15.9343 0.256065 15.9386 0.27736 15.9386H1.47416C1.56193 15.9386 1.63174 15.8688 1.63373 15.783C1.67363 14.2431 2.29197 12.801 3.38505 11.7079C4.51603 10.5769 6.01801 9.95459 7.61774 9.95459C9.21746 9.95459 10.7194 10.5769 11.8504 11.7079C12.9435 12.801 13.5618 14.2431 13.6017 15.783C13.6037 15.8708 13.6735 15.9386 13.7613 15.9386H14.9581C14.9794 15.9386 15.0005 15.9343 15.0201 15.9261C15.0397 15.9178 15.0575 15.9057 15.0724 15.8904C15.0873 15.8752 15.0989 15.8571 15.1067 15.8373C15.1145 15.8175 15.1182 15.7963 15.1177 15.775C15.0977 14.8216 14.9003 13.8941 14.5293 13.0184ZM7.61774 8.43864C6.70218 8.43864 5.84049 8.08159 5.19222 7.43333C4.54395 6.78506 4.18691 5.92336 4.18691 5.00781C4.18691 4.09226 4.54395 3.23056 5.19222 2.58229C5.84049 1.93403 6.70218 1.57698 7.61774 1.57698C8.53329 1.57698 9.39499 1.93403 10.0433 2.58229C10.6915 3.23056 11.0486 4.09226 11.0486 5.00781C11.0486 5.92336 10.6915 6.78506 10.0433 7.43333C9.39499 8.08159 8.53329 8.43864 7.61774 8.43864Z" fill="#AF9065"/>
                </svg>';
			break;

            case 'search':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="16.197" height="16.546"
                viewBox="0 0 16.197 16.546" aria-label="Search Icon">
                <path id="icons8-search"
                    d="M9.939,3a5.939,5.939,0,1,0,3.472,10.754l4.6,4.585.983-.983L14.448,12.8A5.939,5.939,0,0,0,9.939,3Zm0,.7A5.24,5.24,0,1,1,4.7,8.939,5.235,5.235,0,0,1,9.939,3.7Z"
                    transform="translate(-3.5 -2.5)" fill="#001a1a" stroke="#001a1a"
                    stroke-width="1" opacity="0.9" />
                </svg>';
            break;

			case 'cart':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33">
				<path id="Path_10" data-name="Path 10"
					d="M1505.694,120.218l-22.707-.039-.643-3.545a1.989,1.989,0,0,0-1.958-1.634h-4.419a.967.967,0,1,0,0,1.934c4.679,0,4.461-.026,4.474.046,1.049,5.777.381,1.74,3.2,19.749l-2.48.013a1.945,1.945,0,0,0-1.922,2.185l.274,2.193a1.948,1.948,0,0,0,1.929,1.7h1.716a3.555,3.555,0,1,0,6.325,0h9.208a3.555,3.555,0,1,0,6.325,0h2.015a.966.966,0,1,0,0-1.933c-26.795,0-25.6,0-25.6-.009a18.155,18.155,0,0,1-.263-2.2c12.875-.067-17.9,0,23.783,0a2.984,2.984,0,0,0,3.046-3.055v-13.1A2.311,2.311,0,0,0,1505.694,120.218Zm-17.75,24.226a1.622,1.622,0,1,1-1.622-1.622,1.623,1.623,0,0,1,1.622,1.622Zm15.534,0a1.622,1.622,0,1,1-1.623-1.622,1.624,1.624,0,0,1,1.623,1.622Zm2.588-21.919v5.946h-6.252l.791-6.328,5.086.009A.374.374,0,0,1,1506.066,122.525Zm-13.709,14.221-.793-6.342h6.06l-.793,6.342Zm-6.754,0-.994-6.342h5.006l.793,6.342Zm5.719-8.275-.793-6.345,8.128.014-.792,6.331Zm-2.742-6.349.794,6.349h-5.067l-1-6.358Zm16.374,14.624h-6.175l.793-6.342h6.494v5.221A1.057,1.057,0,0,1,1504.954,136.746Z"
					transform="translate(-1475 -115)" fill="#040505" />
				</svg>';
			break;

            case 'arrow':
                return '<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.219421 0.601684C0.251571 0.569452 0.289765 0.543879 0.331815 0.52643C0.373864 0.508982 0.418943 0.5 0.464469 0.5C0.509995 0.5 0.555073 0.508982 0.597123 0.52643C0.639172 0.543879 0.677366 0.569452 0.709517 0.601684L4.86288 4.75504C4.89511 4.78719 4.92068 4.82539 4.93813 4.86744C4.95558 4.90949 4.96456 4.95456 4.96456 5.00009C4.96456 5.04562 4.95558 5.09069 4.93813 5.13274C4.92068 5.17479 4.89511 5.21299 4.86288 5.24514L0.709517 9.3985C0.644526 9.46349 0.55638 9.5 0.464469 9.5C0.372558 9.5 0.284411 9.46349 0.219421 9.3985C0.15443 9.33351 0.117918 9.24536 0.117918 9.15345C0.117918 9.06154 0.15443 8.97339 0.219421 8.9084L4.12842 5.00009L0.219421 1.09178C0.187188 1.05963 0.161616 1.02144 0.144167 0.979386C0.126718 0.937337 0.117737 0.892258 0.117737 0.846732C0.117737 0.801206 0.126718 0.756128 0.144167 0.714078C0.161616 0.672029 0.187188 0.633835 0.219421 0.601684Z" fill="#AF9065"/><path fill-rule="evenodd" clip-rule="evenodd" d="M4.37278 0.601684C4.40493 0.569452 4.44312 0.543879 4.48517 0.52643C4.52722 0.508982 4.5723 0.5 4.61783 0.5C4.66335 0.5 4.70843 0.508982 4.75048 0.52643C4.79253 0.543879 4.83072 0.569452 4.86288 0.601684L9.01623 4.75504C9.04847 4.78719 9.07404 4.82539 9.09149 4.86744C9.10894 4.90949 9.11792 4.95456 9.11792 5.00009C9.11792 5.04562 9.10894 5.09069 9.09149 5.13274C9.07404 5.17479 9.04847 5.21299 9.01623 5.24514L4.86288 9.3985C4.79788 9.46349 4.70974 9.5 4.61783 9.5C4.52592 9.5 4.43777 9.46349 4.37278 9.3985C4.30779 9.33351 4.27128 9.24536 4.27128 9.15345C4.27128 9.06154 4.30779 8.97339 4.37278 8.9084L8.28178 5.00009L4.37278 1.09178C4.34055 1.05963 4.31497 1.02144 4.29753 0.979386C4.28008 0.937337 4.2711 0.892258 4.2711 0.846732C4.2711 0.801206 4.28008 0.756128 4.29753 0.714078C4.31497 0.672029 4.34055 0.633835 4.37278 0.601684Z" fill="#AF9065"/>
                </svg>';
            break;

            case 'email-contact':
                return '<svg width="26" height="25" viewBox="0 0 26 25" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M2.58398 6.24984C2.58398 5.6973 2.80348 5.1674 3.19418 4.7767C3.58488 4.386 4.11478 4.1665 4.66732 4.1665H21.334C21.8865 4.1665 22.4164 4.386 22.8071 4.7767C23.1978 5.1674 23.4173 5.6973 23.4173 6.24984V18.7498C23.4173 19.3024 23.1978 19.8323 22.8071 20.223C22.4164 20.6137 21.8865 20.8332 21.334 20.8332H4.66732C4.11478 20.8332 3.58488 20.6137 3.19418 20.223C2.80348 19.8323 2.58398 19.3024 2.58398 18.7498V6.24984Z"
                    stroke="#AF9065" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M2.58398 8.33301L10.3975 14.584C11.1364 15.1752 12.0544 15.4973 13.0007 15.4973C13.9469 15.4973 14.8649 15.1752 15.6038 14.584L23.4173 8.33301"
                    stroke="#AF9065" stroke-width="2" stroke-linejoin="round" />
                </svg>';
			break;

            case 'location-contact':
                return '<svg width="26" height="25" viewBox="0 0 26 25" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M13 13.542C14.7259 13.542 16.125 12.1429 16.125 10.417C16.125 8.6911 14.7259 7.29199 13 7.29199C11.2741 7.29199 9.875 8.6911 9.875 10.417C9.875 12.1429 11.2741 13.542 13 13.542Z"
                    stroke="#AF9065" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M12.9993 2.0835C10.7892 2.0835 8.6696 2.96147 7.10679 4.52427C5.54399 6.08708 4.66602 8.20669 4.66602 10.4168C4.66602 12.3877 5.08477 13.6772 6.22852 15.1043L12.9993 22.9168L19.7702 15.1043C20.9139 13.6772 21.3327 12.3877 21.3327 10.4168C21.3327 8.20669 20.4547 6.08708 18.8919 4.52427C17.3291 2.96147 15.2095 2.0835 12.9993 2.0835V2.0835Z"
                    stroke="#AF9065" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>';
            break;

            case 'time-contact':
                return '<svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.0007 2.0835C7.2569 2.0835 2.58398 6.75641 2.58398 12.5002C2.58398 18.2439 7.2569 22.9168 13.0007 22.9168C18.7444 22.9168 23.4173 18.2439 23.4173 12.5002C23.4173 6.75641 18.7444 2.0835 13.0007 2.0835ZM13.0007 20.8335C8.40586 20.8335 4.66732 17.095 4.66732 12.5002C4.66732 7.90537 8.40586 4.16683 13.0007 4.16683C17.5954 4.16683 21.334 7.90537 21.334 12.5002C21.334 17.095 17.5954 20.8335 13.0007 20.8335Z" fill="#AF9065"/>
                <path d="M14.0423 7.2915H11.959V13.5415H18.209V11.4582H14.0423V7.2915Z" fill="#AF9065"/>
                </svg>';
            break;

            case 'accomodation':
                return '<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.219421 0.601684C0.251571 0.569452 0.289765 0.543879 0.331815 0.52643C0.373864 0.508982 0.418943 0.5 0.464469 0.5C0.509995 0.5 0.555073 0.508982 0.597123 0.52643C0.639172 0.543879 0.677366 0.569452 0.709517 0.601684L4.86288 4.75504C4.89511 4.78719 4.92068 4.82539 4.93813 4.86744C4.95558 4.90949 4.96456 4.95456 4.96456 5.00009C4.96456 5.04562 4.95558 5.09069 4.93813 5.13274C4.92068 5.17479 4.89511 5.21299 4.86288 5.24514L0.709517 9.3985C0.644526 9.46349 0.55638 9.5 0.464469 9.5C0.372558 9.5 0.284411 9.46349 0.219421 9.3985C0.15443 9.33351 0.117918 9.24536 0.117918 9.15345C0.117918 9.06154 0.15443 8.97339 0.219421 8.9084L4.12842 5.00009L0.219421 1.09178C0.187188 1.05963 0.161616 1.02144 0.144167 0.979386C0.126718 0.937337 0.117737 0.892258 0.117737 0.846732C0.117737 0.801206 0.126718 0.756128 0.144167 0.714078C0.161616 0.672029 0.187188 0.633835 0.219421 0.601684Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M4.37278 0.601684C4.40493 0.569452 4.44312 0.543879 4.48517 0.52643C4.52722 0.508982 4.5723 0.5 4.61783 0.5C4.66335 0.5 4.70843 0.508982 4.75048 0.52643C4.79253 0.543879 4.83072 0.569452 4.86288 0.601684L9.01623 4.75504C9.04847 4.78719 9.07404 4.82539 9.09149 4.86744C9.10894 4.90949 9.11792 4.95456 9.11792 5.00009C9.11792 5.04562 9.10894 5.09069 9.09149 5.13274C9.07404 5.17479 9.04847 5.21299 9.01623 5.24514L4.86288 9.3985C4.79788 9.46349 4.70974 9.5 4.61783 9.5C4.52592 9.5 4.43777 9.46349 4.37278 9.3985C4.30779 9.33351 4.27128 9.24536 4.27128 9.15345C4.27128 9.06154 4.30779 8.97339 4.37278 8.9084L8.28178 5.00009L4.37278 1.09178C4.34055 1.05963 4.31497 1.02144 4.29753 0.979386C4.28008 0.937337 4.2711 0.892258 4.2711 0.846732C4.2711 0.801206 4.28008 0.756128 4.29753 0.714078C4.31497 0.672029 4.34055 0.633835 4.37278 0.601684Z" fill="white"/>
                </svg>';
            break;

            default:
            # code...
            break;
        }
    }
endif;

if( ! function_exists( 'hotell_get_svg_icons' ) ) :
/**
 * Fuction to list SVG Icons
*/
function hotell_get_svg_icons(){

    $social_media = [ 'facebook', 'twitter', 'digg', 'instagram', 'hotel', 'booking', 'pinterest', 'telegram', 'getpocket', 'dribbble', 'behance', 'unsplash', 'five-hundred-px', 'linkedin', 'wordpress', 'parler', 'mastodon', 'medium', 'slack', 'codepen', 'reddit', 'twitch', 'tiktok', 'snapchat', 'spotify', 'soundcloud', 'apple_podcast', 'patreon', 'alignable', 'skype', 'github', 'gitlab', 'youtube', 'vimeo', 'dtube', 'vk', 'ok', 'rss', 'facebook_group', 'discord', 'tripadvisor', 'foursquare', 'yelp', 'hacker_news', 'xing', 'flipboard', 'weibo', 'tumblr', 'qq', 'strava', 'flickr' ];

    // Initate an empty array
    $svg_options = array();
    $svg_options[''] = __( ' -- Choose -- ', 'hotell' );

        foreach ( $social_media as $svg ) {
            $svg_options[ $svg ] = esc_html( $svg );
        }

    return $svg_options;
}
endif;


if( ! function_exists( 'hotell_contact_form' ) ) :
/**
 * Contact page form
*/
function hotell_contact_form(){
    $contact_form    = get_theme_mod( 'contact_form_shortcode' );

    if( $contact_form  ){ ?>
        <div class="contact__form col">
            <div class="contact__form-wrap">
                <?php echo do_shortcode( $contact_form ); ?>
            </div>
        </div>
    <?php }
}
endif;

if( ! function_exists( 'hotell_google_maps' ) ) :
/**
 * Contact page google maps
*/
function hotell_google_maps(){
    $ed_map          = get_theme_mod( 'ed_google_map', false );
    $google_map      = get_theme_mod( 'google_map' );

    if( $ed_map && $google_map ){ ?>
        <div class="contact__map">
            <?php echo htmlspecialchars_decode( $google_map ); ?>
        </div>
    <?php }
    }
endif;

if( ! function_exists( 'hotell_mobile_navigation' ) ) :
/**
 * Mobile Navigation
 */
function hotell_mobile_navigation(){
    $btn_lbl   = get_theme_mod( 'header_btn_lbl' );
    $btn_link  = get_theme_mod( 'header_btn_link' ); ?>
    <div class="mobile-header">
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <?php hotell_site_branding( true ); ?>
                    <div class="nav-wrap">
                        <button id="menu-opener" class="toggle-btn toggle-main" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                            <span class="toggle-bar"></span>
                            <span class="toggle-bar"></span>
                            <span class="toggle-bar"></span>
                            <span class="toggle-bar"></span>
                        </button>
                        <div class="menu-container-wrapper">
                            <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">
                                <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                                    <div class="menu-top-wrap">
                                        <?php hotell_site_branding( true ); ?>
                                        <button class="close close-main-nav-toggle toggle-btn toggle-off" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal">
                                            <span class="toggle-bar"></span>
                                            <span class="toggle-bar"></span>
                                            <span class="toggle-bar"></span>
                                            <span class="toggle-bar"></span>
                                        </button>
                                        <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'hotell' ); ?>">
                                            <div class="header-left">
                                                <?php hotell_primary_nagivation(); ?>
                                                <div class="header-right">
                                                    <?php if( $btn_lbl && $btn_link ) echo '<div class="book-btn"><a href="' . esc_url( $btn_link ) . '" class="btn btn-sm btn-primary">' . esc_html( $btn_lbl ) . '</a></div>'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav><!-- #mobile-site-navigation -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
endif;


if( ! function_exists( 'hotell_single_entry_footer_sections' ) ) :
/**
 * FAQ Section
 */
function hotell_single_entry_footer_sections(){
    if ( is_singular( 'post' ) ) hotell_author_box();
    hotell_navigation();
    hotell_comment();
    if( is_singular( 'post' ) ) hotell_related_posts();
}
endif;

/**
 * Get font face styles.
 *
 * @since 1.0.4
 *
 * @return string
 */
if( ! function_exists( 'hotell_get_font_face_styles' ) ) :
	function hotell_get_font_face_styles() {

		return "
			@font-face{
				font-family: 'Cardo';
				font-weight: 300 400 700;
				font-style: normal;
				font-stretch: normal;
				font-display: swap;
				src: url('" . get_theme_file_uri( 'fonts/Cardo-Regular.ttf' ) . "');
			}

			@font-face{
				font-family: 'Cardo';
				font-weight: 300 400 700;
				font-style: italic;
				font-stretch: normal;
				font-display: swap;
				src: url('" . get_theme_file_uri( 'fonts/Cardo-italic.ttf' ) . "');
			}

			@font-face{
				font-family: 'Nunito';
				font-weight: 300 400 500 600;
				font-style: normal;
				font-stretch: normal;
				font-display: swap;
				src: url('" . get_theme_file_uri( 'fonts/Nunito-Regular.ttf' ) . "');
			}

			@font-face{
				font-family: 'Nunito';
				font-weight: 300 400 500 600;
				font-style: italic;
				font-stretch: normal;
				font-display: swap;
				src: url('" . get_theme_file_uri( 'fonts/Nunito-italic.ttf' ) . "');
			}
			";

	}
endif;


if( ! function_exists( 'hotell_get_breadcrumb_image_url' ) ) :
/**
 * Returns breadcrumb background image link
*/
function hotell_get_breadcrumb_image_url(){
    $blog_id            = get_option( 'page_for_posts' );

    if ( is_home() && ! is_front_page() ){
        $image_url = get_the_post_thumbnail_url( $blog_id, 'hotell-breadcrumb' );
    }elseif( is_tax() || is_category() || is_tag() ){
        $image_id  = get_term_meta( get_queried_object_id(), 'category-image-id', true);
        $image_url = wp_get_attachment_url( $image_id, 'hotell-breadcrumb', false );
    }else{
        $image_url = get_the_post_thumbnail_url( get_the_ID(), 'hotell-breadcrumb' );
    }

    return $image_url;
}
endif;

/**
 * Check if Contact Form 7 Plugin is installed
*/
function hotell_is_cf7_activated(){
    return class_exists( 'WPCF7' ) ? true : false;
}

/**
 * Query Jetpack activation
*/
function hotell_is_jetpack_activated( $gallery = false ){
	if( $gallery ){
        return ( class_exists( 'jetpack' ) && Jetpack::is_module_active( 'tiled-gallery' ) ) ? true : false;
	}else{
        return class_exists( 'jetpack' ) ? true : false;
    }
}