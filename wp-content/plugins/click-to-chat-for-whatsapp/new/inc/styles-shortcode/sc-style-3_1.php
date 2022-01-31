<?php
/**
 * sc s3 Extend
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s3_1_options = get_option( 'ht_ctc_s3_1' );

$s3_type = ( isset( $s3_1_options['s3_type']) ) ? esc_attr( $s3_1_options['s3_type'] ) : 'simple';

$img_size = esc_attr( $s3_1_options['s3_img_size'] );
if ( '' == $img_size ) {
    $img_size = "40px";
}

$ht_ctc_svg_css = "pointer-events:none; display:block; height:$img_size; width:$img_size;";

$s3_img_link = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';

$s3_padding = ( isset( $s3_1_options['s3_padding']) ) ? esc_attr( $s3_1_options['s3_padding'] ) : '';
$s3_bg_color = ( isset( $s3_1_options['s3_bg_color']) ) ? esc_attr( $s3_1_options['s3_bg_color'] ) : '#25D366';
$s3_bg_color_hover = ( isset( $s3_1_options['s3_bg_color_hover']) ) ? esc_attr( $s3_1_options['s3_bg_color_hover'] ) : '#25D366';

$s3_box_shadow = "";
if ( isset( $s3_1_options['s3_box_shadow'])) {
    $s3_box_shadow = "box-shadow: 0px 0px 11px rgba(0,0,0,.5);";
}
$s3_extend_css = "background-color: $s3_bg_color; padding: $s3_padding; border-radius: 50%; $s3_box_shadow";

$s3_box_shadow_hover = "";
if ( isset( $s3_1_options['s3_box_shadow_hover'])) {
    $s3_box_shadow_hover = "box-shadow: 0px 0px 11px rgba(0,0,0,.5);";
}
// hover css
$s3_hover_css = "background-color:$s3_bg_color_hover !important;$s3_box_shadow_hover";

$others = array(
    'bg_color' => "$s3_bg_color",
);

$style_3_extend_svg = ht_ctc_style_3_1_svg( $img_size, $type, $ht_ctc_svg_css, $others );;


// styles
$o .= '<style id="ht-ctc-sc-s8">';
$o .= '.ht-ctc-sc:hover svg stop{stop-color:'.$s3_bg_color_hover.';}.ht-ctc-sc:hover .ht_ctc_padding{'.$s3_hover_css.'}';
$o .= '</style>';


$s3_extend = '';
$s3_extend .= '
<div title="'.$call_to_action.'" class="ctc-analytics ht_ctc_padding" style="'.$s3_extend_css.' display:inline-block;">
    '.$style_3_extend_svg.'
</div>
';

$o .= $s3_extend;