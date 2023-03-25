<?php
/**
 * Class to customize WooCommerce featured products section 
 * to be displayed on any desired page, frontpage, etc. 
 * 
 * Applied only when WooCommerce is activated.
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// class for customization
if ( ! class_exists( 'WonKode_Customize_Woo_Featured_Products' ) ) {
    class WonKode_Customize_Woo_Featured_Products extends WonKode_Customize_Base {
        /**
         * Class constructor
         * 
         * @since 1.0
         */
        public function __construct() {
            parent::__construct();
            // register cusomizer
            add_action( 'customize_register', array( $this, 'register' ) );
        }
        /**
         * Register featured products block 
         * customizer section and settings.
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            /**
             * Section for featured products of woocommerce
             */
            $wp_customize->add_section(
                $this->prefix_id . '_woo_featured_products_section',
                array(
                    'priority'          =>  70, 
                    'title'             =>  esc_html__( 'WooCommerce Front Featured', $this->theme_id ), 
                    'description'       =>  esc_html__( 'Allows to customize woocommerce featured poducts block', $this->theme_id ), 
                    'capability'        =>  'edit_theme_options',
                    'active_callback'   =>  'is_front_page',
                )
            );
            /**
             * Enabling featured products of woocommerce
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_enable_woo_featured_products',
                array(
                    'default'			=>	WK_DEFAULTS['_enable_woo_featured_products'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' ),
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_enable_woo_featured_products',
                    array(
                        'label'			=>	esc_html__( 'Enable woocommerce', $this->theme_id ),
                        'description' 	=>	esc_html__( 'Check the box to enable woocommerce featured products block.', $this->theme_id ),
                        'section'		=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'		=>	$this->prefix_id . '_enable_woo_featured_products',
                        'type'			=>	'checkbox',
                    )
                )
            );

            // WooCommerce block title
            $wp_customize->add_setting(
                $this->prefix_id . '_woo_featured_products_block_title',
                array(
                    'default'			=>	WK_DEFAULTS['_woo_featured_products_block_title'],
                    'transport'			=>	'postMessage',
                    'sanitize_callback'	=>	'sanitize_text_field',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_woo_featured_products_block_title', 
                    array(
                        'label'				=>	esc_html__( 'WooCommerce Block Title ', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'			=>	$this->prefix_id . '_woo_featured_products_block_title', 
                        'active_callback'	=>	array( $this, 'featured_products_enabled' )
                    )
                )
            );
            // WooCommerce block description text one
            $wp_customize->add_setting(
                $this->prefix_id . '_woo_featured_products_block_text_one',
                array(
                    'default'			=>	WK_DEFAULTS['_woo_featured_products_block_text_one'],
                    'transport'			=>	'postMessage',
                    'sanitize_callback'	=>	'sanitize_textarea_field',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_woo_featured_products_block_text_one', 
                    array(
                        'label'				=>	esc_html__( 'WooCommerce Block Text One ', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'			=>	$this->prefix_id . '_woo_featured_products_block_text_one', 
                        'type'				=>	'textarea',
                        'input_attrs' => array(
                            'style' => 'border: 1px solid #999',
                            'placeholder' => esc_html__( 'Enter text...', $this->theme_id ),
                        ),
                        'active_callback'	=>	array( $this, 'featured_products_enabled' )
                    )
                )
            );
            // WooCommerce block description text two
            $wp_customize->add_setting(
                $this->prefix_id . '_woo_featured_products_block_text_two',
                array(
                    'default'			=>	WK_DEFAULTS['_woo_featured_products_block_text_two'],
                    'transport'			=>	'postMessage',
                    'sanitize_callback'	=>	'sanitize_textarea_field',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_woo_featured_products_block_text_two', 
                    array(
                        'label'				=>	esc_html__( 'WooCommerce Block Text Two ', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'			=>	$this->prefix_id . '_woo_featured_products_block_text_two', 
                        'type'				=>	'textarea',
                        'input_attrs' => array(
                            'style' => 'border: 1px solid #999',
                            'placeholder' => esc_html__( 'Enter text...', $this->theme_id ),
                        ),
                        'active_callback'	=>	array( $this, 'featured_products_enabled' )
                    )
                )
            );

            // woocommerce block link
            $wp_customize->add_setting(
                $this->prefix_id . '_woo_featured_products_block_link',
                array(
                    'default'			=>	WK_DEFAULTS['_woo_featured_products_block_link'],
                    'sanitize_callback'	=>	'esc_url_raw',
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_woo_featured_products_block_link', 
                    array(
                        'label'				=>	esc_html__( 'Link To Page ', $this->theme_id ),
                        'type'				=>	'url',
                        'section'			=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'			=>	$this->prefix_id . '_woo_featured_products_block_link',
                        'active_callback'	=>	array( $this, 'featured_products_enabled' ), 
                    )
                )
            );

            // WooCommerce block link text
            $wp_customize->add_setting(
                $this->prefix_id . '_woo_featured_products_block_link_text',
                array(
                    'default'			=>	WK_DEFAULTS['_woo_featured_products_block_link_text'],
                    'transport'			=>	'postMessage',
                    'sanitize_callback'	=>	'sanitize_text_field',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_woo_featured_products_block_link_text', 
                    array(
                        'label'				=>	esc_html__( 'WooCommerce Block Link Text ', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'			=>	$this->prefix_id . '_woo_featured_products_block_link_text', 
                        'active_callback'	=>	array( $this, 'featured_products_enabled' )
                    )
                )
            );

            // WooCommerce featured products button text
            $wp_customize->add_setting(
                $this->prefix_id . '_woo_featured_products_link_btn_text',
                array(
                    'default'			=>	WK_DEFAULTS['_woo_featured_products_link_btn_text'],
                    'transport'			=>	'postMessage',
                    'sanitize_callback'	=>	'sanitize_text_field',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_woo_featured_products_link_btn_text', 
                    array(
                        'label'				=>	esc_html__( 'Products Button Text ', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_woo_featured_products_section',
                        'settings'			=>	$this->prefix_id . '_woo_featured_products_link_btn_text', 
                        'active_callback'	=>	array( $this, 'featured_products_enabled' )
                    )
                )
            );
        }

        /**
         * Check if woocommere featured products enabled
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if woocommere featured products is activated, false otherwise
         */
        public function featured_products_enabled( $control ) {
            return false != $control->manager->get_setting( $this->prefix_id . '_enable_woo_featured_products' )->value();
        }

    } // ENDS --- class
}
return new WonKode_Customize_Woo_Featured_Products;