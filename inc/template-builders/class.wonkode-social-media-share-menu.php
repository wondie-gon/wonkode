<?php
/**
 * Class for social media sharing nav menu
 * 
 * @since 1.0
 * @package WonKode
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Social_Media_Share_Menu' ) ) {
    class WonKode_Social_Media_Share_Menu {
        /**
         * Theme text domain id
         * 
         * @since 1.0
         */
        public static $txt_dom = null;
        /**
         * Unique id for prefix
         * 
         * @since 1.0
         * @var string
         */
        public static $prefix_id;
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
         * Check if social media share feature
         * enabled in theme customizer
         * 
         */
        public static $social_share_enabled = false;
        /**
         * Class constructor
         */
        public function __construct() {
            // set theme name, that is the textdomain
            self::$txt_dom = WonKode_Helper::get_texdomain();
            // set the unique prefix
            self::$prefix_id = WonKode_Helper::get_unique_prefix();
            // is feature enabled
            self::$social_share_enabled = get_theme_mod( 'enable_' . self::$prefix_id . '_social_media_sharing' );
        }

        /**
         * Initializes hooks in relation to 
         * social media sharing features 
         * 
         * @since 1.0
         */
        public static function init_hooks() {
            // add jQuery hook to wp_footer if feature enabled
            if ( self::$social_share_enabled ) {
                add_action( 'wp_footer', array( 'WonKode_Social_Media_Share_Menu', 'open_new_social_share_window' ) );
            }
        }

        /**
         * Display social sharing menu
         * 
         * @since 1.0
         * @return void
         */
        public static function show_nav() {
            echo self::get_nav();
        }
        /**
         * Returns array of social media from theme customizer
         * with values if they are enabled for sharing posts
         * 
         * @since 1.0
         * @return array    Array of social media with each value
         *                  if it is enabled for sharing
         */
        public static function get_social_share_activations() {
            $enabled_shares = array(
                'facebook'      =>  get_theme_mod( self::$prefix_id . '_enable_facebook_share' ),
                'twitter'       =>  get_theme_mod( self::$prefix_id . '_enable_twitter_share' ),
                'googleplus'    =>  get_theme_mod( self::$prefix_id . '_enable_googleplus_share' ),
                'pinterest'     =>  get_theme_mod( self::$prefix_id . '_enable_pinterest_share' ),
                'linkedin'      =>  get_theme_mod( self::$prefix_id . '_enable_linkedin_share' ),
            );
            return $enabled_shares;
        }
        /**
         * Returns social media sharing nav
         * 
         * @since 1.0
         * @return string/mixed
         */
        public static function get_nav() {
            // get enabled social media
            $enabled_socials = self::get_social_share_activations();

            // social share links
            $share_link_elems = array();
            foreach ( $enabled_socials as $key => $value ) {
                if ( $value ) {
                    $share_link_elems[ $key ] = self::get_social_share_link( $key );
                }
            }
            /**
             * check if there are any 
             * social link elements
             */
            if ( empty( $share_link_elems ) ) {
                return;
            }
            // navbar classes
            $navbar_classes = WonKode_Helper::list_classes( self::$nav_args['navbar_class'], array( 'social-share-nav' ) );
            // nav item classes
            $item_classes = WonKode_Helper::list_classes( self::$nav_args['item_class'] );

            // inistantiate output
            $nav_html = '';
            // open nav
            $nav_html .= sprintf(
                '<%1$s class="%2$s" >',
                esc_html( self::$nav_args['navbar'] ),
                esc_attr( $navbar_classes )
            );
            // share title, or share icon
            $nav_html .= self::get_share_title();
            // build each nav item and nav link
            foreach ( $share_link_elems as $link_elem ) {
                // start item
                $nav_html .= sprintf(
                    '<%1$s class="%2$s">%3$s</%4$s>',
                    esc_html( self::$nav_args['nav_item'] ),
                    esc_attr( $item_classes ),
                    $link_elem,
                    esc_html( self::$nav_args['nav_item'] )
                );
            }
            // close nav
            $nav_html .= sprintf(
                '</%s>',
                esc_html( self::$nav_args['navbar'] )
            );
            // return share menu
            return $nav_html;
        }
        /**
         * Returns social share link by medium name
         * 
         * @since 1.0
         * @param string $name  Name of social medium
         * @return string/html  Link element of the passed medium
         */
        public static function get_social_share_link( $name ) {
            // get all share links
            $social_links = self::get_social_share_links();
            // get by medium name
            if ( ! ( $name ) || ! ( array_key_exists( $name, $social_links ) ) ) {
                return;
            }
            // return the link
            return $social_links[ $name ];
        }
        /**
         * Returns array of social media share links
         * 
         * @since 1.0
         * @return array    Array of social media share links
         */
        public static function get_social_share_links() {
            $social_links = array(
                'facebook'      =>  self::get_facebook_link(),
                'twitter'       =>  self::get_twitter_link(),
                'googleplus'    =>  self::get_googleplus_link(),
                'pinterest'     =>  self::get_pinterest_link(),
                'linkedin'      =>  self::get_linkedIn_link(),
            );
            return $social_links;
        }
        /**
         * Returns share link element for Facebook
         * 
         * @since 1.0
         * @return string/html mixed Full link element for 
         *                           sharing to Facebook
         */
        private static function get_facebook_link() {
            // get link class
            $link_classes = self::get_link_class( array( 'social-share-link social_facebook' ) );
            // get the fontawesome icon
            $fa_icon = WonKode_Helper::get_fa_stacked_icons( 'fab fa-facebook-f' );
            // prepare share full url
            $permalink = get_permalink();
            $description = get_the_title() . '-' . get_bloginfo( 'name' );
            $share_url = "https://www.facebook.com/sharer.php?u={$permalink}&t={$description}";
            // title attribute value
            $title = esc_attr__( 'Share on Facebook', self::$txt_dom );
            // preparing output format
            $link = sprintf(
                '<a title="%1$s" href="%2$s" class="%3$s" data-toggle="pill">%4$s</a>',
                $title,
                esc_url( $share_url ),
                esc_attr( $link_classes ),
                $fa_icon
            );
            // return the link element
            return $link;
        }
        /**
         * Returns share link element for twitter
         * 
         * @since 1.0
         * @return string/html mixed Full link element for 
         *                           sharing to twitter
         */
        private static function get_twitter_link() {
            // get link class
            $link_classes = self::get_link_class( array( 'social-share-link social_twitter' ) );
            // get the fontawesome icon
            $fa_icon = WonKode_Helper::get_fa_stacked_icons( 'fab fa-twitter' );
            // intro text
            $intro = __( 'Check this out!', self::$txt_dom );
            // prepare share full url
            $permalink = get_permalink();
            $title_long = get_the_title() . '-' . get_bloginfo( 'name' );
            $share_url = "https://twitter.com/intent/tweet?text={$title_long} {$intro}&url={$permalink}";
            // title attribute value
            $title = esc_attr__( 'Share on Twitter', self::$txt_dom );
            // preparing output format
            $link = sprintf(
                '<a title="%1$s" href="%2$s" class="%3$s" data-toggle="pill">%4$s</a>',
                $title,
                esc_url( $share_url ),
                esc_attr( $link_classes ),
                $fa_icon
            );
            // return the link element
            return $link;
        }
        /**
         * Returns share link element for googleplus
         * 
         * @since 1.0
         * @return string/html mixed Full link element for 
         *                           sharing to googleplus
         */
        private static function get_googleplus_link() {
            // get link class
            $link_classes = self::get_link_class( array( 'social-share-link social_gplus' ) );
            // get the fontawesome icon
            $fa_icon = WonKode_Helper::get_fa_stacked_icons( 'fab fa-google-plus-g' );
            // prepare share full url
            $permalink = get_permalink();
            $share_url = "https://plus.google.com/share?url={$permalink}";
            // title attribute value
            $title = esc_attr__( 'Share on Google+', self::$txt_dom );
            // preparing output format
            $link = sprintf(
                '<a title="%1$s" href="%2$s" class="%3$s" data-toggle="pill">%4$s</a>',
                $title,
                esc_url( $share_url ),
                esc_attr( $link_classes ),
                $fa_icon
            );
            // return the link element
            return $link;
        }
        /**
         * Returns share link element for pinterest
         * 
         * @since 1.0
         * @return string/html mixed Full link element for 
         *                           sharing to pinterest
         */
        private static function get_pinterest_link() {
            // get link class
            $link_classes = self::get_link_class( array( 'social-share-link social_pinterest' ) );
            // get the fontawesome icon
            $fa_icon = WonKode_Helper::get_fa_stacked_icons( 'fab fa-pinterest-p' );
            // image url
            $img_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
            // get description
            $permalink = get_permalink();
            $description = get_the_title() . ' - ' . get_bloginfo( 'name' );
            // prepare share full url
            $share_url = "https://www.pinterest.com/pin/create/button/?url={$permalink}&media={$img_url}&description={$description}";
            // title attribute value
            $title = esc_attr__( 'Share on Pinterest', self::$txt_dom );
            // preparing output format
            $link = sprintf(
                '<a title="%1$s" href="%2$s" class="%3$s" data-toggle="pill">%4$s</a>',
                $title,
                esc_url( $share_url ),
                esc_attr( $link_classes ),
                $fa_icon
            );
            // return the link element
            return $link;
        }
        /**
         * Returns share link element for linkedIn
         * 
         * @since 1.0
         * @return string/html mixed Full link element for 
         *                           sharing to linkedIn
         */
        private static function get_linkedIn_link() {
            // get link class
            $link_classes = self::get_link_class( array( 'social-share-link social_linkedin' ) );
            // get the fontawesome icon
            $fa_icon = WonKode_Helper::get_fa_stacked_icons( 'fab fa-linkedin-in' );
            // get permalink
            $permalink = get_permalink();
            // get description
            $description = get_the_title() . ' - ' . get_bloginfo( 'name' );
            // prepare share full url
            $share_url = "https://www.linkedin.com/shareArticle?mini=true&url={$permalink}&title={$description}&summary={$description}";
            // title attribute value
            $title = esc_attr__( 'Share on LinkedIn', self::$txt_dom );
            // preparing output format
            $link = sprintf(
                '<a title="%1$s" href="%2$s" class="%3$s" data-toggle="pill">%4$s</a>',
                $title,
                esc_url( $share_url ),
                esc_attr( $link_classes ),
                $fa_icon
            );
            // return the link element
            return $link;
        }
        /**
         * Internal to get class of link classes
         * 
         * @access private
         * 
         * @since 1.0
         * @param array $additionals Array of additional classes 
         * @return string List of class
         */
        private static function get_link_class( $additionals = array() ) {
            return WonKode_Helper::list_classes( self::$nav_args['link_class'], $additionals );
        }
        /**
         * Returns social media share title
         * 
         * @since 1.0
         * @return string/html Title with full html tag
         */
        public static function get_share_title() {
            // get title from customize
            $title = ( get_theme_mod( self::$prefix_id . '_display_social_media_share_title' ) && ! empty( get_theme_mod( self::$prefix_id . '_social_media_share_title' ) ) ) ? esc_html__( get_theme_mod( self::$prefix_id . '_social_media_share_title' ) ) : WonKode_Helper::get_fa_icon( 'fa fa-share-alt' );

            // nav item classes
            $item_classes = WonKode_Helper::list_classes( self::$nav_args['item_class'], array( 'title-item' ) );
            // prepare title format
            $share_title = sprintf( 
                '<%1$s class="%2$s">%3$s</%4$s>',
                self::$nav_args['nav_item'],
                esc_attr( $item_classes ),
                $title,
                self::$nav_args['nav_item']
            );

            /**
             * Filters social media nav title
             * 
             * @since 1.0
             * @param string String for html of social nav title
             * @param string String title 
             */
            return apply_filters( self::$prefix_id . '_social_share_title', $share_title, $title );
        }

        /**
         * Returns argument array for social share menu 
         * attributes
         * 
         * @since 1.0
         * @return array 
         */
        public static function get_nav_args( $args = array() ) {
            // filter argument first
            $args = array_filter( $args, function( $a ) {
                return ( isset( $a ) && is_string( $a ) && ! ( '' === $a || null === $a ) );
            } );
            // parsing filtered with existing prop
            $nav_args = wp_parse_args( $args, self::$nav_args );
            // return nav args
            return $nav_args;
        }
        /**
         * Hook to add jQuery anonymous function to open 
         * new window social media sharing feature
         * 
         * @since 1.0
         * @return void
         */
        public static function open_new_social_share_window() {
            if ( is_single() ) {
                ?>
                <script type="text/javascript">
                    ( function( $ ) {
                        var left_win = ( screen.width - 540 ) / 2;
                        var top_win = ( screen.height - 540 ) / 2;
                        var params = "menubar=no, toolbar=no, status=no, width=540, height=450, top=" + top_win + ", left=" + left_win;
    
                        $( 'a.social-share-link' ).on( 'click', function( event ) {
                            event.preventDefault();
                            var href = $( this ).attr( 'href' );
                            window.open( href, "NewWindow", params );
                        } );
    
                    } )( jQuery );
                  </script>
                <?php
            }
        }

    } //ENDS -- class
}