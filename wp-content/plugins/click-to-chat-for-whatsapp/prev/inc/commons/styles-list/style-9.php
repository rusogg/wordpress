<?php
/**
 * logo
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s9_icon_size = esc_attr( $ccw_options_cs['s9_icon_size'] );
?>

<div class="ccw_plugin chatbot" style="<?= $p1 ?>; <?= $p2 ?>;">
    <div class="ccw_style9 animated <?= $an_on_load .' '. $an_on_hover ?>">
        <a target="_blank" href="<?= $redirect_a ?>" rel="noreferrer" class="img-icon-a nofocus">   
            <img class="img-icon ccw-analytics" id="style-9" data-ccw="style-9" style="height: <?= $s9_icon_size ?>;" src="<?= plugins_url( './new/inc/assets/img/whatsapp-icon-square.svg', HT_CTC_PLUGIN_FILE ) ?>" alt="WhatsApp chat">
        </a>
    </div>
</div>