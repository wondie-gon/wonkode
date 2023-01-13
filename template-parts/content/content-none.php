<?php
/**
 * Template part for diplaying messages when there are no posts
 * 
 * @since 1.0
 * @package WonKode
 */
?>
<div class="row page-content">
    <div class="col-12">
        <h1 class="page-title"><?php esc_html_e( 'Nothing here', 'wonkode' ); ?></h1>
    </div>
    <div class="col-12">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>
        <?php
            printf(
                '<p>' . wp_kses(
                    /* translators: %s: Link to WP admin new post page. */
                    __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'wonkode' ),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url( admin_url( 'post-new.php' ) )
            );
        ?>
        <?php } elseif ( is_search() ) { ?>
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wonkode' ); ?></p>
            <?php get_search_form(); ?>
        <?php } else { ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wonkode' ); ?></p>
            <?php get_search_form(); ?>
        <?php } ?>
    </div>
</div>