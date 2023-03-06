<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'thfmu_com' );

/** Database username */
define( 'DB_USER', 'thfmu_com' );

/** Database password */
define( 'DB_PASSWORD', 'KmNPSErx78T4z4zK' );

/** Database hostname */
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
define( 'AUTH_KEY',         'H(ZP=:4Ve|:|)A-h=!huZ{R!p{q9cTI:=_qy?hc=(Rap|%%aI8V7ZC^PB2%`lL/$' );
define( 'SECURE_AUTH_KEY',  '6b$bC@_8N&Du@Gw#*ML|3xR&epv88c55pXda~8{ZW{?J<fJ:*=B(Esygtad6`(;t' );
define( 'LOGGED_IN_KEY',    'qSTvb1jK]ZMtjtr*4{}]^C/;=30!LV?58Xt%%#7z2R-I(sy6u^04=DmNLG:P=N.d' );
define( 'NONCE_KEY',        'I`8foX*Ob}A<j4N1fjP} d f8ij2/{iTk^+zs&b:EiL 1,a:(_`A.[i?+$|4n9r0' );
define( 'AUTH_SALT',        ']d yGdHj8p,BL7{oHis)de )S[otseu!n;)#WIg,t&&g=8J8[Pk zYz!!<[{36L,' );
define( 'SECURE_AUTH_SALT', 'YO2Wlk.9Z}P;g6Zgl>No8!Q]Vo2AwF{_b/[fln=eyL_Dxg[N%;aA7T_F)@1nD^}6' );
define( 'LOGGED_IN_SALT',   'm{SNHz&A6ezG{N0E3~0@E(sk!e?5G10xft|-!mSe/PL9%83$o|%F&OnVxOCwkKO3' );
define( 'NONCE_SALT',       'bqFu!?)O{$VL0sVV{|KZWr(9g2r2`4Q5)+^!14sP*aH8xb.5n_VI>=YKzva2]*ZD' );

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
