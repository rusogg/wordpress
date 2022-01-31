<?php
/**
 * plain link
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// $ccw_options_cs = get_option('ccw_options_cs');
$s2_text_color = esc_attr( $ccw_options_cs['s2_text_color'] );
$s2_text_color_onhover = esc_attr( $ccw_options_cs['s2_text_color_onhover'] );
$s2_decoration = esc_attr( $ccw_options_cs['s2_decoration'] );
$s2_decoration_onhover = esc_attr( $ccw_options_cs['s2_decoration_onhover'] );
?>
<div class="ccw_plugin chatbot" style="<?= $p1 ?>; <?= $p2 ?>;">
    <div class="style2 animated <?= $an_on_load .' '. $an_on_hover ?> ">
        <a href="<?= $redirect_a ?>" rel="noreferrer" 
            style="color: <?= $s2_text_color ?>; text-decoration: <?= $s2_decoration ?>;"
            onmouseover = "this.style.color = '<?= $s2_text_color_onhover ?>', this.style.textDecoration = '<?= $s2_decoration_onhover ?>' "
            onmouseout  = "this.style.color = '<?= $s2_text_color ?>', this.style.textDecoration = '<?= $s2_decoration ?>' "
            target="_blank" class="nofocus ccw-analytics" id="style-2" data-ccw="style-2" ><?= $val ?></a>
    </div>
</div>