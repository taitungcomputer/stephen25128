jQuery(document).ready(function ($) {

    $('.toggle-btn').on('click', function (e) {
        e.stopPropagation();
        $(this).toggleClass('open');
        $('.menu-container-wrapper').toggleClass('open');
        $('body').toggleClass('site-toggled');
    });
    
    document.addEventListener("click", function(event) {
        // If user clicks inside the element, do nothing
        if (event.target.closest(".menu-container-wrapper")) return;
        // If user clicks outside the element, hide it!
        $('body').removeClass('site-toggled');
        $('.menu-container-wrapper').removeClass('open');
    });

    //mobile-menu
    $('<button class="angle-down"> </button>').insertAfter( $(".mobile-header .main-navigation ul .menu-item-has-children > a"));
    $('.main-navigation ul li .angle-down').on('click', function () {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });

    //accessibility
    $('.menu li a, .menu li').on('focus', function() {
        $(this).parents('li').addClass('focus');
    }).blur(function() {
        $(this).parents('li').removeClass('focus');
    });

    $("#menu-opener").on('click', function () {
        $("body").addClass("menu-open");
        $(".mobile-menu-wrapper .primary-menu-list").addClass("toggled");
    });
    
    $(".mobile-menu-wrapper .close-main-nav-toggle ").on('click', function () {
    $("body").removeClass("menu-open");
    $(".mobile-menu-wrapper .primary-menu-list").removeClass("toggled");
    }); 
    //Sticky header
    var siteHeader = document.querySelector('.site-header');
    var headerHeight = siteHeader.offsetHeight;
    var adminBar = document.querySelector('#wpadminbar');
    var articleMeta = document.querySelector('.article-meta');

    if (adminBar !== null) {
        var adminHeight = adminBar.offsetHeight;
    }

    function stick() {

        var scrollValue = window.scrollY;
        if (document.body.classList.contains('sticky-header')) {

            if (scrollValue > headerHeight) {
                siteHeader.classList.add('stick-header');
                if (siteHeader !== null) {
                    siteHeader.style.marginTop = adminHeight + 'px';
                }

                if(articleMeta !==null) {
                    var siteHeaderrr = document.querySelector('.site-header').offsetHeight;
                    articleMeta.style.top = siteHeaderrr + 38 + 'px';
                }
            
            }

            else if (scrollValue < headerHeight) {
                siteHeader.classList.remove('stick-header');
                if (siteHeader !== null) {
                    siteHeader.style.marginTop = 0;
                }

            }
        }

    }
    window.addEventListener("scroll", stick);

    if ( hotell_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }

    //news-and-blogs Slider
    if ($('.news-and-blogs__slider').length > 0) {
        $('.news-and-blogs__slider').owlCarousel({
            loop: true,
            nav: true,
            margin: 30,
            dots: false,
            rtl: rtl,
            thumbContainerClass: 'owl-thumbs',
            navText: ['<svg width = "19" height = "12" viewBox = "0 0 19 12" fill = "none" xmlns = "http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.783 6C18.783 5.82321 18.7127 5.65367 18.5877 5.52866C18.4627 5.40366 18.2932 5.33343 18.1164 5.33343H2.39461L6.59002 1.13935C6.652 1.07737 6.70116 1.0038 6.7347 0.922824C6.76824 0.84185 6.7855 0.755061 6.7855 0.667415C6.7855 0.579769 6.76824 0.492981 6.7347 0.412006C6.70116 0.331032 6.652 0.257456 6.59002 0.195481C6.52805 0.133506 6.45447 0.0843448 6.3735 0.050804C6.29252 0.0172633 6.20573 0 6.11809 0C6.03044 0 5.94365 0.0172633 5.86268 0.050804C5.7817 0.0843448 5.70813 0.133506 5.64615 0.195481L0.313568 5.52807C0.251492 5.58998 0.202242 5.66354 0.168638 5.74452C0.135034 5.82551 0.117737 5.91232 0.117737 6C0.117737 6.08768 0.135034 6.17449 0.168638 6.25548C0.202242 6.33646 0.251492 6.41002 0.313568 6.47193L5.64615 11.8045C5.70813 11.8665 5.7817 11.9157 5.86268 11.9492C5.94365 11.9827 6.03044 12 6.11809 12C6.20573 12 6.29252 11.9827 6.3735 11.9492C6.45447 11.9157 6.52805 11.8665 6.59002 11.8045C6.652 11.7425 6.70116 11.669 6.7347 11.588C6.76824 11.507 6.7855 11.4202 6.7855 11.3326C6.7855 11.2449 6.76824 11.1582 6.7347 11.0772C6.70116 10.9962 6.652 10.9226 6.59002 10.8607L2.39461 6.66657H18.1164C18.2932 6.66657 18.4627 6.59635 18.5877 6.47134C18.7127 6.34633 18.783 6.17679 18.783 6Z" fill="#AF9065" /></svg >','<svg width = "19" height = "12" viewBox = "0 0 19 12" fill = "none" xmlns = "http://www.w3.org/2000/svg" ><path fill-rule="evenodd" clip-rule="evenodd" d="M0.11772 6C0.11772 5.82321 0.187946 5.65367 0.312954 5.52866C0.43796 5.40366 0.607506 5.33343 0.784292 5.33343H16.5061L12.3107 1.13935C12.2487 1.07737 12.1995 1.0038 12.166 0.922824C12.1325 0.84185 12.1152 0.755061 12.1152 0.667415C12.1152 0.579769 12.1325 0.492981 12.166 0.412006C12.1995 0.331032 12.2487 0.257456 12.3107 0.195481C12.3727 0.133506 12.4462 0.0843448 12.5272 0.050804C12.6082 0.0172633 12.695 0 12.7826 0C12.8703 0 12.957 0.0172633 13.038 0.050804C13.119 0.0843448 13.1926 0.133506 13.2545 0.195481L18.5871 5.52807C18.6492 5.58998 18.6985 5.66354 18.7321 5.74452C18.7657 5.82551 18.783 5.91232 18.783 6C18.783 6.08768 18.7657 6.17449 18.7321 6.25548C18.6985 6.33646 18.6492 6.41002 18.5871 6.47193L13.2545 11.8045C13.1926 11.8665 13.119 11.9157 13.038 11.9492C12.957 11.9827 12.8703 12 12.7826 12C12.695 12 12.6082 11.9827 12.5272 11.9492C12.4462 11.9157 12.3727 11.8665 12.3107 11.8045C12.2487 11.7425 12.1995 11.669 12.166 11.588C12.1325 11.507 12.1152 11.4202 12.1152 11.3326C12.1152 11.2449 12.1325 11.1582 12.166 11.0772C12.1995 10.9962 12.2487 10.9226 12.3107 10.8607L16.5061 6.66657H0.784292C0.607506 6.66657 0.43796 6.59635 0.312954 6.47134C0.187946 6.34633 0.11772 6.17679 0.11772 6Z" fill="#AF9065" /></svg>'],
            responsive: {
                0: {
                    items: 1
                },
                1024: {
                    items: 2
                },
            }
        });
    }

    //open comment section when write comment button is clicked
    $(".comment-open").on('click', function () {
        $(".comment-respond").addClass("open");
    });
    $(".comment .reply").on('click', function () {
        $(".comment-respond").addClass("open");
    });
    //scroll to top
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 300) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    $("#back-to-top").on('click', function () {
        $('html,body').animate({
            scrollTop: 0
        }, 100);
    });

    if ($('.foot-top .foot-top__right a').length > 0) {
        $('.foot-top .foot-top__right').owlCarousel({
            loop: true,
            nav: false,
            items: 3,
            margin: 50,
            dots: false,
            rtl: rtl
        });
    }
    
});