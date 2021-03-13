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
define( 'DB_NAME', 'tatticker' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'g<s}Ki%i%7aH/^`E^LGp{xAH-qMA?p-cRnT-^ls+LLSv)oicV(QrJhE~WV_K#&50' );
define( 'SECURE_AUTH_KEY',  'v]u5.e_!@%{wrjhgP?/VkN<t7IP&ukVQR9<^5l|))q44Jh=JcvV}UXmTU[S36EK1' );
define( 'LOGGED_IN_KEY',    'D:&pR{wMPRb0a~fj;3yL5s=q.2ffE3=t3.L9@PHAG vl1]L&+(?9CR|)lN,23Sa2' );
define( 'NONCE_KEY',        '(cl}i=jE{1t;i]Mp{%NTG&[12t=)F.#1sHoDOL5;Ia}!quI,WgXGM36[(BWi(UA7' );
define( 'AUTH_SALT',        '<sMk*bTn!Uo?Dz{<;tPWUKiD+FG0~rDs@22~ZcvJzX-iCu#=jk*=?`~@=g=)xvli' );
define( 'SECURE_AUTH_SALT', '0{A^*DlRtgo[|WO4b<Ur_o9dYj#*U8raAf=-Il_j4+Z*.#aMB.`#O;lSN`~ofpH;' );
define( 'LOGGED_IN_SALT',   '/D0%8/pYZ>u]O@m<pE<y7yV<Q[o*v=).nYK:CPVY,~T>Nja<BNdhb4U9>A$ksai/' );
define( 'NONCE_SALT',       'jeTytSWA/MA=C%v?n?p31R$[^?N<}G@1xiesN9y/Gj,P0bK|?x(7C}QJfVW$Rx:h' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
