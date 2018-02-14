<?php
/**
 * Handles common output tasks
 */
if ( ! class_exists( 'WP_ATI_Common' ) ) {
    class WP_ATI_Common {
        /**
         * Function for site_icon_meta_tags
         * @param array $meta_tags The array of meta tags
         * @return array The modified array of meta tags
         **/
        public static function remove_apple_icons( $meta_tags ) {
            foreach( $meta_tags as $i => $meta_tag ) {
                if ( strpos( $meta_tag, 'apple-touch' ) !== false ) {
                    unset( $meta_tags[$i] );
                }
            }

            return $meta_tags;
        }
    }
}