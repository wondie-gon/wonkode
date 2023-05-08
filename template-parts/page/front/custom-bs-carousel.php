<?php
/**
 * Front page custom Bootstrap carousel section template part
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Hook: wonkode_before_custom_bs_carousel_content.
 * 
 * @hooked wonkode_open_custom_bs_carousel_section
 */
do_action( 'wonkode_before_custom_bs_carousel_content' );

/**
 * Hook: wonkode_custom_bs_carousel_content.
 * 
 * @hooked wonkode_custom_bs_carousel_section_main_content
 */
do_action( 'wonkode_custom_bs_carousel_content' );

/**
 * Hook: wonkode_after_custom_bs_carousel_content.
 * 
 * @hooked wonkode_close_custom_bs_carousel_section
 */
do_action( 'wonkode_after_custom_bs_carousel_content' );