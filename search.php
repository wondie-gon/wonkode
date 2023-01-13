<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WonKode
 * @since 1.0
 */
get_header();
?>
<div class="container-xxl bg-light mb-5">
    <div class="container">
        <div class="row g-5 align-center page-header">
            <div class="col-12 py-5 animated fadeIn text-center">
                <h1 class="page-title py-5">
                <?php
                    printf(
                        /* translators: %s: Search term. */
                        esc_html__( 'Results for "%s"', 'wonkode' ),
                        '<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
                    );
                ?>
                </h1>
            </div>
        </div><!-- .page-header -->
    <?php if ( have_posts() ) { ?>
        <div class="row">
            <div class="col-12 search-result-count">
            <?php
                printf(
                    esc_html(
                        /* translators: %d: The number of search results. */
                        _n(
                            'We found %d result for your search.',
                            'We found %d results for your search.',
                            (int) $wp_query->found_posts,
                            'wonkode'
                        )
                    ),
                    (int) $wp_query->found_posts
                );
            ?>
            </div>
            <div class="col-12">
            <?php
                    // content loop
                    while ( have_posts() ) {
                        the_post();
                        // get content template
                        get_template_part( 'template-parts/content/content', 'excerpt' );
                    }
            ?>
            </div>
        </div>
    <?php } else {
            get_template_part( 'template-parts/content/content-none' );
        } 
    ?>
    </div>
</div>
<?php
get_footer();