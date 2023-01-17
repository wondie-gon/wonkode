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