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
         */
        public static function get_div_open( $new_classes = '', &$old_classes = array(), $id = '' ) {
            // add to existing classes
            if ( ! empty( $new_classes ) ) {
                self::add_to_classes( $new_classes, $old_classes );
            }
            // get list of classes string
            $class_list = WonKode_Helper::list_classes( $old_classes );
            // start html output
            $html = '<div';
            $html .= ! empty( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
            $html .= ! empty( $class_list ) ? ' class="' . esc_attr( $class_list ) . '"' : '';
            $html .= '>';
            // return the tag
            return $html;
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
                return '</' . esc_attr( $tagname ) . '>';
            }
            return '</div>';
        }

    } // ENDS -- class
}