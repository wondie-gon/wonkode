<?php
/**
 * footer template file of the theme
 *
 * @package WonKode
 * @since 1.0
 */
        // open site content area
        WonKode_Site_Content_Area::close_wrappers();
        // open footer section outer container
        WonKode_Site_Content_Area::open_section_outer_container( 'footer bg-primary-lightest mt-5 pt-5' );
        ?>
            <!-- primary footer -->
            <?php get_template_part( 'template-parts/footer/primary-footer' ); ?>
            <!-- secondary footer -->
            <?php get_template_part( 'template-parts/footer/secondary-footer' ); ?>
        <?php 
        // closing footer section outer container
        WonKode_Site_Content_Area::close_section_outer_container();
        ?>
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