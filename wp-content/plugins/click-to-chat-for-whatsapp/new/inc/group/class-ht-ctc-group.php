<?php
/**
 * Group chat/invite feature - main page
 * 
 * @subpackage group
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Group' ) ) :

class HT_CTC_Group {

    public function __construct() {
        // $this->group();
    }

    public function group() {
        
        $options = get_option('ht_ctc_group');
        $othersettings = get_option('ht_ctc_othersettings');
        $type = "group";

        // If db values are not correct
		if ( !is_array($options)  || !isset($options['group_id']) ) {
            return;
        }

        $ht_ctc_group = array();
        $ht_ctc_os = array();

        // show/hide
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/show-hide.php';

        if ( 'no' == $display ) {
            return;
        }

        // is mobile to select styles
        $is_mobile = ht_ctc()->device_type->is_mobile();

        // style
        $ht_ctc_group['style_desktop'] = (isset($options['style_desktop'])) ? esc_attr($options['style_desktop']) : '2';
        if (isset($options['same_settings'])) {
            $ht_ctc_group['style_mobile'] = $ht_ctc_group['style_desktop'];
        } else {
            $ht_ctc_group['style_mobile'] = (isset($options['style_mobile'])) ? esc_attr($options['style_mobile']) : '2';
        }

        // position
        include HT_CTC_PLUGIN_DIR .'new/inc/commons/position-to-place.php';
        $ht_ctc_group['position'] = $position;
        $ht_ctc_group['position_mobile'] = $position_mobile;

        // call to action
        $ht_ctc_group['call_to_action'] = esc_attr( $options['call_to_action'] );
        $ht_ctc_group['call_to_action'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_group['call_to_action'], 'Click to Chat for WhatsApp', 'call_to_action__group' );

        // class names
        $ht_ctc_group['class_names'] = "ht-ctc ht-ctc-group ";

        $page_id = get_the_ID();

        // At page level
        $ht_ctc_pagelevel = get_post_meta( $page_id, 'ht_ctc_pagelevel', true );

        // group id
        $ht_ctc_group['group_id'] = (isset($ht_ctc_pagelevel['group_id'])) ? esc_attr($ht_ctc_pagelevel['group_id']) : esc_attr( $options['group_id'] );
        $ht_ctc_group['group_id'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_group['group_id'], 'Click to Chat for WhatsApp', 'group_id__group' );


        $ht_ctc_group['display_mobile'] = (isset($options['display_mobile'])) ? esc_attr($options['display_mobile']) : 'show';
        $ht_ctc_group['display_desktop'] = (isset($options['display_desktop'])) ? esc_attr($options['display_desktop']) : 'show';

        $zindex = (isset($othersettings['zindex'])) ? esc_attr($othersettings['zindex']) : '';
        $zindex = ('' == $zindex) ? '99999999' : $zindex;

        $ht_ctc_group['css'] = "display: none; cursor: pointer; z-index: $zindex;";

        // analytics
        $ht_ctc_os['is_ga_enable'] = 'yes';
        $ht_ctc_os['is_fb_pixel'] = 'yes';
        $ht_ctc_os['ga_ads'] = 'no';
        $ht_ctc_os['data-attributes'] = '';
        // show effect
        $ht_ctc_os['show_effect'] = '';
        $ht_ctc_os['class_names'] = '';

        // hooks
        $ht_ctc_group = apply_filters( 'ht_ctc_fh_group', $ht_ctc_group );
        $ht_ctc_os = apply_filters( 'ht_ctc_fh_os', $ht_ctc_os );

        // style for desktop, mobile
        if ( 'yes' == $is_mobile ) {
            $ht_ctc_group['style'] = $ht_ctc_group['style_mobile'];
        } else {
            $ht_ctc_group['style'] = $ht_ctc_group['style_desktop'];
        }

        // @uses at styles / easy call (after filter hook)
        $style = $ht_ctc_group['style'];
        $style_desktop = $ht_ctc_group['style_desktop'];
        $style_mobile = $ht_ctc_group['style_mobile'];
        $call_to_action = $ht_ctc_group['call_to_action'];
        
        $other_classes = $ht_ctc_os['class_names'];

        $ht_ctc_group['class_names'] .= " style-$style $other_classes";

        if ( '' == $call_to_action ) {
            if ( '1' == $style || '4' == $style || '6' == $style || '8' == $style ) {
                $call_to_action = "WhatsApp Share";
            }
        }

        // call style
        $path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style. '.php';

        $path_d = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style_desktop. '.php';
        $path_m = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/styles/style-' . $style_mobile. '.php';


        if ( is_file( $path ) ) {
            do_action('ht_ctc_ah_before_fixed_position');
            ?>
            <div class="<?= $ht_ctc_group['class_names'] ?>" 
                style="display: none;"
                data-return_type="<?= $type ?>" 
                data-group_id="<?= $ht_ctc_group['group_id'] ?>" 
                data-is_ga_enable="<?= $ht_ctc_os['is_ga_enable'] ?>" 
                data-is_fb_pixel="<?= $ht_ctc_os['is_fb_pixel'] ?>" 
                data-ga_ads="<?= $ht_ctc_os['ga_ads'] ?>" 
                data-display_mobile="<?= $ht_ctc_group['display_mobile'] ?>" 
                data-display_desktop="<?= $ht_ctc_group['display_desktop'] ?>" 
                data-css="<?= $ht_ctc_group['css'] ?>" 
                data-position="<?= $ht_ctc_group['position'] ?>" 
                data-position_mobile="<?= $ht_ctc_group['position_mobile'] ?>" 
                data-show_effect="<?= $ht_ctc_os['show_effect'] ?>" 
                <?= $ht_ctc_os['data-attributes'] ?>  
                >
                <?php 
                if ( isset( $options['select_styles_issue'] ) ) {
                    ?>
                    <div class="ht_ctc_desktop_group"><?php include $path_d; ?></div>
                    <div class="ht_ctc_mobile_group"><?php include $path_m; ?></div>
                    <?php
                } else {
                    include $path;
                }
                ?>
            </div>
            <?php
            do_action('ht_ctc_ah_after_fixed_position');
        }

        
    }

}

// new HT_CTC_Group();

$ht_ctc_group = new HT_CTC_Group();
add_action( 'wp_footer', array( $ht_ctc_group, 'group' ) );


endif; // END class_exists check