<?php
/**
 * Template for rendering post content 
 * according to caller of get_template_part
 *
 * @since 1.0
 * @package WonKode
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// global object variable for content template
global $wonkode_content_template_parts;

// classes to add to post content
$wonkode_content_wrapper_cls = 'card mb-4 post-content';

if ( ! is_singular() ) {
    // display excerpt content template
    $wonkode_content_template_parts::image_on_left_post_excerpt( $wonkode_content_wrapper_cls );
} else { 
    // classes single post content wrapper
    $wonkode_content_wrapper_cls = 'card mb-4 single-content';
    // display single post content template
    $wonkode_content_template_parts::single_post_content( $wonkode_content_wrapper_cls );
} 
?>