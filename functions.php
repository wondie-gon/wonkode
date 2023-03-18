<?php
/**
 * functions and definitions
 *
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * First, let's set the maximum content width based on the theme's
 * design and stylesheet.
 * This will limit the width of all uploaded images and embeds.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800; /* pixels */
}

/**
* constants
*/
// text domain
if ( ! defined( 'WK_TXTDOM' ) ) {
	define( 'WK_TXTDOM', 'wonkode' );
}
// development mode
if ( ! defined( 'WK_DEVMODE' ) ) {
	define( 'WK_DEVMODE', true );
}

// path to inc
if ( ! defined( 'WK_INC_PATH' ) ) {
	define( 'WK_INC_PATH', get_template_directory() . '/inc' );
}

// path to assets
if ( ! defined( 'WK_ASSETS_PATH' ) ) {
	define( 'WK_ASSETS_PATH', get_template_directory() . '/assets' );
}

// url to assets
if ( ! defined( 'WK_ASSETS_URL' ) ) {
	define( 'WK_ASSETS_URL', get_template_directory_uri() . '/assets' );
}


// theme set up
require_once WK_INC_PATH . '/class.wonkode-setup.php';
WonKode_Setup::get_instance();

// enqueues
require_once WK_INC_PATH . '/class.wonkode-enqueues.php';
WonKode_Enqueues::init();

// includes
require_once WK_INC_PATH . '/class.wonkode-helper.php';
require_once WK_INC_PATH . '/class.wonkode-svg-resources.php';
require_once WK_INC_PATH . '/customizer/customizer-functions.php';
// load class that retrieves post content
require_once WK_INC_PATH . '/class.wonkode-retrieve-post-content.php';
// require_once WK_INC_PATH . '/class.wonkode-custom-nav-walker.php';
require_once WK_INC_PATH . '/class.wp-bootstrap-navwalker.php';

// widget areas and custom widgets
require_once WK_INC_PATH . '/widgets.php';

// template tags
require_once WK_INC_PATH . '/template-tags.php';


/**
 * Load template builders
 */
// UI components builder base class
require_once WK_INC_PATH . '/template-builders/ui-classes/class.wonkode-ui-components.php';
// Comments feature template class
require_once WK_INC_PATH . '/template-builders/class.wonkode-comments-feature.php';
// Social media links feature template class
require_once WK_INC_PATH . '/template-builders/class.wonkode-social-media-links.php';
// Social media sharing feature template class
require_once WK_INC_PATH . '/template-builders/class.wonkode-social-media-share-menu.php';
// Site content area template builder class
require_once WK_INC_PATH . '/template-builders/class.wonkode-site-content-area.php';
// Cards template class
require_once WK_INC_PATH . '/template-builders/ui-classes/class.wonkode-cards.php';

// frontpage builder classes loader
require_once WK_INC_PATH . '/template-builders/front-page-sections/classes-loader.php';

// class for content template parts
require_once WK_INC_PATH . '/template-builders/class.wonkode-content-template-parts.php';
// global variable for rendering template parts
$wonkode_content_template_parts = WonKode_Content_Template_Parts::init();

/**
 * --------
 * Common functions for theme
 * --------
 * 
 */

// hooks
require_once WK_INC_PATH . '/hooks.php';
init_wonkode_comment_feature_hooks();
init_wonkode_social_share_hooks();


// check plugin for being active
if ( wonkode_is_wpcf7_active() ) {
	require_once WK_INC_PATH . '/contact-form-7.php';
}

/**
 * Making theme WooCommerce compatibile
 * 
 * @since 1.0
 */
if ( wonkode_is_woocommerce_activated() ) {
	// include custom template file
	require_once WK_INC_PATH . '/woocommerce.php';
    // WooCommerce featured products customizer
    require_once WK_INC_PATH . '/customizer/woocommerce/class.wonkode-customize-woo-featured-products.php';
    
    /**
     * Add woocommerce supports and some of its features 
	 * by hooking custom callback functions to core's 'after_setup_theme'
     */
    // hooking woocommerce support action
    add_action( 'after_setup_theme', 'wonkode_add_woocommerce_support' );
    // hooking woocommerce product gallery features action
    add_action( 'after_setup_theme', 'wonkode_add_woocommerce_product_gallery_features' );
    /**
     * Hook to enqueue custom styles 
     * for woocommerce pages
     */
    add_action( 'wp_enqueue_scripts', 'wonkode_enqueue_woocommerce_custom_styles' );

    /**
     * Removing action hooks of default woocommerce content wrappers
     */
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

    /**
     * Adding action hooks for theme content wrappers to woocommerce templates
     */
    add_action( 'woocommerce_before_main_content', 'wonkode_woocommerce_before_main_content', 10 );
    add_action( 'woocommerce_after_main_content', 'wonkode_woocommerce_after_main_content', 10 );

    /**
     * Filter to woocommerce body class
     */
    add_filter( 'body_class', 'wonkode_woocommerce_body_class' );

    /**
     * Filter WooCommerce Breadcrumb default arguments
     */
    add_filter( 'woocommerce_breadcrumb_defaults', 'wonkode_woocommerce_modify_breadcrumb_defaults' );

    /**
     * Filter woocommerce single product review form args
     */
    add_filter( 'woocommerce_product_review_comment_form_args', 'wonkode_woocommerce_product_review_form_args' );

    /**
     * Hook filters to add Bootstrap classes to woocommerce form fields.
     */
    add_filter( 'woocommerce_form_field_args', 'wonkode_wc_form_field_args', 10, 3 );
    add_filter( 'woocommerce_quantity_input_classes', 'wonkode_wc_quantity_input_classes' );

    /**
     * Filters single product image gallery wrapper classes
     */
    add_filter( 'woocommerce_single_product_image_gallery_classes', 'wonkode_woocommerce_single_product_image_gallery_classes' );
}

// shortcodes