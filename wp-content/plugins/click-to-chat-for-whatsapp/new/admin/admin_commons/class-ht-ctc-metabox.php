<?php
/**
 * Meta box
 * change values at page level
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_MetaBox' ) ) :

class HT_CTC_MetaBox {


	/**
	 * add meta box
	 */
	function meta_box() {

		$post_types = get_post_types( array('public' => true) );

		foreach ( $post_types as $type ) {
			if ( 'attachment' !== $type ) {
				add_meta_box(
					'ht_ctc_settings_meta_box',             // Id.
					'Click to Chat',                        // Title.
					array( $this, 'display_meta_box' ),     // Callback.
					$type,                                  	// Post_type.
					'side',                                 // Context.
					'default'                               // Priority.
				);
			}
		}

	}


	/**
	 * render meta box content
	 */
	function display_meta_box( $current_post ) {

		wp_nonce_field( 'ht_ctc_page_meta_box', 'ht_ctc_page_meta_box_nonce' );
		$os = get_option( 'ht_ctc_othersettings' );
		$ht_ctc_pagelevel = get_post_meta( $current_post->ID, 'ht_ctc_pagelevel', true );

		?>
		<p class="description">Change values at <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/change-values-at-page-level/?utm_source=ctc&utm_medium=meta&utm_campaign=chat">Page level</a></p>
		<p class="description">Chat Settings:</p>
		<?php

		// chat
		$number = ( isset($ht_ctc_pagelevel['number']) ) ? esc_attr($ht_ctc_pagelevel['number']) : '';
		$call_to_action = ( isset($ht_ctc_pagelevel['call_to_action']) ) ? esc_attr($ht_ctc_pagelevel['call_to_action']) : '';
		$pre_filled = ( isset($ht_ctc_pagelevel['pre_filled']) ) ? esc_attr($ht_ctc_pagelevel['pre_filled']) : '';
		$show_hide = ( isset($ht_ctc_pagelevel['show_hide']) ) ? esc_attr($ht_ctc_pagelevel['show_hide']) : '';

		$options = get_option('ht_ctc_chat_options');

		$ph_number = '';
		$ph_call_to_action = '';
		$ph_pre_filled = '';
		// If db values are correct
		if ( is_array($options) ) {
			$ph_number = ( isset( $options['number']) ) ? esc_attr( $options['number'] ) : '';
			$ph_call_to_action = ( isset( $options['call_to_action']) ) ? esc_attr( $options['call_to_action'] ) : '';
			$ph_pre_filled = ( isset( $options['pre_filled']) ) ? esc_attr( $options['pre_filled'] ) : '';
        }
        
		?>

		<!-- number -->
		<div class="row">
			<label for="number"><?php _e( 'WhatsApp Number', 'click-to-chat-for-whatsapp' ); ?></label><br>
			<input name="ht_ctc_pagelevel[number]" value="<?= $number ?>" id="number" type="text" placeholder="<?= $ph_number ?>">
			<p class="description"><a style="text-decoration: none" target="_blank" href="https://holithemes.com/plugins/click-to-chat/whatsapp-number/?utm_source=ctc&utm_medium=meta&utm_campaign=chat">WhatsApp Number</a> with country code</p>
		</div>

		<!-- call to action -->
		<div class="row">
			<label for="call_to_action"><?php _e( 'Call to Action', 'click-to-chat-for-whatsapp' ); ?></label><br>
			<input name="ht_ctc_pagelevel[call_to_action]" value="<?= $call_to_action ?>" id="call_to_action" type="text" placeholder="<?= $ph_call_to_action ?>">
		</div>

		<!-- pre-filled message -->
		<div class="row">
			<label for="pre_filled"><?php _e( 'Pre-filled Message', 'click-to-chat-for-whatsapp' ); ?></label><br>
			<textarea style="min-height: 74px; min-width: 72%" placeholder="<?= $ph_pre_filled ?>" name="ht_ctc_pagelevel[pre_filled]" id="pre_filled" class="materialize-textarea input-margin"><?= $pre_filled ?></textarea>
		</div>

		<!-- show/hide -->
		<div class="row">
			<label for="show_hide"><?php _e( 'Display Settings', 'click-to-chat-for-whatsapp' ); ?></label><br>
			<label for="show">
			<input name="ht_ctc_pagelevel[show_hide]" <?php checked( 'show' == $show_hide ); ?> value="show" id="show" type="radio">
			<?php _e( 'Show', 'click-to-chat-for-whatsapp' ); ?>
			<!-- <span class="dashicons dashicons-visibility"></span> -->
			</label>
			&emsp;
			<label for="hide">
			<input name="ht_ctc_pagelevel[show_hide]" <?php checked( 'hide' == $show_hide ); ?> value="hide" id="hide" type="radio">
			<?php _e( 'Hide', 'click-to-chat-for-whatsapp' ); ?>
			<!-- <span class="dashicons dashicons-hidden"></span> -->
			</label>
			&emsp;
			<label for="default">
			<input name="ht_ctc_pagelevel[show_hide]" <?php checked( '' == $show_hide ); ?> value="" id="default" type="radio">
			<?php _e( 'Default', 'click-to-chat-for-whatsapp' ); ?>
			</label>
		</div>

		<?php
		do_action('ht_ctc_ah_admin_chat_bottom_meta_box', $current_post );
		


		// if group enabled
		if ( isset( $os['enable_group'] ) ) {
			$group_id = ( isset($ht_ctc_pagelevel['group_id']) ) ? esc_attr($ht_ctc_pagelevel['group_id']) : '';
			?>
			<br>
			<p class="description">Group Settings:</p>
			<!-- group id -->
			<div class="row">
				<label for="group_id">Group ID</label><br>
				<input name="ht_ctc_pagelevel[group_id]" value="<?= $group_id ?>" id="group_id" type="text">
				<!-- <p class="description"><a style="text-decoration: none" target="_blank" href="https://holithemes.com/plugins/click-to-chat/whatsapp-number/">WhatsApp Number</a> with country code</p> -->
			</div>
			<?php
		}


	}


	/**
	 * save meta box
	 */
	function save_meta_box( $post_id ) {


		// Check if our nonce is set.
		if ( ! isset( $_POST['ht_ctc_page_meta_box_nonce'] ) ) {
			return;
		}

		$nonce = $_POST['ht_ctc_page_meta_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'ht_ctc_page_meta_box' ) ) {
			return;
		}

		// If this is an autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( isset( $_POST['ht_ctc_pagelevel'] ) ) {
			
			$ht_ctc_pagelevel = array_filter( $_POST['ht_ctc_pagelevel'] );

			if ( !empty( $ht_ctc_pagelevel ) ) {

				// sanitize
				foreach ($ht_ctc_pagelevel as $key => $value) {
					if( isset( $ht_ctc_pagelevel[$key] ) ) {
						if ( 'pre_filled' == $key ) {
							$new[$key] = sanitize_textarea_field( $ht_ctc_pagelevel[$key] );
						} elseif ( 'call_to_action' == $key ) {
							$new[$key] = sanitize_text_field( $ht_ctc_pagelevel[$key] );
						} else {
							$new[$key] = sanitize_text_field( $ht_ctc_pagelevel[$key] );
						}
						$ht_ctc_pagelevel[$key] = $new[$key];
					}
				}

				update_post_meta( $post_id, 'ht_ctc_pagelevel', $ht_ctc_pagelevel );
			} else {
				delete_post_meta($post_id, 'ht_ctc_pagelevel', '' );
			}
		}

	}





}

$ht_ctc_metabox = new HT_CTC_MetaBox();

add_action( 'add_meta_boxes', array($ht_ctc_metabox, 'meta_box') );
add_action( 'save_post', array($ht_ctc_metabox, 'save_meta_box') );

endif; // END class_exists check