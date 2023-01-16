<?php
/**
 * Base abstract class for customize feature
 * 
 * Defines important methods for subclasses
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ======JUST FOR REFERENCE ON SECTION's PRIORITY======
 * Site Title & Tagline  		title_tagline  		20
 * Colors  					    colors  			40
 * Header Image  				header_image  		60
 * Background Image  			background_image  	80
 * Menus (Panel)  				nav_menus  			100
 * Widgets (Panel)  			widgets  			110
 * Static Front Page  			static_front_page  	120
 * default											160
 * Additional CSS  custom_css  					    200
*/

abstract class WonKode_Customize_Base {
    /**
     * Theme identifier, namespace
     * 
     * @since 1.0
     * @access protected
     * @var string 
     */
    protected $theme_id;
    /**
     * Unique id for prefix
     * 
     * @access protected
     * 
     * @since 1.0
     * @var string
     */
    protected $prefix_id;
    /**
     * Class constructor
     * 
     * @since 1.0
     */
    public function __construct() {
        // setting theme identity
        $theme_obj = wp_get_theme();
        if ( $theme_obj->exists() ) {
            $this->theme_id = $theme_obj->get( 'TextDomain' );
        } else {
            $this->theme_id = get_stylesheet();
        }
        // setting unique prefix
        $this->prefix_id = strtolower( str_replace( '-', '_', $this->theme_id ) );
    }
    /**
     * Abstract method to register customizer
     * 
     * @since 1.0
     * @param \WP_Customize_Manager $wp_customize Customizer object reference.
     * @return void
     */
    abstract public function register( $wp_customize );
    /**
     * This will generate a line of CSS for use in header output. If the setting 
     * ($setting_id) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod() 
     * @param string $selector CSS selector 
     * @param string $css_property The name of the CSS *property* to modify 
     * @param string $setting_id The name of the 'theme_mod' option to fetch 
     * @param string $val_prefix Optional. Anything that needs to be output before the CSS property
     *                                     For example, '#' for color hexadeximal values
     * @param string $val_postfix Optional. Anything that needs to be output after the CSS property
     *                                      For example, '! important' 
     * @param bool $echo Optional. Whether to print directly to the page (default: true). 
     * @return string Returns a single line of CSS with selectors and a property.
     */
    public function generate_css( $selector, $css_property, $setting_id, $val_prefix = '', $val_postfix = '', $echo = true ) {
        $css_output = '';
        $mod_value = get_theme_mod( $setting_id );

        if ( ! empty( $mod_value ) ) {
            $prop_val = $mod_value . $val_postfix;
            $css_output = sprintf( '%s { %s: %s }', 
                $selector, 
                $css_property,
                // $val_prefix . $mod_value . $val_postfix
                str_starts_with( $val_prefix, $prop_val ) ? $prop_val : $val_prefix . $prop_val
            );
            if ( $echo ) {
                echo $css_output;
            }
        }
        return $css_output;
    }

    /**
     * Helper method returns url to customizer assets directory
     * 
     * @since 1.0
     * @return string url to customizer assets url
     */
    public function get_customizer_assets_uri() {
        return get_template_directory_uri() . '/inc/customizer/assets';
    }

    /**
     * Helper method to enqueue JavaScript for the live settings preview
     * 
     * @since 1.0
     * @return void
     */
    public function enqueue_preview_js( $handle_name, $js_file ) {
        // get file info
        $script_file_info = pathinfo( $js_file );
        // check for validity
        if ( ! empty( $handle_name ) && ! empty( $js_file ) && ( 'js' === $script_file_info['extension'] ) ) {
            $script_file_name = $script_file_info['basename'];
            if ( ! file_exists( get_template_directory() . '/inc/customizer/assets/js/' . $script_file_name ) ) {
                if ( file_exists( get_template_directory() . '/assets/js/' . $script_file_name ) ) {
                    wp_enqueue_script( $this->theme_id . '-' . $handle_name, get_template_directory_uri() . '/assets/js/' . $script_file_name, array( 'jquery', 'customize-preview' ), false, true );
                }
            } else {
                wp_enqueue_script( $this->theme_id . '-' . $handle_name, get_template_directory_uri() . '/inc/customizer/assets/js/' . $script_file_name, array( 'jquery', 'customize-preview' ), false, true );
            }
        }
    }
} // ENDS -- abstract class