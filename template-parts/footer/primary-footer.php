<?php
/**
 * Primary footer area template
 *
 * @package WonKode
 * @since 1.0
 */
if ( is_active_sidebar( 'wonkode-primary-footer' ) ) {
?>
<div class="container py-5">
    <div class="row g-5">
        <?php dynamic_sidebar( 'wonkode-primary-footer' ); ?>
    </div>
</div>
<?php
}