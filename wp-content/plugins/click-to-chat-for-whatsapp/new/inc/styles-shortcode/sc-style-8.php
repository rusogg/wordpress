<?php
/**
 * materialize button
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s8_options = get_option( 'ht_ctc_s8' );

$s8_icon_color = esc_attr( $s8_options['s8_icon_color'] );
$s8_icon_color_on_hover = esc_attr( $s8_options['s8_icon_color_on_hover'] );
$s8_txt_color = esc_attr( $s8_options['s8_txt_color'] );
$s8_txt_color_on_hover = esc_attr( $s8_options['s8_txt_color_on_hover'] );
$s8_bg_color = esc_attr( $s8_options['s8_bg_color'] );
$s8_bg_color_on_hover = esc_attr( $s8_options['s8_bg_color_on_hover'] );

$s8_btn_size = esc_attr( $s8_options['s8_btn_size'] );

$s8_icon_size = ('' == esc_attr( $s8_options['s8_icon_size'] )) ? "17px" : esc_attr( $s8_options['s8_icon_size'] );

$s8_text_size = esc_attr( $s8_options['s8_text_size'] );
$s8_text_size_css = ('' == $s8_text_size) ? "" : "font-size: $s8_text_size;";
// $s8_text_size_css = ('' == $s8_text_size) ? "font-size: 16px;" : "font-size: $s8_text_size;";

$s8_icon_position = esc_attr( $s8_options['s8_icon_position'] );

// shortcode attributes 
$s8_width_sc   = $a["s8_width"];
// left/right/hide or any thing to display icon just before the text
$s8_icon_position_sc   = $a["s8_icon_position"];

$s8_width_css = '';
if ( '' !== $s8_width_sc ) {
  $s8_width_css = "width: $s8_width_sc;";
}

if ( '' !== $s8_icon_position_sc ) {
  $s8_icon_position = $s8_icon_position_sc;
}

$s8_height = '36px';
if ('btn-large' == $s8_btn_size) {
  $s8_height = '54px';
}

$s8_icon_css = ( 'right' == $s8_icon_position ) ? "order:1;margin-left: 15px;" : "order:0;margin-right: 15px;";
$s8_text_css = "color:$s8_txt_color; $s8_text_size_css ";
$s8_main_span_css = "display: flex;padding: 0 2rem;letter-spacing: .5px;transition: .2s ease-out;text-align: center;justify-content: center;align-items: center;border-radius:2px;height:$s8_height;line-height:$s8_height;vertical-align:middle;box-shadow:0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12), 0 3px 1px -2px rgba(0,0,0,.2);box-sizing:inherit;background-color:$s8_bg_color;";

$s8_svg_attrs = array (
  'color' => "$s8_icon_color",
  'icon_size' => "$s8_icon_size",
  'type' => "$type",
  'ht_ctc_svg_css' => 'display:block;',
);

$style_8_svg = "";
if ('hide' !== $s8_icon_position) {
  include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';
  $style_8_svg = ht_ctc_singlecolor( $s8_svg_attrs );
}

// styles
$o .= '<style>';
$o .= '.ht-ctc-sc .ht-ctc-style-8 .s_8 svg{'.$s8_icon_css.'}.ht-ctc-sc:hover svg g path{fill:'.$s8_txt_color_on_hover.' !important;}.ht-ctc-sc:hover .ht-ctc-s8-text{color:'.$s8_txt_color_on_hover.' !important;}.ht-ctc-sc:hover .ht-ctc-style-8 .s_8{box-shadow: 0 3px 3px 0 rgba(7,6,6,.14), 0 1px 7px 0 rgba(0,0,0,.12), 0 3px 1px -1px rgba(0,0,0,.2) !important; transition: .2s ease-out !important; background-color:'.$s8_bg_color_on_hover.' !important; }';
$o .= '</style>';

$o .=  '
  <div class="ht-ctc-style-8 ctc-analytics" style="display: inline-block; '.$s8_width_css.' " >
    <span class="s_8 waves-effect waves-light ctc-analytics" style="'.$s8_main_span_css.' ">
      '.$style_8_svg.'
      <span class="ht-ctc-s8-text s8_span ctc-analytics ctc_cta" style="'.$s8_text_css.'">
        '.$call_to_action.'
      </span>
    </span>
  </div>
';
