<?php
/**
 * Widgets and widget areas template functions
 *
 * @package WonKode
 * @since 1.0
 */
// no direct access to file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// 'WonKode_Widget_Areas' class for widget areas
require WK_INC_PATH . '/widgets/class.wonkode-widget-areas.php';

// 'WonKode_Equal_Columns_Image_And_Text' widget
require WK_INC_PATH . '/widgets/class.wonkode-equal-columns-image-and-text.php';
// 'Leaflet_Custom_Map_Widget'
require WK_INC_PATH . '/widgets/class.leaflet-custom-map-widget.php';
// 'WonKode_Short_Footer_About_Site_Text' widget
require WK_INC_PATH . '/widgets/class.wonkode-short-footer-about-site-text.php';
// 'WonKode_Footer_Page_Links' widget
require WK_INC_PATH . '/widgets/class.wonkode-footer-page-links.php';
// 'WonKode_Category_Links_List' widget
require WK_INC_PATH . '/widgets/class.wonkode-category-links-list.php';