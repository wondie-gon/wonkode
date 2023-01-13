<?php
/**
 * Class for helper methods and properties 
 * that can be used through out theme
 *
 * @package WonKode
 * @since 1.0
 */
// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WonKode_Helper' ) ) {
    class WonKode_Helper {
        /**
         * Theme text domain id
         * 
         * @since 1.0
         * @var string
         */
        public static $txt_dom = WK_TXTDOM;
        /**
         * Stores fontawesome icon classes 
         * of social media
         * 
         * @since 1.0
         * @var array
         */
        public static $social_fa_classes = array(
            'facebook'      =>  'fab fa-facebook-f',
            'twitter'       =>  'fab fa-twitter',
            'googleplus'    =>  'fab fa-google-plus-g',
            'pinterest'     =>  'fab fa-pinterest-p',
            'linkedin'      =>  'fab fa-linkedin-in',
            'github'        =>  'fab fa-github',
            'instagram'     =>  'fab fa-instagram',
            'youtube'       =>  'fab fa-youtube',
        );

        /**
         * Returns fontawesome icon element
         * 
         * @since 1.0
         * @param string $fa_class      List of icon class
         * @param array $additionals    Array of additional class names.
         *                              Defaults to empty array
         * @return string/mixed         Html element of icon tag with
         *                              its classes
         */
        public static function get_fa_icon( $fa_class, $additionals = array() ) {
            if ( empty( $fa_class ) ) {
                return;
            }
            // get class list
            $fa_class_list = self::list_classes( $fa_class, $additionals );

            // returning icon element
            return '<i class="' . esc_attr( $fa_class_list ) . '"></i>';
        }

        /**
         * Returns fontawesome stacked icon
         * 
         * @since 1.0
         * 
         * @see 'https://fontawesome.com/docs/web/style/stack'
         * 
         * @param string $fa_class  Main icon class
         * @param bool $solid       Whether icon is solid. Default false
         * @return string/mixed     Html element of icon tag with
         *                          its classes
         */
        public static function get_fa_stacked_icons( $fa_class, $solid = false ) {
            if ( empty( $fa_class ) ) {
                return;
            }
            // get main icon class
            $main_fa_class = self::list_classes( $fa_class, array( 'fa-stack-1x' ) );
            // get outer stack class
            $stack_class = $solid ? self::list_classes( 'fas fa-circle fa-stack-2x' ) : self::list_classes( 'far fa-circle fa-stack-2x' );

            // returning icon element
            return sprintf(
                '<span class="fa-stack" style="vertical-align: top;">
                    <i class="%1$s"></i>
                    <i class="%2$s"></i>
                </span>',
                esc_attr( $stack_class ),
                esc_attr( $main_fa_class )
            );
        }
        /**
         * Helper to get parsed classes ready to be used 
         * in class attribute of html elements
         * 
         * @since 1.0
         * @param array/string $classes list of class argument separated by space
         * @param array $additionals class list array. Defaults to empty array
         * @return string list of parsed classes
         */
        public static function list_classes( $classes, $additionals = array() ) {
            $class_list = '';
            // prepare $classes as array
            $classes = is_array( $classes ) ? $classes : (array) $classes;
            $classes_arr = array();
            for ( $i=0; $i < count( $classes ); $i++ ) { 
                $new_list = explode( ' ', $classes[ $i ] );
                for ( $j=0; $j < count( $new_list ); $j++ ) { 
                    $classes_arr[] = $new_list[ $j ];
                }
            } 
            // merging if additionals is passed
            if ( ! empty( $additionals ) ) {
                $classes_arr = array_merge( $classes_arr, $additionals );
                $class_list .= implode( ' ', (array) implode( ' ', $classes_arr ) );
            } else {
                $class_list .= implode( ' ', $classes_arr );
            }
            return $class_list;
        }

        /*
        ===============Previous function=====================================
        public static function list_classes( $classes, $additionals = array() ) {
            $class_list = '';
            // prepare $classes as array
            $classes = ( ! is_array( $classes ) && is_string( $classes ) ) ? (array) $classes : $classes;
            // parsing
            if ( ! empty( $additionals ) ) {
                $classes = wp_parse_args( $classes, $additionals );
                $class_list .= implode( ' ', (array) implode( ' ', $classes ) );
            } else {
                $class_list .= implode( ' ', $classes );
            }
            return $class_list;
        }
        */

    } // ENDS -- class
}