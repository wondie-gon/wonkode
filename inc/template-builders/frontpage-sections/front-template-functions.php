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
// class for latest posts of selected category section
require_once dirname( __FILE__ ) . '/class.wonkode-categorized-latest-posts-section.php';

/**
 * Frontpage templates action hooks
 * 
 * @since 1.0
 */
// action hooks for selected category latest posts section
add_action( 'wonkode_before_front_categorized_latest_posts_content', 'wonkode_open_frontpage_categorized_latest_posts_section' );
add_action( 'wonkode_before_front_categorized_latest_posts_content', 'wonkode_frontpage_categorized_latest_posts_section_title' );
add_action( 'wonkode_front_categorized_latest_posts_content', 'wonkode_frontpage_categorized_latest_posts_section_main_content' );
add_action( 'wonkode_after_front_categorized_latest_posts_content', 'wonkode_close_frontpage_categorized_latest_posts_section' );

// selected posts section hooks
add_action( 'wonkode_before_front_selected_posts_content', 'wonkode_open_frontpage_selected_posts_section' );
add_action( 'wonkode_before_front_selected_posts_content', 'wonkode_frontpage_selected_posts_section_title' );
add_action( 'wonkode_front_selected_posts_content', 'wonkode_frontpage_selected_posts_section_main_content' );
add_action( 'wonkode_after_front_selected_posts_content', 'wonkode_close_frontpage_selected_posts_section' );

// Custom Bootstrap carousel section hooks
add_action( 'wonkode_before_custom_bs_carousel_content', 'wonkode_open_custom_bs_carousel_section' );
add_action( 'wonkode_custom_bs_carousel_content', 'wonkode_custom_bs_carousel_section_main_content' );
add_action( 'wonkode_after_custom_bs_carousel_content', 'wonkode_close_custom_bs_carousel_section' );


// -------Custom Bootstrap carousel section---------------------------
/**
 * Defines function that opens custom carousel section.
 */
if ( ! function_exists( 'wonkode_open_custom_bs_carousel_section' ) ) {
  /**
   * Callback to render before custom carousel block. Opens the section.
   * 
   * @since 1.0
   */
  function wonkode_open_custom_bs_carousel_section() {
    // open section container
    WonKode_Custom_BS_Carousel_Section::before_section_content( 'custom-carousel-section', 'customBsCarouselSection' );
  }
}

/**
 * Defines function for custom carousel
 * section main content.
 */
if ( ! function_exists( 'wonkode_custom_bs_carousel_section_main_content' ) ) {
  /**
   * Callback to render custom carousel
   * section main content.
   * 
   * @since 1.0
   */
  function wonkode_custom_bs_carousel_section_main_content() {
    // render content
    WonKode_Custom_BS_Carousel_Section::render_carousel_block( 
      array( 
        'carousel_id'   =>  'frontCustomBsCarousel',
        'carousel_new_classes'   =>  'custom-bs-carousel',
        'inner_carousel_new_classes'   =>  '',
      ) 
    );
  }
}

/**
 * Defines function that closes custom carousel section.
 */
if ( ! function_exists( 'wonkode_close_custom_bs_carousel_section' ) ) {
  /**
   * Callback to render after custom carousel
   * section. 
   * Closes section.
   * 
   * @since 1.0
   */
  function wonkode_close_custom_bs_carousel_section() {
    // close section container
    WonKode_Custom_BS_Carousel_Section::after_section_content();
  }
}

// -------selected category posts section---------------------------
/**
 * Defines function to open latest posts of selected category section.
 */
if ( ! function_exists( 'wonkode_open_frontpage_categorized_latest_posts_section' ) ) {
  /**
   * Callback to render before frontpage 
   * latest posts of selected category section. Opens the section.
   * 
   * @since 1.0
   */
  function wonkode_open_frontpage_categorized_latest_posts_section() {
    // open section container
    WonKode_Categorized_Latest_Posts_Section::before_section_content( 'category-posts-wrapper', 'frontSelectedCategorySection' );
  }
}

/**
 * Defines function for latest posts of selected category section title.
 */
if ( ! function_exists( 'wonkode_frontpage_categorized_latest_posts_section_title' ) ) {
  /**
   * Callback to render frontpage 
   * latest posts of selected category section title.
   * 
   * @since 1.0
   */
  function wonkode_frontpage_categorized_latest_posts_section_title() {
    // section title
    WonKode_Categorized_Latest_Posts_Section::section_title_block();
  }
}

/**
 * Defines function for latest posts of selected category 
 * section main content.
 */
if ( ! function_exists( 'wonkode_frontpage_categorized_latest_posts_section_main_content' ) ) {
  /**
   * Callback to render latest posts of selected category 
   * section main content.
   * 
   * @since 1.0
   */
  function wonkode_frontpage_categorized_latest_posts_section_main_content() {
    ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php
      // render content
      WonKode_Categorized_Latest_Posts_Section::post_content_columns( 
        array( 
          'col_class_additions' => 'mb-4' 
        ) 
      );
    ?>
    </div>
    <?php
  }
}

/**
 * Defines function to close latest posts of selected category section.
 */
if ( ! function_exists( 'wonkode_close_frontpage_categorized_latest_posts_section' ) ) {
  /**
   * Callback to render after frontpage 
   * latest posts of selected category 
   * section, closes section.
   * 
   * @since 1.0
   */
  function wonkode_close_frontpage_categorized_latest_posts_section() {
    // close section container
    WonKode_Categorized_Latest_Posts_Section::after_section_content();
  }
}

// -------selected posts section---------------------------
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
        'col_class_additions' =>  'mb-4'
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