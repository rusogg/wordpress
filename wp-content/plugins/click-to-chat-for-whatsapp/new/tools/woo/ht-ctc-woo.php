<?php
/**
 * Init WooCommerce
 * 
 * @included from ht-ctc.php using init hook
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_WOO' ) ) :

class HT_CTC_WOO {

    public function __construct() {
        $this->woo_init();
    }


    function woo_init() {

        // if woocommece plugin in active (checking this way works as now)
        if ( class_exists( 'WooCommerce' ) ) {
    
            if ( is_admin() ) {
                // woo admin
                // woo admin page
                add_action( 'ht_ctc_ah_admin_includes_after_main_page', array($this, 'admin_page') );
            } else {
                // woo public
                include_once HT_CTC_PLUGIN_DIR .'new/tools/woo/class-ht-ctc-woo.php';
            }

        }
    }

    function admin_page() {

        include_once HT_CTC_PLUGIN_DIR .'new/tools/woo/woo-admin/class-ht-ctc-admin-woo-page.php';

    }
    




}

new HT_CTC_WOO();

endif; // END class_exists check