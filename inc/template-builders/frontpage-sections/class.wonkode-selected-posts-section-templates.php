<?php 
/**
 * Class for frontpage selected posts section templates
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Selected_Posts_Section_Templates' ) ) {
    class WonKode_Selected_Posts_Section_Templates extends WonKode_Frontpage_Customize_Builder {
        /**
         * Constructor
         */
        public function __construct() {
            parent::__construct();
        }
        /**
         * Renders front section wrapper opening tag 
         * with all its class and id attributes before 
         * section's main content.
         * 
         * @since 1.0
         * @param string|array $new_classes List of class to add. Defaults: ''
         * @param string $id                Value for id attribute for section.
         *                                  Defaults: ''
         * @return void
         */
        public static function before_section_content( $new_classes = '', $id = '' ) {
            echo self::get_front_section_opened( $new_classes, $id );
        }
        /**
         * Renders front section wrapper closing tag 
         * after section's main content.
         */
        public static function after_section_content() {
            echo self::get_front_section_closed();
        }
        /**
         * Renders selected posts section content 
         * when enabled and customized in theme 
         * customizer.
         * 
         * @since 1.0
         * @param array $args   Array of arguments for additional classes 
         *                      and other attributes 
         *              array(
         *                  @type string 'row_class' additional classes for row 
         *                  @type string 'col_class' additional classes for post columns 
         *                  @type string   'col_class_additions'    additional class. Default: ''
         *                  @type string   'animation_classes'      class names for animation. 
         *                                                          Default: 'wow fadeInUp'
         *                  @type string   'animation_delay'        Data attribute value for 
         *                                                          animation delay in seconds. 
         *                                                          Default: '0.3s'.
         *              )
         * @return mixed|html               
         */
        public static function main_section_content( $args = array() ) {
            $main_content_args = wp_parse_args( 
                $args, 
                array(  
                    'row_class' =>  '',
                    'col_class'             =>  'col',
                    'col_class_additions'   =>  '',
                    'animation_classes'     =>  'wow fadeInUp',
                    'animation_delay'       =>  '0.3s'
                ) 
            );
            /**
             * Gets bootstrap row-cols classes
             */
            // cols in sm devices
            $sm_cols = absint( get_theme_mod( self::$unique_prefix . '_front_selected_posts_cols_sm', self::$defaults['_front_selected_posts_cols_sm'] ) );
            // cols in md devices
            $md_cols = absint( get_theme_mod( self::$unique_prefix . '_front_selected_posts_cols_md', self::$defaults['_front_selected_posts_cols_md'] ) );
            // cols in lg devices
            $lg_cols = absint( get_theme_mod( self::$unique_prefix . '_front_selected_posts_cols_lg', self::$defaults['_front_selected_posts_cols_lg'] ) );
            
            // get row-cols-*
            $row_cols_classes = "row row-cols-1 row-cols-sm-{$sm_cols} row-cols-md-{$md_cols} row-cols-lg-{$lg_cols}";
            $row_classes = WonKode_Helper::list_classes( $row_cols_classes, $main_content_args['row_class'] );
            ?>
            <div class="<?php echo esc_attr( $row_classes ); ?>">
            <?php 
                // post columns
                self::post_content_columns( $main_content_args );
            ?>
            </div>
            <?php
        }

        /**
         * Renders selected posts section title
         * 
         * @since 1.0
         * 
         * @return void
         */
        public static function section_title_block() {
            // get section title
            $section_title = get_theme_mod( self::$unique_prefix . '_front_selected_posts_section_title', self::$defaults['_front_selected_posts_section_title'] );

            self::render_section_title( $section_title );
        }

        /**
         * Renders post columns with default column class 
         * and additional passed class. It also includes classes 
         * for animation, and data attribute for animation delay.
         * 
         * @since 1.0
         * 
         * @param array $col_args = array(
         *      Defaults []
         *          @type string   'col_class'              column class. Default: 'col'
         *          @type string   'col_class_additions'    additional class. Default: ''
         *          @type string   'animation_classes'      class names for animation. 
         *                                                  Default: 'wow fadeInUp'
         *          @type string   'animation_delay'        Data attribute value for 
         *                                                  animation delay in seconds. 
         *                                                  Default: '0.3s'.
         *      )
         * @return void.
         */
        public static function post_content_columns( $col_args = array() ) {
            $args = wp_parse_args(
                $col_args,
                array(
                    'col_class'             =>  'col',
                    'col_class_additions'   =>  '',
                    'animation_classes'     =>  'wow fadeInUp',
                    'animation_delay'       =>  '0.3s'
                )
            );
            // column classes
            $col_additionals = array();
            if ( ! empty( $args['col_class_additions'] ) ) {
                $col_additionals[] = $args['col_class_additions'];
            }
            if ( ! empty( $args['animation_classes'] ) ) {
                $col_additionals[] = $args['animation_classes'];
            }
            // list classes for wrapper column
            $col_cls_list = WonKode_Helper::list_classes( $args['col_class'], $col_additionals );

            // ---NEEDS SANITIZATION AND VALIDATION----
            $col_data_attrs = ' data-wow-delay="' . $args['animation_delay'] . '"';
            // number of posts
            $num_of_posts = absint( get_theme_mod( self::$unique_prefix . '_num_of_front_selected_posts', self::$defaults['_num_of_front_selected_posts'] ) );
            // stores post ids
            $ids = array();
            // build the posts blocks
            for ( $i = 0; $i  < $num_of_posts; $i++ ) { 
                // get selected post id
                $selected_post = get_theme_mod( self::$unique_prefix . '_front_selected_post_' . $i, self::$defaults['_front_selected_post_default'] );
                $_post_id = $selected_post ? absint( $selected_post ) : null;
                if ( null !== $_post_id ) {
                    $ids[] = $_post_id;
                }
            }
            if ( ! empty( $ids ) ) {
                // prepare query args
                $qry_args = array(
                    'post_type'             =>  'post',
                    'post_status'           =>  'publish',
                    'post__in'              =>  $ids,
                    'order'                 =>  'DESC',
                    'orderby'               =>  'date',
                    'ignore_sticky_posts'   =>  true,
                );
                $query = new WP_Query( $qry_args );
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <div class="<?php echo esc_attr( $col_cls_list ); ?>"<?php echo $col_data_attrs; ?>>
                        <?php 
                            // show post card
                            self::show_image_overlay_post_card();
                        ?>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                }
            }
        }
        
    } // ENDS --- class
}
return new WonKode_Selected_Posts_Section_Templates;