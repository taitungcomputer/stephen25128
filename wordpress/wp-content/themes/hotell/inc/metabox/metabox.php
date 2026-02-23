<?php 
/**
* Hotell Metabox for Sidebar Layout
*
* @package Hotell
*
*/ 

function hotell_add_sidebar_layout_box(){
    $postID         = isset( $_GET['post'] ) ? $_GET['post'] : '';
    $shop_id        = get_option( 'woocommerce_shop_page_id' );
    $template       = get_post_meta( $postID, '_wp_page_template', true );
    $page_templates = array( 'templates/contact.php' );

    /**
     * Remove sidebar metabox in specific page template.
    */
    if( ! in_array( $template, $page_templates ) && ( $shop_id != $postID ) ){
        add_meta_box( 
            'hotell_sidebar_layout',
            __( 'Sidebar Layout', 'hotell' ),
            'hotell_sidebar_layout_callback', 
            array( 'page','post'),
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'hotell_add_sidebar_layout_box' );

if( ! function_exists( 'hotell_get_sidebar_layout_options' ) ) :
    function hotell_get_sidebar_layout_options() {
        return array(    
            'default-sidebar'=> array(
                'value'     => 'default-sidebar',
                'label'     => __( 'Default Sidebar', 'hotell' ),
                'thumbnail' => get_template_directory_uri() . '/images/sidebar/general-Default.jpg'
            ),
            'no-sidebar'     => array(
                'value'     => 'no-sidebar',
                'label'     => __( 'Full Width', 'hotell' ),
                'thumbnail' => get_template_directory_uri() . '/images/sidebar/general-full.jpg'
            ),
            'left-sidebar' => array(
                'value'     => 'left-sidebar',
                'label'     => __( 'Left Sidebar', 'hotell' ),
                'thumbnail' => get_template_directory_uri() . '/images/sidebar/general-left.jpg'         
            ),
            'right-sidebar' => array(
                'value'     => 'right-sidebar',
                'label'     => __( 'Right Sidebar', 'hotell' ),
                'thumbnail' => get_template_directory_uri() . '/images/sidebar/general-right.jpg'         
            )    
        );
    }
endif;

function hotell_sidebar_layout_callback(){
    global $post;
    $hotell_sidebar_layout = hotell_get_sidebar_layout_options();
    wp_nonce_field( basename( __FILE__ ), 'hotell_sidebar_nonce' );
    ?>     
    <table class="form-table">
        <tr>
            <td colspan="4"><em class="f13"><?php esc_html_e( 'Choose Sidebar Template', 'hotell' ); ?></em></td>
        </tr>    
        <tr>
            <td>
                <?php  
                    foreach( $hotell_sidebar_layout as $field ){  
                        $layout = get_post_meta( $post->ID, '_hotell_sidebar_layout', true ); ?>
                        <div class="hide-radio radio-image-wrapper" style="float:left; margin-right:30px;">
                            <input id="<?php echo esc_attr( $field['value'] ); ?>" type="radio" name="hotell_sidebar_layout" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( $field['value'], $layout ); if( empty( $layout ) ){ checked( $field['value'], 'default-sidebar' ); }?>/>
                            <label class="description" for="<?php echo esc_attr( $field['value'] ); ?>">
                                <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" alt="<?php echo esc_attr( $field['label'] ); ?>" />                               
                            </label>
                        </div>
                        <?php 
                    } // end foreach 
                ?>
                <div class="clear"></div>
            </td>
        </tr>
    </table>
 <?php 
}

function hotell_save_sidebar_layout( $post_id ){
    $hotell_sidebar_layout = hotell_get_sidebar_layout_options();

    // Verify the nonce before proceeding.
    if( !isset( $_POST[ 'hotell_sidebar_nonce' ] ) || !wp_verify_nonce( $_POST[ 'hotell_sidebar_nonce' ], basename( __FILE__ ) ) )
        return;
    
    // Stop WP from clearing custom fields on autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
    
    $layout = isset( $_POST['hotell_sidebar_layout'] ) ? sanitize_key( $_POST['hotell_sidebar_layout'] ) : 'default-sidebar';

    if( array_key_exists( $layout, $hotell_sidebar_layout ) ){
        update_post_meta( $post_id, '_hotell_sidebar_layout', $layout );
    }else{
        delete_post_meta( $post_id, '_hotell_sidebar_layout' );
    }
      
}
add_action( 'save_post' , 'hotell_save_sidebar_layout' );