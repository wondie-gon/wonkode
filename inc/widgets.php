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
require WK_INC_PATH . '/widgets/cass.wonkode-equal-columns-image-and-text.php';
// 'Leaflet_Custom_Map_Widget'
require WK_INC_PATH . '/widgets/class.leaflet-custom-map-widget.php';