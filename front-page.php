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
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// header
get_header();
// open front page outer container
WonKode_Site_Content_Area::open_section_outer_container( 'bg-pure-light' );
    // Hero widget section
    if ( is_active_sidebar( 'wonkode-fullwidth-page-container' ) ) {
        get_template_part( 'template-parts/page/front/hero' );
    }
    // woocommerce featured products
    if ( wonkode_is_woocommerce_activated() && get_theme_mod( 'wonkode_enable_woo_featured_products', WK_DEFAULTS['_enable_woo_featured_products'] ) === true ) {
        get_template_part( 'template-parts/page/front/woocommerce-featured-products' );
    }

    // selected posts section
    if ( get_theme_mod( 'wonkode_front_selected_posts_enabled', WK_DEFAULTS['_front_selected_posts_enabled'] ) === true ) {
        get_template_part( 'template-parts/page/front/selected-posts' );
    }
    // open front page inner container
    WonKode_Site_Content_Area::open_section_inner_container();
    if ( is_front_page() && is_home() ) { 
        ?>
        <div class="row py-5 posts-list-wrapper">
        <?php
        if ( have_posts() ) {
            // section divider title
            $pg_section_title = __( 'Latest Posts', WK_TXTDOM );
            /**
             * Action hook to display page section title
             * 
             * @since 1.0
             * @param string $pg_section_title  Title of page section
             */
            do_action( "wonkode_page_section_title", $pg_section_title );

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
    // closing front page inner container
    WonKode_Site_Content_Area::close_section_inner_container();
// closing front page outer container
WonKode_Site_Content_Area::close_section_outer_container();

/*----------------Disabled when internet is off-------------
// locations custom map
if ( is_active_widget( false, false, WK_TXTDOM . '-leaflet-map-widget', true ) && is_active_sidebar( WK_TXTDOM . '-leaflet-openstreetmap' ) ) {
    // Location map widget section
    get_template_part( 'template-parts/page/front/locations-map' );
}
-------------------------------------------------------------*/

// load footer
get_footer();