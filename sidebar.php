<?php
/**
 * The template for displaying primary sidebar
 * 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WonKode
 * @since 1.0
 */
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!-- sidebar column starts here -->
<?php 
// open primary sidebar
if ( WonKode_Site_Content_Area::sidebar_is_both() ) {
    WonKode_Site_Content_Area::open_primary_sidebar( 'sidebar-primary double-sidebar-right' );
} else {
    WonKode_Site_Content_Area::open_primary_sidebar( 'sidebar-primary single-sidebar' );
}
?>
    <div id="wk-primary-sidebar" class="primary-sidebar widget-area" role="complementary">
        <?php 
            if ( is_active_sidebar( 'wonkode-primary-sidebar' ) ) {
                dynamic_sidebar( 'wonkode-primary-sidebar' );
            }
        ?>
    </div><!-- #wk-primary-sidebar -->
    
<?php 
// close sidebar
WonKode_Site_Content_Area::close_div_tag();
?>
<!-- sidebar column ends here -->