<?php
/**
 * Color
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title = (isset($input['title'])) ? $input['title'] : '';
$default_color = (isset($input['default_color'])) ? $input['default_color'] : '';

?>
<div class="row">
    <div class="col s6">
        <p><?= $title ?></p>
    </div>
    <div class="input-field col s6">
        <input class="ht-ctc-color" name="<?= $dbrow ?>[<?= $db_key ?>]" data-default-color="<?= $default_color ?>" id="<?= $db_key ?>" value="<?= $db_value ?>" type="text">
    </div>
</div>