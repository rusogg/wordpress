<?php
/**
*  starting point for the admin side of this plugin.
*  include other file here .. which need in admin side. 
*  In click-to-chat.php this file will be loaded as is_admin
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/*************** includes ***********/
include_once 'class-ccw-add-styles-scripts-admin.php';

include_once 'commons/class-ht-ccw-admin-lists.php';

include_once 'class-ccw-admin-menu.php';
include_once 'class-ccw-admin-page.php';
include_once 'class-ccw-admin-page-customize-styles.php';
include_once 'class-ccw-admin-others.php';