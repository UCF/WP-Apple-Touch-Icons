<?php
/**
 * Handles displaying the page icon metabox
 */
if ( ! class_exists( 'WP_ATI_Metabox' ) ) {
	class WP_ATI_Metabox {
		public static function add_metabox() {
			add_meta_box(
				'wp_ati_page_icon_metabox',
				'Apple Touch Icon',
				array( 'WP_ATI_Metabox', 'metabox_output' ),
				'page',
				'normal',
				'low'
			);
		}

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
								<a class="css-upload meta-file-upload <?php if ( $val ) { echo 'hidden'; }?>" href="<?php echo $upload_link; ?>">
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

		public static function handle_save() {

		}
	}
}
