<?php
/**
 * Class to customize categorized latest posts section on frontpage.
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Customize_Categorized_Latest_Posts' ) ) {
    class WonKode_Customize_Categorized_Latest_Posts extends WonKode_Customize_Base {
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
         * Register customizer features.
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            // Customizer heading custom separator control
            $wp_customize->add_setting(
                $this->prefix_id . '_front_categorized_latest_posts_customize_heading', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_categorized_latest_posts_customize_heading',
                    array(
                        'label'             =>  esc_html__( 'Categorized Latest Posts Block', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_categorized_latest_posts_customize_heading',
                        'type'	            =>	'section_heading',
                    )
                )
            );
            // separator description
            $wp_customize->add_setting(
                $this->prefix_id . '_front_categorized_latest_posts_customize_description', 
                array(
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'html' )
                )
            );
            $wp_customize->add_control( 
                new WonKode_Separator_Custom_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_categorized_latest_posts_customize_description',
                    array(
                        'description'       =>  esc_html__( 'Allows to display and customize latest posts block of a selected category on frontpage. Check to display and customize the block.', $this->theme_id ),
                        'section'	        =>	$this->prefix_id . '_frontpage_section',
                        'settings'	        =>	$this->prefix_id . '_front_categorized_latest_posts_customize_description',
                        'type'	            =>	'section_text',
                    )
                )
            );
            /*
            * enabling and Setting contents for frontpage latest posts
            */
            $wp_customize->add_setting(
                $this->prefix_id . '_front_categorized_latest_posts_enabled',
                array(
                    'default'			=>	0,
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' ),
                )
            );


            $wp_customize->add_control( 
                new WP_Customize_Control(
                $wp_customize,
                $this->prefix_id . '_front_categorized_latest_posts_enabled',
                    array(
                        'section'		=>	$this->prefix_id . '_frontpage_section',
                        'label'			=>	esc_html__( 'Enable Categorized Posts Block', $this->theme_id ),
                        'settings'		=>	$this->prefix_id . '_front_categorized_latest_posts_enabled',
                        'type'			=>	'checkbox',
                    )
                )
            );

            /*
            * Get category to display posts on frontpage
            */
            $wp_customize->add_setting(
                $this->prefix_id . '_front_categorized_latest_posts_category',
                    array(
                        'default'			=>	'0',
                        'sanitize_callback'	=>	'absint',
                        )
                );

            $wp_customize->add_control( 
                    new WonKode_Category_Dropdown_Control( 
                        $wp_customize, $this->prefix_id . '_front_categorized_latest_posts_category', 
                        array(
                            'label'				=>	esc_html__( 'Select category of posts', $this->theme_id ),
                            'section'			=>	$this->prefix_id . '_frontpage_section',
                            'settings'			=>	$this->prefix_id . '_front_categorized_latest_posts_category',
                            'type'            	=>	'dropdown-category',
                            'active_callback'	=>	array( $this, 'section_display_enabled' ),
                        ) 
                    ) 
                );

            /*
            * Number of posts
            */
            $wp_customize->add_setting(
                $this->prefix_id . '_num_of_front_categorized_latest_posts',
                    array(
                        'default'			=>	'4',
                        'transport'			=>	'refresh',
                        'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'number' ),
                    )
                );
                
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_num_of_front_categorized_latest_posts',
                    array(
                        'label'				=>	esc_html__('Number of posts', $this->theme_id),
                        'section'			=>	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_num_of_front_categorized_latest_posts',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                        'type' 				=>	'number',
                    )
                )
            );

            // section title
            $wp_customize->add_setting(
                $this->prefix_id . '_front_categorized_latest_posts_section_title',
                array(
                    'default'			=>	WK_DEFAULTS['_front_categorized_latest_posts_section_title'],
                    'transport'			=>	'postMessage',
                    'sanitize_callback'	=>	'sanitize_text_field',
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_front_categorized_latest_posts_section_title', 
                    array(
                        'label'				=>	esc_html__( 'Section title: ', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_frontpage_section',
                        'settings'			=>	$this->prefix_id . '_front_categorized_latest_posts_section_title',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                    )
                )
            );

            //---------categorized_latest_posts section style customizers-------------
            // section background color
            $wp_customize->add_setting( 
                $this->prefix_id . '_front_categorized_latest_posts_section_bg_color', 
                array(
                    'default'			=>	'',
                    'transport'			=> 	'postMessage',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_front_categorized_latest_posts_section_bg_color', 
                    array(
                        'label'				=> 	esc_html__( 'Section Background Color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_frontpage_section',
                        'settings'			=> 	$this->prefix_id . '_front_categorized_latest_posts_section_bg_color',
                        'active_callback'	=>	array( $this, 'section_display_enabled' ),
                    ) 
                ) 
            );

            // section title color
            $wp_customize->add_setting( 
                $this->prefix_id . '_front_categorized_latest_posts_section_title_color', 
                array(
                    'default'			=>	'',
                    'transport'			=> 	'postMessage',
                    'sanitize_callback'	=> 	array( 'WonKode_Sanitize', 'hex_color' ),
                ) 
            );
            $wp_customize->add_control( 
                new WP_Customize_Color_control( 
                    $wp_customize, 
                    $this->prefix_id . '_front_categorized_latest_posts_section_title_color', 
                    array(
                        'label'				=> 	esc_html__( 'Section Heading Color', $this->theme_id ),
                        'section'			=> 	$this->prefix_id . '_frontpage_section',
                        'settings'			=> 	$this->prefix_id . '_front_categorized_latest_posts_section_title_color',
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
            return false != $control->manager->get_setting( $this->prefix_id . '_front_categorized_latest_posts_enabled' )->value();
        }

    } // ENDS --- class
}
return new WonKode_Customize_Categorized_Latest_Posts;