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
            if ( is_customize_preview() ) {
                add_action( 'customize_register', array( $this, 'register' ) );
            }
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
                'wonkode_social_media_link_section', 
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
                'enable_wonkode_social_media_link_nav',
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
                    'enable_wonkode_social_media_link_nav',
                    array(
                        'label' 		=> __( 'Enable Social Media links', $this->theme_id ),
                        'section' 		=> 'wonkode_social_media_link_section',
                        'settings'		=> 'enable_wonkode_social_media_link_nav',
                        'type' 			=> 'checkbox',
                    )
                )
            );

            /* 
            * setting up social media usernames
            */
            // Facebook
            $wp_customize->add_setting(
                'wonkode_facebook_link_username', 
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
                    'wonkode_facebook_link_username', 
                    array(
                        'settings'			=> 'wonkode_facebook_link_username', 
                        'label'				=>	__( 'Facebook', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // Twitter
            $wp_customize->add_setting(
                'wonkode_twitter_link_username', 
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
                    'wonkode_twitter_link_username', 
                    array(
                        'settings'			=>  'wonkode_twitter_link_username', 
                        'label'				=>	__( 'Twitter', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // googleplus
            $wp_customize->add_setting(
                'wonkode_googleplus_link_username', 
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
                    'wonkode_googleplus_link_username', 
                    array(
                        'settings'			=>  'wonkode_googleplus_link_username', 
                        'label'				=>	__( 'Google+', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
            // pinterest
            $wp_customize->add_setting(
                'wonkode_pinterest_link_username', 
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
                    'wonkode_pinterest_link_username', 
                    array(
                        'settings'			=>	'wonkode_pinterest_link_username',
                        'section'			=>	'wonkode_social_media_link_section',
                        'label'				=>	__( 'Pinterest', $this->theme_id ), 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
            // linkedin
            $wp_customize->add_setting(
                'wonkode_linkedin_link_username', 
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
                    'wonkode_linkedin_link_username', 
                    array(
                        'settings'			=>	'wonkode_linkedin_link_username', 
                        'label'				=>	__( 'Linkedin', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // github
            $wp_customize->add_setting(
                'wonkode_github_link_username', 
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
                    'wonkode_github_link_username', 
                    array(
                        'settings'			=>	'wonkode_github_link_username', 
                        'label'				=>	__( 'Github', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );
            // instagram
            $wp_customize->add_setting(
                'wonkode_instagram_link_username', 
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
                    'wonkode_instagram_link_username', 
                    array(
                        'settings'			=>	'wonkode_instagram_link_username', 
                        'label'				=>	__( 'Instagram', $this->theme_id ),
                        'section'			=>	'wonkode_social_media_link_section', 
                        'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                    )
                )
            );

            // youtube
            $wp_customize->add_setting(
                'wonkode_youtube_link_username', 
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
                    'wonkode_youtube_link_username', 
                    array(
                        'settings'			=>	'wonkode_youtube_link_username',
                        'section'			=>	'wonkode_social_media_link_section',
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
                'wonkode_display_social_media_nav_title',
                array(
                    'default'	        => false,
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' )
                )
            );
            $wp_customize->add_control(
                'wonkode_display_social_media_nav_title',
                array(
                    'settings'          => 'wonkode_display_social_media_nav_title', 
                    'label'             => __( 'Display title', $this->theme_id ), 
                    'description'	    =>	__( 'Check to display title for navigation list', $this->theme_id ),
                    'section'           => 'wonkode_social_media_link_section',
                    'type'              => 'checkbox',
                    'active_callback'	=>	array( $this, 'social_media_link_nav_enabled' ),
                )
            );

            // nav title
            $wp_customize->add_setting(
                'wonkode_social_media_nav_title', 
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
                    'wonkode_social_media_nav_title', 
                    array(
                        'settings'			=>	'wonkode_social_media_nav_title',
                        'section'			=>	'wonkode_social_media_link_section',
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
            return false != $control->manager->get_setting( 'enable_wonkode_social_media_link_nav' )->value();
        }
    }
}
/**
 * Initiating class
 */
new WonKode_Customize_Social_Media_Nav();