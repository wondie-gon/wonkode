<?php
/**
 * Template to render single post content
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
$wonkode_single_cotent_wrapper_cls = 'card mb-4 single-content';

// display single post content template
$wonkode_content_template_parts::single_post_content( $wonkode_single_cotent_wrapper_cls );