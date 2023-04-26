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
 * Defines action callback to auto detect page 
 * to add pingback header.
 */
add_action( 'wp_head', 'wonkode_auto_pingback_header' );

if ( ! function_exists( 'wonkode_auto_pingback_header' ) ) {
	/**
	 * Add a pingback url auto-discovery header 
	 * for identifiable singular articles.
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_auto_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}

/**
 * Defining function to initialize 
 * custom comment features class.
 */
if ( ! function_exists( 'init_wonkode_comment_feature_hooks' ) ) {
	/**
	 * Instantiates comment feature hooks
	 * 
	 * @since 1.0
	 * @return void
	 */
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

if ( ! function_exists( 'wonkode_get_archive_title_filter' ) ) {
	/**
	 * Filters the default archive title and 
	 * displays title without prefix
	 * 
	 * @since 1.0
	 * @param mixed $title  Title of archive pages
	 * @return mixed        Modified title of archive pages
	 */
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

if ( ! function_exists( 'init_wonkode_social_share_hooks' ) ) {
	/**
	 * Instantiates social media share feature hooks
	 * 
	 * @since 1.0
	 * @return void
	 */
    function init_wonkode_social_share_hooks() {
        // need to get class instance for __construct() function to execute
        $social_media_share_feature = new WonKode_Social_Media_Share_Menu();
        $social_media_share_feature::init_hooks();
    }
}

if ( ! function_exists( 'wonkode_ui_icons_svg_symbols' ) ) {
	/**
	 * Prints SVG symbols for use in different parts of 
	 * content area. Implements action hook which appends 
	 * ui icons.
	 * 
	 * @since 1.0
	 * @param array $args 		{
	 * 		Array of arguments you want to modify in the <symbol> tag
	 * 		while retrieving svg resources. Default is empty.
	 * 			Default values are for icon svg resources
	 * 			@type string 	'view_box'		Value for 'viewBox' attribute. Default "0 0 24 24"
	 * 			@type int 		'size'			Value for 'size' attribute. Default 24
	 * 			@type int 		'stroke_w'		Value for 'stroke-width' attribute. Default 2
	 * 			@type string 	'stroke'		Value for 'stroke' (color) attribute. 
	 * 											Default 'currentColor'
	 * 			@type string 	'fill'			Value for 'fill' (color) attribute. Default 'none'
	 * }
	 * @return void
	 */
	function wonkode_ui_icons_svg_symbols( $args = array() ) {
		?>
		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<?php
			do_action( 'wonkode_append_ui_icons_symbols', $args );
		?>
		</svg>
		<?php
	}
}

add_action( 'wonkode_append_ui_icons_symbols', 'wonkode_append_ui_icons_svg_symbols', 11 );
if ( ! function_exists( 'wonkode_append_ui_icons_svg_symbols' ) ) {
	/**
	 * Callback function to append SVG symbols of ui icons 
	 * using action hook 'wonkode_append_ui_icons_symbols'.
	 * 
	 * @since 1.0
	 * @param array $args 		{
	 * 		Array of arguments you want to modify in the <symbol> tag
	 * 		while retrieving svg resources. Default is empty.
	 * 			Default values are for icon svg resources
	 * 			@type string 	'view_box'		Value for 'viewBox' attribute. Default "0 0 24 24"
	 * 			@type int 		'size'			Value for 'size' attribute. Default 24
	 * 			@type int 		'stroke_w'		Value for 'stroke-width' attribute. Default 2
	 * 			@type string 	'stroke'		Value for 'stroke' (color) attribute. 
	 * 											Default 'currentColor'
	 * 			@type string 	'fill'			Value for 'fill' (color) attribute. Default 'none'
	 * }
	 * @return void
	 */
	function wonkode_append_ui_icons_svg_symbols( $args ) {
		$names = array( 'rocket', 'arrow_big_up', 'arrow_big_down', 'arrow_big_left', 'arrow_big_right' );
		$symbols = WonKode_SVG_Resources::get_icon_symbols( 'ui-icons', $names, $args );
		if ( ! empty( $symbols ) ) {
			echo $symbols;
		}
	}
}

add_action( 'wonkode_append_ui_icons_symbols', 'wonkode_append_social_icons_svg_symbols', 12 );
if ( ! function_exists( 'wonkode_append_social_icons_svg_symbols' ) ) {
	/**
	 * Callback function to action hook 'wonkode_append_ui_icons_symbols' 
	 * to print SVG symbols of social icons.
	 * 
	 * @since 1.0
	 * @param array $args 		{
		 * 		Array of arguments you want to modify in the <symbol> tag
		 * 		while retrieving svg resources. Default is empty.
		 * 			Default values are for icon svg resources
		 * 			@type string 	'view_box'		Value for 'viewBox' attribute. Default "0 0 24 24"
		 * 			@type int 		'size'			Value for 'size' attribute. Default 24
		 * 			@type int 		'stroke_w'		Value for 'stroke-width' attribute. Default 2
		 * 			@type string 	'stroke'		Value for 'stroke' (color) attribute. 
		 * 											Default 'currentColor'
		 * 			@type string 	'fill'			Value for 'fill' (color) attribute. Default 'none'
		 * }
		 * @return void
	 */
	function wonkode_append_social_icons_svg_symbols( $args ) {
		$names = array( 'facebook', 'twitter', 'instagram', 'linkedin' );
		$symbols = WonKode_SVG_Resources::get_icon_symbols( 'social-icons', $names, $args );
		if ( ! empty( $symbols ) ) {
			echo $symbols;
		}
	}
}

add_action( 'wonkode_page_section_title', 'wonkode_show_page_section_title', 99 );
if ( ! function_exists( 'wonkode_show_page_section_title' ) ) {
	/**
	 * Callback function to display page section title
	 * 
	 * @since 1.0
	 * @param string $section_title  Title for page section
	 * @return void
	 */
	function wonkode_show_page_section_title( $section_title ) {
		if ( empty( $section_title ) ) {
			return;
		}
		?>
		<div class="section-title-wrapper">
			<div class="b4-title-shape"></div>
			<h1 class="page-section-title"><?php echo esc_html( $section_title ); ?></h1>
		</div>
		<?php
	}
}


if ( ! function_exists( 'wonkode_get_post_navigation_html' ) ) {
	/**
	 * Function to get post navigation html template.
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
	function wonkode_get_post_navigation_html( $class, $args = array() ) {
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
add_filter( 'navigation_markup_template', 'wonkode_get_post_navigation_template', 99, 2 );
if ( ! function_exists( 'wonkode_get_post_navigation_template' ) ) {
	function wonkode_get_post_navigation_template( $template, $class = 'post-navigation' ) {
		$template = wonkode_get_post_navigation_html( $class );
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

/**
 * Filter to modify default excerpt length
 */
add_filter( 'excerpt_length', 'wonkode_modified_excerpt_length', 999 );

if ( ! function_exists( 'wonkode_modified_excerpt_length' ) ) {
	/**
	 * Callback that filters the maximum 
	 * number of words in a post excerpt.
	 * 
	 * @since 1.0
	 * 
	 * @param int $length 	The maximum number of words. Default 55
	 * @return int 			Modified number of words on frontpage. 
	 * 						The default on other pages.
	 */
	function wonkode_modified_excerpt_length( $length ) {
		if ( is_front_page() && is_home() ) {
			return 20;
		} else {
			return $length;
		}
	}
}

/**
 * Custom filter that modifies excerpt ellipses 
 * from [...] to ...
 */
add_filter( 'excerpt_more', 'wonkode_excerpt_more_ellipses' );

if ( ! function_exists( 'wonkode_excerpt_more_ellipses' ) ) {
	/**
	 * Callback that filters the string 
	 * in the “more” link displayed 
	 * after a trimmed excerpt.
	 * 
	 * @since 1.0
	 * @param string $more	The string shown within the more link.
	 * @return string 		Modified string after the trimmed excerpt.
	 */
	function wonkode_excerpt_more_ellipses( $more ) {
		return "&nbsp;&hellip;";
	}
}


