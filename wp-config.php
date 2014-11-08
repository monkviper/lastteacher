<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up the Wordpress installation specific config. */
require_once(ABSPATH . 'config' . DIRECTORY_SEPARATOR . 'default.php');
require_once(ABSPATH . 'config' . DIRECTORY_SEPARATOR . 'environment.php');
require_once(ABSPATH . 'config' . DIRECTORY_SEPARATOR . LT_ENVIRONMENT . '.php');
require_once(ABSPATH . 'config' . DIRECTORY_SEPARATOR . 'local.php');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
