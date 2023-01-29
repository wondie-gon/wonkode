<?php
/**
 * Class for different content template parts
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Content_Template_Parts' ) ) {
    class WonKode_Content_Template_Parts {
        /**
         * Theme identifier, text domain
         * 
         * @since 1.0
         * @var string 
         */
        public static $txt_dom;
        /**
         * Class instantiator object.
         * 
         * @access private
         * @since 1.0
         * @var object
         */
        private static $instance;
        /**
         * Unique prefix for naming 
         * filter and action hooks etc
         * 
         * @since 1.0
         * @var string
         */
        public static $unique_prefix;
        /**
         * A nested array of block classes 
         * associations.
         * 
         * Default classes for various blocks 
         * of content template parts before 
         * addiional classes are added. 
         * These are essential for styling 
         * the different blocks of content templates.
         * 
         * @since 1.0
         * @var array
         */
        public static $block_classes_assoc = array(
            'tax_links'             =>  array( 'tax-links-block' ),
            'post_meta'             =>  array( 'post-meta-block' ),
            'single_main'           =>  array( 'content-block' ),
            'excerpt_main'          =>  array( 'excerpt-block' ),
            'img_wrapper'           =>  array( 'image-entry' ),
            'edit_screen_reader'    =>  array( 'screen-reader-block' ),
            'social_media'          =>  array( 'social-block' ),
            'comments_wrapper'      =>  array( 'comments-wrapper' ),
        );

        /**
         * Instantiates class. 
         * 
         * @since 1.0
         * @return object New instance of class.
         */
        public static function init() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WonKode_Content_Template_Parts ) ) {
                self::$instance = new WonKode_Content_Template_Parts;
                // set text domain
                self::$txt_dom = WonKode_Helper::get_texdomain();
                // set unique prefix
                self::$unique_prefix = WonKode_Helper::get_unique_prefix();
            }
            return self::$instance;
        }
        /**
         * Renders card block with post data filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. You can 
         *                          refer arguments in WonKode_Cards::$card_config. 
         *                          Defaults: []
         * 
         * @return void
         */
        public static function image_on_top_post_card( $args = array() ) {
            echo self::get_image_on_top_post_card( $args );
        }
        /**
         * Returns card block with post data filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. You can 
         *                          refer arguments in WonKode_Cards::$card_config. 
         *                          Defaults: []
         * 
         * @return mixed Card filled with post content.
         */
        public static function get_image_on_top_post_card( $args = array() ) {
            $defaults = array(
                'card_class'    =>	'',
                'inline_styles' =>	array(),
                'img_size'      =>  '',
                'img_attrs'	    =>	array(
                    'class'	=>	'',
                    'src'	=>	'',
                    'alt'	=>	'',
                ),
                'body_class'	=>	'',
                'title_tag'	    =>	'',
                'title_class'	=>	'',
                'text_class'	=>	'',
                'link_class'	=>	'',
                'link_text'	    =>	'Read More',
            );
            // get parsed $args
            $args = wp_parse_args( $args, $defaults );

            // post retrieve object
            $post_fetch = new WonKode_Retrieve_Post_Content();

            // card component object
            $card = new WonKode_Cards;
            // start card html
            $card_html = '';
            // get card opening
            $card_html .= $card::get_inline_styled_card_open( $args['card_class'], $args['inline_styles'] );
            // Card post image
            $card_html .= $card::get_card_post_image( $args );
            // card body opening
            $card_html .= $card::get_card_body_open( $args['body_class'] );
            // title
            $card_html .= $card::get_card_post_title( $post_fetch->get_title_anchor(), $args );
            // post excerpt
            $card_html .= $card::get_card_post_excerpt( $post_fetch->get_excerpt(), $args );
            // post link
            $card_html .= $card::get_card_post_link( $args );      
            
            // card body closing
            $card_html .= $card::get_card_body_close();
            
            // get card closing
            $card_html .= $card::get_card_div_close();
            // return card post
            return $card_html;
        }
        /**
         * Renders card block with header, footer 
         * and post content filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @param bool $has_header  Whether card header is needed.
         *                          Defaults: true.
         * @param bool $has_footer  Whether card footer is needed.
         *                          Defaults: true.
         * @return void
         */
        public static function header_footer_post_card( $args = array(), $has_header = true, $has_footer = true ) {
            echo self::get_header_footer_post_card( $args, $has_header, $has_footer );
        }
        /**
         * Returns card block with header, footer 
         * and post content filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. Defaults: []
         * @param bool $has_header  Whether card header is needed.
         *                          Defaults: true.
         * @param bool $has_footer  Whether card footer is needed.
         *                          Defaults: true.
         * @return mixed Card filled with post content.
         */
        public static function get_header_footer_post_card( $args = array(), $has_header = true, $has_footer = true ) {

            // card component object
            $card = new WonKode_Cards;

            // get parsed $args
            $args = $card::parse_card_config( $args );
            
            // start card html
            $card_html = '';
            // get card opening
            $card_html .= $card::get_inline_styled_card_open( $args['card_class'], $args['inline_styles'] );
            // header
            if ( $has_header ) {
                // open header
                $card_html .= $card::get_div_open( $args['header_class'], array( 'card-header' ) );

                // ---------------------Header content here --- post meta

                // close header
                $card_html .= $card::get_html_tag_close();
            }
            // card body opening
            $card_html .= $card::get_card_body_open( $args['body_class'] );

            /**
             * Title
             */
            // title tag
            $args['title_tag'] = ! empty( $args['title_tag'] ) ? $args['title_tag'] : 'h4';
            // title class
            $args['title_class'] = ! empty( $args['title_class'] ) ? $args['title_class'] : 'entry-title';
            $card_html .= $card::get_card_title_open( $args['title_tag'], $args['title_class'] );
            $card_html .= get_the_title();
            $card_html .= $card::get_card_title_close( $args['title_tag'] );

            /**
             * Card text content
             */
            // open entry content
            $card_html .= $card::get_div_open( 'entry-content' );
            // open card text p
            $card_html .= $card::get_card_text_open( $args['text_class'] );
            $card_html .= get_the_excerpt();
            // close card text p
            $card_html .= $card::get_card_text_close();
            // close entry content
            $card_html .= $card::get_html_tag_close();

            /**
             * Link
             */
            $link_args = array(
                'class'     =>  'btn btn-primary',
                'href'      =>  get_the_permalink(),
                'link_text' => ! empty( $args['link_text'] ) ? $args['link_text'] : 'Read More',
            );
            $card_html .= $card::get_card_link( $link_args );           
            
            // card body closing
            $card_html .= $card::get_card_body_close();
            // footer
            if ( $has_footer ) {
                // open footer
                $card_html .= $card::get_div_open( $args['footer_class'], array( 'card-footer' ) );
                
                // --------------------------------footer content here

                // close footer
                $card_html .= $card::get_html_tag_close();
            }
            // get card closing
            $card_html .= $card::get_card_div_close();
            // return card post
            return $card_html;
        }
        /**
         * Renders post excerpt with image on left side.
         * 
         * @param string/array $wrapper_classes List of classes 
         *                                      for post excerpt wrapper.
         *                                      Defaults: ''
         * @return void
         */
        public static function image_on_left_post_excerpt( $wrapper_classes = '' ) {
            // get wrapper class list
            $wrapper_cls_list = WonKode_Helper::list_classes( $wrapper_classes );
            // excerpt block class additions
            $excerpt_cls_additions = 'col-md-7 col-lg-8 py-4';
            // image wrapper column class additions
            $img_col_classes = 'col-md-5 col-lg-4 pt-4';
            // args for image block
            $img_block_args = array();
            ?>
            <article id="<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ) ?>>
                <div class="row">
                <?php 
                    if ( ! has_post_thumbnail() ) {
                        // classes for fullwidth block
                        $excerpt_cls_additions = 'col-12 p-4';
                        self::post_excerpt_block( $excerpt_cls_additions );
                    } else {
                        // post thumbnail block
                        $img_block_args['block_classes'] = $img_col_classes;
                        self::post_thumnail_block( $img_block_args );
                        // post excerpt block
                        self::post_excerpt_block( $excerpt_cls_additions );
                    } 
                ?>
                </div>
            </article>
            <?php
        }
        /**
         * Renders post excerpt with image on right side.
         * 
         * @param string/array $wrapper_classes List of classes 
         *                                      for post excerpt wrapper.
         *                                      Defaults: ''
         * @return void
         */
        public static function image_on_right_post_excerpt( $wrapper_classes = '' ) {
            // get wrapper class list
            $wrapper_cls_list = WonKode_Helper::list_classes( $wrapper_classes );
            // excerpt block class additions
            $excerpt_cls_additions = 'col-md-7 col-lg-8 p-4';
            // image wrapper column class additions
            $img_col_classes = 'col-md-5 col-lg-4 pt-4';
            // args for image block
            $img_block_args = array();
            ?>
            <article id="<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ) ?>>
                <div class="row">
                <?php 
                    if ( ! has_post_thumbnail() ) {
                        // classes for fullwidth block
                        $excerpt_cls_additions = 'col-12 p-4';
                        self::post_excerpt_block( $excerpt_cls_additions );
                    } else {
                        // post excerpt block
                        self::post_excerpt_block( $excerpt_cls_additions );
                        // post thumbnail block
                        $img_block_args['block_classes'] = $img_col_classes;
                        self::post_thumnail_block( $img_block_args );
                    } 
                ?>
                </div>
            </article>
            <?php
        }
        /**
         * Template renders single post content.
         * 
         * @since 1.0
         * @param string/array $wrapper_classes List of classes 
         *                                      for single post 
         *                                      content wrapper. 
         *                                      Defaults: ''
         * @return void
         */
        public static function single_post_content( $wrapper_classes = '' ) {
            // get wrapper class list
            $wrapper_cls_list = WonKode_Helper::list_classes( $wrapper_classes );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ) ?>>
                <div class="row">       
                    <?php
                        // post meta block
                        self::post_meta_block( 'col-12' );
                        ?>
                        <div class="col-12">
                            <?php 
                                // image block
                                if ( has_post_thumbnail() ) {
                                    self::post_thumnail_block( 
                                        array(
                                            'block_classes' =>  '',
                                            'img_size'      =>  'full',
                                            'img_class'     =>  'img-flid',
                                            'img_as_link'   =>  false
                                        ) 
                                    );
                                }
                                // single post content block
                                self::post_content_block( 'entry-content p-3' );
                            ?>
                        </div>
                        <?php
                        // display taxonomy links block
                        self::taxonomy_links_block( 'col-12 p-3' );
                        // visible only in admin mode 
                        if ( get_edit_post_link() ) {
                            self::edit_post_screen_reader_block( 'col-12 p-3' );
                        }
                        // social media sharing block
                        if ( get_theme_mod( 'enable_wonkode_social_media_sharing' ) ) {
                            self::social_media_shares_block( 'co-12 p-3' );
                        }
                        /**
                        * Displays comments area with comment form if comments are open, 
                        * or there is some number of comments, and password is not required
                        */
                        if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
                            self::comments_block( 'col-12 p-4' );
                        }
                    ?>
                </div>
            </article><!-- #post-<?php the_ID(); ?>.card -->
            <?php
        }
        /**
         * Template renders page content.
         * 
         * @since 1.0
         * @param string/array $wrapper_classes List of classes 
         *                                      for page content wrapper. 
         *                                      Defaults: ''
         * @return void
         */
        public static function page_content( $wrapper_classes = '' ) {
            // get wrapper class list
            $wrapper_cls_list = WonKode_Helper::list_classes( $wrapper_classes );
            ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ) ?>>
                <div class="row">
                    <div class="col-12">
                        <?php 
                            // image block
                            if ( has_post_thumbnail() ) {
                                self::post_thumnail_block( 
                                    array(
                                        'block_classes' =>  '',
                                        'img_size'      =>  'full',
                                        'img_class'     =>  'img-flid',
                                        'img_as_link'   =>  false
                                    ) 
                                );
                            }
                            // single post content block
                            self::post_content_block( 'entry-content p-3' );
                        ?>
                    </div>
                    <?php
                        // visible only in admin mode 
                        if ( get_edit_post_link() ) {
                            self::edit_post_screen_reader_block( 'col-12 p-3' );
                        }
                        // social media sharing block
                        if ( get_theme_mod( 'enable_wonkode_social_media_sharing' ) ) {
                            self::social_media_shares_block( 'co-12 p-3' );
                        }
                        /**
                        * Displays comments area with comment form if comments are open, 
                        * or there is some number of comments, and password is not required
                        */
                        if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
                            self::comments_block( 'col-12 p-4' );
                        }
                    ?>
                </div>
            </article><!-- #page-<?php the_ID(); ?>.card -->
            <?php
        }
        /**
         * Renders post content block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        private static function post_content_block( $class_additions = '' ) {
            // get class list for block
            $block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['single_main'] );
            ?>
            <div class="<?php echo esc_attr( $block_cls_list ); ?>">
                <?php 
                    the_content();

                    // Displays page links for paginated posts
                    wp_link_pages( 
                        array(
                            'before'    =>  '<nav class="page-links" aria-label="' . esc_attr__( 'Page', self::$txt_dom ) . '">',
                            'after'     =>  '</nav>',
                            // Translators: %s : page number
                            'pagelink'  =>  esc_html__( 'Page %s', self::$txt_dom )
                        ) 
                    );
                ?>
            </div>
            <?php
        }
        /**
         * Renders post meta block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        private static function post_meta_block( $class_additions = '' ) {
            // get class list for block
            $block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['post_meta'] );
            ?>
            <div class="<?php echo esc_attr( $block_cls_list ); ?>">
                <div class="entry-meta">
                    <?php wonkode_posted_on_by_meta(); ?>
                </div>
            </div>
            <?php
        }
        /**
         * Renders taxonomy links block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        private static function taxonomy_links_block( $class_additions = '' ) {
            // get class list for block
            $block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['tax_links'] );
            ?>
            <div class="<?php echo esc_attr( $block_cls_list ); ?>">
                <?php 
                    // get category list
                    echo get_the_term_list( get_the_ID(), 'category', '<span class="badge text-bg-primary">', '</span><span class="badge text-bg-primary">', '</span>' );

                    // get tags list
                    echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="badge text-bg-secondary">', '</span><span class="badge text-bg-secondary">', '</span>' );
                ?>
            </div>
            <?php
        }
        /**
         * Renders edit post link screen reader block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        private static function edit_post_screen_reader_block( $class_additions = '' ) {
            // get class list for block
            $block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['edit_screen_reader'] );

            // class attribte
            $cls_attr = ! empty( $block_cls_list ) ? ' class="' . esc_attr( $block_cls_list ) . '"' : '';
            ?>
            <div<?php echo $cls_attr; ?>>
                <?php
                    // displays edit post link for post
                    edit_post_link( 
                        sprintf( 
                            /**
                            * Translators: %s: post title, visible only for screen readers
                            */
                            esc_html__( 'Edit %s', self::$txt_dom ), 
                            '<span class="screen-reader-text">' . get_the_title() . '</span>' 
                        ), 
                        '<span class="edit-link">', 
                        '</span>' 
                    );
                ?>
            </div>
            <?php
        }
        /**
         * Renders social media sharing menu block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        private static function social_media_shares_block( $class_additions = '' ) {
            // get class list for block
            $block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['social_media'] );
            ?>
            <div class="<?php echo esc_attr( $block_cls_list ); ?>">
                <?php WonKode_Social_Media_Share_Menu::show_nav(); ?>
            </div>
            <?php
        }
        /**
         * Renders comment template block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        private static function comments_block( $class_additions = '' ) {
            // get class list for block
            $block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['comments_wrapper'] );
            ?>
            <div class="<?php echo esc_attr( $block_cls_list ); ?>">
                <?php comments_template(); ?>
            </div>
            <?php
        }
        /**
         * Renders post thumbnail with wrapping block. 
         * 
         * @since 1.0
         * @param array $args {
         *  Arguments to setup post thumbnail block. Defaults: []
         *      @type string 'block_classes'    Image column classes 
         *                                      to add to image wrapper 
         *                                      class. Defaults: ''.
         *      @type string 'img_size'         Image size to use when 
         *                                      thumbnail is rendered.
         *                                      Defaults: ''.
         *      @type string 'img_class'        Image tag class list. 
         *                                      Defaults: ''.
         *      @type bool 'img_as_link'        Whether image should be used 
         *                                      as link. Defaults: true. 
         * }
         * 
         * If you want to display image without link wrapper, 
         * set $args['img_as_link'] to false. For ex. for single posts.
         * 
         * @return void
         */
        public static function post_thumnail_block( $args = array() ) {
            $defaults = array(
                'block_classes' =>  '',
                'img_size'      =>  '',
                'img_class'     =>  '',
                'img_as_link'   =>  true
            );
            $args = wp_parse_args( $args, $defaults );

            // image ize
            $args['img_ize'] = ! empty( $args['img_ize'] ) ? $args['img_ize'] : 'large';
            // image class
            $args['img_class'] = ! empty( $args['img_class'] ) ? $args['img_class'] : 'img-fluid';
            // image tag class list
            $img_classes = WonKode_Helper::list_classes( $args['img_class'] );
            
            // get class list for block
            $img_block_cls_list = self::get_all_block_class_list( $args['block_classes'], self::$block_classes_assoc['img_wrapper'] );
            // get post image
            $post_img = get_the_post_thumbnail( 
                get_the_ID(), 
                $args['img_size'], 
                array( 
                    'class' => esc_attr( $img_classes ), 
                    'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ) 
                ) 
            );
            ?>
            <div class="<?php echo esc_attr( $img_block_cls_list ); ?>">
                <?php if ( $args['img_as_link'] ) { ?>
                <a href="<?php the_permalink(); ?>">
                    <?php echo $post_img; ?>
                </a>
                <?php 
                } else {
                    echo $post_img;
                } ?>
            </div>
            <?php
        }
        /**
         * Renders post excerpt block.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions String of classes separated by 
         *                                  space to add to excerpt block. 
         *                                  Defaults: ''
         * @return void
         */
        private static function post_excerpt_block( $class_additions = '' ) {
            // get class list for block
            $excerpt_block_cls_list = self::get_all_block_class_list( $class_additions, self::$block_classes_assoc['excerpt_main'] );
            ?>
            <div class="<?php echo esc_attr( $excerpt_block_cls_list ); ?>">
                <?php 
                    // get category list
                    echo get_the_term_list( get_the_ID(), 'category', '<span class="badge text-bg-primary">', '</span><span class="badge text-bg-primary">', '</span>' );
                ?>
                <div class="entry-title">
                    <?php 
                        the_title( sprintf( '<h2 class="excerpt-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
                    ?>
                </div>
                <div class="entry-content pe-4">
                    <p>
                        <a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>
                    </p>
                </div>
                <div class="entry-meta">
                    <?php wonkode_posted_on_by_meta(); ?>
                </div>
            </div>
            <?php
        }
        /**
         * Returns class list ready for use 
         * as class attribute value for an html 
         * block by adding classes to default
         * classes for the block. 
         * 
         * NOTE: You may not sanitize the returned 
         * value as it goes through santization 
         * processes when returned.
         * 
         * @access private
         * 
         * @since 1.0
         * @param string $class_additions       List of class to 
         *                                      add to block default 
         *                                      classes. Defults: ''
         * @param array $default_classes_arr    Default classes array. 
         *                                      Defaults: []
         * @return string Class list ready for use.
         */
        private static function get_all_block_class_list( $class_additions = '', $default_classes_arr = array() ) {
            // default classes should be array
            $default_classes_arr = ! is_array( $default_classes_arr ) ? (array) $default_classes_arr : $default_classes_arr;
            // if additonal classes passed
            if ( ! empty( $class_additions ) ) {
                WonKode_Helper::add_to_classes( $class_additions, $default_classes_arr );
            }
            // return class list
            return WonKode_Helper::list_classes( $default_classes_arr );
        }

    } // ENDS -- class
}