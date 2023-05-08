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
    if ( is_front_page() && is_home() ) { 
        // Hero widget section
        if ( is_active_sidebar( 'wonkode-fullwidth-page-container' ) ) {
            get_template_part( 'template-parts/page/front/hero' );
        }
        // woocommerce featured products
        if ( wonkode_is_woocommerce_activated() && get_theme_mod( 'wonkode_enable_woo_featured_products', WK_DEFAULTS['_enable_woo_featured_products'] ) === true ) {
            get_template_part( 'template-parts/page/front/woocommerce-featured-products' );
        }

        // custom BS carousel section
        if ( get_theme_mod( 'wonkode_enable_bs_carousel', WK_DEFAULTS['_enable_bs_carousel'] ) === true ) {
            get_template_part( 'template-parts/page/front/custom-bs-carousel' );
        }

        // selected category section
        if ( get_theme_mod( 'wonkode_front_categorized_latest_posts_enabled', WK_DEFAULTS['_front_categorized_latest_posts_enabled'] ) === true ) {
            get_template_part( 'template-parts/page/front/latest-category-posts' );
        }

        // selected posts section
        if ( get_theme_mod( 'wonkode_front_selected_posts_enabled', WK_DEFAULTS['_front_selected_posts_enabled'] ) === true ) {
            get_template_part( 'template-parts/page/front/selected-posts' );
        }

        /*----------------Disabled when internet is off-------------
        // locations custom map
        if ( is_active_widget( false, false, 'wonkode-leaflet-map-widget', true ) && is_active_sidebar( 'wonkode-leaflet-openstreetmap' ) ) {
            // Location map widget section
            get_template_part( 'template-parts/page/front/locations-map' );
        }
        -------------------------------------------------------------*/
        
    } elseif ( is_front_page() && ! is_home() ) {
        // open front page inner container
        WonKode_Site_Content_Area::open_section_inner_container();
            // page content loop
            while ( have_posts() ) {
                the_post();
                // get page content template
                get_template_part( 'template-parts/content/content', 'page' );
            }
        // closing front page inner container
        WonKode_Site_Content_Area::close_section_inner_container();
    }
// closing front page outer container
WonKode_Site_Content_Area::close_section_outer_container();
// load footer
get_footer();