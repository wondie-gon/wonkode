<?php
/**
 * functions and definitions
 *
 * @package WonKode
 * @since 1.0
 */

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
require WK_INC_PATH . '/class.wonkode-setup.php';
WonKode_Setup::get_instance();

// enqueues
require WK_INC_PATH . '/class.wonkode-enqueues.php';
WonKode_Enqueues::init();

// includes
require WK_INC_PATH . '/class.wonkode-helper.php';
require WK_INC_PATH . '/class.wonkode-svg-resources.php';
require WK_INC_PATH . '/customizer/customizer-functions.php';
require WK_INC_PATH . '/class.wonkode-custom-nav-walker.php';

// widget areas and custom widgets
require WK_INC_PATH . '/widgets.php';

// template tags
require WK_INC_PATH . '/template-tags.php';


// template builders
require WK_INC_PATH . '/template-builders/class.wonkode-comments-feature.php';
require WK_INC_PATH . '/template-builders/class.wonkode-social-media-links.php';
require WK_INC_PATH . '/template-builders/class.wonkode-social-media-share-menu.php';
require WK_INC_PATH . '/template-builders/class.wonkode-site-content-area.php';

/**
 * --------
 * Common functions for theme
 * --------
 * 
 */

// hooks
require WK_INC_PATH . '/hooks.php';
init_wonkode_comment_feature_hooks();
init_wonkode_social_share_hooks();

// shortcodes