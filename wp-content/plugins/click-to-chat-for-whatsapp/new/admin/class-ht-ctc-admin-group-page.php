<?php
/**
 * group settings page - admin 
 * 
 * group chat options .. 
 * 
 * @package ctc
 * @subpackage admin
 * @since 2.0 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Group_Page' ) ) :

class HT_CTC_Admin_Group_Page {

    public function menu() {

        add_submenu_page(
            'click-to-chat',
            'Group Chat/Invite',
            'Group',
            'manage_options',
            'click-to-chat-group-feature',
            array( $this, 'settings_page' )
        );
    }

    public function settings_page() {

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <div class="row">
                <div class="col s12 m12 xl8 options">
                    <form action="options.php" method="post" class="">
                        <?php settings_fields( 'ht_ctc_group_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_group_page_settings_sections_do' ) ?>
                        <?php submit_button() ?>
                    </form>
                </div>
                <!-- <div class="col s12 m12 xl6 ht-ctc-admin-sidebar">
                </div> -->
            </div>

        </div>

        <?php

    }


    public function settings() {

        // main settings - options enable .. group, share .. 
        // chat options 
        register_setting( 'ht_ctc_group_page_settings_fields', 'ht_ctc_group' , array( $this, 'options_sanitize' ) );
        
        add_settings_section( 'ht_ctc_main_page_settings_sections_add', '', array( $this, 'main_settings_section_cb' ), 'ht_ctc_group_page_settings_sections_do' );
        
        add_settings_field( 'group_id', __( 'WhatsApp Group ID', 'click-to-chat-for-whatsapp'), array( $this, 'group_id_cb' ), 'ht_ctc_group_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'group_cta', __( 'Call to Action', 'click-to-chat-for-whatsapp'), array( $this, 'group_cta_cb' ), 'ht_ctc_group_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        
        add_settings_field( 'group_ctc_desktop', __( 'Style, Position', 'click-to-chat-for-whatsapp'), array( $this, 'group_ctc_device_cb' ), 'ht_ctc_group_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );

        add_settings_field( 'group_show_hide', __( 'Show/Hide', 'click-to-chat-for-whatsapp'), array( $this, 'group_show_hide_cb' ), 'ht_ctc_group_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        add_settings_field( 'group_shortcode_cb', '', array( $this, 'group_shortcode_cb' ), 'ht_ctc_group_page_settings_sections_do', 'ht_ctc_main_page_settings_sections_add' );
        
        
    }

    public function main_settings_section_cb() {
        ?>
        <h1>Group Chat/Invite</h1>
        <?php
        do_action('ht_ctc_ah_admin' );
    }


    // WhatsApp Group ID.
    function group_id_cb() {
        $options = get_option('ht_ctc_group');
        $value = ( isset( $options['group_id']) ) ? esc_attr( $options['group_id'] ) : '';
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_group[group_id]" value="<?= $value ?>" id="whatsapp_group_id" type="text" class="input-margin">
                <label for="whatsapp_group_id"><?php _e( 'WhatsApp Group ID', 'click-to-chat-for-whatsapp' ); ?>.</label>
                <p class="description"><?php _e( 'Enter WhatsApp Group ID. E.g. 9EHLsEsOeJk6AVtE8AvXiA', 'click-to-chat-for-whatsapp' ); ?> - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/find-whatsapp-group-id/?utm_source=ctc&utm_medium=admin&utm_campaign=group"><?php _e( 'more info', 'click-to-chat-for-whatsapp' ); ?></a> </p>
            </div>
        </div>
        <?php
    }

    // call to action 
    function group_cta_cb() {
        $options = get_option('ht_ctc_group');
        $value = ( isset( $options['call_to_action']) ) ? esc_attr( $options['call_to_action'] ) : '';
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_group[call_to_action]" value="<?= $value ?>" id="call_to_action" type="text" class="input-margin">
                <label for="call_to_action"><?php _e( 'Call to Action', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description"> <?php _e( 'Text that appears along with WhatsApp icon/button', 'click-to-chat-for-whatsapp' ); ?> - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/call-to-action/?utm_source=ctc&utm_medium=admin&utm_campaign=group"><?php _e( 'more info', 'click-to-chat-for-whatsapp' ); ?></a> </p>
            </div>
        </div>
        <?php
    }
    

    // device based settings - style, position
    function group_ctc_device_cb() {
        $options = get_option('ht_ctc_group');
        $dbrow = 'ht_ctc_group';
        $type = 'group';
        
        include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-device-settings.php';
    }


    // show/hide 
    function group_show_hide_cb() {
        $options = get_option('ht_ctc_group');
        $dbrow = 'ht_ctc_group';
        $type = 'group';

        include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-show-hide.php';
    }


    function group_shortcode_cb() {
        ?>
        <p class="description"><?php _e( 'Shortcodes for Group Chat', 'click-to-chat-for-whatsapp' ); ?>: [ht-ctc-group] - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/shortcodes-group/?utm_source=ctc&utm_medium=admin&utm_campaign=group">more info</a></p>
        <?php
    }



    /**
     * Sanitize each setting field as needed
     *
     * @since 2.0
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $new_input = array();

        foreach ($input as $key => $value) {

            if ( 'side_1_value' == $key || 'side_2_value' == $key || 'mobile_side_1_value' == $key || 'mobile_side_2_value' == $key ) {
                $input[$key] = str_replace( ' ', '', $input[$key] );
                if ( is_numeric($input[$key]) ) {
                    $input[$key] = $input[$key] . 'px';
                }
                if ( '' == $input[$key] ) {
                    $input[$key] = '0px';
                }
                $new_input[$key] = sanitize_text_field( $input[$key] );
            } elseif ( 'display' == $key ) {
                $new_input[$key] = array_map( 'sanitize_text_field', $input[$key] );
            } else {
                $new_input[$key] = sanitize_text_field( $input[$key] );
            }



            // if( isset( $input[$key] ) ) {
            //     $new_input[$key] = sanitize_text_field( $input[$key] );
            // }
        }

        // l10n
        foreach ($input as $key => $value) {
            if ( 'group_id' == $key || 'call_to_action' == $key ) {
                do_action( 'wpml_register_single_string', 'Click to Chat for WhatsApp', $key.'__group', $input[$key] );
            }
        }

        do_action('ht_ctc_ah_admin_after_sanitize' );

        return $new_input;
    }


}

$ht_ctc_admin_group_page = new HT_CTC_Admin_Group_Page();

add_action('admin_menu', array($ht_ctc_admin_group_page, 'menu') );
add_action('admin_init', array($ht_ctc_admin_group_page, 'settings') );

endif; // END class_exists check