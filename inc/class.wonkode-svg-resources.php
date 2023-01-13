<?php
/**
 * Class for SVG resources of theme
 *
 * Stores SVG for the theme and contains methods 
 * to access SVG's in different parts of theme files
 * 
 *
 * @package WonKode
 * @since 1.0
 *
 */
// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WonKode_SVG_Resources' ) ) {
    class WonKode_SVG_Resources {
        /**
         * Holds SVGs for UI icons
         * 
         * @since 1.0
         * @var array
         */
        protected static $ui_icons = array(
            'search'            =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" />',
            'home'              =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />',
            'star'              =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />',
            'heart'             =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />',
            'thumb_up'          =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />',
            'thumb_down'        =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" />',
            'align_left'        =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="20" y2="6" /><line x1="4" y1="12" x2="14" y2="12" /><line x1="4" y1="18" x2="18" y2="18" />',
            'align_center'      =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="20" y2="6" /><line x1="8" y1="12" x2="16" y2="12" /><line x1="6" y1="18" x2="18" y2="18" />',
            'align_justified'   =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="20" y2="6" /><line x1="4" y1="12" x2="20" y2="12" /><line x1="4" y1="18" x2="16" y2="18" />',
            'align_right'       =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="20" y2="6" /><line x1="10" y1="12" x2="20" y2="12" /><line x1="6" y1="18" x2="20" y2="18" />',
            'rocket'            =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3" /><path d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3" /><circle cx="15" cy="9" r="1" />',
            'arrow_big_up'      =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 12h-3.586a1 1 0 0 1 -.707 -1.707l6.586 -6.586a1 1 0 0 1 1.414 0l6.586 6.586a1 1 0 0 1 -.707 1.707h-3.586v3h-6v-3z" /><path d="M9 21h6" /><path d="M9 18h6" />',
            'arrow_big_down'    =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M15 12h3.586a1 1 0 0 1 .707 1.707l-6.586 6.586a1 1 0 0 1 -1.414 0l-6.586 -6.586a1 1 0 0 1 .707 -1.707h3.586v-3h6v3z" /><path d="M15 3h-6" /><path d="M15 6h-6" />',
            'arrow_big_left'    =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 15v3.586a1 1 0 0 1 -1.707 .707l-6.586 -6.586a1 1 0 0 1 0 -1.414l6.586 -6.586a1 1 0 0 1 1.707 .707v3.586h3v6h-3z" /><path d="M21 15v-6" /><path d="M18 15v-6" />',
            'arrow_big_right'   =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-3v-6h3z" /><path d="M3 9v6" /><path d="M6 9v6" />',
        );

        /**
         * Holds SVGs for Social media icons
         * 
         * @since 1.0
         * @var array
         */
        protected static $social_icons = array(
            'facebook'          =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />',
            'meta'              =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 10.174c1.766 -2.784 3.315 -4.174 4.648 -4.174c2 0 3.263 2.213 4 5.217c.704 2.869 .5 6.783 -2 6.783c-1.114 0 -2.648 -1.565 -4.148 -3.652a27.627 27.627 0 0 1 -2.5 -4.174z" /><path d="M12 10.174c-1.766 -2.784 -3.315 -4.174 -4.648 -4.174c-2 0 -3.263 2.213 -4 5.217c-.704 2.869 -.5 6.783 2 6.783c1.114 0 2.648 -1.565 4.148 -3.652c1 -1.391 1.833 -2.783 2.5 -4.174z" />',
            'twitter'           =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c-.002 -.249 1.51 -2.772 1.818 -4.013z" />',
            'instagram'         =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="4" width="16" height="16" rx="4" /><circle cx="12" cy="12" r="3" /><line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />',
            'pinterest'         =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="8" y1="20" x2="12" y2="11" /><path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" /><circle cx="12" cy="12" r="9" />',
            'tumblr'            =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 21h4v-4h-4v-6h4v-4h-4v-4h-4v1a3 3 0 0 1 -3 3h-1v4h4v6a4 4 0 0 0 4 4" />',
            'reddit'            =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 8c2.648 0 5.028 .826 6.675 2.14a2.5 2.5 0 0 1 2.326 4.36c0 3.59 -4.03 6.5 -9 6.5c-4.875 0 -8.845 -2.8 -9 -6.294l-1 -.206a2.5 2.5 0 0 1 2.326 -4.36c1.646 -1.313 4.026 -2.14 6.674 -2.14z" /><path d="M12 8l1 -5l6 1" /><circle cx="19" cy="4" r="1" /><circle cx="9" cy="13" r=".5" fill="currentColor" /><circle cx="15" cy="13" r=".5" fill="currentColor" /><path d="M10 17c.667 .333 1.333 .5 2 .5s1.333 -.167 2 -.5" />',
            'whatsapp'          =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" /><path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" />',
            'linkedin'          =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="4" width="16" height="16" rx="2" /><line x1="8" y1="11" x2="8" y2="16" /><line x1="8" y1="8" x2="8" y2="8.01" /><line x1="12" y1="16" x2="12" y2="11" /><path d="M16 16v-3a2 2 0 0 0 -4 0" />',
            'googleplus'        =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M17.788 5.108a9 9 0 1 0 3.212 6.892h-8" />',
            'github'            =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />',
            'telegram'          =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />',
            'messenger'         =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" /><path d="M8 13l3 -2l2 2l3 -2" />',
            'snapchat'          =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M16.882 7.842a4.882 4.882 0 0 0 -9.764 0c0 4.273 -.213 6.409 -4.118 8.118c2 .882 2 .882 3 3c3 0 4 2 6 2s3 -2 6 -2c1 -2.118 1 -2.118 3 -3c-3.906 -1.709 -4.118 -3.845 -4.118 -8.118zm-13.882 8.119c4 -2.118 4 -4.118 1 -7.118m17 7.118c-4 -2.118 -4 -4.118 -1 -7.118" />',
            'tiktok'            =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 12a4 4 0 1 0 4 4v-12a5 5 0 0 0 5 5" />',
            'youtube'           =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="3" y="5" width="18" height="14" rx="4" /><path d="M10 9l5 3l-5 3z" />',
            'vimeo'             =>  '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 8.5l1 1s1.5 -1.102 2 -.5c.509 .609 1.863 7.65 2.5 9c.556 1.184 1.978 2.89 4 1.5c2 -1.5 7.5 -5.5 8.5 -11.5c.444 -2.661 -1 -4 -2.5 -4c-2 0 -4.047 1.202 -4.5 4c2.05 -1.254 2.551 1.003 1.5 3c-1.052 2.005 -2 3 -2.5 3c-.49 0 -.924 -1.165 -1.5 -3.5c-.59 -2.42 -.5 -6.5 -3 -6.5s-5.5 4.5 -5.5 4.5z" />',
        );

        /**
         * Holds SVGs for illustration images
         * 
         * @since 1.0
         * @var array
         */
        private static $illustration_imgs = array();

        /**
         * Holds styles for illustration images
         * 
         * @since 1.0
         * @var array
         */
        private static $illustration_styles = array();

        /**
         * Checks whether illustrations in separate 
         * file need to be imported.
         * 
         * @since 1.0
         * @var bool
         */
        private static $import_activated = false;

        /**
         * Class constructor. 
         * 
         * @since 1.0
         * @param bool $import  Whether to import svg 
         *                      resources file. Sets 
         *                      self::$import_activated
         *                      property.
         * @return void
         */
        public function __construct( $import = false ) {
            // set import activation
            self::$import_activated = $import;
            // setting properties
            if ( self::$import_activated ) {
                // set illustration images
                self::set_illustration_imgs();
                // set illustration styles
                self::set_illustration_styles();
            }
        }

        /**
         * Returns svg use element to use svg symbols 
         * loaded in a page.
         * 
         * @since 1.0
         * @param string $name      Name of svg to display from loaded svg symbols. 
         *                          See the available names to use in 
         *                          'WonKode_SVG_Reources' class.
         * @param string $svg_type  Type of svg. Possible values: 'icon' and 'illustration'
         *                          Default 'icon'
         * @param array $args       {
         *      Array of additional arguments to be used as attributes for svg use
         *      Default: empty array
         *          @type string    'class'    Class attribute value
         *          @type int       'width'    Width for svg to display
         *          @type int       'height'   Height for svg to display
         * }
         * @return mixed    SVG use block with id attribute value to display
         */
        public static function get_svg_use_block( $name, $svg_type = 'icon', $args = array() ) {
            // name should be passed
            if ( empty( $name ) ) {
                return;
            }
            // default arguments array
            $default_args = array(
                'class'     =>  '',
                'width'     =>  null,
                'height'    =>  null,
            );
            $args = wp_parse_args( $args, $default_args );

            $svg_use_elem = '';

            /**
             * ============TODO============
             * good if svg symbol exists in document
             */
            
            // id to use
            $symbol_id = $name;
            $svg_class = '';

            if ( 'illustration' === $svg_type ) {
                // content width of theme
                global $content_width;

                $args['class'] = ! empty( $args['class'] ) ? $args['class'] : 'svg-illustration';
                // $args['width'] = isset( $args['width'] ) && is_int( $args['width'] ) ? (string) $args['width'] : '1000';
                $args['width'] = ! empty( $args['width'] ) && is_int( $args['width'] ) ? (string) $args['width'] : (string) $content_width;
                $args['height'] = ! empty( $args['height'] ) && is_int( $args['height'] ) ? (string) $args['height'] : (string) $content_width;
                // complete the id 
                $symbol_id .= '-illustration';
            } else {
                $args['class'] = ! empty( $args['class'] ) ? $args['class'] : 'svg-icon';
                $args['width'] = ! empty( $args['width'] ) && is_int( $args['width'] ) ? (string) $args['width'] : '24';
                $args['height'] = ! empty( $args['height'] ) && is_int( $args['height'] ) ? (string) $args['height'] : '24';
                // complete the id 
                $symbol_id .= '-icon';
            }
            // get class list ready using 'WonKode_Helper' class method
            $svg_class .= WonKode_Helper::list_classes( $args['class'] );
            // construct svg use block
            $svg_use_elem .= '<svg class="' . esc_attr( $svg_class ) . '" width="' . $args['width'] . '" height="' . $args['height'] . '">' . "\n";
            $svg_use_elem .= '<use xlink:href="#' . esc_attr( $symbol_id ) . '" />' . "\n";
            $svg_use_elem .= '</svg>' . "\n";

            // return svg use
            return $svg_use_elem;
        }

        /**
         * Returns svg resources in group of symbols that can be
         * printed just below opening of <body> html tag for the page 
         * where the resources are needed.
         * 
         * @since 1.0
         * @param string $group 	Name of svg resource group you want 
         * 							to retrieve
         * @param array $names 		Array of svg resource names from group
         * @param array $args 		{
         * 		Array of arguments you want to modify in the <symbol> tag
         * 		while retrieving svg resources. Default is empty.
         * 			@type string 'view_box'		Value for 'viewBox' attribute.
         * 			@type int    'size'			Value for 'size' attribute.
         * 			@type int    'stroke_w'		Value for 'stroke-width' attribute.
         * 			@type string 'stroke'		Value for 'stroke' (color) attribute.
         * 			@type string 'fill'			Value for 'fill' (color) attribute.
         * }
         * @return mixed Bundle of SVG symbols
         */
        public static function get_icon_symbols_group( $group, $names = array(), $args = array() ) {
            if ( empty( $group ) ) {
                return '';
            }
            // start collecting symbols
            $symbols_output = '';
            if ( 'ui-icons' === $group ) {
                $symbols_output = self::get_icon_symbols( 'ui-icons', $names, $args );
            } elseif ( 'social-icons' === $group ) {
                $symbols_output = self::get_icon_symbols( 'social-icons', $names, $args );
            } else {
                $symbols_output = null;
            }
            // start the output
            $svg_out = '';
            if ( null !== $symbols_output ) {
                $svg_out .= '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">' . "\n";
                $svg_out .= $symbols_output . "\n";
                $svg_out .= '</svg>' . "\n";
            }
            // return the result
            return $svg_out;
        }
        /**
         * Returns list of svg symbol resources for illustration images
         * 
         * @since 1.0
         * @param array $names      Array of svg icon names stored in 
         *                          self::$illustration_imgs
         * @param array $args 		{
         *  		Array of arguments you want to modify in the <symbol> tag
         *          while retrieving svg resources. Default is empty. 
         *            @type string 'view_box'		Value for 'viewBox' attribute. Default "0 0 1000 1000"
         *            @type string 'x'		        Value for 'x' attribute. Default '0px'
         *            @type string 'y'		        Value for 'y' attribute. Default '0px'
         *            @type string 'bg_shape'		Name of background shape. 
         *                                          Default 'rectangle'. Possible values include 'circle, ellipse'
         *            @type string 'bg_stroke'		Value for 'stroke' (color) attribute of background shape. 
         *                                          Default 'none'
         *            @type string 'bg_fill'		Value for 'fill' (color) attribute of background shape. 
         *                                          Default '#EAECEF'
         *          }
         * @return mixed    List of svg symbols for illustration images
         */
        public static function get_illust_symbols_group( $names = array(), $args = array() ) {
            // start output
            $svg_out = '';
            // get illustration symbols
            $illust_symbols = self::get_illustration_symbols( $names, $args );

            if ( ! empty( $illust_symbols ) ) {
                $svg_out .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">' . "\n";
                $svg_out .= $illust_symbols . "\n";
                $svg_out .= '</svg>';
            }
            // return svg group
            return $svg_out;
        }

        /**
         * Imports illustrations resource and sets 
         * WonKode_SVG_Resources::$illustration_imgs;
         * 
         * @since 1.0
         * @return void
         */
        private static function set_illustration_imgs() {
            include_once get_template_directory() . '/assets/svg-lib/illustrations.php';
            self::$illustration_imgs = $wonkode_illustration_svgs;
        }

        /**
         * Imports illustrations styles and sets 
         * WonKode_SVG_Resources::$illustration_styles;
         * 
         * @since 1.0
         * @return void
         */
        private static function set_illustration_styles( $styles = array() ) {
            include_once get_template_directory() . '/assets/svg-lib/illustration-styles.php';
            self::$illustration_styles = $wonkode_illustration_styles;
        }
        /**
         * Returns list of svg symbol resources for illustration images
         * 
         * @since 1.0
         * @param array $names      Array of svg icon names stored in 
         *                          self::$illustration_imgs
         * @param array $args 		{
         *  		Array of arguments you want to modify in the <symbol> tag
         *          while retrieving svg resources. Default is empty. 
         *            @type string 'view_box'		Value for 'viewBox' attribute. Default "0 0 1000 1000"
         *            @type string 'x'		        Value for 'x' attribute. Default '0px'
         *            @type string 'y'		        Value for 'y' attribute. Default '0px'
         *            @type string 'bg_shape'		Name of background shape. 
         *                                          Default 'rectangle'. Possible values include 'circle, ellipse'
         *            @type string 'bg_stroke'		Value for 'stroke' (color) attribute of background shape. 
         *                                          Default 'none'
         *            @type string 'bg_fill'		Value for 'fill' (color) attribute of background shape. 
         *                                          Default '#EAECEF'
         *          }
         * @return mixed    List of svg symbols for illustration images
         */
        private static function get_illustration_symbols( $names = array(), $args = array() ) {
            // get parsed args
            $args = self::parse_illustration_args( $args );

            if ( ! is_array( $names ) ) {
                $names = (array) $names;
            }

            if ( empty( $names ) ) {
                $names = array_keys( self::$illustration_imgs );
            }

            $illustration_symbols = '';

            foreach ( $names as $name ) {
                if ( self::get_illustration_symbol( $name, $args ) ) {
                    $illustration_symbols .= self::get_illustration_symbol( $name, $args ) . "\n";
                }
            }

            return $illustration_symbols;
        }
        /**
         * Returns list of svg symbol resources for icons
         * 
         * @since 1.0
         * @param string $group 	Name of svg resource group you want 
         * 							to retrieve
         * @param array $names      Array of svg icon names stored in 
         *                          self::$ui_icons, self::$social_icons
         * @param array $args 		{
         *  		Array of arguments you want to modify in the <symbol> tag
         *          while retrieving svg resources. Default is empty. 
         *              'view_box'		Value for 'viewBox' attribute. Default "0 0 24 24"
         *              'size'			Value for 'size' attribute. Default 24
         *              'stroke_w'		Value for 'stroke-width' attribute. Default 2
         *              'stroke'		Value for 'stroke' (color) attribute. Default 'currentColor'
         *              'fill'			Value for 'fill' (color) attribute. Default 'none' 
         *          }
         * @return mixed    List of svg symbols for icons
         */
        public static function get_icon_symbols( $group, $names = array(), $args = array() ) {
            // group should not be empty
            if ( empty( $group ) || ! ( 'ui-icons' === $group || 'social-icons' === $group ) ) {
                return;
            }
            // get parsed args
            $args = self::parse_icon_args( $args );
            // convert names list to array
            if ( ! is_array( $names ) ) {
                $names = (array) $names;
            }
            // when no names passed
            if ( empty( $names ) ) {
                if ( 'ui-icons' === $group ) {
                    $names = array_keys( self::$ui_icons );
                } else {
                    $names = array_keys( self::$social_icons );
                }
            }
            // initiate output
            $ui_icon_symbols = '';
            // get each icon symbol
            foreach ( $names as $name ) {
                if ( self::get_icon_symbol( $group, $name, $args ) ) {
                    $ui_icon_symbols .= self::get_icon_symbol( $group, $name, $args ) . "\n";
                }
            }
            // return the result
            return $ui_icon_symbols;
        }
        /**
         * Returns single svg symbol for illustration image. 
         * For internal use.
         * 
         * @access private
         * 
         * @since 1.0
         * @param array $args 		{
         *  		Array of arguments you want to modify in the <symbol> tag
         *          while retrieving svg resources. Default is empty. 
         *            @type string 'view_box'		Value for 'viewBox' attribute. Default "0 0 1000 1000"
         *            @type string 'x'		        Value for 'x' attribute. Default '0px'
         *            @type string 'y'		        Value for 'y' attribute. Default '0px'
         *            @type string 'bg_shape'		Name of background shape. 
         *                                          Default 'rectangle'. Possible values include 'circle, ellipse'
         *            @type string 'bg_stroke'		Value for 'stroke' (color) attribute of background shape. 
         *                                          Default 'none'
         *            @type string 'bg_fill'		Value for 'fill' (color) attribute of background shape. 
         *                                          Default '#EAECEF'
         *          }
         * @return mixed    SVG symbol
         */
        private static function get_illustration_symbol( $name, $args = array() ) {
            if ( '' === $name || ! array_key_exists( $name, self::$illustration_imgs ) ) {
                return false;
            }

            $illust_symbol = '<symbol id="' . esc_attr( $name ) . '-illustration"';

            $illust_symbol .= ' viewBox="' . $args['view_box'] . '"';

            $illust_symbol .= ' x="' . $args['x'] . '"';

            $illust_symbol .= ' y="' . $args['y'] . '"';

            $illust_symbol .= ' style="enable-background:new ' . $args['view_box'] . ';" xml:space="preserve">' . "\n";

            if ( self::$illustration_styles[ $name ] ) {
                $illust_symbol .= '<style type="text/css">' . "\n";
                $illust_symbol .= self::get_illustration_style( $name ) . "\n";
                $illust_symbol .= '</style>' . "\n";
            }

            $illust_symbol .= self::get_illustration_bg( $args['bg_shape'], $args['bg_fill'], $args['bg_stroke'] );

            $illust_symbol .= self::$illustration_imgs[ $name ] . "\n";
            $illust_symbol .= '</symbol>';

            return $illust_symbol;
        }
        /**
         * Returns single svg symbol for icon. 
         * For internal use.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $group     Name of svg resource group you want 
         * 						    to retrieve
         * @param string $name      Name of icon you want to access stored. 
         *                          See names in self::$ui_icons and self::$social_icons 
         *                          to know which icons exist.
         * @param array $args 		{
         *  		Array of arguments you want to modify in the <symbol> tag
         *          while retrieving svg resources. Default is empty. 
         *              @type string 'view_box'		Value for 'viewBox' attribute. Default "0 0 24 24"
         *              @type int    'stroke_w'		Value for 'stroke-width' attribute. Default 2
         *              @type string 'stroke'		Value for 'stroke' (color) attribute. Default 'currentColor'
         *              @type string 'fill'			Value for 'fill' (color) attribute. Default 'none' 
         *          }
         * @return mixed    SVG symbol
         */
        private static function get_icon_symbol( $group, $name, $args = array() ) {
            // initiate output 
            $icon_symbol = '';
            // initiate svg elements 
            $svg_elems = '';
            if ( 'ui-icons' === $group && isset( self::$ui_icons[ $name ] ) ) {
                $svg_elems .= self::$ui_icons[ $name ];
            } else {
                if ( isset( self::$social_icons[ $name ] ) ) {
                    $svg_elems .= self::$social_icons[ $name ];
                }
            }
            // build symbol if we got svg elements
            if ( ! empty( $svg_elems ) ) {
                $icon_symbol .= '<symbol id="' . esc_attr( $name ) . '-icon"';
                $icon_symbol .= ' viewBox="' . $args['view_box'] . '"';
                $icon_symbol .= ' stroke-width="' . $args['stroke_w'] . '"';
                $icon_symbol .= ' stroke="' . $args['stroke'] . '"';
                $icon_symbol .= ' fill="' . $args['fill'] . '"';
                $icon_symbol .= ' stroke-linecap="round" stroke-linejoin="round">' . "\n";
                // grab the svg element
                $icon_symbol .= $svg_elems . "\n";
                $icon_symbol .= '</symbol>';
            }
            // return icon symbol
            return $icon_symbol;
        }
        /**
         * Returns styles for the passed illustration name
         * 
         * @since 1.0
         * @param string $name      Name of illustration. Name should
         *                          exist in $illustration_styles 
         *                          property of the class.
         * @return string           List of style properties 
         *                          from the stored styles array 
         *                          for the passed illustration
         */
        public static function get_illustration_style( $name ) {
            if ( empty( $name ) || ! array_key_exists( $name, self::$illustration_styles ) ) {
                return;
            }
            // return styles
            return self::$illustration_styles[ $name ];
        }
        /**
         * Return svg element for illustration background. 
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $shape     SVG shape element. Default 'rectangle'
         * @param string $fill      Hexadecimal or valid color name for fill 
         *                          attribute. Default '#EAECEF'
         * @param string $shape     Hexadecimal or valid color name for stroke 
         *                          attribute. Default 'none'
         * @return mixed            SVG element to be used as background for 
         *                          illustration.
         */
        private static function get_illustration_bg( $shape = 'rectangle', $fill = '#EAECEF', $stroke = 'none' ) {
            $style = 'style="fill:' . $fill . '; stroke:' . $stroke . ';"';
            $bg_svg_el = '';
            switch ($shape) {
                case 'circle':
                    $bg_svg_el = '<circle cx="500" cy="500" r="500" ' . $style . ' />';
                    break;
                case 'ellipse':
                    $bg_svg_el = '<ellipse cx="500" cy="500" rx="500" ry="250" ' . $style . ' />';
                    break;
                default:
                    $bg_svg_el = '<rect width="1000" height="1000" ' . $style . ' />';
                    break;
            }
            // return bg
            return $bg_svg_el;
        }
        /**
         * Returns arguments ready for use in svg resources
         * 
         * @since 1.0
         * @param string/array  $args   Array or list of svg attributes
         *                              for <symbol> tag. Attributes are 
         *                              view_box, size. stroke_w, stroke, fill
         * @return array
         */
        public static function parse_icon_args( $args ) {
            if ( ! is_array( $args ) ) {
                $args = ( array ) $args;
            }
            // parse args
            $args = wp_parse_args(
                $args,
                array(
                    'view_box'      =>  '0 0 24 24',
                    'size'          =>  24,
                    'stroke_w'      =>  2,
                    'stroke'        =>  'currentColor',
                    'fill'          =>  'none',
                )
            );

            // converting to non-negative numbers
            $args['size'] = ! empty( $args['size'] ) ? absint( $args['size'] ) : 24;
            $args['stroke_w'] = ! empty( $args['stroke_w'] ) ? absint( $args['stroke_w'] ) : 2;

            // if view_box not set
            if ( empty( $args['view_box'] ) ) {
                $args['view_box'] = '0 0 ' . (string) $args['size'] . ' ' . (string) $args['size'];
            }

            // stroke and fill
            $args['stroke'] = ! empty( $args['stroke'] ) ? $args['stroke'] : 'currentColor';
            $args['fill'] = ! empty( $args['fill'] ) ? $args['fill'] : 'none';

            return $args;
        }

        /**
         * Returns arguments ready for use in illustration svg resources
         * 
         * @since 1.0
         * @param string/array  $args   Array or list of svg attributes
         *                              for <symbol> tag. Attributes are 
         *                              view_box, size, x, y, bg_shape, bg_stroke, bg_fill
         * @return array
         */
        public static function parse_illustration_args( $args ) {
            if ( ! is_array( $args ) ) {
                $args = ( array ) $args;
            }
            // parse args
            $args = wp_parse_args(
                $args,
                array(
                    'view_box'      =>  '0 0 1000 1000',
                    'size'          =>  1000,
                    'x'             =>  '0px',
                    'y'             =>  '0px',
                    'bg_shape'      =>  'rectangle',
                    'bg_stroke'     =>  'none',
                    'bg_fill'       =>  '#EAECEF',
                )
            );

            // converting to non-negative numbers
            $args['size'] = ! empty( $args['size'] ) ? absint( $args['size'] ) : 1000;
            $args['x'] = ! empty( $args['x'] ) ? $args['x'] : '0px';
            $args['y'] = ! empty( $args['y'] ) ? $args['y'] : '0px';

            // if view_box not set
            if ( empty( $args['view_box'] ) ) {
                $args['view_box'] = '0 0 ' . (string) $args['size'] . ' ' . (string) $args['size'];
            }

            // bg_shape, bg_stroke and bg_fill
            $args['bg_shape'] = ! empty( $args['bg_shape'] ) ? $args['bg_shape'] : 'rectangle';
            $args['bg_stroke'] = ! empty( $args['bg_stroke'] ) ? $args['bg_stroke'] : 'none';
            $args['bg_fill'] = ! empty( $args['bg_fill'] ) ? $args['bg_fill'] : '#EAECEF';

            return $args;
        }
    } // Class --ENDS 
}