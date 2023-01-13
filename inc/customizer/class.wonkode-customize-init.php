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
            add_action( 'customize_register', array( $this, 'load_custom_controls' ) );
            $this->load_customizers();
        }

        /**
         * Loads custom controls
         * 
         * @since 1.0
         */
        public function load_custom_controls( $wp_customize ) {
            // load custom tinyMCE control 'WonKode_TinyMCE_Custom_Control'
            require_once( WK_CUSTOM_CONTROLS_PATH . '/tinymce/wonkode-tinymce-custom-control.php' );
            // load custom image checkbox 'WonKode_Image_Checkbox_Custom_Control'
            require_once( WK_CUSTOM_CONTROLS_PATH . '/image-checkbox/wonkode-image-checkbox-custom-control.php' );

            // registering custom controls
            $wp_customize->register_control_type( 'WonKode_TinyMCE_Custom_Control' );
            $wp_customize->register_control_type( 'WonKode_Image_Checkbox_Custom_Control' );
        }

        /**
         * Loads all customizers
         * 
         * @since 1.0
         */
        public function load_customizers() {
            // Customizer base class
            require_once( WK_CUSTOMIZER_PATH . '/class.wonkode-sanitize.php' );
            require_once( WK_CUSTOMIZER_PATH . '/class.wonkode-customize-base.php' );

            // general customizers
            require_once( WK_CUSTOMIZER_PATH . '/general/class.wonkode-customize-site-general.php' );
            require_once( WK_CUSTOMIZER_PATH . '/general/class.wonkode-customize-site-layout.php' );
            require_once( WK_CUSTOMIZER_PATH . '/general/class.wonkode-customize-social-media-nav.php' );

            // singular customizers
            require_once( WK_CUSTOMIZER_PATH . '/singular/class.wonkode-customize-social-media-share.php' );
        }
        
    } // ENDS -- class
}
new WonKode_Customize_Init();