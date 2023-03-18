<?php
/**
 * Front page hero template part
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// open hero section wrapper
WonKode_Site_Content_Area::open_section_inner_container( 'hero-wrapper' );

    dynamic_sidebar( 'wonkode-fullwidth-page-container' );

// closing hero section wrapper
WonKode_Site_Content_Area::close_section_inner_container();
