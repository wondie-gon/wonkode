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
// open outer container
WonKode_Site_Content_Area::open_outer_container( 'bg-light' );
    // open inner container
    WonKode_Site_Content_Area::open_inner_container();
        // get single post header
        get_template_part( 'template-parts/post/single-header' );
        // open wrapping row
        WonKode_Site_Content_Area::open_content_wrapper_row( 'single-post-wrapper py-5' );
            // open post content column
            WonKode_Site_Content_Area::open_main_post_col( 'post-col' );

                while ( have_posts() ) {
                    the_post();
                    // get template part
                    get_template_part( 'template-parts/content/content', 'single' );
                }
            ?>
                <div class="row">
                    <div class="col-12 py-3">
                    <?php
                        // wonkode_show_post_navigation();
                        the_post_navigation();
                    ?>
                    </div>
                    <?php 
                        /**
                        * Displays comments area with comment form if comments are open, 
                        * or there is some number of comments, and password is not required
                        */
                        if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
                            WonKode_Comments_Feature::show_comments_block( 'col-12 p-4' );
                        }
                    ?>
                </div>
            <?php            
            // close post content column
            WonKode_Site_Content_Area::close_main_post_col();
            // render sidebar
            get_sidebar();
        // close wrapping row
        WonKode_Site_Content_Area::close_content_wrapper_row();
    // closing inner container
    WonKode_Site_Content_Area::close_inner_container();
// closing outer container
WonKode_Site_Content_Area::close_outer_container();
get_footer();