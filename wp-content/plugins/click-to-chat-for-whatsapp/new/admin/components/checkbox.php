<?php
/**
 * checkbox
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title = (isset($input['title'])) ? esc_attr($input['title']) : '';

?>
<div class="row">
    <p>
        <label>
            <input name="<?= $dbrow ?>[<?= $db_key ?>]" type="checkbox" value="1" <?php checked( $db_value, 1 ); ?> />
            <span><?= $title ?></span>
        </label>
    </p>
</div>
<?php