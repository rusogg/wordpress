<?php
/**
 * Customize Styles  ( cs )
 * 
 * @package Admin
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Customize_Styles' ) ) :

class HT_CTC_Admin_Customize_Styles {

    public $display_all_styles_checkbox = 'show';
    
    // public function __construct() {
    //     // $this->this_variables();
    // }
    
    public function menu() {

        add_submenu_page(
            'click-to-chat',
            'Customize',
            'Customize',
            'manage_options',
            'click-to-chat-customize-styles',
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
                        <?php settings_fields( 'ht_ctc_cs_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_cs_page_settings_sections_do' ) ?>
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

        $ht_ctc_othersettings = get_option('ht_ctc_othersettings');
        $ht_ctc_chat = get_option('ht_ctc_chat_options');
        $ht_ctc_cs = get_option('ht_ctc_cs_options');

        // @uses for register_setting, add_settings_field
        $styles_list = [
            'ht_ctc_s1',
            'ht_ctc_s2',
            'ht_ctc_s3',
            'ht_ctc_s3_1',
            'ht_ctc_s4',
            'ht_ctc_s5',
            'ht_ctc_s6',
            'ht_ctc_s7',
            'ht_ctc_s7_1',
            'ht_ctc_s8',
            'ht_ctc_s99'
        ];


        // 
        /**
         * Display all - if group or share enabled or display_allstyles option is checked.
         */
        if ( isset($ht_ctc_othersettings['enable_group']) || isset($ht_ctc_othersettings['enable_share']) ) {
            // load all styles
            $this->display_all_styles_checkbox = 'hide';

        } else {
            // only chat enabled.

            // display_allstyles option is checked.
            if ( !isset( $ht_ctc_cs['display_allstyles'] ) ) {

                $style_d = (isset($ht_ctc_chat['style_desktop'])) ? esc_attr($ht_ctc_chat['style_desktop']) : '';
                $style_m = (isset($ht_ctc_chat['style_mobile'])) ? esc_attr($ht_ctc_chat['style_mobile']) : '';

                // $styles_list redefined..
                $styles_list = [];

                if ( '' !== $style_d ) {
                    array_push($styles_list, "ht_ctc_s$style_d");
                }

                if ( !isset($ht_ctc_chat['same_settings']) && '' !== $style_m && $style_d !== $style_m ) {
                    array_push($styles_list, "ht_ctc_s$style_m");
                }

                // // woo style and if not match with style desktop, mobile.
                // $woo = get_option('ht_ctc_woo_options');
                // $woo_style = (isset($woo['woo_style'])) ? esc_attr($woo['woo_style']) : '';
                // if ( '' !== $woo_style && $style_d !== $woo_style && $style_m !== $woo_style ) {
                //     array_push($styles_list, "ht_ctc_s$woo_style");
                // }

            }
        }


        // register_setting
        foreach ($styles_list as $s) {
           
            register_setting( 
                'ht_ctc_cs_page_settings_fields', 
                $s, 
                [$this, 'options_sanitize']
            );

        }

        register_setting( 'ht_ctc_cs_page_settings_fields', 'ht_ctc_cs_options' , array( $this, 'options_sanitize' ) );

        
        
        // check for options.php, _GET page = click-to-chat-customize-styles
        $get_url = ( isset($_GET) && isset($_GET['page']) && 'click-to-chat-customize-styles' == $_GET['page'] ) ? true : false;
        
        $options_page = false;
        // if request url have options.php .. (or if requesturl is not set.. or empty ) then $options_page = true
        if ( isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']) ) {
            if ( false !== strpos( $_SERVER['REQUEST_URI'], 'options.php' ) ) {
                // if options.php page
                $options_page = true;
            }
        } else {
            $options_page = true;
        }
        

        // if its - options.php page or _GET page = click-to-chat-customize-styles - load settings fields.. (or if request url is not set or empty - no risk)
        if ( true == $options_page || true == $get_url ) {

            add_settings_section( 'ht_ctc_cs_settings_sections_add', '', array( $this, 'main_settings_section_cb' ), 'ht_ctc_cs_page_settings_sections_do' );

            // add_settings_field
            foreach ($styles_list as $s) {

                $name = str_replace( 'ht_ctc_s', 'Style ', $s );
            
                add_settings_field( 
                    $s, 
                    $name, 
                    [$this, "{$s}_cb"],
                    'ht_ctc_cs_page_settings_sections_do',
                    'ht_ctc_cs_settings_sections_add'
                );

            }

            add_settings_field( 'ht_ctc_cs', '', array( $this, 'ht_ctc_cs_cb' ), 'ht_ctc_cs_page_settings_sections_do', 'ht_ctc_cs_settings_sections_add' );
        
        }

    }

    public function main_settings_section_cb() {
        ?>
        <h1>Customize</h1>
        <!-- styles -->
        <style id="ht-ctc-admin-cs">
            .ht_ctc_display_none {
                display: none;
            }
        </style>
        <?php
    }

    // display all styles
        // count - updates each time, uses at clear cache 
    public function ht_ctc_cs_cb() {

        $options = get_option('ht_ctc_cs_options');
        $dbrow = 'ht_ctc_cs_options';

        $count = ( isset( $options['count']) ) ? esc_attr( $options['count'] ) : '1';
        $count++;

        
        $display_allstyles = ( isset( $options['display_allstyles']) ) ? esc_attr( $options['display_allstyles'] ) : '';

        $hide_checkbox = '';
        if ( isset( $this->display_all_styles_checkbox ) && 'hide' == $this->display_all_styles_checkbox ) {
            $hide_checkbox = 'ctc_init_display_none';
        }

        ?>
        <!-- not make empty table -->
        <input name="<?= $dbrow; ?>[count]" value="<?= $count; ?>" type="hidden" class="hide" >

        <!-- display all styles -->
        <div class="display_all_styles_checkbox <?= $hide_checkbox ?>">
            <p>
                <label>
                    <input name="<?= $dbrow; ?>[display_allstyles]" type="checkbox" value="1" <?php checked( $display_allstyles, 1 ); ?> id="display_allstyles" />
                    <span><?php _e( 'Display all Styles', 'click-to-chat-for-whatsapp' ); ?></span>
                </label>
            </p>
        </div>

        <?php
    }


    // style-1 - default theme button
    function ht_ctc_s1_cb() {

        $options = get_option('ht_ctc_s1');
        $dbrow = 'ht_ctc_s1';

        $s1_text_color = ( isset( $options['s1_text_color']) ) ? esc_attr( $options['s1_text_color'] ) : '';
        $s1_bg_color = ( isset( $options['s1_bg_color']) ) ? esc_attr( $options['s1_bg_color'] ) : '';
        $s1_icon_color = ( isset( $options['s1_icon_color']) ) ? esc_attr( $options['s1_icon_color'] ) : '';
        $s1_icon_size = ( isset( $options['s1_icon_size']) ) ? esc_attr( $options['s1_icon_size'] ) : '16';

        $s1_m_fullwidth_checkbox = ( isset( $options['s1_m_fullwidth']) ) ? esc_attr( $options['s1_m_fullwidth'] ) : '';
        $s1_add_icon_checkbox = ( isset( $options['s1_add_icon']) ) ? esc_attr( $options['s1_add_icon'] ) : '';

        ?>
        <ul class="collapsible ht_ctc_s1" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 1', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <p class="description"><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?>: <?php _e( 'button that appears like themes button', 'click-to-chat-for-whatsapp' ); ?></p>
        <br><br>

        <!-- Text color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[s1_text_color]" value="<?= $s1_text_color; ?>" type="text">
            </div>
        </div>

        <!-- background color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[s1_bg_color]" value="<?= $s1_bg_color; ?>" type="text">
            </div>
        </div>

        <!-- Add icon -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Add Icon', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <p>
                    <label>
                        <input name="<?= $dbrow; ?>[s1_add_icon]" type="checkbox" value="1" <?php checked( $s1_add_icon_checkbox, 1 ); ?> class="s1_add_icon" id="s1_add_icon" />
                        <span><?php _e( 'Add Icon', 'click-to-chat-for-whatsapp' ); ?></span>
                    </label>
                </p>
            </div>
        </div>

        <!-- Icon color -->
        <div class="row s1_icon_settings">
            <div class="col s6">
                <p><?php _e( 'Icon Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[s1_icon_color]" value="<?= $s1_icon_color; ?>" type="text">
            </div>
        </div>

        <!-- icon size -->
        <div class="row s1_icon_settings">
            <div class="col s6">
                <p><?php _e( 'Icon Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[s1_icon_size]" value="<?= $s1_icon_size ?>" id="s1_icon_size" type="text" class="s1_icon_size" >
                <label for="s1_icon_size"><?php _e( 'Icon Size', 'click-to-chat-for-whatsapp' ); ?> (e.g. 15px)</label>
            </div>
        </div>

        <!-- Full Width on Mobile -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Full Width on Mobile', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <?php
                if ( isset( $options['s1_m_fullwidth'] ) ) {
                    ?>
                    <p>
                        <label>
                            <input name="<?= $dbrow; ?>[s1_m_fullwidth]" type="checkbox" value="1" <?php checked( $options['s1_m_fullwidth'], 1 ); ?> id="s1_m_fullwidth" />
                            <span><?php _e( 'Full Width on Mobile', 'click-to-chat-for-whatsapp' ); ?></span>
                        </label>
                    </p>
                    <?php
                } else {
                ?>
                <p>
                    <label>
                        <input name="<?= $dbrow; ?>[s1_m_fullwidth]" type="checkbox" value="1" id="s1_m_fullwidth" />
                        <span><?php _e( 'Full Width on Mobile', 'click-to-chat-for-whatsapp' ); ?></span>
                    </label>
                </p>
                <?php
                }
                ?>
            </div>
        </div>


        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/style-1/"><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?></a></p>
        
        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }



    // style-2 - ht_ctc_s2 - whatsapp ios style icon
    function ht_ctc_s2_cb() {

        $options = get_option('ht_ctc_s2');
        $dbrow = 'ht_ctc_s2';
        $style = "s2";
        $s2_img_size = ( isset( $options['s2_img_size']) ) ? esc_attr( $options['s2_img_size'] ) : '';

        ?>
        <ul class="collapsible ht_ctc_s2" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 2', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">


        <!-- img size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[s2_img_size]" value="<?= $s2_img_size ?>" id="s2_img_size" type="text" class="" >
                <label for="s2_img_size"><?php _e( 'Image Size', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <?php
        $select_cta_type = ( isset( $options['cta_type']) ) ? esc_attr( $options['cta_type'] ) : '';

        $cta_textcolor = ( isset( $options['cta_textcolor']) ) ? esc_attr( $options['cta_textcolor'] ) : '';
        $cta_bgcolor = ( isset( $options['cta_bgcolor']) ) ? esc_attr( $options['cta_bgcolor'] ) : '';
        $cta_font_size = ( isset( $options['cta_font_size']) ) ? esc_attr( $options['cta_font_size'] ) : '';

        ?>

        <h5 style="display: inline-block;">Call to Action </h5>
        <hr>
        <!-- call to action - hover / show / hide -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Display - Call to Action', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[cta_type]" class="select_cta_type">
                    <option value="hover" <?= $select_cta_type == 'hover' ? 'SELECTED' : ''; ?> >On Hover</option>
                    <option value="show" <?= $select_cta_type == 'show' ? 'SELECTED' : ''; ?> >Show</option>
                    <option value="hide" <?= $select_cta_type == 'hide' ? 'SELECTED' : ''; ?> >Hide</option>
                    <?php
                    if ( 's7' == $style) {
                    ?>
                    <option value="inside" <?= $select_cta_type == 'inside' ? 'SELECTED' : ''; ?> >Inside padding</option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- call to action - Text color -->
        <div class="row cta_textcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Call to Action - Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_textcolor]" data-default-color="#ffffff" value="<?= $cta_textcolor ?>" type="text">
            </div>
        </div>

        <!-- call to action - background color -->
        <div class="row cta_bgcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Call to Action - Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_bgcolor]" data-default-color="#25D366" value="<?= $cta_bgcolor ?>" id="cta_bgcolor" type="text">
            </div>
        </div>

        <!-- font size -->
        <div class="row cta_font_size cta_stick">
            <div class="col s6">
                <p><?php _e( 'Font Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[cta_font_size]" value="<?= $cta_font_size ?>" id="s2_cta_font_size" type="text" class="" >
                <label for="s2_cta_font_size"><?php _e( 'Font Size (e.g. 15px)', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>


        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }



    // style-3 - ht_ctc_s3 - whatsapp andriod style icon
    function ht_ctc_s3_cb() {

        $options = get_option('ht_ctc_s3');
        $dbrow = 'ht_ctc_s3';
        $style = "s3";
        
        $select_s3_type = ( isset( $options['s3_type']) ) ? esc_attr( $options['s3_type'] ) : '1';

        $s3_img_size = ( isset( $options['s3_img_size']) ) ? esc_attr( $options['s3_img_size'] ) : '';

        $s3_extend_img_size = ( isset( $options['s3_extend_img_size']) ) ? esc_attr( $options['s3_extend_img_size'] ) : '';
        $s3_padding = ( isset( $options['s3_padding']) ) ? esc_attr( $options['s3_padding'] ) : '';

        $s3_bg_color = ( isset( $options['s3_bg_color']) ) ? esc_attr( $options['s3_bg_color'] ) : '';
        $s3_bg_color_hover = ( isset( $options['s3_bg_color_hover']) ) ? esc_attr( $options['s3_bg_color_hover'] ) : '';

        $select_cta_type = ( isset( $options['cta_type']) ) ? esc_attr( $options['cta_type'] ) : '';
        $cta_textcolor = ( isset( $options['cta_textcolor']) ) ? esc_attr( $options['cta_textcolor'] ) : '';
        $cta_bgcolor = ( isset( $options['cta_bgcolor']) ) ? esc_attr( $options['cta_bgcolor'] ) : '';
        $cta_font_size = ( isset( $options['cta_font_size']) ) ? esc_attr( $options['cta_font_size'] ) : '';
        ?>
        <ul class="collapsible ht_ctc_s3" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 3', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <!-- img size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s3[s3_img_size]" value="<?= $s3_img_size ?>" id="s3_img_size" type="text" class="" >
                <label for="s3_img_size"><?php _e( 'Image Size (Default: 50px )', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>


        <h5 style="display: inline-block;">Call to Action </h5>
        <!-- call to action - hover / show / hide -->
        <hr>
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Display - Call to Action', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[cta_type]" class="select_cta_type">
                    <option value="hover" <?= $select_cta_type == 'hover' ? 'SELECTED' : ''; ?> >On Hover</option>
                    <option value="show" <?= $select_cta_type == 'show' ? 'SELECTED' : ''; ?> >Show</option>
                    <option value="hide" <?= $select_cta_type == 'hide' ? 'SELECTED' : ''; ?> >Hide</option>
                    <?php
                    if ( 's7' == $style) {
                    ?>
                    <option value="inside" <?= $select_cta_type == 'inside' ? 'SELECTED' : ''; ?> >Inside padding</option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- call to action - Text color -->
        <div class="row cta_textcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Call to Action - Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_textcolor]" data-default-color="#ffffff" value="<?= $cta_textcolor; ?>" type="text">
            </div>
        </div>

        <!-- call to action - background color -->
        <div class="row cta_bgcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Call to Action - Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_bgcolor]" data-default-color="#25D366" value="<?= $cta_bgcolor; ?>" id="cta_bgcolor" type="text">
            </div>
        </div>

        <!-- font size -->
        <div class="row cta_font_size cta_stick">
            <div class="col s6">
                <p><?php _e( 'Font Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[cta_font_size]" value="<?= $cta_font_size; ?>" id="s3_cta_font_size" type="text" class="" >
                <label for="s3_cta_font_size"><?php _e( 'Font Size (e.g. 15px)', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }


    // style-3_1 Extend - ht_ctc_s3_1 - full icon..
    function ht_ctc_s3_1_cb() {

        $options = get_option('ht_ctc_s3_1');
        $dbrow = 'ht_ctc_s3_1';
        $style = "s3";
        $select_s3_type = ( isset( $options['s3_type']) ) ? esc_attr( $options['s3_type'] ) : '1';

        $s3_img_size = ( isset( $options['s3_img_size']) ) ? esc_attr( $options['s3_img_size'] ) : '';

        $s3_extend_img_size = ( isset( $options['s3_extend_img_size']) ) ? esc_attr( $options['s3_extend_img_size'] ) : '';
        $s3_padding = ( isset( $options['s3_padding']) ) ? esc_attr( $options['s3_padding'] ) : '';

        $s3_bg_color = ( isset( $options['s3_bg_color']) ) ? esc_attr( $options['s3_bg_color'] ) : '';
        $s3_bg_color_hover = ( isset( $options['s3_bg_color_hover']) ) ? esc_attr( $options['s3_bg_color_hover'] ) : '';

        ?>
        <ul class="collapsible ht_ctc_s3_1" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 3 Extend', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">


        <!-- img size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s3_1[s3_img_size]" value="<?= $s3_img_size; ?>" id="s3_img_size" type="text" class="" >
                <label for="s3_img_size"><?php _e( 'Image Size (Default: 40px )', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

            
        <!-- padding -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Padding', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s3_1[s3_padding]" value="<?= $s3_padding; ?>" id="s3_padding" type="text" class="" >
                <label for="s3_padding"><?php _e( 'Padding (Default: 20px )', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- background color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s3_1[s3_bg_color]" data-default-color="#25D366" value="<?= $s3_bg_color; ?>" id="s3_bg_color" type="text">
            </div>
        </div>

        <!-- background color hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s3_1[s3_bg_color_hover]" data-default-color="#25D366" value="<?= $s3_bg_color_hover; ?>" id="s3_bg_color_hover" type="text">
                <p class="description"><?php _e( 'E.g. ', 'click-to-chat-for-whatsapp' ); ?> #25D366, #20b038</p>
            </div>
        </div>
        <?php

        // shadow
        ?>
        <div class="s3_box_shadow">
        <?php
        if ( isset( $options['s3_box_shadow'] ) ) {
        ?>
        <p>
            <label>
                <input name="ht_ctc_s3_1[s3_box_shadow]" type="checkbox" value="1" <?php checked( $options['s3_box_shadow'], 1 ); ?> id="s3_box_shadow" />
                <span><?php _e( 'Shadow', 'click-to-chat-for-whatsapp' ); ?></span>
            </label>
        </p>
        <?php
        } else {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_s3_1[s3_box_shadow]" type="checkbox" value="1" id="s3_box_shadow" />
                    <span><?php _e( 'Shadow', 'click-to-chat-for-whatsapp' ); ?></span>
                </label>
            </p>
            <?php
        }
        ?>
        </div>
        <?php

        // shadow on hover
        ?>
        <div class="s3_box_shadow_hover ctc_init_display_none">
        <?php
        if ( isset( $options['s3_box_shadow_hover'] ) ) {
        ?>
        <p>
            <label>
                <input name="ht_ctc_s3_1[s3_box_shadow_hover]" type="checkbox" value="1" <?php checked( $options['s3_box_shadow_hover'], 1 ); ?> id="s3_box_shadow_hover" />
                <span><?php _e( 'Shadow on Hover only', 'click-to-chat-for-whatsapp' ); ?></span>
            </label>
        </p>
        <?php
        } else {
            ?>
            <p>
                <label>
                    <input name="ht_ctc_s3_1[s3_box_shadow_hover]" type="checkbox" value="1" id="s3_box_shadow_hover" />
                    <span><?php _e( 'Shadow on Hover only', 'click-to-chat-for-whatsapp' ); ?></span>
                </label>
            </p>
            <?php
        }
        ?>
        </div>
        <br>

        <?php
        $select_cta_type = ( isset( $options['cta_type']) ) ? esc_attr( $options['cta_type'] ) : '';

        $cta_textcolor = ( isset( $options['cta_textcolor']) ) ? esc_attr( $options['cta_textcolor'] ) : '';
        $cta_bgcolor = ( isset( $options['cta_bgcolor']) ) ? esc_attr( $options['cta_bgcolor'] ) : '';
        $cta_font_size = ( isset( $options['cta_font_size']) ) ? esc_attr( $options['cta_font_size'] ) : '';

        ?>

        <h5 style="display: inline-block;">Call to Action </h5>
        <hr>
        <!-- call to action - hover / show / hide -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Display - Call to Action', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[cta_type]" class="select_cta_type">
                    <option value="hover" <?= $select_cta_type == 'hover' ? 'SELECTED' : ''; ?> >On Hover</option>
                    <option value="show" <?= $select_cta_type == 'show' ? 'SELECTED' : ''; ?> >Show</option>
                    <option value="hide" <?= $select_cta_type == 'hide' ? 'SELECTED' : ''; ?> >Hide</option>
                    <?php
                    if ( 's7' == $style) {
                    ?>
                    <option value="inside" <?= $select_cta_type == 'inside' ? 'SELECTED' : ''; ?> >Inside padding</option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- call to action - Text color -->
        <div class="row cta_textcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Call to Action - Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_textcolor]" data-default-color="#ffffff" value="<?= $cta_textcolor ?>" type="text">
            </div>
        </div>

        <!-- call to action - background color -->
        <div class="row cta_bgcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Call to Action - Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_bgcolor]" data-default-color="#25D366" value="<?= $cta_bgcolor ?>" id="cta_bgcolor" type="text">
            </div>
        </div>

        <!-- font size -->
        <div class="row cta_font_size cta_stick">
            <div class="col s6">
                <p><?php _e( 'Font Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[cta_font_size]" value="<?= $cta_font_size ?>" id="s3_1_cta_font_size" type="text" class="" >
                <label for="s3_1_cta_font_size"><?php _e( 'Font Size (e.g. 15px)', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>


        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }



    // style-4  - ht_ctc_s4 - chip
    function ht_ctc_s4_cb() {

        $options = get_option('ht_ctc_s4');
        $s4_text_color = ( isset( $options['s4_text_color']) ) ? esc_attr( $options['s4_text_color'] ) : '';
        $s4_bg_color = ( isset( $options['s4_bg_color']) ) ? esc_attr( $options['s4_bg_color'] ) : '';
        $s4_img_url = ( isset( $options['s4_img_url']) ) ? esc_attr( $options['s4_img_url'] ) : '';
        $s4_img_size = ( isset( $options['s4_img_size']) ) ? esc_attr( $options['s4_img_size'] ) : '';
        $select_s4_img_position = ( isset( $options['s4_img_position']) ) ? esc_attr( $options['s4_img_position'] ) : '';
        ?>
        <ul class="collapsible ht_ctc_s4" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 4</div>
        <div class="collapsible-body">

        <!-- text color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s4[s4_text_color]" data-default-color="#7f7d7d" value="<?= $s4_text_color ?>" id="s4_text_color" type="text">
            </div>
        </div>

        <!-- background color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s4_bg_color" class="ht-ctc-color" data-default-color="#e4e4e4" name="ht_ctc_s4[s4_bg_color]" value="<?= $s4_bg_color ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- Image position -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Position', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="ht_ctc_s4[s4_img_position]" class="select-2">
                    <option value="left" <?= $select_s4_img_position == 'left' ? 'SELECTED' : ''; ?> >Left</option>
                    <option value="right" <?= $select_s4_img_position == 'right' ? 'SELECTED' : ''; ?> >Right</option>
                </select>
            </div>
        </div>

        <!-- image url -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image URL', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s4[s4_img_url]" value="<?= $s4_img_url ?>" id="s4_img_url" type="text" class="" >
                <label for="s4_img_url"><?php _e( 'Image URL(leave blank for default image)', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- img size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s4[s4_img_size]" value="<?= $s4_img_size ?>" id="s4_img_size" type="text" class="" >
                <label for="s4_img_size"><?php _e( 'Image Size (default 32px)', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description"><?php _e( '(possible, keep the value less then or equal to 32px)', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
        </div>


        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }



    // style-5  - ht_ctc_s5 - chip
    function ht_ctc_s5_cb() {

        $options = get_option('ht_ctc_s5');
        $s5_line_1 = ( isset( $options['s5_line_1']) ) ? esc_attr( $options['s5_line_1'] ) : '';
        $s5_line_2 = ( isset( $options['s5_line_2']) ) ? esc_attr( $options['s5_line_2'] ) : '';
        $s5_line_1_color = ( isset( $options['s5_line_1_color']) ) ? esc_attr( $options['s5_line_1_color'] ) : '';
        $s5_line_2_color = ( isset( $options['s5_line_2_color']) ) ? esc_attr( $options['s5_line_2_color'] ) : '';
        $s5_background_color = ( isset( $options['s5_background_color']) ) ? esc_attr( $options['s5_background_color'] ) : '';
        $s5_border_color = ( isset( $options['s5_border_color']) ) ? esc_attr( $options['s5_border_color'] ) : '';
        $s5_img = ( isset( $options['s5_img']) ) ? esc_attr( $options['s5_img'] ) : '';
        $s5_img_height = ( isset( $options['s5_img_height']) ) ? esc_attr( $options['s5_img_height'] ) : '';
        $s5_img_width = ( isset( $options['s5_img_width']) ) ? esc_attr( $options['s5_img_width'] ) : '';
        $s5_content_height = ( isset( $options['s5_content_height']) ) ? esc_attr( $options['s5_content_height'] ) : '';
        $s5_content_width = ( isset( $options['s5_content_width']) ) ? esc_attr( $options['s5_content_width'] ) : '';
        $select_s5_img_position = ( isset( $options['s5_img_position']) ) ? esc_attr( $options['s5_img_position'] ) : '';
        ?>
        <ul class="collapsible ht_ctc_s5" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 5', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <!-- s5_line_1 -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Line 1', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_line_1]" value="<?= $s5_line_1 ?>" id="s5_line_1" type="text" class="" >
                <label for="s5_line_1"><?php _e( 'Line 1', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s5_line_2 -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Line 2', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_line_2]" value="<?= $s5_line_2 ?>" id="s5_line_2" type="text" class="" >
                <label for="s5_line_2"><?php _e( 'Line 2', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s5_line_1_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Line 1 - Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s5[s5_line_1_color]" data-default-color="#000000" value="<?= $s5_line_1_color ?>" id="s5_line_1_color" type="text">
            </div>
        </div>

        <!-- s5_line_2_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Line 2 - Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s5[s5_line_2_color]" data-default-color="#000000" value="<?= $s5_line_2_color ?>" id="s5_line_2_color" type="text">
            </div>
        </div>

        <!-- s5_background_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Content Box Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s5[s5_background_color]" data-default-color="#ffffff" value="<?= $s5_background_color ?>" id="s5_background_color" type="text">
            </div>
        </div>

        <!-- s5_border_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Content Box Border Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="ht_ctc_s5[s5_border_color]" data-default-color="#dddddd" value="<?= $s5_border_color ?>" id="s5_border_color" type="text">
            </div>
        </div>

        <!-- s5_img -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image URL', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_img]" value="<?= $s5_img ?>" id="s5_img" type="text" class="" >
                <label for="s5_img">Leave blank for default image</label>
            </div>
        </div>

        <!-- s5_img_height -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Height', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_img_height]" value="<?= $s5_img_height ?>" id="s5_img_height" type="text" class="" >
                <label for="s5_img_height"><?php _e( 'Image Height', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s5_img_width -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Width', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_img_width]" value="<?= $s5_img_width ?>" id="s5_img_width" type="text" class="" >
                <label for="s5_img_width"><?php _e( 'Image Width', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s5_content_height -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Content Box Height', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_content_height]" value="<?= $s5_content_height ?>" id="s5_content_height" type="text" class="" >
                <label for="s5_content_height"><?php _e( 'Content Box Height', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s5_content_width -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Content Box Width', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s5[s5_content_width]" value="<?= $s5_content_width ?>" id="s5_content_width" type="text" class="" >
                <label for="s5_content_width"><?php _e( 'Content Box Width', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description"><?php _e( 'E.g.', 'click-to-chat-for-whatsapp' ); ?> 270px, 100%</p>
            </div>
        </div>

        <!-- s5_img_position -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Image Position', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="ht_ctc_s5[s5_img_position]" class="select-2">
                    <option value="right" <?= $select_s5_img_position == 'right' ? 'SELECTED' : ''; ?> ><?php _e( 'Right', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="left" <?= $select_s5_img_position == 'left' ? 'SELECTED' : ''; ?> ><?php _e( 'Left', 'click-to-chat-for-whatsapp' ); ?></option>
                </select>
                <p class="description"><?php _e( 'If style position/located: Right to screen then select Right, if Left to screen then select Left', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
        </div>


        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }

    


    // style-6 - ht_ctc_s6 - plain link
    function ht_ctc_s6_cb() {

        $options = get_option('ht_ctc_s6');
        $s6_txt_color = ( isset( $options['s6_txt_color']) ) ? esc_attr( $options['s6_txt_color'] ) : '';
        $s6_txt_color_on_hover = ( isset( $options['s6_txt_color_on_hover']) ) ? esc_attr( $options['s6_txt_color_on_hover'] ) : '';
        $text_decoration_value = ( isset( $options['s6_txt_decoration']) ) ? esc_attr( $options['s6_txt_decoration'] ) : '';
        $text_decoration_hover_value = ( isset( $options['s6_txt_decoration_on_hover']) ) ? esc_attr( $options['s6_txt_decoration_on_hover'] ) : '';
        ?>
        <ul class="collapsible ht_ctc_s6" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 6</div>
        <div class="collapsible-body">

        <!-- text color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <!-- <input id="s6_txt_color" class="ht-ctc-color" data-default-color="#006ccc" name="ht_ctc_s6[s6_txt_color]" value="<?= $s6_txt_color ?>" type="text" style="height: 1.375rem;" > -->
                <input id="s6_txt_color" class="ht-ctc-color" name="ht_ctc_s6[s6_txt_color]" value="<?= $s6_txt_color ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>


        <!-- text color on hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <!-- <input id="s6_txt_color_on_hover" class="ht-ctc-color" data-default-color="#006ccc" name="ht_ctc_s6[s6_txt_color_on_hover]" value="<?= $s6_txt_color_on_hover ?>" type="text" style="height: 1.375rem;" > -->
                <input id="s6_txt_color_on_hover" class="ht-ctc-color" name="ht_ctc_s6[s6_txt_color_on_hover]" value="<?= $s6_txt_color_on_hover ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- Text Decoration - none/initial/underline/overline/... -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Decoration', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="ht_ctc_s6[s6_txt_decoration]" class="select-2">
                    <option value="initial" <?= $text_decoration_value == 'initial' ? 'SELECTED' : ''; ?> >initial</option>
                    <option value="underline" <?= $text_decoration_value == 'underline' ? 'SELECTED' : ''; ?> >underline</option>
                    <option value="overline" <?= $text_decoration_value == 'overline' ? 'SELECTED' : ''; ?> >overline</option>
                    <option value="line-through" <?= $text_decoration_value == 'line-through' ? 'SELECTED' : ''; ?> >line-through</option>
                    <option value="inherit" <?= $text_decoration_value == 'inherit' ? 'SELECTED' : ''; ?> >inherit</option>
                </select>
                <!-- <label>Text Decoration</label> -->
            </div>
        </div>

        <!-- Text Decoration when hover - none/initial/underline/overline/... -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Decoration when Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="ht_ctc_s6[s6_txt_decoration_on_hover]" class="select-2">
                    <option value="initial" <?= $text_decoration_hover_value == 'initial' ? 'SELECTED' : ''; ?> >initial</option>
                    <option value="underline" <?= $text_decoration_hover_value == 'underline' ? 'SELECTED' : ''; ?> >underline</option>
                    <option value="overline" <?= $text_decoration_hover_value == 'overline' ? 'SELECTED' : ''; ?> >overline</option>
                    <option value="line-through" <?= $text_decoration_hover_value == 'line-through' ? 'SELECTED' : ''; ?> >line-through</option>
                    <option value="inherit" <?= $text_decoration_hover_value == 'inherit' ? 'SELECTED' : ''; ?> >inherit</option>
                </select>
                <!-- <label>Text Decoration when Hover</label> -->
            </div>
        </div>

        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }


    // style-7 - ht_ctc_s7 - plain link
    function ht_ctc_s7_cb() {

        $options = get_option('ht_ctc_s7');
        $dbrow = 'ht_ctc_s7';
        $style = "s7";

        $s7_icon_size = ( isset( $options['s7_icon_size']) ) ? esc_attr( $options['s7_icon_size'] ) : '';
        $s7_icon_color = ( isset( $options['s7_icon_color']) ) ? esc_attr( $options['s7_icon_color'] ) : '';
        $s7_icon_color_hover = ( isset( $options['s7_icon_color_hover']) ) ? esc_attr( $options['s7_icon_color_hover'] ) : '';
        $s7_border_size = ( isset( $options['s7_border_size']) ) ? esc_attr( $options['s7_border_size'] ) : '';
        $s7_border_color = ( isset( $options['s7_border_color']) ) ? esc_attr( $options['s7_border_color'] ) : '';
        $s7_border_color_hover = ( isset( $options['s7_border_color_hover']) ) ? esc_attr( $options['s7_border_color_hover'] ) : '';
        $s7_border_radius = ( isset( $options['s7_border_radius']) ) ? esc_attr( $options['s7_border_radius'] ) : '';

        $select_cta_type = ( isset( $options['cta_type']) ) ? esc_attr( $options['cta_type'] ) : '';

        $cta_textcolor = ( isset( $options['cta_textcolor']) ) ? esc_attr( $options['cta_textcolor'] ) : '';
        $cta_textcolor_hover = ( isset( $options['cta_textcolor_hover']) ) ? esc_attr( $options['cta_textcolor_hover'] ) : '';
        $cta_bgcolor = ( isset( $options['cta_bgcolor']) ) ? esc_attr( $options['cta_bgcolor'] ) : '';
        $cta_bgcolor_hover = ( isset( $options['cta_bgcolor_hover']) ) ? esc_attr( $options['cta_bgcolor_hover'] ) : '';
        $cta_font_size = ( isset( $options['cta_font_size']) ) ? esc_attr( $options['cta_font_size'] ) : '';

        ?>
        <ul class="collapsible ht_ctc_s7" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 7', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <!-- s7_icon_size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s7[s7_icon_size]" value="<?= $s7_icon_size ?>" id="s7_icon_size" type="text" class="" >
                <label for="s7_icon_size"><?php _e( 'Icon Size', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s7_icon_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_icon_color" class="ht-ctc-color" data-default-color="#ffffff" name="ht_ctc_s7[s7_icon_color]" value="<?= $s7_icon_color ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_icon_color_hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_icon_color_hover" class="ht-ctc-color" data-default-color="#fffff" name="ht_ctc_s7[s7_icon_color_hover]" value="<?= $s7_icon_color_hover ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_border_size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Border Padding Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s7[s7_border_size]" value="<?= $s7_border_size ?>" id="s7_border_size" type="text" class="" >
                <label for="s7_border_size"><?php _e( 'Border Padding Size', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description"><?php _e( 'E.g. 12px', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
        </div>

        <!-- s7_border_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_border_color" class="ht-ctc-color" data-default-color="#25d366" name="ht_ctc_s7[s7_border_color]" value="<?= $s7_border_color ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_border_color_hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_border_color_hover" class="ht-ctc-color" data-default-color="#25d366" name="ht_ctc_s7[s7_border_color_hover]" value="<?= $s7_border_color_hover ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_border_radius -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Border radius', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s7[s7_border_radius]" value="<?= $s7_border_radius ?>" id="s7_border_radius" type="text" class="" >
                <label for="s7_border_radius"><?php _e( 'Border radius', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description"><?php _e( 'E.g. 10px, 50% ( for round border add 50% )', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
        </div>
        <br>
        <p class="description"><?php _e( 'To display icon only - clear background-color. (May need to change icon color to display in plain background)', 'click-to-chat-for-whatsapp' ); ?> </p>

        <br><br>

        <h5 style="display: inline-block;">Call to Action </h5>
        <hr>
        <!-- call to action - hover / show / hide -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Display - Call to Action', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[cta_type]" class="select_cta_type">
                    <option value="hover" <?= $select_cta_type == 'hover' ? 'SELECTED' : ''; ?> >On Hover</option>
                    <option value="show" <?= $select_cta_type == 'show' ? 'SELECTED' : ''; ?> >Show</option>
                    <option value="hide" <?= $select_cta_type == 'hide' ? 'SELECTED' : ''; ?> >Hide</option>
                </select>
            </div>
        </div>
        <!-- call to action - Text color -->
        <div class="row cta_textcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_textcolor]" data-default-color="#ffffff" value="<?= $cta_textcolor ?>" type="text">
            </div>
        </div>

        <!-- call to action - background color -->
        <div class="row cta_bgcolor cta_stick">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input class="ht-ctc-color" name="<?= $dbrow; ?>[cta_bgcolor]" data-default-color="#25d366" value="<?= $cta_bgcolor ?>" id="cta_bgcolor" type="text">
            </div>
        </div>

        <!-- font size -->
        <div class="row cta_font_size cta_stick">
            <div class="col s6">
                <p><?php _e( 'Font Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[cta_font_size]" value="<?= $cta_font_size ?>" id="s7_cta_font_size" type="text" class="" >
                <label for="s7_cta_font_size"><?php _e( 'Font Size (e.g. 15px)', 'click-to-chat-for-whatsapp' ); ?></label>
                <span class="helper-text"><?php _e( 'Leave blank for default settings', 'click-to-chat-for-whatsapp' ); ?></span>
            </div>
        </div>

        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }


    // style-7_1 Extend  - ht_ctc_s7_1
    function ht_ctc_s7_1_cb() {

        $options = get_option('ht_ctc_s7_1');
        $dbrow = 'ht_ctc_s7_1';
        $style = "s7";

        $s7_icon_size = ( isset( $options['s7_icon_size']) ) ? esc_attr( $options['s7_icon_size'] ) : '';
        $s7_icon_color = ( isset( $options['s7_icon_color']) ) ? esc_attr( $options['s7_icon_color'] ) : '';
        $s7_icon_color_hover = ( isset( $options['s7_icon_color_hover']) ) ? esc_attr( $options['s7_icon_color_hover'] ) : '';
        $s7_border_size = ( isset( $options['s7_border_size']) ) ? esc_attr( $options['s7_border_size'] ) : '';
        $s7_bgcolor = ( isset( $options['s7_bgcolor']) ) ? esc_attr( $options['s7_bgcolor'] ) : '';
        $s7_bgcolor_hover = ( isset( $options['s7_bgcolor_hover']) ) ? esc_attr( $options['s7_bgcolor_hover'] ) : '';
        $cta_font_size = ( isset( $options['cta_font_size']) ) ? esc_attr( $options['cta_font_size'] ) : '';

        $select_cta_type = ( isset( $options['cta_type']) ) ? esc_attr( $options['cta_type'] ) : '';

        ?>
        <ul class="collapsible ht_ctc_s7_1" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 7 Extend', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <!-- s7_1 call to action - hover / show  -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Display - Call to Action', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[cta_type]" class="select_cta_type">
                    <option value="hover" <?= $select_cta_type == 'hover' ? 'SELECTED' : ''; ?> >On Hover</option>
                    <option value="show" <?= $select_cta_type == 'show' ? 'SELECTED' : ''; ?> >Show</option>
                </select>
            </div>
        </div>


        <!-- s7_icon_size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[s7_icon_size]" value="<?= $s7_icon_size ?>" id="s7_icon_size" type="text" class="" >
                <label for="s7_icon_size"><?php _e( 'Icon Size', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- s7_border_size icon padding size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Border Padding Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[s7_border_size]" value="<?= $s7_border_size ?>" id="s7_border_size" type="text" class="" >
                <label for="s7_border_size"><?php _e( 'Border Padding Size', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description"><?php _e( 'E.g. 12px', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
        </div>

        <!-- s7_icon_color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon,Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_icon_color" class="ht-ctc-color" data-default-color="#ffffff" name="<?= $dbrow; ?>[s7_icon_color]" value="<?= $s7_icon_color ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_icon_color_hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon,Text Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_icon_color_hover" class="ht-ctc-color" data-default-color="#f4f4f4" name="<?= $dbrow; ?>[s7_icon_color_hover]" value="<?= $s7_icon_color_hover ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_bgcolor -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_bgcolor" class="ht-ctc-color" data-default-color="#25d366" name="<?= $dbrow; ?>[s7_bgcolor]" value="<?= $s7_bgcolor ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- s7_bgcolor_hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s7_bgcolor_hover" class="ht-ctc-color" data-default-color="#25d366" name="<?= $dbrow; ?>[s7_bgcolor_hover]" value="<?= $s7_bgcolor_hover ?>" type="text" style="height: 1.375rem;" >
            </div>
        </div>

        <!-- font size -->
        <div class="row cta_font_size cta_stick">
            <div class="col s6">
                <p><?php _e( 'Font Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="<?= $dbrow; ?>[cta_font_size]" value="<?= $cta_font_size ?>" id="s7_1_cta_font_size" type="text" class="" >
                <label for="s7_1_cta_font_size"><?php _e( 'Font Size (e.g. 15px)', 'click-to-chat-for-whatsapp' ); ?></label>
                <span class="helper-text"><?php _e( 'Leave blank for default settings', 'click-to-chat-for-whatsapp' ); ?></span>
            </div>
        </div>


        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }



    // style-8 - ht_ctc_s8 - button with icon
    function ht_ctc_s8_cb() {

        $options = get_option('ht_ctc_s8');
        $dbrow = 'ht_ctc_s8';

        $s8_txt_color = ( isset( $options['s8_txt_color']) ) ? esc_attr( $options['s8_txt_color'] ) : '';
        $s8_txt_color_on_hover = ( isset( $options['s8_txt_color_on_hover']) ) ? esc_attr( $options['s8_txt_color_on_hover'] ) : '';
        $s8_bg_color = ( isset( $options['s8_bg_color']) ) ? esc_attr( $options['s8_bg_color'] ) : '';
        $s8_bg_color_on_hover = ( isset( $options['s8_bg_color_on_hover']) ) ? esc_attr( $options['s8_bg_color_on_hover'] ) : '';
        $s8_icon_color = ( isset( $options['s8_icon_color']) ) ? esc_attr( $options['s8_icon_color'] ) : '';
        $s8_icon_color_on_hover = ( isset( $options['s8_icon_color_on_hover']) ) ? esc_attr( $options['s8_icon_color_on_hover'] ) : '';
        $icon_position_value = ( isset( $options['s8_icon_position']) ) ? esc_attr( $options['s8_icon_position'] ) : '';
        $s8_text_size = ( isset( $options['s8_text_size']) ) ? esc_attr( $options['s8_text_size'] ) : '';
        $s8_icon_size = ( isset( $options['s8_icon_size']) ) ? esc_attr( $options['s8_icon_size'] ) : '';
        $s8_btn_size = ( isset( $options['s8_btn_size']) ) ? esc_attr( $options['s8_btn_size'] ) : '';
        ?>
        <ul class="collapsible ht_ctc_s8" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 8', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <!-- text color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s8_txt_color" class="ht-ctc-color" data-default-color="#ffffff" name="ht_ctc_s8[s8_txt_color]" value="<?= $s8_txt_color ?>" type="text" style="height: 1.375rem;" >
                <!-- <label for="s3_img_url">Text Color</label> -->
                <!-- <p class="description">Default Color: #ffffff</p> -->
            </div>
        </div>

        <!-- text color on hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s8_txt_color_on_hover" class="ht-ctc-color" data-default-color="#ffffff" name="ht_ctc_s8[s8_txt_color_on_hover]" value="<?= $s8_txt_color_on_hover ?>" type="text" style="height: 1.375rem;" >
                <!-- <label for="s3_img_url">Text Color on Hover</label> -->
                <!-- <p class="description">Default Color: #ffffff</p> -->
            </div>
        </div>

        <!-- background color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s8_bg_color" class="ht-ctc-color" data-default-color="#26a69a" name="ht_ctc_s8[s8_bg_color]" value="<?= $s8_bg_color ?>" type="text" style="height: 1.375rem;" >
                <!-- <label for="s3_img_url">Background Color</label> -->
                <!-- <p class="description">Default Color: #26a69a</p> -->
            </div>
        </div>

        <!-- background color on hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Background Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s8_bg_color_on_hover" class="ht-ctc-color" data-default-color="#26a69a" name="ht_ctc_s8[s8_bg_color_on_hover]" value="<?= $s8_bg_color_on_hover ?>" type="text" style="height: 1.375rem;" >
                <!-- <label for="s3_img_url">Background Color on Hover</label> -->
                <!-- <p class="description">Default Color: #26a69a</p> -->
            </div>
        </div>

        <!-- icon color -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Color', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s8_icon_color" class="ht-ctc-color" data-default-color="#ffffff" name="ht_ctc_s8[s8_icon_color]" value="<?= $s8_icon_color ?>" type="text" style="height: 1.375rem;" >
                <!-- <label for="s3_img_url">Icon Color</label> -->
                <!-- <p class="description">Default Color: #ffffff</p> -->
            </div>
        </div>

        <!-- icon color on hover -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Color on Hover', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input id="s8_icon_color_on_hover" class="ht-ctc-color" data-default-color="#ffffff" name="ht_ctc_s8[s8_icon_color_on_hover]" value="<?= $s8_icon_color_on_hover ?>" type="text" style="height: 1.375rem;" >
                <!-- <label for="s3_img_url">Icon Color on Hover</label> -->
                <!-- <p class="description">Default Color: #ffffff</p> -->
            </div>
        </div>



        <!-- icon position - left/right -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Icon Position', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="ht_ctc_s8[s8_icon_position]" class="select-2">
                    <option value="left" <?= $icon_position_value == 'left' ? 'SELECTED' : ''; ?> >Left</option>
                    <option value="right" <?= $icon_position_value == 'right' ? 'SELECTED' : ''; ?> >Right</option>
                    <option value="hide" <?= $icon_position_value == 'hide' ? 'SELECTED' : ''; ?> >Hide</option>
                </select>
                <!-- <label>Icon Position</label> -->
            </div>
        </div>


        <!-- Text Size -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Text Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s8[s8_text_size]" value="<?= $s8_text_size ?>" id="s8_text_size" type="text" class="" >
                <label for="s8_text_size"><?php _e( 'Text Size  -  E.g. 12px', 'click-to-chat-for-whatsapp' ); ?></label>
                <span class="helper-text"><?php _e( 'Leave blank for default settings', 'click-to-chat-for-whatsapp' ); ?></span>
            </div>
        </div>

        <!-- Icon Size -->
        <div class="row">
            <div class="col s6">
                <p>Icon Size</p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s8[s8_icon_size]" value="<?= $s8_icon_size ?>" id="s8_icon_size" type="text" class="" >
                <label for="s8_icon_size"><?php _e( 'Icon Size  -  E.g. 16px', 'click-to-chat-for-whatsapp' ); ?></label>
                <span class="helper-text"><?php _e( 'Leave blank for default settings', 'click-to-chat-for-whatsapp' ); ?></span>
            </div>
        </div>

        <!-- button size - btn, btn-large -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Button Size', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="ht_ctc_s8[s8_btn_size]" class="select-2">
                    <option value="btn" <?= $s8_btn_size == 'btn' ? 'SELECTED' : ''; ?> ><?php _e( 'Normal', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="btn-large" <?= $s8_btn_size == 'btn-large' ? 'SELECTED' : ''; ?> ><?php _e( 'Large', 'click-to-chat-for-whatsapp' ); ?></option>
                </select>
            </div>
        </div>

        <!-- Full Width on Mobile -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Full Width on Mobile', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <?php
                if ( isset( $options['s8_m_fullwidth'] ) ) {
                    ?>
                    <p>
                        <label>
                            <input name="<?= $dbrow; ?>[s8_m_fullwidth]" type="checkbox" value="1" <?php checked( $options['s8_m_fullwidth'], 1 ); ?> id="s8_m_fullwidth" />
                            <span><?php _e( 'Full Width on Mobile', 'click-to-chat-for-whatsapp' ); ?></span>
                        </label>
                    </p>
                    <?php
                } else {
                ?>
                <p>
                    <label>
                        <input name="<?= $dbrow; ?>[s8_m_fullwidth]" type="checkbox" value="1" id="s8_m_fullwidth" />
                        <span><?php _e( 'Full Width on Mobile', 'click-to-chat-for-whatsapp' ); ?></span>
                    </label>
                </p>
                <?php
                }
                ?>
            </div>
        </div>

        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/style-8/"><?php _e( 'Style-8', 'click-to-chat-for-whatsapp' ); ?></a></p>
        

        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }


    // style-99 - ht_ctc_s99 - own image
    function ht_ctc_s99_cb() {

        $options = get_option('ht_ctc_s99');
        $s_99_dekstop_img_url = ( isset( $options['s99_dekstop_img_url']) ) ? esc_attr( $options['s99_dekstop_img_url'] ) : '';
        $s_99_mobile_img_url = ( isset( $options['s99_mobile_img_url']) ) ? esc_attr( $options['s99_mobile_img_url'] ) : '';
        $s_99_desktop_img_height = ( isset( $options['s99_desktop_img_height']) ) ? esc_attr( $options['s99_desktop_img_height'] ) : '';
        $s_99_desktop_img_width = ( isset( $options['s99_desktop_img_width']) ) ? esc_attr( $options['s99_desktop_img_width'] ) : '';
        $s_99_mobile_img_height = ( isset( $options['s99_mobile_img_height']) ) ? esc_attr( $options['s99_mobile_img_height'] ) : '';
        $s_99_mobile_img_width = ( isset( $options['s99_mobile_img_width']) ) ? esc_attr( $options['s99_mobile_img_width'] ) : '';
        ?>
        <ul class="collapsible ht_ctc_s99" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Add your own image / GIF (Style 99)', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <!-- Image URL - Desktop -->
        <div class="row">
            <!-- <div class="col s6">
                <p>Image URL</p>
            </div> -->
            <div class="input-field col s12">
                <input name="ht_ctc_s99[s99_dekstop_img_url]" value="<?= $s_99_dekstop_img_url ?>" id="s99_dekstop_img_url" type="text" class="" >
                <label for="s99_dekstop_img_url"><?php _e( 'Image URL - Desktop', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- Image URL - Mobile -->
        <div class="row">
            <!-- <div class="col s6">
                <p>Image URL</p>
            </div> -->
            <div class="input-field col s12">
                <input name="ht_ctc_s99[s99_mobile_img_url]" value="<?= $s_99_mobile_img_url ?>" id="s99_mobile_img_url" type="text" class="" >
                <label for="s99_mobile_img_url"><?php _e( 'Image URL - Mobile', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- Desktop - Image Height -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Desktop - Image Height', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s99[s99_desktop_img_height]" value="<?= $s_99_desktop_img_height ?>" id="s99_desktop_img_height" type="text" class="" >
                <label for="s99_desktop_img_height"><?php _e( 'Desktop - Image Height', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- Desktop - Image Width -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Desktop - Image Width', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s99[s99_desktop_img_width]" value="<?= $s_99_desktop_img_width ?>" id="s99_desktop_img_width" type="text" class="" >
                <label for="s99_desktop_img_width"><?php _e( 'Desktop - Image Width', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- Mobile - Image Height -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Mobile - Image Height', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s99[s99_mobile_img_height]" value="<?= $s_99_mobile_img_height ?>" id="s99_mobile_img_height" type="text" class="" >
                <label for="s99_mobile_img_height"><?php _e( 'Mobile - Image Height', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- Mobile - Image Width -->
        <div class="row">
            <div class="col s6">
                <p><?php _e( 'Mobile - Image Width', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <input name="ht_ctc_s99[s99_mobile_img_width]" value="<?= $s_99_mobile_img_width ?>" id="s99_mobile_img_width" type="text" class="" >
                <label for="s99_mobile_img_width"><?php _e( 'Mobile - Image Width', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/style-99/">Add your own image / GIF (Style-99)</a></p>

        </div>
        </div>
        </li>
        </ul>
        
        <?php
    }








    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $new_input = array();

        // add px suffix, remove spaces
        $add_suffix = array(
            's1_icon_size',
            's2_img_size',
            's3_img_size',
            's3_padding',
            's4_img_size',
            's5_img_height',
            's5_img_width',
            's5_content_height',
            's5_content_width',
            's7_icon_size',
            's7_border_size',
            's7_border_radius',
            's8_text_size',
            's8_icon_size',
            's99_desktop_img_height',
            's99_desktop_img_width',
            's99_mobile_img_height',
            's99_mobile_img_width',
            'cta_font_size',
        );

        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {

                if ( in_array( $key, $add_suffix ) ) {

                    $input[$key] = str_replace( ' ', '', $input[$key] );

                    if ( is_numeric($input[$key]) ) {
                        $input[$key] = $input[$key] . 'px';
                    }
                    if ( 's5_img_height' == $key || 's5_img_width' == $key || 's5_content_height' == $key ) {
                        $input[$key] = ('' == $input[$key]) ? '70px' : $input[$key];
                    }
                    if ( 's5_content_width' == $key ) {
                        $input[$key] = ('' == $input[$key]) ? '270px' : $input[$key];
                    }
                    if ( 's7_icon_size' == $key ) {
                        $input[$key] = ('' == $input[$key]) ? '24px' : $input[$key];
                    }
                    if ( 's7_border_size' == $key ) {
                        $input[$key] = ('' == $input[$key]) ? '12px' : $input[$key];
                    }
                    if ( 's7_border_radius' == $key ) {
                        $input[$key] = ('' == $input[$key]) ? '4px' : $input[$key];
                    }
                    $new_input[$key] = sanitize_text_field( $input[$key] );
                } else {
                    $new_input[$key] = sanitize_text_field( $input[$key] );
                }

            }
        }

        return $new_input;
    }



}

$ht_ctc_admin_customize_styles = new HT_CTC_Admin_Customize_Styles();

add_action('admin_menu', array($ht_ctc_admin_customize_styles, 'menu') );
add_action('admin_init', array($ht_ctc_admin_customize_styles, 'settings') );

endif; // END class_exists check