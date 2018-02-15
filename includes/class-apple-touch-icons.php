<?php
/**
 * Provides a utility class for creating and loading apple-touch-icons
 */
if ( ! class_exists( 'WP_ATI_Icons' ) ) {
	class WP_ATI_Icons {
		public
			/**
			 * The attachment id
			 * @var int
			 */
			$attachment_id,
			/**
			 * The primary attachment url
			 * @var string
			 */
			$attachment_url,
			/**
			 * The primary attachment filepath
			 * @var string
			 */
			$attachment_path,
			/**
			 * The icon array
			 * @var array
			 */
			$icon_array;

		/**
		 * Constructs a new instance of WP_ATI_Icons
		 * @param mixed $attachment The id or url of the attachment
		 * @param bool $retrieve_icons Set to false when generating icons
		 * @return WP_ATI_Icons
		 */
		public function __construct( $attachment, $retrieve_icons=true ) {
			if ( is_numeric( $attachment ) ) {
				$this->attachment_id = $attachment;
				$this->attachment_url = $this->get_attachment_url_from_id();
			} else {
				$this->attachment_url = $attachment;
				$this->attachment_id = $this->get_attachment_id_from_url();
			}

			$this->attachment_path = get_attached_file( $this->attachment_id );

			if ( $retrieve_icons ) {
				$this->icon_array = $this->get_icon_array();
			}
		}

		/**
		 * Attempts to retrieve the attachment id from a provided url
		 * @return int The attachment id
		 */
		private function get_attachment_id_from_url() {
			global $wpdb;

			$attachment_id = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT ID FROM $wpdb->posts WHERE guid=%s",
					$this->attachment_url
				)
			);

			$retval = null;

			if ( $attachment_id ) {
				$retval = $attachment_id;
			}

			return $retval;
		}

		/**
		 * Attempts to retrieve the attachment url from a provided id
		 * @return string The attachment url
		 */
		private function get_attachment_url_from_id() {
			$retval = null;

			$attachment = get_post( $this->attachment_id );

			if ( ! is_wp_error( $attachment ) ) {
				$retval = get_permalink( $attachment );
			}

			return $retval;
		}

		/**
		 * Retrieves the icon array
		 * @return array The array of icons, indexed by size
		 */
		private function get_icon_array() {
			$retval = array();

			foreach( WP_ATI_Admin::$size_array as $size ) {
				// Load the image editor so we can access some utilities.
				$image = wp_get_image_editor( $this->attachment_path );

				$src = '';

				// Generate the filepath of a specifically sized image.
				$generated_src = $image->generate_filename( $size['width'] . 'x' . $size['height'] );

				// If the file exists, generate the full url.
				if ( file_exists( $generated_src ) ) {
					preg_match( '/wp-content(.*)/', $generated_src, $matches );

					if ( $matches ) {
						$src = content_url( $matches[1] );
					}
				}

				// If the above step didn't generate a `$src`, get the closest match.
				if ( ! $src ) {
					$src = wp_get_attachment_image_src( $this->attachment_id, array( $size['width'], $size['height'] ) );
				}

				if ( $src ) {
					$retval[$size['width']] = array(
						'primary' => false,
						'src'     => $src
					);

					if ( $size['width'] === WP_ATI_Admin::$primary_size ) {
						$retval[$size['width']]['primary'] = true;
					}
				}
			}

			return $retval;
		}

		/**
		 * Generates the various icon sizes
		 */
		public function generate_icons() {
			$image = wp_get_image_editor( $this->attachment_path );
			$image->multi_resize( WP_ATI_Admin::$size_array );
			wp_generate_attachment_metadata( $this->attachment_id, $this->attachment_path );
		}
	}
}
