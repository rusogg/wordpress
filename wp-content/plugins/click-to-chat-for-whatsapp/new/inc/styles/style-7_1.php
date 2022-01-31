<?php
/**
 * Style - 7
 * icon with customize padding
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// shadow
// 0px 0px 11px rgba(0,0,0,.5)  /   5px 5px 11px #888888
// $s7_bs = "box-shadow: 5px 5px 11px rgba(0,0,0,.5);";
// $s7_bs = "box-shadow: 2px 2px 6px rgba(0,0,0,.5);";
// $s7_box_shadow = "";
// if ( !isset( $s7_options['s3_box_shadow'])) {
//     $s7_box_shadow = "$s7_bs ";
// }
// $s7_box_shadow_hover = "";
// if ( isset( $s7_options['s7_box_shadow_hover'])) {
//     $s7_box_shadow_hover = "$s7_bs ";
// }

$s7_1_options = get_option( 'ht_ctc_s7_1' );
$s7_1_options = apply_filters( 'ht_ctc_fh_s7_1_options', $s7_1_options );

$s7_icon_size = esc_attr( $s7_1_options['s7_icon_size'] );
$s7_icon_color = esc_attr( $s7_1_options['s7_icon_color'] );
$s7_icon_color_hover = esc_attr( $s7_1_options['s7_icon_color_hover'] );
$s7_bgcolor = esc_attr( $s7_1_options['s7_bgcolor'] );
$s7_bgcolor_hover = esc_attr( $s7_1_options['s7_bgcolor_hover'] );
$s7_border_size = esc_attr( $s7_1_options['s7_border_size'] );

// Call to action 
$s7_cta_type = (isset( $s7_1_options['cta_type'])) ? esc_attr( $s7_1_options['cta_type'] ) : 'hover';
$s7_1_cta_font_size = (isset( $s7_1_options['cta_font_size'])) ? esc_attr( $s7_1_options['cta_font_size'] ) : '';

$s7_1_cta_font_size = ('' !== $s7_1_cta_font_size) ? "font-size: $s7_1_cta_font_size" : "";

// Call to action - Order
$s7_cta_order = "1";
$s7_hover_cta_padding_css = "padding-right: 21px;";
$s7_show_cta_padding_css = "padding:5px 5px 5px 20px;";
if ( isset($side_2) && 'right' == $side_2) {
    // if side_2 is right then cta is left
    $s7_cta_order = "0";
    $s7_hover_cta_padding_css = "padding-left: 21px;";
    $s7_show_cta_padding_css = "padding:5px 20px 5px 5px;";
}

$rtl_css = "";
if ( function_exists('is_rtl') && is_rtl() ) {
    $rtl_css = "flex-direction:row-reverse;";

    if ('right' == $side_2) {
        $s7_show_cta_padding_css = "padding:5px 5px 5px 20px;";
    } else {
        $s7_show_cta_padding_css = "padding:5px 20px 5px 5px;";
    }
}

$s7_n1_styles = "display:flex;justify-content:center;align-items:center;$rtl_css ";
$s7_cta_css = "$s7_1_cta_font_size; ";
$s7_icon_padding_css = "";
$s7_cta_class = "ht-ctc-cta ";
$s7_hover_styles = "";
if ( 'hover' == $s7_cta_type ) {
    $s7_n1_styles .= "background-color: $s7_bgcolor; border-radius:25px;";
    $s7_cta_css .= " display: none; order: $s7_cta_order; color: $s7_icon_color; $s7_hover_cta_padding_css  margin:0 10px; border-radius: 25px; ";
    $s7_cta_class .= " ht-ctc-cta-hover ";
    $s7_icon_padding_css .= "padding: $s7_border_size;background-color: $s7_bgcolor;border-radius: 25px; ";
    $s7_hover_styles = ".ht-ctc.style-7_1:hover .ctc_s_7_icon_padding, .ht-ctc.style-7_1:hover .ctc_s_7_1{background-color:$s7_bgcolor_hover !important;border-radius: 25px;}.ht-ctc.style-7_1:hover .ctc_s_7_1_cta{color:$s7_icon_color_hover !important;}.ht-ctc.style-7_1:hover svg g path{fill:$s7_icon_color_hover !important;}";
} elseif ( 'show' == $s7_cta_type ) {
    $s7_n1_styles .= "$s7_show_cta_padding_css background-color:$s7_bgcolor;border-radius:25px;";
    $s7_cta_css .= "padding: 1px 16px; color: $s7_icon_color; border-radius:10px; margin:0 10px; order: $s7_cta_order; ";
    $s7_icon_padding_css .= "";
    $s7_hover_styles = ".ht-ctc.style-7_1:hover .ctc_s_7_1{background-color:$s7_bgcolor_hover !important;}.ht-ctc.style-7_1:hover .ctc_s_7_1_cta{color:$s7_icon_color_hover !important;}.ht-ctc.style-7_1:hover svg g path{fill:$s7_icon_color_hover !important;}";
}


// svg values
$ht_ctc_svg_css = "pointer-events:none; display:block; height:$s7_icon_size; width:$s7_icon_size;";
$s7_svg_attrs = array(
    'color' => "$s7_icon_color",
    'icon_size' => "$s7_icon_size",
    'type' => "$type",
    'ht_ctc_svg_css' => "$ht_ctc_svg_css",
);


include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';
?>
<style id="ht-ctc-s7_1">
<?= $s7_hover_styles ?>
</style>

<div class="ctc_s_7_1 ctc-analytics" style="<?= $s7_n1_styles; ?>">
    <p class="ctc_s_7_1_cta ctc-analytics ctc_cta <?= $s7_cta_class ?>" style="<?= $s7_cta_css ?>"><?= $call_to_action; ?></p>
    <div class="ctc_s_7_icon_padding ctc-analytics " style="<?= $s7_icon_padding_css ?>">
        <?= ht_ctc_singlecolor( $s7_svg_attrs ); ?>
    </div>
</div>