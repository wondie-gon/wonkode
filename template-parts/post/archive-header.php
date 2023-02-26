<?php
/**
 * Header template part for archive pages
 * 
 * @since 1.0
 * @package WonKode
 */
?>
<div class="row g-5 align-center">
    <div class="col-12 py-5 animated fadeIn archive-header"<?php wonkode_page_header_bg_img_style(); ?>>
        <h1 class="archive-title py-5">
            <?php echo get_the_archive_title(); ?>
        </h1>
    </div><!-- .archive-header -->
</div>