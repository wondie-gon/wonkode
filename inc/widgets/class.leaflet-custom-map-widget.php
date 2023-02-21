<?php
/**
 * Widget for displaying LeafletJS custom map
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'Leaflet_Custom_Map_Widget' ) ) {
    class Leaflet_Custom_Map_Widget extends WP_Widget {
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
                'classname'     =>  $this->theme_id . '-leaflet-map',
                'description'   =>  __( 'Widget to display business locations map', $this->theme_id )
            );
            parent::__construct(
                // Base id
                $this->theme_id . '-leaflet-map-widget',
                // Widget name
                $this->theme_name . ' Business Locations Map',
                $widget_ops
            );
            // hook actions
            add_action( 'widgets_init', array( $this, 'init' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'widget_styles' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'widget_scripts' ) );
        }
        /**
         * Action callback to register custom map widget area 
         * to display business location powered by 
         * LeafletJS and OpenStreetMap.
         * --and--
         * Action callback to initializes widget
         * 
         * Uses: 'widgets_init'
         * @since 1.0
         */
        public function init() {
            $prefix = str_replace( '-', '_', $this->theme_id );
            register_sidebar( 
                apply_filters(
                    $prefix . '_business_locations_map_widgetarea',
                    array(
                        'name'              =>  __( 'Business Locations Map Widget Area', $this->theme_id ),
                        'id'                =>  $this->theme_id . '-leaflet-openstreetmap',
                        'description'       =>  __( 'Add Business Locations Map widget here to display custom map powered by LeafletJS and OpenStreetMap', $this->theme_id ),
                        'before_widget'     =>  '<div id="%1$s" class="col-12 mb-4 locations-section-inner widget %2$s">',
                        'after_widget'      =>  '</div>',
                        'before_title'      =>  '<h1 class="locations-section-title locations-widget-title">',
                        'after_title'       =>  '</h1>',
                    )
                )
            );
            // register widget
            register_widget( 'Leaflet_Custom_Map_Widget' );
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
            /**
             * Filters widget title  and echoes 
             * whole title element
             * 
             * @param string $instance['title']     Title field instance value
             */
            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }
            ?>
            <div id="<?php echo esc_attr( $instance['map_container_id'] ); ?>" class="leaflet-map"></div>
            <?php
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
            $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Come and stop by', $this->theme_id );
            $map_container_id = ! empty( $instance['map_container_id'] ) ? $instance['map_container_id'] : esc_attr( $this->theme_id . '_map' );
            $loc_lat = ! empty( $instance['loc_lat'] ) ? (float) $instance['loc_lat'] : '';
            $loc_long = ! empty( $instance['loc_long'] ) ? (float) $instance['loc_long'] : '';
            $zoom_level = ! empty( $instance['zoom_level'] ) ? $instance['zoom_level'] : '12';
            $tile_max_zoom = ! empty( $instance['tile_max_zoom'] ) ? $instance['tile_max_zoom'] : '18';

            $specific_name = ! empty( $instance['specific_name'] ) ? $instance['specific_name'] : esc_html__( 'Location Name', $this->theme_id );

            $full_address = ! empty( $instance['full_address'] ) ? $instance['full_address'] : '';

            $phone_num = ! empty( $instance['phone_num'] ) ? $instance['phone_num'] : '';
            ?>
            <div class="widget-content">
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Map Section Title: ', $this->theme_id ); ?></label>
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
                    <label for="<?php echo esc_attr( $this->get_field_id( 'map_container_id' ) ); ?>"><?php esc_html_e( 'Map Container ID: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'map_container_id' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'map_container_id' ) ); ?>" 
                        value="<?php echo esc_attr( $map_container_id ); ?>" 
                        class="widefat" 
                        placeholder="mapContainerId"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'loc_lat' ) ); ?>"><?php esc_html_e( 'View Center Latitude: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'loc_lat' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'loc_lat' ) ); ?>" 
                        value="<?php echo $loc_lat; ?>" 
                        class="widefat" 
                        placeholder="48.865938564750046"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'loc_long' ) ); ?>"><?php esc_html_e( 'View Center Longitude: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'loc_long' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'loc_long' ) ); ?>" 
                        value="<?php echo $loc_long; ?>" 
                        class="widefat" 
                        placeholder="2.319205591760637"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'zoom_level' ) ); ?>"><?php esc_html_e( 'Map View Zoom Level: ', $this->theme_id ); ?></label>
                    <input 
                        type="range" 
                        min="1" 
                        max="22" 
                        step="1" 
                        name="<?php echo esc_attr( $this->get_field_name( 'zoom_level' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'zoom_level' ) ); ?>" 
                        value="<?php echo $zoom_level; ?>" 
                        class="widefat" 
                    />
                    <span class="description"><?php _e( 'Zoom level map view will be set.', $this->theme_id ); ?></span>
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'tile_max_zoom' ) ); ?>"><?php esc_html_e( 'TileLayer Maximum Zoom Level: ', $this->theme_id ); ?></label>
                    <input 
                        type="range" 
                        min="0" 
                        max="18" 
                        step="1" 
                        name="<?php echo esc_attr( $this->get_field_name( 'tile_max_zoom' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'tile_max_zoom' ) ); ?>" 
                        value="<?php echo $tile_max_zoom; ?>" 
                        class="widefat" 
                    />
                    <span class="description"><?php _e( 'The maximum zoom level up to which tile layer will be displayed', $this->theme_id ); ?></span>
                </p>

                <!-- Additional widget customization fields with repeater -->
                <h4 class="widget-sub-title"><?php esc_html_e( 'Add markers and popup contents', $this->theme_id ); ?></h4>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'specific_name' ) ); ?>"><?php esc_html_e( 'Location Specific Name: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'specific_name' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'specific_name' ) ); ?>" 
                        class="widefat" 
                        value="<?php echo $specific_name; ?>" 
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'full_address' ) ); ?>"><?php esc_html_e( 'Full Address: ', $this->theme_id ); ?></label>
                    <input 
                        type="text" 
                        name="<?php echo esc_attr( $this->get_field_name( 'full_address' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'full_address' ) ); ?>" 
                        class="widefat" 
                        value="<?php echo $full_address; ?>" 
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'phone_num' ) ); ?>"><?php esc_html_e( 'Phone Number: ', $this->theme_id ); ?></label>
                    <input 
                        type="tel" 
                        name="<?php echo esc_attr( $this->get_field_name( 'phone_num' ) ); ?>" 
                        id="<?php echo esc_attr( $this->get_field_id( 'phone_num' ) ); ?>" 
                        class="widefat" 
                        value="<?php echo $phone_num; ?>" 
                        placeholder="123-45-6789" 
                        pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" 
                    />
                    <span class="description"><small><?php esc_html_e( 'Use format: 123-45-6789', $this->theme_id ); ?></small></span>
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
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['map_container_id'] = ( ! empty( $new_instance['map_container_id'] ) ) ? esc_attr( $new_instance['map_container_id'] ) : esc_attr( $this->theme_id . '_map' );
            $instance['loc_lat'] = ( ! empty( $new_instance['loc_lat'] ) && is_numeric( $new_instance['loc_lat'] ) ) ? (float) $new_instance['loc_lat'] : '';
            $instance['loc_long'] = ( ! empty( $new_instance['loc_long'] ) && is_numeric( $new_instance['loc_long'] ) ) ? (float) $new_instance['loc_long'] : '';
            $instance['zoom_level'] = ( ! empty( $new_instance['zoom_level'] ) && ( absint( $new_instance['zoom_level'] ) >= 1 && absint( $new_instance['zoom_level'] ) <= 22 ) ) ? absint( $new_instance['zoom_level'] ) : '12';

            $instance['tile_max_zoom'] = ( ! empty( $new_instance['tile_max_zoom'] ) && ( absint( $new_instance['tile_max_zoom'] ) > 0 && absint( $new_instance['tile_max_zoom'] ) < 18 ) ) ? absint( $new_instance['tile_max_zoom'] ) : '18';

            $instance['specific_name'] = ( ! empty( $new_instance['specific_name'] ) ) ? sanitize_text_field( $new_instance['specific_name'] ) : esc_html__( 'Enter Name of Location', $this->theme_id );
            $instance['full_address'] = ( ! empty( $new_instance['full_address'] ) ) ? sanitize_text_field( $new_instance['full_address'] ) : '';

            // NOTE------needs phone number sanitizer------
            $instance['phone_num'] = ( ! empty( $new_instance['phone_num'] ) ) ? sanitize_text_field( $new_instance['phone_num'] ) : '';

            // then return
            return $instance;
        }
        /**
         * Displays parts of form fields for 
         * entering weekdays and working hours
         * 
         * @param array $instance Current settings.
         * @param int $field_rows Number of field rows
         */
        public function working_hour_fields( $instance, $field_rows = 4 ) {
            ?>
            <p class="fields-group-description"><?php esc_html_e( 'Weekdays and working hours ', $this->theme_id ); ?><small><?php esc_html_e( 'Weekday: From - To', $this->theme_id ); ?></small></p>
            <?php
            // stores weekdays' working hours
            $week_working_hrs = isset( $instance['week_working_hrs'] ) ? $instance['week_working_hrs'] : array();

            for ( $i = 0; $i < $field_rows; $i++ ) { 
                $workDaysArr = array();

                $week_working_hrs[ $i ] = isset( $week_working_hrs[ $i ] ) ? $week_working_hrs[ $i ] : array();

                $work_days = ! empty( $week_working_hrs[ $i ]['work_days'] ) ? $week_working_hrs[ $i ]['work_days'] : esc_html__( 'Monday - Thursday', $this->theme_id );

                if ( $i > 0 ) {
                    $work_days = ! empty( $week_working_hrs[ $i ]['work_days'] ) ? $week_working_hrs[ $i ]['work_days'] : '';
                }

                $hrs_from = isset( $week_working_hrs[ $i ]['hrs_from'] ) ? $week_working_hrs[ $i ]['hrs_from'] : '';
                $hrs_to = isset( $week_working_hrs[ $i ]['hrs_to'] ) ? $week_working_hrs[ $i ]['hrs_to'] : '';

                if ( ! empty( $work_days ) && ! empty( $hrs_from ) && ! empty( $hrs_to ) ) {
                    $workDaysArr['work_days'] = $work_days;
                    $workDaysArr['hrs_from'] = $hrs_from;
                    $workDaysArr['hrs_to'] = $hrs_to;
                }
                // add $$workDaysArr
                if ( ! empty( $workDaysArr ) ) {
                    $week_working_hrs[ $i ] = $workDaysArr;
                } else {
                    continue;
                }
                ?>
                <div class="grid-container">
                    <div class="grid-item">
                        <input 
                            type="text" 
                            name="<?php echo esc_attr( $this->get_field_name( 'week_working_hrs' )[ $i ]['work_days'] ); ?>" 
                            id="<?php echo esc_attr( $this->get_field_id( 'work_days_' . $i ) ); ?>" 
                            value="<?php echo esc_attr( $work_days ); ?>" 
                            placeholder="<?php esc_html_e( 'Active weekdays', $this->theme_id ); ?>"
                        />
                    </div>
                    <div class="grid-item">
                        <input 
                            type="time" 
                            name="<?php echo esc_attr( $this->get_field_name( 'week_working_hrs' )[ $i ]['hrs_from'] ); ?>" 
                            id="<?php echo esc_attr( $this->get_field_id( 'hrs_from_' . $i ) ); ?>" 
                            value="<?php echo esc_attr( $hrs_from ); ?>" 
                        />
                    </div>
                    <div class="grid-item">
                        <input 
                            type="time" 
                            name="<?php echo esc_attr( $this->get_field_name( 'week_working_hrs' )[ $i ]['hrs_to'] ); ?>" 
                            id="<?php echo esc_attr( $this->get_field_id( 'hrs_to_' . $i ) ); ?>" 
                            value="<?php echo esc_attr( $hrs_to ); ?>" 
                        />
                    </div>
                </div>
                <?php

            } // End for ( $i = 0; $i < $field_rows; $i++ )
        }
        /**
         * Gets args to be used in leaflet js
         * 
         * @since 1.0
         * @return array Array of args for localizing js data.
         */
        public function get_widget_last_instance() {
            $all_instances = $this->get_settings();
            return $all_instances[ array_key_last( $all_instances ) ];
        }

        /**
         * Enqueueing scripts for the widget
         */
        public function widget_scripts() {
            // cdn
            // leaflet
            wp_register_script( $this->theme_id . '-leaflet-cdn', 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.js', array(), false, false );

            // registering leaflet
            wp_register_script( $this->theme_id . '-init-leaflet', get_template_directory_uri() . '/assets/js/init-leaflet.js', array( $this->theme_id . '-leaflet-cdn' ), '1.0', true );
        }
        /**
         * Enqueueing widget styles
         */
        public function widget_styles() {
            // leaflet css
            wp_register_style( $this->theme_id . '-leaflet-css-cdn', 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.css', array(), '6.1.1', 'all' );

            // register leaflet and owl custom style
            wp_register_style( $this->theme_id . '-custom-leaflet', get_template_directory_uri() . '/assets/css/custom-leaflet.css', array( $this->theme_id . '-leaflet-css-cdn' ), '1.0', 'all' );
        }
    } // ENDS -- class
}
// inistantiate widget
new Leaflet_Custom_Map_Widget();



