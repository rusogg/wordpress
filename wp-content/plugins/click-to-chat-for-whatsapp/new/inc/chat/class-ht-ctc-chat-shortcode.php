<?php
/**
* shortcodes 
* for list of attribute support check  -> shortcode_atts ( $a )
*
* @package chat
* @since 2.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Chat_Shortcode' ) ) :
    
class HT_CTC_Chat_Shortcode {

    //  Register shortcode
    public function shortcodes_init() {
        add_shortcode( 'ht-ctc-chat', array( $this, 'shortcode' ) );
    }

    // call back function - shortcode 
    public function shortcode( $atts = [], $content = null, $shortcode = '' ) {

        $options = get_option( 'ht_ctc_chat_options' );
        $ht_ctc_os = array();

        $number_db = (isset($options['number'])) ? esc_attr($options['number']) : '';
        
        $call_to_action_db = esc_attr( $options['call_to_action'] );
        $pre_filled_db = esc_attr( $options['pre_filled'] );

        $number = __( $number_db , 'click-to-chat-for-whatsapp' );
        $call_to_action = __( $call_to_action_db , 'click-to-chat-for-whatsapp' );
        $pre_filled = __( $pre_filled_db , 'click-to-chat-for-whatsapp' );

        $style_desktop = (isset($options['style_desktop'])) ? esc_attr($options['style_desktop']) : '2';
        if (isset($options['same_settings'])) {
            $style_mobile = $style_desktop;
        } else {
            $style_mobile = (isset($options['style_mobile'])) ? esc_attr($options['style_mobile']) : '2';
        }

        $is_mobile = ht_ctc()->device_type->is_mobile();

        $style = $style_desktop;
        if ( 'yes' == $is_mobile ) {
            $style = $style_mobile;
        }

        // if woocommerce single product page
        if ( function_exists( 'is_product' ) && function_exists( 'wc_get_product' )) {
            if ( is_product() ) {

                $product = wc_get_product();

                $name = $product->get_name();
                // $title = $product->get_title();
                $price = $product->get_price();
                $regular_price = $product->get_regular_price();
                $sku = $product->get_sku();

                // pre-filled
                if ( isset( $options['woo_pre_filled'] ) && '' !== $options['woo_pre_filled'] ) {
                    $pre_filled = esc_attr( $options['woo_pre_filled'] );
                    $pre_filled = apply_filters( 'wpml_translate_single_string', $pre_filled, 'Click to Chat for WhatsApp', 'woo_pre_filled' );
                }
                // variables now works in default pre_filled also
                $pre_filled = str_replace( array('{product}', '{price}', '{regular_price}', '{sku}' ),  array( $name, $price, $regular_price, $sku ), $pre_filled );

                // call to action
                if ( isset( $options['woo_call_to_action'] ) && '' !== $options['woo_call_to_action'] ) {
                    $call_to_action = esc_attr( $options['woo_call_to_action'] );
                    $call_to_action = apply_filters( 'wpml_translate_single_string', $call_to_action, 'Click to Chat for WhatsApp', 'woo_call_to_action' );
                    $call_to_action = str_replace( array('{product}', '{price}', '{regular_price}', '{sku}' ),  array( $name, $price, $regular_price, $sku ), $call_to_action );
                }

            }
        }

        // $content = do_shortcode($content);

        // $ccw_options_cs = get_option('ccw_options_cs');
        //  use like  $ccw_options_cs['']
        
        $a = shortcode_atts(
            array(
                'number' => $number,
                'call_to_action' => $call_to_action,
                'pre_filled' => $pre_filled,
                'style' => $style,
                
                'position' => '',
                'top' => '',
                'right' => '',
                'bottom' => '',
                'left' => '',
                'home' => '',  // home -  to hide on experts .. 
                'hide_mobile' => '',
                'hide_desktop' => '',
                
                's5_img_position' => '',  //left, right
                's5_img_url' => '',
                's5_line_2' => '',

                's8_width' => '',
                's8_icon_position' => '',  // left, right, hide
                
            ), $atts, $shortcode );
        // use like -  '.$a["title"].'   
        
        // number
        $number   = $a["number"];

        // if random number feature, this have to modify (ltrim, preg_replace)
        // $number = preg_replace('/[^0-9,\s]/', '', $number );
        $number = preg_replace('/\D/', '', $number );
        $number = ltrim( $number, '0' );

        // pre-filled text
        $page_url = get_permalink();
        $post_title = esc_html( get_the_title() );

        $pre_filled = $a["pre_filled"];
        $pre_filled = str_replace( array('{{url}}', '{url}', '{{title}}', '{title}', '{{site}}', '{site}' ),  array( $page_url, $page_url, $post_title, $post_title, HT_CTC_BLOG_NAME, HT_CTC_BLOG_NAME ), $pre_filled );

    
        // hide on devices
        // if 'yes' then hide
        $hide_mobile = $a["hide_mobile"];
        $hide_desktop = $a["hide_desktop"];
        
        if( 'yes' == $is_mobile ) {
            if ( 'yes' == $hide_mobile ) {
                return;
            }
        } else {
            if ( 'yes' == $hide_desktop ) {
                return;
            }
        }
        
        
        
        $position   = $a["position"];
        $top        = $a["top"];
        $right      = $a["right"];
        $bottom     = $a["bottom"];
        $left       = $a["left"];
        
        $css = '';

        if ( '' !== $position ) {
            $css .= 'position:'.$position.';';
        }
        if ( '' !== $top ) {
            $css .= 'top:'.$top.';';
        }
        if ( '' !== $right ) {
            $css .= 'right:'.$right.';';
        }
        if ( '' !== $bottom ) {
            $css .= 'bottom:'.$bottom.';';
        }
        if ( '' !== $left ) {
            $css .= 'left:'.$left.';';
        }

        // to hide styles in home, archive, category pages
        $home       = $a["home"];
        // $position !== 'fixed' why !== to avoid double time adding display: none .. 
        if ( 'fixed' !== $position && 'hide' == $home && ( is_home() || is_category() || is_archive() ) ) {
                $css .= 'display:none;';
        }
        // By default position: fixed style hide on home screen, 
        // if plan to show, then add hide='show' ( actually something not equal to 'hide' )
        if ( 'fixed' == $position && 'show' !== $home &&  ( is_home() || is_category() || is_archive() ) ) {
            $css .= 'display:none;';
        }

        $return_type = "chat";

        $style = $a["style"];

        // call to action
        $call_to_action   = $a["call_to_action"];
        
        if ( '' == $call_to_action ) {
            if ( '1' == $style || '4' == $style || '6' == $style || '8' == $style ) {
                $call_to_action = "WhatsApp us";
            }
        }

        $type = "chat-sc";
        $class_names = "ht-ctc-sc ht-ctc-sc-chat sc-style-$style";

        // analytics
        $ht_ctc_os['data-attributes'] = '';
        $ht_ctc_os['class_names'] = '';
        
        // Hooks
        $ht_ctc_os = apply_filters( 'ht_ctc_fh_os', $ht_ctc_os );


        $o = '';

        // shortcode template file path
        $sc_path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles-shortcode/sc-style-' . $style. '.php';

        if ( is_file( $sc_path ) ) {
            $o .= '<div data-number="'.$number.'" data-pre_filled="'.$pre_filled.'" data-style="'.$style.'" style="display: inline; cursor: pointer; z-index: 99999999; '.$css.'" class="'.$class_names.' ht-ctc-inline">';
            include $sc_path;
            $o .= '</div>';
        } else {
            // if style is not in the list.. 
            $img_link = plugins_url("./new/inc/assets/img/whatsapp-logo.svg", HT_CTC_PLUGIN_FILE );
            $o .= '<div data-number="'.$number.'" data-pre_filled="'.$pre_filled.'" style="display: inline; cursor: pointer; z-index: 99999999; '.$css.'" class="'.$class_names.' ht-ctc-inline">';
            $o .= '<img class="img-icon-sc sc_item pointer style-3-sc" src="'.$img_link.'" alt="'.$call_to_action.'" style="height: 50px; '.$css.' " >';
            $o .= '</div>';
        }

        
        return $o;

    }


}


$shortcode = new HT_CTC_Chat_Shortcode();

add_action('init', array( $shortcode, 'shortcodes_init' ) );

endif; // END class_exists check