<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package WonKode
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<?php if ( ! is_singular() ) { ?>
<article id="<?php the_ID(); ?>" <?php post_class( 'card mb-4 post-content' ) ?>>
    <div class="row">
        <?php if ( ! has_post_thumbnail() || is_search() ) { ?>
            <div class="col-12 p-4">
                <?php 
                    // get category list
                    echo get_the_term_list( $post->ID, 'category', '<span class="badge text-bg-primary">', '</span><span class="badge text-bg-primary">', '</span>' );
                ?>
                <div class="entry-title">
                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <div class="entry-content">
                    <?php if ( is_search() ) { ?>
                        <a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>
                    <?php } else {
                        the_excerpt();
                    }
                    ?>
                </div>
                <div class="entry-meta">
                    <?php 
                        wonkode_posted_on_by_meta();
                    ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-md-5 col-lg-4 entry-image py-4">
                <a href="<?php the_permalink(); ?>">
                    <?php 
                        echo get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'img-fluid d-block', 'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ) ) );
                    ?>
                </a>
            </div>
            <div class="col-md-7 col-lg-8 py-4">
                <?php 
                    // get category list
                    echo get_the_term_list( $post->ID, 'category', '<span class="badge text-bg-primary">', '</span><span class="badge text-bg-primary">', '</span>' );
                ?>
                <div class="entry-title">
                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <div class="entry-content pe-4">
                    <p>
                        <a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>
                    </p>
                </div>
                <div class="entry-meta">
                    <?php 
                        wonkode_posted_on_by_meta();
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</article><!-- #<?php the_ID(); ?>.card -->
<?php } else { ?> 
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card mb-4 single-content' ) ?>>
    <div class="row">
        <div class="col-12 p-3">
            <?php 
                if ( has_post_thumbnail() ) {
                    echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid', 'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ) ) );
                }
            ?>
            <div class="entry-title mt-3">
                <h1><?php the_title(); ?></h1>
            </div>
            <?php if ( is_single() ) { ?>
            <div class="entry-meta">
                <?php 
                    wonkode_posted_on_by_meta();
                ?>
            </div>
            <?php } ?>
            <div class="entry-content">
                <p><?php the_content(); ?></p>
            </div>
        </div>
        <div class="col-12 p-3">
        <?php
            if ( is_single() ) {
                // get category list
                echo get_the_term_list( $post->ID, 'category', '<span class="badge text-bg-primary">', '</span><span class="badge text-bg-primary">', '</span>' );

                // get tags list
                echo get_the_term_list( $post->ID, 'post_tag', '<span class="badge text-bg-secondary">', '</span><span class="badge text-bg-secondary">', '</span>' );
            }
        ?>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?>.card -->
<?php } ?>