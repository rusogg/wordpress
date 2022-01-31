<?php
/**
 * add space / line breaks
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$type = (isset($input['type'])) ? esc_attr($input['type']) : '';

if ('line' == $type) {
    ?>
    <br>
    <?php
} else if ('margin' == $type) {

    $margin_bottom = (isset($input['margin_bottom'])) ? "margin-bottom: " . esc_attr($input['margin_bottom']) . ";" : '';

    ?>
    <span style="display:block; <?= $margin_bottom ?>"></span>
    <?php
}