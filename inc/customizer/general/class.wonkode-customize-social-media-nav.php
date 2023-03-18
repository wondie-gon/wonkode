<?php 
/**
 * Social media links customizer
 * 
 * @package WonKode
 * @since 1.0
 */
// disallow direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Customize_Social_Media_Nav' ) ) {
    class WonKode_Customize_Social_Media_Nav extends WonKode_Customize_Base {
        /**
         * constructor
         */
        public function __construct() {
            parent::__construct();
            // register the customizer
            add_action( 'customize_register', array( $this, 'register' ) );
        }
        
        /**
         * Action function to register section and settings
         * @param WP_Customize_Manager $wp_customize Customizer reference.
         */
        public function register( $wp_customize ) {
            /**
             * Social media link customizer section
             */
            $wp_customize->add_section(
                $this->prefix_id . '_social_media_link_section', 
                array(
                    'priority'	    =>	160,
                    'capability'    => 'edit_theme_options',
                    'title'		    =>	__( 'Social Media Nav', $this->theme_id ),
                    'description'   => __( 'Customize social media links menu', $this->theme_id ),
                )
            );
            /* 
            * Whether to display social media link nav bar
            */
            $wp_customize->add_setting(
                'enable_' . $this->prefix_id . '_social_media_link_nav',
                array(
                    'default'	        => false,
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    'enable_' . $this->prefix_id . '_social_media_link_nav',
                    array(
                        'label' 		=> __( 'Enable Social Media links', $this->theme_id ),
                        'section' 		=> $this->prefix_id . '_social_media_link_section',
                        'settings'		=> 'enable_' . $this->prefix_id . '_social_media_link_nav',
                        'type' 			=> 'checkbox',
                    )
                )
            );

            /* 
            * setting up social media usernames
            */
            // Facebook
            $wp_customize->add_setting(
                $this->prefix_id . '_facebook_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_facebook_link_username', 
                    array(
                        'settings'			=> $this->prefix_id . '_facebook_link_username', 
                        'label'				=>	__( 'Facebook', $this->theme_id ), 
                        'section'			=>	$this->prefix_id . '_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // Twitter
            $wp_customize->add_setting(
                $this->prefix_id . '_twitter_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_twitter_link_username', 
                    array(
                        'settings'			=>  $this->prefix_id . '_twitter_link_username', 
                        'label'				=>	__( 'Twitter', $this->theme_id ), 
                        'section'			=>	$this->prefix_id . '_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // googleplus
            $wp_customize->add_setting(
                $this->prefix_id . '_googleplus_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_googleplus_link_username', 
                    array(
                        'settings'			=>  $this->prefix_id . '_googleplus_link_username', 
                        'label'				=>	__( 'Google+', $this->theme_id ), 
                        'section'			=>	$this->prefix_id . '_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
            // pinterest
            $wp_customize->add_setting(
                $this->prefix_id . '_pinterest_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_pinterest_link_username', 
                    array(
                        'settings'			=>	$this->prefix_id . '_pinterest_link_username',
                        'section'			=>	$this->prefix_id . '_social_media_link_section',
                        'label'				=>	__( 'Pinterest', $this->theme_id ), 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
            // linkedin
            $wp_customize->add_setting(
                $this->prefix_id . '_linkedin_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_linkedin_link_username', 
                    array(
                        'settings'			=>	$this->prefix_id . '_linkedin_link_username', 
                        'label'				=>	__( 'Linkedin', $this->theme_id ), 
                        'section'			=>	$this->prefix_id . '_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // github
            $wp_customize->add_setting(
                $this->prefix_id . '_github_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_github_link_username', 
                    array(
                        'settings'			=>	$this->prefix_id . '_github_link_username', 
                        'label'				=>	__( 'Github', $this->theme_id ), 
                        'section'			=>	$this->prefix_id . '_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
            // instagram
            $wp_customize->add_setting(
                $this->prefix_id . '_instagram_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_instagram_link_username', 
                    array(
                        'settings'			=>	$this->prefix_id . '_instagram_link_username', 
                        'label'				=>	__( 'Instagram', $this->theme_id ),
                        'section'			=>	$this->prefix_id . '_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // youtube
            $wp_customize->add_setting(
                $this->prefix_id . '_youtube_link_username', 
                array(
                    'default'	        =>	'', 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );

            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_youtube_link_username', 
                    array(
                        'settings'			=>	$this->prefix_id . '_youtube_link_username',
                        'section'			=>	$this->prefix_id . '_social_media_link_section',
                        'label'				=>	__( 'Youtube', $this->theme_id ), 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            /**
             * Whether to display social media nav 
             * title
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_display_social_media_nav_title',
                array(
                    'default'	        => false,
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' )
                )
            );
            $wp_customize->add_control(
                $this->prefix_id . '_display_social_media_nav_title',
                array(
                    'settings'          => $this->prefix_id . '_display_social_media_nav_title', 
                    'label'             => __( 'Display title', $this->theme_id ), 
                    'description'	    =>	__( 'Check to display title for navigation list', $this->theme_id ),
                    'section'           => $this->prefix_id . '_social_media_link_section',
                    'type'              => 'checkbox',
                    'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                )
            );

            // nav title
            $wp_customize->add_setting(
                $this->prefix_id . '_social_media_nav_title', 
                array(
                    'default'	        =>	__( 'Follow', $this->theme_id ), 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    $this->prefix_id . '_social_media_nav_title', 
                    array(
                        'settings'			=>	$this->prefix_id . '_social_media_nav_title',
                        'section'			=>	$this->prefix_id . '_social_media_link_section',
                        'label'				=>	__( 'Title', $this->theme_id ), 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
        }

        /**
         * Check if the social media nav enabled
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if social media nav is activated, false otherwise
         */
        public function social_media_link_nav_enabled( $control ) {
            return false != $control->manager->get_setting( 'enable_' . $this->prefix_id . '_social_media_link_nav' )->value();
        }
    }
}
/**
 * Initiating class
 */
new WonKode_Customize_Social_Media_Nav();