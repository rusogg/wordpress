<?php
/**
 * WooCommerce settings page - admin 
 * 
 * @package ctc
 * @subpackage admin
 * @since 3.3.3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Woo_Page' ) ) :

class HT_CTC_Admin_Woo_Page {

    public function __construct() {
        $this->start();
	}

    function start() {
        add_action('admin_menu', array($this, 'menu') );
        add_action('admin_init', array($this, 'settings') );
    }

    public function menu() {

        // dashicons-format-chat  /  dashicons-whatsapp
        $icon = 'dashicons-whatsapp';
        if( version_compare( get_bloginfo('version'), '5.6', '<') )  {
            $icon = 'dashicons-format-chat';
        }

        add_submenu_page(
            'click-to-chat',
            'WooCommerce page',
            'WooCommerce',
            'manage_options',
            'click-to-chat-woocommerce',
            array( $this, 'settings_page' )
        );
    }

    public function settings_page() {

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <!-- full row -->
            <div class="row">

                <div class="col s12 m12 xl7 options">
                    <form action="options.php" method="post" class="">
                        <?php settings_fields( 'ht_ctc_woo_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_woo_page_settings_sections_do' ) ?>
                        <?php submit_button() ?>
                    </form>
                </div>

                <!-- sidebar content -->
                <div class="col s12 m12 l7 xl4 ht-ctc-admin-sidebar ht-ctc-admin-woo-sidebar sticky-sidebar">
                    <?php // include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-sidebar-content.php'; ?>
                </div>
                
            </div>

            <!-- new row - After settings page  -->
            <div class="row">
            </div>

        </div>

        <?php

    }


    public function settings() {

        // WooCommerce chat feautes
        register_setting( 'ht_ctc_woo_page_settings_fields', 'ht_ctc_woo_options' , array( $this, 'options_sanitize' ) );

        // if ( isset($_GET) && isset($_GET['page']) && 'click-to-chat-woocommerce' == $_GET['page'] ) {
            add_settings_section( 'ht_ctc_woo_page_settings_sections_add', '', array( $this, 'chat_settings_section_cb' ), 'ht_ctc_woo_page_settings_sections_do' );
            add_settings_field( 'ctc_woocommerce', __( 'WooCommerce', 'click-to-chat-for-whatsapp'), array( $this, 'ctc_woocommerce_cb' ), 'ht_ctc_woo_page_settings_sections_do', 'ht_ctc_woo_page_settings_sections_add' );
        // }

    }


    public function chat_settings_section_cb() {
        ?>
        <h1 id="woo_settings">WooCommerce WhatsApp Chat Settings </h1>
        <br>
        <?php
        do_action('ht_ctc_ah_admin' );
    }

     

    /**
     * single product pages
     * 
     * @var [woo_is_single] - floating style for single product pages
     */
    function ctc_woocommerce_cb() {
        
        $woo_options = get_option('ht_ctc_woo_options');
        $chat = get_option('ht_ctc_chat_options');
        $dbrow = 'ht_ctc_woo_options';

        /**
         * Single product page..
         */
        // pre filled
        $woo_pre_filled = ( isset( $woo_options['woo_pre_filled']) ) ? esc_attr( $woo_options['woo_pre_filled'] ) : '';
        $pf_placeholder = "Hello {site} \nLike to buy {product}, {url}";
        // call to action
        $woo_call_to_action = ( isset( $woo_options['woo_call_to_action']) ) ? esc_attr( $woo_options['woo_call_to_action'] ) : '';
        $ctc_placeholder = 'Buy {product}';
        $single_ctc_placeholder = "WhatsApp Order";

        // Add styles at woo page position
        $woo_position = ( isset( $woo_options['woo_position']) ) ? esc_attr( $woo_options['woo_position'] ) : '';
        $woo_style = ( isset( $woo_options['woo_style']) ) ? esc_attr( $woo_options['woo_style'] ) : '8';
        $woo_single_block_type = ( isset( $woo_options['woo_single_block_type']) ) ? esc_attr( $woo_options['woo_single_block_type'] ) : 'inline-block';

        $woo_places = [
            'select' => '-- Select --',
            'woocommerce_after_single_product_summary' => 'After Product Summary'
        ];

        $woo_places = apply_filters( 'ht_ctc_fh_admin_woo_places', $woo_places );

        $woo_single_position_center = ( isset( $woo_options['woo_single_position_center']) ) ? esc_attr( $woo_options['woo_single_position_center'] ) : '';
        $woo_single_layout_cart_btn = ( isset( $woo_options['woo_single_layout_cart_btn']) ) ? esc_attr( $woo_options['woo_single_layout_cart_btn'] ) : '';
        $woo_single_margin_top = ( isset( $woo_options['woo_single_margin_top']) ) ? esc_attr( $woo_options['woo_single_margin_top'] ) : '';
        $woo_single_margin_right = ( isset( $woo_options['woo_single_margin_right']) ) ? esc_attr( $woo_options['woo_single_margin_right'] ) : '';
        $woo_single_margin_bottom = ( isset( $woo_options['woo_single_margin_bottom']) ) ? esc_attr( $woo_options['woo_single_margin_bottom'] ) : '';
        $woo_single_margin_left = ( isset( $woo_options['woo_single_margin_left']) ) ? esc_attr( $woo_options['woo_single_margin_left'] ) : '';
        $woo_single_margin_unit =  ( isset( $woo_options['woo_single_margin_unit']) ) ? esc_attr( $woo_options['woo_single_margin_unit'] ) : 'px';

        /**
         * woo - shop page
         */
        $woo_shop_style = ( isset( $woo_options['woo_shop_style']) ) ? esc_attr( $woo_options['woo_shop_style'] ) : '1';
        $woo_shop_pre_filled = ( isset( $woo_options['woo_shop_pre_filled']) ) ? esc_attr( $woo_options['woo_shop_pre_filled'] ) : '';
        $woo_shop_call_to_action = ( isset( $woo_options['woo_shop_call_to_action']) ) ? esc_attr( $woo_options['woo_shop_call_to_action'] ) : '';
        $woo_shop_layout_cart_btn = ( isset( $woo_options['woo_shop_layout_cart_btn']) ) ? esc_attr( $woo_options['woo_shop_layout_cart_btn'] ) : '';
        $woo_shop_add_whatsapp = ( isset( $woo_options['woo_shop_add_whatsapp']) ) ? esc_attr( $woo_options['woo_shop_add_whatsapp'] ) : '';

        $woo_shop_position_center = ( isset( $woo_options['woo_shop_position_center']) ) ? esc_attr( $woo_options['woo_shop_position_center'] ) : '';
        $woo_shop_margin_top = ( isset( $woo_options['woo_shop_margin_top']) ) ? esc_attr( $woo_options['woo_shop_margin_top'] ) : '';
        $woo_shop_margin_right = ( isset( $woo_options['woo_shop_margin_right']) ) ? esc_attr( $woo_options['woo_shop_margin_right'] ) : '';
        $woo_shop_margin_bottom = ( isset( $woo_options['woo_shop_margin_bottom']) ) ? esc_attr( $woo_options['woo_shop_margin_bottom'] ) : '';
        $woo_shop_margin_left = ( isset( $woo_options['woo_shop_margin_left']) ) ? esc_attr( $woo_options['woo_shop_margin_left'] ) : '';
        $woo_shop_margin_unit =  ( isset( $woo_options['woo_shop_margin_unit']) ) ? esc_attr( $woo_options['woo_shop_margin_unit'] ) : 'px';

        ?>
        
        <ul class="collapsible ht_ctc_woo_1">
        <li class="">
        <div class="collapsible-header"><?php _e( 'WooCommerce', 'click-to-chat-for-whatsapp' ); ?> - <?php _e( 'Single Product Pages', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/woocommerce-single-product-pages/"><?php _e( 'WooCommerce Single Product pages', 'click-to-chat-for-whatsapp' ); ?></a></p>
        <br>

        <!-- prefilled message -->
        <div class="row">
            <div class="input-field col s12">
                <textarea name="ht_ctc_woo_options[woo_pre_filled]" id="woo_pre_filled" class="materialize-textarea input-margin" style="min-height: 84px;" placeholder="<?= $pf_placeholder ?>"><?= $woo_pre_filled ?></textarea>
                <label for="woo_pre_filled"><?php _e( 'Pre-filled message', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>


        <!-- Call to Action -->
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_woo_options[woo_call_to_action]" value="<?= $woo_call_to_action ?>" id="woo_call_to_action" type="text" class="input-margin" placeholder="<?= $ctc_placeholder ?>">
                <label for="woo_call_to_action"><?php _e( 'Call to Action', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- docs - prefilled, call to action .. -->
        <p class="description">Variables: {product}, {price}, {regular_price}, {sku}, {site}, {url}, {title} </p>
        <!-- <p class="description">Change Values for WooCommerce Single Product pages - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/woocommerce-single-product-pages/"><?php _e( 'more info', 'click-to-chat-for-whatsapp' ); ?></a></p> -->
        <p class="description">Leave blank to get value from main settings</p>

        <br><hr style="max-width: 240px;"><br>
        <p class="description" style="margin-bottom:15px;"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/add-whatsapp-in-woocommerce-single-product-pages/"><?php _e( 'Add WhatsApp in WooCommerce Single Product pages', 'click-to-chat-for-whatsapp' ); ?></a></p>


        <!-- Add button/icon -->
        <div class="row">
            <div class="col s6" style="padding-top: 14px;">
                <p><?php _e( 'Add WhatsApp', 'click-to-chat-for-whatsapp' ); ?>:</p>
            </div>
            <div class="input-field col s6">
                <select name="<?php echo $dbrow ?>[woo_position]" class="woo_single_position_select">
                    <?php
                    foreach ($woo_places as $key => $value) {
                        ?>
                        <option value="<?= $key ?>" <?php echo $woo_position == $key ? 'SELECTED' : ''; ?> ><?php _e( $value, 'click-to-chat-for-whatsapp' ); ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php
                if ( ! defined( 'HT_CTC_PRO_VERSION' ) ) {
                    ?>
                    <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/add-whatsapp-in-woocommerce-single-product-pages/#pro_block">More Positions</a> (PRO)</p>
                    <?php
                }
                ?>

            </div>
        </div>

        <!-- style -->
        <div class="row ctc_init_display_none woo_single_position_settings">
            <div class="col s6" style="padding-top: 14px;">
                <p><?php _e( 'Select Style', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[woo_style]" class="woo_single_style_select">
                    <option value="1" <?= $woo_style == 1 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="2" <?= $woo_style == 2 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-2', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="3" <?= $woo_style == 3 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-3', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="3_1" <?= $woo_style == '3_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-3 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="4" <?= $woo_style == 4 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-4', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="5" <?= $woo_style == 5 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-5', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="7" <?= $woo_style == 7 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-7', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="7_1" <?= $woo_style == '7_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-7 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="8" <?= $woo_style == 8 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-8', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="99" <?= $woo_style == 99 ? 'SELECTED' : ''; ?> ><?php _e( 'Add your own image / GIF (Style-99)', 'click-to-chat-for-whatsapp' ); ?></option>
                </select>
                <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/list-of-styles/?utm_source=ctc&utm_medium=admin&utm_campaign=woo"><?php _e( 'List of Styles', 'click-to-chat-for-whatsapp' ); ?></a> &emsp; | &emsp; <span><a target="_blank" href="<?= admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>">Customize the styles</a></span> </p>
                <p class="description"><strong>Recommended Styles: 1, 8</strong></p>
            </div>
        </div>

        <p class="description ctc_init_display_none woo_single_position_settings">These styles and their position appears based on how the Theme is developed. </p>
        <br>

        <details open class="description ctc_init_display_none woo_single_position_settings">
            <summary style="padding: 5px; background-color: #eeeeee; cursor: pointer; width: fit-content;">Adjust settings compatible with the theme design</summary>

            <!-- style 1, 8 - add to cart layout -->
            <div class="woo_single_position_settings_cart_layout" style="display: none;">
                <div class="row">
                    <div class="col s6" style="padding-top: 14px;">
                        <p>Button layout <br><span style="font-size:0.8em;">WhatsApp button looks like 'Add to Cart' button</span></p>
                    </div>
                    <div class="input-field col s6">
                        <label>
                            <input name="<?= $dbrow; ?>[woo_single_layout_cart_btn]" type="checkbox" value="1" <?php checked( $woo_single_layout_cart_btn, 1 ); ?> id="woo_single_layout_cart_btn" />
                            <span>Displays like 'Add to Cart' button</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- display - center -->
            <div class="row woo_single_position_settings" style="display: none;">
                <div class="col s6" style="padding-top: 14px;">
                    <p><?php _e( 'Display Center', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <label>
                        <input name="<?= $dbrow; ?>[woo_single_position_center]" type="checkbox" value="1" <?php checked( $woo_single_position_center, 1 ); ?> id="woo_single_position_center" />
                        <span><?php _e( 'Display center within available space', 'click-to-chat-for-whatsapp' ); ?></span>
                    </label>
                </div>
            </div>
            
            <!-- display: block, inline-block ..  -->
            <div class="row ctc_init_display_none woo_single_position_settings">
                <div class="col s6" style="padding-top: 14px;">
                    <p><?php _e( 'Display Block Type', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <select name="<?= $dbrow; ?>[woo_single_block_type]" class="">
                        <option value="block" <?= $woo_single_block_type == 'block' ? 'SELECTED' : ''; ?> >block</option>
                        <option value="inline" <?= $woo_single_block_type == 'inline' ? 'SELECTED' : ''; ?> >inline</option>
                        <option value="inline-block" <?= $woo_single_block_type == 'inline-block' ? 'SELECTED' : ''; ?> >inline-block</option>
                    </select>
                    <p class="woo_single_position_center_checked_content" style="display: none;">Recommended type: 'block'</p>
                </div>
            </div>
            
            <!-- margin -->
            <div class="row ctc_init_display_none woo_single_position_settings">
                <div class="col s6" style="padding-top: 14px;">
                    <p><?php _e( 'Spacing (Margin)', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6" style="display: flex; margin-bottom: 1px;">
                    <input name="ht_ctc_woo_options[woo_single_margin_top]" value="<?= $woo_single_margin_top ?>" id="woo_single_margin_top" type="text" style="display:inline; margin-right:4px;" class="input-margin tooltipped" placeholder="Top" data-position="top" data-tooltip="<?php _e( 'Top', 'click-to-chat-for-whatsapp' ); ?>">
                    <input name="ht_ctc_woo_options[woo_single_margin_bottom]" value="<?= $woo_single_margin_bottom ?>" id="woo_single_margin_bottom" type="text" style="display:inline; margin-right:8px;" class="input-margin tooltipped" placeholder="Bottom" data-position="bottom" data-tooltip="<?php _e( 'Bottom', 'click-to-chat-for-whatsapp' ); ?>">
                    <input name="ht_ctc_woo_options[woo_single_margin_left]" value="<?= $woo_single_margin_left ?>" id="woo_single_margin_left" type="text" style="display:inline; margin-right:4px;" class="input-margin tooltipped" placeholder="Left" data-position="left" data-tooltip="<?php _e( 'Left', 'click-to-chat-for-whatsapp' ); ?>">
                    <input name="ht_ctc_woo_options[woo_single_margin_right]" value="<?= $woo_single_margin_right ?>" id="woo_single_margin_right" type="text" style="display:inline;" class="input-margin tooltipped" placeholder="Right" data-position="right" data-tooltip="<?php _e( 'Right', 'click-to-chat-for-whatsapp' ); ?>">
                </div>
                <span class="helper-text" style="float:right;">Top, Bottom, Left, Right <span> E.g. 10px, 50%</span> </span>
            </div>

            <br>
            <p class="description ctc_init_display_none woo_single_position_settings" style="margin-bottom:15px;"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/add-whatsapp-in-woocommerce-single-product-pages/"><?php _e( 'Add WhatsApp in WooCommerce Single Product pages', 'click-to-chat-for-whatsapp' ); ?></a></p>
        </details>



        </div>
        </div>
        </li>
        </ul>


        <!-- woo shop page -->
        <ul class="collapsible ht_ctc_woo_shop" style="margin-top: 40px;">
        <li class="">
        <div class="collapsible-header"><?php _e( 'WooCommerce', 'click-to-chat-for-whatsapp' ); ?> - <?php _e( 'Shop Page', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/whatsapp-chat-in-woocommerce-shop-page/"><?php _e( 'WooCommerce Shop page', 'click-to-chat-for-whatsapp' ); ?></a></p>

        <!-- At WooCommerce shop pages, loop.. -->
        <div class="row">
            <div class="col s6" style="padding-top: 14px;">
                <p><?php _e( 'Add WhatsApp', 'click-to-chat-for-whatsapp' ); ?>:</p>
            </div>
            <div class="input-field col s6">
                <label>
                    <input name="<?= $dbrow; ?>[woo_shop_add_whatsapp]" type="checkbox" value="1" <?php checked( $woo_shop_add_whatsapp, 1 ); ?> id="woo_shop_add_whatsapp" />
                    <span><?php _e( "At Products Archive, Shop Page", 'click-to-chat-for-whatsapp' ); ?></span>
                </label>
            </div>
        </div>
        
        <!-- prefilled message -->
        <div class="row ctc_init_display_none woo_shop_add_whatsapp_settings">
            <div class="input-field col s12">
                <textarea name="ht_ctc_woo_options[woo_shop_pre_filled]" id="woo_shop_pre_filled" class="materialize-textarea input-margin" style="min-height: 84px;" placeholder="<?= $pf_placeholder ?>"><?= $woo_shop_pre_filled ?></textarea>
                <label for="woo_shop_pre_filled"><?php _e( 'Pre-filled message', 'click-to-chat-for-whatsapp' ); ?></label>
                <p class="description">pre-filled, call-to-action: if blank, get values from page-level settings if not from the main settings</p>
            </div>
        </div>


        <!-- Call to Action -->
        <div class="row ctc_init_display_none woo_shop_add_whatsapp_settings">
            <div class="input-field col s12">
                <input name="ht_ctc_woo_options[woo_shop_call_to_action]" value="<?= $woo_shop_call_to_action ?>" id="woo_shop_call_to_action" type="text" class="input-margin" placeholder="<?= $single_ctc_placeholder ?>">
                <label for="woo_shop_call_to_action"><?php _e( 'Call to Action', 'click-to-chat-for-whatsapp' ); ?></label>
            </div>
        </div>

        <!-- style -->
        <div class="row ctc_init_display_none woo_shop_add_whatsapp_settings">
            <div class="col s6" style="padding-top: 14px;">
                <p><?php _e( 'Select Style', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[woo_shop_style]" class="woo_shop_style">
                    <option value="1" <?= $woo_shop_style == 1 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="2" <?= $woo_shop_style == 2 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-2', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="3" <?= $woo_shop_style == 3 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-3', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="3_1" <?= $woo_shop_style == '3_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-3 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="4" <?= $woo_shop_style == 4 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-4', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="5" <?= $woo_shop_style == 5 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-5', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="7" <?= $woo_shop_style == 7 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-7', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="7_1" <?= $woo_shop_style == '7_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-7 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="8" <?= $woo_shop_style == 8 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-8', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="99" <?= $woo_shop_style == 99 ? 'SELECTED' : ''; ?> ><?php _e( 'Add your own image / GIF (Style-99)', 'click-to-chat-for-whatsapp' ); ?></option>
                </select>
                <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/list-of-styles/?utm_source=ctc&utm_medium=admin&utm_campaign=woo"><?php _e( 'List of Styles', 'click-to-chat-for-whatsapp' ); ?></a> &emsp; | &emsp; <span><a target="_blank" href="<?= admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>">Customize the styles</a></span> </p>
                <p class="description"><b>Recommended Styles: 1, 8</b></p>
            </div>
        </div>

        <details open class="description ctc_init_display_none woo_shop_add_whatsapp_settings">
            <summary style="padding: 5px; background-color: #eeeeee; cursor: pointer; width: fit-content;">Adjust settings compatible with the theme design</summary>

            <!-- style 1, 8 - shop - add to cart layout -->
            <div class="woo_shop_cart_layout" style="display: none;">
                <div class="row">
                    <div class="col s6" style="padding-top: 14px;">
                        <p>Button layout <br><span style="font-size:0.8em;">WhatsApp button looks like 'Add to Cart' button</span></p>
                    </div>
                    <div class="input-field col s6">
                        <label>
                            <input name="<?= $dbrow; ?>[woo_shop_layout_cart_btn]" type="checkbox" value="1" <?php checked( $woo_shop_layout_cart_btn, 1 ); ?> id="woo_shop_layout_cart_btn" />
                            <span>Displays like 'Add to Cart' button</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- display - center -->
            <div class="row ctc_init_display_none woo_shop_add_whatsapp_settings">
                <div class="col s6" style="padding-top: 14px;">
                    <p><?php _e( 'Display Center', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6">
                    <label>
                        <input name="<?= $dbrow; ?>[woo_shop_position_center]" type="checkbox" value="1" <?php checked( $woo_shop_position_center, 1 ); ?> id="woo_shop_position_center" />
                        <span><?php _e( 'Display center', 'click-to-chat-for-whatsapp' ); ?></span>
                    </label>
                </div>
            </div>

            <!-- margin -->
            <div class="row ctc_init_display_none woo_shop_add_whatsapp_settings">
                <div class="col s6" style="padding-top: 14px;">
                    <p><?php _e( 'Spacing (Margin)', 'click-to-chat-for-whatsapp' ); ?></p>
                </div>
                <div class="input-field col s6" style="display: flex; margin-bottom: 1px;">
                    <input name="ht_ctc_woo_options[woo_shop_margin_top]" value="<?= $woo_shop_margin_top ?>" id="woo_shop_margin_top" type="text" style="display:inline; margin-right:4px;" class="input-margin tooltipped" placeholder="Top" data-position="top" data-tooltip="<?php _e( 'Top', 'click-to-chat-for-whatsapp' ); ?>">
                    <input name="ht_ctc_woo_options[woo_shop_margin_bottom]" value="<?= $woo_shop_margin_bottom ?>" id="woo_shop_margin_bottom" type="text" style="display:inline; margin-right:8px;" class="input-margin tooltipped" placeholder="Bottom" data-position="bottom" data-tooltip="<?php _e( 'Bottom', 'click-to-chat-for-whatsapp' ); ?>">
                    <input name="ht_ctc_woo_options[woo_shop_margin_left]" value="<?= $woo_shop_margin_left ?>" id="woo_shop_margin_left" type="text" style="display:inline; margin-right:4px;" class="input-margin tooltipped" placeholder="Left" data-position="left" data-tooltip="<?php _e( 'Left', 'click-to-chat-for-whatsapp' ); ?>">
                    <input name="ht_ctc_woo_options[woo_shop_margin_right]" value="<?= $woo_shop_margin_right ?>" id="woo_shop_margin_right" type="text" style="display:inline;" class="input-margin tooltipped" placeholder="Right" data-position="right" data-tooltip="<?php _e( 'Right', 'click-to-chat-for-whatsapp' ); ?>">
                </div>
                <span class="helper-text" style="float:right;">Top, Bottom, Left, Right <span> E.g. 10px, 50%</span> </span>
            </div>
            <br>

            <br>
            <p class="description ctc_init_display_none woo_shop_add_whatsapp_settings"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/whatsapp-chat-in-woocommerce-shop-page/"><?php _e( 'WooCommerce Shop page', 'click-to-chat-for-whatsapp' ); ?></a></p>
        </details>



        </div>
        </div>
        </li>
        </ul>


        <!-- Page Level settings - for WooCommerce pages -->
        <br><br>
        <p class="description ht_ctc_subtitle">Page Level Settings:</p>
        <br>
        <?php

        $admin_url = admin_url();
        
        if (function_exists( 'wc_get_page_id')) {
            $shop_page_id = wc_get_page_id( 'shop' );
            $shop_admin_url = "${admin_url}post.php?post=${shop_page_id}&action=edit";
            
            $cart_page_id = wc_get_page_id( 'cart' );
            $cart_admin_url = "${admin_url}post.php?post=${cart_page_id}&action=edit";
            
            $checkout_page_id = wc_get_page_id( 'checkout' );
            $checkout_admin_url = "${admin_url}post.php?post=${checkout_page_id}&action=edit";
            
            $myaccount_page_id = wc_get_page_id( 'myaccount' );
            $myaccount_admin_url = "${admin_url}post.php?post=${myaccount_page_id}&action=edit";

            ?>
            <p class="description"><a target="_blank" href="<?= $shop_admin_url ?>">Edit Shop Page</a> </p>
            <p class="description"><a target="_blank" href="<?= $cart_admin_url ?>">Edit Cart Page</a> </p>
            <p class="description"><a target="_blank" href="<?= $checkout_admin_url ?>">Edit Checkout Page</a> </p>
            <p class="description"><a target="_blank" href="<?= $myaccount_admin_url ?>">Edit My Account Page</a> </p>
            
            <br>
            <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/change-values-at-page-level/">Page Level Settings</a> <br> Number, Call to Action, Prefilled Message, <br> <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/pricing/">PRO</a>: Style, Time Delay, Scroll Delay</p>
            <?php
        }

    }




    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $new_input = array();

        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {

                if ( 'woo_pre_filled' == $key || 'woo_shop_pre_filled' == $key ) {
                    $new_input[$key] = sanitize_textarea_field( $input[$key] );
                } elseif ( 'woo_single_margin_top' == $key || 'woo_single_margin_bottom' == $key || 'woo_single_margin_left' == $key || 'woo_single_margin_right' == $key || 'woo_shop_margin_top' == $key || 'woo_shop_margin_bottom' == $key || 'woo_shop_margin_left' == $key || 'woo_shop_margin_right' == $key ) {
                    $input[$key] = str_replace( ' ', '', $input[$key] );
                    if ( is_numeric($input[$key]) ) {
                        $input[$key] = $input[$key] . 'px';
                    }
                    // if ( '' == $input[$key] ) {
                    //     $input[$key] = '0px';
                    // }
                    $new_input[$key] = sanitize_text_field( $input[$key] );
                } else {
                    $new_input[$key] = sanitize_text_field( $input[$key] );
                }
            }
        }

        // l10n
        foreach ($input as $key => $value) {
            if ( 'woo_pre_filled' == $key || 'woo_call_to_action' == $key || 'woo_shop_pre_filled' == $key || 'woo_shop_call_to_action' == $key) {
                do_action( 'wpml_register_single_string', 'Click to Chat for WhatsApp', $key, $input[$key] );
            }
        }

        do_action('ht_ctc_ah_admin_after_sanitize' );

        return $new_input;
    }


}

new HT_CTC_Admin_Woo_Page();

endif; // END class_exists check