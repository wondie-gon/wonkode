<?php
/**
 * Template to render cntent for pages
 *
 * @package WonKode
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<article id="page-<?php the_ID(); ?>" <?php post_class( 'row py-5 page-content' ); ?>>
    <div class="col-12 entry-content">
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
    </div><!-- .entry-content -->
    <?php if ( get_edit_post_link() ) { ?>
    <footer class="col-12 entry-footer">
        <?php
            // displays edit post link for page
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
    </footer><!-- .entry-footer -->
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
</article><!-- #page-<?php the_ID(); ?> -->