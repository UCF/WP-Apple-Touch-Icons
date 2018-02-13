<?php
/**
 * Handles Plugin Options/Customizer Options
 **/
if ( ! class_exists( 'WP_ATI_Admin' ) ) {
    class WP_ATI_Admin {
        static
            $option_prefix = 'wp_ati';

        public static function add_customizer_section( $wp_customize ) {
            $wp_customize->add_section(
                
            );  
        }

        public static function add_customizer_controls( $wp_customize ) {

        }
    }
}
