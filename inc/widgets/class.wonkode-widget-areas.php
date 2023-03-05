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
         * 
         * @since 1.0
         * @return void
         */
        public function register_widget_areas() {
            $this->full_width_page_container_widget_area();
            $this->primary_sidebar();
            $this->secondary_sidebar();
            $this->footer_half_columned_widget_area();
            $this->footer_auto_resizing_columns_widget_area();
            $this->secondary_footer_widget_area();
        }
        /**
         * Callback for registering primary 
         * sidebar widget area
         * 
         * @since 1.0
         * @return void
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
         * @return void
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
         * callback to register half columned 
         * footer widget area
         * 
         * @since 1.0
         * @return void
         */
        public function footer_half_columned_widget_area() {
            register_sidebar( 
                apply_filters(
                    'wonkode_footer_half_columned_widgetarea',
                    array(
                        'name'              =>  __( 'Footer 2 Columns Widget Area', WK_TXTDOM ),
                        'id'                =>  'wonkode-footer-half-columned',
                        'description'       =>  __( 'Add 2 half columned widgets here', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="col-md-6 widget footer-widget-half-columned %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h2 class="widget-title">',
                        'after_title'       =>  '</h2>',
                    )
                )
            );
        }

        /**
         * callback to register primary auto resizing column 
         * footer widget area
         * 
         * @since 1.0
         * @return void
         */
        public function footer_auto_resizing_columns_widget_area() {
            register_sidebar( 
                apply_filters(
                    'wonkode_footer_auto_resizing_column_widgetarea',
                    array(
                        'name'              =>  __( 'Footer Auto-resizing Columns', WK_TXTDOM ),
                        'id'                =>  'wonkode-footer-auto-col-widgets',
                        'description'       =>  __( 'Add widgets here. For example&comma; quick links&comma; category list', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="col widget footer-widget-auto-col %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h2 class="widget-title">',
                        'after_title'       =>  '</h2>',
                    )
                )
            );
        }

        /**
         * callback to register secondary
         * footer widget area
         * 
         * @since 1.0
         * @return void
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
         * @return void
         */
        public function full_width_page_container_widget_area() {
            register_sidebar( 
                apply_filters(
                    'wonkode_width_page_container_widgetarea',
                    array(
                        'name'              =>  __( 'Full Width Page Container', WK_TXTDOM ),
                        'id'                =>  'wonkode-fullwidth-page-container',
                        'description'       =>  __( 'Add widgets to display inside full width page containers', WK_TXTDOM ),
                        'before_widget'     =>  '<div id="%1$s" class="widget fullwidth-container-widget row g-5 align-items-center %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '',
                        'after_title'       =>  '',
                    )
                )
            );
        }
        
    } // ENDS --- class
}
// inistantiating class
new WonKode_Widget_Areas;