<?php
/**
 * Achive post content rendering template
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
$wonkode_excerpt_post_wrapper_cls = 'card mb-4 post-content';

// display excerpt content template
$wonkode_content_template_parts::image_on_left_post_excerpt( $wonkode_excerpt_post_wrapper_cls );