<?php 
/**
 * Social media share menu customizer
 * 
 * @package WonKode
 * @since 1.0
 */
// disallow direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Customize_Social_Media_Share' ) ) {
    class WonKode_Customize_Social_Media_Share extends WonKode_Customize_Base {
        /**
         * class constructor
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
             * Social media share customizer section
             */
            $wp_customize->add_section(
                'wonkode_social_media_share_section', 
                array(
                    'priority'	        =>	170,
                    'capability'        => 'edit_theme_options',
                    'title'		        =>	__( 'Social Share Menu', $this->theme_id ),
                    'description'       =>	__( 'Allows to customize social media sharing menu you want posts to share to.', $this->theme_id ),
                    // 'active_callback'   =>  'is_singular',
                )
            );

            /**
             * Whether to display social media sharing
             */
            $wp_customize->add_setting(
                'enable_wonkode_social_media_sharing',
                array(
                    'default'	        => false,
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' )
                )
            );
            $wp_customize->add_control(
                'enable_wonkode_social_media_sharing',
                array(
                    'settings'      => 'enable_wonkode_social_media_sharing', 
                    'label'         => __( 'Enable Social Media Sharing', $this->theme_id ), 
                    'description'	=>	__( 'Check which social media to share posts to.', $this->theme_id ),
                    'section'       => 'wonkode_social_media_share_section',
                    'type'          => 'checkbox',
                )
            );

            /**
             * Check social media you want to have share link
             */
            // Facebook
            $wp_customize->add_setting(
                'wonkode_enable_facebook_share', 
                array(
                    'default'	        =>	false, 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'checkbox' ),	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    'wonkode_enable_facebook_share', 
                    array(
                        'settings'          => 'wonkode_enable_facebook_share', 
                        'label'				=>	__( 'Facebook', $this->theme_id ),
                        'section'			=>	'wonkode_social_media_share_section', 
                        'active_callback'	=>	array( $this, 'social_media_sharing_enabled' ),
                        'type'				=>	'checkbox',
                    )
                )
            );
            // Twitter
            $wp_customize->add_setting(
                'wonkode_enable_twitter_share', 
                array(
                    'default'	        =>	false, 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'checkbox' ),	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    'wonkode_enable_twitter_share', 
                    array(
                        'settings' 			=> 'wonkode_enable_twitter_share', 
                        'label'				=>	__( 'Twitter', $this->theme_id ),
                        'section'			=>	'wonkode_social_media_share_section', 
                        'active_callback'	=>	array( $this, 'social_media_sharing_enabled' ),
                        'type'				=>	'checkbox',
                    )
                )
            );
            // googleplus
            $wp_customize->add_setting(
                'wonkode_enable_googleplus_share', 
                array(
                    'default'	        =>	false, 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'checkbox' ),	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    'wonkode_enable_googleplus_share', 
                    array(
                        'settings' 			=> 'wonkode_enable_googleplus_share', 
                        'label'				=>	__( 'Google+', $this->theme_id ),
                        'section'			=>	'wonkode_social_media_share_section', 
                        'active_callback'	=>	array( $this, 'social_media_sharing_enabled' ),
                        'type'				=>	'checkbox',
                    )
                )
            );
            // pinterest
            $wp_customize->add_setting(
                'wonkode_enable_pinterest_share', 
                array(
                    'default'	        =>	false, 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'checkbox' ),	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    'wonkode_enable_pinterest_share', 
                    array(
                        'settings' 			=> 'wonkode_enable_pinterest_share', 
                        'label'				=>	__( 'Pinterest', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_share_section', 
                        'active_callback'	=>	array( $this, 'social_media_sharing_enabled' ),
                        'type'				=>	'checkbox',
                    )
                )
            );
            // linkedin
            $wp_customize->add_setting(
                'wonkode_enable_linkedin_share', 
                array(
                    'default'	        =>	false, 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'checkbox' ),	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    'wonkode_enable_linkedin_share', 
                    array(
                        'settings' 			=> 'wonkode_enable_linkedin_share', 
                        'label'				=>	__( 'Linkedin', $this->theme_id ), 
                        'section'			=>	'wonkode_social_media_share_section',
                        'active_callback'	=>	array( $this, 'social_media_sharing_enabled' ),
                        'type'				=>	'checkbox',
                    )
                )
            );

            /**
             * Whether to display social media share 
             * title
             */
            $wp_customize->add_setting(
                'wonkode_display_social_media_share_title',
                array(
                    'default'	        => false,
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod',  
                    'sanitize_callback'	=>	array( 'WonKode_Sanitize', 'checkbox' )
                )
            );
            $wp_customize->add_control(
                'wonkode_display_social_media_share_title',
                array(
                    'settings'          => 'wonkode_display_social_media_share_title', 
                    'label'             => __( 'Display title', $this->theme_id ), 
                    'description'	    =>	__( 'Check to display title for share menu', $this->theme_id ),
                    'section'           => 'wonkode_social_media_share_section',
                    'type'              => 'checkbox',
                    'active_callback'	=>	array( $this, 'social_media_sharing_enabled' ),
                )
            );

            // share title
            $wp_customize->add_setting(
                'wonkode_social_media_share_title', 
                array(
                    'default'	        =>	__( 'Share', $this->theme_id ), 
                    'capability'        => 'edit_theme_options', 
                    'type'              => 'theme_mod', 
                    'sanitize_callback' => 'sanitize_text_field',	
                )
            );
            $wp_customize->add_control( 
                new WP_Customize_Control(
                    $wp_customize, 
                    'wonkode_social_media_share_title', 
                    array(
                        'settings'			=>	'wonkode_social_media_share_title',
                        'section'			=>	'wonkode_social_media_share_section',
                        'label'				=>	__( 'Title', $this->theme_id ), 
                        'active_callback'	=>	array( $this, 'share_title_display_enabled' ),
                    )
                )
            );
        }

        /**
         * Check if the social media share links enabled
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if social media sharing activated, false otherwise
         */
        public function social_media_sharing_enabled( $control ) {
            return false != $control->manager->get_setting( 'enable_wonkode_social_media_sharing' )->value();
        }

        /**
         * Check if the social media share title display enabled
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if display title enabled, false otherwise
         */
        public function share_title_display_enabled( $control ) {
            return false != $control->manager->get_setting( 'wonkode_display_social_media_share_title' )->value();
        }
    }
}
/**
 * Initiating class
 */
new WonKode_Customize_Social_Media_Share();