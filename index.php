<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WonKode
 * @since 1.0
 */
// header
get_header();
// open section outer container
WonKode_Site_Content_Area::open_section_outer_container();
    // open section inner container
    WonKode_Site_Content_Area::open_section_inner_container();
        // if home page
        if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) {
            // get page header
            get_template_part( 'template-parts/page/page-header' );
        }
        // starting loop
        if ( have_posts() ) {
        ?>
        <div class="row py-5 posts-list-wrapper bg-pure-light">
        <?php 
            // open post content column
            WonKode_Site_Content_Area::open_main_post_col( 'posts-list-col' );
                while ( have_posts() ) {
                    the_post();
                    // get template part
                    get_template_part( 'template-parts/content/content', get_post_format() );
                }
            // close post content column
            WonKode_Site_Content_Area::close_div_tag();
            // sidebar
            get_sidebar();
        ?>
        </div><!-- .posts-list-wrapper -->
        <?php 
        } else {
            get_template_part( 'template-parts/content/content-none' );
        }
    // closing section inner container
    WonKode_Site_Content_Area::close_section_inner_container();
// closing section outer container
WonKode_Site_Content_Area::close_section_outer_container();
get_footer();