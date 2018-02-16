<?php
/**
 * Handles common output tasks
 */
if ( ! class_exists( 'WP_ATI_Common' ) ) {
    class WP_ATI_Common {
		/**
		 * Adds the apple icons to the head
		 * @param array $meta_tags The array of meta tags
		 * @return array The modified meta tags
		 */
		public static function add_apple_icons( $meta_tags ) {
			$icon = get_option( 'wp_ati_apple_touch_icon' );

			if ( $icon ) {
				/**
				 * Remove the existing meta tag
				 */
				foreach( $meta_tags as $i => $meta_tag ) {
					if ( strpos( $meta_tag, 'apple-touch' ) !== false ) {
						unset( $meta_tags[$i] );
					}
				}

				$icons = new WP_ATI_Icons( $icon );

				foreach( $icons->icon_array as $size => $data ) {
					ob_start();

					if ( $data['primary'] ) :
				?>
					<link rel="apple-touch-icon" href="<?php echo $data['src']; ?>">
				<?php
					else:
				?>
					<link rel="apple-touch-icon" sizes="<?php echo $size; ?>x<?php echo $size; ?>" href="<?php echo $data['src']; ?>">
				<?php
					endif;

					$meta_tags[] = ob_get_clean();
				}
			}

			return $meta_tags;
		}
    }
}
