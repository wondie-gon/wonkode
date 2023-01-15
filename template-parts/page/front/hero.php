<?php
/**
 * Front page hero template part
 * 
 * @package WonKode
 * @since 1.0
 */
// open hero wrapper
WonKode_Site_Content_Area::open_inner_container( 'hero-wrapper bg-light py-5' );

    dynamic_sidebar( 'wonkode-fullwidth-page-container' );

// closing hero wrapper
WonKode_Site_Content_Area::close_div_tag();