/**
 * Hook callbacks to 'wp_enqueue_scripts' action
 */
add_action( 'wp_enqueue_scripts', 'wonkode_leaflet_map_widget_styles' );
add_action( 'wp_enqueue_scripts', 'wonkode_leaflet_map_widget_scripts' );

if ( ! function_exists( 'wonkode_leaflet_map_widget_scripts' ) ) {
    /**
     * Callback function to enqueue scripts for the widget
     * 
     * @since 1.0
     */
    function wonkode_leaflet_map_widget_scripts() {
        // init widget class to access instance data
        $wonkode_leaflet_map_widget = new Leaflet_Custom_Map_Widget();
        // get theme id
        $theme_id = wp_get_theme()->get( 'TextDomain' );
        // prefix for object
        $obj_prefix = str_replace( '-', '_', $theme_id );

        // enqueue only when widget is active
        if ( is_active_widget( false, false, $theme_id . '-leaflet-map-widget', true ) ) {
            // enqueueing
            wp_enqueue_script( $theme_id . '-leaflet-cdn' );
            wp_enqueue_script( $theme_id . '-init-leaflet' );

            // get args to initialize leaflet map
            $leaflet_args = $wonkode_leaflet_map_widget->get_widget_last_instance();

            $leaflet_args = wp_parse_args( 
                $leaflet_args, 
                array(
                    'map_container_id'  =>  '',
                    'loc_lat'           =>  '',
                    'loc_long'          =>  '',
                    'zoom_level'        =>  '',
                    'tile_max_zoom'     =>  '',
                    'specific_name'     =>  '',
                    'full_address'      =>  '',
                    'phone_num'         =>  '',
                ) 
            );

            // create nonce ... repeatFieldsNonce
            $leaflet_args['repeatFieldsNonce'] = wp_create_nonce( 'repeat-marker-fields' );

            // add assets url
            $leaflet_args['assets_url'] = WK_ASSETS_URL;

            wp_localize_script( $theme_id . '-init-leaflet', $obj_prefix . '_leaflet_args', $leaflet_args );
        }
    }
}

if ( ! function_exists( 'wonkode_leaflet_map_widget_styles' ) ) {
    /**
     * Callback function to enqueue widget styles
     * 
     * @since 1.0
     */
    function wonkode_leaflet_map_widget_styles() {
        // get theme id
        $theme_id = wp_get_theme()->get( 'TextDomain' );
        // enqueue only when widget is active
        if ( is_active_widget( false, false, $theme_id . '-leaflet-map-widget', true ) ) {
            wp_enqueue_style( $theme_id . '-leaflet-css-cdn' );
            wp_enqueue_style( $theme_id . '-custom-leaflet' );
        }
    }
}