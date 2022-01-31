<?php
/**
 * material button - text , icon
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// wp_enqueue_style('ccw_mdstyle8_css');

// $ccw_options_cs = get_option('ccw_options_cs');
$s8_text_color = esc_attr( $ccw_options_cs['s8_text_color'] );
$s8_background_color = esc_attr( $ccw_options_cs['s8_background_color'] );
$s8_icon_color = esc_attr( $ccw_options_cs['s8_icon_color'] );

$s8_text_color_onhover = esc_attr( $ccw_options_cs['s8_text_color_onhover'] );
$s8_background_color_onhover = esc_attr( $ccw_options_cs['s8_background_color_onhover'] );
$s8_icon_color_onhover = esc_attr( $ccw_options_cs['s8_icon_color_onhover'] );

$s8_icon_float = esc_attr( $ccw_options_cs['s8_icon_float'] );


?>
<div class="ccw_plugin mdstyle8 chatbot" style="<?= $p1 ?>; <?= $p2 ?>;">
    <div class="style8 animated <?= $an_on_load .' '. $an_on_hover ?>">
        <a target="_blank" class="btn ccw-analytics" id="style-8" data-ccw="style-8" rel="noreferrer" 
            style="background-color: <?= $s8_background_color ?>; " 
            onmouseover = "this.style.backgroundColor = '<?= $s8_background_color_onhover ?>', document.getElementsByClassName('ccw-s8-icon')[0].style.color = '<?= $s8_icon_color_onhover ?>', document.getElementsByClassName('ccw-s8-span')[0].style.color = '<?= $s8_text_color_onhover ?>' " 
            onmouseout  = "this.style.backgroundColor = '<?= $s8_background_color ?>', document.getElementsByClassName('ccw-s8-icon')[0].style.color = '<?= $s8_icon_color ?>', document.getElementsByClassName('ccw-s8-span')[0].style.color = '<?= $s8_text_color ?>' " 
            href="<?= $redirect_a ?>" >   
        <i class="material-icons <?= $s8_icon_float ?> icon icon-whatsapp2 ccw-s8-icon ccw-analytics" data-ccw="style-8" id="s8-icon" style="color: <?= $s8_icon_color ?> ;" ></i>
        <span class="ccw-s8-span ccw-analytics" id="s8-text" data-ccw="style-8" style="color: <?= $s8_text_color ?> ;" ><?= $val ?></span>
        </a>
    </div>
</div>