<?php
/**
 * icon with padding borderr
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s7_1_options = get_option( 'ht_ctc_s7_1' );

$s7_icon_size = esc_attr( $s7_1_options['s7_icon_size'] );
$s7_icon_color = esc_attr( $s7_1_options['s7_icon_color'] );
$s7_icon_color_hover = esc_attr( $s7_1_options['s7_icon_color_hover'] );
$s7_bgcolor = esc_attr( $s7_1_options['s7_bgcolor'] );
$s7_bgcolor_hover = esc_attr( $s7_1_options['s7_bgcolor_hover'] );

// Call to action 
$s7_cta_type = (isset( $s7_1_options['cta_type'])) ? esc_attr( $s7_1_options['cta_type'] ) : 'hover';

// Call to action - Order
$s7_cta_order = "1";
$s7_cta_padding_css = "padding-right: 21px;";
// $s7_cta_padding_css = "padding-left: 21px;";

$s7_n1_styles = "display:inline-flex;justify-content:center;align-items:center;";
$s7_cta_css = "";
$s7_icon_padding_css = "";
$s7_cta_class = "ht-ctc-cta ";

// hover style is not there in shortcodes.. 
$s7_n1_styles .= "padding:5px 25px; background-color:$s7_bgcolor;border-radius:25px;";
$s7_cta_css .= "padding: 1px 16px; color: $s7_icon_color; border-radius:10px; margin:0 10px; order: $s7_cta_order; ";
$s7_icon_padding_css .= "";

// $s7_mouse_hover = "this.style.backgroundColor= '$s7_bgcolor_hover', this.querySelector('.ctc_s_7_1_cta').style.color= '$s7_icon_color_hover', this.querySelector('svg g path').style.fill= '$s7_icon_color_hover' ";
// $s7_mouse_out = "this.style.backgroundColor= '$s7_bgcolor', this.querySelector('.ctc_s_7_1_cta').style.color= '$s7_icon_color', this.querySelector('svg g path').style.fill= '$s7_icon_color' ";
// onmouseover="'.$s7_mouse_hover.'" onmouseout="'.$s7_mouse_out.'"

// svg values
$ht_ctc_svg_css = "pointer-events:none; display:block; height:$s7_icon_size; width:$s7_icon_size;";
$s7_svg_attrs = array(
    'color' => "$s7_icon_color",
    'icon_size' => "$s7_icon_size",
    'type' => "$type",
    'ht_ctc_svg_css' => "$ht_ctc_svg_css",
);

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';

$style_7_1_svg = ht_ctc_singlecolor( $s7_svg_attrs );

$o .= '<style id="ht-ctc-sc-s7_1">';
$o .= '.ht-ctc-sc.sc-style-7_1:hover .ctc_s_7_1{background-color:'.$s7_bgcolor_hover.' !important;}.ht-ctc-sc.sc-style-7_1:hover .ctc_s_7_1_cta{color:'.$s7_icon_color_hover.' !important;}.ht-ctc-sc.sc-style-7_1:hover svg g path{fill:'.$s7_icon_color_hover.' !important;}';
$o .= '</style>';

$o .=  '
    <div class="ctc_s_7_1 ctc-analytics" style="'.$s7_n1_styles.'">
        <p class="ctc_s_7_1_cta ctc-analytics ctc_cta '.$s7_cta_class.'" style="'.$s7_cta_css.'">'.$call_to_action.'</p>
        <div class="ctc_s_7_icon_padding ctc-analytics " style="'.$s7_icon_padding_css.'">
            '.$style_7_1_svg.'
        </div>
    </div>
';