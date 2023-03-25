<?php 
/**
 * Class for custom frontpage sections templates
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if ( ! class_exists( 'WonKode_Frontpage_Customize_Builder' ) ) {
  class WonKode_Frontpage_Customize_Builder extends WonKode_UI_Components {
    /**
     * Customize defaults
     * 
     * @since 1.0
     * @var array
     */
    public static $defaults = WK_DEFAULTS;
    /**
     * Class constructor
     */
    public function __construct() {
      // constructor of parent class
      parent::__construct();
    }

    /**
     * Returns page separator section title
     * 
     * @since 1.0
     * @param string $section_title       Section title.
     * @param string $wrapper_classes Additional classes for section title 
     *                                wrapper, string separated by space.
     * @return html/mixed Section title html.
     */
    public static function get_section_title_block( $section_title, $wrapper_classes = '' ) {
      if ( empty( $section_title ) ) {
        return '';
      }
      // wrapper class
      $wrapper_classes = WonKode_Helper::list_classes( 'section-title-wrapper', $wrapper_classes );
      // html output
      $html = '<div class="' . esc_attr( $wrapper_classes ) . '">';
      $html .= '<div class="b4-title-shape"></div>';
      $html .= sprintf( 
                '<h1 class="page-section-title">%s</h1>',
                sprintf( esc_html__( '%s', self::$txt_dom ), $section_title )
              );
      $html .= '</div>';
      return $html;
    }

    /**
     * Returns front section wrapper opening tag.
     * 
     * @since 1.0
     * @param string|array $new_classes List of class to add. Defaults: ''
     * @param string $id                Value for id attribute for card.
     *                                  Defaults: ''
     * @return mixed Section wrapper opening html tag with class attributes
     */
    public static function get_front_section_opened( $new_classes = '', $id = '' ) {
      $class_arr = array();
      // container classes from customizer
      $class_arr[] = get_theme_mod( self::$unique_prefix . '_inner_container_bs_class', self::$defaults['_inner_container_bs_class'] );

      // return section wrapper opening tag
      return self::get_div_open( $new_classes, $class_arr, $id );
    }
    /**
     * Returns front section wrapper closing tag.
     * 
     * @since 1.0
     * @return mixed HTML div closing.
     */
    public static function get_front_section_closed() {
      return self::get_div_close();
    }

  } // END --- class
}