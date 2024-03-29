<?php
/**
 * Custom template tags for theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 * 
 * @package WonKode
 * @since 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * Defines custom conditional function to check 
 * page is not a single post.
 */
if ( ! function_exists( 'wonkode_is_not_single_post' ) ) {
	/**
	 * Checks if query is not for a single post, 
	 * or not singular of any post type, except page.
	 * 
	 * @since 1.0
	 * @return bool True if query is not single post.
	 */
	function wonkode_is_not_single_post() {
		return ! is_single() || ( ! is_singular() || is_page() );
	}
}

/**
 * Prints HTML with meta information for 
 * the current post-date/time and author.
 */
if ( ! function_exists( 'wonkode_posted_on_by_meta' ) ) {
	/**
	 * Prints HTML with meta information for both 
	 * the current post-date/time and author in one line.
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_posted_on_by_meta() {
		global $wonkode_content_template_parts;
		$wonkode_content_template_parts::post_date_and_author_meta_nav();
	}
}
/**
 * Minimal posted on time.
 */
if ( ! function_exists( 'wonkode_minimal_posted_on' ) ) {
	/**
	 * Renders a minimal posted on date meta 
	 * without date of updates.
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_minimal_posted_on() {
		global $wonkode_content_template_parts;
		$wonkode_content_template_parts::minimal_posted_on();
	}
}

if ( ! function_exists( 'wonkode_get_minimal_posted_on' ) ) {
	/**
	 * Returns a minimal posted on date meta 
	 * without date of updates.
	 * 
	 * @since 1.0
	 * @return mixed Post date meta.
	 */
	function wonkode_get_minimal_posted_on() {
		global $wonkode_content_template_parts;
		return $wonkode_content_template_parts::get_minimal_posted_on();
	}
}

if ( ! function_exists( 'wonkode_minimal_posted_by' ) ) {
	/**
	 * Renders a minimal posted by author meta 
	 * only.
	 * 
	 * @since 1.0
	 * @return void
	 */
	function wonkode_minimal_posted_by() {
		global $wonkode_content_template_parts;
		$wonkode_content_template_parts::minimal_posted_by();
	}
}

if ( ! function_exists( 'wonkode_get_minimal_posted_by' ) ) {
	/**
	 * Returns a minimal posted by author meta 
	 * only.
	 * 
	 * @since 1.0
	 * @return mixed Post author meta.
	 */
	function wonkode_get_minimal_posted_by() {
		global $wonkode_content_template_parts;
		return $wonkode_content_template_parts::get_minimal_posted_by();
	}
}

/**
 * Template function to display category 
 * link list.
 */
if ( ! function_exists( 'wonkode_the_category_list_block' ) ) {
	/**
	 * Prints HTML of list of categories.
	 * 
	 * @since 1.0
	 * @param bool $with_icon 		Whether to display category 
	 * 								link badges with icons on start 
	 * 								of badges. Defaults: false.
	 * @param string $block_class	List/s of classes to add to 
	 * 								category links block.
	 * 								Defaults: empty
	 * @return void
	 */
	function wonkode_the_category_list_block( $with_icon = false, $block_class = '' ) {
		// global variable for template builder class
		global $wonkode_content_template_parts;
		// if not post or has no category, exit mission
		if ( 'post' !== get_post_type() || ! has_category() ) {
			return;
		}
		// default categories list block classes
		$cat_block_classes = array( 'cat-links' );
		// sanitize class
		$block_class = sanitize_html_class( $block_class );
		// add to defaults
		if ( ! empty( $block_class ) ) {
			WonKode_Helper::add_to_classes( $block_class, $cat_block_classes );
		}
		// prepare class list
		$cat_block_cls_list = WonKode_Helper::list_classes( $cat_block_classes );

		// print category links block
		echo '<div class="' . $cat_block_cls_list . '">';
		echo $wonkode_content_template_parts::get_categories_list( $with_icon );
		echo '</div>';
	}
}

/**
 * Template function to display tag 
 * links list.
 */
if ( ! function_exists( 'wonkode_the_tag_list_block' ) ) {
	/**
	 * Prints HTML of list of tag links
	 * as badges.
	 * 
	 * @since 1.0
	 * @param bool $with_icon 		Whether to display category 
	 * 								link badges with icons on start 
	 * 								of badges. Defaults: false.
	 * @param string $block_class	List/s of classes to add to 
	 * 								tags links block.
	 * 								Defaults: empty
	 * @return void
	 */
	function wonkode_the_tag_list_block( $with_icon = false, $block_class = '' ) {
		// global variable for template builder class
		global $wonkode_content_template_parts;

		// if not post or has no tags, exit mission
		if ( 'post' !== get_post_type() || ! has_tag() ) {
			return;
		}
		// default tags list block classes
		$tag_block_classes = array( 'tag-links' );
		// sanitize class
		$block_class = sanitize_html_class( $block_class );
		// add to defaults
		if ( ! empty( $block_class ) ) {
			WonKode_Helper::add_to_classes( $block_class, $tag_block_classes );
		}
		// prepare class list
		$tag_block_cls_list = WonKode_Helper::list_classes( $tag_block_classes );

		// print tags links block
		echo '<div class="' . $tag_block_cls_list . '">';

		echo $wonkode_content_template_parts::get_post_tags_list( $with_icon );

		echo '</div>';
	}
}

/**
 * Prints background image style 
 * for page headers.
 */
if ( ! function_exists( 'wonkode_page_header_bg_img_style' ) ) {
	/**
	 * Prints background image style for page headers
	 * 
	 * @since 1.0
	 * @param string  $asset_img_file Optional. Image file name in 
	 * 											assets folder of theme.
	 * @return void
	 */
	function wonkode_page_header_bg_img_style( $asset_img_file = '' ) {
		$hdr_bg_style = wonkode_get_page_header_bg_img_style( $asset_img_file );
		echo $hdr_bg_style;
	}
}

/**
 * Function to get background image style 
 * for page headers
 */
if ( ! function_exists( 'wonkode_get_page_header_bg_img_style' ) ) {
	/**
	 * Returns background image style for page headers
	 * 
	 * @since 1.0
	 * @param string  $asset_img_file	Optional. Image file name 
	 * 								in assets folder of theme.
	 * @return string 	A style attribute to be used inside header 
	 * 					html tags to set its background image
	 */
	function wonkode_get_page_header_bg_img_style( $asset_img_file = '' ) {
		if ( empty( $asset_img_file ) ) {
			// get image url for header
			$header_img_url = wonkode_get_page_header_bg_img_url();
		} else {
			$header_img_url = wonkode_get_page_header_bg_img_url( $asset_img_file );
		}
		// prepare style attribute with properties
		$wonkode_header_bg_style = ( ! empty( $header_img_url ) ) ? ' style="min-height: 200px; background-image: url(' . esc_url( $header_img_url ) . '); background-repeat: no-repeat; background-position: center; background-size: cover; background-attachment: fixed;"' : '';

		/**
		 * Filters page header background image style 
		 * with all relevant properties
		 * 
		 * @since 1.0
		 * @param string $wonkode_header_bg_style	header background image style 
		 * 											with all relevant properties
		 * @param string $header_img_url			Url for image to use as header 
		 * 											background image
		 */
		return apply_filters( 'wonkode_header_bg_style', $wonkode_header_bg_style, $header_img_url );
	}
}

/**
 * Function to get post thumbnail url or asset image url, or 
 * the set header image url.
 */
if ( ! function_exists( 'wonkode_get_page_header_bg_img_url' ) ) {
	/**
	 * Returns post thumbnail url or asset image url, or 
	 * the set header image url of the theme for background 
	 * image of page header
	 * 
	 * @since 1.0
	 * @param string  $asset_img_file Optional. Image file name in assets folder of theme.
	 * @return string Url of image that can be used for background image value
	 */
	function wonkode_get_page_header_bg_img_url( $asset_img_file = '' ) {
		$img_url = '';
		if ( ( is_page() || is_single() ) && has_post_thumbnail() ) {
			$img_url = get_the_post_thumbnail_url( null, 'full' );
		} else {
			if ( $asset_img_file && wonkode_get_theme_asset_img_url( $asset_img_file ) ) {
				$img_url = wonkode_get_theme_asset_img_url( $asset_img_file );
			} elseif ( ! wonkode_get_theme_asset_img_url( $asset_img_file ) ) {
				// $img_url = get_random_header_image();
				$img_url = get_header_image();
			} else {
				$img_url = '';
			}
		}
		/**
		 * Filters image url for page heaader
		 * 
		 * @since 1.0
		 * @param string $img_url Url of image for page header background
		 * @param string $asset_img_file Image file name in assets folder of theme 
		 */
		return apply_filters( 'wonkode_header_img_url', $img_url, $asset_img_file );
	}
}
/**
 * Function to get url of image in assets folder.
 */
if ( ! function_exists( 'wonkode_get_theme_asset_img_url' ) ) {
	/**
	 * Returns url of image in assets folder or false if passed image name
	 * does not fulfill requirements
	 * 
	 * @since 1.0
	 * @param string  		$asset_img_file Optional. Image file name in assets folder of theme.
	 * @param array  		$allowed_types Optional. Array of allowed image file types/extensions
	 * @return string/bool 	Url of image in theme folder '/assets/images/' or false 
	 * 						if none is found or empty string is passed for $asset_img_file, 
	 * 						or image extension is not in $allowed_types types
	 */
	function wonkode_get_theme_asset_img_url( $asset_img_file, $allowed_types = array() ) {
		if ( empty( $asset_img_file ) ) {
			return false;
		}
		if ( empty( $allowed_types ) ) {
			$allowed_types = array( 'png', 'jpg', 'jpeg', 'jiff' );
		}
		$image = pathinfo( $asset_img_file );
		// check if image extension
		$image_ext = $image['extension'];
		if ( ! in_array( $image_ext, $allowed_types ) ) {
			return false;
		}
	
		// get image file basename
		$image_file = $image['basename'];
	
		if ( file_exists( WK_ASSETS_PATH . '/images/' . $image_file ) ) {
			return esc_url( WK_ASSETS_URL . '/images/' . $image_file );
		} else {
			return false;
		}
	}
}

/**
 * Function to get svg resources in group of symbols.
 */
if ( ! function_exists( 'wonkode_get_svg_icon_symbols_bundle' ) ) {
	/**
	 * Returns svg resources in group of symbols that can be
	 * printed just below opening of <body> html tag for the page 
	 * where the resources are needed.
	 * 
	 * @since 1.0
	 * @param string $group 	Name of svg resource group you want 
	 * 							to retrieve
	 * @param array $names 		Array of svg resource names from group. 
	 * 							See available SVGs in 'WonKode_SVG_Resources' 
	 * 							class.
	 * @param array $args 		{
	 * 		Array of arguments you want to modify in the <symbol> tag
	 * 		while retrieving svg resources. Default is empty.
	 * 			Default values are for icon svg resources
	 * 			@type string 	'view_box'		Value for 'viewBox' attribute. Default "0 0 24 24"
	 * 			@type int 		'size'			Value for 'size' attribute. Default 24
	 * 			@type int 		'stroke_w'		Value for 'stroke-width' attribute. Default 2
	 * 			@type string 	'stroke'		Value for 'stroke' (color) attribute. Default 'currentColor'
	 * 			@type string 	'fill'			Value for 'fill' (color) attribute. Default 'none'
	 * }
	 * @return mixed Bundle of SVG symbols
	 */
	function wonkode_get_svg_icon_symbols_bundle( $group, $names = array(), $args = array() ) {
		return WonKode_SVG_Resources::get_icon_symbols_group( $group, $names, $args );
	}
}

/**
 * Function to get list of svg symbol resources 
 * for illustration images
 */
if ( ! function_exists( 'wonkode_get_illustration_svgs' ) ) {
	/**
	 * Returns list of svg symbol resources for illustration images
	 * 
	 * @since 1.0
	 * @param array $names      Array of svg icon names stored in 
	 *                          self::$illustration_imgs
	 * @param array $args 		{
	 *  		Array of arguments you want to modify in the <symbol> tag
	 *          while retrieving svg resources. Default is empty. 
	 *            @type string 'view_box'		Value for 'viewBox' attribute. Default "0 0 1000 1000"
	 *            @type string 'x'		        Value for 'x' attribute. Default '0px'
	 *            @type string 'y'		        Value for 'y' attribute. Default '0px'
	 *            @type string 'bg_shape'		Name of background shape. 
	 *                                          Default 'rectangle'. Possible values include 'circle, ellipse'
	 *            @type string 'bg_stroke'		Value for 'stroke' (color) attribute of background shape. 
	 *                                          Default 'none'
	 *            @type string 'bg_fill'		Value for 'fill' (color) attribute of background shape. 
	 *                                          Default '#EAECEF'
	 *          }
	 * @return mixed    List of svg symbols for illustration images
	 */
	function wonkode_get_illustration_svgs( $import = false, $names = array(), $args = array() ) {
		$svg_resources = new WonKode_SVG_Resources( $import );
		return $svg_resources::get_illust_symbols_group( $names, $args );
	}
}

/**
 * Template function to get svg use block 
 * for passed name of svg symbol
 */
if ( ! function_exists( 'wonkode_get_svg_use_block' ) ) {
	/**
	 * Returns svg use block for passed name of svg symbol
	 * 
	 * @since 1.0
	 * @param string $name      Name of svg to display from loaded svg symbols. 
	 *                          See the available names to use in 
	 *                          'WonKode_SVG_Reources' class.
	 * @param string $svg_type  Type of svg. Possible values: 'icon' and 'illustration'
	 *                          Default 'icon'
	 * @param array $args       {
	 *      Array of additional arguments to be used as attributes for svg use
	 *      Default: empty array
	 *          @type string    'class'    Class attribute value
	 *          @type int 		'width'    Width for svg to display
	 *          @type int 		'height'   Height for svg to display
	 * }
	 * @return mixed    SVG use block with id attribute value to display
	 */
	function wonkode_get_svg_use_block( $name, $svg_type = 'icon', $args = array() ) {
		return WonKode_SVG_Resources::get_svg_use_block( $name, $svg_type, $args );
	}
}

/**
 * Template function to get svg use block for icon SVGs.
 */
if ( ! function_exists( 'wonkode_get_svg_icon_use' ) ) {
	/**
	 * Returns svg use block for passed name of svg icon
	 * 
	 * @since 1.0
	 * @param string $name      Name of svg icon to display from loaded svg symbols. 
	 *                          See the available names to use in 
	 *                          'WonKode_SVG_Reources::$ui_icons' and 
	 * 							'WonKode_SVG_Reources::$social_icons'.
	 * 
	 * @param array $args       {
	 *      Array of additional arguments to be used as attributes for svg use
	 *      Default: empty array
	 *          @type string    'class'    Class attribute value. Default 'svg-icon'
	 *          @type int 		'width'    Width for svg to display. Default 24
	 *          @type int 		'height'   Height for svg to display. Default 24
	 * }
	 * @return mixed    SVG use block to display for icon.
	 */
	function wonkode_get_svg_icon_use( $name, $args = array() ) {
		$svg_type = 'icon';
		return WonKode_SVG_Resources::get_svg_use_block( $name, $svg_type, $args );
	}
}

/**
 * Template function to get 
 * illustration image's svg use block.
 */
if ( ! function_exists( 'wonkode_get_svg_illustration_use' ) ) {
	/**
	 * Returns illustration image's svg use block for passed name
	 * 
	 * @since 1.0
	 * @param string $name      Name of svg illustration to display from loaded svg symbols. 
	 *                          See the available names to use in 
	 *                          'WonKode_SVG_Reources::$illustration_imgs'.
	 * 
	 * @param array $args       {
	 *      Array of additional arguments to be used as attributes for svg use
	 *      Default: empty array
	 *          @type string    'class'    Class attribute value. Default 'svg-illustration'
	 *          @type int 		'width'    Width for svg to display. Default $content_width
	 *          @type int 		'height'   Height for svg to display. Default $content_width
	 * }
	 * @return mixed    SVG use block to display for illustration image.
	 */
	function wonkode_get_svg_illustration_use( $name, $args = array() ) {
		$svg_type = 'illustration';
		// modifying width and height
		$illust_args = array(
			'width'		=>	600,
			'height'	=>	600,
		);
		$args = wp_parse_args( $args, $illust_args );
		// return svg use block
		return WonKode_SVG_Resources::get_svg_use_block( $name, $svg_type, $args );
	}
}

/**
 * Template tag to display custom logo on site header
 */
if ( ! function_exists( 'wonkode_header_custom_logo' ) ) {
	/**
	 * Function that displays custom logo on site header
	 * 
	 * @since 1.0
	 */
    function wonkode_header_custom_logo() {
        $logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $logo_id, array( '200', '40' ) );   
        if ( has_custom_logo() ) {
            ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand d-flex align-items-center">
            	<img class="img-fluid" src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo get_bloginfo( 'name' ) . ' ' . __( 'logo', WK_TXTDOM ); ?>">
            </a>
            <?php
        } else {
            ?>
            <a id="site-title" class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            	<?php bloginfo( 'name' ); ?>
            </a>
            <?php
        }
    }
}

