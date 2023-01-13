<?php
/**
 * Class for custom nav walker
 *
 * Custom nav walker that will be used as a walker 
 * for custom nav menu
 * 
 *
 * @package WonKode
 * @since 1.0
 */
// restricting direct access of class
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Custom_Nav_Walker' ) ) {
    class WonKode_Custom_Nav_Walker extends Walker_Nav_Menu {
        /**
         * --Modifies core--
         * Starts the list before the elements are added.
         *
         *
         * @see Walker::start_lvl()
         * 
         * @since 1.0
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $output .= '<ul class="dropdown-menu">';
        }
        /**
         * --Modifies core--
         * Starts the element output.
         *
         * @since 1.0
         *
         * @see Walker::start_el()
         *
         * @param string   $output              Used to append additional content (passed by reference).
         * @param WP_Post  $item                Menu item data object.
         * @param int      $depth               Depth of menu item. Used for padding.
         * @param stdClass $args                An object of wp_nav_menu() arguments.
         * @param int      $current_object_id   Optional. ID of the current menu item. Default 0.
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {

            // Passed classes.
            $classes = empty( $item->classes ) ? array() : ( array ) $item->classes;
            $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

            if( $depth == 0 && ! ( in_array( 'menu-item-has-children', (array) $item->classes ) ) ) {
                $output .= '<li id="nav-menu-item-' . $item->ID . '" class="nav-item nav-item-depth-' . $depth . ' ' . $class_names  . '" >';
            } elseif ( $depth == 0 && in_array( 'menu-item-has-children', (array) $item->classes ) ) {
                $output .= '<li id="nav-menu-item-' . $item->ID . '" class="nav-item dropdown nav-item-depth-' . $depth . ' ' . $class_names  . '" >';
            } elseif( $depth > 0 && in_array( 'menu-item-has-children', (array) $item->classes ) ) {
                $output .= '<li id="nav-menu-item-' . $item->ID . '" class="dropend nav-item-depth-' . $depth . ' ' . $class_names  . '" >';
            } elseif( $depth > 0 && ! ( in_array( 'menu-item-has-children', (array) $item->classes ) ) ) {
                $output .= '<li id="nav-menu-item-' . $item->ID . '" class="nav-item-depth-' . $depth . ' ' . $class_names  . '" >';
            } else {
                $output .= '<li id="nav-menu-item-' . $item->ID . '" class="nav-item-depth-' . $depth . '" >';
            }

            // Link attributes.
            $attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
            $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
            $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
            
            if ( in_array( 'menu-item-has-children', (array) $item->classes ) ) {
                $attributes .= ' class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"';
            } else {
                $attributes .= ' class="' . ( ( $depth > 0 ) ? 'dropdown-item' : 'nav-link' ) . '"';
            }

            // Build HTML output and pass through the proper filter
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                $args->before,
                $attributes,
                $args->link_before,
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args->link_after,
                $args->after
            );

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
        /**
         * --Modifies core--
         * Ends the element output, if needed.
         *
         * @since 1.0
         *
         * @see Walker::end_el()
         *
         * @param string   $output      Used to append additional content (passed by reference).
         * @param WP_Post  $item        Menu item data object. Not used.
         * @param int      $depth       Depth of page. Not Used.
         * @param stdClass $args        An object of wp_nav_menu() arguments.
         */
        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= '</li>';
        }
        /**
         * --Modifies core--
         * Ends the list of after the elements are added.
         *
         * @since 1.0
         *
         * @see Walker::end_lvl()
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $output .= '</ul>';
        }
    }
    
}