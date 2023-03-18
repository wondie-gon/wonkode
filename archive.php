<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WonKode
 * @since 1.0
 */
// header
get_header();
// open archive outer container
WonKode_Site_Content_Area::open_section_outer_container();
    // open archive inner container
    WonKode_Site_Content_Area::open_section_inner_container();
        // get archive header
        get_template_part( 'template-parts/post/archive-header' );
        // check post loop
        if ( have_posts() ) {
            // open wrapping row
            WonKode_Site_Content_Area::open_content_wrapper_row( 'archive-posts-wrapper bg-pure-light py-5' );
                // open post content column
                WonKode_Site_Content_Area::open_main_post_col( 'posts-list-col' );
                    while ( have_posts() ) {
                        the_post();
                        // get template part
                        get_template_part( 'template-parts/content/content', 'archive' );
                    }
                // close post content column
                WonKode_Site_Content_Area::close_main_post_col();
                // render sidebar
                get_sidebar();
            // close wrapping row
            WonKode_Site_Content_Area::close_content_wrapper_row();
        
        } else {
            get_template_part( 'template-parts/content/content-none' );
        }
    // closing archive inner container
    WonKode_Site_Content_Area::close_section_inner_container();
// closing archive outer container
WonKode_Site_Content_Area::close_section_outer_container();
get_footer();