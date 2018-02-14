<?php
/**
 * Handles Plugin Options/Customizer Options
 **/
if ( ! class_exists( 'WP_ATI_Admin' ) ) {
    class WP_ATI_Admin {
        private static
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

        /**
         * Provides the value of the option after it's been saved
         * @param mixed $old_value The old value
         * @param mixed $new_value The new value
         * @return mixed The new value modified
         */
        public static function save_apple_touch_icon( $old_value, $new_value ) {
            preg_match( '/\/wp-content(.*)/', $new_value, $matches );

            if ( ! $matches ) return;

            $path = ABSPATH . 'wp-content' . $matches[1];

            $image = wp_get_image_editor( $path );

            $size_array = array(
                array( 'width' => 120, 'height' => 120, 'crop' => false ),
                array( 'width' => 152, 'height' => 152, 'crop' => false ),
                array( 'width' => 167, 'height' => 167, 'crop' => false ),
                array( 'width' => 180, 'height' => 180, 'crop' => false )
            );

            $image->multi_resize( $size_array );

            $image->save();
        }
    }
}
