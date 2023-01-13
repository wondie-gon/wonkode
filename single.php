<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WonKode
 * @since 1.0
 */
// header
get_header();
?>
<div class="container-xxl mb-5">
    <div class="container-fluid">
        <?php
            // get single post header
            get_template_part( 'template-parts/post/single-header' );
        ?>
        <div class="row py-5 single-post-wrapper">
            <!-- single post column Starts -->
            <div class="col-md-8 col-lg-9 posts-list-col">
            <?php
                while ( have_posts() ) {
                    the_post();
                    // get template part
                    get_template_part( 'template-parts/content/content', 'single' );
                }
            ?>
                <div class="row">
                    <div class="col-12 py-3">
                    <?php
                        // post navigation
                        echo get_the_post_navigation( 
                            array( 
                                'prev_text' => '<i class="fa fa-arrow-left"></i> %title',
                                'next_text' => '%title <i class="fa fa-arrow-right"></i>',
                            ) 
                        );
                    ?>
                    </div>
                </div>
            </div>
            <!-- single post column Ends -->
            <?php get_sidebar(); ?>
        </div><!-- .single-post-wrapper -->
    </div>
</div>
<?php
get_footer();