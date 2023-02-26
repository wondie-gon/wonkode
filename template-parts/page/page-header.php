<?php
/**
 * Template part for page header
 * 
 * @since 1.0
 * @package WonKode
 */
?>
<div class="row g-5 align-center">
    <?php $page_hdr_bg_img = 'wonkode-bg-img-light.jpg'; ?>
    <div class="col-12 py-5 animated fadeIn page-header"<?php wonkode_page_header_bg_img_style( $page_hdr_bg_img ); ?>>
        <?php single_post_title( '<h1 class="page-title">', '</h1>' ); ?>
    </div><!-- .page-header -->
</div>