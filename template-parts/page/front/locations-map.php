<?php
/**
 * Front page custom location map template part
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// open custom location map section wrapper
WonKode_Site_Content_Area::open_section_inner_container( 'locations-map-section' );
    // row
    WonKode_Site_Content_Area::open_content_wrapper_row();
        // display widget
        dynamic_sidebar( WK_TXTDOM . '-leaflet-openstreetmap' );
    // close row
    WonKode_Site_Content_Area::close_content_wrapper_row();

// closing custom location map section wrapper
WonKode_Site_Content_Area::close_section_inner_container();