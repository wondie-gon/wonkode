<?php
/**
 * Front page default content if no customization 
 * is done. Displays latest posts of all categories.
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// open front page inner container
WonKode_Site_Content_Area::open_section_inner_container();
?>
    <div class="row py-5 posts-list-wrapper">
    <?php
        if ( have_posts() ) {
            // section divider title
            $pg_section_title = __( 'Latest Posts', WK_TXTDOM );
            /**
             * Action hook to display page section title
             * 
             * @since 1.0
             * @param string $pg_section_title  Title of page section
             */
            do_action( "wonkode_page_section_title", $pg_section_title );

            // open post content column
            WonKode_Site_Content_Area::open_main_post_col( 'posts-list-col' );
            while ( have_posts() ) {
                the_post();
                // get template part
                get_template_part( 'template-parts/content/content', get_post_format() );
            }
            // close post content column
            WonKode_Site_Content_Area::close_div_tag();
            // get sidebar
            get_sidebar();
        }
    ?>
    </div><!-- .posts-list-wrapper -->
<?php
// closing front page inner container
WonKode_Site_Content_Area::close_section_inner_container();