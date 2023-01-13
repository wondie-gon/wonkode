<?php
/**
 * Class to customize site general features
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Customize_Site_General' ) ) {

    class WonKode_Customize_Site_General extends WonKode_Customize_Base {
        /**
         * Class constructor
         * 
         * Hooks callbacks to relevant customizer actions
         */
        public function __construct() {
            parent::__construct();

            // add action to hook to register customizer
            add_action( 'customize_register', array( $this, 'register' ) );
            // adding live preview
            add_action( 'customize_preview_init', array( $this, 'live_preview_js' ) );
            // adding style to head
            add_action( 'wp_head', array( $this, 'style_output' ) );
        }
        /**
         * Register some changes on site general 
         * customize
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            // changes settings transport attribute
            $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
            $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
            $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
            $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
        }

        /**
         * Action to be hooked to 'wp_head'
         * This will output style changes of the cstomizer.
         * 
         * @since 1.0
         */
        public function style_output() {
            // Customizer styles
            $this->generate_css( '#site-title a, #site-title, .site-description', 'color', 'header_textcolor', '#', '', false ); 
            $this->generate_css( 'body.custom-background', 'background-color', 'background_color', '#', '', false ); 
        }

        /**
         * Enqueues JavaScript for the live settings preview
         * 
         * Used by hook: 'customize_preview_init'
         * 
         * @since 1.0
         * @return void
         */
        public function live_preview_js() {
            wp_enqueue_script( $this->theme_id . '-site-general', get_template_directory_uri() . '/inc/customizer/assets/js/site-general-preview.js', array( 'jquery', 'customize-preview' ), '', true );
        }
        
    } // ENDS -- class
    
}
new WonKode_Customize_Site_General();