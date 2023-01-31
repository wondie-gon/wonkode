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

/**
 * Action function to display post navigation. 
 * 
 * Hooked to: self::$unique_prefix . '_post_navigation' 
 * action hook.
 * 
 * @see https://developer.wordpress.org/reference/functions/get_the_post_navigation/
 * 
 * @since 1.0
 * 
 * @param string $class Class for post navigation wrapper
 * @param array $args 	Arguments for post navigation
 * @return mixed Post navigation html block
 */
if ( ! function_exists( 'wonkode_get_post_navigation_template' ) ) {
	function wonkode_get_post_navigation_template( $class, $args = array() ) {
		$args = wp_parse_args(
			$args, 
			array(
				'format'            	=> '%link',
				'prev_icon'         	=> '<i class="fas fa-arrow-left"></i>',
				'next_icon'         	=> '<i class="fas fa-arrow-right"></i>',
				'link'              	=> '%title',
				'in_same_term'      	=> false,
				'excluded_terms'    	=> '',
				'taxonomy'          	=> 'category',
				'screen_reader_text'	=> __( 'Posts Navigation', 'wonkode' ),
				'aria_label'        	=> __( 'Posts', 'wonkode' ),
			)
		);
	
		$prev_link = $args['prev_icon'] . ' ' . $args['link'];
		$next_link = $args['link'] . ' ' . $args['next_icon'];
	
		// post navigation template
		$template = '<nav class="navigation %1$s"';
		$template .= ' aria-label="' . esc_html( $args['aria_label'] ) . '">';
		$template .= '<h2 class="screen-reader-text">' . esc_html( $args['screen_reader_text'] ) . '</h2>';
		$template .= '<ul class="pagination justify-content-center">';
	
		// prev post link item
		$template .= '<li class="page-item">';
		$template .= get_previous_post_link( $args['format'], $prev_link, $args['in_same_term'], $args['excluded_terms'], $args['taxonomy'] );
		$template .= '</li>';
	
		// next post link item
		$template .= '<li class="page-item">';
		$template .= get_next_post_link( $args['format'], $next_link, $args['in_same_term'], $args['excluded_terms'], $args['taxonomy'] );
		$template .= '</li>';
	
		$template .= '</ul>';
		$template .= '</nav>';
	
		/**
		 * Filters post navigation markup
		 */
		$template = apply_filters( 'wonkode_navigation_markup_template', $template, sanitize_html_class( $class ) );
	
		return $template;
		
	}
}

/**
 * Filter hook to modify post navigation markup.
 * 
 * Enables to display modified post navigation 
 * using the_post_navigation() core template tag.
 * 
 * @since 1.0
 * @param mixed $template Post navigation html output
 * @param string $class Class for post navigation wrapper
 * @return mixed Post navigation html
 */
add_filter( 'navigation_markup_template', 'wonkode_get_post_navigation_template' );
if ( ! function_exists( 'wonkode_get_post_navigation' ) ) {
	function wonkode_get_post_navigation( $template, $class = 'post-navigation' ) {
		$template = wonkode_get_post_navigation_template( $class );
		return $template;
	}
}

/**
 * Function implements display of custom post 
 * navigation action.
 * 
 * Enables to use wonkode_show_post_navigation() 
 * custom template tag to display post navigation.
 * 
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'wonkode_show_post_navigation' ) ) {
	function wonkode_show_post_navigation() {
		do_action( 'wonkode_post_navigation' );
	} 
}

/**
 * Add to filter hook to add class to 
 * post navigation links output.
 */
add_filter( 'next_post_link', 'wonkode_post_nav_link_filter' );
add_filter( 'previous_post_link', 'wonkode_post_nav_link_filter' );

if ( ! function_exists( 'wonkode_post_nav_link_filter' ) ) {
	/**
	 * Filter function that filters out 
	 * post navigation link output, useful 
	 * for styling post navigation.
	 * 
	 * @since 1.0
	 * @param mixed $html Post link output
	 * @return mixed Modified post link tag
	 */
	function wonkode_post_nav_link_filter( $html ) {
		$html = str_replace( '<a ', '<a class="page-link" ', $html );
		return $html;
	}
}