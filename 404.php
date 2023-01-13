<?php
/**
 * The template for displaying 404 pages (not found)
 * 
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WonKode
 * @since 1.0
 */
get_header();
?>
<div class="container-xxl wow fadeInUp" data-wow-delay="0.1s">
    <div class="container-fluid">
        <div class="row g-5 align-center page-header">
            <?php $a404_hdr_bg_img = 'wonkode-bg-img-light.jpg'; ?>
            <div class="col-12 animated fadeIn text-center"<?php wonkode_page_header_bg_img_style( $a404_hdr_bg_img ); ?>>
                <h1 class="page-title py-5">
                    <?php esc_html_e( 'Not Found', 'wonkode' ); ?>
                </h1>
            </div>
        </div><!-- .page-header -->
        <div class="row justify-content-center py-5 content-404-wrapper">
            <div class="col-lg-6 text-center">
                <i class="fa fa-exclamation-triangle fa-5x text-primary" aria-hidden="true"></i>
                <h1 class="display-1 mb-4"><?php __( '404 Page Not Found', 'wonkode' ); ?></h1>
                <p class="lead mb-4"><?php _e( 'We are sorry, the page you looked for does not exist in our website! Maybe try the search form to explore what we got.or go to our home page?', 'wonkode' ); ?></p>
                <p class="mb-4">
                    <?php
                        get_search_form();
                    ?>
                </p>
                <p class="lead mb-4"><?php _e( 'You may also go to our home page to start fresh.', 'wonkode' ); ?></p>
                <a class="btn btn-primary py-3 px-4" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Go Back To Home', 'wonkode' ); ?></a>
            </div>
        </div><!-- .content-404-wrapper -->
    </div>
</div>
<?php
get_footer();