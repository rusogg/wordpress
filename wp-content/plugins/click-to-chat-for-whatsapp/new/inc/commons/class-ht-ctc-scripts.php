<?php
/**
* Register css styles, javascript files front end
*
* @package ctc
* @since 2.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Scripts' ) ) :

class HT_CTC_Scripts {


    /**
	 * Register styles - front end ( non admin )
	 *
	 * @since 1.0
	 */
    function register_scripts() {

        $os = get_option('ht_ctc_othersettings');

        // true/false
        $load_app_js_bottom = apply_filters( 'ht_ctc_fh_load_app_js_bottom', true );

        // js
        // $js = 'app.js';
        $js = '332.app.js';
        $woo_js = 'woo.js';
        $group_js = 'group.js';
        $share_js = 'share.js';

        if ( isset($os['debug_mode']) ) {
            $js = 'dev/app.dev.js';
            $woo_js = 'dev/woo.dev.js';
            $group_js = 'dev/group.dev.js';
            $share_js = 'dev/share.dev.js';
        }

        do_action('ht_ctc_ah_scripts_before');

        // app.js for all (chat)
        wp_enqueue_script( 'ht_ctc_app_js', plugins_url( "new/inc/assets/js/$js", HT_CTC_PLUGIN_FILE ), array ( 'jquery' ), HT_CTC_VERSION, $load_app_js_bottom );

        // woocommerce
        if ( class_exists( 'WooCommerce' ) ) {

            // if - cart layout option is checked. 
            $woo_options = get_option('ht_ctc_woo_options');

            if ( isset( $woo_options['woo_single_layout_cart_btn']) || isset( $woo_options['woo_shop_layout_cart_btn']) ) {
                wp_enqueue_script( 'ht_ctc_woo_js', plugins_url( "new/inc/assets/js/$woo_js", HT_CTC_PLUGIN_FILE ), array ( 'jquery' ), HT_CTC_VERSION, $load_app_js_bottom );
            }

        }


        // group.js
        if ( isset ( $os['enable_group'] ) ) { 
            wp_enqueue_script( 'ht_ctc_group_js', plugins_url( "new/inc/assets/js/$group_js", HT_CTC_PLUGIN_FILE ), array ( 'jquery', 'ht_ctc_app_js' ), HT_CTC_VERSION, $load_app_js_bottom );
        }

        // share.js
        if ( isset ( $os['enable_share'] ) ) { 
            wp_enqueue_script( 'ht_ctc_share_js', plugins_url( "new/inc/assets/js/$share_js", HT_CTC_PLUGIN_FILE ), array ( 'jquery', 'ht_ctc_app_js' ), HT_CTC_VERSION, $load_app_js_bottom );
        }

        do_action('ht_ctc_ah_scripts_after');

    }

}

$ht_ctc_scripts =  new HT_CTC_Scripts();

add_action('wp_enqueue_scripts', array( $ht_ctc_scripts, 'register_scripts' ), 1 );

endif; // END class_exists check