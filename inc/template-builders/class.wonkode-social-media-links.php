<?php
/**
 * Class for custom social media templates
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Social_Media' ) ) {
    class WonKode_Social_Media {
        /**
         * Theme text domain id
         * 
         * @since 1.0
         */
        public static $txt_dom = null;

        /**
         * Stores urls of social media
         * 
         * @since 1.0
         * @var array
         */
        public static $social_urls = array(
            'facebook'      =>  'https://www.facebook.com/',
            'twitter'       =>  'https://www.twitter.com/',
            'googleplus'    =>  'https://plus.google.com/',
            'pinterest'     =>  'https://www.pinterest.com/',
            'linkedin'      =>  'https://www.linkedin.com/in/',
            'github'        =>  'https://www.github.com/',
            'instagram'     =>  'https://www.instagram.com/',
            'youtube'       =>  'https://www.youtube.com/',
        );

        /**
         * Stores social media nav 
         * attributes 
         * 
         * @since 1.0
         * @var array
         */
        public static $nav_args = array(
            'navbar'        =>  'ul',
            'nav_item'      =>  'li',
            'navbar_class'  =>  'nav',
            'item_class'    =>  'nav-item',
            'link_class'    =>  'nav-link',
        );
        /**
         * Instance of social media customizer
         * 
         * @since 1.0
         * @var object \WonKode_Customize_Social_Media_Nav
         */
        public static $custom_social_media = null;

        /**
         * Check if social media nav 
         * enabled in theme customizer
         * 
         */
        public static $nav_enabled = false;

        /**
         * Class constructor
         */
        public function __construct() {
            self::$custom_social_media = new WonKode_Customize_Social_Media_Nav();
            // set theme name, that is the textdomain
            self::$txt_dom = get_stylesheet();
            // determine if social nav enabled
            self::$nav_enabled = get_theme_mod( 'enable_wonkode_social_media_link_nav' );
        }

        /**
         * Returns social media usernames
         * 
         * @since 1.0
         * @param array $args Array of social media usernames
         * @return array Array of set usernames
         */
        public static function get_usernames( $args = array() ) {
            $usernames = array();
            if ( self::$nav_enabled ) {
                // facebook
                $usernames['facebook'] = ! empty( get_theme_mod( 'wonkode_facebook_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_facebook_link_username' ) ) : '';
                // twitter
                $usernames['twitter'] = ! empty( get_theme_mod( 'wonkode_twitter_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_twitter_link_username' ) ) : '';
                // googleplus
                $usernames['googleplus'] = ! empty( get_theme_mod( 'wonkode_googleplus_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_googleplus_link_username' ) ) : '';
                // pinterest
                $usernames['pinterest'] = ! empty( get_theme_mod( 'wonkode_pinterest_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_pinterest_link_username' ) ) : '';
                // linkedin
                $usernames['linkedin'] = ! empty( get_theme_mod( 'wonkode_linkedin_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_linkedin_link_username' ) ) : '';
                // github
                $usernames['github'] = ! empty( get_theme_mod( 'wonkode_github_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_github_link_username' ) ) : '';
                // instagram
                $usernames['instagram'] = ! empty( get_theme_mod( 'wonkode_instagram_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_instagram_link_username' ) ) : '';
                // youtube
                $usernames['youtube'] = ! empty( get_theme_mod( 'wonkode_youtube_link_username' ) ) ? esc_attr( get_theme_mod( 'wonkode_youtube_link_username' ) ) : '';
            }

            $args = wp_parse_args( $args, $usernames );

            /**
             * Filters social media usernames array
             * 
             * @param array $usernames {
             *      Array of social media handles
             *          'facebook',
             *          'twiiter',
             *          'googleplus',
             *          'pinterest',
             *          'linkedin',
             *          'github',
             *          'instagram',
             * }
             * @param array $args Array of usernames provided by user
             */
            return apply_filters( 'wonkode_social_usernames', $args, $usernames );
        }

        /**
         * Returns argument array for social nav 
         * attributes
         * 
         * @since 1.0
         * @return array 
         */
        public static function get_nav_args( $args = array() ) {
            $nav_args = wp_parse_args( $args, self::$nav_args );
            return $nav_args;
        }

        /**
         * Returns social media nav
         * 
         * @since 1.0
         * @return string/mixed
         */
        public static function get_social_nav() {
            // TODO -- 'wonkode_social_usernames' filter can be done here
            // get social usernames
            $social_usernames = self::get_usernames();

            /**
             * check for usernames
             * can use ! count( $social_usernames ) too
             */
            if ( empty( $social_usernames ) ) {
                return;
            }

            // get nav args
            $nav_args = self::get_nav_args();
            // navbar classes
            $navbar_classes = WonKode_Helper::list_classes( $nav_args['navbar_class'], array( 'social-links-nav' ) );
            // nav item classes
            $item_classes = WonKode_Helper::list_classes( $nav_args['item_class'] );
            // link classes
            $link_classes = WonKode_Helper::list_classes( $nav_args['link_class'] );

            // inistantiate output
            $nav_html = '';
            // open nav
            $nav_html .= sprintf(
                '<%1$s class="%2$s" >',
                esc_html( $nav_args['navbar'] ),
                esc_attr( $navbar_classes )
            );
            // build each nav item and nav link
            foreach ( $social_usernames as $medium => $username ) {
                if ( ! empty( $username ) ) {
                    // get social media full url
                    $account_url = self::$social_urls[ $medium ] . $username;
                    // start item
                    $nav_html .= sprintf(
                        '<%1$s class="%2$s"><a class="%3$s" href="%4$s">',
                        esc_html( $nav_args['nav_item'] ),
                        esc_attr( $item_classes ),
                        esc_attr( $link_classes ),
                        esc_url( $account_url )
                    );
                    // get icon
                    $nav_html .= WonKode_Helper::get_fa_stacked_icons( WonKode_Helper::$social_fa_classes[ $medium ] );
                    // end item
                    $nav_html .= sprintf(
                        '</a></%s>',
                        esc_html( $nav_args['nav_item'] )
                    );
                }
            }
            // close nav
            $nav_html .= sprintf(
                '</%s>',
                esc_html( $nav_args['navbar'] )
            );

            return $nav_html;
        }

        /**
         * Callback to display social media nav
         * 
         * @since 1.0
         * @return void
         */
        public static function show_social_nav() {
            if ( get_theme_mod( 'wonkode_display_social_media_nav_title' ) ) {
                echo self::get_nav_title();
            }
            echo self::get_social_nav();
        }

        /**
         * Returns social media nav title
         * 
         * @since 1.0
         * @return string/html Title with full html tag
         */
        public static function get_nav_title() {
            // get title from customize
            $title = get_theme_mod( 'wonkode_social_media_nav_title' );
            // prepare title format
            $nav_title = sprintf( 
                '<h5>' . esc_html__( '%s', self::$txt_dom ) . '</h5>',
                $title
            );

            /**
             * Filters social media nav title
             * 
             * @since 1.0
             * @param string String for html of social nav title
             * @param string String title 
             */
            return apply_filters( 'wonkode_social_nav_title', $nav_title, $title );
        }

    } // ENDS -- class
}