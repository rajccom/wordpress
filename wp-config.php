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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'Nn9m5Pe(N|p~.P~ N>f^AE~YTfU-* e?}wk|lA,YQU,<z>Fw&,dzZYS%uVOoZGT{' );
define( 'SECURE_AUTH_KEY',  '4S|qE#yV5IkMnw7`fZN`y9WiVg^ByLTu4*Hs6kAOTOLD|W>5HP>U6#x|QVA,rE0K' );
define( 'LOGGED_IN_KEY',    '/PFDm@Uo=S2>F_j&4XIN/d0U5Y&OQ4/qw/fL^e/Z/> PUZ&j$DyKN*.@@/yx|IE?' );
define( 'NONCE_KEY',        '~i@]~c3yrb~$R(i35+]piO7vD6!%m*19yN>p2+ >%bc$5(d3NJH4NUkfeTN>u8AF' );
define( 'AUTH_SALT',        '2NS=Zs8+,n##YCc~* aN,@)M2RD=GW]cfDIlek9L64LVVyf!n0<H+9ZdWZ}~xbuQ' );
define( 'SECURE_AUTH_SALT', '9hmhwn3>u/`Dv;.a#N]R<?%*9mK:^or]uGC4sM_#>I~D)R0lmSsZ#[x`.o}/)]Ly' );
define( 'LOGGED_IN_SALT',   '5<dleC~UT;y;9P8X_l!`0v>2*dquh#cusxQ`}AIoc%c=[_o0*)[8N7H7rBLCw!kM' );
define( 'NONCE_SALT',       '*ta(ok1F|,7;K0bBn}e|_3_L|XeJjKjmq*Jvn88*FHXy9cV_X7^f/-D4`1838$jn' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
