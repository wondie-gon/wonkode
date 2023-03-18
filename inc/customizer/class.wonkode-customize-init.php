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
         * Class constructor
         */
        public function __construct() {
            // enqueue styles for custom controls
            add_action( 'customize_controls_print_styles', array( $this, 'custom_controls_generic_css' ) );

            // load custom control classes
            $this->load_custom_controls();
            // load customizers
            $this->load_customizers();
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
        
    } // ENDS -- class
}
// initialize customize
return new WonKode_Customize_Init();