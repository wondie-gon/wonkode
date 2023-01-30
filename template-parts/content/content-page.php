<?php
/**
 * Template to render cntent for pages
 *
 * @package WonKode
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// global object variable for content template
global $wonkode_content_template_parts;

// classes to add to page content
$wonkode_page_cotent_wrapper_cls = 'col-12 page-content';

// display page content template
$wonkode_content_template_parts::page_content( $wonkode_page_cotent_wrapper_cls );