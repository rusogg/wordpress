<?php
/**
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $s1_options = get_option( 'ht_ctc_s1' );
// $s1_img_size = esc_attr( $s1_options['s1_img_size'] );


$s1_options = get_option( 'ht_ctc_s1' );

$s1_css = "";
$s1_text_color = (isset( $s1_options['s1_text_color'])) ? esc_attr( $s1_options['s1_text_color'] ) : '';
$s1_css .= ('' !== $s1_text_color) ? "color:$s1_text_color;": "";
$s1_bg_color = (isset( $s1_options['s1_bg_color'])) ? esc_attr( $s1_options['s1_bg_color'] ) : '';
$s1_css .= ('' !== $s1_bg_color) ? "background-color:$s1_bg_color;": "";

$s1_style = ('' !== $s1_css) ? "style='$s1_css'": "";

$s1_fullwidth_css = "";

if ( '' == $call_to_action ) {
    $call_to_action = "WhatsApp us";
}


$o .=  '
    <button '.$s1_style.' class="ctc-analytics ctc_cta">'.$call_to_action.'</button>
';