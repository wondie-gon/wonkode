<?php
/**
 * Support for custom Contact Form 7
 * 
 * @package WonKode
 * @since 1.0
 */
// deny direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// include plugin
if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * Adding custom form tag for user subscription form 
 * to contact form 7. 
 */
if ( wonkode_is_wpcf7_active() ) {
    add_action( 'wpcf7_init', 'wonkode_wpcf7_add_subscription_form_tag' );
}
if ( ! function_exists( 'wonkode_wpcf7_add_subscription_form_tag' ) ) {
    /**
     * Custom function to register form tag handler 
     * for custom subscription form. 
     * @uses Contact Form 7 wpcf7_add_form_tag() function
     * 
     * @since 1.0
     * @return void
     */
    function wonkode_wpcf7_add_subscription_form_tag() {
        if ( function_exists( 'wpcf7_add_form_tag' ) ) {
            wpcf7_add_form_tag( 
                'wonkode_subscription_form', 
                'wonkode_wpcf7_add_subscription_form_tag_handler', 
                array( 'name-attr' => true ) 
            );
        }
    }
}

/**
 * Callback function that handles subscription form tag
 */
if ( ! function_exists( 'wonkode_wpcf7_add_subscription_form_tag_handler' ) ) {
    /**
     * Defines handler for 'wonkode_subscription_form' form tag
     * 
     * @since 1.0
     * @return string/mixed HTML that replaces 'wonkode_subscription_form' 
     *                      form tag
     */
    function wonkode_wpcf7_add_subscription_form_tag_handler( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $sub_email_identifier = $tag->name . '-email';
        $sub_email_label = __( 'Email', WK_TXTDOM );
        $sub_email = sprintf( 
            '<div class="col-auto mb-2 mb-md-0">
                <label for="%1$s" class="visually-hidden">%2$s</label>
                <input %3$s>
            </div>',
            esc_attr( $sub_email_identifier ),
            esc_html( $sub_email_label ),
            wpcf7_format_atts( 
                array(
                    'type'          => 'email',
                    'id'            =>  esc_attr( $sub_email_identifier ),
                    'name'          =>  esc_attr( $sub_email_identifier ),
                    'class'         =>  'form-control',
                    'placeholder'   =>  'youremail@example.com',
                    'required'      =>  true,
                ) 
            ),
        );

        $sub_button_label = __( 'Subscribe', WK_TXTDOM );
        $sub_button = sprintf(
            '<div class="col-auto">
                <button %1$s>%2$s</button>
            </div>',
            wpcf7_format_atts( 
                array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ) 
            ),
            esc_html( $sub_button_label )
        );

        return sprintf( 
            '<div class="row g-3">%1$s %2$s</div>',
            $sub_email,
            $sub_button
        );
    }
}