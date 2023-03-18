<?php
/**
 * Class to customize selected posts section 
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
if ( ! class_exists( 'WonKode_Customize_Selected_Posts_Section' ) ) {
    class WonKode_Customize_Selected_Posts_Section extends WonKode_Customize_Base {
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
         * Register customizers
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            // Customizer heading custom separator control
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_customize_heading', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_customize_heading',
                    array(
                        'label'             =>  esc_html__( 'Selected Posts Block', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_selected_posts_customize_heading',
                        'type'	            =>	'section_heading',
                    )
                )
            );
            // separator description
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_customize_description', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_customize_description',
                    array(
                        'description'       =>  esc_html__( 'Allows to display and customize selected posts block on frontpage. Check to display and customize the block.', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_selected_posts_customize_description',
                        'type'	            =>	'section_text',
                    )
                )
            );

            /**
             * Enabling and Setting contents 
             * for frontpage selected posts
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_enabled',
                array(
                    'default'			=>	WK_DEFAULTS['_front_selected_posts_enabled'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' ),
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                $wp_customize,
                $this->prefix_id . '_front_selected_posts_enabled',
                    array(
                        'section'		=>	$this->prefix_id . '_frontpage_section',
                        'label'			=>	esc_html__( 'Enable Selected Posts Block', $this->theme_id ),
                        'settings'		=>	$this->prefix_id . '_front_selected_posts_enabled',
                        'type'			=>	'checkbox',
                    )
                )
            );

            // section title
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_section_title',
                array(
                    'default'			=>	WK_DEFAULTS['_front_selected_posts_section_title'],
                    'sanitize_callback'	=>	'sanitize_text_field',
                    'transport'			=>	'postMessage',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_section_title', 
                    array(
                        'label'				=>	esc_html__( 'Section title: ', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_front_selected_posts_section_title',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                    )
                )
            );

            /*
            * Number of posts
            */
            $wp_customize->add_setting(
                $this->prefix_id . '_num_of_front_selected_posts',
                array(
                    'default'			=>	WK_DEFAULTS['_num_of_front_selected_posts'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'number' ),
                    'transport'			=>	'refresh',
                )
            ); 
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_num_of_front_selected_posts',
                    array(
                        'label'				=>	esc_html__('Number of posts', $this->theme_id),
                        'description'		=>	esc_html__('Sets total number of posts to be display on this section.', $this->theme_id),
                        'section'			=>	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_num_of_front_selected_posts',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                        'type' 				=>	'number',
                    )
                )
            );

            /*
            * select posts to show
            */
            // ----Customizer sub-heading for post selection----
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_customize_sub_heading_selection', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_customize_sub_heading_selection',
                    array(
                        'label'             =>  esc_html__( 'Select Posts To Display', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_selected_posts_customize_sub_heading_selection',
                        'type'	            =>	'sub_section_heading',
                    )
                )
            );

            $num_of_selected_posts = absint( get_theme_mod( $this->prefix_id . '_num_of_front_selected_posts', WK_DEFAULTS['_num_of_front_selected_posts'] ) );

            $pst = 0;

            while ( $pst < $num_of_selected_posts ) :

                // select post
                $wp_customize->add_setting(
                    $this->prefix_id . '_front_selected_post_' . $pst, 
                    array(
                        'default'			=>	WK_DEFAULTS['_front_selected_post_default'],
                        'sanitize_callback'	=>	'absint',
                        'transport'			=>	'refresh',
                    )
                );
                $wp_customize->add_control(
                    new WonKode_Post_Dropdown_Custom_Control(
                        $wp_customize, 
                        $this->prefix_id . '_front_selected_post_' . $pst, 
                        array(
                            'label'				=>	esc_html__('Post ', $this->theme_id) . $pst,
                            'section'			=>	$this->prefix_id . '_frontpage_section',
                            'settings'			=>	$this->prefix_id . '_front_selected_post_' . $pst,
                            'active_callback'	=>	array( $this, 'section_display_enabled' ), 
                        )
                    )
                    
                );

                // Custom separator control between posts selection
                $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_custom_separator_' . $pst, 
                    array(
                        'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                    )
                );
                $wp_customize->add_control( 
                    new WonKode_Separator_Custom_Control(
                        $wp_customize, 
                        $this->prefix_id . '_front_selected_posts_custom_separator_' . $pst,
                            array(
                                'type'	            =>	'hr_divider',
                                'section'	        =>	$this->prefix_id . '_frontpage_section',
                                'settings'	        =>	$this->prefix_id . '_front_selected_posts_custom_separator_' . $pst,
                                'active_callback'	=>	array( $this, 'section_display_enabled' ),
                            )
                    )
                );

                $pst++;

            endwhile;

            //-----selected_posts section style customizers-------------

            // Customizer sub-heading for columns per row
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_customize_sub_heading_cols', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_customize_sub_heading_cols',
                    array(
                        'label'             =>  esc_html__( 'Columns per row', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_selected_posts_customize_sub_heading_cols',
                        'type'	            =>	'sub_section_heading',
                    )
                )
            );

            /**
             * Number of columns per row 
             * on smaller devices.
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_cols_sm',
                array(
                    'default'			=>	WK_DEFAULTS['_front_selected_posts_cols_sm'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'number' ),
                    'transport'			=>	'refresh',
                )
            ); 
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_front_selected_posts_cols_sm',
                    array(
                        'label'				=>	esc_html__( 'Device width &ge; 576px', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_front_selected_posts_cols_sm',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                        'type' 				=>	'number',
                    )
                )
            );

            /**
             * Number of columns per row 
             * on medium devices.
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_cols_md',
                array(
                    'default'			=>	WK_DEFAULTS['_front_selected_posts_cols_md'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'number' ),
                    'transport'			=>	'refresh',
                )
            ); 
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_front_selected_posts_cols_md',
                    array(
                        'label'				=>	esc_html__( 'Device width &ge; 768px', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_front_selected_posts_cols_md',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                        'type' 				=>	'number',
                    )
                )
            );

            /**
             * Number of columns per row 
             * on large devices.
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_cols_lg',
                array(
                    'default'			=>	WK_DEFAULTS['_front_selected_posts_cols_lg'],
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'number' ),
                    'transport'			=>	'refresh',
                )
            ); 
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_front_selected_posts_cols_lg',
                    array(
                        'label'				=>	esc_html__( 'Device width &ge; 992px', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_front_selected_posts_cols_lg',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                        'type' 				=>	'number',
                    )
                )
            );

            // ----Customizer sub-heading for Styles----
            $wp_customize->add_setting(
                $this->prefix_id . '_front_selected_posts_customize_sub_heading_styling', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_customize_sub_heading_styling',
                    array(
                        'label'             =>  esc_html__( 'Customize Styles', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_selected_posts_customize_sub_heading_styling',
                        'type'	            =>	'sub_section_heading',
                    )
                )
            );
            // section background color
            $wp_customize->add_setting( 
                $this->prefix_id . '_front_selected_posts_section_bg_color', 
                array(
                    'default'			=>	'',
                    'transport'			=> 	'postMessage',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_section_bg_color', 
                    array(
                        'label'				=> 	esc_html__( 'Section Background Color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_frontpage_section',
                        'settings'			=> 	$this->prefix_id . '_front_selected_posts_section_bg_color',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                    ) 
                ) 
            );

            // section title color
            $wp_customize->add_setting( 
                $this->prefix_id . '_front_selected_posts_section_title_color', 
                array(
                    'default'			=>	'',
                    'transport'			=> 	'postMessage',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_front_selected_posts_section_title_color', 
                    array(
                        'label'				=> 	esc_html__( 'Section Title Color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_frontpage_section',
                        'settings'			=> 	$this->prefix_id . '_front_selected_posts_section_title_color',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                    ) 
                ) 
            );
        }

        /**
         * Check if displaying section enabled
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if displaying section is activated, false otherwise
         */
        public function section_display_enabled( $control ) {
            return false != $control->manager->get_setting( $this->prefix_id . '_front_selected_posts_enabled' )->value();
        }

    } // ENDS --- class
}
return new WonKode_Customize_Selected_Posts_Section;