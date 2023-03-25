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
            $wp_customize->add_panel( 
                $this->prefix_id . '_frontpage_panel',
                array(
                    'title'             => __( 'Frontpage Customizer', $this->theme_id ),
                    'description'       => esc_html__( 'Allows you to customize your frontpage sections and other features.', $this->theme_id ),
                    'priority'          =>  160,
                    'active_callback'   =>  'is_front_page',
                )
            );
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