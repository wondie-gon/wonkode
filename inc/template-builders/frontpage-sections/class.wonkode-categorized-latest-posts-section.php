<?php 
/**
 * Class for custom frontpage templates 
 * of categorized latest posts section
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if ( ! class_exists( 'WonKode_Categorized_Latest_Posts_Section' ) ) {
    class WonKode_Categorized_Latest_Posts_Section extends WonKode_Frontpage_Customize_Builder {
        /**
         * Class constructor
         */
        public function __construct() {
            // constructor of parent class
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
         * Renders section title
         * 
         * @since 1.0
         * 
         * @return void
         */
        public static function section_title_block() {
            // get section title
            $section_title = get_theme_mod( self::$unique_prefix . '_front_categorized_latest_posts_section_title', self::$defaults['_front_categorized_latest_posts_section_title'] );

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

            // get selected category
            $cat_id = absint( get_theme_mod( self::$unique_prefix . '_front_categorized_latest_posts_category', self::$defaults['_front_categorized_latest_posts_category'] ) );
            // number of posts
            $posts_num = absint( get_theme_mod( self::$unique_prefix . '_num_of_front_categorized_latest_posts', self::$defaults['_num_of_front_categorized_latest_posts'] ) );

            // prepare query args
            $qry_args = array(
                'post_type'         =>  'post',
                'post_status'       =>  'publish',
                'cat'               =>  (int) $cat_id,
                'posts_per_page'    =>  (int) $posts_num,
                'order'             =>  'DESC',
                'orderby'           =>  'date',
            );
            $query = new WP_Query( $qry_args );
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    ?>
                    <div class="<?php echo esc_attr( $col_cls_list ); ?>"<?php echo $col_data_attrs; ?>>
                    <?php 
                        // show post card
                        self::show_left_image_post_card();
                    ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
        }

    } // END --- class
}
// return class
return new WonKode_Categorized_Latest_Posts_Section();