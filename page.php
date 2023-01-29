<?php
/**
 * The template for displaying a single page
 *
 * @package WonKode
 * @since 1.0
 */
get_header();
// open outer container
WonKode_Site_Content_Area::open_outer_container( 'bg-light' );
    // open inner container
    WonKode_Site_Content_Area::open_inner_container();
        // get page header
        get_template_part( 'template-parts/page/page-header' );
        // open wrapping row
        WonKode_Site_Content_Area::open_content_wrapper_row( 'page-posts-wrapper py-5' );
            // page content loop
            while ( have_posts() ) {
                the_post();
                // get page content template
                get_template_part( 'template-parts/content/content', 'page' );
            }
        // close wrapping row
        WonKode_Site_Content_Area::close_content_wrapper_row();
    // closing inner container
    WonKode_Site_Content_Area::close_inner_container();
// closing outer container
WonKode_Site_Content_Area::close_outer_container();
get_footer();