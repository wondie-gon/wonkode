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
        // page content loop
        while ( have_posts() ) {
            the_post();
            // get page content template
            get_template_part( 'template-parts/content/content', 'page' );
        }
    // closing inner container
    WonKode_Site_Content_Area::close_div_tag();
// closing outer container
WonKode_Site_Content_Area::close_div_tag();
get_footer();