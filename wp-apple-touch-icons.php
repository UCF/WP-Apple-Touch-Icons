<?php
/*
Plugin Name: WP Apple Touch Icons
Description: Provides the ability to upload a separate apple-touch-icon image, instead of using the site's favicon. Also allows for per page uploads of apple-icon-image.
Version: 1.0.2
Author: UCF Web Communications
License: GPL3
License URI: https://www.gnu.org/licenses/gpl.html
GitHub Plugin URI: UCF/WP-Apple-Touch-Icons
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'WP_ATI__FILE', __FILE__ );
define( 'WP_ATI__STATIC_URL', plugins_url( 'static', __FILE__ ) );
define( 'WP_ATI__JS_URL', WP_ATI__STATIC_URL . '/js' );

include_once 'includes/class-apple-touch-icons.php';
include_once 'admin/wp-apple-touch-icons-admin.php';
include_once 'admin/wp-apple-touch-icons-metabox.php';
include_once 'includes/wp-apple-touch-icons-common.php';

if ( ! function_exists( 'wp_ati_plugins_loaded' ) ) {
	/**
	 * Runs when the plugins are finished loading.
	 */
	function wp_ati_plugins_loaded() {
		add_action( 'customize_register', array( 'WP_ATI_Admin', 'add_customizer_section' ), 10, 1 );
		add_action( 'customize_register', array( 'WP_ATI_Admin', 'add_customizer_controls' ), 10, 1 );
		add_action( 'update_option_wp_ati_apple_touch_icon', array( 'WP_ATI_Admin', 'save_apple_touch_icon' ), 10, 2 );
		add_filter( 'site_icon_meta_tags', array( 'WP_ATI_Common', 'add_apple_icons' ), 10, 1 );
		add_action( 'add_meta_boxes', array( 'WP_ATI_Metabox', 'add_metabox' ), 10, 0 );
		add_action( 'save_post', array( 'WP_ATI_Metabox', 'handle_save' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( 'WP_ATI_Metabox', 'admin_enqueue_assets' ), 10, 1 );
	}

	add_action( 'plugins_loaded', 'wp_ati_plugins_loaded', 10, 0 );
}
