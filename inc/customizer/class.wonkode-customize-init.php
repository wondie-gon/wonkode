<?php
/**
 * Initializes customize feature
 * 
 * Defines constants, loads custom controls, customizers
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Customize_Init' ) ) {
    class WonKode_Customize_Init {
        /**
         * Theme identifier, namespace
         * 
         * @since 1.0
         * @access protected
         * @var string 
         */
        protected $theme_id;
        /**
         * Unique id for prefix
         * 
         * @access protected
         * 
         * @since 1.0
         * @var string
         */
        protected $prefix_id;
        /**
         * Class constructor
         */
        public function __construct() {
            // setting theme identity
            $theme_obj = wp_get_theme();
            if ( $theme_obj->exists() ) {
                $this->theme_id = $theme_obj->get( 'TextDomain' );
            } else {
                $this->theme_id = get_stylesheet();
            }
            // setting unique prefix
            $this->prefix_id = strtolower( str_replace( '-', '_', $this->theme_id ) );

            // load custom control classes
            $this->load_custom_controls();
            // load customizers
            $this->load_customizers();

            // Enqueue customize preview javascript
            add_action( 'customize_preview_init', array( $this, 'customize_previews_js' ) );

            // enqueue customize controls js
            add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_js' ) );

            // enqueue styles for custom controls
            add_action( 'customize_controls_print_styles', array( $this, 'custom_controls_generic_css' ) );
        }

        /**
         * Loads custom controls
         * 
         * @since 1.0
         */
        public function load_custom_controls() {
            // load custom tinyMCE control 'WonKode_TinyMCE_Custom_Control'
            require_once WK_CUSTOM_CONTROLS_PATH . '/tinymce/wonkode-tinymce-custom-control.php';
            // load custom image checkbox 'WonKode_Image_Checkbox_Custom_Control'
            require_once WK_CUSTOM_CONTROLS_PATH . '/image-checkbox/wonkode-image-checkbox-custom-control.php';

            require_once WK_CUSTOM_CONTROLS_PATH . '/wonkode-separator-custom-control.php';
            require_once WK_CUSTOM_CONTROLS_PATH . '/dropdown-categories/wonkode-category-dropdown-control.php';
            require_once WK_CUSTOM_CONTROLS_PATH . '/dropdown-posts/wonkode-post-dropdown-custom-control.php';
        }
        /**
         * Loads all customizers
         * 
         * @since 1.0
         */
        public function load_customizers() {
            // Customizer base class
            require_once WK_CUSTOMIZER_PATH . '/class.wonkode-sanitize.php';
            require_once WK_CUSTOMIZER_PATH . '/class.wonkode-customize-base.php';

            // general customizers
            require_once WK_CUSTOMIZER_PATH . '/general/class.wonkode-customize-site-general.php';
            require_once WK_CUSTOMIZER_PATH . '/general/class.wonkode-customize-site-layout.php';
            require_once WK_CUSTOMIZER_PATH . '/general/class.wonkode-customize-social-media-nav.php';

            // frontpage customizers
            require_once WK_CUSTOMIZER_PATH . '/front-page/class.wonkode-customize-front-page.php';

            // singular customizers
            require_once WK_CUSTOMIZER_PATH . '/singular/class.wonkode-customize-social-media-share.php';
        }
        /**
		 * Adds generic custom styles for customizer 
         * controls.
         * 
		 * @since  1.0
		 */
		public function custom_controls_generic_css() {
			?>
			<style>
                .customize-section-title {
                    font-size: 1.125rem;
                    font-weight: 400;
                }
                .description.customize-section-description {
                    font-size: 1.125rem;
                    font-weight: 300;
                }
                span.customize-section_heading {
                    display: block;
                    font-size: 1.125rem;
                    font-weight: 400;
                    color: #320f1e;
                }
                span.customize-sub_section_heading {
                    display: block;
                    font-size: 1rem;
                    font-weight: 400;
                    color: #320f1e;
                    border-bottom: 1px solid #0091c8;
                }
                p.description, 
                .customize-separator-description.description {
                    color: #19070f;
                    font-size: 0.875rem;
                    font-weight: 300;
                    padding-left: 0.5rem;
                }
                .customize-sub_section_text {
                    color: #19070f;
                    font-size: 0.75rem;
                    font-weight: 200;
                    font-style: italic;
                    padding-left: 0.5rem;
                }

			</style>
			<?php
		}

        /**
		 * Enqueues custom javascript for 
         * asynchronous real time preview 
         * of customizer changes.
         * 
		 * @since  1.0
		 */
		public function customize_previews_js() {
            // get version
            $ver = $this->get_scripts_version();
            // customize assets url
            $customize_assets_url = get_template_directory_uri() . '/inc/customizer/assets';
            wp_enqueue_script( $this->theme_id . '-customize-previews', $customize_assets_url . '/js/customize-previews.js', array( 'customize-preview' ), $ver, true );
        }

        /**
		 * Enqueues customize controls 
         * custom javascript
         * 
		 * @since  1.0
		 */
		public function customize_controls_js() {
            // get version
            $ver = $this->get_scripts_version();
            // customize assets url
            $customize_assets_url = get_template_directory_uri() . '/inc/customizer/assets';
            wp_enqueue_script( $this->theme_id . '-customize-controls', $customize_assets_url . '/js/customize-controls.js', array( 'customize-controls', 'jquery' ), $ver, true );
        }

        /**
         * Check if theme is in development mode
         * 
         * @since 1.0
         * @return string Version for enqueued scripts
         */
        public function get_scripts_version() {
            $ver = wp_get_theme()->get( 'Version' );
            // get sitename, and check if it is on local
		    $sitename = wp_parse_url( network_home_url(), PHP_URL_HOST );
            // use time as version on local server
            if ( in_array( strtolower( $sitename ), array( 'localhost', '127.0.0.1' ) ) ) {
                $ver = time();
            }
            return $ver;
        }
        
    } // ENDS -- class
}
// initialize customize
return new WonKode_Customize_Init();