/**
 * Template tag to display custom logo on site footer
 */
if ( ! function_exists( 'wonkode_footer_custom_logo' ) ) {
	/**
	 * Function that displays custom logo on site footer
	 * 
	 * @since 1.0
	 */
    function wonkode_footer_custom_logo() {
        $logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $logo_id, array( '200', '40' ) );   
        if ( has_custom_logo() ) {
            ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            	<img class="img-fluid" src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo get_bloginfo( 'name' ) . ' ' . __( 'logo', WK_TXTDOM ); ?>">
            </a>
            <?php
        } else {
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            	<?php bloginfo( 'name' ); ?>
            </a>
            <?php
        }
    }
}

/**
 * Template function to get 
 * copyright info of site.
 */
if ( ! function_exists( 'wonkode_get_copyright_info' ) ) {
	/**
	 * Returns copyright info of site
	 * 
	 * @since 1.0
	 * @return mixed Html string with copyright info
	 */
	function wonkode_get_copyright_info() {
		return apply_filters( 
			'wonkode_copyright_info', 
			sprintf( 
				'&copy; %1$s <a href="%2$s">%3$s</a> %4$s',
				date( 'Y' ),
				esc_url( home_url( '/' ) ),
				esc_html( get_bloginfo( 'name' ) ),
				__( 'All Rights Reserved.', WK_TXTDOM )
			) 
		);
	}
}

