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
		 * Adds all image sizes. Used before images are resized.
		 */
		public static function add_image_sizes() {
			foreach( self::$size_array as $size ) {
				self::add_image_size( $size );
			}
		}

		/**
		 * Removes all images sizes. Used after images are resized.
		 */
		public static function remove_image_sizes() {
			foreach( self::$size_array as $size ) {
				self::remove_image_size( $size );
			}
		}

		/**
		 * Adds the icon image size to the image size array
		 * @param int $size The image size to add
		 */
		public static function add_image_size( $size ) {
			add_image_size(
				self::$option_prefix . $size['width'],
				$size['width'],
				$size['height'],
				false
			);
		}

		/**
		 * Removes the icon image size from the image size array
		 * @param int $size The image size to remove
		 */
		public static function remove_image_size( $size ) {
			$name = self::$option_prefix . $size['width'];
			remove_image_size( $name );
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

		/**
         * Provides the value of the option after it's been saved
         * @param mixed $old_value The old value
         * @param mixed $new_value The new value
         * @return mixed The new value modified
         */
        public static function save_apple_touch_icon( $old_value, $new_value ) {
			self::add_image_sizes();

			$icon = new WP_ATI_Icons( $new_value, false );
			$data = wp_generate_attachment_metadata( $icon->attachment_id, $icon->attachment_path );
			wp_update_attachment_metadata( $icon->attachment_id, $data );

			self::remove_image_sizes();
        }
    }
}
