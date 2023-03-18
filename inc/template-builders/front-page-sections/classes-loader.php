<?php 
/**
 * Loader for classes of frontpage sections templates
 * 
 * @package WonKode
 * @since 1.0
 */
// direct access restricted
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// base class
require_once dirname( __FILE__ ) . '/class.wonkode-frontpage-customize-builder.php';
// class for selected posts section
require_once dirname( __FILE__ ) . '/class.wonkode-selected-posts-section-templates.php';