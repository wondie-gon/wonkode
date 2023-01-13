<?php
/**
 * Class for theme setup
 *
 * Allows different theme features to be included 
 * that run initially when this theme is activated.
 * 
 *
 * @package WonKode
 * @since 1.0
 *
 */
// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WonKode_Setup' ) ) {
	/**
	 * Class for theme setup
	 */
	class WonKode_Setup {
		/**
		* Object instance of the class
		* 
		* @access private
		*/
		private static $instance;

		/**
		* Instantiate class
		*/
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WonKode_Setup ) ) {
				self::$instance = new WonKode_Setup;

				add_action( 'after_setup_theme', array( self::$instance, 'setup_theme' ) );
			}
			return self::$instance;
		}

		public function setup_theme() {
			self::$instance->load_textdomain();
			self::$instance->automatic_feed_links();
			self::$instance->title_tag();
			self::$instance->register_nav_menus();
			self::$instance->add_theme_supports();
		}

		public function add_theme_supports() {
			self::$instance->post_thumbnails();
			self::$instance->post_formats();
			self::$instance->support_html5();
			self::$instance->add_custom_logo();
			self::$instance->custom_header_setup();
			self::$instance->widgets_selective_refresh();
			self::$instance->support_block_styles();
			self::$instance->support_align_wide();
			self::$instance->support_editor_styles();
			self::$instance->support_custom_background();
		}

		/**
		* Loads theme textdomain
		*/
		public function load_textdomain() {
			/**
			 * Make theme available for translation.
			 * Translations can be placed in the /languages/ directory.
			 */
			load_theme_textdomain( WK_TXTDOM, get_template_directory() . '/languages' );
		}

		/**
		* Theme support for automatic feed links
		*/
		public function automatic_feed_links() {
			/**
			 * Add default posts and comments RSS feed links to <head>.
			 */
			add_theme_support( 'automatic-feed-links' );
		}

		/**
		* Allows WordPress manage the document title 
		* instead of hard-coded <title> tag for each 
		* document head
		*/
		public function title_tag() {
			/*
			 * Let WordPress manage the document title.
			 */
			add_theme_support( 'title-tag' );
		}

		/**
		* Theme support for post thumbnails and 
		* featured images
		*/
		public function post_thumbnails() {
			/**
			 * Enable support for post thumbnails and featured images.
			 */
			add_theme_support( 'post-thumbnails' );
		}

		/**
		* Theme support for aside, gallery, quote, image, 
		* and video post formats
		*/
		public function post_formats() {
			/**
			 * Enable support for the following post formats:
			 * link, aside, gallery, quote, image, status, 
			 * audio, chat and video
			 */
			add_theme_support(
				'post-formats',
				array(
					'link',
					'aside',
					'gallery',
					'image',
					'quote',
					'status',
					'video',
					'audio',
					'chat',
				)
			);
		}

		/**
		* Switches default markup to HTML5 
		* for listed blocks
		*/
		public function support_html5() {
			/*
			 * Use HTML5 markup for search form, 
			 * comment form, comments, gallery, 
			 * caption, style, script, and 
			 * navigation-widgets
			 */
			add_theme_support(
				'html5',
				array(
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'style',
					'script',
					'navigation-widgets',
				)
			);
		}

		/**
		* Allows theme to support custom logo
		*/
		public function add_custom_logo() {
			/**
			 * Add support for core custom logo.
			 *
			 * @link https://codex.wordpress.org/Theme_Logo
			 */
			$logo_width  = 200;
			$logo_height = 40;

			add_theme_support(
				'custom-logo',
				array(
					'height'               	=>	$logo_height,
					'width'                	=>	$logo_width,
					'flex-width'           	=>	true,
					'flex-height'          	=>	true,
					'unlink-homepage-logo' 	=>	true,
					'header-text'			=>	array( 'site-title', 'site-description' )
				)
			);
		}

		/**
		* Theme support for selective refresh for widgets.
		*/
		public function widgets_selective_refresh() {
			// selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
		}

		/**
		* Theme support for wp block styles
		*/
		public function support_block_styles() {
			// Add support for Block Styles.
			add_theme_support( 'wp-block-styles' );
		}

		/**
		* Theme support for full and wide align images.
		*/
		public function support_align_wide() {
			// Add support for full and wide align images.
			add_theme_support( 'align-wide' );
		}

		/**
		* Theme support for editor styles
		*/
		public function support_editor_styles() {
			// Add support for editor styles.
			add_theme_support( 'editor-styles' );

			// Enqueue editor styles.
			add_editor_style( WK_ASSETS_PATH . '/css/style-editor.css' );
		}

		/**
		 * Theme support for custom background
		 * 
		 * @link https://codex.wordpress.org/Custom_Backgrounds
		 */
		public function support_custom_background() {
			$bg_defaults = array(
				'default-color' 			=> 'e8eaed',
				'default-image'          	=> '%1$s/assets/images/wonkode-bg-img-light.jpg',
				'default-repeat'         	=> 'repeat',
				'default-position-x'     	=> 'left',
				'default-position-y'     	=> 'top',
				'default-size'           	=> 'auto',
				'default-attachment'     	=> 'scroll',
				'wp-head-callback'       	=> '_custom_background_cb',
				'admin-head-callback'    	=> '',
				'admin-preview-callback' 	=> ''
			);

			/**
			 * Filters custom background feature defaul arguments
			 * 
			 * @since 1.0
			 * 
			 * @param array $bg_defaults Default array of custom-background 
			 * arguments
			 */
			$bg_defaults = apply_filters( 'wonkode_custom_bg_args', $bg_defaults );
			
			add_theme_support( 'custom-background', $bg_defaults );
		}

		/**
		* Registers custom nav menus of theme
		*/
		public function register_nav_menus() {
			/**
			 * Add support for navigation menus.
			 */
			register_nav_menus( array(
				'primary'   	=> __( 'Primary Menu', WK_TXTDOM ),
				'secondary' 	=> __( 'Secondary Menu', WK_TXTDOM ),
				'footer' 		=> __( 'Footer Menu', WK_TXTDOM ),
			) );
		}

		/**
		 * Sets up custom header to add to theme 
		 * support
		 *
		 * @since 1.0
		 */
		public function custom_header_setup() {
			$wonkode_custom_hdr_args = array(
				'width'         		=>	980,
				'flex-width'			=>	true,
				'height'        		=>	200,
				'flex-height'   		=>	true,
				'default-text-color'	=>	'46728a',
				'header-text'			=> 	true,
				'uploads'               => 	true,
				'default-image' 		=>	get_template_directory_uri() . '/assets/images/wonkode_hdr_img_one.jpg',
			);
	
			/**
			 * Filter wonkode custom-header support arguments.
			 *
			 * @since 1.0
			 *
			 * @param array $wonkode_custom_hdr_args {
			 *     An array of custom-header support arguments.
			 * 
			 *     	@type int		'width'					Width in pixels of the custom 
			 * 												header image. Default 980.
			 * 		@type string	'flex-width'            Flex support for width of header.
			 *     	@type int		'height'				Height in pixels of the custom 
			 * 												header image. Default 200.
			 * 		@type string	'flex-height'			Flex support for height of header.
			 * 		@type string	'default-text-color'	Default color of the header text.
			 * 		@type bool		'header-text'			Display the header text along 
			 * 												with the image.
			 * 		@type bool		'uploads'				Enable upload of image file 
			 * 												in admin.
			 * 		@type string	'default-image'     	Default image of the header. 	
			 * }
			 */
			$wonkode_custom_hdr_args = apply_filters( 'wonkode_custom_header_args', $wonkode_custom_hdr_args );
	
			// add to theme support
			add_theme_support( 'custom-header', $wonkode_custom_hdr_args );

			/**
			 * Registering defualt images for custom header
			 */
			$wonkode_default_header_imgs = array(
				'wonkode_hdr_img_one'	=>	array(
					'url'			=>	'%s/assets/images/wonkode_hdr_img_one.jpg',
					'thumbnail_url'	=>	'%s/assets/images/wonkode_hdr_img_one-thumbnail.jpg',
					'description'	=>	__( 'Header image one light', 'wonkode' ),
				),
				'wonkode_hdr_img_two'	=>	array(
					'url'			=>	'%s/assets/images/wonkode_hdr_img_two.jpg',
					'thumbnail_url'	=>	'%s/assets/images/wonkode_hdr_img_two-thumbnail.jpg',
					'description'	=>	__( 'Header image two light', 'wonkode' ),
				),
				'wonkode_hdr_img_three'	=>	array(
					'url'			=>	'%s/assets/images/wonkode_hdr_img_three.jpg',
					'thumbnail_url'	=>	'%s/assets/images/wonkode_hdr_img_three-thumbnail.jpg',
					'description'	=>	__( 'Header image three dark', 'wonkode' ),
				),
			);
	
			// register default header images
			register_default_headers( $wonkode_default_header_imgs );
		}
		
	} // END --class
}