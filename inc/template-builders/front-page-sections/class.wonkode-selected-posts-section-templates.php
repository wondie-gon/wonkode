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
         * Renders selected posts section content 
         * when enabled and customized in theme 
         * customizer.
         * 
         * @since 1.0
         * @param array $class_additions  Array of additional classes 
         *              array(
         *                @type string 'title_block_class' additional classes for title block 
         *                @type string 'row_class' additional classes for row 
         *                @type string 'col_class' additional classes for post columns 
         *              )
         * @return mixed|html               
         */
        public static function show_section_content( $class_additions = array() ) {
            $classes = wp_parse_args( 
                $class_additions, 
                array(  
                    'title_block_class' =>  '',
                    'row_class' =>  '',
                    'col_class' =>  '',
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
            $row_classes = WonKode_Helper::list_classes( $row_cols_classes, $classes['col_class'] );
    
            // get section title
            $section_title = get_theme_mod( self::$unique_prefix . '_front_selected_posts_section_title', self::$defaults['_front_selected_posts_section_title'] );

            // render section title block
            self::selected_posts_section_title( $section_title, $classes['title_block_class'] );
            ?>
            <div class="<?php echo esc_attr( $row_classes ); ?>">
                <?php 
                    // post columns
                    self::selected_posts_blocks( $classes['col_class'] );
                ?>
            </div>
            <?php
        }
        /**
         * Renders selected posts section title
         * 
         * @since 1.0
         * @param string $section_title       Section title from theme cutomize
         * @param string $wrapper_classes     Additional classes for section title 
         *                                    wrapper, string separated by space.
         * @return html/mixed Section title html.
         */
        public static function selected_posts_section_title( $section_title, $wrapper_classes = '' ) {
            echo self::get_section_title_block( $section_title, $wrapper_classes );
        }

        /**
         * Renders selected posts block on 
         * front page from theme customize.
         * 
         * @since 1.0
         */
        public static function selected_posts_blocks( $col_classes = '' ) {
            // number of posts
            $num_of_posts = absint( get_theme_mod( self::$unique_prefix . '_num_of_front_selected_posts', self::$defaults['_num_of_front_selected_posts'] ) );
    
            // get column class
            $col_classes = WonKode_Helper::list_classes( 'col', $col_classes );
    
            // build the posts blocks
            for ( $i = 0; $i  < $num_of_posts; $i++ ) { 
                // get selected post id
                $selected_post = get_theme_mod( self::$unique_prefix . '_front_selected_post_' . $i, self::$defaults['_front_selected_post_default'] );
                $_post_id = $selected_post ? absint( $selected_post ) : null;
        
                if ( null !== $_post_id ) {
                    $_post_title = get_the_title( $_post_id );
                    $_post_link = get_permalink( $_post_id );
                    $_post_excerpt = get_the_excerpt( $_post_id );
                    ?>
                    <div id="selected-post-<?php echo $_post_id; ?>" class="<?php echo esc_attr( $col_classes ); ?>">
                        <div class="card">
                            <?php  
                            if ( has_post_thumbnail( $_post_id ) ) {
                                echo get_the_post_thumbnail( 
                                    $_post_id, 
                                    'medium', 
                                    array(
                                        'class' =>  'card-img-top',
                                        'alt'   =>  the_title_attribute( array( 'echo'  =>  false ) ),
                                    ) 
                                );  
                            }
                            ?>
                            <div class="card-body">
                            <?php
                                // card title
                                echo sprintf(
                                    '<h2 class="card-title"><a href="%1$s">%2$s</a></h2>',
                                    esc_url( $_post_link ),
                                    esc_html( $_post_title )
                                );
                                // the excerpt
                                echo sprintf(
                                    wp_kses(
                                        __( '<p class="card-text">%s</p>', self::$txt_dom ),
                                        array(
                                            'p' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    wp_kses_post( $_post_excerpt )
                                );
                                // the btn link
                                echo sprintf(
                                    '<a class="btn-main-dark" href="%1$s">%2$s<i class="fa fa-arrow-right"></i></a>',
                                    esc_url( $_post_link ),
                                    __( 'View More ', self::$txt_dom )
                                );
                            ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    } // ENDS --- class
}
return new WonKode_Selected_Posts_Section_Templates;