<?php
/**
 * Initializes customize front page
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Customize_Front_Page' ) ) {
    class WonKode_Customize_Front_Page extends WonKode_Customize_Base {
        /**
         * Class constructor
         * 
         * @since 1.0
         * @return void
         */
        public function __construct() {
            // parent constructor
            parent::__construct();

            // register customizers
            add_action( 'customize_register', array( $this, 'register' ) );
            // adding live preview
            add_action( 'customize_preview_init', array( $this, 'live_preview_js' ) );

            // load customizers
            $this->load_customizers();
        }
        
        /**
         * Method to register customizer
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            /**
             * Front page customize section
             */
            $wp_customize->add_section(
                $this->prefix_id . '_frontpage_section',
                array(
                    'priority'          =>  130, 
                    'title'             =>  esc_html__( 'WonKode Front Page', $this->theme_id ), 
                    'description'       =>  esc_html__( 'Customize front page sections.', $this->theme_id ), 
                    'capability'        =>  'edit_theme_options',
                    'active_callback'   =>  'is_front_page',
                )
            );
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
            $customize_assets_url = $this->get_customizer_assets_uri();
            wp_enqueue_script( $this->theme_id . '-front-customizer', $customize_assets_url . '/js/front-customizer-preview.js', array( 'jquery', 'customize-preview' ), '', true );
        }

        /**
         * Loads all customizers for 
         * frontpage.
         * 
         * @since 1.0
         */
        public function load_customizers() {
            // categorized latest posts
            require_once WK_CUSTOMIZER_PATH . '/front-page/class.wonkode-customize-categorized-latest-posts.php';
            require_once WK_CUSTOMIZER_PATH . '/front-page/class.wonkode-customize-selected-posts-section.php';
        }
        
    } // ENDS -- class
}
return new WonKode_Customize_Front_Page();