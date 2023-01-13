<?php
/**
 * Achive post content rendering template
 * 
 * @since 1.0
 * @package WonKode
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<article id="<?php the_ID(); ?>" <?php post_class( 'card mb-4 post-content' ) ?>>
<div class="row">
    <?php if ( ! has_post_thumbnail() ) { ?>
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