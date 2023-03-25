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

/**
 * Frontpage templates action hooks
 * 
 * @since 1.0
 */
add_action( 'wonkode_before_front_selected_posts_content', 'wonkode_open_frontpage_selected_posts_section' );
add_action( 'wonkode_before_front_selected_posts_content', 'wonkode_frontpage_selected_posts_section_title' );
add_action( 'wonkode_front_selected_posts_content', 'wonkode_frontpage_selected_posts_section_main_content' );
add_action( 'wonkode_after_front_selected_posts_content', 'wonkode_close_frontpage_selected_posts_section' );

/**
 * Defines function to open selected posts section.
 */
if ( ! function_exists( 'wonkode_open_frontpage_selected_posts_section' ) ) {
  /**
   * Callback to render before frontpage 
   * selected posts section. Opens the section.
   * 
   * @since 1.0
   */
  function wonkode_open_frontpage_selected_posts_section() {
    // open section container
    WonKode_Selected_Posts_Section_Templates::before_section_content( 'selected-posts-wrapper', 'frontSelectedPostsSection' );
  }
}

/**
 * Defines function for selected posts section title.
 */
if ( ! function_exists( 'wonkode_frontpage_selected_posts_section_title' ) ) {
  /**
   * Callback to render frontpage 
   * selected posts section title.
   * 
   * @since 1.0
   */
  function wonkode_frontpage_selected_posts_section_title() {
    // section title
    WonKode_Selected_Posts_Section_Templates::section_title_block();
  }
}

/**
 * Defines function for selected posts section main content.
 */
if ( ! function_exists( 'wonkode_frontpage_selected_posts_section_main_content' ) ) {
  /**
   * Callback to render selected posts section main content.
   * 
   * @since 1.0
   */
  function wonkode_frontpage_selected_posts_section_main_content() {
    // render content
    WonKode_Selected_Posts_Section_Templates::main_section_content(  
      array(
        'row_class' =>  'g-4',
        // 'col_class' =>  ''
      )
    );
  }
}

/**
 * Defines function to close selected posts section.
 */
if ( ! function_exists( 'wonkode_close_frontpage_selected_posts_section' ) ) {
  /**
   * Callback to render after frontpage 
   * selected posts section, closes section.
   * 
   * @since 1.0
   */
  function wonkode_close_frontpage_selected_posts_section() {
    // close section container
    WonKode_Selected_Posts_Section_Templates::after_section_content();
  }
}