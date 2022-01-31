<?php
/**
 * Style-1 - new method. 
 *  default button, looks like theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="ccw_plugin chatbot" style="<?= $p1 ?>; <?= $p2 ?>;">
    <div class="style1 animated <?= $an_on_load .' '. $an_on_hover ?> ">
        <button onclick="<?= $redirect ?>"><?= $val ?></button>    
    </div>
</div>