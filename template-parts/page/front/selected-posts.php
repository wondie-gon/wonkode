<?php
/**
 * Front page selected posts section template part
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// open section container
WonKode_Site_Content_Area::open_section_inner_container( 'selected-posts-section' );
    // show customized section content
    WonKode_Selected_Posts_Section_Templates::show_section_content(  
        array( 
            'row_class'     =>  'g-4'
        )
    );
// closing section container
WonKode_Site_Content_Area::close_section_inner_container();