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
    ) );
}

// include customizers
// require_once( WK_CUSTOMIZER_PATH . '/class.wonkode-customize-base.php' );
// require_once( WK_CUSTOMIZER_PATH . '/class.wonkode-customize-site-general.php' );
require_once( WK_CUSTOMIZER_PATH . '/class.wonkode-customize-init.php' );