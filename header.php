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
    <?php 
    // if ( is_singular() && get_option( 'thread_comments' ) ) {
    //     wp_enqueue_script( 'comment-reply' );
    // } 
    ?>
    <?php wp_head(); ?>
</head>

<body>
    <!-- svg resources starts here -->
    <?php
        // dump svg symbols here
        echo wonkode_get_svg_icon_symbols_bundle( 'social-icons', array( 'facebook', 'twitter', 'instagram', 'linkedin' ) );
        echo wonkode_get_svg_icon_symbols_bundle( 'ui-icons', array( 'rocket', 'arrow_big_up', 'arrow_big_down', 'arrow_big_left', 'arrow_big_right' ) );
        // svg illustrations
        // echo wonkode_get_illustration_svgs( true, 'working' );
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
        if ( has_nav_menu( 'primary' ) ) {
            // navbar wrapper class
            $navbar_classes = array( 'navbar navbar-expand-lg bg-light bg-white ' . WK_TXTDOM . '-navbar ' . 'sticky-top p-0 px-4 px-lg-5' );
        ?>
        <!-- Navbar Start -->
        <nav class="<?php echo esc_attr( implode( ' ', $navbar_classes ) ); ?>">
            <div class="container-fluid">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand d-flex align-items-center">
                    <img class="img-fluid" src="<?php echo esc_url( WK_ASSETS_URL . '/images/logo.svg' ); ?>" alt="<?php echo get_bloginfo( 'name' ) . ' ' . __( 'logo', WK_TXTDOM ); ?>">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="<?php echo esc_attr( '#' . WK_TXTDOM . '-primary-navbar' ); ?>" aria-controls="<?php echo esc_attr( WK_TXTDOM . '-primary-navbar' ); ?>" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
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
            </div>
        </nav>
        <!-- Navbar End -->
    <?php 
        }
        // open site content area
        WonKode_Site_Content_Area::open_wrappers();