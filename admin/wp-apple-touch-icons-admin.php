<?php
/**
 * Handles Plugin Options/Customizer Options
 **/
if ( ! class_exists( 'WP_ATI_Admin' ) ) {
    class WP_ATI_Admin {
        public static
            $size_array = array(
                array( 'width' => 120, 'height' => 120, 'crop' => false ),
                array( 'width' => 152, 'height' => 152, 'crop' => false ),
                array( 'width' => 167, 'height' => 167, 'crop' => false ),
                array( 'width' => 180, 'height' => 180, 'crop' => false )
			),
			$primary_size = 180;

        private static
            $option_prefix = 'wp_ati_';

		/**
		 * Adds the icon image sizes to the image size array.
		 */
		public static function add_image_sizes() {
			foreach( self::$size_array as $size ) {
				add_image_size( self::$option_prefix . $size['width'], $size['width'], $size['height'], $size['crop'] );
			}
		}

		public static function remove_image_sizes( $sizes, $meta ) {
			$screen = get_current_screen();

			if ( ! $screen->parent_base === 'customize' ) {
				foreach( $sizes as $key => $size ) {
					if ( strpos( $key, 'wp_ati_' ) !== false ) {
						unset( $sizes[$key] );
					}
				}
			}

			return $sizes;
		}

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
