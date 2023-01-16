<?php
/**
 * The template for displaying secondary sidebar, 
 * on the left
 *
 * @package WonKode
 * @since 1.0
 */
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// open secondary sidebar
if ( WonKode_Site_Content_Area::sidebar_is_both() ) {
    WonKode_Site_Content_Area::open_secondary_sidebar( 'sidebar-secondary double-sidebar-left' );
}
?>
    <div id="wk-secondary-sidebar" class="secondary-sidebar widget-area" role="complementary">
        <?php 
            if ( is_active_sidebar( 'wonkode-secondary-sidebar' ) ) {
                dynamic_sidebar( 'wonkode-secondary-sidebar' );
            }
        ?>
    </div><!-- #wk-secondary-sidebar -->
<?php
// close secondary sidebar
WonKode_Site_Content_Area::close_secondary_sidebar();