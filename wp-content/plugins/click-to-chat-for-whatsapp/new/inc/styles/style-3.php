<?php
/**
 * Style - 3
 * 
 * WhatsApp icon
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s3_options = get_option( 'ht_ctc_s3' );
$s3_options = apply_filters( 'ht_ctc_fh_s3_options', $s3_options );
$s3_type = ( isset( $s3_options['s3_type']) ) ? esc_attr( $s3_options['s3_type'] ) : 'simple';

$s3_img_size = esc_attr( $s3_options['s3_img_size'] );
$img_size = esc_attr( $s3_options['s3_img_size'] );
if ( '' == $img_size ) {
    $img_size = "50px";
}

// Call to action 
$s3_cta_type = (isset( $s3_options['cta_type'])) ? esc_attr( $s3_options['cta_type'] ) : 'hover';

$rtl_css = "";
if ( function_exists('is_rtl') && is_rtl() ) {
    $rtl_css = "flex-direction:row-reverse;";
}

$s3_cta_order = "1";
if ( isset($side_2) && 'right' == $side_2) {
    // if side_2 is right then cta is left
    $s3_cta_order = "0";
}

$s3_css = "display:flex;justify-content:center;align-items:center;$rtl_css ";
$s3_cta_textcolor = (isset( $s3_options['cta_textcolor'])) ? esc_attr( $s3_options['cta_textcolor'] ) : '';
$s3_cta_bgcolor = (isset( $s3_options['cta_bgcolor'])) ? esc_attr( $s3_options['cta_bgcolor'] ) : '#ffffff';
$s3_cta_font_size = (isset( $s3_options['cta_font_size'])) ? esc_attr( $s3_options['cta_font_size'] ) : '';

$s3_cta_textcolor = ('' !== $s3_cta_textcolor) ? "color: $s3_cta_textcolor" : "";
$s3_cta_bgcolor = ('' !== $s3_cta_bgcolor) ? "background-color: $s3_cta_bgcolor" : "";
$s3_cta_font_size = ('' !== $s3_cta_font_size) ? "font-size: $s3_cta_font_size" : "";

$s3_cta_css = "padding: 0px 16px; line-height: 1.6; $s3_cta_font_size; $s3_cta_bgcolor; $s3_cta_textcolor; border-radius:10px; margin:0 10px; ";
$s3_cta_class = "ht-ctc-cta ";
$title = "";
if ( 'hover' == $s3_cta_type ) {
    $s3_cta_css .= " display: none; order: $s3_cta_order; ";
    $s3_cta_class .= " ht-ctc-cta-hover ";
} elseif ( 'show' == $s3_cta_type ) {
    $s3_cta_css .= "order: $s3_cta_order; ";
} elseif ( 'hide' == $s3_cta_type ) {
    $s3_cta_css .= " display: none; ";
    $title = "title = '$call_to_action'";
}

$ht_ctc_svg_css = "pointer-events:none; display:block; height:$img_size; width:$img_size;";

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';

?>
<div <?= $title ?> style="<?= $s3_css ?>">
    <p class="ctc-analytics ctc_cta <?= $s3_cta_class ?>" style="<?= $s3_cta_css ?>"><?= $call_to_action; ?></p>
    <?= ht_ctc_style_3_svg( $img_size, $type, $ht_ctc_svg_css ); ?>
</div>