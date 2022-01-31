<?php
/**
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$s3_options = get_option( 'ht_ctc_s3' );

$img_size = esc_attr( $s3_options['s3_img_size'] );
if ( '' == $img_size ) {
    $img_size = "50px";
}

$ht_ctc_svg_css = "pointer-events:none; display:block; height:$img_size; width:$img_size;";

$s3_img_link = plugins_url( './new/inc/assets/img/whatsapp-logo.svg', HT_CTC_PLUGIN_FILE );

include_once HT_CTC_PLUGIN_DIR .'new/inc/assets/img/ht-ctc-svg-images.php';

$s3_simple = '';
$s3_simple .=  '
<img class="img-icon ctc-analytics ctc_cta" title="'.$call_to_action.'" style="display: inline-block; height: '.$img_size.';" src="'.$s3_img_link.'" alt="'.$call_to_action.'">
';

$o .= $s3_simple;