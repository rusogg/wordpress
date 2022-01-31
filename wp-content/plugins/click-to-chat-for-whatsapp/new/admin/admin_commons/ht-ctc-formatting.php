<?php
/**
 * @deprecated since 3.4  - Moved to - ht-ctc-admin-formatting.php 
 * 	remove this in v3.8 - duplicate: kept with initial file name also - to avoid cache issue..
 * 
 * 
 * Formatting API
 * 
 * Encode emoji.. 
 * @since 3.3.5
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Encoding emoji 
 * 
 * To check the charset and run
 * @uses wp_encode_emoji
 * 
 * @since 3.3.5
 * @param string $value		input value to convert emojis to html entity
 */
if ( ! function_exists('ht_ctc_wp_encode_emoji') ) {
	function ht_ctc_wp_encode_emoji($value = '') {
		
		if ( defined('DB_CHARSET') && 'utf8' == DB_CHARSET ) {

			if (function_exists('wp_encode_emoji')) {
				$value = wp_encode_emoji( $value );
			}
		}

		return $value;
	}
}