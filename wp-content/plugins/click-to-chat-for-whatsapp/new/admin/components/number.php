<?php
/**
 * number
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title = (isset($input['title'])) ? esc_attr($input['title']) : '';
$description = (isset($input['description'])) ? esc_attr($input['description']) : '';
$label = (isset($input['label'])) ? esc_attr($input['label']) : '';
$placeholder = (isset($input['placeholder'])) ? esc_attr($input['placeholder']) : '';

$min = (isset($input['min'])) ? esc_attr($input['min']) : '';

$attr = '';

if ('' !== $min) {
    $attr .= " min=$min ";
}

?>
<div class="row">
    <div class="input-field col s12">
        <input name="<?= $dbrow ?>[<?= $db_key ?>]" type="number" <?= $attr ?> value="<?= $db_value ?>" placeholder="<?= $placeholder ?>"/>
        <label for="pre_filled"><?= $label ?></label>
        <p class="description"><?= $description ?></p>
    </div>
</div>