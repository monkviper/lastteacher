<?php

if(LT_ENVIRONMENT_DEV !== LT_ENVIRONMENT)
	define( 'ACF_LITE' , true );

// Require ACF extension
require_once LT_EXT_DIR . '/advanced-custom-fields/acf.php';
require_once LT_EXT_DIR . '/acf-options-page/acf-options-page.php';
require_once LT_EXT_DIR . '/acf-flexible-content/acf-flexible-content.php';
require_once LT_EXT_DIR . '/acf-repeater/acf-repeater.php';
require_once LT_EXT_DIR . '/acf-wordpress-wysiwyg-field-master/acf-wp_wysiwyg.php';

