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
			$retval = null;

			$attachment_id = attachment_url_to_postid( $this->attachment_url );

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

			$attachment = wp_get_attachment_url( $this->attachment_id );

			if ( $attachment ) {
				$retval = $attachment;
			}

			return $retval;
		}

		/**
		 * Retrieves the icon array
		 * @return array The array of icons, indexed by size
		 */
		private function get_icon_array() {
			$retval = array();

			WP_ATI_Admin::add_image_sizes();

			foreach( WP_ATI_Admin::$size_array as $size ) {
				// If the above step didn't generate a `$src`, get the closest match.
				$src = wp_get_attachment_image_src( $this->attachment_id, array( $size['width'], $size['height'] ) );

				if ( $src ) {
					$retval[$size['width']] = array(
						'primary' => false,
						'src'     => $src[0]
					);

					if ( $size['width'] === WP_ATI_Admin::$primary_size ) {
						$retval[$size['width']]['primary'] = true;
					}
				}
			}

			WP_ATI_Admin::remove_image_sizes();

			return $retval;
		}
	}
}
