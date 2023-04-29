<?php
/**
 * Class for custom Bootstrap carousel section customizer 
 * on frontpage.
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// the customize class
if ( ! class_exists( 'WonKode_Customize_BS_Custom_Carousel_Section' ) ) {
    class WonKode_Customize_BS_Custom_Carousel_Section extends WonKode_Customize_Base {

        /**
         * Class constructor
         * 
         * @since 1.0
         */
        public function __construct() {
            parent::__construct();
            // register cusomizer
            add_action( 'customize_register', array( $this, 'register' ) );

            // styles output action hook
            if ( is_front_page() && $this->carousel_section_enabled( $this->theme_id . '_enable_bs_carousel' ) ) {
                add_action( 'wp_head', array( $this, 'style_output' ) );
            }
        }
        /**
         * Register customizers
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            /**
             * Front page customize section for 
             * bootstrap carousel.
             */
            $wp_customize->add_section(
                $this->prefix_id . '_customize_section_bs_carousel',
                array(
                    'priority'          =>  30, 
                    'title'             =>  esc_html__( 'BS Carousel/Slider Section', $this->theme_id ), 
                    'description'       =>  esc_html__( 'Allows to display and customize Bootstrap carousel section on frontpage. Check to display and customize the section.', $this->theme_id ), 
                    'capability'        =>  'edit_theme_options',
                    'panel'             =>  $this->prefix_id . '_frontpage_panel',
                )
            );

            /**
             * Enabling carousel
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_enable_bs_carousel',
                array(
                    'default'			=>	WK_DEFAULTS['_enable_bs_carousel'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' ),
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_enable_bs_carousel',
                    array(
                        'label'			=>	esc_html__( 'Enable Carousel', $this->theme_id ),
                        'description' 	=>	esc_html__( 'Check the box to enable carousel on frontpage of site.', $this->theme_id ),
                        'section'		=>	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'		=>	$this->prefix_id . '_enable_bs_carousel',
                        'type'			=>	'checkbox',
                    )
                )
            );

            /**
             * Number of carousel items 
             * setting and control
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_number_of_custom_carousel_items',
                    array(
                        'default'			=>	WK_DEFAULTS['_number_of_custom_carousel_items'],
                        'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'number' ),
                        'transport'			=>	'refresh',
                    )
                );
                
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_number_of_custom_carousel_items',
                    array(
                        'label'				=>	esc_html__( 'Number of slides', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'			=>	$this->prefix_id . '_number_of_custom_carousel_items',
                        'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                        'type' 				=>	'number',
                    )
                )
            );

            // custom carousel settings
            $this->custom_carousel_settings( $wp_customize );
            // customize styles settings
            $this->customize_styles( $wp_customize );
        }

        /**
         * Custom carousel customize settings
         * 
         * @param object $wp_customize Customizer reference.
         */
        public function custom_carousel_settings( $wp_customize ) {
            $num_of_slides = absint( get_theme_mod( $this->prefix_id . '_number_of_custom_carousel_items', WK_DEFAULTS['_number_of_custom_carousel_items'] ) );

            $i = 0;

            // $num = $i + 1;

            // ----Custom carousel separator sub-heading----
            $wp_customize->add_setting(
                $this->prefix_id . '_custom_carousels_separator_sub_heading', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_custom_carousels_separator_sub_heading',
                    array(
                        'label'             =>  esc_html__( 'Customize Carousel Custom Contents', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'	        =>	$this->prefix_id . '_custom_carousels_separator_sub_heading',
                        'type'	            =>	'sub_section_heading',
                        'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                    )
                )
            );

            while ( $i < $num_of_slides ) {
                // custom carousel top caption title
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_top_caption_title_' . $i,
                        array(
                            'default'			=>	WK_DEFAULTS['_custom_carousel_top_caption_title_'],
                            'transport'			=>	'refresh',
                            'sanitize_callback'	=>	'sanitize_text_field',
                        )
                    );

                $wp_customize->add_control( 
                    new WP_Customize_Control(
                        $wp_customize, 
                        $this->prefix_id . '_custom_carousel_top_caption_title_' . $i, 
                        array(
                            'label'				=>	esc_html__( 'Caption Title ', $this->theme_id ) . $i,
                            'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_top_caption_title_' . $i, 
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                        )
                    )
                );

                // custom carousel top caption text
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_top_caption_text_' . $i,
                        array(
                            'default'			=>	WK_DEFAULTS['_custom_carousel_top_caption_text_'],
                            'transport'			=>	'refresh',
                            'sanitize_callback'	=>	'sanitize_textarea_field',
                        )
                    );
                $wp_customize->add_control( 
                    new WP_Customize_Control(
                        $wp_customize, 
                        $this->prefix_id . '_custom_carousel_top_caption_text_' . $i, 
                        array(
                            'label'				=>	esc_html__( 'Top Caption Text ', $this->theme_id ) . $i,
                            'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                            'type'				=>	'textarea',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_top_caption_text_' . $i,
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                            'input_attrs' => array(
                                'class' => 'topcaption-textarea',
                                'style' => 'border: 1px solid #999',
                                'placeholder' => esc_html__( 'Enter text...', $this->theme_id ),
                            ),
                        )
                    )
                );

                // custom carousel bottom caption title
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_bottom_caption_title_' . $i,
                        array(
                            'default'			=>	WK_DEFAULTS['_custom_carousel_bottom_caption_title_'],
                            'transport'			=>	'refresh',
                            'sanitize_callback'	=>	'sanitize_text_field',
                        )
                    );

                $wp_customize->add_control( 
                    new WP_Customize_Control(
                        $wp_customize, 
                        $this->prefix_id . '_custom_carousel_bottom_caption_title_' . $i, 
                        array(
                            'label'				=>	esc_html__( 'Caption Bottom Sub-title ', $this->theme_id ) . $i,
                            'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_bottom_caption_title_' . $i, 
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                        )
                    )
                );

                // custom carousel bottom caption text
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_bottom_caption_text_' . $i,
                        array(
                            'default'			=>	WK_DEFAULTS['_custom_carousel_bottom_caption_text_'],
                            'transport'			=>	'refresh',
                            'sanitize_callback'	=>	'sanitize_textarea_field',
                        )
                    );
                $wp_customize->add_control( 
                    new WP_Customize_Control(
                        $wp_customize, 
                        $this->prefix_id . '_custom_carousel_bottom_caption_text_' . $i, 
                        array(
                            'label'				=>	esc_html__( 'Bottom Caption Text ', $this->theme_id ) . $i,
                            'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                            'type'				=>	'textarea',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_bottom_caption_text_' . $i,
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                            'input_attrs' => array(
                                'class' => 'bottomcaption-textarea',
                                'style' => 'border: 1px solid #999',
                                'placeholder' => esc_html__( 'Enter text...', $this->theme_id ),
                            ),
                        )
                    )
                );

                // custom carousel link to
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_link_' . $i,
                        array(
                            'default'			=>	WK_DEFAULTS['_custom_carousel_link_'],
                            'sanitize_callback'	=>	'esc_url_raw',
                        )
                    );
                $wp_customize->add_control( 
                    new WP_Customize_Control(
                        $wp_customize, 
                        $this->prefix_id . '_custom_carousel_link_' . $i, 
                        array(
                            'label'				=>	esc_html__( 'Link ', $this->theme_id ) . $i,
                            'type'				=>	'url',
                            'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_link_' . $i,
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ), 
                        )
                    )
                );

                // custom carousel link text
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_link_text_' . $i,
                    array(
                        'default' 			=>	WK_DEFAULTS['_custom_carousel_link_text_'],
                        'sanitize_callback' =>	'sanitize_text_field',
                        'transport'			=>	'refresh',
                    )
                );

                $wp_customize->add_control( 
                    new WP_Customize_Control(
                        $wp_customize,
                        $this->prefix_id . '_custom_carousel_link_text_' . $i,
                        array(
                            'label'				=>	esc_html__( 'Button text ', $this->theme_id ),
                            'section'			=>	$this->prefix_id . '_customize_section_bs_carousel',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_link_text_' . $i,
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                        )
                    )
                );

                // Add image for custom carousel
                $wp_customize->add_setting(
                    $this->prefix_id . '_custom_carousel_image_'. $i, 
                    array(
                        'default' 			=> '',
                        'transport'			=>	'refresh',
                        'sanitize_callback' =>	'absint',	
                    )
                );

                $wp_customize->add_control( 
                    new WP_Customize_Cropped_Image_Control(
                        $wp_customize, 
                        $this->prefix_id . '_custom_carousel_image_'. $i, 
                        array(
                            'label'				=> 	esc_html__( 'Carousel Image ', $this->theme_id ) . $i,
                            'section'			=> 	$this->prefix_id . '_customize_section_bs_carousel',
                            'settings'			=>	$this->prefix_id . '_custom_carousel_image_'. $i,
                            'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                            'width'				=>	800,
                            'height'			=>	450,
                        )
                    )
                );
                $i++;
            }
        }

        /**
         * Carousel customize styles settingss
         * 
         * @param object $wp_customize Customizer reference.
         */
        public function customize_styles( $wp_customize ) {

            // ----Customizer styles separator sub-heading----
            $wp_customize->add_setting(
                $this->prefix_id . '_carousel_customizer_styles_separator_sub_heading', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_carousel_customizer_styles_separator_sub_heading',
                    array(
                        'label'             =>  esc_html__( 'Customize section styles', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'	        =>	$this->prefix_id . '_carousel_customizer_styles_separator_sub_heading',
                        'type'	            =>	'sub_section_heading',
                        'active_callback'	=>	array( $this, 'carousel_section_enabled' ),
                    )
                )
            );

            // carousel title color
            $wp_customize->add_setting( 
                $this->prefix_id . '_custom_carousel_caption_title_color', 
                array(
                    'default'			=>	WK_DEFAULTS['_custom_carousel_caption_title_color'],
                    'transport'			=> 	'refresh',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_custom_carousel_caption_title_color', 
                    array(
                        'label'				=> 	esc_html__( 'Carousel title color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'			=> 	$this->prefix_id . '_custom_carousel_caption_title_color',
                        'active_callback'	=> 	array( $this, 'carousel_section_enabled' ),
                    ) 
                ) 
            );

            // carousel text color
            $wp_customize->add_setting( 
                $this->prefix_id . '_custom_carousel_caption_text_color', 
                array(
                    'default'			=>	WK_DEFAULTS['_custom_carousel_caption_text_color'],
                    'transport'			=> 	'refresh',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_custom_carousel_caption_text_color', 
                    array(
                        'label'				=> 	esc_html__( 'Carousel caption text color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'			=> 	$this->prefix_id . '_custom_carousel_caption_text_color',
                        'active_callback'	=> 	array( $this, 'carousel_section_enabled' ),
                    ) 
                ) 
            );

            // carousel link color
            $wp_customize->add_setting( 
                $this->prefix_id . '_custom_carousel_caption_link_color', 
                array(
                    'default'			=>	WK_DEFAULTS['_custom_carousel_caption_link_color'],
                    'transport'			=> 	'refresh',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_custom_carousel_caption_link_color', 
                    array(
                        'label'				=> 	esc_html__( 'Carousel caption link color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_customize_section_bs_carousel',
                        'settings'			=> 	$this->prefix_id . '_custom_carousel_caption_link_color',
                        'active_callback'	=> 	array( $this, 'carousel_section_enabled' ),
                    ) 
                ) 
            );
        }

        /**
         * Action to be hooked to 'wp_head'
         * This will output style changes of the cstomizer.
         * 
         * @since 1.0
         */
        public function style_output() {
            ?>
            <!--carousel customize CSS--> 
            <style type="text/css" id="<?php echo esc_attr( $this->theme_id . '-bs-carousel-customizer' ); ?>">
            <?php
                // custom_carousel_caption_title_color
                if ( ! empty( get_theme_mod( $this->prefix_id . '_custom_carousel_caption_title_color' ) ) ) {
                    $this->generate_css( '.caption-top .car-main-title, .caption-bottom .car-sub-title', 'color', $this->prefix_id . '_custom_carousel_caption_title_color' );
                }
                // custom_carousel_caption_text_color
                if ( ! empty( get_theme_mod( $this->prefix_id . '_custom_carousel_caption_text_color' ) ) ) {
                    $this->generate_css( '.caption-top .car-main-text, .caption-bottom .car-extra-text', 'color', $this->prefix_id . '_custom_carousel_caption_text_color' );
                }
                // custom_carousel_caption_link_color
                if ( ! empty( get_theme_mod( $this->prefix_id . '_custom_carousel_caption_link_color' ) ) ) {
                    $this->generate_css( '.caption-bottom .btn-outline-primary, .caption-bottom a.btn-outline-primary', 'color', $this->prefix_id . '_custom_carousel_caption_link_color' );
                }
            ?>
            </style>
            <!--/carousel customize CSS-->
            <?php
        }

        /**
         * Check if displaying section enabled
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if carousel is activated, false otherwise
         */
        public function carousel_section_enabled( $control ) {
            return false != $control->manager->get_setting( $this->prefix_id . '_enable_bs_carousel' )->value();
        }

    } // End of class
}
// initialize class
return new WonKode_Customize_BS_Custom_Carousel_Section;