<?php
/**
* content of the options page ..  Customize Styles ..
* admin_menu.php  -> settings_page.php  -> admin_page.php
*  in name exists - this short values - it means 
*   cs  - customize styles
*   cb  - call back - function
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Admin_Page_Customize_Styles' ) ) :
    
class CCW_Admin_Page_Customize_Styles {


    function customize_styles() {
        
        register_setting( 'ccw_settings_group_cs', 'ccw_options_cs' , 'ccw_options_sanitize_cs_cb' );

        register_setting( 'ccw_settings_group_cs', 'ht_ccw_ga' , 'ccw_options_sanitize_cs_cb' );
        register_setting( 'ccw_settings_group_cs', 'ht_ccw_fb' , 'ccw_options_sanitize_cs_cb' );
        
        add_settings_section( 'ccw_settings_cs', '', array( $this, 'ccw_settings_section_cs_cb' ), 'ccw_options_settings_cs' );
    
        add_settings_field( 'ccw_style_1_cs', 'Style 1', array( $this, 'ccw_style_1_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_2_cs', 'Style 2', array( $this, 'ccw_style_2_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_3_cs', 'Style 3', array( $this, 'ccw_style_3_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_4_cs', 'Style 4', array( $this, 'ccw_style_4_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_5_cs', 'Style 5', array( $this, 'ccw_style_5_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_6_cs', 'Style 6', array( $this, 'ccw_style_6_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_7_cs', 'Style 7', array( $this, 'ccw_style_7_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_8_cs', 'Style 8', array( $this, 'ccw_style_8_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_9_cs', 'Style 9', array( $this, 'ccw_style_9_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_style_99_own_img_cs', 'Style 99 own Image', array( $this, 'ccw_style_99_own_img_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ccw_animations', 'Animations', array( $this, 'ccw_animations_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );

        add_settings_field( 'ht_ccw_ga', 'Google Analytics', array( $this, 'ht_ccw_ga_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );
        add_settings_field( 'ht_ccw_fb', 'Facebook Analytics', array( $this, 'ht_ccw_fb_cb' ), 'ccw_options_settings_cs', 'ccw_settings_cs' );

    }

    
    function ccw_settings_section_cs_cb() {
        echo '<h1>Customize Styles</h1>';
    }

    // style - 1 - new
    function ccw_style_1_cb() {
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 1</div>
        <div class="collapsible-body">

            <div class="row">
                <p class="description"> Style-1 is the default theme button. (looks like currently activated Theme button).</p>
                <br>
                <p class="description">For customizable button, please select style-8</p>
                <br><br>
                <p class="description">changes made in style-1 since <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/v-1-7">Version-1.7</a></p>
            </div>

        </div>
        </div>
        </li>
        </ul>

        <?php

    }


    
    // style - 2
    function ccw_style_2_cb() {
        $ccw_style_2 = get_option('ccw_options_cs');
        $s2_decoration_value = esc_attr( $ccw_style_2['s2_decoration'] );
        $s2_decoration_onhover = esc_attr( $ccw_style_2['s2_decoration_onhover'] );
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 2</div>
        <div class="collapsible-body">

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s2_text_color]" data-default-color="inherit" value="<?= esc_attr( $ccw_style_2['s2_text_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Color on Hover', 'click-to-chat-for-whatsapp' ); ?> </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s2_text_color_onhover]" data-default-color="inherit" value="<?= esc_attr( $ccw_style_2['s2_text_color_onhover'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>
        
            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Decoration', 'click-to-chat-for-whatsapp' ); ?> </p>
                </div>
                <div class="input-field col s6">
                    <select name="ccw_options_cs[s2_decoration]" class="select-2_2">
                        <option value="none" <?= $s2_decoration_value == 'none' ? 'SELECTED' : ''; ?> >none</option>
                        <option value="underline" <?= $s2_decoration_value == 'underline' ? 'SELECTED' : ''; ?> >underline</option>
                        <option value="overline" <?= $s2_decoration_value == 'overline' ? 'SELECTED' : ''; ?> >overline</option>
                        <option value="line-through" <?= $s2_decoration_value == 'line-through' ? 'SELECTED' : ''; ?> >line-through</option>
                        <option value="initial" <?= $s2_decoration_value == 'initial' ? 'SELECTED' : ''; ?> >initial</option>
                        <option value="inherit" <?= $s2_decoration_value == 'inherit' ? 'SELECTED' : ''; ?> >inherit</option>
                    </select>
                    <label><?php _e( 'Text Decoration', 'click-to-chat-for-whatsapp' ); ?> </label>
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Decoration when Hover', 'click-to-chat-for-whatsapp' ); ?> </p>
                </div>
                <div class="input-field col s6">
                    <select name="ccw_options_cs[s2_decoration_onhover]" class="select-2_2">
                        <option value="none" <?= $s2_decoration_onhover == 'none' ? 'SELECTED' : ''; ?> >none</option>
                        <option value="underline" <?= $s2_decoration_onhover == 'underline' ? 'SELECTED' : ''; ?> >underline</option>
                        <option value="overline" <?= $s2_decoration_onhover == 'overline' ? 'SELECTED' : ''; ?> >overline</option>
                        <option value="line-through" <?= $s2_decoration_onhover == 'line-through' ? 'SELECTED' : ''; ?> >line-through</option>
                        <option value="initial" <?= $s2_decoration_onhover == 'initial' ? 'SELECTED' : ''; ?> >initial</option>
                        <option value="inherit" <?= $s2_decoration_onhover == 'inherit' ? 'SELECTED' : ''; ?> >inherit</option>
                    </select>
                    <label>Text Decoration on focus </label>
                </div>
            </div>

            </div>
            </div>
            </li>
            </ul>
        <?php
    }


    // style - 3
    function ccw_style_3_cb() {
        $ccw_style_3 = get_option('ccw_options_cs');
        
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 3</div>
        <div class="collapsible-body">
            
            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Image size', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s3_icon_size]" value="<?= esc_attr( $ccw_style_3['s3_icon_size'] ) ?>" type="text" class="" >
                </div>
            </div>

        </div>
        </div>
        </li>
        </ul>

        <?php
    }


    // style - 4
    function ccw_style_4_cb() {
        $ccw_style_4 = get_option('ccw_options_cs');
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 4</div>
        <div class="collapsible-body">

        
            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?> </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s4_text_color]" data-default-color="rgba(0, 0, 0, 0.6)" value="<?= esc_attr( $ccw_style_4['s4_text_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?> </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s4_background_color]" data-default-color="#e4e4e4" value="<?= esc_attr( $ccw_style_4['s4_background_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>
        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }


    // style - 5
    function ccw_style_5_cb() {
        $ccw_style_5 = get_option('ccw_options_cs');
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 5</div>
        <div class="collapsible-body">

            <div class="row">
                <div class="col s6">
                    <p>Color of icon </p>
                </div>
                <div class="input-field col s6">
                    <!--   style="height: 1.375rem;"  or  22px   -->
                    <input name="ccw_options_cs[s5_color]" data-default-color="#000" value="<?= esc_attr( $ccw_style_5['s5_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>
            
            <div class="row">
                <div class="col s6">
                    <p>Color of icon - when hover  </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s5_hover_color]" data-default-color="#ddd" value="<?= esc_attr( $ccw_style_5['s5_hover_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Size of icon </p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s5_icon_size]" value="<?= esc_attr( $ccw_style_5['s5_icon_size'] ) ?>" type="text" class="" >
                </div>
            </div>

        </div>
        </li>
        </ul>

        <?php
    }


    // style - 6
    function ccw_style_6_cb() {
        $ccw_style_6 = get_option('ccw_options_cs');
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 6</div>
        <div class="collapsible-body">

            <div class="row">
                <div class="col s6">
                    <p>Color of icon</p>
                </div>
                <div class="input-field col s6">
                    <!--   style="height: 1.375rem;"  or  22px   -->
                    <input name="ccw_options_cs[s6_color]" data-default-color="#fff" value="<?= esc_attr( $ccw_style_6['s6_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>
            
            <div class="row">
                <div class="col s6">
                    <p>Color of icon - when hover </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s6_hover_color]" data-default-color="#000" value="<?= esc_attr( $ccw_style_6['s6_hover_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Size of icon</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s6_icon_size]" value="<?= esc_attr( $ccw_style_6['s6_icon_size'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Circle color </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s6_circle_background_color]" data-default-color="#ffa500" value="<?= esc_attr( $ccw_style_6['s6_circle_background_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Circle color - when hover </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s6_circle_background_hover_color]" data-default-color="#ffa500" value="<?= esc_attr( $ccw_style_6['s6_circle_background_hover_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>


            <div class="row">
                <div class="col s6">
                    <p>Circle Height</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s6_circle_height]" value="<?= esc_attr( $ccw_style_6['s6_circle_height'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Circle Width</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s6_circle_width]" value="<?= esc_attr( $ccw_style_6['s6_circle_width'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Circle Line Height</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s6_line_height]" value="<?= esc_attr( $ccw_style_6['s6_line_height'] ) ?>" type="text" class="" >
                </div>
            </div>

            <p class="description">add height, width, line-height same values - if feels like icon is not center then adjust 'Line Height' to make icon looks center of the circle</p>
            
        </div>
        </div>
        </li>
        </ul>
            
        <?php
    }



    // style - 7
    function ccw_style_7_cb() {
        $ccw_style_7 = get_option('ccw_options_cs');
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 7</div>
        <div class="collapsible-body">


            <div class="row">
                <div class="col s6">
                    <p>Color of icon</p>
                </div>
                <div class="input-field col s6">
                    <!--   style="height: 1.375rem;"  or  22px   -->
                    <input name="ccw_options_cs[s7_color]" data-default-color="#fff" value="<?= esc_attr( $ccw_style_7['s7_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>
            
            <div class="row">
                <div class="col s6">
                    <p>Color of icon - when hover </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s7_hover_color]" data-default-color="#000" value="<?= esc_attr( $ccw_style_7['s7_hover_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Size of icon</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s7_icon_size]" value="<?= esc_attr( $ccw_style_7['s7_icon_size'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>box color </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s7_box_background_color]" data-default-color="#ffa500" value="<?= esc_attr( $ccw_style_7['s7_box_background_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>box color - when hover </p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s7_box_background_hover_color]" data-default-color="#ffa500" value="<?= esc_attr( $ccw_style_7['s7_box_background_hover_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>


            <div class="row">
                <div class="col s6">
                    <p>box Height</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s7_box_height]" value="<?= esc_attr( $ccw_style_7['s7_box_height'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>box Width</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s7_box_width]" value="<?= esc_attr( $ccw_style_7['s7_box_width'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>box Line Height</p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s7_line_height]" value="<?= esc_attr( $ccw_style_7['s7_line_height'] ) ?>" type="text" class="" >
                </div>
            </div>

            <p class="description">add height, width, line-height same values - if feels like icon is not center then adjust 'Line Height' to make icon looks center of the box</p>
            
            
        </div>
        </div>
        </li>
        </ul>

        <?php
    }


    // style - 8
    function ccw_style_8_cb() {
        $ccw_style_8 = get_option('ccw_options_cs');
        $s8_icon_float = esc_attr( $ccw_style_8['s8_icon_float'] )
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 8</div>
        <div class="collapsible-body">

        
            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Color', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s8_text_color]" data-default-color="#fff" value="<?= esc_attr( $ccw_style_8['s8_text_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Background Color', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s8_background_color]" data-default-color="#26a69a" value="<?= esc_attr( $ccw_style_8['s8_background_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Icon color', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s8_icon_color]" data-default-color="#fff" value="<?= esc_attr( $ccw_style_8['s8_icon_color'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Text Color on hover', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s8_text_color_onhover]" data-default-color="#fff" value="<?= esc_attr( $ccw_style_8['s8_text_color_onhover'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Background Color on hover', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s8_background_color_onhover]" data-default-color="#26a69a" value="<?= esc_attr( $ccw_style_8['s8_background_color_onhover'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Icon color on hover', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <input name="ccw_options_cs[s8_icon_color_onhover]" data-default-color="#fff" value="<?= esc_attr( $ccw_style_8['s8_icon_color_onhover'] ) ?>" type="text" class="color-wp" style="height: 1.375rem;" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p>Icon float</p>
                </div>
                <div class="input-field col s6">
                    <select name="ccw_options_cs[s8_icon_float]" class="select-2_2">
                        <option value="left" <?= $s8_icon_float == 'left' ? 'SELECTED' : ''; ?> >left</option>
                        <option value="right" <?= $s8_icon_float == 'right' ? 'SELECTED' : ''; ?> >right</option>
                        <option value="hide" <?= $s8_icon_float == 'hide' ? 'SELECTED' : ''; ?> >hide</option>
                    </select>
                    <label>Icon flow</label>
                </div>
            </div>

            <!-- hidden value - as in array empty values are not updating .. -->
            <div class="row hide">
                <div class="col s6">
                    <p><?php _e( 'Icon size', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s8_1_width]" value="<?= esc_attr( $ccw_style_8['s8_1_width'] ) ?>" type="text" class="" >
                </div>
            </div>
        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }


    // style - 9
    function ccw_style_9_cb() {
        $ccw_style_9 = get_option('ccw_options_cs');
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Style 9</div>
        <div class="collapsible-body">
            
            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Image size', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s9_icon_size]" value="<?= esc_attr( $ccw_style_9['s9_icon_size'] ) ?>" type="text" class="" >
                </div>
            </div>
        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }


    // style - 99 - own image
    function ccw_style_99_own_img_cb() {
        $ccw_style_99_own_img = get_option('ccw_options_cs');
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header"><?php _e( 'Style 99 - own Image / GIF', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">


           <div class="row">
                <div class="input-field col s12">
                    <input name="ccw_options_cs[s99_desktop_img]" value="<?= esc_attr( $ccw_style_99_own_img['s99_desktop_img'] ) ?>" id="img-url-desktop" type="text" class="validate">
                    <label for="img-url-desktop"><?php _e( 'Image URL - Desktop', 'click-to-chat-for-whatsapp' ); ?> </label>
                    <p class="description">e.g. https://example.com/img.png - <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/style-99-own-image/">own image - style 99</a> </p>
                    <p class="description">Image / GIF </p>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input name="ccw_options_cs[s99_mobile_img]" value="<?= esc_attr( $ccw_style_99_own_img['s99_mobile_img'] ) ?>" id="img-url-mobile" type="text" class="validate">
                    <label for="img-url-mobile"><?php _e( 'Image URL - Mobile', 'click-to-chat-for-whatsapp' ); ?> </label>
                    <p class="description">e.g. https://example.com/img.png - <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/style-99-own-image/">own image - style 99</a> </p>
                </div>
            </div>

            <br><hr><br>
            <p class="description">Instead of changing the Heigth, Width - Add Image with pefect size, and keep this field blank </p>
            <p class="description">If not then add only height or width for better result ( Heigth preferred ) <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/style-99-own-image/">own image - style 99</a> </p>
            <br>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Desktop - Image Height', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s99_img_height_desktop]" value="<?= esc_attr( $ccw_style_99_own_img['s99_img_height_desktop'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Desktop - Image Width', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s99_img_width_desktop]" value="<?= esc_attr( $ccw_style_99_own_img['s99_img_width_desktop'] ) ?>" type="text" class="" >
                </div>
            </div>


            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Mobile - Image Height', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s99_img_height_mobile]" value="<?= esc_attr( $ccw_style_99_own_img['s99_img_height_mobile'] ) ?>" type="text" class="" >
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <p><?php _e( 'Mobile - Image Width', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s4">
                    <input name="ccw_options_cs[s99_img_width_mobile]" value="<?= esc_attr( $ccw_style_99_own_img['s99_img_width_mobile'] ) ?>" type="text" class="" >
                </div>
            </div>

            <p class="description">E.g. 100px </p>
            

        
        

        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }




    // Animations
    function ccw_animations_cb() {
        $ccw_animations = get_option('ccw_options_cs');
        // $an_enable = esc_attr( $ccw_animations['an_enable'] );
        $an_on_load = esc_attr( $ccw_animations['an_on_load'] );
        $an_on_hover = esc_attr( $ccw_animations['an_on_hover'] );
        
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div class="collapsible-header">Animations - alpha release </div>
        <div class="collapsible-body">
            
        <p class="description"> alpha stage, things may change, may not work as like this in next releases, </br> may need to reconfigure also .. </p>
        <p class="description"> Animations for floating styles - <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/animations/">more info</a> </p>
        <br><br>            

            
            <!-- animation on load -->
            <div class="row">
                <div class="col s6">
                    <p>Animation on Page load</p>
                </div>
                <div class="input-field col s6">
                    <select name="ccw_options_cs[an_on_load]" class="select-2_2">
                    <?php 
                    $an_list = HT_CCW_Admin_lists::$animations_list;

                    foreach ( $an_list as $value ) {
                    ?>
                    <option value="<?= $value ?>" <?= $an_on_load == $value ? 'SELECTED' : ''; ?> ><?= $value ?></option>
                    <?php
                    }

                    ?>
                    </select>
                    <label>animation on page load</label>
                </div>
            </div>

            <!-- animation on hover -->
            <div class="row">
                <div class="col s6">
                    <p>Animation on hover</p>
                </div>
                <div class="input-field col s6">
                    <select name="ccw_options_cs[an_on_hover]" class="select-2_2">
                        <option value="ccw-an" <?= $an_on_hover == 'ccw-an' ? 'SELECTED' : ''; ?> >Yes</option>
                        <option value="ccw-no-hover-an" <?= $an_on_hover == 'ccw-no-hover-an' ? 'SELECTED' : ''; ?> >No</option>
                    </select>
                    <label>Animation on mouse hover</label>
                </div>
                <p class="description">If Yes, Animation on hover - works based on - Animation  on page load - value</p>
            </div>

        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }





    // Google Analytics
    function ht_ccw_ga_cb() {
        $ht_ccw_ga = get_option('ht_ccw_ga');
        $ga_category = esc_attr( $ht_ccw_ga['ga_category'] );
        $ga_action = esc_attr( $ht_ccw_ga['ga_action'] );
        $ga_label = esc_attr( $ht_ccw_ga['ga_label'] );
        
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div id="ga-analytics" class="collapsible-header">Google Analytics </div>
        <div class="collapsible-body">
            
            <p class="description"> Enable Google Analytics at plugin home settings - <a target="_blank" href="<?= admin_url( 'admin.php?page=click-to-chat' ); ?>">Click to Chat</a>  </p>
            <p class="description"> Event Values - <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/google-analytics/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            <br><br>    

            <!-- Category Name -->
            <div class="row">
                <div class="col s6">
                    <p>Category Name</p>
                </div>
                <div class="input-field col s5">
                    <input name="ht_ccw_ga[ga_category]" value="<?= esc_attr( $ht_ccw_ga['ga_category'] ) ?>" type="text" class="" >
                </div>
            </div>

            <!-- Action Name -->
            <div class="row">
                <div class="col s6">
                    <p>Action Name</p>
                </div>
                <div class="input-field col s5">
                    <input name="ht_ccw_ga[ga_action]" value="<?= esc_attr( $ht_ccw_ga['ga_action'] ) ?>" type="text" class="" >
                </div>
            </div>

            <!-- Label Name -->
            <div class="row">
                <div class="col s6">
                    <p>Label Name</p>
                </div>
                <div class="input-field col s5">
                    <input name="ht_ccw_ga[ga_label]" value="<?= esc_attr( $ht_ccw_ga['ga_label'] ) ?>" type="text" class="" >
                </div>
            </div>
        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }


    // fb Analytics
    function ht_ccw_fb_cb() {
        $ht_ccw_fb = get_option('ht_ccw_fb');
        $fb_event_name = esc_attr( $ht_ccw_fb['fb_event_name'] );
        $p1_value = esc_attr( $ht_ccw_fb['p1_value'] );
        $p2_value = esc_attr( $ht_ccw_fb['p2_value'] );
        $p3_value = esc_attr( $ht_ccw_fb['p3_value'] );
        $p1_name = esc_attr( $ht_ccw_fb['p1_name'] );
        $p2_name = esc_attr( $ht_ccw_fb['p2_name'] );
        $p3_name = esc_attr( $ht_ccw_fb['p3_name'] );
        
        ?>
        <ul class="collapsible" data-collapsible="accordion">
        <li>
        <div id="fb-analytics" class="collapsible-header">Facebook Analytics </div>
        <div class="collapsible-body">
            
            <p class="description"> Enable Facebook Analytics at plugin home settings - <a target="_blank" href="<?= admin_url( 'admin.php?page=click-to-chat' ); ?>"><?php _e( 'Click to Chat' , 'click-to-chat-for-whatsapp' ) ?></a>  </p>
            <p class="description"> Event Parameters - <a target="_blank" href="https://holithemes.com/plugins/whatsapp-chat/facebook-analytics/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            <br><br>    

            <!-- Event Name -->
            <div class="row">
                <div class="col s6">
                    <p>Event Name</p>
                </div>
                <div class="input-field col s5">
                    <input name="ht_ccw_fb[fb_event_name]" value="<?= esc_attr( $ht_ccw_fb['fb_event_name'] ) ?>" type="text" class="" >
                </div>
            </div>

            <!-- Parameter 1 -->
            <div class="row">
                <div class="col s6">
                    <p>Custom Parameter 1</p>
                </div>
                <div class="input-field col s5">
                    
                    <div class="input-field col">
                    <input name="ht_ccw_fb[p1_name]" value="<?= esc_attr( $ht_ccw_fb['p1_name'] ) ?>" id="p1_name" type="text" class="" >
                    <label for="p1_name">Name: </label>
                    </div>

                    <div class="input-field col">
                    <input name="ht_ccw_fb[p1_value]" value="<?= esc_attr( $ht_ccw_fb['p1_value'] ) ?>" id="p1_value" type="text" class="" >
                    <label for="p1_value">Value: </label>
                    </div>

                </div>
            </div>

            
            <!-- Parameter 2 -->
            <div class="row">
                <div class="col s6">
                    <p>Custom Parameter 2</p>
                </div>
                <div class="input-field col s5">
                    
                    <div class="input-field col">
                    <input name="ht_ccw_fb[p2_name]" value="<?= esc_attr( $ht_ccw_fb['p2_name'] ) ?>" id="p2_name" type="text" class="" >
                    <label for="p2_name">Name: </label>
                    </div>

                    <div class="input-field col">
                    <input name="ht_ccw_fb[p2_value]" value="<?= esc_attr( $ht_ccw_fb['p2_value'] ) ?>" id="p2_value" type="text" class="" >
                    <label for="p2_value">Value: </label>
                    </div>

                </div>
            </div>


            <!-- Parameter 3 -->
            <div class="row">
                <div class="col s6">
                    <p>Custom Parameter 3</p>
                </div>
                <div class="input-field col s5">
                    
                    <div class="input-field col">
                    <input name="ht_ccw_fb[p3_name]" value="<?= esc_attr( $ht_ccw_fb['p3_name'] ) ?>" id="p3_name" type="text" class="" >
                    <label for="p3_name">Name: </label>
                    </div>

                    <div class="input-field col">
                    <input name="ht_ccw_fb[p3_value]" value="<?= esc_attr( $ht_ccw_fb['p3_value'] ) ?>" id="p3_value" type="text" class="" >
                    <label for="p3_value">Value: </label>
                    </div>

                </div>
            </div>
        
        </div>
        </div>
        </li>
        </ul>

        <?php
    }



    // sanitize
    function ccw_options_sanitize_cs_cb( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }
        
        $new_input = array();


        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {
                $new_input[$key] = sanitize_text_field( $input[$key] );
            }
        }


        return $new_input;
    }


}

$ccw_customize_styles = new CCW_Admin_Page_Customize_Styles();

add_action( 'admin_init', array( $ccw_customize_styles, 'customize_styles') );

endif; // END class_exists check