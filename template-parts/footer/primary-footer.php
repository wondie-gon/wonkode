<?php
/**
 * Primary footer area template. 
 * Displays top two half columned and four columned widgets 
 * in footer area.
 *
 * @package WonKode
 * @since 1.0
 */

if ( is_active_sidebar( 'wonkode-footer-half-columned' ) || is_active_sidebar( 'wonkode-footer-auto-col-widgets' ) ) {
    // open primary footer section
    WonKode_Site_Content_Area::open_section_inner_container( 'py-3' );
    // display half columned widgets if active
    if ( is_active_sidebar( 'wonkode-footer-half-columned' ) ) {
    ?>
        <div class="row g-5 mb-3">
            <?php dynamic_sidebar( 'wonkode-footer-half-columned' ); ?>
        </div>
    <?php } ?>
    <div class="row g-5">
    <?php
        // display auto resizing column widgets if active
        if ( is_active_sidebar( 'wonkode-footer-auto-col-widgets' ) ) {
            dynamic_sidebar( 'wonkode-footer-auto-col-widgets' );
        }
    ?>
    <?php if ( get_theme_mod( 'enable_wonkode_social_media_link_nav' ) ) { ?>
        <div class="col-12 col-sm-6 col-md">
            <?php wonkode_show_social_media_links_nav(); ?>
        </div>
    <?php } ?>
    </div>
    <?php
    // closing primary footer section
    WonKode_Site_Content_Area::close_section_inner_container();
}