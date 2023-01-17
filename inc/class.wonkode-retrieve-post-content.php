<?php
/**
 * Class to retrieve content of current post in the loop
 * 
 * @uses core's '/wp-includes/post-template.php'
 * 
 * @package WonKode
 * @since 1.0
 */
// restrict direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Retrieve_Post_Content' ) ) {
    class WonKode_Retrieve_Post_Content {
        /**
         * Theme identifier, namespace
         * 
         * @since 1.0
         * @var string 
         */
        public $theme_id;
        /**
         * Theme's unique prefix id
         * 
         * @since 1.0
         * @var string
         */
        public $unique_prefix;
        /**
         * Holds the post object
         * 
         * @access private
         * @since 1.0
         * @var object|null
         */
        private $the_post;
        /**
         * Class constructor
         */
        public function __construct() {
            // setting theme identity
            $this->theme_id = WonKode_Helper::get_texdomain();
            // set theme unique prefix
            $this->unique_prefix = WonKode_Helper::get_unique_prefix();
        }
        /**
         * Returns post id
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return int post id
         */
        public function get_id( $post = null ) {
            $_post = get_post( $post );
            return ! empty( $_post ) ? $_post->ID : false;
        }
        /**
         * Returns the post object
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return WP_Post|array|null
         */
        protected function get_the_post( $post = null ) {
            $post_id = $this->get_id( $post );
            return $post_id ? get_post( $post_id ) : null;
        }
        /**
         * Checks if post status is private
         * For internal use only
         * 
         * @access private
         * @param WP_Post $_post    WP_Post object. 
         * @return bool true if private
         */
        private function post_is_private( $_post ) {
            return isset( $_post->post_status ) && 'private' === $_post->post_status;
        }
        /**
         * Checks if post status is password protected
         * For internal use only
         * 
         * @access private
         * @param WP_Post $_post    WP_Post object. 
         * @return bool true if password protected
         */
        private function post_is_protected( $_post ) {
            return ! empty( $_post->post_password );
        }
        /**
         * Checks if accessing post is allowed. 
         * Returns true if user is admin or 
         * not both password protected and private
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`. 
         * @return bool true if access is allowed
         */
        public function post_access_allowed( $post = null ) {
            $_post = $this->get_the_post( $post );
            return is_admin() || ! ( $this->post_is_private( $_post ) || $this->post_is_protected( $_post ) );
        }
        /**
         * Returns post title
         * 
         * @since 1.0
         * @param int|WP_Post|null $post Post id or WP_Post object. Defaults null
         * @param string title of post
         */
        public function get_title( $post = null ) {
            if ( ! $this->post_access_allowed( $post ) ) {
                return;
            }
            $_post = $this->get_the_post( $post );
            $post_title = isset( $_post->post_title ) ? $_post->post_title : '';
            $post_id = isset( $_post->ID ) ? $_post->ID : 0;
            /**
             * Filter the title
             */
            $post_title = apply_filters( 'the_title', $post_title, $post_id );
            // strip tags
            $post_title = strip_tags( $post_title );
            /**
             * Filters the post title.
             * 
             * @since 1.0
             * @param string $post_title The post title.
             * @param int    $post_id    The post ID.
             */
            return apply_filters( $this->unique_prefix . '_post_title', $post_title, $post_id );
        }
        /**
         * Returns post's title anchor tag
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return mixed link of post title
         */
        public function get_title_anchor( $post = null ) {
            if ( ! $this->post_access_allowed( $post ) ) {
                return;
            }
            $_post = $this->get_the_post( $post );
            $post_title = $this->get_title( $post );
            $post_id = $_post->ID;
            $title_link = get_permalink( $post_id );
            $title_anchor = '';
            if ( ! empty( $post_title ) ) {
                $title_anchor = sprintf( 
                    '<a href="%1$s" rel="bookmark">%2$s</a>',
                    esc_url( $title_link ),
                    sprintf( __( '%s', $this->theme_id ), esc_html( $post_title ) ) 
                );
            }
            /**
             * Filters title link element
             * 
             * @since 1.0
             * @param mixed $title_anchor   html anchor element containing title link
             * @param string $title_link    url of tile link
             * @param string $post_tile     Title of post
             */
            return apply_filters( $this->unique_prefix . '_title_anchor', $title_anchor, $title_link, $post_title );
        }
        /**
         * Renders post's title anchor tag
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return void
         */
        public function the_title_anchor( $post = null ) {
            echo $this->get_title_anchor( $post );
        }
        /**
         * Returns post's excerpt
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return string excerpt of post
         */
        public function get_excerpt( $post = null ) {
            if ( ! $this->post_access_allowed( $post ) ) {
                return;
            }
            $_post = $this->get_the_post( $post );

            $excerpt_text = '';
            $excerpt = wp_strip_all_tags( get_the_excerpt( $_post->ID ) );
            if ( ! empty( $excerpt ) ) {
                $excerpt_text .= sprintf( __( '%s', $this->theme_id ), $excerpt );
            }
            return $excerpt_text;
        }
        /**
         * Returns post content
         * 
         * @since 1.0
         * @param int|WP_Post|null $post Post id or WP_Post object. Defaults null
         * @param string Content of post
         */
        public function get_content( $post = null ) {
            if ( ! $this->post_access_allowed( $post ) ) {
                return;
            }
            $post = $this->get_the_post( $post );

            $content = get_the_content();
            //Apply "the_content" filter : formats shortcodes etc.
            $content = apply_filters( 'the_content', $content );
            $content = str_replace( ']]>', ']]&gt;', $content );
            $allowed_tags = '<br/><br><p><div><h1><h2><h3><h4><h5><h6><a><span><sup><sub><img><i><em><strong><b><ul><ol><li><blockquote><pre>';
            /**
             * Filters allowed tags for post content
             * 
             * @since 1.0
             * @param string $allowed_tags  Allowed tags for post content
             * @param WP_Post $post         WP_Post object
             */
            $allowed_tags = apply_filters( $this->unique_prefix . '_content_allowed_tags', $allowed_tags, $post );
            // strip tags
            $content = strip_tags( $content, $allowed_tags );
            /**
             * Filters post content
             * 
             * @since 1.0
             * @param string $content Content of current post
             * @param object $post WP_Post object
             */
            $content = apply_filters( $this->unique_prefix . '_post_content', $content, $post );
        }
        /**
         * Renders post's excerpt in paragraph
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return void
         */
        public function the_post_excerpt( $post = null ) {
            echo '<p>' . $this->get_excerpt( $post ) . '</p>';
        }


    } // ENDS --- class
}