<?php 
 /**
 * Get font face styles.
 * 
 * @return void
 */
function hotell_get_font_face_styles() {

	return "
		@font-face{
			font-family: 'Philosopher';
			font-weight: 400;
			font-style: normal;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/Philosopher-Regular.ttf' ) . "');
		}

        @font-face{
            font-family: 'Philosopher';
            font-weight: 700;
            font-style: bold;
            font-stretch: normal;
            font-display: swap;
            src: url('" . get_theme_file_uri( 'assets/fonts/Philosopher-Bold.ttf' ) . "');
        }
		";
}

/**
 * Pluggable Function For Hotell Blog Section
 *
 * @return void
 */
function hotell_card_content(){
    echo '<div class="card__content">';
        hotell_posts_meta();
        the_title( '<h5><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
        if( has_excerpt() ){
            the_excerpt();
        }else{
            echo wpautop( wp_trim_words( get_the_content(),10,'..' ) );
        }
    echo '</div>';
}

/**
 * Pluggable Function For Hotell Gallery Section
 *
 * @return void
 */
function hotell_section_header( $sec_title, $sec_subtitle, $sec_content ){
    if( $sec_title || $sec_subtitle || $sec_content ){ ?>
        <div class="section-header">
            <?php if( $sec_title || $sec_subtitle ){ ?>
                <div class="content-left">
                    <?php
                        if( $sec_subtitle ) echo '<span class="section-header__tag">' . esc_html( $sec_subtitle ) . '</span>';
                        if( $sec_title ) echo '<h2 class="section-header__title section-header__title-2">' . esc_html( $sec_title ) . '</h2>';
                    ?>
                </div>
            <?php }if( $sec_content ){ ?>
                <div class="content-right">
                    <?php
                        if( $sec_content ) echo esc_html( $sec_content );
                    ?>
                </div>
            <?php } ?>
        </div>
    <?php }
}

/**
 * Pluggable Function For Hotell Banner
 *
 * @return void
 */

function hotell_get_banner(){
    $ed_banner         = get_theme_mod( 'ed_banner_section', 'static_banner' );
    $read_more         = get_theme_mod( 'slider_readmore', esc_html__( "Learn More", "cottageinn" ) );
    $read_more_link    = get_theme_mod( 'banner_readmore_link', "#" );
    $btn_lbl           = get_theme_mod( 'slider_btn_lbl', esc_html__( "Take A Tour", "cottageinn" ) );
    $btn_link          = get_theme_mod( 'slider_btn_link', "#" );
    $slider_target     = get_theme_mod( 'slider_btn_new_tab', false ) ? 'target=_blank' : '';
    $banner_title      = get_theme_mod( 'banner_title', esc_html__( 'Find Your Cozy Retreat in Nature\'s Embrace', 'cottageinn' ));
    $banner_subtitle   = get_theme_mod( 'banner_subtitle', esc_html__( 'WELCOME TO OUR COTTAGE', 'cottageinn' ) );
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

/**
 * Filter for banner Image
 * 
 * @return array
 */
add_filter( 'hotell_custom_header_args', function(){
    return array(
        'default-image' => esc_url( get_stylesheet_directory_uri() . '/assets/images/banner.jpg' ),
        'video'         => true,
        'width'         => 776,
        'height'        => 650,
        'header-text'   => false
    );
});

/**
 * Cottage SVG Function 
 * 
 * @return void
 */

 function hotell_misc_svg( $svg ){
    if( !$svg ){
        return;
    }
    switch ( $svg ) {

        case 'comment':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                <path d="M10.1177 13.0742C12.946 13.0742 14.3605 13.0742 15.2387 12.1952C16.1177 11.317 16.1177 9.90247 16.1177 7.07422C16.1177 4.24597 16.1177 2.83147 15.2387 1.95322C14.3605 1.07422 12.946 1.07422 10.1177 1.07422H7.11774C4.28949 1.07422 2.87499 1.07422 1.99674 1.95322C1.11774 2.83147 1.11774 4.24597 1.11774 7.07422C1.11774 9.90247 1.11774 11.317 1.99674 12.1952C2.48649 12.6857 3.14274 12.9025 4.11774 12.9977" stroke="#4A6145" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.1178 13.0737C9.19076 13.0737 8.16926 13.4487 7.23701 13.9325C5.73851 14.7102 4.98926 15.0995 4.62026 14.8512C4.25126 14.6037 4.32101 13.835 4.46126 12.2982L4.49276 11.9487" stroke="#4A6145" stroke-width="1.5" stroke-linecap="round"/>
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
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M14.5293 13.0186C14.153 12.1274 13.6069 11.3178 12.9216 10.635C12.2383 9.95026 11.4288 9.40431 10.5379 9.02731C10.53 9.02332 10.522 9.02133 10.514 9.01734C11.7567 8.11974 12.5645 6.65764 12.5645 5.00805C12.5645 2.27536 10.3504 0.0612793 7.61774 0.0612793C4.88504 0.0612793 2.67096 2.27536 2.67096 5.00805C2.67096 6.65764 3.4788 8.11973 4.72148 9.01933C4.7135 9.02332 4.70552 9.02531 4.69754 9.0293C3.80393 9.4063 3.00208 9.94685 2.31392 10.637C1.62917 11.3203 1.08321 12.1298 0.706214 13.0206C0.335848 13.8928 0.136102 14.8279 0.117787 15.7753C0.117254 15.7966 0.120988 15.8177 0.128769 15.8376C0.13655 15.8574 0.148219 15.8755 0.16309 15.8907C0.177961 15.9059 0.195733 15.918 0.215358 15.9263C0.234983 15.9346 0.256065 15.9388 0.27736 15.9388H1.47416C1.56193 15.9388 1.63174 15.869 1.63373 15.7832C1.67363 14.2434 2.29197 12.8012 3.38505 11.7081C4.51603 10.5772 6.01801 9.95483 7.61774 9.95483C9.21746 9.95483 10.7194 10.5772 11.8504 11.7081C12.9435 12.8012 13.5618 14.2434 13.6017 15.7832C13.6037 15.871 13.6735 15.9388 13.7613 15.9388H14.9581C14.9794 15.9388 15.0005 15.9346 15.0201 15.9263C15.0397 15.918 15.0575 15.9059 15.0724 15.8907C15.0873 15.8755 15.0989 15.8574 15.1067 15.8376C15.1145 15.8177 15.1182 15.7966 15.1177 15.7753C15.0977 14.8218 14.9003 13.8943 14.5293 13.0186ZM7.61774 8.43888C6.70218 8.43888 5.84049 8.08184 5.19222 7.43357C4.54395 6.7853 4.18691 5.92361 4.18691 5.00805C4.18691 4.0925 4.54395 3.23081 5.19222 2.58254C5.84049 1.93427 6.70218 1.57723 7.61774 1.57723C8.53329 1.57723 9.39499 1.93427 10.0433 2.58254C10.6915 3.23081 11.0486 4.0925 11.0486 5.00805C11.0486 5.92361 10.6915 6.7853 10.0433 7.43357C9.39499 8.08184 8.53329 8.43888 7.61774 8.43888Z" fill="#4A6145"/>
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

