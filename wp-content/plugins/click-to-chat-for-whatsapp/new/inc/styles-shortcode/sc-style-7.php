<?php
/**
 * icon with padding borderr
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s7_options = get_option( 'ht_ctc_s7' );

$s7_icon_size = esc_attr( $s7_options['s7_icon_size'] );
$s7_icon_color = esc_attr( $s7_options['s7_icon_color'] );
$s7_icon_color_hover = esc_attr( $s7_options['s7_icon_color_hover'] );
$s7_border_size = esc_attr( $s7_options['s7_border_size'] );
$s7_border_color = esc_attr( $s7_options['s7_border_color'] );
$s7_border_color_hover = esc_attr( $s7_options['s7_border_color_hover'] );
$s7_border_radius = esc_attr( $s7_options['s7_border_radius'] );

// Call to action 
$s7_cta_type = (isset( $s7_options['cta_type'])) ? esc_attr( $s7_options['cta_type'] ) : 'hover';
$s7_cta_textcolor = (isset( $s7_options['cta_textcolor'])) ? esc_attr( $s7_options['cta_textcolor'] ) : '';
$s7_cta_bgcolor = (isset( $s7_options['cta_bgcolor'])) ? esc_attr( $s7_options['cta_bgcolor'] ) : '#ffffff';

$s7_n1_styles = "display:inline-flex;justify-content:center;align-items:center;";
$s7_icon_css = "font-size: $s7_icon_size; color: $s7_icon_color; padding: $s7_border_size; background-color: $s7_border_color; border-radius: $s7_border_radius;";

// Call to action 
$s7_cta_order = "1";

$s7_cta_css = "padding: 0px 16px; color: $s7_cta_textcolor; background-color: $s7_cta_bgcolor; border-radius:10px; margin:0 10px; ";
$s7_cta_class = "ht-ctc-cta ";
$title = "";
if ( 'hover' == $s7_cta_type ) {
    $s7_cta_css .= " display: none; order: $s7_cta_order; ";
    $s7_cta_class .= " ht-ctc-cta-hover ";
    $title = "title = '$call_to_action'";
} elseif ( 'show' == $s7_cta_type ) {
    $s7_cta_css .= "order: $s7_cta_order; ";
} elseif ( 'hide' == $s7_cta_type ) {
    $s7_cta_css .= " display: none; ";
    $title = "title = '$call_to_action'";
}

// svg values
$ht_ctc_svg_css = "pointer-events:none; display:block; height:$s7_icon_size; width:$s7_icon_size;";
$s7_svg_attrs = array(
    'color' => "$s7_icon_color",
    'icon_size' => "$s7_icon_size",
    'type' => "$type",
    'ht_ctc_svg_css' => "$ht_ctc_svg_css",
);


// hover (call to action hover effects is not there for shortcodes - as it may moves posts content. )(javascript have to display cta on hover)
$s7_hover_icon_styles = ".ht-ctc-sc.sc-style-7:hover .ctc_s_7_icon_padding{background-color:$s7_border_color_hover !important;}.ht-ctc-sc.sc-style-7:hover svg g path{fill:$s7_icon_color_hover !important;}";

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';

$style_7_svg = ht_ctc_singlecolor( $s7_svg_attrs );


$o .= '<style id="ht-ctc-sc-s7">';
$o .= '.ht-ctc-sc.sc-style-7:hover .ctc_s_7_icon_padding{background-color:'.$s7_border_color_hover.' !important;}.ht-ctc-sc.sc-style-7:hover svg g path{fill:'.$s7_icon_color_hover.' !important;}';
$o .= '</style>';

$o .= '
    <div '.$title.' class="ctc_s_7 ctc-analytics" style="'.$s7_n1_styles.'">
        <p class="ctc_s_7_cta ctc-analytics ctc_cta '.$s7_cta_class.'" style="'.$s7_cta_css.'">'.$call_to_action.'</p>
        <div class="ctc_s_7_icon_padding ctc-analytics " style="'.$s7_icon_css.'">
            '.$style_7_svg.'
        </div>
    </div>
';