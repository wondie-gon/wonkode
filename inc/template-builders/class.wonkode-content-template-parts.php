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

                // hook to custom action
                add_action( self::$unique_prefix . '_append_ui_icons_symbols', array( 'WonKode_Content_Template_Parts', 'taxonomy_ui_icons_svg_symbols' ), 10 );

                add_action( self::$unique_prefix . '_post_navigation', array( 'WonKode_Content_Template_Parts', 'get_post_links_nav' ) );
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
         * @param array $show_taxos Array of built in taxonomies to show in the post block. 
         *                          Defaults to: array( 'post_tag' ). 
         * 
         *                          If you want to show both category and tags: 
         *                          pass array( 'category', 'post_tag' ) as param.
         * @param bool $tax_icon    Whether to display taxonomy icon. Defaults: false.
         * 
         * @return void
         */
        public static function image_on_top_post_card( $args = array(), $show_taxos = array( 'post_tag' ), $tax_icon = false ) {
            echo self::get_image_on_top_post_card( $args, $show_taxos, $tax_icon );
        }
        /**
         * Returns card block with post data filled.
         * 
         * @since 1.0
         * @param array $args       Array of arguments for card 
         *                          block configuration. You can 
         *                          refer arguments in WonKode_Cards::$card_config. 
         *                          Defaults: []
         * @param array $show_taxos  Array of built in taxonomies to show in the post block. 
         *                          Defaults to: array( 'post_tag' ). 
         *                          If you want to show both category and tags: 
         *                          pass array( 'category', 'post_tag' ) as param.
         * @param bool $tax_icon    Whether to display taxonomy icon. Defaults: false
         * 
         * @return mixed Card filled with post content.
         */
        public static function get_image_on_top_post_card( $args = array(), $show_taxos = array( 'post_tag' ), $tax_icon = false ) {
            $defaults = array(
                'card_class'    =>	'',
                'inline_styles' =>	array(),
                'img_size'      =>  'medium',
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

            // title tag
            $args['title_tag'] = ! empty( $args['title_tag'] ) ? $args['title_tag'] : 'h5';
            // title class
            $args['title_class'] = ! empty( $args['title_class'] ) ? $args['title_class'] : 'card-title entry-title';

            $card_html .= $card::get_card_title_open( $args['title_tag'], $args['title_class'] );
            $card_html .= '<a href="' . esc_url( get_the_permalink() ) . '">';
            $card_html .= get_the_title();
            $card_html .= '</a>';
            $card_html .= $card::get_card_title_close( $args['title_tag'] );

            // get taxonomy link badges
            $card_html .= self::get_post_taxonomy_badges_block( $show_taxos, $tax_icon );

            // post excerpt
            $card_html .= $card::get_card_post_excerpt( get_the_excerpt(), $args );

            // post meta area
            $card_html .= $card::get_div_open( 'card-post-meta' );
            // posted on meta
            $card_html .= wonkode_get_minimal_posted_on();
            // posted by meta
            $card_html .= wonkode_get_minimal_posted_by();
            // close block
            $card_html .= $card::get_div_close();


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
            $card = new WonKode_Cards();

            $defaults = array(
                'card_class'    =>	'',
                'inline_styles' =>	array(),
                'header_class'	=>	'',
                'img_size'      =>  'medium',
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
                'link_text'	    =>	'',
                'footer_class'	=>	'',
            );

            // get parsed $args
            $args = wp_parse_args( $args, $defaults );
            // test args
            // print_r( $args );
            
            // start card html
            $card_html = '';

            // addition to card class
            $args['card_class'] = ! empty( $args['card_class'] ) ? $args['card_class'] : '';

            // get card opening
            $card_html .= $card::get_inline_styled_card_open( $args['card_class'], $args['inline_styles'] );
            /**
             * Card header
             */
            if ( $has_header ) {
                // open header
                $card_hdr_classes = array( 'card-header' );
                $card_html .= $card::get_div_open( $args['header_class'], $card_hdr_classes );
                /**
                 * Title as header content
                 */
                // title tag
                $args['title_tag'] = ! empty( $args['title_tag'] ) ? $args['title_tag'] : 'h5';
                // title class
                $args['title_class'] = ! empty( $args['title_class'] ) ? $args['title_class'] : 'card-header-title entry-title';
                $card_html .= $card::get_card_title_open( $args['title_tag'], $args['title_class'] );
                $card_html .= get_the_title();
                $card_html .= $card::get_card_title_close( $args['title_tag'] );
                /**
                 * get tag links
                 */
                $card_html .= $card::get_div_open( 'tag-links' );
                $card_html .= get_the_term_list( get_the_ID(), 'post_tag', '<span class="tag-link-badge badge">', '</span><span class="tag-link-badge badge">', '</span>' );
                $card_html .= $card::get_div_close();

                // close header
                $card_html .= $card::get_div_close();
            }

            // card body opening
            $card_html .= $card::get_card_body_open( $args['body_class'] );

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
            $card_html .= $card::get_div_close();         
            
            // card body closing
            $card_html .= $card::get_card_body_close();

            /**
             * Card footer
             */
            if ( $has_footer ) {
                // open footer
                $card_ftr_classes = array( 'card-footer' );
                $card_html .= $card::get_div_open( $args['footer_class'], $card_ftr_classes );

                // post meta area
                $card_html .= $card::get_div_open( 'card-post-meta' );
                // posted on meta
                $card_html .= wonkode_get_minimal_posted_on();
                // posted by meta
                $card_html .= wonkode_get_minimal_posted_by();
                // close block
                $card_html .= $card::get_div_close();

                // post links area
                $card_html .= $card::get_div_open( 'card-post-links' );

                // get post link
                $card_html .= $card::get_link_element(
                    array(
                        'class'         =>  ! empty( $args['link_class'] ) ? $args['link_class'] : 'btn btn-primary btn-sm',
                        'href'	        =>	get_the_permalink(),
                        'link_text'	    =>	! empty( $args['link_text'] ) ? $args['link_text'] : 'View Full',
                    )
                );

                // get category links
                $card_html .= $card::get_div_open( 'cat-links' );
                $card_html .= get_the_term_list( get_the_ID(), 'category', '<span class="cat-link-badge badge">', '</span><span class="cat-link-badge badge">', '</span>' );
                $card_html .= $card::get_div_close();

                // close block
                $card_html .= $card::get_div_close();

                // close footer
                $card_html .= $card::get_div_close();
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
                    ?>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->
            <?php
        }
        /**
         * Renders related posts by the built in taxonomy 
         * passed as parameter which you want the posts 
         * to be related to the current post.
         * 
         * @since 1.0
         * @param int/string $num_posts Number of posts to display.
         *                              Defaults: 3
         * @param string $taxonomy      Name of taxonomy to use to 
         *                              query posts with which the 
         *                              posts will be related with 
         *                              currently displayed post.
         *                              Defaults to: 'category'.
         *                              Other value: 'post_tag'
         * @return mixed List of related posts.
         */
        public static function related_posts_by_tax( $num_posts = 3, $taxonomy = 'category' ) {
            // global $post;
            $_post = get_post();
            // print_r($_post);
            // query args
            $args = array(
                'posts_per_page'    =>  absint( $num_posts ),
                'post__not_in'      =>  array( $_post->ID ),
            );

            // taxonomies to show
            $show_taxos = array();

            // taxonomy parameter
            if ( 'post_tag' === $taxonomy ) {               
                // array to collect tag ids
                $tag_ids = array();
                // get tags of current post
                $post_tags = get_the_tags( $_post->ID );
                if ( $post_tags ) {
                    foreach ( $post_tags as $tag ) {
                        $tag_ids[] = $tag->term_id;
                    }
                    // add tag ids to query args
                    $args['tag__in'] = $tag_ids;
                }

                // tax links to show
                $show_taxos = array( 'category' );

            } else {
                $categories = get_the_category( $_post->ID );
                $args['cat'] = ( ! empty( $categories ) ) ? $categories[0]->term_id : null;

                // tax links to show
                $show_taxos = array( 'post_tag' );
            }

            // query posts
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                // get row class to add
                $row_class = 'row row-cols-1 row-cols-md-3 g-4';
                if ( $num_posts <= 6 ) {
                    $row_class = 'row row-cols-1 row-cols-md-' . $num_posts . ' g-4';
                }
                $row_class = WonKode_Helper::list_classes( $row_class );
                ?>
                <div class="<?php echo esc_attr( $row_class ); ?>">
                <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <div class="col">
                        <?php
                            // display related posts
                            self::image_on_top_post_card( array( 'card_class' => 'h-100 related-post' ), $show_taxos, true );
                            // self::header_footer_post_card( array( 'card_class' => 'h-100 related-post' ) );
                        ?>
                        </div>
                        <?php
                    } // end while
                ?>
                </div>
                <?php
                // reset post data
                wp_reset_postdata();
            }
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
                    ?>
                </div>
            </article><!-- #page-<?php the_ID(); ?> -->
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
                    echo get_the_term_list( get_the_ID(), 'category', '<span class="cat-link-badge badge">', '</span><span class="cat-link-badge badge">', '</span>' );

                    // get tags list
                    echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="tag-link-badge badge">', '</span><span class="tag-link-badge badge">', '</span>' );
                ?>
            </div>
            <?php
        }
        /**
         * Return HTML block with taxonomy link badges of the current post.
         * 
         * @since 1.0
         * @param array $show_taxos Array of built in taxonomies to show in the post block. 
         *                          Defaults to: array( 'post_tag' ). 
         *                          If you want to show both category and tags: 
         *                          pass array( 'category', 'post_tag' ) as param.
         * @param bool $with_icon   Whether to display taxonomy icon. Defaults: false
         * @return mixed HTML block with taxonomy link badges.
         */
        public static function get_post_taxonomy_badges_block( $show_taxos = array( 'post_tag' ), $with_icon = false ) {
            
            // initialialize UI Component
            $ui = new WonKode_UI_Components();

            // init html output
            $ui_html = '';

            if ( in_array( 'post_tag', $show_taxos ) || in_array( 'category', $show_taxos ) ) {
                // wrapping both taxonomy links
                $ui_html .= $ui::get_div_open( 'post-taxos-wrapper' );

                if ( in_array( 'post_tag', $show_taxos ) && in_array( 'category', $show_taxos ) ) {
                    // category links
                    if ( has_category() ) {
                        $ui_html .= $ui::get_div_open( 'cat-links' );
                        // $ui_html .= get_the_term_list( get_the_ID(), 'category', '<span class="cat-link-badge badge">', '</span><span class="cat-link-badge badge">', '</span>' );
                        $ui_html .= self::get_categories_list( '', $with_icon );
                        $ui_html .= $ui::get_div_close();
                    }
                    // tag links
                    if ( has_tag() ) {
                        $ui_html .= $ui::get_div_open( 'tag-links' );
                        $ui_html .= self::get_post_tags_list( '', $with_icon );
                        $ui_html .= $ui::get_div_close();
                    }
    
                } elseif ( in_array( 'post_tag', $show_taxos ) && has_tag() && ! in_array( 'category', $show_taxos ) ) {
                    $ui_html .= $ui::get_div_open( 'tag-links' );
                    $ui_html .= self::get_post_tags_list( '', $with_icon );
                    $ui_html .= $ui::get_div_close();
                } elseif ( in_array( 'category', $show_taxos ) && has_category() && ! in_array( 'post_tag', $show_taxos ) ) {
                    $ui_html .= $ui::get_div_open( 'cat-links' );
                    $ui_html .= self::get_categories_list( '', $with_icon );
                    $ui_html .= $ui::get_div_close();
                } else {
                    $ui_html .= '';
                }

                // closing taxonomy wrapper
                $ui_html .= $ui::get_div_close();
            }
            // return html
            return $ui_html;
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
         * Action function to display post navigation. 
         * 
         * Hooked to: self::$unique_prefix . '_post_navigation' 
         * action hook.
         * 
         * @see https://developer.wordpress.org/reference/functions/get_the_post_navigation/
         * 
         * @since 1.0
         * @param array $args 	Arguments for post navigation
         * @return void
         */
        public static function get_post_links_nav( $args = array() ) {
            $args = wp_parse_args(
                $args, 
                array(
                    'format'            => '%link',
                    'prev_icon'         => '<i class="fas fa-arrow-left"></i>',
                    'next_icon'         => '<i class="fas fa-arrow-right"></i>',
                    'link'              => '%title',
                    'in_same_term'      => false,
                    'excluded_terms'    => '',
                    'taxonomy'          => 'category',
                    'aria_label'        => __( 'Posts', self::$txt_dom ),
                    'class'             => 'navigation post-navigation',
                )
            );

            // include icons
            $prev_link = $args['prev_icon'] . ' ' . $args['link'];
	        $next_link = $args['link'] . ' ' . $args['next_icon'];

            // class list for nav
            $nav_class_list = WonKode_Helper::list_classes( $args['class'] );
            ?>
            <nav class="<?php echo esc_attr( $nav_class_list ); ?>" aria-label="<?php echo esc_html( $args['aria_label'] ); ?>">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <?php previous_post_link( $args['format'], $prev_link, $args['in_same_term'], $args['excluded_terms'], $args['taxonomy'] ); ?>
                    </li>
                    <li class="page-item">
                        <?php next_post_link( $args['format'], $next_link, $args['in_same_term'], $args['excluded_terms'], $args['taxonomy'] ); ?>
                    </li>
                </ul>
            </nav>
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
                    echo get_the_term_list( get_the_ID(), 'category', '<span class="cat-link-badge badge">', '</span><span class="cat-link-badge badge">', '</span>' );
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
         * Action hook to add taxonomy svg symbols. 
         * 
         * Used by custom action hook: 'wonkode_add_to_svg_symbols'
         * 
         * @since 1.0
         * @param array $args 		{
         * 		Array of arguments you want to modify in the <symbol> tag
         * 		while retrieving svg resources. Default is empty.
         * 			@type string 'view_box'		Value for 'viewBox' attribute.
         * 			@type int    'size'			Value for 'size' attribute.
         * 			@type int    'stroke_w'		Value for 'stroke-width' attribute.
         * 			@type string 'stroke'		Value for 'stroke' (color) attribute.
         * 			@type string 'fill'			Value for 'fill' (color) attribute.
         * }
         * @return void
         */
        public static function taxonomy_ui_icons_svg_symbols( $args = array() ) {
            $names = array( 'category', 'tags' );
            $symbols = WonKode_SVG_Resources::get_icon_symbols( 'ui-icons', $names, $args );
            if ( ! empty( $symbols ) ) {
                echo $symbols;
            }
        }

        /**
         * Returns category links list.
         * 
         * @since 1.0
         * @param string $class_additions   List of clases to add to link badges. 
         *                                  Defaults to: empty
         * @param bool $with_icon           Whether to add icon in front of each badge. 
         *                                  Defaults to: false
         * @return mixed HTML list of cat link badges.
         */
        public static function get_categories_list( $class_additions = '', $with_icon = false ) {
            // default classes
            $cat_classes = array( 'cat-link-badge', 'badge' );

            // get all classes
            $cat_cls_list = self::get_all_block_class_list( $class_additions, $cat_classes );

            $before = '';
            $sep = '</span>';

            if ( $with_icon ) {
                $before .= WonKode_SVG_Resources::get_svg_use_block( 'category', 'icon', array( 'class' => 'cat-icon me-2', 'width' => 16, 'height' => 16 ) );

                $sep .= WonKode_SVG_Resources::get_svg_use_block( 'category', 'icon', array( 'class' => 'cat-icon me-2', 'width' => 16, 'height' => 16 ) );
            }

            $before .= '<span class="' . esc_attr( $cat_cls_list ) . '">';
            $sep .= '<span class="' . esc_attr( $cat_cls_list ) . '">';
            $after = '</span>';

            // return link badges
            return get_the_term_list( get_the_ID(), 'category', $before, $sep, $after );
        }
        /**
         * Returns tags links list.
         * 
         * @since 1.0
         * @param string $class_additions   List of clases to add to link badges. 
         *                                  Defaults to: empty
         * @param bool $with_icon           Whether to add icon in front of each badge. 
         *                                  Defaults to: false
         * @return mixed HTML list of tag link badges.
         */
        public static function get_post_tags_list( $class_additions = '', $with_icon = false ) {
            // default classes
            $tag_classes = array( 'tag-link-badge', 'badge' );

            // get all classes
            $tag_cls_list = self::get_all_block_class_list( $class_additions, $tag_classes );

            $before = '';
            $sep = '</span>';

            if ( $with_icon ) {
                $before .= WonKode_SVG_Resources::get_svg_use_block( 'tags', 'icon', array( 'class' => 'tag-icon me-2', 'width' => 16, 'height' => 16 ) );

                $sep .= WonKode_SVG_Resources::get_svg_use_block( 'tags', 'icon', array( 'class' => 'tag-icon me-2', 'width' => 16, 'height' => 16 ) );
            }

            $before .= '<span class="' . esc_attr( $tag_cls_list ) . '">';
            $sep .= '<span class="' . esc_attr( $tag_cls_list ) . '">';
            $after = '</span>';

            // return link badges
            return get_the_term_list( get_the_ID(), 'post_tag', $before, $sep, $after );
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