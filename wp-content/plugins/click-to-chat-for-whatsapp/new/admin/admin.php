<?php
/**
*  starting point for the admin side of this plugin.
*
*  include other file here .. which need in admin side. 
*
*  In click-to-chat.php this file will be loaded as is_admin
*
* @package ctc
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;


$ht_ctc_othersettings = get_option('ht_ctc_othersettings');


/*************** includes ***********/

// others - hooks ....
include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/class-ht-ctc-admin-hooks.php';

// add scripts
include_once HT_CTC_PLUGIN_DIR .'new/admin/class-ht-ctc-admin-scripts.php';

// Main, Chat admin page
include_once HT_CTC_PLUGIN_DIR .'new/admin/class-ht-ctc-admin-main-page.php';

do_action('ht_ctc_ah_admin_includes_after_main_page' );

// group admin page
if ( isset ( $ht_ctc_othersettings['enable_group'] ) ) { 
    include_once HT_CTC_PLUGIN_DIR .'new/admin/class-ht-ctc-admin-group-page.php';
}

// share admin page
if ( isset ( $ht_ctc_othersettings['enable_share'] ) ) { 
    include_once HT_CTC_PLUGIN_DIR .'new/admin/class-ht-ctc-admin-share-page.php';
}

// customize
include_once HT_CTC_PLUGIN_DIR .'new/admin/class-ht-ctc-admin-customize-styles.php';

// other settings - enable options ..
include_once HT_CTC_PLUGIN_DIR .'new/admin/class-ht-ctc-admin-other-settings.php';

// meta boxes - change values at page level
include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/class-ht-ctc-metabox.php';

do_action('ht_ctc_ah_admin_includes' );