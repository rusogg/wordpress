<?php
/**
 * Admin settings
 *  select style
 *  postion to place
 *  
 *  same_settings - checkbox - if unchecked display setting for desktop, mobile
 * 
 * @package ctc
 * @subpackage Administration
 * @since 2.11 ( updated on 3.3.3 merged - admin-mobile, admin-dekstop.php )
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// style
$style_desktop = ( isset( $options['style_desktop']) ) ? esc_attr( $options['style_desktop'] ) : '';
$style_mobile = ( isset( $options['style_mobile']) ) ? esc_attr( $options['style_mobile'] ) : '';


// desktop position
$side_1 = ( isset( $options['side_1']) ) ? esc_attr( $options['side_1'] ) : '';
$side_1_value = ( isset( $options['side_1_value']) ) ? esc_attr( $options['side_1_value'] ) : '';
$side_2 = ( isset( $options['side_2']) ) ? esc_attr( $options['side_2'] ) : '';
$side_2_value = ( isset( $options['side_2_value']) ) ? esc_attr( $options['side_2_value'] ) : '';

// mobile position
$mobile_side_1 = ( isset( $options['mobile_side_1']) ) ? esc_attr( $options['mobile_side_1'] ) : '';
$mobile_side_1_value = ( isset( $options['mobile_side_1_value'])) ? esc_attr( $options['mobile_side_1_value'] ) : '';
$mobile_side_2 = ( isset( $options['mobile_side_2']) ) ? esc_attr( $options['mobile_side_2'] ) : '';
$mobile_side_2_value = ( isset( $options['mobile_side_2_value'])) ? esc_attr( $options['mobile_side_2_value'] ) : '';

$position_type = ( isset( $options['position_type']) ) ? esc_attr( $options['position_type'] ) : 'fixed';
$position_type_mobile = ( isset( $options['position_type_mobile']) ) ? esc_attr( $options['position_type_mobile'] ) : 'fixed';

$position_type_values = [
    'fixed' => 'Fixed'
];

$position_type_values = apply_filters( 'ht_ctc_fh_position_type_values', $position_type_values );

?>

<ul class="collapsible ht_ctc_device_settings">
<li class="">
<div class="collapsible-header"><?php _e( 'Style, Position - Desktop, Mobile', 'click-to-chat-for-whatsapp' ); ?></div>
<div class="collapsible-body">

<blockquote class="not_samesettings" style="margin-bottom: 25px;">Desktop:</blockquote>

<!-- style -->
<p class="description ht_ctc_admin_desktop ht_ctc_subtitle"><?php _e( 'Select Style', 'click-to-chat-for-whatsapp' ); ?> <span class="not_samesettings"><?php _e( ' (Desktop)', 'click-to-chat-for-whatsapp' ); ?></span>:</p class="description">
<div class="row ht_ctc_admin_desktop">
    <div class="input-field col s12 m12">
        <select name="<?= $dbrow; ?>[style_desktop]" class="chat_select_style select_style_desktop">
            <option value="1" <?= $style_desktop == 1 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="2" <?= $style_desktop == 2 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-2', 'click-to-chat-for-whatsapp' ); ?></option>
            <!-- <optgroup label="Style 3"> -->
            <option value="3" <?= $style_desktop == 3 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-3', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="3_1" <?= $style_desktop == '3_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-3 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
            <!-- </optgroup> -->
            <option value="4" <?= $style_desktop == 4 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-4', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="5" <?= $style_desktop == 5 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-5', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="6" <?= $style_desktop == 6 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-6', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="7" <?= $style_desktop == 7 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-7', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="7_1" <?= $style_desktop == '7_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-7 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="8" <?= $style_desktop == 8 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-8', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="99" <?= $style_desktop == 99 ? 'SELECTED' : ''; ?> ><?php _e( 'Add your own image / GIF (Style-99)', 'click-to-chat-for-whatsapp' ); ?></option>
        </select>
        <p class="description"><a style="background-color: #26a69a; color: #fff; padding: 5px;" target="_blank" href="https://holithemes.com/plugins/click-to-chat/list-of-styles/?utm_source=ctc&utm_medium=admin&utm_campaign=chat"><?php _e( 'List of Styles', 'click-to-chat-for-whatsapp' ); ?></a> &emsp; | &emsp; <span><?php _e( 'Customize the styles', 'click-to-chat-for-whatsapp' ); ?>  <a target="_blank" class="customize_styles_link" href="<?= admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>">( Click to Chat -> Customize )</a></span> </p>
    </div>
</div>

<!-- position type -->
<p class="description ht_ctc_admin_desktop ht_ctc_subtitle"><?php _e( 'Position Type', 'click-to-chat-for-whatsapp' ); ?> <span class="not_samesettings"><?php _e( ' (Desktop)', 'click-to-chat-for-whatsapp' ); ?></span>:</p>
<div class="row ht_ctc_admin_desktop">
    <div class="input-field col s12 m12">
        <select name="<?php echo $dbrow ?>[position_type]" class="chat_select_position_type">
            <?php
            foreach ($position_type_values as $key => $value) {
                ?>
                <option value="<?= $key ?>" <?php echo $position_type == $key ? 'SELECTED' : ''; ?> ><?php _e( $value, 'click-to-chat-for-whatsapp' ); ?></option>
                <?php
            }
            ?>
        </select>
        <p class="description"><?php _e( 'Fixed: Position relative to the screen, stays at the same place even after page scroll', 'click-to-chat-for-whatsapp' ); ?></p>
        <p class="description"><?php _e( 'Absolute: Position relative to the content (body tag) and moves with page scroll', 'click-to-chat-for-whatsapp' ); ?> (PRO) - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/position-to-place/#pro_block">more info</a></p>
    </div>
</div>

<?php
// Action hook - After select style - Desktop
// do_action('ht_ctc_ah_admin_desktop_after_select_sytle', $options, $dbrow );
?>

<!-- Desktop position -->
<!-- side - 1 -->
<p class="description ht_ctc_admin_desktop ht_ctc_subtitle"><?php _e( 'Position to Place', 'click-to-chat-for-whatsapp' ); ?> <span class="not_samesettings"><?php _e( ' (Desktop)', 'click-to-chat-for-whatsapp' ); ?></span>:</p>
<div class="row ht_ctc_admin_desktop">
    <br>
    <div class="input-field col s6">
        <select name="<?= $dbrow; ?>[side_1]" class="position_bottom_top">
            <option value="bottom" <?= $side_1 == 'bottom' ? 'SELECTED' : ''; ?> ><?php _e( 'bottom', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="top" <?= $side_1 == 'top' ? 'SELECTED' : ''; ?> ><?php _e( 'top', 'click-to-chat-for-whatsapp' ); ?></option>
        </select>
        <label>top / bottom </label>
    </div>
    <div class="input-field col s6">
        <input name="<?= $dbrow; ?>[side_1_value]" value="<?= $side_1_value ?>" id="side_1_value" type="text" class="input-margin position_bottom_top_value">
        <label for="side_1_value"><?php _e( 'E.g. 10px', 'click-to-chat-for-whatsapp' ); ?></label>
    </div>
</div>

<!-- side - 2 -->
<div class="row ht_ctc_admin_desktop" style="margin-bottom:0;">
    <div class="input-field col s6">
        <select name="<?= $dbrow; ?>[side_2]" class="position_right_left">
            <option value="right" <?= $side_2 == 'right' ? 'SELECTED' : ''; ?> ><?php _e( 'right', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="left" <?= $side_2 == 'left' ? 'SELECTED' : ''; ?> ><?php _e( 'left', 'click-to-chat-for-whatsapp' ); ?></option>
        </select>
        <label><?php _e( 'right / left', 'click-to-chat-for-whatsapp' ); ?></label>
    </div>

    <div class="input-field col s6">
        <input name="<?= $dbrow; ?>[side_2_value]" value="<?= $side_2_value ?>" id="side_2_value" type="text" class="input-margin position_right_left_value">
        <label for="side_2_value"><?php _e( 'E.g. 50%', 'click-to-chat-for-whatsapp' ); ?></label>
    </div>
</div>
<p class="description ht_ctc_admin_desktop"><?php _e( 'Add css units as suffix - e.g. 10px, 50%', 'click-to-chat-for-whatsapp' ); ?> - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/position-to-place/?utm_source=ctc&utm_medium=admin&utm_campaign=chat">more info</a> </p>



<br><br>

<?php

// Same setting for Mobile Devices
if ( isset( $options['same_settings'] ) ) {
    ?>
    <p style="margin-bottom: 25px;">
        <label>
            <input name="<?= $dbrow; ?>[same_settings]" type="checkbox" value="1" <?php checked( $options['same_settings'], 1 ); ?> class="same_settings" id="same_settings" />
            <span><?php _e( 'Mobile and Desktop same setttings', 'click-to-chat-for-whatsapp' ); ?></span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p style="margin-bottom: 25px;">
        <label>
            <input name="<?= $dbrow; ?>[same_settings]" type="checkbox" value="1" class="same_settings" id="same_settings" />
            <span><?php _e( 'Mobile and Desktop same setttings', 'click-to-chat-for-whatsapp' ); ?></span>
        </label>
    </p>
    <?php
}

?>

<blockquote class="not_samesettings " style="margin-bottom: 25px;"><?php _e( 'Mobile', 'click-to-chat-for-whatsapp' ); ?>:</blockquote>

<!-- style -->
<p class="description ht_ctc_admin_mobile ht_ctc_subtitle not_samesettings"><?php _e( 'Select Style (Mobile)', 'click-to-chat-for-whatsapp' ); ?>:</p class="description">
<div class="row ht_ctc_admin_mobile not_samesettings">
    <div class="input-field col s12 m12">
        <select name="<?= $dbrow; ?>[style_mobile]" class="chat_select_style select_style_mobile">
            <option value="1" <?= $style_mobile == 1 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="2" <?= $style_mobile == 2 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-2', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="3" <?= $style_mobile == 3 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-3', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="3_1" <?= $style_mobile == '3_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-3 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="4" <?= $style_mobile == 4 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-4', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="5" <?= $style_mobile == 5 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-5', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="6" <?= $style_mobile == 6 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-6', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="7" <?= $style_mobile == 7 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-7', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="7_1" <?= $style_mobile == '7_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-7 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="8" <?= $style_mobile == 8 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-8', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="99" <?= $style_mobile == 99 ? 'SELECTED' : ''; ?> ><?php _e( 'Add your own image / GIF (Style-99)', 'click-to-chat-for-whatsapp' ); ?></option>
        </select>
        <p class="description"><a style="background-color: #26a69a; color: #fff; padding: 5px;" target="_blank" href="https://holithemes.com/plugins/click-to-chat/list-of-styles/?utm_source=ctc&utm_medium=admin&utm_campaign=chat"><?php _e( 'List of Styles', 'click-to-chat-for-whatsapp' ); ?></a> &emsp; | &emsp; <span><?php _e( 'Customize the styles', 'click-to-chat-for-whatsapp' ); ?>  <a target="_blank" class="customize_styles_link" href="<?= admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>">( Click to Chat -> Customize )</a></span> </p>
    </div>
</div>

<!-- position type - mobile -->
<p class="description ht_ctc_admin_mobile ht_ctc_subtitle not_samesettings"><?php _e( 'Position Type', 'click-to-chat-for-whatsapp' ); ?>:</p class="description">
<div class="row ht_ctc_admin_mobile not_samesettings">
    <div class="input-field col s12 m12">
        <select name="<?php echo $dbrow ?>[position_type_mobile]" class="chat_select_position_type">
            <?php
            foreach ($position_type_values as $key => $value) {
                ?>
                <option value="<?= $key ?>" <?php echo $position_type_mobile == $key ? 'SELECTED' : ''; ?> ><?php _e( $value, 'click-to-chat-for-whatsapp' ); ?></option>
                <?php
            }
            ?>
        </select>
        <p class="description"><?php _e( 'Fixed: Position relative to the screen, stays at the same place even after page scroll', 'click-to-chat-for-whatsapp' ); ?></p>
        <p class="description"><?php _e( 'Absolute: Position relative to the content (body tag) and moves with page scroll', 'click-to-chat-for-whatsapp' ); ?> (PRO) - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/position-to-place/#pro_block">more info</a></p>
    </div>
</div>

<?php
// Action hook - After select style - Mobile
// do_action('ht_ctc_ah_admin_mobile_after_select_sytle', $options, $dbrow );
?>

<!-- Mobile position -->
<!-- side - 1 -->
<p class="description ht_ctc_admin_mobile ht_ctc_subtitle not_samesettings"><?php _e( 'Position to Place (Mobile)', 'click-to-chat-for-whatsapp' ); ?>:</p>
<div class="row ht_ctc_admin_mobile not_samesettings">
    <br>
    <div class="input-field col s6">
        <select name="<?= $dbrow; ?>[mobile_side_1]" class="select-2">
            <option value="bottom" <?= $mobile_side_1 == 'bottom' ? 'SELECTED' : ''; ?> ><?php _e( 'bottom', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="top" <?= $mobile_side_1 == 'top' ? 'SELECTED' : ''; ?> ><?php _e( 'top', 'click-to-chat-for-whatsapp' ); ?></option>
        </select>
        <label>top / bottom </label>
    </div>
    <div class="input-field col s6">
        <input name="<?= $dbrow; ?>[mobile_side_1_value]" value="<?= $mobile_side_1_value ?>" id="mobile_side_1_value" type="text" class="input-margin">
        <label for="mobile_side_1_value"><?php _e( 'E.g. 10px', 'click-to-chat-for-whatsapp' ); ?></label>
    </div>
</div>

<!-- side - 2 -->
<div class="row ht_ctc_admin_mobile not_samesettings" style="margin-bottom:0;">
    <div class="input-field col s6">
        <select name="<?= $dbrow; ?>[mobile_side_2]" class="select-2">
            <option value="right" <?= $mobile_side_2 == 'right' ? 'SELECTED' : ''; ?> ><?php _e( 'right', 'click-to-chat-for-whatsapp' ); ?></option>
            <option value="left" <?= $mobile_side_2 == 'left' ? 'SELECTED' : ''; ?> ><?php _e( 'left', 'click-to-chat-for-whatsapp' ); ?></option>
        </select>
        <label><?php _e( 'right / left', 'click-to-chat-for-whatsapp' ); ?></label>
    </div>

    <div class="input-field col s6">
        <input name="<?= $dbrow; ?>[mobile_side_2_value]" value="<?= $mobile_side_2_value ?>" id="mobile_side_2_value" type="text" class="input-margin">
        <label for="mobile_side_2_value"><?php _e( 'E.g. 50%', 'click-to-chat-for-whatsapp' ); ?></label>
    </div>
</div>
<p class="description ht_ctc_admin_mobile not_samesettings"><?php _e( 'Add css units as suffix - e.g. 10px, 50%', 'click-to-chat-for-whatsapp' ); ?> - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/position-to-place/?utm_source=ctc&utm_medium=admin&utm_campaign=chat"><?php _e( 'more info', 'click-to-chat-for-whatsapp' ); ?></a> </p>



<br class="not_samesettings">
<hr class="not_samesettings" style="max-width: 500px;">
<br class="not_samesettings">
<p class="description"><span class="not_samesettings select_styles_issue_description" style="font-size: 0.7em;">If Styles for desktop, mobile not selected as expected <span style="color: #039be5; cursor: pointer;">Check this</span>, - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/select-styles/?utm_source=ctc&utm_medium=admin&utm_campaign=chat">more info</a></span></p>

<div class="select_styles_issue_checkbox ctc_init_display_none" style="">
    <?php
    // If checked loads both styles and display the needed style
    // cache issue while selecting styles
    if ( isset( $options['select_styles_issue'] ) ) {
        ?>
        <p id="styles_issue">
            <label>
                <input name="<?= $dbrow; ?>[select_styles_issue]" type="checkbox" value="1" <?php checked( $options['select_styles_issue'], 1 ); ?> id="select_styles_issue" />
                <!-- <span>Style for device is not as expected(due to cache)</span> -->
                <span><?php _e( 'Check this only, If styles for mobile, desktop not selected as expected(due to cache)', 'click-to-chat-for-whatsapp' ); ?></span>
            </label>
        </p>
        <?php
    } else {
        ?>
        <p id="styles_issue">
            <label>
                <input name="<?= $dbrow; ?>[select_styles_issue]" type="checkbox" value="1" id="select_styles_issue" />
                <span><?php _e( 'Check this, If styles for mobile, desktop not selected as expected(due to cache)', 'click-to-chat-for-whatsapp' ); ?></span>
            </label>
        </p>
        <?php
    }
    ?>
</div>

</div>
</div>
</li>
</ul>