
<?php
/**
 * editor
 * 
 * 
 * $db_value is santized esc_attr - so call db again.. and reassing $db_value
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title = (isset($input['title'])) ? $input['title'] : '';
$description = (isset($input['description'])) ? $input['description'] : '';
$label = (isset($input['label'])) ? $input['label'] : '';
$placeholder = (isset($input['placeholder'])) ? $input['placeholder'] : '';
$parent_style = (isset($input['parent_style'])) ? $input['parent_style'] : '';


// function ctc_edit_quicktags( $qtInit, $editor_id = 'content' ) {
// 	$qtInit['buttons'] = 'strong,code,more,close';
// 	return $qtInit;
// }
// add_filter( 'quicktags_settings', 'ctc_edit_quicktags', 10, 2 );

if ( ! function_exists( 'ctc_tiny_mce_toolbar_settings' ) ) {
    function ctc_tiny_mce_toolbar_settings( $args ) {
        $args['fontsize_formats'] = "6px 8px 10px 12px 13px 14px 15px 16px 18px 20px 24px 28px 32px 36px";
        return $args;
    }
}
add_filter( 'tiny_mce_before_init', 'ctc_tiny_mce_toolbar_settings' );

if ( ! function_exists( 'ctc_tinymce_add_font_sizes' ) ) {
    function ctc_tinymce_add_font_sizes( $buttons ) {
        array_unshift( $buttons, 'fontselect' );
        array_unshift( $buttons, 'fontsizeselect' );
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'ctc_tinymce_add_font_sizes' );

// db_value call again for editor. and santize using wp_kses
$db_value = ( isset( $options[$db_key]) ) ? $options[$db_key] : '';

if ( '' !== $db_value ) {
    $allowed_html = wp_kses_allowed_html( 'post' );

    // $allowed_html['iframe'] = array(
    //     'src'             => true,
    //     'height'          => true,
    //     'width'           => true,
    //     'frameborder'     => true,
    //     'allowfullscreen' => true,
    //     'title' => true,
    //     'allow' => true,
    //     'autoplay' => true,
    //     'clipboard-write' => true,
    //     'encrypted-media' => true,
    //     'gyroscope' => true,
    //     'picture-in-picture' => true,
    // );
    
    $db_value = html_entity_decode(wp_kses($db_value, $allowed_html));
}

?>
<div class="row" style="<?= $parent_style ?>">
<p class="description ht_ctc_subtitle" style="margin-top: 40px;"><?php _e( $title, 'click-to-chat-for-whatsapp' ); ?> </p>
<?php

$content   = $db_value;
$editor_id = $db_key;
$args = [
    'textarea_name' => "$dbrow"."[$db_key]", 
    'textarea_rows' => 10,
    'editor_height' => 250,
    // 'media_buttons' => false,
    'drag_drop_upload' => true,
    'tinymce'       => array(
        'textarea_rows'=> 10,
        'fontsize_formats' => "8px 10px 12px 14px 18px 24px 36px",
    )
    ];

wp_editor( $content, $editor_id, $args );
?>
<p class="description"><?= $description ?></p>
</div>