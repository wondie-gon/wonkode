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
// open outer container
WonKode_Site_Content_Area::open_outer_container( 'bg-light' );
    // open inner container
    WonKode_Site_Content_Area::open_inner_container();
        // get archive header
        get_template_part( 'template-parts/post/archive-header' );
        // check post loop
        if ( have_posts() ) {
    ?>
        <div class="row py-5 archive-posts-wrapper">
            <!-- posts list column Starts here -->
            <?php
            // open post content column
            WonKode_Site_Content_Area::open_main_post_col( 'posts-list-col' );
                while ( have_posts() ) {
                    the_post();
                    // get template part
                    get_template_part( 'template-parts/content/content', 'archive' );
                }
            // close post content column
            WonKode_Site_Content_Area::close_div_tag();
            ?>
            <!-- posts list column Ends here -->
            <?php get_sidebar(); ?>
        </div><!-- .archive-posts-wrapper -->
    <?php 
        } else {
            get_template_part( 'template-parts/content/content-none' );
        }
    // closing inner container
    WonKode_Site_Content_Area::close_div_tag();
// closing outer container
WonKode_Site_Content_Area::close_div_tag();
get_footer();