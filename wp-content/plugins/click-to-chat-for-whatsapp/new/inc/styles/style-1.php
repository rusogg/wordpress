<?php
/**
 * Style - 1
 * 
 * theme button
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s1_options = get_option( 'ht_ctc_s1' );
$s1_options = apply_filters( 'ht_ctc_fh_s1_options', $s1_options );

$s1_css = "";
$s1_css .= "cursor:pointer; display:flex; align-items:center; justify-content:center;";
$s1_text_color = (isset( $s1_options['s1_text_color'])) ? esc_attr( $s1_options['s1_text_color'] ) : '';
$s1_css .= ('' !== $s1_text_color) ? "color:$s1_text_color;": "";
$s1_bg_color = (isset( $s1_options['s1_bg_color'])) ? esc_attr( $s1_options['s1_bg_color'] ) : '';
$s1_css .= ('' !== $s1_bg_color) ? "background-color:$s1_bg_color;": "";

$s1_add_icon = ( isset( $s1_options['s1_add_icon']) ) ? esc_attr( $s1_options['s1_add_icon'] ) : '';
$s1_icon_color = ( isset( $s1_options['s1_icon_color']) ) ? esc_attr( $s1_options['s1_icon_color'] ) : '';
$s1_icon_size = ( isset( $s1_options['s1_icon_size']) ) ? esc_attr( $s1_options['s1_icon_size'] ) : '';

if ('' == $s1_icon_size) {
  $s1_icon_size = '15';
}

if ('' == $s1_icon_color) {
  $s1_icon_color = '#ffffff';
}

$s1_style = ('' !== $s1_css) ? "style='$s1_css'": "";

$s1_fullwidth_css = "";

if ( '' == $call_to_action ) {
    $call_to_action = "WhatsApp us";
}

if ( isset( $s1_options['s1_m_fullwidth'] ) ) {
  $s1_fullwidth_css = "@media(max-width:1201px){.ht-ctc.style-1{left:unset !important;right:0px !important;}.ht-ctc.style-1,.ht-ctc .s1_btn{width:100%;}}";

?>
<style id="ht-ctc-s1"><?= $s1_fullwidth_css ?></style>
<?php
}

?>
<button <?= $s1_style; ?> class="ctc-analytics s1_btn ctc_cta">
<?php
if ('' !== $s1_add_icon) {
  
  $s1_svg_css = "margin-right:6px;";

  $s1_svg_attrs = array(
      'color' => "$s1_icon_color",
      'icon_size' => "$s1_icon_size",
      'type' => "$type",
      'ht_ctc_svg_css' => "$s1_svg_css",
  );
  include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';
  echo ht_ctc_singlecolor( $s1_svg_attrs );
}
?>
<?= $call_to_action ?>
</button>