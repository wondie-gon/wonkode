<?php
/**
 * header template file of the theme
 *
 * @package WonKode
 * @since 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- svg resources starts here -->
    <?php
        // dump svg symbols here
        wonkode_ui_icons_svg_symbols();
    ?>
    <!-- svg resources ends here -->
    <div id="page" class="site">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->
        <?php 
        // open section outer container
        WonKode_Site_Content_Area::open_section_outer_container( 'bg-primary-lightest' );
            // open section inner container
            WonKode_Site_Content_Area::open_section_inner_container( 'navbar-wrapper' );
            // start displaying nav
            if ( has_nav_menu( 'primary' ) ) : 
                // navbar wrapper class
                $navbar_classes = array( 'navbar navbar-expand-lg ' . WK_TXTDOM . '-navbar ' . 'sticky-top' );
            ?>
            <!-- Navbar Start -->
            <nav class="<?php echo esc_attr( implode( ' ', $navbar_classes ) ); ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand d-flex align-items-center">
                    <img class="img-fluid" src="<?php echo esc_url( WK_ASSETS_URL . '/images/logo.svg' ); ?>" alt="<?php echo get_bloginfo( 'name' ) . ' ' . __( 'logo', WK_TXTDOM ); ?>">
                </a>

                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="<?php echo esc_attr( '#' . WK_TXTDOM . '-primary-navbar' ); ?>" aria-controls="<?php echo esc_attr( WK_TXTDOM . '-primary-navbar' ); ?>" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon toggler-bar"></span> -->
                    <span class="navbar-toggler-icon toggler-grid"></span>
                </button>

                <?php 
                    wp_nav_menu(
                        array(
                            'theme_location'    =>  'primary',
                            'container'         =>  'div',
                            'container_id'      =>  esc_attr( WK_TXTDOM . '-primary-navbar' ),
                            'container_class'   =>  'collapse navbar-collapse',
                            'menu_class'        =>  'navbar-nav mx-auto mb-2 mb-lg-0',
                            'menu_id'           =>  '',
                            'fallback_cb'       =>  false,
                            'depth'             =>  4,
                            'walker'            =>  new WP_Bootstrap_Navwalker()
                        )
                    );
                ?>
                <div class="h-100 d-lg-inline-flex align-items-center d-none">
                    <a class="btn btn-square rounded-circle bg-light text-primary me-2" href="">
                    <?php
                        // use facebook svg icon
                        echo wonkode_get_svg_icon_use( 'facebook' );
                    ?>
                    </a>
                    <a class="btn btn-square rounded-circle bg-light text-primary me-2" href="">
                    <?php
                        // use twitter svg icon
                        echo wonkode_get_svg_icon_use( 'twitter' );
                    ?>
                    </a>
                    <a class="btn btn-square rounded-circle bg-light text-primary me-0" href="">
                    <?php
                        // use linkedin svg icon
                        echo wonkode_get_svg_icon_use( 'linkedin' );
                    ?>
                    </a>
                    <a class="btn btn-square rounded-circle bg-light text-primary me-0" href="">
                    <?php
                        // use instagram svg icon
                        echo wonkode_get_svg_icon_use( 'instagram' );
                    ?>
                    </a>
                </div>
            </nav>
            <!-- Navbar End -->
    <?php
            // closing section inner container
            WonKode_Site_Content_Area::close_section_inner_container();
        // closing section outer container
        WonKode_Site_Content_Area::close_section_outer_container();
        else : 
            // just use the default
            wp_nav_menu(); 
        endif; // if ( has_nav_menu( 'primary' ) )
        // open site content area
        WonKode_Site_Content_Area::open_wrappers();