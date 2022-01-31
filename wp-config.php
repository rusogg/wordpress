<?php
//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'q K}0`r/[hJzG1tJ2pOZli&<MDbO=$M+$(5tdO,#dg<9gb=:9yU)GYXfD^Y+_sc?' );
define( 'SECURE_AUTH_KEY',  'ii<p^@~sx>ipO)0G]tlLUbhC=o#haY*,bGx%RO1(5ltS6y479z(k=,^i LgoVt6q' );
define( 'LOGGED_IN_KEY',    'Bdp{I7V0t(N[i;+&JRo/.Y#krz/8=Go}V+$~B~--5TB{Jih.a}gWfvf8)Rr,zu[1' );
define( 'NONCE_KEY',        '_tO3!Jp)bQW86~=t%lpqd+]/KEE#+d?8h<M1Au}).1ZGdw40&+_SNr~^lPyj0qFY' );
define( 'AUTH_SALT',        'E+1ia7H=IS,cUj7R}Bz^uK&R+~{hY-h9p;26skI:jDk[)JW~q4<epQyw07>:nJi@' );
define( 'SECURE_AUTH_SALT', '6:;2gy$HKRjS}bagWon}*IgL(dPj(y~YSi3WL>7w}1^/JfHpxV_=Qfh!?:~MimnT' );
define( 'LOGGED_IN_SALT',   '/.#xAKog_ sX]6Az1V%&NwdDHG 4/mD?nj@lK,H3(gp_BR6O{R$^8luOd!WFv<;.' );
define( 'NONCE_SALT',       '{~S94;g5lqHQhS(*tI_OYmZ:EMS$JW)r #.WST_e@a]-DzFqN:gn|aH4~hi>[_b;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
