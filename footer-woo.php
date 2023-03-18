<?php
/**
 * Theme's footer template file for woocommerce 
 * pages.
 *
 * @package WonKode
 * @since 1.0
 */
?>
        <!-- Footer Start -->
        <div class="container-xxl bg-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <!-- primary footer -->
            <?php get_template_part( 'template-parts/footer/primary-footer' ); ?>
            <!-- secondary footer -->
            <?php get_template_part( 'template-parts/footer/secondary-footer' ); ?>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn rounded-circle back-to-top">
            <?php
                // use arrow_big_up svg icon
                echo wonkode_get_svg_icon_use( 'arrow_big_up' );
            ?>
        </a>

    </div>
    <?php wp_footer(); ?>
</body>
</html>