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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'UuGVUJbugHM4SrjrCymLAi78UtZzFWGlp2HiIE0y5MRuA9tobq53R6kGj/9ifKGsJ2teWVeBnwEKnqSHDwKu9A==');
define('SECURE_AUTH_KEY',  'N3aOJ4MQbtHWGyIHCgToHIyt2Nm1QLGVZD8Kukf/n6GKQvM6plLRrf8+LBQLyhKl1FWLKU5mQZVTHe1D80W4Vw==');
define('LOGGED_IN_KEY',    'KzmQHBp1FEbmRTx5laol7kJ3k3FpzgBQ0o1ijSVws0C9aIwcV/NF6g6OddDGPU206PrmUh/CLZKnTSMSyYPg1A==');
define('NONCE_KEY',        'WOv40Q+mZ++mMolwxj6k/5XCQFTjoksKBC3xjickAWWSPQJLBT9tpbU5imNtZIN2NBb2hKqhg9bs8xJUvQVP4w==');
define('AUTH_SALT',        'LE7OcIMQ21El0qbzDr/iXL7p0SynWhd+bb1BY52DS7hK/YE/1ZlnIPGJU52Kg0B4GnIhXOJiEK/Q7idK/4DetA==');
define('SECURE_AUTH_SALT', 'hPzYjaJ9xBt+JvISidtNBQMoiWlYM7c7KwspRXOV+the03nI1rHrbPyzXGhFYcppRd4yU70faAeIAsbdN6CKMA==');
define('LOGGED_IN_SALT',   'hWqiKRaFOPZjMPmL/ENIrwfO0gJXBMzbyZbV+ZHTEhELNvVnlPXaqUnq9dnK6toIHtR1prYKEDTdbNdJBA9JaA==');
define('NONCE_SALT',       'CJaBlD2lQEoqqQor44UFHAhz5ZSj5II3xb6i6rdS7dBXviJMe3lHDyRFoYpPfW3ibIAjBAsvfIuSt2+BJCNEdQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
