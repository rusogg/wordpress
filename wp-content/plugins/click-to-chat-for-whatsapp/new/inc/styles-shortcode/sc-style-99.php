<?php
/**
 * style 99 own image
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s_99_options = get_option( 'ht_ctc_s99' );

$s_99_desktop_img_height = esc_attr( $s_99_options['s99_desktop_img_height'] );
$s_99_desktop_img_width = esc_attr( $s_99_options['s99_desktop_img_width'] );
$s_99_mobile_img_height = esc_attr( $s_99_options['s99_mobile_img_height'] );
$s_99_mobile_img_width = esc_attr( $s_99_options['s99_mobile_img_width'] );

// img url
// image - width, height based on device
$s_99_img_css = "";


if( 'yes' == $is_mobile ) {

    $s_99_own_image = esc_html( $s_99_options['s99_mobile_img_url'] );

    if ( '' !== $s_99_mobile_img_height ) {
        $s_99_img_css .= "height: $s_99_mobile_img_height; ";
    } else {
        $s_99_img_css .= "height: 40px; ";
    }

    if ( '' !== $s_99_mobile_img_width ) {
        $s_99_img_css .= "width: $s_99_mobile_img_width; ";
    }
} else {
    $s_99_own_image = esc_html( $s_99_options['s99_dekstop_img_url'] );

    if ( '' !== $s_99_desktop_img_height ) {
        $s_99_img_css .= "height: $s_99_desktop_img_height; ";
    }   else {
        $s_99_img_css .= "height: 50px; ";
    }
    
    if ( '' !== $s_99_desktop_img_width ) {
        $s_99_img_css .= "width: $s_99_desktop_img_width; ";
    }
}

// fallback image
if ( '' == $s_99_own_image ) {
    $s_99_own_image = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );
}


$o .=  '
    <img class="own-img ctc-analytics ctc_cta" title="'.$call_to_action.'" id="style-99" src="'.$s_99_own_image.'" style="'.$s_99_img_css.'" alt="'.$call_to_action.'">
';