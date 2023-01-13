<?php
/**
 * Custom controls base
 * 
 * @package WonKode
 * @since 1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WonKode_Custom_Control extends WP_Customize_Control {
    protected function get_custom_controls_uri() {}
}
