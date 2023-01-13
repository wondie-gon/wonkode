<?php
/**
 * Post rendering single content
 *
 * @package WonKode
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card mb-4 single-content' ) ?>>
    <div class="row">
        <div class="col-12">
            <div class="entry-meta">
            <?php 
                wonkode_posted_on_by_meta();
            ?>
            </div>
        </div>
        <div class="col-12">
            <?php 
                if ( has_post_thumbnail() ) {
                    echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid', 'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ) ) );
                }
            ?>
            <div class="entry-content p-3">
            <?php 
                the_content();

                // Displays page links for paginated posts
                wp_link_pages( 
                    array(
                        'before'    =>  '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'wonkode' ) . '">',
                        'after'     =>  '</nav>',
                        // Translators: %s : page number
                        'pagelink'  =>  esc_html__( 'Page %s', 'wonkode' )
                    ) 
                );
            ?>
            </div>
        </div>
        <div class="col-12 p-3">
            <?php 
                // get category list
                echo get_the_term_list( $post->ID, 'category', '<span class="badge text-bg-primary">', '</span><span class="badge text-bg-primary">', '</span>' );

                // get tags list
                echo get_the_term_list( $post->ID, 'post_tag', '<span class="badge text-bg-secondary">', '</span><span class="badge text-bg-secondary">', '</span>' );
            ?>
        </div>
        <?php if ( get_edit_post_link() ) { ?>
        <div class="co-12 py-3">
            <?php
                // displays edit post link for post
                edit_post_link( 
                    sprintf( 
                        /**
                         * Translators: %s: post title, visible only for screen readers
                         */
                        esc_html__( 'Edit %s', 'wonkode' ), 
                        '<span class="screen-reader-text">' . get_the_title() . '</span>' 
                    ), 
                    '<span class="edit-link">', 
                    '</span>' 
                );
            ?>
        </div>
        <?php } ?>
        <?php if ( get_theme_mod( 'enable_wonkode_social_media_sharing' ) ) { ?>
        <div class="co-12 py-3">
            <?php WonKode_Social_Media_Share_Menu::show_nav(); ?>
        </div>
        <?php } ?>
        <?php
        /**
         * Displays comments area with comment form if comments are open, 
         * or there is some number of comments, and password is not required
         */
        if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) { ?>
        <div class="col-12 p-4 comments-wrapper">
            <?php comments_template(); ?>
        </div>
        <?php } ?>
    </div>
</article><!-- #post-<?php the_ID(); ?>.card -->