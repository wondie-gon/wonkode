<?php
/**
 * Class for footer page links nav custom widget
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'WonKode_Footer_Page_Links' ) ) {
    class WonKode_Footer_Page_Links extends WP_Widget {
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
                'classname'     =>  $this->theme_id . '-footer-page-links',
                'description'   =>  __( 'Widget to display page links menu', $this->theme_id )
            );
            parent::__construct(
                // Base id
                $this->theme_id . '-footer-page-links-widget',
                // Name that appears on admin widget screen
                $this->theme_name . ' Footer Page Links',
                $widget_ops
            );
            /**
             * Register the widget using anonymous function, 
             * and hook to 'widgets_init' core action
             */
            add_action( 'widgets_init', function() {
                register_widget( 'WonKode_Footer_Page_Links' );
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
         *      @type mixed 'before_title'     Html before the titlef
         *      @type mixed 'after_title'      Html after the title
         *      @type mixed 'before_widget'    Html before the widget
         *      @type mixed 'after_widget'     Html after the widget
         * }
         * @param array $instance The settings for the particular instance of the widget.
         */
        public function widget( $args, $instance ) {
            // display before widget
            echo $args['before_widget'];
            /**
             * Filters widget title  and echoes 
             * whole title element
             * 
             * @param string $instance['title']     Title field instance value
             */
            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }
            // get array of id integers
            $pg_ids = array_map( 'absint', (array) $instance['include_pages'] );
            // get pages
            $pgs = get_pages(
                array(
                    'child_of'      =>  0,
                    'include'       =>  $pg_ids,
                    'sort_order'    =>  'DESC',
                    'sort_column'   =>  'menu_order',
                    'post_status'   =>  'publish'
                )
            );

            if ( $pgs ) {
                // display nav list
                echo '<ul class="nav flex-column">';
                // display link lists
                foreach ( $pgs as $pg ) {
                    echo sprintf( 
                        '<li class="nav-item mb-2"><a href="%1$s" class="nav-link p-0">%2$s</a></li>',
                        esc_url( get_page_link( $pg->ID ) ), 
                        sprintf(
                            esc_html__( '%s', $this->theme_id ),
                            $pg->post_title
                        )
                    );
                }
                echo '</ul>';
            }

            // after widget
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
            $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Sitemap', $this->theme_id );
            $include_pages = ! empty( $instance['include_pages'] ) ? $instance['include_pages'] : [];
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
                    <?php 
                        $_pages = get_pages();
                        ?>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'include_pages' ) ); ?>">
                            <?php esc_html_e( 'Include pages: ', $this->theme_id ); ?>
                        </label>
                        <?php
                        foreach ( $_pages as $_pg ) { 
                            ?>
                            <span style="margin-right: 32px;">
                                <input 
                                    type="checkbox" 
                                    name="<?php echo esc_attr( $this->get_field_name( 'include_pages' ) ); ?>[]" 
                                    id="<?php echo esc_attr( $this->get_field_id( 'include_pages' ) . $_pg->ID ); ?>" 
                                    value="<?php echo $_pg->ID; ?>" 
                                    class="widefat" 
                                    <?php checked( "1", in_array( $_pg->ID, $instance['include_pages'] ) ); ?> 
                                />
                                <label for="<?php echo esc_attr( $this->get_field_id( 'include_pages' ) . $_pg->ID ); ?>">
                                <?php echo sprintf( esc_html__( '%s', $this->theme_id ), $_pg->post_title ); ?></label>
                            </span>
                    <?php } ?>
                    <span class="description" style="display: block; font-size:small; font-style:italic;"><?php _e( 'Check pages to include in links menu.', $this->theme_id ); ?></span>
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
            $instance['include_pages'] = ! empty( $new_instance['include_pages'] ) ? array_map( 'absint', $new_instance['include_pages'] ) : [];
            return $instance;
        }

    } // END -- class
}
// initialize widget
new WonKode_Footer_Page_Links();