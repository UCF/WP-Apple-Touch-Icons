<?php
/**
 * Handles displaying the page icon metabox
 */
if ( ! class_exists( 'WP_ATI_Metabox' ) ) {
	class WP_ATI_Metabox {

		/**
		 * Enqueues the admin assets
		 * @param string $hook The current hook being called
		 */
		public static function admin_enqueue_assets( $hook ) {
			if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
				wp_enqueue_script(
					'wp-ati-js',
					WP_ATI__JS_URL . '/wp-ati.min.js',
					array( 'jquery' ),
					null,
					true
				);
			}
		}

		/**
		 * Adds the icon metabox
		 */
		public static function add_metabox() {
			add_meta_box(
				'wp_ati_page_icon_metabox',
				'Apple Touch Icon',
				array( 'WP_ATI_Metabox', 'metabox_output' ),
				null,
				'normal',
				'low'
			);
		}

		/**
		 * The output of the meta box
		 * @param WP_Post $post The post.
		 * @return string The html output
		 */
		public static function metabox_output( $post ) {
			wp_nonce_field( 'wp_ati_page_icon_metabox_nonce_save', 'wp_ati_page_icon_metabox_nonce' );
			$upload_link = esc_url( get_upload_iframe_src( 'media', $post->ID ) );

			$icon = get_post_meta( $post->ID, 'wp_ati_icon', true );
			$val = null;

			if ( $icon ) {
				$val = new WP_ATI_Icons( $icon );
			}
		?>
			<table class="form-table">
				<tbody>
					<tr>
						<th><strong>Custom Apple Touch Icon</strong></th>
						<td>
							<div class="icon-preview meta-file-wrap <?php if ( ! $val ) { echo 'hidden'; }?>">
								<span class="dashicons dashicons-media-code"></span>
								<span id="icon-filename"><?php if ( $val ) { echo basename( $val->attachment_url ); } ?></span>
							</div>
							<p class="hide-if-no-js">
								<a class="icon-upload meta-file-upload <?php if ( $val ) { echo 'hidden'; }?>" href="<?php echo $upload_link; ?>">
									Add File
								</a>
								<a class="icon-remove meta-file-upload <?php if ( !$val ) { echo 'hidden'; }?>" href="#">
									Remove File
								</a>
							</p>

							<input class="meta-file-field" id="wp_ati_icon" name="wp_ati_icon" type="hidden" value="<?php if ( $val ) { echo htmlentities( $val->attachment_id ); } ?>">
						</td>
					</tr>
				</tbody>
			</table>
		<?php

		}

		/**
		 * Handles saving the metabox values
		 */
		public static function handle_save() {

		}
	}
}
