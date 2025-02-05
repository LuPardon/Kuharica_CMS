<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kuharica' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'HsVwBHoM!R2|a7gMadtO]]xy^ea#R`r)P[nw^>:JR.3Wf|Qsn$}DsSObt6f<g%p;' );
define( 'SECURE_AUTH_KEY',  'OPyPjcEYwmouUkp}Hj+xw[+C3rXKg~j=>6mG6HeCWHrK`7^87lrh2C_4sVZ}9pdR' );
define( 'LOGGED_IN_KEY',    'E%O%aJJdB~z&SU3{]}Vh]K+:W[*[$1_i-Cs[MlWE|Do?JzAlRa&AgoQ?m/T$}Ni}' );
define( 'NONCE_KEY',        'xgD)Pp#nLsF%(YtWHKT{hP8cd!,3A6nuUO$jQYw}u6>CW4)rjo^tR>$w$@nQ?^4I' );
define( 'AUTH_SALT',        'NNL`JvzZN2TYV$Gn.Ybom>o7fj`*>l%ubot}cEb?*{l[`tr[3KqKNPm>*|#:kee!' );
define( 'SECURE_AUTH_SALT', '=!O(&,,=k*bl2@x /j~+T[FhKu)?4+XuP&jnFHa]n*J7{Gb3rL, m6]]8_<HbiVx' );
define( 'LOGGED_IN_SALT',   '|rrDu`w9`fbl1Mh}8dvj5muE:-E9Uf),;Y;<Z0?DQK[Bep,_ZtF;hQJTQn%jh*Ml' );
define( 'NONCE_SALT',       'J7!1>gs27:4H`qR-b_*U<` +E|pLT+[Nx>(<`Tbzl*$&yvjeKXh5w@X`,dq(,.4:' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
