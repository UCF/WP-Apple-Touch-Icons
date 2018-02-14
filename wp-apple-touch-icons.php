<?php
/*
Plugin Name: WP Apple Touch Icons
Description: Provides the ability to upload a separate apple-touch-icon image, instead of using the site's favicon. Also allows for per page uploads of apple-icon-image.
Verion: 1.0.0
Author: UCF Web Communications
License: GPL3
License URI: https://www.gnu.org/licenses/gpl.html
*/
if ( ! defined( 'WPINC' ) ) {
    die;
}

include_once 'admin/wp-apple-touch-icons-admin.php';

if ( ! function_exists( 'wp_ati_plugins_loaded' ) ) {
    /**
     * Runs when the plugins are finished loading.
     */
    function wp_ati_plugins_loaded() {
        add_action( 'customize_register', array( 'WP_ATI_Admin', 'add_customizer_section' ), 10, 1 );
        add_action( 'customize_register', array( 'WP_ATI_Admin', 'add_customizer_controls' ), 10, 1 );
    }

    add_action( 'plugins_loaded', 'wp_ati_plugins_loaded', 10, 0 );
}
