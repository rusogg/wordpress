<?php
/**
 * Default Values
 * 
 *  set the default values
 *  which stores in database options table
 *
 * @package ctc
 * @since 2.0
 * @from ht-ccw-register.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_DB' ) ) :

class HT_CTC_DB {


    public $os = '';

    public function __construct() {
        $this->db();
    }
    
    
    /**
     * based on condition.. update the db .. 
     *
     */
    public function db() {
       
        $this->os = array();
        $ht_ctc_plugin_details = get_option('ht_ctc_plugin_details');

        if ( is_array($ht_ctc_plugin_details) ) {
            $this->os = $ht_ctc_plugin_details;
        }

        // only if already installed - then only call db updater
        if ( isset( $ht_ctc_plugin_details['version'] ) ) {
            // @since 3.2.2
            include_once HT_CTC_PLUGIN_DIR .'/new/admin/db/class-ht-ctc-update-db.php';
        }


        $this->ht_ctc_othersettings();
        $this->ht_ctc_chat_options();
        $this->ht_ctc_s2();
        $this->ht_ctc_plugin_details();
        // $this->ht_ctc_one_time();

    }

    
    /**
     * table name: "ht_ctc_othersettings"
     * 
     * other settings 
     * 
     * checkboxes .. 
     *  select_styles_issue
     *  enable_group  enable_group chat
     *  enable_share  enable_share
     *  google_analytics
     *  fb_pixel
     *  ga_ads
     *  delete options on plugin uninstall
     * 
     */
    public function ht_ctc_othersettings() {
        
        $values = array(
            'an_type' => 'no-animation',
            'an_delay' => '0',
            'an_itr' => '1',
            'show_effect' => 'no-show-effects',
            'amp' => '1',
        );

        // enable by default for new installs. 
        if ( !isset ( $this->os['version'] ) ) {
            $values['google_analytics'] = '1';
            $values['fb_pixel'] = '1';
            $values['show_effect'] = 'From Corner';
        }

        $db_values = get_option( 'ht_ctc_othersettings', array() );
        $update_values = array_merge($values, $db_values);
        update_option('ht_ctc_othersettings', $update_values);

    }





    /**
     * table name: "ht_ctc_chat_options"
     * 
     * Chat options, main page .. some feature enable options .. 
     * 
     * checkboxes .. 
     *  hide/show options .. 
     *  same_settings - desktop, mobile same settings. i.e. apply dekstop setting to mobile - since v3.3.3 for new users auto checks
     *  
     *  webandapi  if checked ? web/api.whatsapp(mobile,desktop) : wa.me
     * 
     * @since 3.2.7 - cc, num - better user interface to add number
     * 
     */
    public function ht_ctc_chat_options() {
        
        $values = array(
            'cc' => '',
            'num' => '',
            'number' => '',
            'pre_filled' => '',
            'call_to_action' => 'WhatsApp us',
            'style_desktop' => '2',
            'style_mobile' => '2',

            'side_1' => 'bottom',
            'side_1_value' => '15px',
            'side_2' => 'right',
            'side_2_value' => '15px',

            // 'show_or_hide' => 'hide',
            'list_hideon_pages' => '',
            'list_hideon_cat' => '',
            'list_showon_pages' => '',
            'list_showon_cat' => '',

        );

        $options = get_option('ht_ctc_chat_options');
        // mobile position if not set
        if ( !isset($options['mobile_side_1_value']) && !isset($options['mobile_side_2_value'])  ) {
            $mobile_values = array(
                'mobile_side_1' => ( isset( $options['side_1']) ) ? esc_attr( $options['side_1'] ) : 'bottom',
                'mobile_side_1_value' => ( isset( $options['side_1_value'])) ? esc_attr( $options['side_1_value'] ) : '10px',
                'mobile_side_2' => ( isset( $options['side_2']) ) ? esc_attr( $options['side_2'] ) : 'right',
                'mobile_side_2_value' => ( isset( $options['side_2_value'])) ? esc_attr( $options['side_2_value'] ) : '10px',
            );
            $values = array_merge($values, $mobile_values);
        }

        // for new installs. 
        if ( !isset ( $this->os['version'] ) ) {
            $values['same_settings'] = '1';
            $values['display_desktop'] = 'show';
            $values['display_mobile'] = 'show';
            $values['display']['global_display'] = 'show';
        }

        $db_values = get_option( 'ht_ctc_chat_options', array() );
        $update_values = array_merge($values, $db_values);
        update_option('ht_ctc_chat_options', $update_values);

    }


    // styles

    /**
     * name: ht_ctc_s2
     * 
     * Style-2
     * green square icon
     * 
     * cta_type - hover only, show, hide - if new install dispaly on hover.
     */
    public function ht_ctc_s2() {
        
        $style_2 = array(
            
            's2_img_size' => '50px',
            'cta_textcolor' => '#ffffff',
            'cta_bgcolor' => '#25D366',
            
        );

        // new install
        if ( !isset ( $this->os['version'] ) ) {
            $style_2['cta_type'] = 'hover';
            $style_2['cta_font_size'] = '15px';
        } else {
            $style_2['cta_type'] = 'hide';
        }

        $db_values = get_option( 'ht_ctc_s2', array() );
        $update_values = array_merge($style_2, $db_values);
        update_option('ht_ctc_s2', $update_values);

    }



    /**
     * name: ht_ctc_plugin_details
     * 
     * Add plugin Details to db 
     * Add plugin version to db - useful for upgrading db - class-ht-ctc-update-db.php
     *      update version value for each update. 
     * 
     * first_install_time @since v3.7 ( if installed before v3.7 first_install_time will be the first plugin version upgrade time of v3.7 or + )
     * v3, v3_2_5, v3_3_3, v3_3_5 - values changed to time @since v3.7
     */
    public function ht_ctc_plugin_details() {

        $time = time();

        // plugin details 
        $values = array(
            'version' => HT_CTC_VERSION,
            'first_install_time' => $time,
            'v3' => $time,
            'v3_2_5' => $time,
            'v3_3_3' => $time,
            'v3_3_5' => $time,
            'v3_7' => $time,
            'v3_8' => $time,
        );

        $db_values = get_option( 'ht_ctc_plugin_details', array() );
        
        // extra safe instead of directly merge.
        $update_values = $values;
        if (is_array($db_values)) {
            $update_values = array_merge($values, $db_values);
        }

        /**
         * IMP: have to update version number.. 
         * (always use the latest value)
         */
        $update_values['version'] = HT_CTC_VERSION;

        update_option( 'ht_ctc_plugin_details', $update_values );
    }




}

new HT_CTC_DB();

endif; // END class_exists check