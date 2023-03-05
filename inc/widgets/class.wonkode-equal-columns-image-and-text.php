<?php
/**
 * Two equal columns image and text cutom widget
 * 
 * @package WonKode
 * @since 1.0
 */
// restrict direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Image_And_Text_Equal_Columns' ) ) {
    class WonKode_Equal_Columns_Image_And_Text extends WP_Widget {
        /**
         * Theme identity to be
         * used as unique prefix, and text domain
         * 
         * @since 1.0
         * @var string
         */
        public $theme_id;

        /**
         * Theme name to be used for naming widget
         * 
         * @since 1.0
         * @var string
         */
        public $theme_name;
        /**
         * Class constructor
         */
        public function __construct() {
            // setting theme identity
            $theme_obj = wp_get_theme();
            $this->theme_id = $theme_obj->get( 'TextDomain' );
            $this->theme_name = $theme_obj->get( 'Name' );
            // options for widget
            $widget_ops = array(
                'classname'     =>  $this->theme_id . '-equal-image-text',
                'description'   =>  __( 'Widget to display equal columns image and text', $this->theme_id )
            );
            parent::__construct(
                // Base id
                $this->theme_id . '-equal-cols-image-text',
                // Name that appears on admin widget screen
                $this->theme_name . ' Equal Image and Text',
                $widget_ops
            );

            /**
             * Register the widget using anonymous function, 
             * and hook to 'widgets_init' core action
             */
            add_action( 'widgets_init', function() {
                register_widget( 'WonKode_Equal_Columns_Image_And_Text' );
            } );
        }
        /**
         * Echoes the widget content.
         * Process the widget options and display 
         * the HTML on your page.
         * 
         * Subclasses should override this function to generate their widget code.
         * 
         * @since 2.8.0
         * @param array $args {
         *  Arguments to display widgets
         *      @type mixed 'before_title'     Html before the title
         *      @type mixed 'after_title'      Html after the title
         *      @type mixed 'before_widget'    Html before the widget
         *      @type mixed 'after_widget'     Html after the widget
         * }
         * @param array $instance The settings for the particular instance of the widget.
         */
        public function widget( $args, $instance ) {
            // get title classes
            $title_classes = ( ! empty( $instance['title_animation'] ) && 'none' !== $instance['title_animation'] ) ? WonKode_Helper::list_classes( $instance['title_animation'], (array) 'widget-title display-4 mb-3 animated' ) : WonKode_Helper::list_classes( 'widget-title display-4 mb-3 animated' );
            
            // before_title is empty
            $args['before_title'] = ! empty( $args['before_title'] ) ? $args['before_title'] : '<h1 class="' . esc_attr( $title_classes ) . '">';
            $args['after_title'] = ! empty( $args['after_title'] ) ? $args['after_title'] : '</h1>';

            // prepare classes
            $text_classes = ( ! empty( $instance['text_animation'] ) && 'none' !== $instance['text_animation'] ) ? WonKode_Helper::list_classes( $instance['text_animation'], (array) 'lead animated' ) : WonKode_Helper::list_classes( 'lead' );

            $btn_classes = ( ! empty( $instance['btn_animation'] ) && 'none' !== $instance['btn_animation'] ) ? WonKode_Helper::list_classes( $instance['btn_animation'], (array) 'btn btn-primary py-3 px-4 animated' ) : WonKode_Helper::list_classes( 'btn btn-primary py-3 px-4' );

            $img_wrapper_classes = ( ! empty( $instance['img_wrapper_animation'] ) && 'none' !== $instance['img_wrapper_animation'] ) ? WonKode_Helper::list_classes( $instance['img_wrapper_animation'], (array) 'col-lg-6 animated' ) : WonKode_Helper::list_classes( 'col-lg-6' );

            // image classes
            $img_classes = WonKode_Helper::list_classes( 'img-fluid' );
            // style for image animation duration
            $style_anim_duration = '';
            // add animation classes
            if ( ! empty( $instance['img_animation'] ) && 'none' !== $instance['img_animation'] ) {
                $img_classes = WonKode_Helper::list_classes( $img_classes . ' animated', (array) $instance['img_animation'] );
                // animation iteration
                if ( 'infinite' === $instance['img_anim_iteration'] ) {
                    $img_classes = WonKode_Helper::list_classes( 'infinite', (array) $img_classes );
                }
                // add animation duration
                $style_anim_duration .= $instance['img_anim_duration'] ? ' style="animation-duration: ' . esc_attr( $instance['img_anim_duration'] ) . 's;"' : ' style="animation-duration: 3s;"';
            }
            // start displaying widget
            echo $args['before_widget'];
            echo '<div class="col-lg-6">' . "\n";
            /**
             * Filters widget title  and echoes 
             * whole title element
             * 
             * @param string $instance['title']     Title field instance value
             */
            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }
            // displaying text paragraph
            echo '<p class="' . esc_attr( $text_classes ) . '">';
            echo esc_html__( $instance['text'], $this->theme_id );
            echo '</p>' . "\n";
            // displaying link button
            if ( $instance['display_btn'] ) {
                echo '<a href="' . esc_url( $instance['link_to'], $this->theme_id ) . '" class="' . esc_attr( $btn_classes ) . '">';
                echo esc_html__( $instance['btn_text'], $this->theme_id );
                echo '</a>' . "\n";
            }
            echo '</div>' . "\n";
            echo '<div class="' . esc_attr( $img_wrapper_classes ) . '">' . "\n";
            echo '<img class="' . esc_attr( $img_classes ) . '"' . $style_anim_duration . ' src="' . esc_url( $instance['img_src'] ) . '" alt="' . esc_html__( $instance['title'], $this->theme_id ) . '">';
            echo '</div>' . "\n";
            echo $args['after_widget'];

        }
        /**
         * Outputs the settings update form in the admin 
         * widget screen
         * 
         * @since 2.8.0
         * @param array $instance Current settings.
         * @return string Default return is 'noform'.
         */
        public function form( $instance ) {

            $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Equal Columns Widget Title', $this->theme_id );
            $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( 'Equal columns with image text', $this->theme_id );
            $display_btn = isset( $instance['display_btn'] ) && $instance['display_btn'] ? true : false;
            $link_to = ! empty( $instance['link_to'] ) ? $instance['link_to'] : '';
            $btn_text = ! empty( $instance['btn_text'] ) ? $instance['btn_text'] : esc_html__( 'Explore More', $this->theme_id );
            $img_src = ! empty( $instance['img_src'] ) ? $instance['img_src'] : '';

            // animation settings
            $title_animation = isset( $instance['title_animation'] ) && $instance['title_animation'] ? $instance['title_animation'] : '';

            $text_animation = isset( $instance['text_animation'] ) && $instance['text_animation'] ? $instance['text_animation'] : '';

            $btn_animation = isset( $instance['btn_animation'] ) && $instance['btn_animation'] ? $instance['btn_animation'] : '';
            $img_wrapper_animation = isset( $instance['img_wrapper_animation'] ) && $instance['img_wrapper_animation'] ? $instance['img_wrapper_animation'] : '';
            $img_animation = ! empty( $instance['img_animation'] ) ? $instance['img_animation'] : '';
            $img_anim_iteration = ! empty( $instance['img_anim_iteration'] ) ? $instance['img_anim_iteration'] : 'default';
            $img_anim_duration = $instance['img_anim_duration'] ? $instance['img_anim_duration'] : 2;

            // check html5 supported
            $is_html5 = current_theme_supports( 'html5' );
            // Define checked attribute in HTML5 or XHTML syntax.
            $checked_attr  = ( $is_html5 ? ' checked' : ' checked="checked"' );
            ?>
            <div class="widget-content">
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
                        value="<?php echo esc_attr( $title ); ?>" 
                        class="widefat" 
                        placeholder="<?php esc_html_e( 'Enter title', $this->theme_id ); ?>"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ) ?>"><?php esc_attr_e( 'Text: ', $this->theme_id ); ?></label>
                    <textarea 
                        id="<?php echo esc_attr( $this->get_field_id( 'text' ) ) ?>" 
                        name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" 
                        class="widefat" 
                        cols="20" 
                        rows="6" 
                        autocomplete="off" 
                        maxlength="300" 
                        placeholder="<?php esc_attr_e( 'Enter text to diplay on text column', $this->theme_id ); ?>"><?php echo wp_strip_all_tags( $text ); ?></textarea>
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'display_btn' ) ); ?>">
                        <?php esc_attr_e( 'Display link button', $this->theme_id ); ?>
                        <input 
                            type="checkbox" 
                            name="<?php echo esc_attr( $this->get_field_name( 'display_btn' ) ); ?>" 
                            id="<?php echo esc_attr( $this->get_field_id( 'display_btn' ) ); ?>" 
                            value="true"  
                            <?php checked( $display_btn, true, true ); ?> 
                        />
                    </label>
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'link_to' ) ); ?>"><?php esc_attr_e( 'Link to: ', $this->theme_id ); ?></label>
                    <input 
                        type="url" 
                        name="<?php echo esc_attr( $this->get_field_name( 'link_to' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'link_to' ) ); ?>" 
                        class="widefat" 
                        value="<?php echo esc_url( $link_to ); ?>" 
                        placeholder="<?php echo esc_url( home_url( '/' ) . 'example-post/' ); ?>" 
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'btn_text' ) ); ?>"><?php esc_attr_e( 'Button text: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'btn_text' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'btn_text' ) ); ?>" 
                        value="<?php echo esc_attr( $btn_text ); ?>" 
                        class="widefat" 
                        placeholder="<?php esc_html_e( 'Button text', $this->theme_id ); ?>"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'img_src' ) ); ?>"><?php esc_attr_e( 'Image URL:', $this->theme_id ); ?></label>
                    <input 
                        type="url" 
                        id="<?php echo esc_attr( $this->get_field_id( 'img_src' ) ); ?>" 
                        name="<?php echo esc_attr( $this->get_field_name( 'img_src' ) ); ?>" 
                        value="<?php echo esc_attr( $img_src ); ?>" 
                        class="widefat"
                    />
                </p>

                <h3><?php esc_attr_e( 'Set animations for different elements of this widget.', $this->theme_id ); ?></h3>

                <p class="description"><?php esc_attr_e( 'When you choose animation for each element, classes will be added to respective elements.', $this->theme_id ); ?></p>

                <p><?php esc_attr_e( 'Title animation:', $this->theme_id ); ?></p>
                <?php 
                    $title_animations = array( 'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp', 'none' );
                ?>
                <p>
                <?php
                    foreach ( $title_animations as $anim ) {
                    ?>
                        <span style="margin-right: 16px;">
                            <input 
                                type="radio" 
                                id="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>" 
                                name="<?php echo esc_attr( $this->get_field_name( 'title_animation' ) ); ?>" 
                                value="<?php echo esc_attr( $anim ); ?>" 
                                <?php echo ( strtolower( $title_animation ) === strtolower( $anim ) ) ? $checked_attr : ''; ?>
                            />
                            <label for="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>"><?php echo $anim; ?></label>
                        </span>
                    <?php
                    }
                ?>
                </p>

                <p><?php esc_attr_e( 'Main Text animation:', $this->theme_id ); ?></p>
                <?php 
                    $text_animations = array( 'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp', 'none' );
                ?>
                <p>
                <?php
                    foreach ( $text_animations as $anim ) {
                    ?>
                        <span style="margin-right: 16px;">
                            <input 
                                type="radio" 
                                id="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>" 
                                name="<?php echo esc_attr( $this->get_field_name( 'text_animation' ) ); ?>" 
                                value="<?php echo esc_attr( $anim ); ?>" 
                                <?php echo ( strtolower( $text_animation ) === strtolower( $anim ) ) ? $checked_attr : ''; ?>
                            />
                            <label for="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>"><?php echo $anim; ?></label>
                        </span>
                    <?php
                    }
                ?>
                </p>

                <p><?php esc_attr_e( 'Button animation:', $this->theme_id ); ?></p>
                <?php 
                    $btn_animations = array( 'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp', 'none' );
                ?>
                <p>
                <?php
                    foreach ( $btn_animations as $anim ) {
                    ?>
                        <span style="margin-right: 16px;">
                            <input 
                                type="radio" 
                                id="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>" 
                                name="<?php echo esc_attr( $this->get_field_name( 'btn_animation' ) ); ?>" 
                                value="<?php echo esc_attr( $anim ); ?>" 
                                <?php echo ( strtolower( $btn_animation ) === strtolower( $anim ) ) ? $checked_attr : ''; ?>
                            />
                            <label for="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>"><?php echo $anim; ?></label>
                        </span>
                    <?php
                    }
                ?>
                </p>

                <p><?php esc_attr_e( 'Image wrapper animation:', $this->theme_id ); ?></p>
                <?php 
                    $img_wrapper_animations = array( 'fadeIn', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUp', 'fadeOut', 'none' );
                ?>
                <p>
                <?php
                    foreach ( $img_wrapper_animations as $anim ) {
                    ?>
                        <span style="margin-right: 16px;">
                            <input 
                                type="radio" 
                                id="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>" 
                                name="<?php echo esc_attr( $this->get_field_name( 'img_wrapper_animation' ) ); ?>" 
                                value="<?php echo esc_attr( $anim ); ?>" 
                                <?php echo ( strtolower( $img_wrapper_animation ) === strtolower( $anim ) ) ? $checked_attr : ''; ?>
                            />
                            <label for="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>"><?php echo $anim; ?></label>
                        </span>
                    <?php
                    }
                ?>
                </p>

                <p><?php esc_attr_e( 'Image animation:', $this->theme_id ); ?></p>
                <?php 
                    $img_animations = array( 'pulse', 'bounce', 'shake', 'wobble', 'none' );
                ?>
                <p>
                <?php
                    foreach ( $img_animations as $anim ) {
                    ?>
                        <span style="margin-right: 16px;">
                            <input 
                                type="radio" 
                                id="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>" 
                                name="<?php echo esc_attr( $this->get_field_name( 'img_animation' ) ); ?>" 
                                value="<?php echo esc_attr( $anim ); ?>" 
                                <?php echo ( strtolower( $img_animation ) === strtolower( $anim ) ) ? $checked_attr : ''; ?>
                            />
                            <label for="<?php echo esc_attr( $this->get_field_id( $anim ) ); ?>"><?php echo $anim; ?></label>
                        </span>
                    <?php
                    }
                ?>
                </p>

                <p><?php esc_attr_e( 'Image animation iteration:', $this->theme_id ); ?></p>
                <?php 
                    $img_anim_iterations = array( 'infinite', 'default' );
                ?>
                <p>
                <?php
                    foreach ( $img_anim_iterations as $iteration ) {
                    ?>
                        <span style="margin-right: 16px;">
                            <input 
                                type="radio" 
                                id="<?php echo esc_attr( $this->get_field_id( $iteration ) ); ?>" 
                                name="<?php echo esc_attr( $this->get_field_name( 'img_anim_iteration' ) ); ?>" 
                                value="<?php echo esc_attr( $iteration ); ?>" 
                                <?php echo ( strtolower( $img_anim_iteration ) === strtolower( $iteration ) ) ? $checked_attr : ''; ?>
                            />
                            <label for="<?php echo esc_attr( $this->get_field_id( $iteration ) ); ?>"><?php echo $iteration; ?></label>
                        </span>
                    <?php
                    }
                ?>
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'img_anim_duration' ) ); ?>"><?php esc_attr_e( 'Image animation duration: ', $this->theme_id ); ?></label>
                    <input 
                        type="number" 
                        name="<?php echo esc_attr( $this->get_field_name( 'img_anim_duration' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'img_anim_duration' ) ); ?>" 
                        value="<?php echo esc_attr( $img_anim_duration ); ?>" 
                        class="widefat" 
                        min="1" 
                        max="10"
                    />
                </p>

            </div>
            <?php
        }
        /**
         * Updates a particular instance of a widget.
         * This function should check that `$new_instance` is set correctly. 
         * The newly-calculated value of `$instance` should be returned. 
         * If false is returned, the instance won't be saved/updated.
         * 
         * @since 2.8.0
         * @param array $new_instance   New settings for this instance as 
         *                              input by the user via WP_Widget::form().
         * @param array $old_instance   Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['text'] = ! empty( $new_instance['text'] ) ? sanitize_textarea_field( $new_instance['text'] ) : '';
            $instance['display_btn'] = isset( $new_instance['display_btn'] ) && $new_instance['display_btn'] ? boolval( $new_instance['display_btn'] ) : false;
            $instance['link_to'] = ! empty( $new_instance['link_to'] ) ? esc_url_raw( $new_instance['link_to'] ) : '';
            $instance['btn_text'] = ! empty( $new_instance['btn_text'] ) ? sanitize_text_field( $new_instance['btn_text'] ) : '';
            $instance['img_src'] = ! empty( $new_instance['img_src'] ) ? esc_url_raw( $new_instance['img_src'] ) : '';

            $instance['title_animation'] = isset( $new_instance['title_animation'] ) && ! empty( $new_instance['title_animation'] ) ? sanitize_key( $new_instance['title_animation'] ) : false;
            $instance['text_animation'] = isset( $new_instance['text_animation'] ) && ! empty( $new_instance['text_animation'] ) ? sanitize_key( $new_instance['text_animation'] ) : '';

            $instance['btn_animation'] = isset( $new_instance['btn_animation'] ) && ! empty( $new_instance['btn_animation'] ) ? sanitize_key( $new_instance['btn_animation'] ) : '';

            $instance['img_wrapper_animation'] = isset( $new_instance['img_wrapper_animation'] ) && ! empty( $new_instance['img_wrapper_animation'] ) ? sanitize_key( $new_instance['img_wrapper_animation'] ) : '';

            $instance['img_animation'] = isset( $new_instance['img_animation'] ) && ! empty( $new_instance['img_animation'] ) ? sanitize_key( $new_instance['img_animation'] ) : '';

            $instance['img_anim_iteration'] = ! empty( $new_instance['img_anim_iteration'] ) ? sanitize_key( $new_instance['img_anim_iteration'] ) : 'default';

            $instance['img_anim_duration'] = $new_instance['img_anim_duration'] ? absint( $new_instance['img_anim_duration'] ) : 2;

            return $instance;
        }
    } // ENDS --- class
}
$wonkode_equal_columns_image_and_text_widget = new WonKode_Equal_Columns_Image_And_Text();