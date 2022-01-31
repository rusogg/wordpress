<?php
/**
 * When plugin upgrades
 * 
 * update the db values to compatibile with in versions
 *
 * @package ctc
 * @since 3.2.2
 * @from ht-ctc-db.php -> db()
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Update_DB' ) ) :

class HT_CTC_Update_DB {


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

            // v3: if not yet updated to v3 or above  (in v3 $ht_ctc_plugin_details['v3'] is not added)
            if ( ! isset( $ht_ctc_plugin_details['v3'] ) ) {
                $this->v3_update();
            }

            // v3.3.3: if not yet updated to v3.3.3 or above  (in v3 $ht_ctc_plugin_details['v3_3_3'] is not added)
            if ( ! isset( $ht_ctc_plugin_details['v3_3_3'] ) ) {
                $this->v3_3_3_update_woo();
                $this->v3_3_3_update_show_hide_chat();
                $this->v3_3_3_update_show_hide_group();
                $this->v3_3_3_update_show_hide_share();
            }

            // v3.3.5: if not yet updated to v3.3.5 or above  (in v3.3.5 $ht_ctc_plugin_details['v3_3_5'] is not added)
            if ( ! isset( $ht_ctc_plugin_details['v3_3_5'] ) ) {
                $this->v3_3_5_update();
            }


        }


    }


    /**
     * Database updates.. 
     */

    

    /**
     * updating to v3.3.3 or above
     * 
     * select styles issue checkbox  move from other styles to its c/g/s
     * 
     * @note: merge this function in the next db update. as only one value..
     *      @imp - if merging - here 'return' is used if not set. need to update this.. 
     */
    public function v3_3_5_update() {

        $os = get_option('ht_ctc_othersettings');

        if ( ! isset( $os['select_styles_issue'] ) ) {
            return;
        }

        $n = array();
        $n['select_styles_issue'] = '1';
        
        $chat = get_option( 'ht_ctc_chat_options', array() );
        $update_chat = array_merge($n, $chat);
        update_option('ht_ctc_chat_options', $update_chat);

        $group = get_option( 'ht_ctc_group', array() );
        $update_group = array_merge($n, $group);
        update_option('ht_ctc_group', $update_chat);

        $share = get_option( 'ht_ctc_share', array() );
        $update_share = array_merge($n, $share);
        update_option('ht_ctc_share', $update_chat);

    }





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

    /**
     * updating to v3 or above. 
     *  - style 3 Extend to Style-3_1 
     *  - analytics, .. switch to other settings..
     */
    public function v3_update() {

        $ht_ctc_othersettings = get_option('ht_ctc_othersettings');
        $ht_ctc_s3 = get_option('ht_ctc_s3');
        
        // ht_ctc_main_options to ht_ctc_othersettings
        $ht_ctc_main_options = get_option('ht_ctc_main_options');

        if ( $ht_ctc_main_options ) {

            $os = array(
                'hello' => 'world',
            );
            
            if ( isset ( $ht_ctc_main_options['google_analytics'] ) ) {
                $os['google_analytics'] = '1';
            }
            if ( isset ( $ht_ctc_main_options['fb_pixel'] ) ) {
                $os['fb_pixel'] = '1';
            }
            if ( isset ( $ht_ctc_main_options['enable_group'] ) ) {
                $os['enable_group'] = '1';
            }
            if ( isset ( $ht_ctc_main_options['enable_share'] ) ) {
                $os['enable_share'] = '1';
            }

            $db_os = get_option( 'ht_ctc_othersettings', array() );
            $update_os = array_merge($os, $db_os);
            update_option('ht_ctc_othersettings', $update_os);

            // delete ht_ctc_main_options settings, as transfered to other settings
            delete_option( 'ht_ctc_main_options' );
        }
        

        // style-3 type extend is selected.. and if style 3 to 3_1
        if ( isset($ht_ctc_s3['s3_type']) && 'extend' == $ht_ctc_s3['s3_type'] ) {

            $ht_ctc_chat_options = get_option('ht_ctc_chat_options');
            $ht_ctc_group = get_option('ht_ctc_group');
            $ht_ctc_share = get_option('ht_ctc_share');
            
            // this works as s3 type extend came later version of select style dekstop, mobile.
            // chat
            if ( isset($ht_ctc_chat_options['style_desktop']) && isset($ht_ctc_chat_options['style_mobile']) ) {
                if ( '3' == $ht_ctc_chat_options['style_desktop']) {
                    $ht_ctc_chat_options['style_desktop'] = '3_1';
                }
                if ( '3' == $ht_ctc_chat_options['style_mobile']) {
                    $ht_ctc_chat_options['style_mobile'] = '3_1';
                }
                update_option( 'ht_ctc_chat_options', $ht_ctc_chat_options);
            }

            // group
            if (isset($ht_ctc_group['style_desktop'])) {
                if ( '3' == $ht_ctc_group['style_desktop']) {
                    $ht_ctc_group['style_desktop'] = '3_1';
                }
                if ( '3' == $ht_ctc_group['style_mobile']) {
                    $ht_ctc_group['style_mobile'] = '3_1';
                }
                update_option( 'ht_ctc_group', $ht_ctc_group);
            }

            // share
            if (isset($ht_ctc_share['style_desktop'])) {
                if ( '3' == $ht_ctc_share['style_desktop']) {
                    $ht_ctc_share['style_desktop'] = '3_1';
                }
                if ( '3' == $ht_ctc_share['style_mobile']) {
                    $ht_ctc_share['style_mobile'] = '3_1';
                }
                update_option( 'ht_ctc_share', $ht_ctc_share);
            }

        }

    }







}

new HT_CTC_Update_DB();

endif; // END class_exists check