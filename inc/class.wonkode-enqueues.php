<?php
/**
 * Class for enqueueing scripts and styles
 *
 * Allows to enqueue scripts, styles, third party libraries of 
 * scripts, styles, font icons etc
 * 
 *
 * @package WonKode
 * @since 1.0
 */
// restricting direct access of class
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Enqueues' ) ) {
    class WonKode_Enqueues {
        /**
         * Object instance of the class
         * 
         * @access private
         */
        private static $instance;
        /**
         * Theme's css uri
         * 
         * @var string
         * @access private
         */
        private static $css_url = WK_ASSETS_URL . '/css';
        /**
         * Theme's js uri
         * 
         * @var string
         * @access private
         */
        private static $js_url = WK_ASSETS_URL . '/js';
        /**
         * Theme's third party libraries uri that 
         * are stored in the theme
         * 
         * @var string
         * @access private
         */
        private static $libs_url = WK_ASSETS_URL . '/lib';

        /**
         * Theme's third party libraries uri that 
         * are stored in the theme
         * 
         * @var string
         * @access private
         */
        private static $handles_prefix = 'wonkode';

        /**
         * Checks if theme is on development mode 
         * Allows to set versions of styles and scripts
         * 
         * @var boolean 
         * @access private
         */
        private static $in_dev_mode = WK_DEVMODE;

        /**
		* Instantiate class
		*/
		public static function init() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WonKode_Enqueues ) ) {
                // assign object instance
				self::$instance = new WonKode_Enqueues;

                /**
                 * Hook styles' and scripts' enqueue callback to 
                 * 'wp_enqueue_scripts' WordPress action
                 */
                add_action( 'wp_enqueue_scripts', array( self::$instance, 'theme_all_styles' ) );
                add_action( 'wp_enqueue_scripts', array( self::$instance, 'theme_all_scripts' ) );
			}
			return self::$instance;
		}

        /**
         * Gathering all styles to be enqueued
         */
        public function theme_all_styles() {
            // prefix for handle names
            $prefix = self::$handles_prefix;
            // get version
            $ver = self::$in_dev_mode ? time() : wp_get_theme()->get( 'Version' );

            // enqueue theme's main style
            wp_enqueue_style( $prefix . '-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ), 'all' );

            // adding Google fonts
            self::google_fonts( $prefix );
            // adding fontawesome
            self::fontawesome_icons( $prefix );
            // adding third party css
            self::third_party_css( $prefix );
            // theme's basic styles
            self::enqueue_basic_styles( $prefix, $ver );
        }

        /**
         * Gathering all scripts to be enqueued
         */
        public function theme_all_scripts() {
            // prefix for handle names
            $prefix = self::$handles_prefix;
            // get version
            $ver = self::$in_dev_mode ? time() : wp_get_theme()->get( 'Version' );

            // add third party scripts
            self::third_party_js( $prefix );
            // add custom scripts
            self::enqueue_custom_scripts( $prefix, $ver );
        }

        /**
         * Enqueues Google fonts
         */
        public static function google_fonts( $prefix ) {
            wp_register_style( $prefix . '-google-font-style', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700&display=swap', array(), false, 'all' );

            wp_enqueue_style( $prefix . '-google-font-style' );
        }

        /**
         * Enqueues Fontawesome icons' css file
         */
        public static function fontawesome_icons( $prefix ) {
            wp_register_style( $prefix . '-fontawesome-icons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css', array(), false, 'all' );

            wp_enqueue_style( $prefix . '-fontawesome-icons' );
        }

        /**
         * Enqueues all styles, including 
         * custom and bootstrap styles
         */
        public static function enqueue_basic_styles( $prefix, $ver ) {
            wp_register_style( $prefix . '-bootstrap', self::$css_url . '/bootstrap.min.css', array(), $ver, 'all' );

	        wp_register_style( $prefix . '-customstyles', self::$css_url . '/custom-styles.css', array( $prefix . '-bootstrap' ), $ver, 'all' );

            // enqueueing styles
            wp_enqueue_style( $prefix . '-bootstrap' );
	        wp_enqueue_style( $prefix . '-customstyles' );
        }

        /**
         * Enqueues third party stylesheet files 
         * that are essential for theme
         */
        public static function third_party_css( $prefix ) {
            wp_register_style( $prefix . '-bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css', array(), '1.4.1', 'all' );

            wp_register_style( $prefix . '-animate-style', self::$libs_url . '/animate/animate.min.css', array(), false, 'all' );

            wp_register_style( $prefix . '-owlcarousel-style', self::$libs_url . '/owlcarousel/assets/owl.carousel.min.css', array(), false, 'all' );

            // enqueueing
            wp_enqueue_style( $prefix . '-bootstrap-icons' );
            wp_enqueue_style( $prefix . '-animate-style' );
            wp_enqueue_style( $prefix . '-owlcarousel-style' );
        }

        /**
         * Enqueues third party JavaScript files 
         * that are essential for theme
         */
        public static function third_party_js( $prefix ) {
            // registering third party JavaScript libraries
            wp_register_script( $prefix . '-bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), false, true );
            // wp_register_script( $prefix . '-popperjs', 'https://unpkg.com/@popperjs/core@2/dist/umd/popper.js', array(), false, true );
            wp_register_script( $prefix . '-wow', self::$libs_url . '/wow/wow.min.js', array(), false, true );
            wp_register_script( $prefix . '-easing', self::$libs_url . '/easing/easing.min.js', array(), false, true );
            wp_register_script( $prefix . '-waypoints', self::$libs_url . '/waypoints/waypoints.min.js', array(), false, true );
            wp_register_script( $prefix . '-owlcarousel', self::$libs_url . '/owlcarousel/owl.carousel.min.js', array(), false, true );
            wp_register_script( $prefix . '-counterup', self::$libs_url . '/counterup/counterup.min.js', array( 'jquery' ), false, true );

            // enqueueing registered third party scripts
            wp_enqueue_script( $prefix . '-bootstrap-script' );
            // wp_enqueue_script( $prefix . '-popperjs' );
            wp_enqueue_script( $prefix . '-wow' );
            wp_enqueue_script( $prefix . '-easing' );
            wp_enqueue_script( $prefix . '-waypoints' );
            wp_enqueue_script( $prefix . '-owlcarousel' );
        }

        /**
         * Enqueues custom scripts of theme
         */
        public static function enqueue_custom_scripts( $prefix, $ver ) {
            // registering custom scripts
            wp_register_script( $prefix . '-custom-main', self::$js_url . '/custom-main.js', array( 'jquery', $prefix . '-wow', $prefix . '-easing', $prefix . '-waypoints', $prefix . '-counterup' ), $ver, true );

            // enqueueing custom scripts
            wp_enqueue_script( $prefix . '-custom-main' );
        }

        
    } // END of class
}