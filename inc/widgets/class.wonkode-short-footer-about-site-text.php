<?php
/**
 * Class a small brief about site custom widget
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Short_Footer_About_Site_Text' ) ) {
    class WonKode_Short_Footer_About_Site_Text extends WP_Widget {
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
         * Class construct
         * 
         * @since 1.0
         */
        public function __construct() {
            // setting theme identity
            $theme_obj = wp_get_theme();
            $this->theme_id = $theme_obj->get( 'TextDomain' );
            $this->theme_name = $theme_obj->get( 'Name' );
            // options for widget
            $widget_ops = array(
                'classname'     =>  $this->theme_id . '-footer-about-site-text',
                'description'   =>  __( 'Widget to display very brief text about site in footer area.', $this->theme_id )
            );
            parent::__construct(
                // Base id
                $this->theme_id . '-footer-about-site-text-widget',
                $this->theme_name . ' Footer About Site',
                $widget_ops
            );
            /**
             * Register the widget using anonymous function, 
             * and hook to 'widgets_init' core action
             */
            add_action( 'widgets_init', function() {
                register_widget( 'WonKode_Short_Footer_About_Site_Text' );
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
            // display before widget
            echo $args['before_widget'];
            // display logo instead of title
            if ( $instance['display_logo_instead'] ) {
                wonkode_footer_custom_logo();
            } else {
                /**
                 * Filters widget title  and echoes 
                 * whole title element
                 * 
                 * @param string $instance['title']     Title field instance value
                 */
                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                } else {
                    echo $args['before_title'] . apply_filters( 'widget_title', esc_html( get_bloginfo( 'name' ) ) ) . $args['after_title'];
                }
            }
            // diplay short description of site
            if ( ! empty( $instance['about_site_description'] ) ) {
                echo '<p>';
                echo sprintf( esc_html__( '%s', $this->theme_id ), $instance['about_site_description'] );
                echo '</p>';
            }
            
            // display after widget
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
            $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $display_logo_instead = isset( $instance['display_logo_instead'] ) && $instance['display_logo_instead'] ? true : false;
            $about_site_description = ! empty( $instance['about_site_description'] ) ? $instance['about_site_description'] : esc_html__( 'Enter very brief description of your site.', $this->theme_id );
            ?>
            <div class="widget-content">
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title: ', $this->theme_id ); ?></label>
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
                    <label for="<?php echo esc_attr( $this->get_field_id( 'display_logo_instead' ) ); ?>">
                        <?php esc_attr_e( 'Display logo instead of title', $this->theme_id ); ?>
                        <input 
                            type="checkbox" 
                            name="<?php echo esc_attr( $this->get_field_name( 'display_logo_instead' ) ); ?>" 
                            id="<?php echo esc_attr( $this->get_field_id( 'display_logo_instead' ) ); ?>" 
                            value="true"  
                            <?php checked( $display_logo_instead, true, true ); ?> 
                        />
                    </label>
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'about_site_description' ) ) ?>"><?php esc_attr_e( 'Site Description: ', $this->theme_id ); ?></label>
                    <textarea 
                        id="<?php echo esc_attr( $this->get_field_id( 'about_site_description' ) ) ?>" 
                        name="<?php echo esc_attr( $this->get_field_name( 'about_site_description' ) ); ?>" 
                        class="widefat" 
                        cols="20" 
                        rows="6" 
                        autocomplete="off" 
                        maxlength="300" 
                        placeholder="<?php esc_attr_e( 'Enter text here', $this->theme_id ); ?>"><?php echo wp_strip_all_tags( $about_site_description ); ?></textarea>
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
            $instance['display_logo_instead'] = isset( $new_instance['display_logo_instead'] ) && $new_instance['display_logo_instead'] ? boolval( $new_instance['display_logo_instead'] ) : false;
            $instance['about_site_description'] = ! empty( $new_instance['about_site_description'] ) ? sanitize_textarea_field( $new_instance['about_site_description'] ) : '';
            return $instance;
        }


    } // ENDS -- class
}
// initialize widget
new WonKode_Short_Footer_About_Site_Text();