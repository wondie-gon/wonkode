<?php
/**
 * Custom image checkbox control
 * 
 * @package WonKode
 * @since 1.0 
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( class_exists( 'WP_Customize_Control' ) ) {
    class WonKode_Image_Checkbox_Custom_Control extends WP_Customize_Control {
        /**
         * The type of control being rendered
         */
        public $type = 'wonkode_image_checkbox';
        /**
         * Enqueue our scripts and styles
         */
        public function enqueue() {
            wp_enqueue_style( 'wonkode-image-checkbox', WK_CUSTOM_CONTROLS_URL . '/image-checkbox/image-checkbox.css', array(), '1.0', 'all' );
        }

        /**
         * Refresh the parameters passed to the JavaScript via JSON.
         *
         * @since 1.0
         * @uses WP_Customize_Control::json()
         * @return array Array of parameters passed to the JavaScript
         */
        public function json() {

            $json = parent::json();

            $value = $this->value();

            if ( $this->setting->default ) {
                $json['defaultValue']     = $this->setting->default;
            }

            // set selected values
            if ( $value && $json['defaultValue'] && $value === $json['defaultValue'] ) {
                $json['selectedValues'] = $json['defaultValue'];
            } elseif ( $value ) {
                $json['selectedValues'] = $value;
            }

            $json['link']             = $this->get_link();

            return $json;
        }

        /**
         * Render the control in the customizer
         */
        public function render_content() {}

        /**
         * Render a JS template for the content of the image checkbox control.
         */
        public function content_template() {
            ?>
            <#
                var fieldID = _.uniqueId( '_customize-input-image-checkbox-' );
                var descriptionID = _.uniqueId( 'description-image-checkbox-' );
            #>
            <div id="image-checkbox-control-{{data.id}}" class="wonkode_image_checkbox_control">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span id="{{ descriptionID }}" class="customize-control-description">{{{ data.description }}}</span>
                <# } #>
                <#
                    var checkboxVals = data.selectedValues.split( ',' );

                    var checked = function( item, arr ) {
                        for ( var i = 0; i < a.length; i++ ) {
                            if ( arr[i] === item ) {
                                return "checked";
                            } else {
                                return "";
                            }
                        }
                    };
                #>
                <input type="hidden" id="{{ fieldID }}" value="{{ data.selectedValues }}" class="customize-control-multi-image-checkbox" {{{ data.link }}} />

                <# _.each( data.choices, function( key, val ) {
                    var value, image, name;
                    value = key;
                    if ( _.isObject( val ) ) {
                        image = val.image;
                        name = val.name;
                    }
                #>
                    <label class="checkbox-label">
                        <input type="checkbox" id="{{ fieldID + '-' + value }}" value="{{ value }}" {{ checked( value, checkboxVals ); }} class="multi-image-checkbox"/>
                        <img src="{{ image }}" alt="{{ name }}" title="{{ name }}" />
                    </label>
                <# } ); #>
            </div>
            <?php
        }
    }
}