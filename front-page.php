<?php
/**
 * The template for displaying static front page
 * 
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
    if ( is_active_sidebar( 'wonkode-wide-page-container' ) ) {
        // Hero widget section
        get_template_part( 'template-parts/page/front/hero' );
    }
    // open inner container
    WonKode_Site_Content_Area::open_inner_container();
    if ( is_front_page() && is_home() ) { 
        ?>
        <div class="row py-5 posts-list-wrapper">
        <?php
        if ( have_posts() ) {
            // open post content column
            WonKode_Site_Content_Area::open_main_post_col( 'posts-list-col' );
            while ( have_posts() ) {
                the_post();
                // get template part
                get_template_part( 'template-parts/content/content', get_post_format() );
            }
            // close post content column
            WonKode_Site_Content_Area::close_div_tag();
            // get sidebar
            get_sidebar();
        }
        ?>
        </div><!-- .posts-list-wrapper -->
        <?php
    } elseif ( is_front_page() && ! is_home() ) {
        // page content loop
        while ( have_posts() ) {
            the_post();
            // get page content template
            get_template_part( 'template-parts/content/content', 'page' );
        }
    }
    // closing inner container
    WonKode_Site_Content_Area::close_div_tag();
// closing outer container
WonKode_Site_Content_Area::close_div_tag();
get_footer();