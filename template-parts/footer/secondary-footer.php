<?php
/**
 * Secondary footer area template
 *
 * @package WonKode
 * @since 1.0
 */
?>
<div class="container copyright">
    <div class="row">
    <?php
        if ( is_active_sidebar( 'wonkode-secondary-footer' ) ) {
            dynamic_sidebar( 'wonkode-secondary-footer' );
        } else {
    ?>
        <div class="col-md-6 text-center text-md-start mb-3">
            <?php echo wonkode_get_copyright_info(); ?>
        </div>
        <div class="col-md-6 text-center text-md-end mb-3">
            <?php echo wonkode_get_about_theme(); ?>
        </div>
    <?php } ?>
    </div>
</div>