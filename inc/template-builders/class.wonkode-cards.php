<?php
/**
 * Class for templating cards UI component
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Cards' ) ) {
    class WonKode_Cards extends WonKode_UI_Components {
        /**
         * Class constructor.
         * Sets text domain and unique prefix 
         * properties via parent constructor.
         * 
         * @since 1.0
         */
        public function __construct() {
            parent::__construct();
        }
        /**
         * Returns opening tag for default card element.
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @param string $id                    Value for id attribute for card.
         *                                      Defaults: ''
         * @return mixed Opening tag for default card.
         */
        public static function get_default_card_open( $new_classes = '', $id = '' ) {
            // card default class
            $card_classes = array( 'card' );
            // get card html
            $card_html = self::get_div_open( $new_classes, $card_classes, $id );
            /**
             * Filters default card opening tag
             * 
             * @since 1.0
             * @param mixed $card_html          Card html tag output
             * @param string|array $new_classes List of class to add.
             * @param array $card_classes       Default card classes array.
             *                                  Used to append additional 
             *                                  classes (passed by reference).
             * @param string $id                Value for id attribute for card.
             */
            $card_html = apply_filters( self::$unique_prefix . '_default_card', $card_html, $new_classes, $card_classes, $id );
            return $card_html;
        }
        /**
         * Renders opening tag for default card element.
         * 
         * @since 1.0
         * @param string|array $new_classes List of class to add.
         * @param string $id                Value for id attribute for card.
         * @return void
         */
        public static function open_default_card( $new_classes = '', $id = '' ) {
            echo self::get_default_card_open( $new_classes, $id );
        }
        /**
         * Returns opening tag for card element with 
         * class and inline style.
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @param array $styles             Array of css properties.
         *                                  CSS properties with '-', such as 
         *                                  'background-color', their key 
         *                                  should be given with '_' like 
         *                                  'background_color' => '#fcfcfc'
         * @return mixed Card opening tag with class and inline style.
         */
        public static function get_inline_styled_card_open( $new_classes = '', $styles = array() ) {
            // card default class
            $card_classes = array( 'card' );
            // get div tag including inline style
            $card_div = self::get_inline_styled_div_open( $new_classes, $card_classes, $styles );
            // return card div open
            return $card_div;
        }
        /**
         * Renders opening tag for card with class and 
         * inline style. 
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @param array $styles             Array of css properties.
         *                                  CSS properties with '-', such as 
         *                                  'background-color', their key 
         *                                  should be given with '_' like 
         *                                  'background_color' => '#fcfcfc'
         * @return void
         */
        public static function open_inline_styled_card( $new_classes = '', $styles = array() ) {
            echo self::get_inline_styled_card_open( $new_classes, $styles );
        }
        /**
         * Returns card body tag opening
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @return mixed HTML opening tag for card body.
         */
        public static function get_card_body_open( $new_classes = '' ) {
            // default card body classes
            $card_body_classes = array( 'card-body' );
            // get card body classes
            $card_body_html = self::get_div_open( $new_classes, $card_body_classes );
            // return html
            return $card_body_html;
        }
        /**
         * Renders opening tag for card body.
         * 
         * @since 1.0
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return void
         */
        public static function open_card_body( $new_classes = '' ) {
            echo self::get_card_body_open( $new_classes );
        }
        /**
         * Returns closing div of card body.
         * 
         * @since 1.0
         * @return mixed Closing div of card body
         */
        public static function get_card_body_close() {
            return self::get_html_tag_close();
        }
        /**
         * Renders closing div of card body.
         * 
         * @since 1.0
         * @return void
         */
        public static function close_card_body() {
            echo self::get_card_body_close();
        }
        /**
         * Returns card title element opening. 
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return mixed Card title element opening tag.
         */
        public static function get_card_title_open( $h_tag = 'h4', $new_classes = '' ) {
            // default card title classes
            $card_title_classes = array( 'card-title' );
            // get element tag
            $card_title_elem = self::get_html_elem_open( $new_classes, $card_title_classes, '', $h_tag );
            // return opening tag
            return $card_title_elem;
        }
        /**
         * Renders card title element opening. 
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return void
         */
        public static function open_card_title( $h_tag = 'h4', $new_classes = '' ) {
            echo self::get_card_title_open( $h_tag, $new_classes );
        }
        /**
         * Returns closing of card title element.
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @return mixed Closing h tag
         */
        public static function get_card_title_close( $h_tag = 'h4' ) {
            return self::get_html_tag_close( $h_tag );
        }
        /**
         * Renders closing of card title element.
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @return void
         */
        public static function close_card_title( $h_tag = 'h4' ) {
            echo self::get_card_title_close( $h_tag );
        }
        /**
         * Returns closing div of card element
         * 
         * @since 1.0
         * @return mixed Closing div of html element
         */
        public static function get_card_div_close() {
            return self::get_html_tag_close();
        }
        /**
         * Renders closing div of card element
         * 
         * @since 1.0
         * @return void
         */
        public static function close_card_div() {
            echo self::get_card_div_close();
        }
    } // ENDS -- class
}