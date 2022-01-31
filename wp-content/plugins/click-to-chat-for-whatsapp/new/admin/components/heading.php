<?php
/**
 * number
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title = (isset($input['title'])) ? $input['title'] : '';
?>

<div class="row">
    <p class="description ht_ctc_subtitle"><?php _e( $title, 'click-to-chat-for-whatsapp' ); ?> </p>
</div>