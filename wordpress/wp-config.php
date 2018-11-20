<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'iki_exchange');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'NXmjA%0wbi|alF7ze81nhW. Ju? a,S[AJNvvqboBrk0@_63cqN3KnF DRXjrqC+');
define('SECURE_AUTH_KEY',  '6~It; 17KmcBlJMDP^x]S_ih8Q#jMbBf `*Y!hI2/C8gW&2@[^M/XI7e-Vt@-`(K');
define('LOGGED_IN_KEY',    '5P!Q mH4-*P9HX_Ld{~P))z6Mw&~VY[v|C,5[o(z$5lO)wXeHucE17 6}IJ-)&~F');
define('NONCE_KEY',        'j @4de[E%NlFHQP3WCRES`s3yS;e%8khZMt/qC)|wWR8y&&h2.;0APQIc%WkEX{^');
define('AUTH_SALT',        'a8l@esemvoAHNlG$KD:mPatBLtse4$ZVC0L}E[HoWt%kEwgO>.J{4} 4anhahDXb');
define('SECURE_AUTH_SALT', 'gmPX%eI#vS@K1E*4r&q_>n4yUeVWtyMj~{zdd=Y~i)U1nG/$cy xc;VNz$b#g_{/');
define('LOGGED_IN_SALT',   '.n*N*@82fe0:h>DC<Mk[s**6aYu_3xMj/XZ}+%oK;>PY}gL}PVg31CjM]t;OsWal');
define('NONCE_SALT',       '^*22PC7G};S@g(0dd%M2C7PoPGyeW(c5.tY*,(;*x7{wU7e_$=J^>fhivPs.ct++');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
