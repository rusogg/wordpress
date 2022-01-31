<?php
/**
 * Color
 * 
 * 
 * list - is an array of values.. adding direclty..
 * list_cb - get from ht-h-list.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// todo: improve this .. to not create multiple instance .. 
include_once HT_CTC_PLUGIN_DIR ."new/admin/components/list/ht-ctc-admin-list-greetings-page.php";
$lists = new HT_CTC_Admin_List_Greetings_Page();

$title = (isset($input['title'])) ? $input['title'] : '';
$description = (isset($input['description'])) ? $input['description'] : '';

// list
if (isset($input['list'])) {
    $list = $input['list'];
} elseif (isset($input['list_cb'])) {
    
    $list_cb = $input['list_cb'];
    // $lists is instance
    $list = $lists->$list_cb();
}

if ( '' !== $title ) {
?>
<p class="description"><?php _e( $title, 'click-to-chat-for-whatsapp' ); ?> </p>
<?php
}

?>
<div class="row">
    <div class="input-field col s12">
        <select name="<?= $dbrow ?>[<?= $db_key ?>]" class="">
            <?php
            foreach ($list as $k => $v) {
                ?>
                <option value="<?= $k ?>" <?= $db_value == $k ? 'SELECTED' : ''; ?> ><?= $v ?></option>
                <?php
            }
            ?>
        </select>
        <p class="description"><?= $description ?></p>
    </div>
</div>