/**
 * Template function to get 
 * info about theme to display 
 * on bottom footer of sites.
 */
if ( ! function_exists( 'wonkode_get_about_theme' ) ) {
	/**
	 * Returns information about theme, 
	 * powered by info, developers, 
	 * and related links.
	 * 
	 * @since 1.0
	 * @return mixed Information about theme.
	 */
	function wonkode_get_about_theme() {
		$wonkode_theme = wp_get_theme();
		return apply_filters( 
			'wonkode_about_theme', 
			sprintf( 
				'<span>%1$s: <a href="%2$s">%3$s</a> %4$s %5$s</span>',
				__( 'Powered By', WK_TXTDOM ),
				esc_url( $wonkode_theme->get( 'ThemeURI' ) ),
				$wonkode_theme->get( 'Name' ),
				__( 'WordPress Theme', WK_TXTDOM ),
				sprintf( 
					'Version %s', 
					$wonkode_theme->get( 'Version' ) 
				)	
			) 
		);
	}
}

/**
 * Template function to get 
 * current theme name.
 */
if ( ! function_exists( 'wonkode_get_theme_name' ) ) {
	/**
	 * Returns current theme name 
	 * regardless of the child theme
	 * 
	 * @since 1.0
	 * @return string/bool Name of theme if 
	 * it's parent theme, otherwise false
	 */
	function wonkode_get_theme_name() {
		$current_theme = wp_get_theme();

		if ( $current_theme->exists() && $current_theme->parent() ) {
			$parent_theme = $current_theme->parent();

			if ( $parent_theme->exists() ) {
				return $parent_theme->get( 'Name' );
			}
		} elseif ( $current_theme->exists() ) {
			return $current_theme->get( 'Name' );
		} else {
			return false;
		}
	}
}

