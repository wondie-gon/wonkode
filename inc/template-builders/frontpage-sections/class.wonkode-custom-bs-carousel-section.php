<?php 
/**
 * Class for custom Bootstrap carousel section template builder
 * 
 * @package WonKode
 * @since 1.0
 */
// denying direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Custom_BS_Carousel_Section' ) ) {
    class WonKode_Custom_BS_Carousel_Section extends WonKode_Frontpage_Customize_Builder {
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
         * 
         * @since 1.0
         * 
         * @return void
         */
        public static function after_section_content() {
            echo self::get_front_section_closed();
        }

        /**
         * Renders opening html for Bootstrap carousel section. 
         * 
         * @since 1.0
         * 
         * @param string $carousel_id       Value for id attribute of carousel component.
         * @param string|array $new_classes List of class to add. Defaults: ''
         * 
         * @return void
         */
        public static function open_carousel_block( $carousel_id, $new_classes = '' ) {
            $carousel_classes_list = WonKode_Helper::list_classes( 'carousel slide', (array) $new_classes );
            ?>
            <div id="<?php echo esc_attr( $carousel_id ); ?>" class="<?php echo esc_attr( $carousel_classes_list ); ?>" data-bs-ride="carousel">
            <?php
        }

        /**
         * Renders closing html for Bootstrap carousel section. 
         * 
         * @since 1.0
         * 
         * @return void
         */
        public static function close_carousel_block() {
            ?></div><?php
        }

        /**
         * Returns Carousel indicators
         * 
         * @since 1.0
         * @param string $id id attribute for carousel
         * @param int $num Number of carousel items
         * 
         * @return html|mixed Indicators block for carousel
         */
        public static function carousel_indicators( $id, $num = 0 ) {
            $num = absint( $num );
            $html = '';
            if ( empty( $id ) || $num < 1 ) {
                return;
            }
            $html .= '<div class="carousel-indicators">';
            for ( $i = 0; $i < $num; $i++ ) { 
                $aria_label = 'Slide ' . $i + 1;
                $html .= '<button type="button" data-bs-target="#' . esc_attr( $id ) . '" data-bs-slide-to="' . $i . '"';
                $html .= $i === 0 ? ' class="active" aria-current="true"' : '';
                $html .= ' aria-label="' . esc_attr( $aria_label ) . '"></button>';
            }
            $html .= '</div>';
            // return indicators
            return $html;
        }

        /**
         * Renders opening html of carousel inner. 
         * 
         * @since 1.0
         * @param string|array $new_classes List of class to add. Defaults: ''
         * 
         * @return void
         */
        public static function open_carousel_inner( $new_classes = '' ) {
            // get inner carousel class list
            $inner_car_cls_list = WonKode_Helper::list_classes( 'carousel-inner', (array) $new_classes );
            ?>
            <div class="<?php echo esc_attr( $inner_car_cls_list ); ?>">
            <?php
        }

        /**
         * Renders carousel items.
         * 
         * @since 1.0
         * 
         * @return void
         */
        public static function render_carousel_items() {
            // number of sliders
            $num_of_slides = absint( get_theme_mod( self::$unique_prefix . '_number_of_custom_carousel_items', self::$defaults['_number_of_custom_carousel_items'] ) );
            // loop through carousel items
            for ( $i = 0; $i < $num_of_slides; $i++ ) { 
                // caption title
                $top_title = esc_html( get_theme_mod( self::$unique_prefix . '_custom_carousel_top_caption_title_' . $i, self::$defaults['_custom_carousel_top_caption_title_'] ) );
                $top_text = get_theme_mod( self::$unique_prefix . '_custom_carousel_top_caption_text_' . $i, self::$defaults['_custom_carousel_top_caption_text_'] );
                $bottom_title = get_theme_mod( self::$unique_prefix . '_custom_carousel_bottom_caption_title_' . $i, self::$defaults['_custom_carousel_bottom_caption_title_'] );
                $bottom_text = get_theme_mod( self::$unique_prefix . '_custom_carousel_bottom_caption_text_' . $i, self::$defaults['_custom_carousel_bottom_caption_text_'] );
                $link = get_theme_mod( self::$unique_prefix . '_custom_carousel_link_' . $i, self::$defaults['_custom_carousel_link_'] );
                $link_text = get_theme_mod( self::$unique_prefix . '_custom_carousel_link_text_' . $i, self::$defaults['_custom_carousel_link_text_'] );
                // get image id
                $image_id = absint( get_theme_mod( self::$unique_prefix . '_custom_carousel_image_' . $i ) );
                // carousel item class
                $car_item_class = ( $i === 0 ) ? 'carousel-item active' : 'carousel-item';
                ?>
                <div class="<?php echo esc_attr( $car_item_class ); ?>">
                <?php 
                    // displaying carousel image
                    if ( $image_id ) {
                        $custom_img_src = wp_get_attachment_url( $image_id );
                        // carousel custom image
                        echo sprintf( 
                            '<img src="%1$s" alt="%2$s" />', 
                            esc_url( $custom_img_src ), 
                            esc_attr( $top_title ) 
                        );
    
                    }
                ?>
                    <div class="container">
                        <div class="carousel-caption">
                          <div class="d-flex flex-column justify-content-between">
                            <div class="caption-top">
                                <h2 class="car-main-title">
                                    <?php echo sprintf( esc_html__( '%s', self::$txt_dom ), $top_title ); ?>
                                </h2>
                                <p class="car-main-text">
                                    <?php echo sprintf( esc_html__( '%s', self::$txt_dom ), $top_text ); ?>
                                </p>
                            </div>
                            <div class="caption-bottom">
                                <h5 class="car-sub-title">
                                    <?php echo sprintf( esc_html__( '%s', self::$txt_dom ), $bottom_title ); ?>
                                </h5>
                                <p class="small car-extra-text">
                                    <?php echo sprintf( esc_html__( '%s', self::$txt_dom ), $bottom_text ); ?>
                                </p>
                                <?php
                                    // display link
                                    echo sprintf( 
                                            '<a class="btn btn-outline-primary" href="%1$s">%2$s</a>',
                                            esc_url( $link ),
                                            sprintf( esc_html__( '%s', self::$txt_dom ), $link_text )
                                        );
                                ?>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        /**
         * Renders closing html of carousel inner. 
         * 
         * @since 1.0
         * 
         * @return void
         */
        public static function close_carousel_inner() {
            ?></div><?php
        }

        /**
         * Renders html of carousel control elements.
         * 
         * @since 1.0
         * @param string $carousel_id       Id of carousel component.
         *                                  Defaults: ''
         * 
         * @return void
         */
        public static function carousel_controls( $carousel_id = '' ) {
            // $id = ( ! empty( $carousel_id ) ) ? esc_attr( $carousel_id ) : self::$unique_prefix . 'BsCustomCar';
            $carousel_target = '#' . esc_attr( $carousel_id );
            ?>
            <button class="carousel-control-prev" type="button" data-bs-target="<?php echo $carousel_target; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><?php _e( 'Previous', self::$txt_dom ); ?></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="<?php echo $carousel_target; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><?php _e( 'Next', self::$txt_dom ); ?></span>
            </button>
            <?php
        }
    
    } // END -- of class
}