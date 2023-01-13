<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WonKode
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 * 
 * @since 1.0
 */
if ( ! function_exists( 'wonkode_posted_on_by_meta' ) ) {
	function wonkode_posted_on_by_meta() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s"> (%4$s) </time>';
		}
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			sprintf(
				'<em class="small">%s</em> %s',
				esc_html__( 'Updated on', 'wonkode' ), 
				esc_html( get_the_modified_date() )
			)
		);
		$posted_on = apply_filters(
			'wonkode_posted_on',
			sprintf(
				'<li class="nav-item posted-on"><a class="nav-link" href="%1$s" rel="bookmark"><i class="fa fa-calendar me-2"></i>%2$s</a></li>',
				esc_url( get_permalink() ),
				apply_filters( 'wonkode_posted_on_time', $time_string )
			)
		);
		$byline = apply_filters(
			'wonkode_posted_by',
			sprintf(
				'<li class="nav-item byline"><a class="nav-link" href="%1$s"><i class="fa fa-user me-2"></i>%2$s</a></li>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			)
		);
		echo '<ul class="nav">' . $posted_on . $byline . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Prints background image style for page headers
 * 
 * @since 1.0
 * @param string  $asset_img_file Optional. Image file name in assets folder of theme.
 */
if ( ! function_exists( 'wonkode_page_header_bg_img_style' ) ) {
	function wonkode_page_header_bg_img_style( $asset_img_file = '' ) {
		$hdr_bg_style = wonkode_get_page_header_bg_img_style( $asset_img_file );
		echo $hdr_bg_style;
	}
}

/**
 * Returns background image style for page headers
 * 
 * @since 1.0
 * @param string  $asset_img_file	Optional. Image file name 
 * 								in assets folder of theme.
 * @return string 	A style attribute to be used inside header 
 * 					html tags to set its background image
 */
if ( ! function_exists( 'wonkode_get_page_header_bg_img_style' ) ) {
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
 * Returns post thumbnail url or asset image url, or 
 * the set header image url of the theme for background 
 * image of page header
 * 
 * @since 1.0
 * @param string  $asset_img_file Optional. Image file name in assets folder of theme.
 * @return string Url of image that can be used for background image value
 */
if ( ! function_exists( 'wonkode_get_page_header_bg_img_url' ) ) {
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
if ( ! function_exists( 'wonkode_get_theme_asset_img_url' ) ) {
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
if ( ! function_exists( 'wonkode_get_svg_icon_symbols_bundle' ) ) {
	function wonkode_get_svg_icon_symbols_bundle( $group, $names = array(), $args = array() ) {
		return WonKode_SVG_Resources::get_icon_symbols_group( $group, $names, $args );
	}
}

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
if ( ! function_exists( 'wonkode_get_illustration_svgs' ) ) {
	function wonkode_get_illustration_svgs( $import = false, $names = array(), $args = array() ) {
		$svg_resources = new WonKode_SVG_Resources( $import );
		return $svg_resources::get_illust_symbols_group( $names, $args );
	}
}

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
if ( ! function_exists( 'wonkode_get_svg_use_block' ) ) {
	function wonkode_get_svg_use_block( $name, $svg_type = 'icon', $args = array() ) {
		return WonKode_SVG_Resources::get_svg_use_block( $name, $svg_type, $args );
	}
}

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
if ( ! function_exists( 'wonkode_get_svg_icon_use' ) ) {
	function wonkode_get_svg_icon_use( $name, $args = array() ) {
		$svg_type = 'icon';
		return WonKode_SVG_Resources::get_svg_use_block( $name, $svg_type, $args );
	}
}

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
if ( ! function_exists( 'wonkode_get_svg_illustration_use' ) ) {
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
 * Returns copyright info of site
 * 
 * @since 1.0
 * @return mixed Html string with copyright info
 */
if ( ! function_exists( 'wonkode_get_copyright_info' ) ) {
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
 * Returns info about theme
 * 
 * @since 1.0
 */
if ( ! function_exists( 'wonkode_get_about_theme' ) ) {
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
 * Gets current theme name 
 * regardless of the child theme
 * 
 * @return string/bool Name of theme if 
 * it's parent theme, otherwise false
 */
if ( ! function_exists( 'wonkode_get_theme_name' ) ) {
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