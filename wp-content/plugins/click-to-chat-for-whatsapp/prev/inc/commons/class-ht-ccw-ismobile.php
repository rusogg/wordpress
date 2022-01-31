<?php
/**
 * detect device -  mobile or not
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW_IsMobile' ) ) :

class HT_CCW_IsMobile {

    /**
     * return is mobile or not
     * while using in condition check with 1 not with 2
     * @var int - if mobile : 1 ?  2
     */
    public $is_mobile;

    public function __construct() {
        
        $this->is_mobile = $this->is_mobile();
        
    }

    /**
     * added this  -  an user mention that wp_is_mobile uncauched error
     *  so now it easy to fix incase more users repoted this issue
     * 
     * Check is mobile device or not
     * wp_is_mobile - if true then 1, else 2
     */
    public function is_mobile() {
        
        if ( function_exists( 'wp_is_mobile' ) ) {
            if ( wp_is_mobile() ) {
                return $this->is_mobile = 1;
            } else {
                return $this->is_mobile = 2;
            }
        } else {
            if ( $this->php_is_mobile() ) {
                return $this->is_mobile = 1;
            } else {
                return $this->is_mobile = 2;
            }
        }

    }


    /**
     * @uses $this -> is_mobile
     * 
     * php way of find is mobile
     * fallback if wp_is_mobile is not defined 
     * @return boolean
     */
    public function php_is_mobile() {
        // return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        return preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackbe‌​rry|iemobile|bolt|bo‌​ost|cricket|docomo|f‌​one|hiptop|mini|oper‌​a mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|‌​webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }  



}

endif; // END class_exists check