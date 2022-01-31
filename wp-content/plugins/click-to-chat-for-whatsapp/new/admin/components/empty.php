<?php
/**
 * empty field. hidden type.. useful to save some value in table instead of keeping empty. to prevent some errors
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$db_value = '1';
?>
<input name="<?= $dbrow ?>[<?= $db_key ?>]" type="text" hidden style="display:none;" value="<?= $db_value ?>"/>