<?php
/**
 * Customizer functions
 * 
 * @package WonKode
 * @since 1.0
 */
// constants for customizer feature
// customizer path
if ( ! defined( 'WK_CUSTOMIZER_PATH' ) ) {
    define( 'WK_CUSTOMIZER_PATH', get_template_directory() . '/inc/customizer' );
}
// customizer url
if ( ! defined( 'WK_CUSTOMIZER_URL' ) ) {
    define( 'WK_CUSTOMIZER_URL', get_template_directory_uri() . '/inc/customizer' );
}
// custom controls path
if ( ! defined( 'WK_CUSTOM_CONTROLS_PATH' ) ) {
    define( 'WK_CUSTOM_CONTROLS_PATH', WK_CUSTOMIZER_PATH . '/controls' );
}
// custom controls url
if ( ! defined( 'WK_CUSTOM_CONTROLS_URL' ) ) {
    define( 'WK_CUSTOM_CONTROLS_URL', WK_CUSTOMIZER_URL . '/controls' );
}

// theme customize defaults
if ( ! defined( 'WK_DEFAULTS' ) ) {
    define( 'WK_DEFAULTS', array(
        '_outer_container_bs_class'             =>  'container-xxl',
        '_inner_container_bs_class'             =>  'container-fluid',
        '_sidebar_position'                     =>  'right',
        '_single_sidebar_col_size_lg'           =>  '3',
        '_single_sidebar_col_size_md'           =>  '4',
        '_double_sidebar_left_col_size_lg'      =>  '2',
        '_double_sidebar_left_col_size_md'      =>  '3',
        '_double_sidebar_right_col_size_lg'     =>  '2',
        '_double_sidebar_right_col_size_md'     =>  '3',
        '_outer_container_margin_top'           =>  '',
        '_outer_container_margin_bottom'        =>  'mb-5',

        // categorized latest posts section defaults
        '_front_categorized_latest_posts_section_title'    =>  esc_html__( 'Latest Posts', WK_TXTDOM ),

        // selected posts section defaults
        '_front_selected_posts_enabled'         => false,
        '_front_selected_posts_section_title'     =>  esc_html__( 'Popular Posts', WK_TXTDOM ),
        '_num_of_front_selected_posts'              =>  6,
        '_front_selected_posts_cols_sm'              =>  1,
        '_front_selected_posts_cols_md'              =>  3,
        '_front_selected_posts_cols_lg'              =>  4,
        '_front_selected_post_default'       =>  '',

        // woocommerce customize defaults
        '_enable_woo_featured_products'         =>  false,
        '_woo_featured_products_block_title'    =>  esc_html__( 'Featured Products', WK_TXTDOM ),
        '_woo_featured_products_block_text_one' =>  '',
        '_woo_featured_products_block_text_two' =>  '',
        '_woo_featured_products_block_link'     =>  '#',
        '_woo_featured_products_block_link_text'    =>  esc_html__( 'Go To Shop', WK_TXTDOM ),
        '_woo_featured_products_link_btn_text'      =>  esc_html__( 'View Now', WK_TXTDOM ),
    ) );
}

// include customize initializer
require_once WK_CUSTOMIZER_PATH . '/class.wonkode-customize-init.php';