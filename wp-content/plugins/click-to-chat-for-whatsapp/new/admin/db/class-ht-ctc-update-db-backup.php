<?php
/**
 * backup/fallback option - if the updater process not worked well. while upgrading the plugin.
 *
 * @package ctc
 * @since 3.3.3
 * @from 
 *  class-ht-ctc-chat.php
 *  
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Update_DB_Backup' ) ) :

class HT_CTC_Update_DB_Backup {


    public function __construct() {
        $this->ht_ctc_updatedb();
    }
    
    
    /**
     * update db - First
     * @since 3.2.2 ( intiall 3.0, later 3.2.2 moved form class-ht-ctc-db.php )
     */
    public function ht_ctc_updatedb() {

        $ht_ctc_plugin_details = get_option('ht_ctc_plugin_details');

        // only if already installed.
        if ( isset( $ht_ctc_plugin_details['version'] ) ) {

        $this->v3_3_3_update_woo();
        $this->v3_3_3_update_show_hide_chat();
        $this->v3_3_3_update_show_hide_group();
        $this->v3_3_3_update_show_hide_share();

        }


    }


    /**
     * Database updates.. 
     */


    /**
     * updating to v3.3.3 or above
     * 
     * chat
     */
    public function v3_3_3_update_show_hide_chat() {

        $options = get_option('ht_ctc_chat_options');

        // show/hide select settings value 2.0 to 3.3.2
        $show_or_hide = (isset($options['show_or_hide'])) ? esc_html($options['show_or_hide']) : '';

        $n = array();

        // desktop
        $n['display_desktop'] = 'show';
        if ( isset( $options['hideon_desktop'] ) ) {
            $n['display_desktop'] = 'hide';
        }

        // mobile
        $n['display_mobile'] = 'show';
        if ( isset( $options['hideon_mobile'] ) ) {
            $n['display_mobile'] = 'hide';
        }

        /**
         * show / hide
         * 
         * if its hide based on then default is hide and get only show settings and apply
         * if its show based on then default is show and get only hide settings and apply
         */

        $n['display']['show_hide'] = 'setting';

        if ( 'hide' == $show_or_hide ) {
            // default show on all pages (check: show settings)
            
            // new settings - select show
            $n['display']['global_display'] = 'show';

            // check if any hide settings added

            // posts
            if ( isset( $options['hideon_posts'] ) ) {
                $n['display']['posts'] = 'hide';
            }

            // pages
            if ( isset( $options['hideon_page'] ) ) {
                $n['display']['pages'] = 'hide';
            }

            // home page
            if ( isset( $options['hideon_homepage'] ) ) {
                $n['display']['home'] = 'hide';
            }

            // category
            if ( isset( $options['hideon_category'] ) ) {
                $n['display']['category'] = 'hide';
            }

            // archive
            if ( isset( $options['hideon_archive'] ) ) {
                $n['display']['archive'] = 'hide';
            }

            // 404
            if ( isset( $options['hideon_404'] ) ) {
                $n['display']['page_404'] = 'hide';
            }

            // woocommerce product pages
            if ( isset( $options['hideon_wooproduct'] ) ) {
                $n['display']['woo_product'] = 'hide';
            }

            // post id's
            if ( isset( $options['list_hideon_pages'] ) ) {
                $n['display']['list_hideon_pages'] = $options['list_hideon_pages'];
            }

            // category names
            if ( isset( $options['list_hideon_cat'] ) ) {
                $n['display']['list_hideon_cat'] = $options['list_hideon_cat'];
            }

        } elseif ( 'show' == $show_or_hide ) {
            
            // default hide on all pages (check: hide)

            // new settings - select hide
            $n['display']['global_display'] = 'hide';

            // check if any hide settings added

            // posts
            if ( isset( $options['showon_posts'] ) ) {
                $n['display']['posts'] = 'show';
            }

            // pages
            if ( isset( $options['showon_page'] ) ) {
                $n['display']['pages'] = 'show';
            }

            // home page
            if ( isset( $options['showon_homepage'] ) ) {
                $n['display']['home'] = 'show';
            }

            // category
            if ( isset( $options['showon_category'] ) ) {
                $n['display']['category'] = 'show';
            }

            // archive
            if ( isset( $options['showon_archive'] ) ) {
                $n['display']['archive'] = 'show';
            }

            // 404
            if ( isset( $options['showon_404'] ) ) {
                $n['display']['page_404'] = 'show';
            }

            // woocommerce product pages
            if ( isset( $options['showon_wooproduct'] ) ) {
                $n['display']['woo_product'] = 'show';
            }

            // post id's
            if ( isset( $options['list_showon_pages'] ) ) {
                $n['display']['list_showon_pages'] = $options['list_showon_pages'];
            }

            // category names
            if ( isset( $options['list_showon_cat'] ) ) {
                $n['display']['list_showon_cat'] = $options['list_showon_cat'];
            }

        }

        $db_values = get_option( 'ht_ctc_chat_options', array() );
        $update_os = array_merge($n, $db_values);
        update_option('ht_ctc_chat_options', $update_os);

    }


    /**
     * updating to v3.3.3 or above
     * 
     * group
     */
    public function v3_3_3_update_show_hide_group() {

        $options = get_option('ht_ctc_group');

        // show/hide select settings value 2.0 to 3.3.2
        $show_or_hide = (isset($options['show_or_hide'])) ? esc_html($options['show_or_hide']) : '';

        $n = array();

        // desktop
        $n['display_desktop'] = 'show';
        if ( isset( $options['hideon_desktop'] ) ) {
            $n['display_desktop'] = 'hide';
        }

        // mobile
        $n['display_mobile'] = 'show';
        if ( isset( $options['hideon_mobile'] ) ) {
            $n['display_mobile'] = 'hide';
        }

        /**
         * show / hide
         * 
         * if its hide based on then default is hide and get only show settings and apply
         * if its show based on then default is show and get only hide settings and apply
         */

        $n['display']['show_hide'] = 'setting';

        if ( 'hide' == $show_or_hide ) {
            // default show on all pages (check: show settings)
            
            // new settings - select show
            $n['display']['global_display'] = 'show';

            // check if any hide settings added

            // posts
            if ( isset( $options['hideon_posts'] ) ) {
                $n['display']['posts'] = 'hide';
            }

            // pages
            if ( isset( $options['hideon_page'] ) ) {
                $n['display']['pages'] = 'hide';
            }

            // home page
            if ( isset( $options['hideon_homepage'] ) ) {
                $n['display']['home'] = 'hide';
            }

            // category
            if ( isset( $options['hideon_category'] ) ) {
                $n['display']['category'] = 'hide';
            }

            // archive
            if ( isset( $options['hideon_archive'] ) ) {
                $n['display']['archive'] = 'hide';
            }

            // 404
            if ( isset( $options['hideon_404'] ) ) {
                $n['display']['page_404'] = 'hide';
            }

            // woocommerce product pages
            if ( isset( $options['hideon_wooproduct'] ) ) {
                $n['display']['woo_product'] = 'hide';
            }

            // post id's
            if ( isset( $options['list_hideon_pages'] ) ) {
                $n['display']['list_hideon_pages'] = $options['list_hideon_pages'];
            }

            // category names
            if ( isset( $options['list_hideon_cat'] ) ) {
                $n['display']['list_hideon_cat'] = $options['list_hideon_cat'];
            }

        } elseif ( 'show' == $show_or_hide ) {
            
            // default hide on all pages (check: hide)

            // new settings - select hide
            $n['display']['global_display'] = 'hide';

            // check if any hide settings added

            // posts
            if ( isset( $options['showon_posts'] ) ) {
                $n['display']['posts'] = 'show';
            }

            // pages
            if ( isset( $options['showon_page'] ) ) {
                $n['display']['pages'] = 'show';
            }

            // home page
            if ( isset( $options['showon_homepage'] ) ) {
                $n['display']['home'] = 'show';
            }

            // category
            if ( isset( $options['showon_category'] ) ) {
                $n['display']['category'] = 'show';
            }

            // archive
            if ( isset( $options['showon_archive'] ) ) {
                $n['display']['archive'] = 'show';
            }

            // 404
            if ( isset( $options['showon_404'] ) ) {
                $n['display']['page_404'] = 'show';
            }

            // woocommerce product pages
            if ( isset( $options['showon_wooproduct'] ) ) {
                $n['display']['woo_product'] = 'show';
            }

            // post id's
            if ( isset( $options['list_showon_pages'] ) ) {
                $n['display']['list_showon_pages'] = $options['list_showon_pages'];
            }

            // category names
            if ( isset( $options['list_showon_cat'] ) ) {
                $n['display']['list_showon_cat'] = $options['list_showon_cat'];
            }

        }

        $db_values = get_option( 'ht_ctc_group', array() );
        $update_os = array_merge($n, $db_values);
        update_option('ht_ctc_group', $update_os);

    }


    /**
     * updating to v3.3.3 or above
     * 
     * share
     */
    public function v3_3_3_update_show_hide_share() {

        $options = get_option('ht_ctc_share');

        // show/hide select settings value 2.0 to 3.3.2
        $show_or_hide = (isset($options['show_or_hide'])) ? esc_html($options['show_or_hide']) : '';

        $n = array();

        // desktop
        $n['display_desktop'] = 'show';
        if ( isset( $options['hideon_desktop'] ) ) {
            $n['display_desktop'] = 'hide';
        }

        // mobile
        $n['display_mobile'] = 'show';
        if ( isset( $options['hideon_mobile'] ) ) {
            $n['display_mobile'] = 'hide';
        }

        /**
         * show / hide
         * 
         * if its hide based on then default is hide and get only show settings and apply
         * if its show based on then default is show and get only hide settings and apply
         */

        $n['display']['show_hide'] = 'setting';

        if ( 'hide' == $show_or_hide ) {
            // default show on all pages (check: show settings)
            
            // new settings - select show
            $n['display']['global_display'] = 'show';

            // check if any hide settings added

            // posts
            if ( isset( $options['hideon_posts'] ) ) {
                $n['display']['posts'] = 'hide';
            }

            // pages
            if ( isset( $options['hideon_page'] ) ) {
                $n['display']['pages'] = 'hide';
            }

            // home page
            if ( isset( $options['hideon_homepage'] ) ) {
                $n['display']['home'] = 'hide';
            }

            // category
            if ( isset( $options['hideon_category'] ) ) {
                $n['display']['category'] = 'hide';
            }

            // archive
            if ( isset( $options['hideon_archive'] ) ) {
                $n['display']['archive'] = 'hide';
            }

            // 404
            if ( isset( $options['hideon_404'] ) ) {
                $n['display']['page_404'] = 'hide';
            }

            // woocommerce product pages
            if ( isset( $options['hideon_wooproduct'] ) ) {
                $n['display']['woo_product'] = 'hide';
            }

            // post id's
            if ( isset( $options['list_hideon_pages'] ) ) {
                $n['display']['list_hideon_pages'] = $options['list_hideon_pages'];
            }

            // category names
            if ( isset( $options['list_hideon_cat'] ) ) {
                $n['display']['list_hideon_cat'] = $options['list_hideon_cat'];
            }

        } elseif ( 'show' == $show_or_hide ) {
            
            // default hide on all pages (check: hide)

            // new settings - select hide
            $n['display']['global_display'] = 'hide';

            // check if any hide settings added

            // posts
            if ( isset( $options['showon_posts'] ) ) {
                $n['display']['posts'] = 'show';
            }

            // pages
            if ( isset( $options['showon_page'] ) ) {
                $n['display']['pages'] = 'show';
            }

            // home page
            if ( isset( $options['showon_homepage'] ) ) {
                $n['display']['home'] = 'show';
            }

            // category
            if ( isset( $options['showon_category'] ) ) {
                $n['display']['category'] = 'show';
            }

            // archive
            if ( isset( $options['showon_archive'] ) ) {
                $n['display']['archive'] = 'show';
            }

            // 404
            if ( isset( $options['showon_404'] ) ) {
                $n['display']['page_404'] = 'show';
            }

            // woocommerce product pages
            if ( isset( $options['showon_wooproduct'] ) ) {
                $n['display']['woo_product'] = 'show';
            }

            // post id's
            if ( isset( $options['list_showon_pages'] ) ) {
                $n['display']['list_showon_pages'] = $options['list_showon_pages'];
            }

            // category names
            if ( isset( $options['list_showon_cat'] ) ) {
                $n['display']['list_showon_cat'] = $options['list_showon_cat'];
            }

        }

        $db_values = get_option( 'ht_ctc_share', array() );
        $update_os = array_merge($n, $db_values);
        update_option('ht_ctc_share', $update_os);

    }


    /**
     * updating to v3.3.3 or above
     *  - woocommerce option changed from ht_ctc_chat_options settings to ht_ctc_woo_options
     * 
     * chat
     */
    public function v3_3_3_update_woo() {

        $options = get_option('ht_ctc_woo_options');

        $chat = get_option('ht_ctc_chat_options');


        $woo = array(
            'woo' => 'settings',
        );
        
        if ( isset($chat['woo_pre_filled']) ) {
            $woo['woo_pre_filled'] = $chat['woo_pre_filled'];
        }
        if ( isset($chat['woo_call_to_action']) ) {
            $woo['woo_call_to_action'] = $chat['woo_call_to_action'];
        }

        $db_woo = get_option( 'ht_ctc_woo_options', array() );
        $update_os = array_merge($woo, $db_woo);
        update_option('ht_ctc_woo_options', $update_os);
    }


}

new HT_CTC_Update_DB_Backup();

endif; // END class_exists check