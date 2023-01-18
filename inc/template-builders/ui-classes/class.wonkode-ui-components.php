<?php
/**
 * Class for building UI components
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_UI_Components' ) ) {
    class WonKode_UI_Components {
        /**
         * Theme identifier, text domain
         * 
         * @since 1.0
         * @var string 
         */
        public static $txt_dom;
        /**
         * Unique prefix for naming 
         * filter and action hooks etc
         * 
         * @since 1.0
         * @var string
         */
        public static $unique_prefix;
        /**
         * Default array of arguments for number of 
         * columns in each breakpoints.
         * This will be used to set a responsive 
         * Bootstrap class for columns inside row 
         * wrapper. 
         * 
         * Here decide how many columns is 
         * needed in each breakpoint. 
         * 
         * $col_defaults = array(
         *  Defaults 'xs_cols' to 1 column
         *   @type int/string   'xs_cols'   =>  '1', // # of columns in device width <576px
         *   @type int/string   'sm_cols'   =>  '', // width ≥576px
         *   @type int/string   'md_cols'   =>  '', // width ≥768px
         *   @type int/string   'lg_cols'   =>  '', // width ≥992px
         *   @type int/string   'xl_cols'   =>  '', // width ≥1200px
         *   @type int/string   'xxl_cols'  =>  '', // width ≥1400px
         * )
         * 
         * @since 1.0
         * @var array
         */
        public static $col_defaults = array(
            'xs_cols'   =>  '1',
            'sm_cols'   =>  '',
            'md_cols'   =>  '',
            'lg_cols'   =>  '',
            'xl_cols'   =>  '',
            'xxl_cols'  =>  '',
        );
        
        /**
         * Class constructor.
         * Sets text domain and unique prefix 
         * properties.
         * 
         * @since 1.0
         */
        public function __construct() {
            // set text domain
            self::$txt_dom = WonKode_Helper::get_texdomain();
            // set unique prefix
            self::$unique_prefix = WonKode_Helper::get_unique_prefix();
        }
        /**
         * Returns column class name for a breakpoint
         * 
         * @since 1.0
         * @param int|string $num_of_cols   Number of columns for a breakpoint
         * @param string $prefix            Column breakpoint class prefix
         * @return string Column class name for a breakpoint
         */
        private static function get_breakpoint_class( $num_of_cols, $prefix = 'col' ) {
            if ( ! $num_of_cols || empty( $num_of_cols ) ) {
                return;
            }
            // should be positive integer
            $num_of_cols = absint( $num_of_cols );
            $num_of_cols = $num_of_cols > 0 && $num_of_cols < 12 ? $num_of_cols : 12;
            // get class postfix
            $postfix = 12 / $num_of_cols;
            // get prefix ready
            $prefix = str_ends_with( $prefix, '-' ) ? $prefix : $prefix . '-';
            // return class name
            return $prefix . $postfix;
        }
        /**
         * Adds new classes to existing ones for 
         * an html element
         * 
         * @access private
         * 
         * @since 1.0
         * @param string/array $new_classes List of class to add.
         * @param array &$old_classes       Existing classes array. 
         *                                  Used to append additional 
         *                                  classes (passed by reference).
         * @return void
         */
        private static function add_to_classes( $new_classes, &$old_classes = array() ) {
            // empty class
            if ( empty( $new_classes ) ) {
                $class_list = '';
            } else {
                /**
                 * outputs space separated string 
                 * whether $new_classes is string or array
                 */
                $class_list = WonKode_Helper::list_classes( $new_classes );
                // string to array
                $class_list = explode( ' ', $class_list );
            }
            if ( ! empty( $class_list ) ) {
                foreach ( $class_list as $cls ) {
                    $old_classes[] = $cls;
                }
            }
            
        }
        /**
         * Returns an opening tag for a div element.
         * 
         * @since 1.0
         * @param string/array $new_classes List of class to add.
         * @param array $old_classes        Existing classes array. 
         *                                  Used to append additional 
         *                                  classes (passed by reference).
         * @param string $id                Value for id attribute for card.
         *                                  Defaults: ''
         * @param string $tagname           Name for html tag. Defaults: ''
         * @return mixed A div opening tag with passed attributes.
         */
        public static function get_html_elem_open( $new_classes = '', &$old_classes = array(), $id = '', $tagname = '' ) {
            // init element
            $html = '';
            // add to existing classes
            if ( ! empty( $new_classes ) ) {
                self::add_to_classes( $new_classes, $old_classes );
            }
            // get list of classes string
            $class_list = WonKode_Helper::list_classes( $old_classes );
            // clear $tagname from special chars
            $tagname = WonKode_Helper::tags_to_str( $tagname );
            // start html output
            $html .= ! empty( $tagname ) ? '<' . esc_attr( $tagname ) : '<div';
            $html .= ! empty( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
            $html .= ! empty( $class_list ) ? ' class="' . esc_attr( $class_list ) . '"' : '';
            $html .= '>';
            // return the tag
            return $html;
        }
        /**
         * Returns column html opening tag 
         * filled with its classes and id attribtes.
         * 
         * @since 1.0
         * @param array $args   {
         *  Array of arguments for column opening tag. Defaults []
         *      @type string       'tag_name'  html tag name. Defaults '',
         *      @type string       'id'        Value for id attribute. Defaults '',
         *      @type array        'classes'   Array of classes. Defaults empty,
         *      @type int/string   'xs_cols'   Number of columns at device width <576px.
         *      @type int/string   'sm_cols'   Number of columns at width ≥576px.
         *      @type int/string   'md_cols'   Number of columns at width ≥768px.
         *      @type int/string   'lg_cols'   Number of columns at width ≥992px.
         *      @type int/string   'xl_cols'   Number of columns at width ≥1200px.
         *      @type int/string   'xxl_cols'  Number of columns at width ≥1400px.
         * }
         * @return mixed HTML opening tag for column
         */
        public static function get_responsive_column_open( $args = array() ) {
            // column element defaults
            $defaults = array_merge(
                array(
                    'tag_name'  =>  '',
                    'id'        =>  '',
                    'classes'   =>  array(),
                ),
                self::$col_defaults
            );
            // more merging with user defined $args
            $args = wp_parse_args( $args, $defaults );
            // make sure $args['classes] is array
            $args['classes'] = is_array( $args['classes'] ) ? $args['classes'] : (array) $args['classes'];

            // breakpoint column classes
            // $col_classes = array();
            $col_classes_arr = self::get_col_classes( $args );
            $args['classes'] = array_merge( $args['classes'], $col_classes_arr );

            // get class list
            $col_class_list = WonKode_Helper::list_classes( $args['classes'] );
            
            // starting html tag output
            $html_out = '';
            $html_out .= ! empty( $args['tag_name'] ) ? '<' . esc_attr( $args['tag_name'] ) : '<div';
            $html_out .= ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : '';
            $html_out .= ! empty( $col_class_list ) ? ' class="' . esc_attr( $col_class_list ) . '"' : '';
            $html_out .= '>';

            return $html_out;
        }
        /**
         * Return array of classes for column tag
         * 
         * @since 1.0
         * @param array $args {
         *  Array of arguments for column tag. Defaults []
         *      @type int/string   'xs_cols'   Number of columns at device width <576px.
         *      @type int/string   'sm_cols'   Number of columns at width ≥576px.
         *      @type int/string   'md_cols'   Number of columns at width ≥768px.
         *      @type int/string   'lg_cols'   Number of columns at width ≥992px.
         *      @type int/string   'xl_cols'   Number of columns at width ≥1200px.
         *      @type int/string   'xxl_cols'  Number of columns at width ≥1400px.
         * }
         * @param array Classes array for a responsive column.
         */
        public static function get_col_classes( $args = array() ) {
            $col_classes_arr = array();
            $args = wp_parse_args( $args, self::$col_defaults );
            // adding col class for <576px device
            if ( ! empty( $args['xs_cols'] ) && absint( $args['xs_cols'] ) >= 0 ) {
                $col_classes_arr[] = self::get_breakpoint_class( $args['xs_cols'], 'col-' );
            }
            // adding col class for ≥576px device
            if ( ! empty( $args['sm_cols'] ) && absint( $args['sm_cols'] ) >= 0 ) {
                $col_classes_arr[] = self::get_breakpoint_class( $args['sm_cols'], 'col-sm-' );
            }
            // adding col class for ≥768px device
            if ( ! empty( $args['md_cols'] ) && absint( $args['md_cols'] ) >= 0 ) {
                $col_classes_arr[] = self::get_breakpoint_class( $args['md_cols'], 'col-md-' );
            }
            // adding col class for ≥992px device
            if ( ! empty( $args['lg_cols'] ) && absint( $args['lg_cols'] ) >= 0 ) {
                $col_classes_arr[] = self::get_breakpoint_class( $args['lg_cols'], 'col-lg-' );
            }
            // adding col class for ≥1200px device
            if ( ! empty( $args['xl_cols'] ) && absint( $args['xl_cols'] ) >= 0 ) {
                $col_classes_arr[] = self::get_breakpoint_class( $args['xl_cols'], 'col-xl-' );
            }
            // adding col class for ≥1400px device
            if ( ! empty( $args['xxl_cols'] ) && absint( $args['xxl_cols'] ) >= 0 ) {
                $col_classes_arr[] = self::get_breakpoint_class( $args['xxl_cols'], 'col-xxl-' );
            }

            return $col_classes_arr;
        }
        /**
         * Returns an opening tag for a div element.
         * 
         * @since 1.0
         * @param string/array $new_classes List of class to add.
         * @param array $old_classes        Existing classes array. 
         *                                  Used to append additional 
         *                                  classes (passed by reference).
         * @param string $id                Value for id attribute for card.
         *                                  Defaults: ''
         * @return mixed A div opening tag with passed attributes.
         */
        public static function get_div_open( $new_classes = '', &$old_classes = array(), $id = '' ) {
            /**
             * Get an html element opening tag using 
             * existing method, that returns a div opening tag
             * by default. 
             * @see self::get_html_elem_open( $new_classes, $old_classes, $id, '' ) 
             * for details.
             */
            $open_div = self::get_html_elem_open( $new_classes, $old_classes, $id );
            // return the tag
            return $open_div;
        }
        /**
         * Returns an opening tag for a div element with 
         * class attribute and inline styles if passed.
         * 
         * @since 1.0
         * @param string/array $new_classes List of class to add.
         * @param array $old_classes        Existing classes array. 
         *                                  Used to append additional 
         *                                  classes (passed by reference).
         * @param array $styles             Array of css properties.
         *                                  CSS properties with '-', such as 
         *                                  'background-color', their key 
         *                                  should be given with '_' like 
         *                                  'background_color' => '#fcfcfc'
         * @return mixed div opening tag with class and inline style.
         */
        public static function get_inline_styled_div_open( $new_classes = '', &$old_classes = array(), $styles = array() ) {
            // start html output
            $html_out = '<div';
            // add to existing classes
            if ( ! empty( $new_classes ) ) {
                self::add_to_classes( $new_classes, $old_classes );
            }
            // get list of classes string
            $class_list = WonKode_Helper::list_classes( $old_classes );
            // add class attribute
            $html_out .= ! empty( $class_list ) ? ' class="' . esc_attr( $class_list ) . '"' : '';
            // get styles ready
            $styles = array_filter( $styles, function( $v ) {
                return $v !== '';
            } );
            // start style attribute
            $inline_style = '';
            // go through styles
            if ( count( $styles ) >= 1 ) {
                $inline_style .= ' style="';
                $css_list = '';
                foreach ( $styles as $prop => $value ) {
                    // $property = str_replace( '_', '-', $prop );
                    /**
                     * keys with '_' are css properties with '-'
                     * For example: key name for css property 'background-color' 
                     * is passed with key 'background_color'
                     */
                    $css_list .= str_replace( '_', '-', $prop ) . ': ' . $value . '; ';
                }
                $inline_style .= rtrim( $css_list, ' ' );
                $inline_style .= '"';
            }
            // adding inline style
            $html_out .= $inline_style;
            $html_out .= '>';
            // return html
            return $html_out;
        }
        /**
         * Returns link anchor element <a></a> with 
         * all passed arguments.
         * 
         * @since 1.0
         * @param array $args = [
         *  Arguments for link anchor element. Defaults: []
         *      @type string 'id'	        Element id attribute. Defaults: '',
         *      @type string 'class'        Element class attribute. Defaults: '',
         *      @type string 'href'	        Element href attribute. Defaults: '',
         *      @type string 'target'	    Element target attribute. Defaults: '',
         *      @type string 'hreflang'	    Element hreflang attribute. Defaults: '',
         *      @type string 'title'	    Element title attribute. Defaults: '',
         *      @type string 'role'	        Element role attribute. Defaults: '',
         *      @type array  'data_attrs'	Array of data set attribute names 
         *                                  with value. Defaults:	[],
         *      @type array  'aria_attrs'	Array of aria attribute names with value. 
         *                                  Defaults:	[],
         *      @type bool   'downloadable'	Whether link is downloadable. 
         *                                  Defaults: false,
         *      @type string 'link_fa_icon'	Fontawesome icon class. Defaults: '',
         *      @type string 'link_text'    Link text. Defaults: '',
         * ]
         * @return html|string  Link with attributes, fontawesome icon, and text
         */
        public static function get_link_element( $args = array() ) {
            $defaults = array(
                'id'	        =>	'',
                'class'	        =>	'',
                'href'	        =>	'',
                'target'	    =>	'',
                'hreflang'	    =>	'',
                'title'	        =>	'',
                'role'	        =>	'',
                'data_attrs'	=>	array(),
                'aria_attrs'	=>	array(),
                'downloadable'	=>	false,
                'link_fa_icon'	=>	'',
                'link_text'	    =>	'',
            );
            // merging
            $args = wp_parse_args( $args, $defaults );

            // open link
            $a_html = '<a';
            // id attribute
            $a_html .= ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : '';
            // class attribute
            $a_html .= ! empty( $args['class'] ) ? ' class="' . WonKode_Helper::list_classes( $args['class'] ) . '"' : '';
            // href attribute
            $a_html .= ! empty( $args['href'] ) ? ' href="' . esc_url( $args['href'] ) . '"' : ' href="#"';
            // target attribute
            if ( ! empty( $args['target'] ) && in_array( $args['target'], array( '_self', '_parent', '_top', '_blank' ) ) ) {
                $a_html .= ' target="' . esc_attr( $args['target'] ) . '"';
            }
            // hreflang attribute
            $a_html .= ! empty( $args['hreflang'] ) ? ' hreflang="' . esc_attr( $args['hreflang'] ) . '"' : '';
            // role attribute
            $a_html .= ! empty( $args['role'] ) ? ' role="' . esc_attr( $args['role'] ) . '"' : '';
            // data_attrs attribute
            if ( ! empty( $args['data_attrs'] ) && is_array( $args['data_attrs'] ) ) {
                foreach ( $args['data_attrs'] as $data_key => $data_value ) {
                    $a_html .= ' data-' . $data_key . '="' . esc_attr( $data_value ) . '"';
                }
            }
            // aria_attrs attribute
            if ( ! empty( $args['aria_attrs'] ) && is_array( $args['aria_attrs'] ) ) {
                foreach ( $args['aria_attrs'] as $aria_key => $aria_value ) {
                    $a_html .= ' aria-' . $aria_key . '="' . esc_attr( $aria_value ) . '"';
                }
            }
            // download attribute
            $a_html .= $args['downloadable'] ? ' download' : '';
            $a_html .= '>';
            // get fontawesome icon
            $a_html .= ! empty( $args['link_fa_icon'] ) ? WonKode_Helper::get_fa_icon( $args['link_fa_icon'] ) : '';

            // text
            if ( ! empty( $args['link_text'] ) ) {
                $a_html .= sprintf(
                    // Translators: %s: link text
                    esc_html__( '%s', self::$txt_dom ),
                    $args['link_text']
                );
            }
            $a_html .= '</a>';
            // return html
            return $a_html;
        }
        /**
         * Returns img element. 
         * Nothing if src not passed.
         * 
         * @since 1.0
         * @param array $args [
         *      Arguments array. Defaults: []
         *          @type string        'src'      Image src. Defaults: ''
         *          @type string|array  'class'    Class for img. Defaults: ''
         *          @type string        'alt'      Image alt. Defaults: ''
         * ]
         * @return mixed image element.
         */
        public static function get_img_element( $args = array() ) {
            $defaults = array(
                'src'	=>	'',
                'class'	=>	'',
                'alt'	=>	'',
            );
            // merging
            $args = wp_parse_args( $args, $defaults );
            // if no image src
            if ( empty( $args['src'] ) ) {
                return;
            }
            $img = '<img src"' . esc_url( $args['src'] ) . '"';
            // class for image
            $img .= ! empty( $args['class'] ) ? ' class="' . WonKode_Helper::list_classes( $args['class'] ) . '"' : '';
            // alt attribute
            $img .= ! empty( $args['alt'] ) ? ' alt="' . esc_attr( $args['alt'] ) . '"' : '';
            $img .= '>';
            // return img element
            return $img;
        }
        /**
         * Returns closing tag of html element
         * 
         * @since 1.0
         * @param string $tagname html tag name to close.
         * @return mixed Closing tag of html element
         */
        public static function get_html_tag_close( $tagname = '' ) {
            if ( ! empty( $tagname ) ) {
                // clear $tagname
                $tagname = WonKode_Helper::tags_to_str( $tagname );
                return '</' . esc_attr( $tagname ) . '>';
            }
            return '</div>';
        }

    } // ENDS -- class
}