<?php

/* Last Teacher Theme Version */
define( 'LT_VERSION', '1.0' );

/* Last Teacher Theme Directory Paths */
define( 'LT_THEME_DIR', get_template_directory() );
define( 'LT_EXT_DIR', LT_THEME_DIR . '/ext' );
define( 'LT_INC_DIR', LT_THEME_DIR . '/inc' );
define( 'LT_JS_DIR', LT_THEME_DIR . '/js' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if( !isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lt_setup() {
}

add_action( 'after_setup_theme', 'lt_setup' );

/**
 * Enqueue scripts and styles.
 */
function lt_scripts() {
	wp_enqueue_style( 'lt-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'lt_scripts' );

/** Include the file to hook the main modifications */
require_once LT_INC_DIR . '/main.php';

/** Include the file to make some wordpress tweaks */
require_once LT_INC_DIR . '/wp-tweaks.php';

/** Include the class that holds the exams */
require_once LT_INC_DIR . '/class-Exam.php';

/** Include the external plugins and extensions */
require_once LT_EXT_DIR . '/main.php';
