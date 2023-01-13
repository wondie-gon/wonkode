<?php
/**
 * Class for registeration and functionalities of theme custom widget areas
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access of class file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Widget_Areas' ) ) {
    class WonKode_Widget_Areas {
        /**
         * Class Constructor
         * 
         * Hooks widget registrations to 
         * 'widgets_init' core action when
         * class initializes
         */
        public function __construct() {
            // hook to 'widgets_init'
            add_action( 'widgets_init', array( $this, 'register_widget_areas' ) );
        }
        
        /**
         * Registering all widget areas
         */
        public function register_widget_areas() {
            $this->primary_sidebar();
            $this->secondary_sidebar();
            $this->primary_footer_widget_area();
            $this->secondary_footer_widget_area();
            $this->wide_page_block_widget_area();
        }
        /**
         * Callback for registering primary 
         * sidebar widget area
         * 
         * @since 1.0
         */
        public function primary_sidebar() {
            register_sidebar( 
                apply_filters(
                    'wonkode_sidebar_args',
                    array(
                        'name'              =>  __( 'Primary Sidebar', WK_TXTDOM ),
                        'id'                =>  'wonkode-primary-sidebar',
                        'description'       =>  __( 'Add widgets to display on primary sidebar, commonly right sidebar', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="widget clearfix %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h4 class="widget-title">',
                        'after_title'       =>  '</h4>',
                    )
                )
            );
        }

        /**
         * Callback for registering secondary 
         * sidebar widget area
         * 
         * @since 1.0
         */
        public function secondary_sidebar() {
            register_sidebar( 
                apply_filters(
                    'wonkode_secondary_sidebar_args',
                    array(
                        'name'              =>  __( 'Secondary Sidebar', WK_TXTDOM ),
                        'id'                =>  'wonkode-secondary-sidebar',
                        'description'       =>  __( 'Add widgets to display on the left secondary sidebar', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="widget clearfix %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h4 class="widget-title">',
                        'after_title'       =>  '</h4>',
                    )
                )
            );
        }

        /**
         * callback to register primary
         * footer widget area
         * 
         * @since 1.0
         */
        public function primary_footer_widget_area() {
            register_sidebar( 
                apply_filters(
                    'wonkode_footer_one_widgetarea',
                    array(
                        'name'              =>  __( 'Primary Footer Widget Area', WK_TXTDOM ),
                        'id'                =>  'wonkode-primary-footer',
                        'description'       =>  __( 'Add widgets to top footer section', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="col-6 col-md widget footer-widget-t %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h4 class="widget-title">',
                        'after_title'       =>  '</h4>',
                    )
                )
            );
        }

        /**
         * callback to register secondary
         * footer widget area
         * 
         * @since 1.0
         */
        public function secondary_footer_widget_area() {
            register_sidebar( 
                apply_filters(
                    'wonkode_footer_two_widgetarea',
                    array(
                        'name'              =>  __( 'Secondary Footer Widget Area', WK_TXTDOM ),
                        'id'                =>  'wonkode-secondary-footer',
                        'description'       =>  __( 'Add widgets to bottom footer section', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="col-md-6 text-center text-md-start mb-3 widget footer-widget-b %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h4 class="widget-title">',
                        'after_title'       =>  '</h4>',
                    )
                )
            );
        }

        /**
         * callback to register wide container widget area 
         * for frontpages and other page templates
         * 
         * @since 1.0
         */
        public function wide_page_block_widget_area() {
            register_sidebar( 
                apply_filters(
                    'wonkode_wide_page_block_widgetarea',
                    array(
                        'name'              =>  __( 'Wide Container Page Widget Area', WK_TXTDOM ),
                        'id'                =>  'wonkode-wide-page-container',
                        'description'       =>  __( 'Add Wonkode Equal Image and Text Widget', WK_TXTDOM ),
                        'before_title'      =>  '<h1 class="display-4 mb-3 animated slideInDown">',
                        'after_title'       =>  '</h1>',
                        'before_widget'     =>  '<div class="container py-5">',
                        'after_widget'      =>  '</div>',
                    )
                )
            );
        }
        
    } // ENDS --- class
}
// inistantiating class
new WonKode_Widget_Areas;