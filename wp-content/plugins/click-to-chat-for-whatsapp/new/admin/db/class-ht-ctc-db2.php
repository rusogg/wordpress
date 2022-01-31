<?php
/**
 * Default Values
 * 
 *  set the default values
 *  which stores in database options table
 *
 * @package ctc
 * @since 2.0
 * @from class-ht-ctc-register.php -> version_changed() - when version changes
 * @from class-ht-ctc-admin-hooks.php -> ctc_admin_pages() - calls for ctc admin pages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_DB2' ) ) :

class HT_CTC_DB2 {


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


        $this->ht_ctc_group();
        $this->ht_ctc_share();

        // woocommerce
        $this->ht_ctc_woo_options();

        $this->ht_ctc_s1();
        
        // s2 at ht-ctc-db.php
        // $this->ht_ctc_s2();

        $this->ht_ctc_s3();
        $this->ht_ctc_s3_1();
        $this->ht_ctc_s4();
        $this->ht_ctc_s5();
        $this->ht_ctc_s6();
        $this->ht_ctc_s7();
        $this->ht_ctc_s7_1();
        $this->ht_ctc_s8();
        $this->ht_ctc_s99();

        $this->ht_ctc_one_time();

        
    }

    

    /**
     * table name: "ht_ctc_group"
     * 
     * Group chat
     */
    public function ht_ctc_group() {

        $values = array(

            'group_id' => '',
            'call_to_action' => 'WhatsApp Group',
            
            'style_desktop' => '4',
            'style_mobile' => '2',

            'side_1' => 'bottom',
            'side_1_value' => '10px',
            'side_2' => 'left',
            'side_2_value' => '10px',

            'show_or_hide' => 'hide',
            'list_hideon_pages' => '',
            'list_hideon_cat' => '',
            'list_showon_pages' => '',
            'list_showon_cat' => '',

        );

        $options = get_option('ht_ctc_group');
        // mobile position if not set
        if ( !isset($options['mobile_side_1_value']) && !isset($options['mobile_side_2_value'])  ) {
            $mobile_values = array(
                'mobile_side_1' => ( isset( $options['side_1']) ) ? esc_attr( $options['side_1'] ) : 'bottom',
                'mobile_side_1_value' => ( isset( $options['side_1_value'])) ? esc_attr( $options['side_1_value'] ) : '10px',
                'mobile_side_2' => ( isset( $options['side_2']) ) ? esc_attr( $options['side_2'] ) : 'left',
                'mobile_side_2_value' => ( isset( $options['side_2_value'])) ? esc_attr( $options['side_2_value'] ) : '10px',
            );
            $values = array_merge($values, $mobile_values);
        }

        // new install
        if ( !isset ( $this->os['version'] ) ) {
            $values['same_settings'] = '1';
            $values['display_desktop'] = 'show';
            $values['display_mobile'] = 'show';
            $values['display']['global_display'] = 'show';
        }


        $db_values = get_option( 'ht_ctc_group', array() );
        $update_values = array_merge($values, $db_values);
        update_option('ht_ctc_group', $update_values);
    }


    
    /**
     * table name: "ht_ctc_share"
     * 
     * share chat
     * 
     * checkboxes
     *  webandapi
     *  show/hide ..
     */
    public function ht_ctc_share() {

        $values = array(

            'share_text' => 'Checkout this Awesome page {{url}}',
            'call_to_action' => 'WhatsApp Share',
            
            'style_desktop' => '1',
            'style_mobile' => '2',

            'side_1' => 'top',
            'side_1_value' => '10px',
            'side_2' => 'right',
            'side_2_value' => '10px',

            'show_or_hide' => 'hide',
            'list_hideon_pages' => '',
            'list_hideon_cat' => '',
            'list_showon_pages' => '',
            'list_showon_cat' => '',
        );

        $options = get_option('ht_ctc_share');
        // mobile position if not set
        if ( !isset($options['mobile_side_1_value']) && !isset($options['mobile_side_2_value'])  ) {
            $mobile_values = array(
                'mobile_side_1' => ( isset( $options['side_1']) ) ? esc_attr( $options['side_1'] ) : 'top',
                'mobile_side_1_value' => ( isset( $options['side_1_value'])) ? esc_attr( $options['side_1_value'] ) : '10px',
                'mobile_side_2' => ( isset( $options['side_2']) ) ? esc_attr( $options['side_2'] ) : 'right',
                'mobile_side_2_value' => ( isset( $options['side_2_value'])) ? esc_attr( $options['side_2_value'] ) : '10px',
            );
            $values = array_merge($values, $mobile_values);
        }

        // new install
        if ( !isset ( $this->os['version'] ) ) {
            $values['same_settings'] = '1';
            $values['display_desktop'] = 'show';
            $values['display_mobile'] = 'show';
            $values['display']['global_display'] = 'show';
        }

        $db_values = get_option( 'ht_ctc_share', array() );
        $update_values = array_merge($values, $db_values);
        update_option('ht_ctc_share', $update_values);
    }


    /**
     * table name: "ht_ctc_woo_options"
     * 
     * woocommerce 
     *  @var woo_is_single - checkbox - if checked display flaoting style on woo single product pages
     */
    public function ht_ctc_woo_options() {

        $values = array(

            'woo_pre_filled' => '',
            'woo_call_to_action' => '',
        );

        $db_values = get_option( 'ht_ctc_woo_options', array() );
        $update_values = array_merge($values, $db_values);
        update_option('ht_ctc_woo_options', $update_values);
    }

    

    // styles



    /**
     * name: ht_ctc_s1
     * 
     * Style-1  
     * style-1 is default button
     * 
     * checkbox
     *  s1_m_fullwidth
     */
    public function ht_ctc_s1() {
        
        $style_1 = array(

            's1_text_color' => '',
            's1_bg_color' => '',
            's1_icon_color' => '',
            's1_icon_size' => '16',
            
        );

        $db_values = get_option( 'ht_ctc_s1', array() );
        $update_values = array_merge($style_1, $db_values);
        update_option('ht_ctc_s1', $update_values);

    }






    /**
     * name: ht_ctc_s2
     * 
     * Style-2
     * green square icon
     * 
     * cta_type - hover only, show, hide - if new install dispaly on hover.
     */
    // public function ht_ctc_s2() {
        
    //     $style_2 = array(
            
    //         's2_img_size' => '50px',
    //         'cta_textcolor' => '#ffffff',
    //         'cta_bgcolor' => '#25D366',
            
    //     );

    //     // new install
    //     if ( !isset ( $this->os['version'] ) ) {
    //         $style_2['cta_type'] = 'hover';
    //         $style_2['cta_font_size'] = '15px';
    //     } else {
    //         $style_2['cta_type'] = 'hide';
    //     }

    //     $db_values = get_option( 'ht_ctc_s2', array() );
    //     $update_values = array_merge($style_2, $db_values);
    //     update_option('ht_ctc_s2', $update_values);

    // }


    /**
     * name: ht_ctc_s3
     * 
     * s3_type - simple / extend
     *  simple - only image size setting.
     * 
     * Style-3
     * icon
     */
    public function ht_ctc_s3() {
        
        $style_3 = array(

            's3_img_size' => '50px',
            'cta_textcolor' => '#ffffff',
            'cta_bgcolor' => '#25d366',
            
        );

        // @since 3.0 cta
        if ( !isset ( $this->os['version'] ) ) {
            $style_3['cta_type'] = 'hover';
            $style_3['cta_font_size'] = '13px';
        } else {
            $style_3['cta_type'] = 'hide';
        }


        // type: extend is moving to Style-3_1 Extend
        $s3 = get_option('ht_ctc_s3');
        $s3_1 = get_option('ht_ctc_s3_1');
        // if 3_1 not yet created - run only once.
        if ( !isset($s3_1['s3_1_img_size']) ) {
            // if type: extend 
            if ( isset($s3['s3_type']) && 'extend' == $s3['s3_type'] ) {
                // then add table s3_1 with s3 values
                update_option('ht_ctc_s3_1', $s3);
            }
        }

        $db_values = get_option( 'ht_ctc_s3', array() );
        $update_values = array_merge($style_3, $db_values);
        update_option('ht_ctc_s3', $update_values);

    }



    /**
     * name: ht_ctc_s3_1
     * 
     * Style-3 Extend
     * 
     * icon
     * @since 3.0 (in v2.11 s3 type extend created and since 3.0 created as a new style 3_1 i.e. s3 Extend)
     */
    public function ht_ctc_s3_1() {
        
        $style_3_1 = array(

            's3_img_size' => '40px',
            's3_bg_color' => '#25D366',
            's3_bg_color_hover' => '#25D366',
            's3_padding' => '14px',
            's3_box_shadow' => '1',
            's3_box_shadow_hover' => '1',
            'cta_type' => 'hide',
            'cta_textcolor' => '#ffffff',
            'cta_bgcolor' => '#25d366',
            
        );

        // new install
        if ( !isset ( $this->os['version'] ) ) {
            $style_3_1['cta_type'] = 'hover';
            $style_3_1['cta_font_size'] = '15px';
        }

        $db_values = get_option( 'ht_ctc_s3_1', array() );
        $update_values = array_merge($style_3_1, $db_values);
        update_option('ht_ctc_s3_1', $update_values);

    }



    /**
     * name: ht_ctc_s4
     * 
     * Style-4
     * chip
     */
    public function ht_ctc_s4() {

        $style_4 = array(

            's4_text_color' => '#7f7d7d',
            's4_bg_color' => '#e4e4e4',
            's4_img_url' => '',
            's4_img_position' => 'left',
            's4_img_size' => '32px',
        );

        $db_values = get_option( 'ht_ctc_s4', array() );
        $update_values = array_merge($style_4, $db_values);
        update_option('ht_ctc_s4', $update_values);

    }



    /**
     * name: ht_ctc_s5
     * 
     * Style-5
     * chip
     */
    public function ht_ctc_s5() {
        
        $style_5 = array(

            's5_line_1' => '',
            's5_line_2' => 'We will respond as soon as possible',
            's5_line_1_color' => '#000000',
            's5_line_2_color' => '#000000',
            's5_background_color' => '#ffffff',
            's5_border_color' => '#dddddd',
            's5_img' => '',
            's5_img_height' => '70px',
            's5_img_width' => '70px',
            's5_content_height' => '70px',
            's5_content_width' => '270px',
            's5_img_position' => 'right',  // left means nothing - right means - order: 1
            
        );

        $db_values = get_option( 'ht_ctc_s5', array() );
        $update_values = array_merge($style_5, $db_values);
        update_option('ht_ctc_s5', $update_values);

    }


    /**
     * name: ht_ctc_s6
     * 
     * Style-6
     * 
     * #006ccc
     * #0073aa
     * #005177
     */
    public function ht_ctc_s6() {
        
        $style_6 = array(

            's6_txt_color' => '',
            's6_txt_color_on_hover' => '',
            's6_txt_decoration' => '',
            's6_txt_decoration_on_hover' => '',
            
        );

        $db_values = get_option( 'ht_ctc_s6', array() );
        $update_values = array_merge($style_6, $db_values);
        update_option('ht_ctc_s6', $update_values);

    }


    /**
     * name: ht_ctc_s7
     * 
     * Style-7
     * 
     * border is padding
     * hover idea - icon #6b6b6b, #262626, #455a64,   #f9f9f9, #00d34d
     * hover idea - icon, border  #f9f9f9/#f4f4f4, #00d34d
     */
    public function ht_ctc_s7() {
        
        $style_7 = array(

            's7_icon_size' => '20px',
            's7_icon_color' => '#ffffff',
            's7_icon_color_hover' => '#f4f4f4',
            's7_border_size' => '12px',
            's7_border_color' => '#25D366',
            's7_border_color_hover' => '#25d366',
            's7_border_radius' => '50%',
            'cta_type' => 'hide',
            'cta_textcolor' => '#ffffff',
            'cta_bgcolor' => '#25d366',
        );

        // if new install
        if ( !isset ( $this->os['version'] ) ) {
            $style_7['cta_type'] = 'hover';
        }

        $db_values = get_option( 'ht_ctc_s7', array() );
        $update_values = array_merge($style_7, $db_values);
        update_option('ht_ctc_s7', $update_values);

    }


    /**
     * name: ht_ctc_s7_1
     * 
     * Style-7_1
     * 
     * border is padding
     * hover idea - icon #6b6b6b, #262626, #455a64,   #f9f9f9, #00d34d
     * hover idea - icon, border  #f9f9f9/#f4f4f4, #00d34d
     * 
     * cta_type - show / hover (hover is expand)
     */
    public function ht_ctc_s7_1() {
        
        $style_7_1 = array(

            's7_icon_size' => '20px',
            's7_icon_color' => '#ffffff',
            's7_icon_color_hover' => '#f4f4f4',
            's7_border_size' => '12px',
            's7_bgcolor' => '#25D366',
            's7_bgcolor_hover' => '#00d34d',
            'cta_type' => 'hover',
        );

        $db_values = get_option( 'ht_ctc_s7_1', array() );
        $update_values = array_merge($style_7_1, $db_values);
        update_option('ht_ctc_s7_1', $update_values);

    }



    /**
     * name: ht_ctc_s8
     * 
     * Style-8
     * 
     * s8_btn_size: btn / btn-large
     * 
     * checkbox
     *  s8_m_fullwidth
     */
    public function ht_ctc_s8() {
        
        $style_8 = array(

            's8_txt_color' => '#ffffff',
            's8_txt_color_on_hover' => '#ffffff',
            's8_bg_color' => '#26a69a',
            's8_bg_color_on_hover' => '#26a69a',
            's8_icon_color' => '#ffffff',
            's8_icon_color_on_hover' => '#ffffff',
            's8_icon_position' => 'left',
            's8_text_size' => '',
            's8_icon_size' => '',
            's8_btn_size' => 'btn',
            
        );

        // if new install
        if ( !isset ( $this->os['version'] ) ) {
            $style_8['s8_text_size'] = '16px';
            $style_8['s8_icon_size'] = '16px';
        }

        $db_values = get_option( 'ht_ctc_s8', array() );
        $update_values = array_merge($style_8, $db_values);
        update_option('ht_ctc_s8', $update_values);

    }


    /**
     * name: ht_ctc_s99
     * 
     * Style-99
     */
    public function ht_ctc_s99() {
        
        $style_99 = array(

            's99_dekstop_img_url' => '',
            's99_mobile_img_url' => '',
            's99_desktop_img_height' => '50px',
            's99_desktop_img_width' => '',
            's99_mobile_img_height' => '50px',
            's99_mobile_img_width' => '',
            
        );

        $db_values = get_option( 'ht_ctc_s99', array() );
        $update_values = array_merge($style_99, $db_values);
        update_option('ht_ctc_s99', $update_values);

    }

    /**
     * name: ht_ctc_one_time 
     * 
     * ***** caution ***** 
     * when using this values always check if exists.. 
     *  as some new values may add in other versions.. 
     *  and thoose values may not exists if this option is added before 
     *  ( it add_option not update_option )
     * 
     * dont update values. .. one time values .. 
     * 
     * first_version - first version installed
     * 
     * Add plugin Details to db 
     * Add plugin version to db - useful while updating plugin
     * 
     * @since 3.7
     * first_install_time - as add_option, first_install_time avaible only since 3.7
     *  if no first_install_time - then installed before v3.7 (as this options will save using add_option)
     */
    public function ht_ctc_one_time() {

        $time = time();

        // plugin details 
        $values = array(
            'first_version' => HT_CTC_VERSION,
            'first_install_time' => $time
        );

        // dont update values. .. one time values .. 
        add_option( 'ht_ctc_one_time', $values );
    }



}

new HT_CTC_DB2();

endif; // END class_exists check