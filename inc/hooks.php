<?php
/**
 * Holds most hooks and callback functions of theme. 
 * Also initializes hooks from classes.
 * 
 * ===Note===
 * After including file to 'functions.php', some functions
 * need to be called for the hooks to start execution, especially 
 * those from classes.
 * 
 * @package WonKode
 * @since 1.0
 */
// disallow direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Instantiates comment feature hooks
 * 
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'init_wonkode_comment_feature_hooks' ) ) {
    function init_wonkode_comment_feature_hooks() {
        // No __construct() function, no need to instantiate class
        WonKode_Comments_Feature::init_hooks();
    }
}
/**
 * Filters the default archive title and 
 * displays title without prefix
 * 
 * @since 1.0
 * @return mixed Modified title of archive pages
 */
add_filter( 'get_the_archive_title', 'wonkode_get_archive_title_filter' );
/**
 * Filters the default archive title and 
 * displays title without prefix
 * 
 * @since 1.0
 * @param mixed $title  Title of archive pages
 * @return mixed        Modified title of archive pages
 */
if ( ! function_exists( 'wonkode_get_archive_title_filter' ) ) {
	function wonkode_get_archive_title_filter( $title ) {
		if ( is_category() ) {
			$title  = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title  = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title  = '<i class="fa fa-user me-2"></i>' . get_the_author();
		} elseif ( is_post_type_archive() ) {
			$title  = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title  = single_term_title( '', false );
		}
		return $title;
	}
}
/**
 * Instantiates social media share feature hooks
 * 
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'init_wonkode_social_share_hooks' ) ) {
    function init_wonkode_social_share_hooks() {
        // need to get class instance for __construct() function to execute
        $social_media_share_feature = new WonKode_Social_Media_Share_Menu();
        $social_media_share_feature::init_hooks();
    }
}