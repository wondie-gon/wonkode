<?php
/**
 * Front page selected posts section template part
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Hook: wonkode_before_front_selected_posts_content.
 * 
 * @hooked wonkode_open_frontpage_selected_posts_section
 * @hooked wonkode_frontpage_selected_posts_section_title
 */
do_action( 'wonkode_before_front_selected_posts_content' );

/**
 * Hook: wonkode_front_selected_posts_content.
 * 
 * @hooked wonkode_frontpage_selected_posts_section_main_content
 */
do_action( 'wonkode_front_selected_posts_content' );

/**
 * Hook: wonkode_after_front_selected_posts_content.
 * 
 * @hooked wonkode_close_frontpage_selected_posts_section
 */
do_action( 'wonkode_after_front_selected_posts_content' );