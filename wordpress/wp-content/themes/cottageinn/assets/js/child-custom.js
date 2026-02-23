jQuery(document).ready(function ($) {
    
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
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 2
                },
                1199:{
                    items: 3
                }
            }
        });
    }
});