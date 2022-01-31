<?php
/**
 * logo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s3_icon_size = esc_attr( $ccw_options_cs['s3_icon_size'] );

?>
<div class="ccw_plugin chatbot" style="<?= $p1 ?>; <?= $p2 ?>;" >
    <div class="ccw_style3 animated <?= $an_on_load .' '. $an_on_hover ?> ">
        <a target="_blank" href="<?= $redirect_a ?>" rel="noreferrer" class="img-icon-a nofocus">   
            <img class="img-icon ccw-analytics" id="style-3" data-ccw="style-3" style="height: <?= $s3_icon_size ?>;" src="<?= plugins_url( "./new/inc/assets/img/whatsapp-logo.svg", HT_CTC_PLUGIN_FILE ) ?>" alt="WhatsApp chat">
        </a>
    </div>
</div>