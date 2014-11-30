<?php

class LAST_TEACHER {

	function __construct() {
		add_action( 'init', array( $this, 'post_type' ) );
	}

	function post_type() {
		$labels = array(
				'name'               => _x( 'Exams', 'Post Type General Name', 'lastteacher' ),
				'singular_name'      => _x( 'Exam', 'Post Type Singular Name', 'lastteacher' ),
				'menu_name'          => __( 'Exams', 'lastteacher' ),
				'parent_item_colon'  => __( 'Parent Exam:', 'lastteacher' ),
				'all_items'          => __( 'All Exams', 'lastteacher' ),
				'view_item'          => __( 'View Exam', 'lastteacher' ),
				'add_new_item'       => __( 'Add New Exam', 'lastteacher' ),
				'add_new'            => __( 'Add New', 'lastteacher' ),
				'edit_item'          => __( 'Edit Exam', 'lastteacher' ),
				'update_item'        => __( 'Update Exam', 'lastteacher' ),
				'search_items'       => __( 'Search Exam', 'lastteacher' ),
				'not_found'          => __( 'Not found', 'lastteacher' ),
				'not_found_in_trash' => __( 'Not found in Trash', 'lastteacher' ),
		);
		$args = array(
				'label'               => __( 'exam', 'lastteacher' ),
				'description'         => __( 'A post type to handle exams', 'lastteacher' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'author', 'custom-fields', ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
		);
		register_post_type( 'exam', $args );
	}
}

new LAST_TEACHER();