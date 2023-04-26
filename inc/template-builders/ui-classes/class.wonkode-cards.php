<?php
/**
 * Class for templating cards UI component. Since card 
 * is a flexible and extensible content container, that 
 * includes options for headers and footers, a wide variety 
 * of content, contextual background colors, and powerful 
 * display options, it deserves its own class.
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Cards' ) ) {
    class WonKode_Cards extends WonKode_UI_Components {
        /**
         * Configuration arguments of a post 
         * card.
         * 
         * @access private
         * 
         * @since 1.0
         * @var array
         */
        private static $card_config = array(
            'card_class'    =>	'',
            'inline_styles' =>	array(),
            'header_class'	=>	'',
            'has_image'	    =>	true,
            'img_size'      =>  '',
            'img_attrs'	    =>	array(
                'class'	=>	'card-img-top',
                'src'	=>	'',
                'alt'	=>	'',
            ),
            'body_class'	=>	'',
            'title_tag'	    =>	'',
            'title_class'	=>	'',
            'text_class'	=>	'',
            'link_class'	=>	'',
            'link_text'	    =>	'Read More',
            'footer_class'	=>	'',
        );
        /**
         * Class constructor.
         * Sets text domain and unique prefix 
         * properties via parent constructor.
         * 
         * @since 1.0
         */
        public function __construct() {
            parent::__construct();
        }
        /**
         * Returns card block with post data filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @return mixed Card filled with post content.
         */
        public static function get_card_post( $args = array() ) {
            // post retrieve object
            $post_fetch = new WonKode_Retrieve_Post_Content();

            // get parsed $args
            $args = self::parse_card_config( $args );
            // start card html
            $card_html = '';
            // get card opening
            $card_html .= self::get_inline_styled_card_open( $args['card_class'], $args['inline_styles'] );
            // Card post image
            $card_html .= self::get_card_post_image( $args );
            // card body opening
            $card_html .= self::get_card_body_open( $args['body_class'] );
            // title
            $card_html .= self::get_card_post_title( $post_fetch->get_title_anchor(), $args );
            // post excerpt
            $card_html .= self::get_card_post_excerpt( $post_fetch->get_excerpt(), $args );
            // post link
            $card_html .= self::get_card_post_link( $args );        
            
            // card body closing
            $card_html .= self::get_card_body_close();
            
            // get card closing
            $card_html .= self::get_card_div_close();
            // return card post
            return $card_html;
        }
        /**
         * Returns card post thumbnail.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @return mixed card post image
         */
        public static function get_card_post_image( $args = array() ) {
            // start html
            $img_html = '';
            $args['img_size'] = ! empty( $args['img_size'] ) ? $args['img_size'] : 'medium';
            $args['img_attrs']['class'] = ! empty( $args['img_attrs']['class'] ) ? $args['img_attrs']['class'] : 'card-img-top';
            if ( empty( $args['img_attrs']['src'] ) ) {
                if ( ! has_post_thumbnail() ) {
                    $img_html .= '';
                } else {
                    // set image alt
                    $args['img_attrs']['alt'] = the_title_attribute( array( 'echo'  =>  false ) );
                    // get post thumbnail
                    $img_html .= get_the_post_thumbnail( get_the_ID(), $args['img_size'], $args['img_attrs'] );
                }
            } else {
                $img_html .= self::get_card_image( $args['img_attrs'] );
            }
            // return image block
            return $img_html;
        }
        /**
         * Returns card post title block.
         * 
         * @since 1.0
         * @param string $title     Post title.
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @return mixed Post title block.
         */
        public static function get_card_post_title( $title, $args = array() ) {
            // start html
            $html_out = '';
            // title tag
            $args['title_tag'] = ! empty( $args['title_tag'] ) ? $args['title_tag'] : 'h4';
            // title class
            $args['title_class'] = ! empty( $args['title_class'] ) ? $args['title_class'] : 'entry-title';
            $html_out .= self::get_card_title_open( $args['title_tag'], $args['title_class'] );
            $html_out .= $title;
            $html_out .= self::get_card_title_close( $args['title_tag'] );
            // return post title block
            return $html_out;
        }
        /**
         * Returns card post excerpt block.
         * 
         * @since 1.0
         * @param string $excerpt Post excerpt.
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @return mixed Post excerpt block.
         */
        public static function get_card_post_excerpt( $excerpt, $args = array() ) {
            // start html
            $html = '';
            $html .= self::get_div_open( 'entry-content' );
            // open card text p
            $args['text_class'] = ! empty( $args['text_class'] ) ? $args['text_class'] : '';
            $html .= self::get_card_text_open( $args['text_class'] );
            // post excerpt
            $html .= $excerpt;
            // close card text p
            $html .= self::get_card_text_close();
            // close entry content
            $html .= self::get_html_tag_close();
            // return excerpt block
            return $html;
        }
        /**
         * Returns card post link
         * 
         * @since 1.0
         * 
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @param int|WP_Post $post Optional. Post ID or WP_Post object. 
         *                          Default is global `$post`.
         * @return mixed post link
         */
        public static function get_card_post_link( $args = array(), $post = null ) {
            $link_args = array(
                'class'     =>  ! empty( $args['link_class'] ) ? $args['link_class'] : 'btn btn-primary',
                'href'      =>  get_permalink( $post ),
                'link_text' => ! empty( $args['link_text'] ) ? $args['link_text'] : 'Read More',
            );
            // return link
            return self::get_card_link( $link_args );
        }
        /**
         * Returns card block with header, footer 
         * and post content filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @param bool $has_header  Whether card header is needed.
         *                          Defaults: false.
         * @param bool $has_footer  Whether card footer is needed.
         *                          Defaults: false.
         * @return mixed Card filled with post content.
         */
        public static function get_header_footer_card_post( $args = array(), $has_header = false, $has_footer = false ) {
            // get parsed $args
            $args = self::parse_card_config( $args );
            // start card html
            $card_html = '';
            // get card opening
            $card_html .= self::get_inline_styled_card_open( $args['card_class'], $args['inline_styles'] );
            // header
            if ( $has_header ) {
                // open header
                $card_html .= self::get_div_open( $args['header_class'], array( 'card-header' ) );
                // -----Header content here
                // close header
                $card_html .= self::get_html_tag_close();
            }
            // card body opening
            $card_html .= self::get_card_body_open( $args['body_class'] );

            /**
             * Title
             */
            // title tag
            $args['title_tag'] = ! empty( $args['title_tag'] ) ? $args['title_tag'] : 'h4';
            // title class
            $args['title_class'] = ! empty( $args['title_class'] ) ? $args['title_class'] : 'entry-title';
            $card_html .= self::get_card_title_open( $args['title_tag'], $args['title_class'] );
            $card_html .= 'Card Title One';
            $card_html .= self::get_card_title_close( $args['title_tag'] );

            /**
             * Card text content
             */
            // open entry content
            $card_html .= self::get_div_open( 'entry-content' );
            // open card text p
            $card_html .= self::get_card_text_open( $args['text_class'] );
            $card_html .= 'Post excerpt content here without paragraph tag';
            // close card text p
            $card_html .= self::get_card_text_close();
            // close entry content
            $card_html .= self::get_html_tag_close();

            /**
             * Link
             */
            $link_args = array(
                'class'     =>  'btn btn-primary',
                'href'      =>  '',
                'link_text' => ! empty( $args['link_text'] ) ? $args['link_text'] : 'Read More',
            );
            $card_html .= self::get_card_link( $link_args );           
            
            // card body closing
            $card_html .= self::get_card_body_close();
            // footer
            if ( $has_footer ) {
                // open footer
                $card_html .= self::get_div_open( $args['footer_class'], array( 'card-footer' ) );
                
                // -----footer content here

                // close footer
                $card_html .= self::get_html_tag_close();
            }
            // get card closing
            $card_html .= self::get_card_div_close();
            // return card post
            return $card_html;
        }
        /**
         * Returns configuration arguments 
         * parsed with defaults, ready for 
         * use to render post in card block.
         * 
         * @since 1.0
         * @param array $args   Array of card's configuration 
         *                      arguments. Defaults: []
         * @return array Parsed configuration arguments.
         */
        public static function parse_card_config( $args = array() ) {
            $args = wp_parse_args( $args, self::$card_config );
            return $args;
        }
        /**
         * Returns opening tag for default card element.
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @param string $id                    Value for id attribute for card.
         *                                      Defaults: ''
         * @return mixed Opening tag for default card.
         */
        public static function get_default_card_open( $new_classes = '', $id = '' ) {
            // card default class
            $card_classes = array( 'card' );
            // get card html
            $card_html = self::get_div_open( $new_classes, $card_classes, $id );
            /**
             * Filters default card opening tag
             * 
             * @since 1.0
             * @param mixed $card_html          Card html tag output
             * @param string|array $new_classes List of class to add.
             * @param array $card_classes       Default card classes array.
             *                                  Used to append additional 
             *                                  classes (passed by reference).
             * @param string $id                Value for id attribute for card.
             */
            $card_html = apply_filters( self::$unique_prefix . '_default_card', $card_html, $new_classes, $card_classes, $id );
            return $card_html;
        }
        /**
         * Renders opening tag for default card element.
         * 
         * @since 1.0
         * @param string|array $new_classes List of class to add.
         * @param string $id                Value for id attribute for card.
         * @return void
         */
        public static function open_default_card( $new_classes = '', $id = '' ) {
            echo self::get_default_card_open( $new_classes, $id );
        }
        /**
         * Returns opening tag for card element with 
         * class and inline style.
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @param array $styles             Array of css properties.
         *                                  CSS properties with '-', such as 
         *                                  'background-color', their key 
         *                                  should be given with '_' like 
         *                                  'background_color' => '#fcfcfc'
         * @return mixed Card opening tag with class and inline style.
         */
        public static function get_inline_styled_card_open( $new_classes = '', $styles = array() ) {
            // card default class
            $card_classes = array( 'card' );
            // get div tag including inline style
            $card_div = self::get_inline_styled_div_open( $new_classes, $card_classes, $styles );
            // return card div open
            return $card_div;
        }
        /**
         * Renders opening tag for card with class and 
         * inline style. 
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @param array $styles             Array of css properties.
         *                                  CSS properties with '-', such as 
         *                                  'background-color', their key 
         *                                  should be given with '_' like 
         *                                  'background_color' => '#fcfcfc'
         * @return void
         */
        public static function open_inline_styled_card( $new_classes = '', $styles = array() ) {
            echo self::get_inline_styled_card_open( $new_classes, $styles );
        }
        /**
         * Returns card body tag opening
         * 
         * @since 1.0
         * @param string|array $new_classes     List of class to add. 
         *                                      Defaults: ''
         * @return mixed HTML opening tag for card body.
         */
        public static function get_card_body_open( $new_classes = '' ) {
            // default card body classes
            $card_body_classes = array( 'card-body' );
            // get card body classes
            $card_body_html = self::get_div_open( $new_classes, $card_body_classes );
            // return html
            return $card_body_html;
        }
        /**
         * Renders opening tag for card body.
         * 
         * @since 1.0
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return void
         */
        public static function open_card_body( $new_classes = '' ) {
            echo self::get_card_body_open( $new_classes );
        }
        /**
         * Returns closing div of card body.
         * 
         * @since 1.0
         * @return mixed Closing div of card body
         */
        public static function get_card_body_close() {
            return self::get_html_tag_close();
        }
        /**
         * Renders closing div of card body.
         * 
         * @since 1.0
         * @return void
         */
        public static function close_card_body() {
            echo self::get_card_body_close();
        }
        /**
         * Returns card title element opening. 
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return mixed Card title element opening tag.
         */
        public static function get_card_title_open( $h_tag = 'h4', $new_classes = '' ) {
            // default card title classes
            $card_title_classes = array( 'card-title' );
            // get element tag
            $card_title_elem = self::get_html_tag_open( $new_classes, $card_title_classes, '', $h_tag );
            // return opening tag
            return $card_title_elem;
        }
        /**
         * Renders card title element opening. 
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return void
         */
        public static function open_card_title( $h_tag = 'h4', $new_classes = '' ) {
            echo self::get_card_title_open( $h_tag, $new_classes );
        }
        /**
         * Returns closing of card title element.
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @return mixed Closing h tag
         */
        public static function get_card_title_close( $h_tag = 'h4' ) {
            return self::get_html_tag_close( $h_tag );
        }
        /**
         * Renders closing of card title element.
         * 
         * @since 1.0
         * @param string $h_tag     h tag. Defaults: 'h4'
         * @return void
         */
        public static function close_card_title( $h_tag = 'h4' ) {
            echo self::get_card_title_close( $h_tag );
        }
        /**
         * Returns card text element opening. 
         * 
         * @since 1.0
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return mixed Card text element opening tag.
         */
        public static function get_card_text_open( $new_classes = '' ) {
            // default card text classes
            $card_text_classes = array( 'card-text' );
            // get element tag
            $card_text_elem = self::get_html_tag_open( $new_classes, $card_text_classes, '', 'p' );
            // return opening tag
            return $card_text_elem;
        }
        /**
         * Renders card text element opening. 
         * 
         * @since 1.0
         * @param string|array $new_classes List of new classes to add.
         *                                  Defaults: ''
         * @return void
         */
        public static function open_card_text( $new_classes = '' ) {
            echo self::get_card_text_open( $new_classes );
        }
        /**
         * Returns card link anchor element <a></a> with 
         * all passed arguments.
         * 
         * @since 1.0
         * @param array $args = [
         *  Arguments for link anchor element. Defaults: []
         *      @type string 'id'	        Element id attribute. Defaults: '',
         *      @type string 'class'        Element class attribute. Defaults: '',
         *      @type string 'href'	        Element href attribute. Defaults: '',
         *      @type string 'target'	    Element target attribute. Defaults: '',
         *      @type string 'hreflang'	    Element hreflang attribute. Defaults: '',
         *      @type string 'title'	    Element title attribute. Defaults: '',
         *      @type string 'role'	        Element role attribute. Defaults: '',
         *      @type array  'data_attrs'	Array of data set attribute names 
         *                                  with value. Defaults:	[],
         *      @type array  'aria_attrs'	Array of aria attribute names with value. 
         *                                  Defaults:	[],
         *      @type bool   'downloadable'	Whether link is downloadable. 
         *                                  Defaults: false,
         *      @type string 'link_fa_icon'	Fontawesome icon class. Defaults: '',
         *      @type string 'link_text'    Link text. Defaults: '',
         * ]
         * @return html|string  Link with attributes, fontawesome icon, and text
         */
        public static function get_card_link( $args = array() ) {
            // setting card link if not passed
            $args['class'] = ! empty( $args['class'] ) ? $args['class'] : 'card-link';
            return self::get_link_element( $args );
        }
        /**
         * Renders card link anchor element <a></a> with 
         * all passed arguments.
         * 
         * @since 1.0
         * @param array $args   Arguments for link anchor element. 
         *                      Defaults: [].
         *                      See details about arguments in 
         *                      WonKode_Cards::get_card_link( $args )
         * @return void
         */
        public static function card_link( $args = array() ) {
            echo self::get_card_link( $args );
        }
        /**
         * Returns card img element. 
         * Nothing if src not passed.
         * 
         * @since 1.0
         * @param array $args [
         *      Arguments array. Defaults: []
         *          @type string        'src'      Image src. Defaults: ''
         *          @type string|array  'class'    Class for img. Defaults: ''
         *          @type string        'alt'      Image alt. Defaults: ''
         * ]
         * @return mixed Card image.
         */
        public static function get_card_image( $args = array() ) {
            // set card image
            $args['class'] = ! empty( $args['class'] ) ? $args['class'] : 'card-img-top';
            // return img
            return self::get_img_element( $args );
        }
        /**
         * Renders card img element. 
         * Nothing displays if src not passed.
         * 
         * @since 1.0
         * @param array $args [
         *      Arguments array. Defaults: []
         *          @type string        'src'      Image src. Defaults: ''
         *          @type string|array  'class'    Class for img. Defaults: ''
         *          @type string        'alt'      Image alt. Defaults: ''
         * ]
         * @return void
         */
        public static function card_image( $args = array() ) {
            echo self::get_card_image( $args );
        }
        /**
         * Returns closing of card text element.
         * 
         * @since 1.0
         * @return mixed Closing html tag for card text
         */
        public static function get_card_text_close() {
            return self::get_html_tag_close( 'p' );
        }
        /**
         * Renders closing of card text element.
         * 
         * @since 1.0
         * @return void
         */
        public static function close_card_text() {
            echo self::get_card_text_close();
        }
        /**
         * Returns closing div of card element
         * 
         * @since 1.0
         * @return mixed Closing div of html element
         */
        public static function get_card_div_close() {
            return self::get_html_tag_close();
        }
        /**
         * Renders closing div of card element
         * 
         * @since 1.0
         * @return void
         */
        public static function close_card_div() {
            echo self::get_card_div_close();
        }
    } // ENDS -- class
}