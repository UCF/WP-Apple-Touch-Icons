<?php
/**
 * Handles Plugin Options/Customizer Options
 **/
if ( ! class_exists( 'WP_ATI_Admin' ) ) {
    class WP_ATI_Admin {
        static
            $option_prefix = 'wp_ati_';

        /**
         * Adds the Touch Icons section to the customizer
         * @param WP_Customizer $wp_customize
         */
        public static function add_customizer_section( $wp_customize ) {
            $wp_customize->add_section(
                self::$option_prefix . 'general_section',
                array(
                    'title' => 'Apple Touch Icons'
                )
            );  
        }

        /**
         * Adds the apple touch icon settings and control
         * @param WP_Customizer $wp_customize
         */
        public static function add_customizer_controls( $wp_customize ) {
            $wp_customize->add_setting(
                self::$option_prefix . 'apple_touch_icon',
                array(
                    'type' => 'option'
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    self::$option_prefix . 'apple_touch_icon',
                    array(
                        'label'       => 'Apple Touch Icon',
                        'description' => 'Icon that will be used when Apple user bookmark pages from this site.',
                        'section'     => self::$option_prefix . 'general_section'
                    )
                )
            );
        }
    }
}