/**
 * Template tag to display social media nav menu
 */
if ( ! function_exists( 'wonkode_show_social_media_links_nav' ) ) {
	/**
	 * Initialize 'WonKode_Social_Media' class and 
	 * show links nav
	 * 
	 * @since 1.0
	 * @return void
	 */
    function wonkode_show_social_media_links_nav() {
        // need to get class instance for __construct() function to execute
        $social_media_links_nav = new WonKode_Social_Media();
        $social_media_links_nav::show_social_nav();
    }
}

/**
 * Function checks if WordPress is running on localhost
 */
if ( ! function_exists( 'wonkode_is_on_localhost' ) ) {
	/**
	 * Returns true if WordPress is running on localhost
	 * 
	 * @since 1.0
	 * @return bool 
	 */
	function wonkode_is_on_localhost() {
		// get sitename
		$sitename = wp_parse_url( network_home_url(), PHP_URL_HOST );
		return in_array( strtolower( $sitename ), array( 'localhost', '127.0.0.1' ) );
	}
}

/**
 * Checks whether the given input is a well-formed telephone number.
 */
if ( ! function_exists( 'wonkode_is_tel' ) ) {
	/**
	 * Validates input value is a valid telephone number
	 * 
	 * @since 1.0
	 * 
	 * @param string $input   Value of input field
	 * @return bool
	 */
	function wonkode_is_tel( $input ) {
		$input = preg_replace( '%[()/.*#\s-]+%', '', $input );
		$result = preg_match( '/^[+]?[0-9]+$/', $input );
		return apply_filters( 'wonkode_is_tel', $result, $input );
	}
}

