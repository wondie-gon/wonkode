<?php
/**
 * Class to customize site layout 
 * containers, sidebar position, columns etc
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// class for customizing layout
if ( ! class_exists( 'WonKode_Customize_Site_Layout' ) ) {
    class WonKode_Customize_Site_Layout extends WonKode_Customize_Base {
        /**
         * Class constructor
         * 
         * @since 1.0
         */
        public function __construct() {
            parent::__construct();

            add_action( 'customize_register', array( $this, 'register' ) );
        }
        /**
         * Register site layout customize features
         * 
         * @since 1.0
         * @param \WP_Customize_Manager $wp_customize Customizer object reference.
         * @return void
         */
        public function register( $wp_customize ) {
            /**
             * Section for site layout
             */
            $wp_customize->add_section(
                $this->prefix_id . '_site_layout_section', 
                array(
                    'priority'	    =>	50,
                    'capability'    => 'edit_theme_options',
                    'title'		    =>	__( 'Site Layout', $this->theme_id ),
                    'description'   => __( 'Enables to customize site layout, including container sizes, sidebar positions, etc', $this->theme_id ),
                )
            );

            /**
             * Outer container width bootstrap class 
             * selection setting
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_outer_container_bs_class',
                array(
                    'default'           => WK_DEFAULTS['_outer_container_bs_class'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'choices' ),
                    'capability'        => 'edit_theme_options',
                )
            );
            /**
             * Outer container selection radio control
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_outer_container_bs_class',
                    array(
                        'priority'    => 10,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_outer_container_bs_class',
                        'label'       => __( 'Outer container Bootstrap class', $this->theme_id ),
                        'description' => __( 'Set outer container width of your site by choosing which Bootstrap class to use', $this->theme_id ),
                        'type'        => 'radio',
                        'choices'     => array(
                            'container-xxl'     => __( 'container-xxl: Full width until 1399px device width', $this->theme_id ),
                            'container-xl'      => __( 'container-xl: Full width until 1199px device width', $this->theme_id ),
                            'container-lg'      => __( 'container-lg: Full width until 991px device width', $this->theme_id ),
                            'container-md'      => __( 'container-md: Full width until 767px device width', $this->theme_id ),
                            'container'         => __( 'container: Full width until 575px but sets a max-width at each breakpoint above that', $this->theme_id ),
                            'container-fluid'   => __( 'container-fluid: Full width at all breakpoints', $this->theme_id ),
                        ),
                    )
                )
            );

            /**
             * Inner container width bootstrap class 
             * selection setting
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_inner_container_bs_class',
                array(
                    'default'           => WK_DEFAULTS['_inner_container_bs_class'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'choices' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * Inner container selection radio control
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_inner_container_bs_class',
                    array(
                        'priority'    => 20,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_inner_container_bs_class',
                        'label'       => __( 'Inner container Bootstrap class', $this->theme_id ),
                        'description' => __( 'Set inner container width by choosing Bootstrap container class', $this->theme_id ),
                        'type'        => 'radio',
                        'choices'     => array(
                            'container-xxl'     => __( 'container-xxl: Full width until 1399px device width', $this->theme_id ),
                            'container-xl'      => __( 'container-xl: Full width until 1199px device width', $this->theme_id ),
                            'container-lg'      => __( 'container-lg: Full width until 991px device width', $this->theme_id ),
                            'container-md'      => __( 'container-md: Full width until 767px device width', $this->theme_id ),
                            'container'         => __( 'container: Full width until 575px but sets a max-width at each breakpoint above that', $this->theme_id ),
                            'container-fluid'   => __( 'container-fluid: Full width at all breakpoints', $this->theme_id ),
                        ),
                    )
                )
            );

            /**
             * Outer container margin top class 
             * selection setting
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_outer_container_margin_top',
                array(
                    'default'           => WK_DEFAULTS['_outer_container_margin_top'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'choices' ),
                    'capability'        => 'edit_theme_options',
                )
            );
            /**
             * Outer container margin top selection radio control
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_outer_container_margin_top',
                    array(
                        'priority'    => 10,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_outer_container_margin_top',
                        'label'       => __( 'Outer container margin top', $this->theme_id ),
                        'type'        => 'radio',
                        'choices'     => array(
                            'mt-auto'   =>  'Auto',
                            'mt-3'      =>  '1rem',
                            'mt-4'      =>  '1.5rem',
                            'mt-5'      =>  '3rem',
                            'unset'     =>  'Unset',
                        ),
                    )
                )
            );

            /**
             * Outer container margin bottom class 
             * selection setting
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_outer_container_margin_bottom',
                array(
                    'default'           => WK_DEFAULTS['_outer_container_margin_bottom'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'choices' ),
                    'capability'        => 'edit_theme_options',
                )
            );
            /**
             * Outer container margin bottom selection radio control
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_outer_container_margin_bottom',
                    array(
                        'priority'    => 10,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_outer_container_margin_bottom',
                        'label'       => __( 'Outer container margin bottom', $this->theme_id ),
                        'type'        => 'radio',
                        'choices'     => array(
                            'mb-auto'   =>  'Auto',
                            'mb-3'      =>  '1rem',
                            'mb-4'      =>  '1.5rem',
                            'mb-5'      =>  '3rem',
                            'unset'     =>  'Unset',
                        ),
                    )
                )
            );

            /**
             * Sidebar position selection setting
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_sidebar_position',
                array(
                    'default'           => WK_DEFAULTS['_sidebar_position'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'choices' ),
                    'capability'        => 'edit_theme_options',
                )
            );
            /**
             * Sidebar position selection radio control
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_sidebar_position',
                    array(
                        'priority'    => 30,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_sidebar_position',
                        'label'       => __( 'Sidebar position', $this->theme_id ),
                        'description' => __( 'Set sidebar position of site by checking one option', $this->theme_id ),
                        'type'        => 'radio',
                        'choices'     => array(
                            'right' => __( 'Right', $this->theme_id ),
                            'left'  => __( 'Left', $this->theme_id ),
                            'both'  => __( 'Left & Right', $this->theme_id ),
                            'none'  => __( 'No sidebar', $this->theme_id ),
                        ),
                    )
                )
            );

            /**
             * column size for single sidebar 
             * setting for large device width (>=992px)
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_single_sidebar_col_size_lg',
                array(
                    'default'           => WK_DEFAULTS['_single_sidebar_col_size_lg'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'number' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * column size for single sidebar 
             * number input control for 
             * large device width (>=992px)
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_single_sidebar_col_size_lg',
                    array(
                        'priority'    => 40,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_single_sidebar_col_size_lg',
                        'label'       => __( 'Sidebar column size (min-width: 992px)', $this->theme_id ),
                        'type'        => 'number',
                        'input_attrs'     => array(
                            'min'   => '2',
                            'max'   => '6',
                        ),
                        'active_callback'   =>  array( $this, 'sidebar_is_single' ),
                    )
                )
            );

            /**
             * column size for single sidebar 
             * setting for medium device width (>=768px)
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_single_sidebar_col_size_md',
                array(
                    'default'           => WK_DEFAULTS['_single_sidebar_col_size_md'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'number' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * column size for single sidebar 
             * number input control for 
             * medium device width (>=768px)
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_single_sidebar_col_size_md',
                    array(
                        'priority'    => 50,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_single_sidebar_col_size_md',
                        'label'       => __( 'Sidebar column size (min-width: 768px)', $this->theme_id ),
                        'type'        => 'number',
                        'input_attrs'     => array(
                            'min'   => '2',
                            'max'   => '6',
                        ),
                        'active_callback'   =>  array( $this, 'sidebar_is_single' ),
                    )
                )
            );

            /**
             * left column size for double sidebar 
             * setting for large device width (>=992px)
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_double_sidebar_left_col_size_lg',
                array(
                    'default'           => WK_DEFAULTS['_double_sidebar_left_col_size_lg'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'number' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * left column size for double sidebar 
             * number input control 
             * for large device width (>=992px)
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_double_sidebar_left_col_size_lg',
                    array(
                        'priority'    => 60,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_double_sidebar_left_col_size_lg',
                        'label'       => __( 'Left columns (min-width: 992px)', $this->theme_id ),
                        'type'        => 'number',
                        'input_attrs'     => array(
                            'min'   => '2',
                            'max'   => '4',
                        ),
                        'active_callback'   =>  array( $this, 'sidebar_is_double' ),
                    )
                )
            );

            /**
             * left column size for double sidebar 
             * setting for large device width (>=768px)
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_double_sidebar_left_col_size_md',
                array(
                    'default'           => WK_DEFAULTS['_double_sidebar_left_col_size_md'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'number' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * left column size for double sidebar 
             * number input control 
             * for large device width (>=768px)
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_double_sidebar_left_col_size_md',
                    array(
                        'priority'    => 70,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_double_sidebar_left_col_size_md',
                        'label'       => __( 'Left columns (min-width: 768px)', $this->theme_id ),
                        'type'        => 'number',
                        'input_attrs'     => array(
                            'min'   => '2',
                            'max'   => '4',
                        ),
                        'active_callback'   =>  array( $this, 'sidebar_is_double' ),
                    )
                )
            );

            /**
             * right column size for double sidebar 
             * setting for large device width (>=992px)
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_double_sidebar_right_col_size_lg',
                array(
                    'default'           => WK_DEFAULTS['_double_sidebar_right_col_size_lg'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'number' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * right column size for double sidebar 
             * number input control 
             * for large device width (>=992px)
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_double_sidebar_right_col_size_lg',
                    array(
                        'priority'    => 80,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_double_sidebar_right_col_size_lg',
                        'label'       => __( 'Right columns (min-width: 992px)', $this->theme_id ),
                        'type'        => 'number',
                        'input_attrs'     => array(
                            'min'   => '2',
                            'max'   => '4',
                        ),
                        'active_callback'   =>  array( $this, 'sidebar_is_double' ),
                    )
                )
            );

            /**
             * right column size for double sidebar 
             * setting for large device width (>=768px)
             */
            $wp_customize->add_setting(
                $this->prefix_id . '_double_sidebar_right_col_size_md',
                array(
                    'default'           => WK_DEFAULTS['_double_sidebar_right_col_size_md'],
                    'type'              => 'theme_mod',
                    'sanitize_callback' => array( 'WonKode_Sanitize', 'number' ),
                    'capability'        => 'edit_theme_options',
                )
            );

            /**
             * right column size for double sidebar 
             * number input control 
             * for large device width (>=768px)
             */
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $this->prefix_id . '_double_sidebar_right_col_size_md',
                    array(
                        'priority'    => 90,
                        'section'     => $this->prefix_id . '_site_layout_section',
                        'settings'    => $this->prefix_id . '_double_sidebar_right_col_size_md',
                        'label'       => __( 'Right columns (min-width: 768px)', $this->theme_id ),
                        'type'        => 'number',
                        'input_attrs'     => array(
                            'min'   => '2',
                            'max'   => '4',
                        ),
                        'active_callback'   =>  array( $this, 'sidebar_is_double' ),
                    )
                )
            );
        }

        /**
         * Check if single sidebar is set (right or left)
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if right or left sidebar is set, false otherwise
         */
        public function sidebar_is_single( $control ) {
            $sidebar_position = $control->manager->get_setting( $this->prefix_id . '_sidebar_position' )->value();
            return 'right' === $sidebar_position || 'left' === $sidebar_position;
        }

        /**
         * Check if double sidebar is set (right and left)
         * 
         * @since 1.0
         * @param WP_Customize_Control $control Object for customize control
         * @return bool true if sidebar position is set as 'both', false otherwise
         */
        public function sidebar_is_double( $control ) {
            $sidebar_position = $control->manager->get_setting( $this->prefix_id . '_sidebar_position' )->value();
            return 'both' === $sidebar_position;
        }


    } // ENDS --- class
}
new WonKode_Customize_Site_Layout;