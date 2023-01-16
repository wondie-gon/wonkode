<?php
/**
 * Class to be used to retrieve post data
 * 
 * @package WonKode
 * @since 1.0
 */
// restrict direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Retrieve_Posts' ) ) {
    class WonKode_Retrieve_Posts {
        /**
         * Theme identifier, namespace
         * 
         * @since 1.0
         * @var string 
         */
        public $theme_id;
        /**
         * Class constructor
         */
        public function __construct() {
            // setting theme identity
            $theme_obj = wp_get_theme();
            if ( $theme_obj->exists() ) {
                $this->theme_id = $theme_obj->get( 'TextDomain' );
            } else {
                $this->theme_id = get_stylesheet();
            }
        }
        /**
         * Returns post id
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return int post id
         */
        public function get_id( $post = null ) {
            if ( $post ) {
                $_post = get_post( $post );
                return $_post->ID;
            } else {
                return get_the_ID();
            }
        }
        /**
         * Returns post's title anchor tag
         * 
         * @param int|WP_Post $post Optional.   Post ID or WP_Post object. 
         *                                      Default is global `$post`.
         * @return mixed link of post title
         */
        public function get_title_anchor( $post = null ) {
            $post_id = $this->get_id( $post );
            $title_anchor = sprintf( 
                '<a href="%1$s" rel="bookmark">%2$s</a>',
                esc_url( get_permalink( $post_id ) ),
                sprintf( __( '%s', $this->theme_id ), esc_html( get_the_title( $post_id ) ) ) 
            );
            return $title_anchor;
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
            $post_id = $this->get_id( $post );
            $excerpt_text = '';
            $excerpt = wp_strip_all_tags( get_the_excerpt( $post_id ) );
            if ( ! empty( $excerpt ) ) {
                $excerpt_text .= sprintf( __( '%s', $this->theme_id ), $excerpt );
            }
            return $excerpt_text;
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