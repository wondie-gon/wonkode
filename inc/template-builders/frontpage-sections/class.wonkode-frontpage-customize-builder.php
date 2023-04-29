<?php 
/**
 * Class for custom frontpage sections templates
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if ( ! class_exists( 'WonKode_Frontpage_Customize_Builder' ) ) {
  class WonKode_Frontpage_Customize_Builder {
    /**
     * Theme identifier, text domain
     * 
     * @since 1.0
     * @var string 
     */
    public static $txt_dom;
    /**
     * Unique prefix for naming 
     * filter and action hooks etc
     * 
     * @since 1.0
     * @var string
     */
    public static $unique_prefix;
    /**
     * Customize defaults
     * 
     * @since 1.0
     * @var array
     */
    public static $defaults = WK_DEFAULTS;
    /**
     * Object instance of template 
     * builder for post content blocks.
     * 
     * @since 1.0
     * @var object
     */
    public static $content_template;
    /**
     * Class constructor
     */
    public function __construct() {
      // set text domain
      self::$txt_dom = WonKode_Helper::get_texdomain();
      // set unique prefix
      self::$unique_prefix = WonKode_Helper::get_unique_prefix();
      // initialize content template
      self::init_content_template();
    }
    /**
     * Initialize content template class
     * to be used for building post blocks. 
     * 
     * @since 1.0
     * @return void
     */
    public static function init_content_template() {
        if ( ! class_exists( 'WonKode_Content_Template_Parts' ) ) {
            require_once get_template_directory() . '/inc/template-builders/class.wonkode-content-template-parts.php';
        }
        // initialize content template builder class
        self::$content_template = WonKode_Content_Template_Parts::init();
    }

    /**
     * Renders page separator section title
     * 
     * @since 1.0
     * 
     * @param string $section_title       Section title.
     * @return void
     */
    public static function render_section_title( $section_title ) {
      // check for section title
      if ( ! empty( $section_title ) ) {
        // section divider title
        $pg_section_title = sprintf( esc_html__( '%s', self::$txt_dom ), $section_title );
        /**
         * Action hook to display page section title
         * 
         * @since 1.0
         * @param string $pg_section_title  Title of page section
         */
        do_action( self::$unique_prefix . "_page_section_title", $pg_section_title );
      }
    }

    /**
     * Returns front section wrapper opening tag.
     * 
     * @since 1.0
     * @param string|array $new_classes List of class to add. Defaults: ''
     * @param string $id                Value for id attribute for section.
     *                                  Defaults: ''
     * @return mixed Section wrapper opening html tag with class attributes
     */
    public static function get_front_section_opened( $new_classes = '', $id = '' ) {
      $class_arr = array();
      // container classes from customizer
      $class_arr[] = get_theme_mod( self::$unique_prefix . '_inner_container_bs_class', self::$defaults['_inner_container_bs_class'] );
      // section wrapper class
      $section_wrapper_classes = WonKode_Helper::list_classes( $new_classes, $class_arr );
      // id for section
      $section_id = ( ! empty( $id ) ) ? ' id="' . esc_attr( $id ) . '"' : '';

      // return section wrapper opening tag
      return '<div' . $section_id  . ' class="' . esc_attr( $section_wrapper_classes ) . '">';
    }
    /**
     * Returns front section wrapper closing tag.
     * 
     * @since 1.0
     * @return mixed HTML div closing.
     */
    public static function get_front_section_closed() {
      return '</div>';
    }

      /**
       * Renders a horizontal card post content 
       * with image on left.
       * 
       * @since 1.0
       * 
       * @param array $additional_classes List of classes for post content block. 
       *                                  Defaults: []
       * @return void
       */
      public static function show_left_image_post_card( $additional_classes = array() ) {
        // get wrapper class list
        $wrapper_cls_list = WonKode_Helper::list_classes( 'card', $additional_classes );
        // excerpt block class additions
        $excerpt_block_class = 'col-md-7 col-lg-8 left-img-excerpt p-5';
        // image wrapper column class additions
        $img_col_classes = 'col-md-5 col-lg-4 image-on-left';
        // args for image block
        $img_block_args = array();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ); ?>>
            <div class="row g-0">
            <?php 
                if ( ! has_post_thumbnail() ) {
                    // classes for fullwidth block
                    $excerpt_block_class = 'col-12 excerpt-full p-5';
                    self::post_excerpt_block( $excerpt_block_class );
                } else {
                    // post thumbnail block
                    $img_block_args['block_classes'] = $img_col_classes;
                    self::$content_template::post_thumnail_block( $img_block_args );
                    // post excerpt block
                    self::post_excerpt_block( $excerpt_block_class );
                } 
            ?>
            </div>
        </article>
        <?php
    }

    /**
     * Renders a horizontal card post content 
     * with image on right.
     * 
     * @since 1.0
     * 
     * @param array $additional_classes List of classes for post content block. 
     *                                  Defaults: []
     * @return void
     */
    public static function show_right_image_post_card( $additional_classes = array() ) {
        // get wrapper class list
        $wrapper_cls_list = WonKode_Helper::list_classes( 'card', $additional_classes );
        // excerpt block class additions
        $excerpt_block_class = 'col-md-7 col-lg-8 right-img-excerpt p-5';
        // image wrapper column class additions
        $img_col_classes = 'col-md-5 col-lg-4 image-on-right';
        // args for image block
        $img_block_args = array();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ); ?>>
            <div class="row g-0">
            <?php 
                if ( ! has_post_thumbnail() ) {
                    // classes for fullwidth block
                    $excerpt_block_class = 'col-12 excerpt-full p-5';
                    self::post_excerpt_block( $excerpt_block_class );
                } else {
                    // post excerpt block
                    self::post_excerpt_block( $excerpt_block_class );
                    // post thumbnail block
                    $img_block_args['block_classes'] = $img_col_classes;
                    self::$content_template::post_thumnail_block( $img_block_args );
                } 
            ?>
            </div>
        </article>
        <?php
    }

    /**
     * Renders a horizontal card post content 
     * with image on top.
     * 
     * @since 1.0
     * 
     * @param array $additional_classes List of classes for post content block. 
     *                                  Defaults: []
     * @return void
     */
    public static function show_top_image_post_card( $additional_classes = array() ) {
        // get wrapper class list
        $wrapper_cls_list = WonKode_Helper::list_classes( 'card', $additional_classes );
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ); ?>>
        <?php 
            if ( has_post_thumbnail() ) {
                echo get_the_post_thumbnail( 
                    get_the_ID(), 
                    'medium', 
                    array( 
                        'class' => esc_attr( 'card-img-top' ), 
                        'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ) 
                    ) 
                );
                // card body block
                self::post_card_body_block();
            } else {
                // card body block
                self::post_card_body_block();
            }
        ?>
        </article>
        <?php
    }

    /**
     * Renders card component post with image overlay. 
     * 
     * Not wrapped in a link element.
     * 
     * @since 1.0
     * 
     * @param array $additional_classes List of classes for post content block. 
     *                                  Defaults: []
     * @return void
     */
    public static function show_image_overlay_post_card( $additional_classes = array() ) {
        // get wrapper class list
        $wrapper_cls_list = WonKode_Helper::list_classes( 'card img-overlayed', $additional_classes );
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( $wrapper_cls_list ); ?>>
        <?php 
            // taxonomy outside of excerpt block
            if ( has_tag() ) {
                self::taxonomies_block( array( 'post_tag' ) );
            }

            if ( has_post_thumbnail() ) {
                echo get_the_post_thumbnail( 
                    get_the_ID(), 
                    'medium', 
                    array( 
                        'class' => esc_attr( 'card-img' ), 
                        'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ) 
                    ) 
                );
                // card body with class 'card-img-overlay' class
                self::post_card_body_block( array( 'card_body_class'    =>  'card-img-overlay', 'show_taxonomy' =>  false, 'show_meta' =>  false ) );
            } else {
                // card body block with default class
                self::post_card_body_block( array( 'card_body_class'    =>  'card-img-overlay', 'show_taxonomy' =>  false, 'show_meta' =>  false ) );
            }
        ?>
        </article>
        <?php
    }
    
    /**
     * Renders card body block 
     * with title, excerpt, and other 
     * text contents with bootstrap 
     * card component classes, instead of 
     * default classes names.
     * 
     * 
     * @since 1.0
     * @param string $args  Array of arguments that determines 
     *                      how card body is diplayed. 
     *              [
     *                  @type bool'card_body_class' Class list for card body block. 
     *                                              Defaults: '',
     *                  @type bool 'show_taxonomy'  Whether to display taxonomy links. 
     *                                              Defaults: true,
     *                  @type bool 'show_meta'      Whether to display date and author. 
     *                                              Defaults: true,
     *                  @type bool 'show_excerpt'   Whether to display excerpt. 
     *                                              Defaults: true,
     *                  @type bool 'show_link_btn'  Whether to display link button. 
     *                                              Defaults: true,
     *              ]
     * @return void
     */
    public static function post_card_body_block( $args = array() ) {
        $args = wp_parse_args( 
                    $args, 
                    array(
                        'card_body_class'   =>  '',
                        'show_taxonomy'     =>  true,
                        'show_meta'         =>  true,
                        'show_excerpt'      =>  true,
                        'show_link_btn'     =>  true,
                    ) 
                );
        // get class list for block
        $card_body_cls_list = ( ! empty( $args['card_body_class'] ) ) ? WonKode_Helper::list_classes( $args['card_body_class'] ) : 'card-body';
        ?>
        <div class="<?php echo esc_attr( $card_body_cls_list ); ?>">
            <?php
                if ( has_tag() && $args['show_taxonomy'] ) {
                    // taxonomy links block
                    self::taxonomies_block( array( 'post_tag' ) );
                }
                // title
                self::the_post_title( 'card-title' );
                // meta data block
                if ( $args['show_meta'] ) {
                    self::the_meta_data_block();
                }
                // excerpt 
                if ( $args['show_excerpt'] ) {
                    self::the_post_excerpt( 'card-text' );
                }
                // link button
                if ( $args['show_link_btn'] ) {
                    self::the_post_link_btn( 'Read More' );
                }
            ?>
        </div>
        <?php
    }

    /**
     * Renders post excerpt block.
     * 
     * @since 1.0
     * @param string $block_class   String of classes separated by 
     *                              space to add to excerpt block. 
     *                              Defaults: ''
     * @return void
     */
    public static function post_excerpt_block( $block_class = '' ) {
        // get class list for block
        $excerpt_block_cls_list = WonKode_Helper::list_classes( $block_class );
        ?>
        <div class="<?php echo esc_attr( $excerpt_block_cls_list ); ?>">
            <?php
                if ( has_tag() ) {
                    // taxonomy links block
                    self::taxonomies_block( array( 'post_tag' ) );
                }
                // title
                self::the_post_title();
                // meta data block
                self::the_meta_data_block();
                // excerpt 
                self::the_post_excerpt();
                // link button
                self::the_post_link_btn( 'Read More' );
            ?>
        </div>
        <?php
    }
    /**
     * Renders HTML block with taxonomy link badges of the current post.
     * 
     * @since 1.0
     * @param array $show_taxos             Array of built in taxonomies 
     *                                      to show in the post block. 
     *                                      Defaults to: array( 'post_tag' ). 
     *                                      If you want to show both category and tags: 
     *                                      pass array( 'category', 'post_tag' ) 
     *                                      as param.
     * @return void
     */
    public static function taxonomies_block( $show_taxos = array( 'post_tag' ) ) {
        // taxonomy links block
        self::$content_template::post_tax_link_badges_block( array( 'post_tag' ) );
    }
    /**
     * Renders title of current loop post.
     * 
     * @since 1.0
     * 
     * @param string $title_class   Class for title. Default: ''
     * @param bool $is_link         Whether post title is set as link. 
     * @return void.
     */
    public static function the_post_title( $title_class = '', $is_link = true ) {
        // get class list for title
        $title_cls_list = ( ! empty( $title_class ) ) ? WonKode_Helper::list_classes( $title_class ) : 'entry-title';
        if ( $is_link ) {
            the_title( 
                sprintf( 
                    '<h2 class="%1$s"><a href="%2$s">', 
                    esc_attr( $title_cls_list ),
                    esc_url( get_permalink() ) 
                ), 
                '</a></h2>' 
            );
        } else {
            the_title( 
                sprintf( 
                    '<h2 class="%1$s">', 
                    esc_attr( $title_cls_list )
                ), 
                '</h2>' 
            );
        }
    }

    /**
     * Renders excerpt of current loop post.
     * 
     * @since 1.0
     * 
     * @param string $excerpt_class   Class for excerpt. Default: ''
     * @return void.
     */
    public static function the_post_excerpt( $excerpt_class = '' ) {
        // get class list for excerpt
        $excerpt_cls_list = ( ! empty( $excerpt_class ) ) ? WonKode_Helper::list_classes( $excerpt_class ) : 'entry-excerpt';
        ?>
        <p class="<?php echo esc_attr( $excerpt_cls_list ); ?>"><?php echo wp_strip_all_tags( get_the_excerpt() ); ?></p>
        <?php
    }

    /**
     * Renders the meta data block of current loop post.
     * 
     * @since 1.0
     * 
     * @param string $block_class   Class for meta data block. Default: ''
     * @return void.
     */
    public static function the_meta_data_block( $block_class = '' ) {
        // get class list for meta block
        $meta_cls_list = ( ! empty( $block_class ) ) ? WonKode_Helper::list_classes( $block_class ) : 'entry-meta';
        ?>
        <div class="<?php echo esc_attr( $meta_cls_list ); ?>">
            <?php self::$content_template::post_date_and_author_meta_nav(); ?>
        </div>
        <?php
    }
    /**
     * Renders link button of current post.
     * 
     * @since 1.0
     * 
     * @param string $btn_text  Text for link button.
     * @param string $btn_class List of class string separated 
     *                          by space for link button. Default: ''
     * @return void
     */
    public static function the_post_link_btn( $btn_text, $btn_class = '' ) {
        // get class list for btn
        $btn_cls_list = ( ! empty( $btn_class ) ) ? WonKode_Helper::list_classes( $btn_class ) : 'btn btn-primary';
        echo sprintf( 
            '<a href="%1$s" class="%2$s">%3$s</a>',
            esc_url( get_the_permalink() ),
            esc_attr( $btn_cls_list ),
            sprintf( __( '%s', self::$txt_dom ), esc_html( $btn_text ) )
        );
    }

  } // END --- class
}