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
  class WonKode_Frontpage_Customize_Builder {
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
      // set text domain
      self::$txt_dom = WonKode_Helper::get_texdomain();
      // set unique prefix
      self::$unique_prefix = WonKode_Helper::get_unique_prefix();
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

  } // END --- class
}