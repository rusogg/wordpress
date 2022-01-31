<?php
/**
 * WhatsApp Chat  - main page .. 
 * 
 * @subpackage chat
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Chat' ) ) :

class HT_CTC_Chat {

    /**
     * Chat
     * 
     * @var $display - changes at show-hide.php
     */
    public function chat() {
        
        $options = get_option('ht_ctc_chat_options');
        $othersettings = get_option('ht_ctc_othersettings');
        $type = "chat";

        // If db values are not correct
		if ( !is_array($options)  || !isset($options['number']) ) {
            return;
        }
		

        $ht_ctc_chat = array();
        $ht_ctc_os = array();
        $ht_ctc_settings = array();

        $page_id = get_the_ID();
        // $page_id = get_queried_object_id();

        // $object_id = get_queried_object_id();
        // if (0 == $object_id || '' == $object_id) {
        //     $page_id = get_the_ID();
        // } else {
        //     $page_id = $object_id;
        // }


        $page_url = get_permalink();
        $post_title = esc_html( get_the_title() );

        if ( is_home() || is_front_page() ) {
            // is home page
            $page_url = home_url('/');
            // if home page is a loop then return site name.. (instead of getting the last post title in that loop)
            $post_title = HT_CTC_BLOG_NAME;

            // if home page is a page then return page title.. (if not {site} and {title} will be same )
            if ( is_page() ) {
                $post_title = esc_html( get_the_title() );
            }
        } elseif ( is_singular() ) {
            // is singular
            $page_url = get_permalink();
            $post_title = esc_html( get_the_title() );
        } elseif ( is_archive() ) {

            if ( isset($_SERVER['HTTP_HOST']) && $_SERVER['REQUEST_URI'] ) {
                $protocol = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https' : 'http';
                $page_url = $protocol . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }

            if ( is_category() ) {
                $post_title = single_cat_title( '', false );
            } elseif ( is_tag() ) {
                $post_title = single_tag_title( '', false );
            } elseif ( is_author() ) {
                $post_title = get_the_author();
            } elseif ( is_post_type_archive() ) {
                $post_title = post_type_archive_title( '', false );
            } elseif ( function_exists( 'is_tax') && function_exists( 'single_term_title') && is_tax() ) {
                $post_title = single_term_title( '', false );
            } else {
                if ( function_exists('get_the_archive_title') ) {
                    $post_title = get_the_archive_title();
                }
            }

        }

        // is shop page
        if ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop') && function_exists( 'wc_get_page_id') && is_shop() ) {
            $page_id = wc_get_page_id( 'shop' );
            $post_title = esc_html( get_the_title( $page_id ) );
        }

        // page level
        $ht_ctc_pagelevel = get_post_meta( $page_id, 'ht_ctc_pagelevel', true );

        /**
         * show/hide
         * $page_display - page level settings  - show/hide/ null
         * $display - global display settings - changes at - show-hide.php
         */
        $display = '';
        $page_display = (isset($ht_ctc_pagelevel['show_hide'])) ? esc_attr($ht_ctc_pagelevel['show_hide']) : '';

        if ( 'show' !== $page_display ) {
            include HT_CTC_PLUGIN_DIR .'new/inc/commons/show-hide.php';
        }


        // is mobile
        $is_mobile = ht_ctc()->device_type->is_mobile();
        // style
        $ht_ctc_chat['style_desktop'] = (isset($options['style_desktop'])) ? esc_attr($options['style_desktop']) : '2';
        if (isset($options['same_settings'])) {
            $ht_ctc_chat['style_mobile'] = $ht_ctc_chat['style_desktop'];
        } else {
            $ht_ctc_chat['style_mobile'] = (isset($options['style_mobile'])) ? esc_attr($options['style_mobile']) : '2';
        }

        // position
        // default position override at js, but useful in amp pages
        $default_position = '';
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/position-to-place.php';
        $ht_ctc_chat['position'] = $position;
        $ht_ctc_chat['position_mobile'] = $position_mobile;
        
        // number
        $number = (isset($options['number'])) ? esc_attr($options['number']) : '';

        // safe side action .. if number not saved in new method
        if ( '' == $number ) {
            $cc = (isset($options['cc'])) ? esc_attr($options['cc']) : '';
            $num = (isset($options['num'])) ? esc_attr($options['num']) : '';
            $number = $cc.$num;
        }

        $ht_ctc_chat['number'] = (isset($ht_ctc_pagelevel['number'])) ? esc_attr($ht_ctc_pagelevel['number']) : $number;
        $ht_ctc_chat['number'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_chat['number'], 'Click to Chat for WhatsApp', 'number' );

        // call to action
        $ht_ctc_chat['call_to_action'] = (isset($ht_ctc_pagelevel['call_to_action'])) ? esc_attr($ht_ctc_pagelevel['call_to_action']) : __( esc_attr( $options['call_to_action'] ) , 'click-to-chat-for-whatsapp' );
        $ht_ctc_chat['call_to_action'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_chat['call_to_action'], 'Click to Chat for WhatsApp', 'call_to_action' );

        // prefilled text
        $ht_ctc_chat['pre_filled'] = (isset($ht_ctc_pagelevel['pre_filled'])) ? esc_attr($ht_ctc_pagelevel['pre_filled']) : __( esc_attr( $options['pre_filled'] ) , 'click-to-chat-for-whatsapp' );
        $ht_ctc_chat['pre_filled'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_chat['pre_filled'], 'Click to Chat for WhatsApp', 'pre_filled' );

        // wa: wa.me  /  web: web/api.whatsapp,  
        $ht_ctc_chat['webandapi'] = 'wa';
        if ( isset( $options['webandapi'] ) ) {
            $ht_ctc_chat['webandapi'] = 'web';
        }

        // need to run the updater backup
        if ( !isset($options['display_mobile']) ) {
            include_once HT_CTC_PLUGIN_DIR . '/new/admin/db/class-ht-ctc-update-db-backup.php';
        }

        $ht_ctc_chat['display_mobile'] = (isset($options['display_mobile'])) ? esc_attr($options['display_mobile']) : 'show';
        $ht_ctc_chat['display_desktop'] = (isset($options['display_desktop'])) ? esc_attr($options['display_desktop']) : 'show';

        // number not added and is administrator
        $no_number = '';
        
        if ( '' == $ht_ctc_chat['number'] ) {
            $no_number = "<p style='background-color:#ffffff; margin:0; border:1px solid #fbfbfb; padding:7px; border-radius:4px; box-shadow:5px 10px 8px #888888;'>No WhatsApp Number Found!</p>";
            if ( current_user_can('administrator') ) {
                $admin_url = admin_url( 'admin.php?page=click-to-chat' );
                $admin_link = "<a href='$admin_url'>WhatsApp number</a>";
                $no_number = "<p style='background-color:#ffffff; margin:0; border:1px solid #fbfbfb; padding:11px; border-radius:4px; box-shadow:5px 10px 8px #888888;'>No WhatsApp Number Found!<br><small style='color:red;'>Admin Notice:<br></small><small>Add $admin_link at pluign Settings<br>If already added, <strong>clear the Cache</strong> and try.<br>If still an issue, please contact plugin developers</small></p>";
            }
        }

        // class names
        $ht_ctc_chat['class_names'] = "ht-ctc ht-ctc-chat ctc-analytics";
        $ht_ctc_chat['id'] = "ht-ctc-chat";
        // schedule
        $ht_ctc_chat['schedule'] = 'no';

        $zindex = (isset($othersettings['zindex'])) ? esc_attr($othersettings['zindex']) : '';
        $zindex = ('' == $zindex) ? '99999999' : $zindex;

        $ht_ctc_chat['css'] = "display: none; cursor: pointer; z-index: $zindex;";

        // analytics
        $ht_ctc_os['is_ga_enable'] = 'yes';
        $ht_ctc_os['is_fb_pixel'] = 'yes';
        $ht_ctc_os['ga_ads'] = 'no';
        $ht_ctc_os['data-attributes'] = '';
        // @since v3.3.5 new way of adding attributes [data-attributes]
        $ht_ctc_os['attributes'] = '';

        // class name related to animations..
        $ht_ctc_os['class_names'] = '';
        // show effect
        $ht_ctc_os['show_effect'] = '';
        $ht_ctc_os['an_type'] = '';

        // hooks
        $ht_ctc_chat = apply_filters( 'ht_ctc_fh_chat', $ht_ctc_chat );
        $ht_ctc_os = apply_filters( 'ht_ctc_fh_os', $ht_ctc_os );
        $ht_ctc_settings = apply_filters( 'ht_ctc_fh_settings', $ht_ctc_settings );

        // pre-filled  - have to run after filter hook. 
        $ht_ctc_chat['pre_filled'] = str_replace( array('{{url}}', '{url}', '{{title}}', '{title}', '{{site}}', '{site}' ),  array( $page_url, $page_url, $post_title, $post_title, HT_CTC_BLOG_NAME, HT_CTC_BLOG_NAME ), $ht_ctc_chat['pre_filled'] );

        // style for desktop, mobile
        if ( 'yes' == $is_mobile ) {
            $ht_ctc_chat['style'] = $ht_ctc_chat['style_mobile'];
            $wp_device = 'ctc_wp_mobile';
        } else {
            $ht_ctc_chat['style'] = $ht_ctc_chat['style_desktop'];
            $wp_device = 'ctc_wp_desktop';
        }

        // @uses at styles / easy call (after filter hook)
        $style = $ht_ctc_chat['style'];
        $style_desktop = $ht_ctc_chat['style_desktop'];
        $style_mobile = $ht_ctc_chat['style_mobile'];
        $call_to_action = $ht_ctc_chat['call_to_action'];

        $other_classes = $ht_ctc_os['class_names'];

        $ht_ctc_chat['class_names'] .= " $wp_device style-$style $other_classes ";

        // call style
        $path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style. '.php';

        $path_d = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style_desktop. '.php';
        $path_m = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style_mobile. '.php';

        
        if ( '' == $call_to_action ) {
            if ( '1' == $style || '4' == $style || '6' == $style || '8' == $style ) {
                $call_to_action = "WhatsApp us";
            }
        }

        $display_css = "display: none; ";

        // AMP
        $is_amp = false;
        $on = "";

        // AMP
        if ( isset($othersettings['amp']) ) {
            // ampforwp_is_amp_endpoint  / is_amp_endpoint / amp_is_request
            if ( function_exists( 'amp_is_request' ) && amp_is_request() ) {
            
                $is_amp = true;

                if ( 'yes' == $is_mobile ) {
                    if ( 'show' == $ht_ctc_chat['display_mobile'] ) {
                        $display_css = "";
                    }
                } else {
                    if ( 'show' == $ht_ctc_chat['display_desktop'] ) {
                        $display_css = "";
                    }
                }
                $display_css .= "cursor:pointer;";

                $pre = rawurlencode($ht_ctc_chat['pre_filled']);
                // 'single quote', 'double quote', '&', '<', '>'
                $pre = str_replace( array('%26%23039%3B', '%26quot%3B', '%26amp%3B', '%26lt%3B', '%26gt%3B'), array('', '', '', '<', '>'), $pre);
                $ext = $ht_ctc_chat['number'] . '?text=' . $pre;
                $wame_link = "https://wa.me/$ext";
                $on = "on=\"tap:AMP.navigateTo(url='$wame_link', target='_blank', opener='')\"";

                wp_deregister_script( 'ht_ctc_app_js' );
            }
        }

        // webhook
        $hook_url = isset($othersettings['hook_url']) ? esc_attr( $othersettings['hook_url'] ) : '';

        
        /**
         * ctc
         * 
         * v - plugin version
         */
        $ctc = array(

            'number' => $ht_ctc_chat['number'],
            'pre_filled' => $ht_ctc_chat['pre_filled'],
            'dis_m' => $ht_ctc_chat['display_mobile'],
            'dis_d' => $ht_ctc_chat['display_desktop'],
            'css' => $ht_ctc_chat['css'],
            'pos_d' => $ht_ctc_chat['position'],
            'pos_m' => $ht_ctc_chat['position_mobile'],
            'schedule' => $ht_ctc_chat['schedule'],
            'se' => $ht_ctc_os['show_effect'],
            'ani' => $ht_ctc_os['an_type'],
        );

        // web whatsapp
        if ( 'web' == $ht_ctc_chat['webandapi'] ) {
            $ctc['web'] = 'y';
        }

        // ga
        if ( 'yes' == $ht_ctc_os['is_ga_enable'] ) {
            $ctc['ga'] = 'yes';
        }
        // ga4
        if ( 'yes' == $ht_ctc_os['ga4'] ) {
            $ctc['ga4'] = 'yes';
        }

        // ads
        if ( 'yes' == $ht_ctc_os['ga_ads'] ) {
            $ctc['ads'] = 'yes';
        }

        // fb
        if ( 'yes' == $ht_ctc_os['is_fb_pixel'] ) {
            $ctc['fb'] = 'yes';
        }

        // adds only if hided on current page
            // global
        if ( 'no' == $display ) {
            $ctc['display'] = 'no';
        }
            // page level
        if ( 'hide' == $page_display ) {
            $ctc['page_display'] = 'hide';
        }

        // webhook
        if ( '' !== $hook_url ) {
            // $ctc hook url
            $ctc['hook_url'] = $hook_url;
            $hook_v = isset($othersettings['hook_v']) ? $othersettings['hook_v'] : '';

            if ( is_array($hook_v) ) {
                $hook_v = array_filter($hook_v);
                $hook_v = array_values($hook_v);
                $hook_v = array_map('esc_attr', $hook_v );
                
                if ( isset($hook_v[0]) ) {
                    // $ctc - hook values
                    $ctc['hook_v'] = $hook_v;
                }
            }
        }

        $ctc = apply_filters( 'ht_ctc_fh_ctc', $ctc );

        // data-attribute - data-settings 
        $ht_ctc_settings = htmlspecialchars(json_encode($ctc), ENT_QUOTES, 'UTF-8');
        
        // localize script - ht_ctc_chat_var
        wp_localize_script( 'ht_ctc_app_js', 'ht_ctc_chat_var', $ctc );



        // 'no' == $display - hided from global settings (display can be no, only after checking page display is not show)
        // 'hide' == $page_display - hided at page level settings
        if ( 'no' == $display || 'hide' == $page_display ) {
            return;
        }


        // load style
        if ( is_file( $path ) ) {
            do_action('ht_ctc_ah_before_fixed_position');
            ?>  
            <div class="<?= $ht_ctc_chat['class_names'] ?>" id="<?= $ht_ctc_chat['id'] ?>"  
                style="<?= $display_css ?> <?= $default_position ?>" <?= $ht_ctc_os['attributes'] ?> <?= $on ?> >
                <?php
                do_action('ht_ctc_ah_in_fixed_position');
                ?>
                <div class="ht_ctc_style ht_ctc_chat_style">
                <?php
                if ( isset( $options['select_styles_issue'] ) ) {
                    ?>
                    <div class="ht_ctc_desktop_chat"><?php include $path_d; ?></div>
                    <div class="ht_ctc_mobile_chat"><?php include $path_m; ?></div>
                    <?php
                } else {
                    include $path;
                }
                ?>
                </div>
            </div>
            <?php
            do_action('ht_ctc_ah_after_fixed_position');
            

            // if js var not available, dont depend on this element ht_ctc_chat_data
            // no_number may be needed.
            ?>
            <span class="ht_ctc_chat_data" 
                data-no_number="<?= $no_number ?>"
                data-settings="<?= $ht_ctc_settings ?>" 
            ></span>
            <?php

        }

        
    }

}

// new HT_CTC_Chat();

$ht_ctc_chat = new HT_CTC_Chat();

// wp_footer / wp_head / get_footer
$ht_ctc_chat_load_position = apply_filters( 'ht_ctc_chat_load_position', 'wp_footer' );

add_action( "$ht_ctc_chat_load_position", array( $ht_ctc_chat, 'chat' ) );

endif; // END class_exists check