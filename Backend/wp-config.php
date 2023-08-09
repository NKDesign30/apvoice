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

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

function env($value, $default = null)
{
	return getenv($value) ? getenv($value) : $default;
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', env('WORDPRESS_DB_NAME', 'apovoice'));

/** MySQL database username */
define('DB_USER', env('WORDPRESS_DB_USER', 'root'));

/** MySQL database password */
define('DB_PASSWORD', env('WORDPRESS_DB_PASSWORD', 'root'));

/** MySQL hostname */
define('DB_HOST', env('WORDPRESS_DB_HOST', 'mysql'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', env('WORDPRESS_DB_CHARSET', 'utf8'));

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Set SSL database connection */
if (!is_null(env('WORDPRESS_SSL_DB_CONNECTION'))) {
	define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL);
}

/** Set Azure storage account name if it is set in the environment */
if (!is_null(env('APOVOICE_MICROSOFT_AZURE_STORAGE_ACCOUNT_NAME'))) {
	define('MICROSOFT_AZURE_ACCOUNT_NAME', env('APOVOICE_MICROSOFT_AZURE_STORAGE_ACCOUNT_NAME', null));
}

/** Set Azure storage account key if it is set in the environment */
if (!is_null(env('APOVOICE_MICROSOFT_AZURE_STORAGE_ACCOUNT_KEY'))) {
	define('MICROSOFT_AZURE_ACCOUNT_KEY', env('APOVOICE_MICROSOFT_AZURE_STORAGE_ACCOUNT_KEY', null));
}

/** Set Azure storage container if it is set in the environment */
if (!is_null(env('APOVOICE_MICROSOFT_AZURE_STORAGE_MEDIA_CONTAINER'))) {
	define('MICROSOFT_AZURE_CONTAINER', env('APOVOICE_MICROSOFT_AZURE_STORAGE_MEDIA_CONTAINER', null));
}

/** Set Azure storage cname if it is set in the environment */
if (!is_null(env('APOVOICE_MICROSOFT_AZURE_STORAGE_CNAME'))) {
	define('MICROSOFT_AZURE_CNAME', env('APOVOICE_MICROSOFT_AZURE_STORAGE_CNAME', null));
}

/** Set Azure storage default upload if it is set in the environment */
if (!is_null(env('APOVOICE_MICROSOFT_AZURE_STORAGE_USE_FOR_DEFAULT_UPLOAD'))) {
	define('MICROSOFT_AZURE_USE_FOR_DEFAULT_UPLOAD', env('APOVOICE_MICROSOFT_AZURE_STORAGE_USE_FOR_DEFAULT_UPLOAD', null));
}

/** Set Azure storage container for user profile uploads if it is set in the environment */
define('MICROSOFT_AZURE_USER_PROFILE_CONTAINER', env('APOVOICE_MICROSOFT_AZURE_STORAGE_USER_PROFILE_CONTAINER', 'user-uploads'));

/** Set Azure storage container for raffle uploads if it is set in the environment */
define('MICROSOFT_AZURE_RAFFLE_CONTAINER', env('APOVOICE_MICROSOFT_AZURE_STORAGE_RAFFLE_CONTAINER', 'raffles'));

/** 
 * Set Credentials for the reporting api
 * use the username:password convention
 * the credentials are passed as base64 encoded string in the request header
 */
define('REPORTING_API_SECRET', env('APOVOICE_REPORTING_API_SECRET', 'apovoice:CbwnvIvwLmxAxbBTJSeK'));

define('REPORTING_INITIAL_START_DATE', env('APOVOICE_REPORTING_INITIAL_START_DATE', '2020-01-06'));

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         env('WORDPRESS_AUTH_KEY', '[R|Ad!EqRupZQNJVW*:E<]9TwiK+ MtV/dqyACR0$s8<OLc.<(7VL8vSd>f/2:i5'));
define('SECURE_AUTH_KEY',  env('WORDPRESS_SECURE_AUTH_KEY', '+n0wNJ-8p9xH`sV6b>b=PW`,<|7f{Nv~=FqJUNQ$<X~.9&:GxTb+,)PN@Vcb/! o'));
define('LOGGED_IN_KEY',    env('WORDPRESS_LOGGED_IN_KEY', '>1MHW=V=WN`?N`8TQ=k&Pbf&@nPX)S1a-]g09t;d1b@r20Nr+nsLDd/bLv6m/bqE'));
define('NONCE_KEY',        env('WORDPRESS_NONCE_KEY', '(C;e#JJO3Y(cQ3I,YV:muzLF;m:t%G:7D0%X]p/-Ap%Du7MdKt46Kp7^60sGkU<K'));
define('AUTH_SALT',        env('WORDPRESS_AUTH_SALT', 'X-4x7a $%mTt=CP)f,JjNK{#;bg!Uqn[-!>imxToY?H~9&acvsvyMUkb-%F-Eq,+'));
define('SECURE_AUTH_SALT', env('WORDPRESS_SECURE_AUTH_SALT', 'c6vF-aoa;cDI,%LAl=#eL{+t<Ct%e_Nd:2Oa]RbTgOtTd6B$`{B_G]Br3@-LrDQa'));
define('LOGGED_IN_SALT',   env('WORDPRESS_LOGGED_IN_SALT', '<HFRin[BQ<5U~@DSl{7=:9[.`eh6{vb>6!Fr-UfQ#7 V-9tB+!#$1FU&dH$VyYg+'));
define('NONCE_SALT',       env('WORDPRESS_NONCE_SALT', '`B>V|{&>+>K&+6Yy~R|9p7(|A*GdG$2<<X!VrG)9Yc#{N)+$!4,brmsH*D+p~.J6'));

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', env('WORDPRESS_DEBUG', false));


// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', true);
// define('SAVEQUERIES', true);

/** JWT Auth Configurations */
define('JWT_AUTH_SECRET_KEY', env('WORDPRESS_JWT_AUTH_SECRET_KEY', 'Mbxw8749RZC2IR2qfJde'));
define('JWT_AUTH_CORS_ENABLE', env('WORDPRESS_JWT_AUTH_CORS_ENABLE', true));

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', env('WORDPRESS_DOMAIN_CURRENT_SITE', 'localhost'));
define('PATH_CURRENT_SITE',  env('WORDPRESS_PATH_CURRENT_SITE', '/'));
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/**
 * Additional custom settings 
 */

/* Limiting post revisions */
define('WP_POST_REVISIONS', env('WORDPRESS_POST_REVISION_LIMIT', 3));

/* Sets the post revision autosave interval */
define('AUTOSAVE_INTERVAL', env('WORDPRESS_POST_REVISION_AUTOSAVE_INTERVAL', 60));

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
