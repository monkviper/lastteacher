<?php

/** Remove support for comments */
add_action( 'init', create_function( '', 'remove_post_type_support( \'post\', \'comments\' );remove_post_type_support( \'page\', \'comments\' );' ) );

/** Remove Generator Tag */
add_filter( 'the_generator', '__return_empty_string' );

/** Don't check if theme was switched, since we will never switch the theme */
remove_action( 'init', 'check_theme_switched', 99 );

/** Remove the widgets initialization hook as this theme doesn't support widgets */
remove_action('init', 'wp_widgets_init', 1);
