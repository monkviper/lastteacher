<?php

/** Environmental Constants */
define( 'LT_ENVIRONMENT_DEV', 'dev' );
define( 'LT_ENVIRONMENT_STAGING', 'staging' );
define( 'LT_ENVIRONMENT_PRODUCTION', 'production' );

// ** MySQL settings - You can get this info from your web host ** //
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY', ' .R}RPZazA<hv~Kn(Gi|>+g6-{kl7=-/,+?q$z9/4DzP.Tdki;3?6stc3jbfxy]V' );
define( 'SECURE_AUTH_KEY', '`x!3eg.$$%rNQd[=N -zTF!}|(M.RF6UX_gqK@9* 3[|Qmhlu5J<^Wdz:),P3fDH' );
define( 'LOGGED_IN_KEY', 'd>idyAj%H5}cg-ISU`9enA8((w81e=v&1Qv[k09b<lv4ppX*13r]Gv]U}30yuv]>' );
define( 'NONCE_KEY', '+da)eYHU`wevm8bkB[`<ibTC4*vZ@.Qct(YJh.+rK/GpE-VMD6I=o#z<9n/5o=:g' );
define( 'AUTH_SALT', '5|.-+R3SWo-y~(fV+6l+=4woLU/I5`y-bO|Nnq8[Oa_Tq@$^ZNc_$byN0<m!n.x9' );
define( 'SECURE_AUTH_SALT', '?T~DdPBL_ -k#FF35^58ld~|3NwFCW-vFq~x-_LZ8aV)/|_ss)o_s|(/HcE9MX+z' );
define( 'LOGGED_IN_SALT', 'L<OFn5Ga>QmSwYs&~4tC69ps?}IKpa]y5fE$Uf}N_keob]Zp-.-(sLx2+`Z(g(WJ' );
define( 'NONCE_SALT', '?`;Y+d:M%_|Gw8Jt7Ohmn4ON&(8s`96(rplgk20 O:rQ3te,t|6xSB)^[g;),!mJ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'lt_';

/* AutoSave Interval. */
define( 'AUTOSAVE_INTERVAL', '86400' );

/* Updates */
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'DISALLOW_FILE_EDIT', true );

/* Default Theme */
define( 'WP_DEFAULT_THEME', 'lastteacher' );
