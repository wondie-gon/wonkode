<?php
/**
 * The template for displaying a single page
 *
 * @package WonKode
 * @since 1.0
 */
get_header();
// open page template outer container
WonKode_Site_Content_Area::open_section_outer_container();
    // open page template inner container
    WonKode_Site_Content_Area::open_section_inner_container();
        // get page header
        get_template_part( 'template-parts/page/page-header' );
        // open wrapping row
        WonKode_Site_Content_Area::open_content_wrapper_row( 'page-posts-wrapper bg-pure-light py-5 mb-4' );
            // page content loop
            while ( have_posts() ) {
                the_post();
                // get page content template
                get_template_part( 'template-parts/content/content', 'page' );
            }
            /**
            * Displays comments area with comment form if comments are open, 
            * or there is some number of comments, and password is not required
            */
            if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
                WonKode_Comments_Feature::show_comments_block( 'col-12 p-4' );
            }
        // close wrapping row
        WonKode_Site_Content_Area::close_content_wrapper_row();
    // closing page template inner container
    WonKode_Site_Content_Area::close_section_inner_container();
// closing page template outer container
WonKode_Site_Content_Area::close_section_outer_container();
get_footer();