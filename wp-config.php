<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'i1542677_wp1');

/** MySQL database username */
define('DB_USER', 'i1542677_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'B*rSVwr]nW27^^8');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'GEW1XiRDf1iNJIeW75zy3fg0X6UdfE0uo87KA4WGiwO5hVjJeecmQrs82tfBjHud');
define('SECURE_AUTH_KEY',  'DupN0j8OjevdjUsFByiLnihmISuMnbLTyTjDI3DGuUpkpFlWL2lxsuBdLZdc5WwG');
define('LOGGED_IN_KEY',    'vIKhIeJ463oOPK9xADrTryyUfrzQWRKthFWH38JHMPKk98V5woCQi3vGeRRuR5yQ');
define('NONCE_KEY',        '6HZ2z7DfWfd4OhSo5ktG3AjaPrn8JxDIaundesRs6sRX53b1C7aNhbqqIhGnQNPv');
define('AUTH_SALT',        'X08Z9IKzNwDf2urb27NKDsKIaeEkMhWyxJDCJ5HlS47pI7RQcCfVkvYYBVRuqrU2');
define('SECURE_AUTH_SALT', 'KvnB2zpRc594pzgFkHLGMefv33XYg6IWvEtuayiv4BUzgdvEzPxDJ2a60Dkw2aSM');
define('LOGGED_IN_SALT',   'j9S1mX87K3jbnoQWFU0O0faaKeINMFwHbOQF2N3JkFA8Pl2G31tnlg0KYzUPLRUv');
define('NONCE_SALT',       'P9XWQVWk2F8BBWjmBbgPU3rVNhitWOd76FFws5lt9h2Xt6MPxeCzcQC7cgBiBTvQ');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