/**
 * Defines function to sanitize svg on 
 * frontend.
 */
if ( ! function_exists( 'wonkode_sanitize_svg' ) ) {
	/**
	 * Sanitize SVG markup for front-end display.
	 * 
	 * @see https://developer.wordpress.org/reference/functions/wp_kses/#user-contributed-notes
	 * Contributed by: Mahdi Yazdani
	 * 
	 * @param  string $svg SVG markup to sanitize.
	 * @return string 	  Sanitized markup.
	 */
	function wonkode_sanitize_svg( $svg = '' ) {
		$allowed_html = [
			'svg'  => [
				'xmlns'       => [],
				'fill'        => [],
				'viewbox'     => [],
				'role'        => [],
				'aria-hidden' => [],
				'focusable'   => [],
				'height'      => [],
				'width'       => [],
			],
			'path' => [
				'd'    => [],
				'fill' => [],
			],
		];

		return wp_kses( $svg, $allowed_html );
	}
}

/**
 * Defining function that checks contact-form-7 
 * is active
 */
if ( ! function_exists( 'wonkode_is_wpcf7_active' ) ) {
	/**
	 * Checks if contact-form-7 plugin is active.
	 * 
	 * @since 1.0
	 * @return bool true if plugin is active
	 */
	function wonkode_is_wpcf7_active() {
		// include plugin
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		return is_plugin_active( 'contact-form-7/wp-contact-form-7.php' );
	}
}

/**
 * Defining function that checks WooCommerce 
 * is active
 */
if ( ! function_exists( 'wonkode_is_woocommerce_activated' ) ) {
	/**
	 * Checks if WooCommerce plugin is active.
	 * 
	 * @since 1.0
	 * @return bool true if plugin is active
	 */
	function wonkode_is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}