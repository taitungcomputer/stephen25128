( function( api ) {

    // Extends our custom "example-1" section.
    api.sectionConstructor['pro-section'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

} )( wp.customize );
jQuery(document).ready(function($) {

    wp.customize.panel( 'frontpage_settings', function( section ){
        section.expanded.bind( function( isExpanded ) {
            if( isExpanded ){
                wp.customize.previewer.previewUrl.set( hotell_cdata.home );
            }
        });
    });

    wp.customize.panel( 'contact_page_setting', function( section ){
        section.expanded.bind( function( isExpanded ) {
            if( isExpanded ){
                wp.customize.previewer.previewUrl.set( hotell_cdata.contact );
            }else{
                wp.customize.previewer.previewUrl.set( hotell_cdata.home );
            }
        });
    });

    //Scroll to front page section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    }); 

    function scrollToSection( section_id ){

        var preview_section_id = "banner_section";
    
        var $contents = jQuery('#customize-preview iframe').contents();
    
        switch ( section_id ) {
    
            case 'accordion-section-about_section':
            preview_section_id = "about-section";
            break;
    
            case 'accordion-section-cta_section':
            preview_section_id = "cta-section";
            break;
    
            case 'accordion-section-video_block_section':
            preview_section_id = "video-block-section";
            break;
    
            case 'accordion-section-gallery_section':
            preview_section_id = "gallery-section";
            break;

            case 'accordion-section-blog_sec_home':
            preview_section_id = "blog-section";
            break;

            case 'accordion-section-footer_top_section':
            preview_section_id = "footer-top-section";
            break;
    
        }
    
        if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
            $contents.find("html, body").animate({
            scrollTop: $contents.find( "#" + preview_section_id ).offset().top
            }, 1000);
        }
    }

});