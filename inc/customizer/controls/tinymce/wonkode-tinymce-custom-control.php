<?php
/**
 * Custom TinyMCE control
 * 
 * @package WonKode
 * @since 1.0 
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WonKode_TinyMCE_Custom_Control extends WP_Customize_Control {
    /**
     * The type of control being rendered
     */
    public $type = 'wonkode_tinymce';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue() {
        wp_enqueue_style( 'wonkode-tinymce', WK_CUSTOM_CONTROLS_URL . '/tinymce/tinymce.css', array(), '1.0', 'all' );
        wp_enqueue_script( 'wonkode-tinymce', WK_CUSTOM_CONTROLS_URL . '/tinymce/tinymce.js', array( 'jquery' ), '1.0', true );
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

        $json['wonkodetinymce_toolbar1'] = isset( $this->input_attrs['toolbar1'] ) ? esc_attr( $this->input_attrs['toolbar1'] ) : 'bold italic bullist numlist alignleft aligncenter alignright link';
        $json['wonkodetinymce_toolbar2'] = isset( $this->input_attrs['toolbar2'] ) ? esc_attr( $this->input_attrs['toolbar2'] ) : '';
        $json['wonkodetinymce_mediabuttons'] = isset( $this->input_attrs['mediaButtons'] ) && ( $this->input_attrs['mediaButtons'] === true ) ? true : false;

        $json['value'] = $this->value();

        $json['link'] = $this->get_link();

        return $json;
    }
    /**
     * Render the control in the customizer
     */
    public function render_content(){
        ?>
            
        <?php
    }

    /**
     * Render a JS template for the content of the image checkbox control.
     */
    public function content_template() {
        ?>
        <#
            var tinymceControlID = _.uniqueId( 'customize-control-tinymce-' );
            var descriptionID = _.uniqueId( 'description-tinymce-' );
            var textAreaID = data.id;

            var tinymcetoolbar1Str = data.wonkodetinymce_toolbar1;
            var tinymcetoolbar2Str = data.wonkodetinymce_toolbar2;
            var tinymcetoolbarMediaBtnsStr = data.wonkodetinymce_mediabuttons;
        #>
        <div id="{{ tinymceControlID }}" class="tinymce-control">
            <# if ( data.label ) { #>
                <label class="customize-control-title">{{{ data.label }}}</label>
            <# } #>
            <# if ( data.description ) { #>
                <span id="{{ descriptionID }}" class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <textarea id="{{ data.id }}" class="customize-control-tinymce-editor" {{ data.link }}>{{{ data.value }}}</textarea>
        </div>
        <#
            wp.editor.initialize( textAreaID, {
                tinymce: {
                    wpautop: true,
                    toolbar1: tinymcetoolbar1Str,
                    toolbar2: tinymcetoolbar2Str
                },
                quicktags: true,
                mediaButtons: tinymcetoolbarMediaBtnsStr
            });
        #>
        <?php
    }
} // ENDS -- class