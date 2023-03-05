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
    ?>
    <div class="container py-5">
        <?php 
            // display half columned widgets if active
            if ( is_active_sidebar( 'wonkode-footer-half-columned' ) ) {
        ?>
            <div class="row g-5">
                <?php dynamic_sidebar( 'wonkode-footer-half-columned' ); ?>
            </div>
        <?php } ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
            <?php
                // display auto resizing column widgets if active
                if ( is_active_sidebar( 'wonkode-footer-auto-col-widgets' ) ) {
                    dynamic_sidebar( 'wonkode-footer-auto-col-widgets' );
                }
            ?>
            <?php if ( get_theme_mod( 'enable_wonkode_social_media_link_nav' ) ) { ?>
                <div class="col">
                    <?php wonkode_show_social_media_links_nav(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}