<?php
/**
 * Class for building main site content area.
 * The class responsible to construct site content area 
 * between header and footer areas.
 * 
 * @package WonKode
 * @since 1.0
 */
// restricted from direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Site_Content_Area' ) ) {
    class WonKode_Site_Content_Area {
        /**
         * Theme identifier, namespace
         * 
         * @since 1.0
         * @var string 
         */
        public static $theme_id;
        /**
         * Unique prefix for naming 
         * filter and action hooks etc
         * 
         * @since 1.0
         * @var string
         */
        private static $unique_prefix;
        /**
         * Site content tag id
         * 
         * @since 1.0
         * @access private
         * @var string
         */
        private static $site_content_id = 'content';
        /**
         * Site content tag classes
         * 
         * @since 1.0
         * @var array
         */
        public static $site_content_classes = array( 'site-content' );
        /**
         * Site primary tag id
         * 
         * @since 1.0
         * @access private
         * @var string
         */
        private static $site_primary_id = 'primary';
        /**
         * Site primary tag classes
         * 
         * @since 1.0
         * @var array
         */
        public static $site_primary_classes = array( 'content-area' );
        /**
         * Site main tag id
         * 
         * @since 1.0
         * @access private
         * @var string
         */
        private static $site_main_id = 'main';
        /**
         * Site main tag classes
         * 
         * @since 1.0
         * @var array
         */
        public static $site_main_classes = array( 'site-main' );
        /**
         * Class constructor
         */
        public function __construct() {
            // setting theme identity
            $theme_obj = wp_get_theme();
            if ( $theme_obj->exists() ) {
                self::$theme_id = $theme_obj->get( 'TextDomain' );
            } else {
                self::$theme_id = get_stylesheet();
            }
            // setting unique prefix
            self::$unique_prefix = strtolower( str_replace( '-', '_', self::$theme_id ) );
        }
        /**
         * Adds new classes to existing ones
         * 
         * @access private
         * 
         * @since 1.0
         * @param string/array $new_classes List of class to add
         * @param array &$class existing class
         * @return void
         */
        private static function add_to_classes( $new_classes, &$class ) {
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
                    $class[] = $cls;
                }
            }
        }
        /**
         * Adds new classes to self::$site_content_classes
         * 
         * @since 1.0
         * @param string/array $new_classes List of new classes
         * @return void
         */
        public static function add_site_content_classes( $new_classes ) {
            self::add_to_classes( $new_classes, self::$site_content_classes );
        }
        /**
         * Adds new classes to self::$site_primary_classes
         * 
         * @since 1.0
         * @param string/array $new_classes List of new classes
         * @return void
         */
        public static function add_site_primary_classes( $new_classes ) {
            self::add_to_classes( $new_classes, self::$site_primary_classes );
        }
        /**
         * Adds new classes to self::$site_main_classes
         * 
         * @since 1.0
         * @param string/array $new_classes List of new classes
         * @return void
         */
        public static function add_site_main_classes( $new_classes ) {
            self::add_to_classes( $new_classes, self::$site_main_classes );
        }
        /**
         * Opens site content area wrappers
         * 
         * @since 1.0
         */
        public static function open_wrappers() {
            // preparing classes
            $content_class_list = WonKode_Helper::list_classes( self::$site_content_classes );
            $primary_class_list = WonKode_Helper::list_classes( self::$site_primary_classes );
            $main_class_list = WonKode_Helper::list_classes( self::$site_main_classes );
            echo '
            <div id="' . esc_attr( self::$site_content_id ) . '" class="' . esc_attr( $content_class_list ) . '">
                <div id="' . esc_attr( self::$site_primary_id ) . '" class="' . esc_attr( $primary_class_list ) . '">
                    <main id="' . esc_attr( self::$site_main_id ) . '" class="' . esc_attr( $main_class_list ) . '">
            ';
        }
        /**
         * Closes site content area wrappers
         * 
         * @since 1.0
         */
        public static function close_wrappers() {
            $main_id = self::$site_main_id;
            echo '
                    </main><!-- #' . self::$site_main_id . ' -->
                </div><!-- #' . self::$site_primary_id . ' -->
            </div><!-- #' . self::$site_content_id . ' -->
            ';
        }
        /**
         * Returns outer container opening tag for main content area
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return mixed outer container html tag with class attributes
         */
        public static function get_outer_container_opener( $additional_class = '' ) {
            $class_arr = array();
            // container classes from customizer
            $class_arr[] = get_theme_mod( self::$unique_prefix . '_outer_container_bs_class', WK_DEFAULTS['_outer_container_bs_class'] );
            $mt = get_theme_mod( self::$unique_prefix . '_outer_container_margin_top', WK_DEFAULTS['_outer_container_margin_top'] );
            $mt_class = ! ( '' === $mt || 'unset' === $mt ) ? $mt : '';
            // add margin top class
            if ( ! empty( $mt_class ) ) {
                $class_arr[] = $mt_class;
            }
            $mb = get_theme_mod( self::$unique_prefix . '_outer_container_margin_bottom', WK_DEFAULTS['_outer_container_margin_bottom'] );
            $mb_class = ! ( '' === $mb || 'unset' === $mb ) ? $mb : '';
            // add margin bottom class
            if ( ! empty( $mb_class ) ) {
                $class_arr[] = $mb_class;
            }
            // if additional class passed
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $class_arr );
            }
            // get classes for outer container
            $class_list = WonKode_Helper::list_classes( $class_arr );
            /**
             * Filters class list for outer container
             * 
             * @since 1.0
             * @param string $class_list    List of classes for outer container
             * @param array $class_arr      Array of classes to filter class output
             */
            $class_list = apply_filters( self::$unique_prefix . '_outer_container_classes', $class_list, $class_arr );
            // return the outer container
            return '<div class="' . esc_attr( $class_list ) . '">';
        }
        /**
         * Renders outer container opening tag for main content area
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return void
         */
        public static function open_outer_container( $additional_class = '' ) {
            echo self::get_outer_container_opener( $additional_class );
        }
        /**
         * Renders outer container closing tag 
         * for the main content area
         * 
         * @since 1.0
         * @return void
         */
        public static function close_outer_container() {
            echo '</div>';
        }
        /**
         * Returns inner container opening tag
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return mixed inner container html tag with class attributes
         */
        public static function get_inner_container_opener( $additional_class = '' ) {
            $class_arr = array();
            // container classes from customizer
            $class_arr[] = get_theme_mod( self::$unique_prefix . '_inner_container_bs_class', WK_DEFAULTS['_inner_container_bs_class'] );
            // if additional class passed
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $class_arr );
            }
            // get classes for inner container
            $class_list = WonKode_Helper::list_classes( $class_arr );
            /**
             * Filters class list for inner container
             * 
             * @since 1.0
             * @param string $class_list    List of classes for inner container
             * @param array $class_arr      Array of classes to filter class output
             */
            $class_list = apply_filters( self::$unique_prefix . '_inner_container_classes', $class_list, $class_arr );
            // return the inner container
            return '<div class="' . esc_attr( $class_list ) . '">';
        }
        /**
         * Renders inner container opening tag for main content area
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return void
         */
        public static function open_inner_container( $additional_class = '' ) {
            echo self::get_inner_container_opener( $additional_class );
        }
        /**
         * Renders inner container closing tag 
         * for the main content area
         * 
         * @since 1.0
         * @return void
         */
        public static function close_inner_container() {
            echo '</div>';
        }
        /**
         * Returns posts content wrapping row opening tag
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return mixed posts content wrapping row html tag with class attributes
         */
        public static function get_content_wrapper_row_opener( $additional_class = '' ) {
            $row_classes_arr = array( 'row' );
            // if additional class passed
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $row_classes_arr );
            }
            // get all row classes
            $row_classes_list = WonKode_Helper::list_classes( $row_classes_arr );
            /**
             * Filters class list for posts content wrapper row
             * 
             * @since 1.0
             * @param string $row_classes_list    List of classes for row
             * @param array $row_classes_arr      Array of classes to filter class output
             */
            $row_classes_list = apply_filters( self::$unique_prefix . '_content_wrapper_row_classes', $row_classes_list, $row_classes_arr );
            // return content wrapping row
            return '<div class="' . esc_attr( $row_classes_list ) . '">';
        }
        /**
         * Renders post content wrapper's opening tag 
         * in the main content area
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return void
         */
        public static function open_content_wrapper_row( $additional_class = '' ) {
            echo self::get_content_wrapper_row_opener( $additional_class );
        }
        /**
         * Renders post content wrapper's closing tag 
         * in the main content area
         * 
         * @since 1.0
         * @return void
         */
        public static function close_content_wrapper_row() {
            echo '</div>';
        }
        /**
         * Returns sidebar position set in customizer.
         * 
         * @since 1.0
         * @return string position of sidebar
         */
        public static function get_sidebar_position() {
            return get_theme_mod( self::$unique_prefix . '_sidebar_position', WK_DEFAULTS['_sidebar_position'] );
        }
        /**
         * Checks if 'left' is set for a single sidebar. 
         * Sidebar will be displayed on left side of page 
         * if true.
         * 
         * @since 1.0
         * @return bool true if sidebar is left
         */
        public static function sidebar_is_left() {
            return 'left' === self::get_sidebar_position();
        }
        /**
         * Checks if 'right' is set for a single sidebar. 
         * Sidebar will be displayed on right side of page 
         * if true.
         * 
         * @since 1.0
         * @return bool true if sidebar is right
         */
        public static function sidebar_is_right() {
            return 'right' === self::get_sidebar_position();
        }
        /**
         * Checks if 'both' is set as sidebar position 
         * in theme customizer. Sidebar will be displayed 
         * both on right and left of page if true.
         * 
         * @since 1.0
         * @return bool true if sidebar is both
         */
        public static function sidebar_is_both() {
            return 'both' === self::get_sidebar_position();
        }
        /**
         * Checks if 'none' is set as sidebar position 
         * in theme customizer. No sidebar will be displayed 
         * if true.
         * 
         * @since 1.0
         * @return bool true if sidebar is none
         */
        public static function sidebar_is_none() {
            return 'none' === self::get_sidebar_position();
        }
        /**
         * Returns number of columns of sidebar. 
         * Used to determine Bootstrap grid column 
         * classes at different breakpoints. Will be 
         * also important to determine class of 
         * post listing column of page.
         * 
         * @access private 
         * 
         * @since 1.0
         * @param string $mod_id    Identifier for theme mod setting
         * @return int Number of cols
         */
        private static function get_sidebar_cols( $mod_id ) {
            return intval( get_theme_mod( self::$unique_prefix . $mod_id, WK_DEFAULTS[ $mod_id ] ) );
        }
        /**
         * Returns opening tag for single primary sidebar. 
         * Used when sidebar position is set either 'right' or 
         * 'left' in layout customizer of theme.
         * 
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes for sidebar
         *                                          Defaults ''
         * @return mixed Sidebar html tag
         */
        public static function get_single_primary_sidebar_opener( $additional_class = '' ) {
            $sidebar_classes_arr = array();
            // cols on medium size device width
            $cols_md = self::get_sidebar_cols( '_single_sidebar_col_size_md' );
            $sidebar_classes_arr[] = 'col-md-' . $cols_md;
            // cols on large size device width
            $cols_lg = self::get_sidebar_cols( '_single_sidebar_col_size_lg' );
            $sidebar_classes_arr[] = 'col-lg-' . $cols_lg;
            // adding classes if given
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $sidebar_classes_arr );
            }
            // get classes for sidebar
            $sidebar_class_list = WonKode_Helper::list_classes( $sidebar_classes_arr );
            /**
             * Filters class list for sidebar
             * 
             * @since 1.0
             * @param string $sidebar_class_list      List of classes for sidebar
             * @param array $sidebar_classes_arr      Array of classes to filter class output
             */
            $sidebar_class_list = apply_filters( self::$unique_prefix . '_single_sidebar_classes', $sidebar_class_list, $sidebar_classes_arr );
            // return sidebar opening tag
            return '<div class="' . esc_attr( $sidebar_class_list ) . '">';
        }
        //--------------------------double sidebar-----------------------------------------
        /**
         * Returns opening tag for left sidebar, 
         * for double sidebar, or when sidebar position 
         * is set 'both' in customizer. 
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes for 
         *                                          left sidebar. Defaults ''
         * @return mixed Sidebar html tag
         */
        public static function get_double_sidebar_left_opener( $additional_class = '' ) {
            $left_sidebar_classes_arr = array();
            // cols for md breakpoints
            $cols_md_left = self::get_sidebar_cols( '_double_sidebar_left_col_size_md' );
            $left_sidebar_classes_arr[] = 'col-md-' . $cols_md_left;
            // cols for lg breakpoints
            $cols_lg_left = self::get_sidebar_cols( '_double_sidebar_left_col_size_lg' );
            $left_sidebar_classes_arr[] = 'col-lg-' . $cols_lg_left;
            // when additional classes are given
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $left_sidebar_classes_arr );
            }
            // get class list ready
            $left_sidebar_classes = WonKode_Helper::list_classes( $left_sidebar_classes_arr );
            // return left sidebar opening
            return '<div class="' . esc_attr( $left_sidebar_classes ) . '">';
        }
        /**
         * Returns opening tag for right sidebar, 
         * for double sidebar, or when sidebar position 
         * is set 'both' in customizer. 
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes for 
         *                                          right sidebar. Defaults ''
         * @return mixed Sidebar html tag
         */
        public static function get_double_sidebar_right_opener( $additional_class = '' ) {
            $right_sidebar_classes_arr = array();
            // cols for md breakpoints
            $cols_md_right = self::get_sidebar_cols( '_double_sidebar_right_col_size_md' );
            $right_sidebar_classes_arr[] = 'col-md-' . $cols_md_right;
            // cols for lg breakpoints
            $cols_lg_right = self::get_sidebar_cols( '_double_sidebar_right_col_size_lg' );
            $right_sidebar_classes_arr[] = 'col-lg-' . $cols_lg_right;
            // when additional classes are given
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $right_sidebar_classes_arr );
            }
            // get class list ready
            $right_sidebar_classes = WonKode_Helper::list_classes( $right_sidebar_classes_arr );
            // return right sidebar opening
            return '<div class="' . esc_attr( $right_sidebar_classes ) . '">';
        }
        
        //--------------------------double sidebar-----------------------------------------
        

        // -------------------------Generic for left and right sidebar---------------------
        /**
         * Renders primary sidebar opening tag, on right side when 
         * position is set 'right', on left side when position is set 
         * 'left'. When sidebar position is set 'both', primary sidebar 
         * is displayed on right side.
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes for 
         *                                          primary sidebar. Defaults ''
         * @return void
         */
        public static function open_primary_sidebar( $additional_class = '' ) {
            // primary sidebar is positioned 'left' or 'right'
            if ( self::sidebar_is_right() || self::sidebar_is_left() ) {
                echo self::get_single_primary_sidebar_opener( $additional_class );
            // when both sidebar is selected
            } elseif ( self::sidebar_is_both() ) {
                echo self::get_double_sidebar_right_opener( $additional_class );
            } else {
                echo '';
            }
        }
        /**
         * Renders div closing tag for 
         * primary sidebar
         * 
         * @since 1.0
         * @return void
         */
        public static function close_primary_sidebar() {
            echo '</div>';
        }
        /**
         * Renders secondary sidebar opening tag, on left   
         * when sidebar position is set 'both' 
         * in customizer.
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes for 
         *                                          secondary sidebar. Defaults ''
         * @return void
         */
        public static function open_secondary_sidebar( $additional_class = '' ) {
            // only when both sidebar is activated
            if ( self::sidebar_is_both() ) {
                echo self::get_double_sidebar_left_opener( $additional_class );
            } else {
                echo '';
            }
        }
        /**
         * Renders div closing tag for 
         * secondary sidebar
         * 
         * @since 1.0
         * @return void
         */
        public static function close_secondary_sidebar() {
            echo '</div>';
        }
        // -------------------------Generic for left and right sidebar---------------------
        /**
         * Returns opening tag for main column 
         * that holds post contents
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes 
         *                                          for main content column.
         *                                          Defaults ''
         * @return mixed main content column html tag
         */
        public static function get_main_post_col_opener( $additional_class = '' ) {
            $main_col_classes_arr = array();
            if ( self::sidebar_is_left() || self::sidebar_is_right() ) {
                // number of md cols
                $cols_md = 12 - self::get_sidebar_cols( '_single_sidebar_col_size_md' );
                $main_col_classes_arr[] = 'col-md-' . $cols_md;
                // number of lg cols
                $cols_lg = 12 - self::get_sidebar_cols( '_single_sidebar_col_size_lg' );
                $main_col_classes_arr[] = 'col-lg-' . $cols_lg;
            } elseif ( self::sidebar_is_both() ) {
                // cols for md
                $cols_md = 12 - ( self::get_sidebar_cols( '_double_sidebar_left_col_size_md' ) + self::get_sidebar_cols( '_double_sidebar_right_col_size_md' ) );
                $main_col_classes_arr[] = 'col-md-' . $cols_md;
                // cols for lg
                $cols_lg = 12 - ( self::get_sidebar_cols( '_double_sidebar_left_col_size_lg' ) + self::get_sidebar_cols( '_double_sidebar_right_col_size_lg' ) );
                $main_col_classes_arr[] = 'col-lg-' . $cols_lg;
            } else {
                $main_col_classes_arr[] = 'col-12';
            }
            // adding classes if given
            if ( ! empty( $additional_class ) ) {
                self::add_to_classes( $additional_class, $main_col_classes_arr );
            }
            // get classes for content column
            $main_col_classes = WonKode_Helper::list_classes( $main_col_classes_arr );
            /**
             * Filters class list for main col
             * 
             * @since 1.0
             * @param string $main_col_classes      List of classes for main col
             * @param array $main_col_classes_arr        Array of classes to filter class output
             */
            $main_col_classes = apply_filters( self::$unique_prefix . '_main_col_classes', $main_col_classes, $main_col_classes_arr );
            // return the content column
            return '<div class="' . esc_attr( $main_col_classes ) . '">';
        }
        /**
         * Renders main content column opening tag
         * 
         * @since 1.0
         * @param string/array $additional_class    Additional classes. Defaults ''
         * @return void
         */
        public static function open_main_post_col( $additional_class = '' ) {
            echo self::get_main_post_col_opener( $additional_class );
        }
        /**
         * Renders div closing tag for 
         * main posts column
         * 
         * @since 1.0
         * @return void
         */
        public static function close_main_post_col() {
            echo '</div>';
        }
        /**
         * Renders div closing tag
         * 
         * @since 1.0
         * @return void
         */
        public static function close_div_tag() {
            echo '</div>';
        }
    } // ENDS --- class
}
new WonKode_Site_Content_Area;