<?php

class LT_AJAX {

	function __construct() {
		$actions = array();
		foreach( $actions as $action ) {
			add_action( 'wp_ajax_' . $action, array( $this, 'handle_ajax' ) );
		}
	}

	function handle_ajax() {
		if( !check_ajax_referer( '_ajax' ) ) {
			$result = array( 'error' => 1, 'message' => 'invalid session', 'redirect' => home_url( '/' ) );
		}

		$params = $_POST;
		$action = $params['action'];
		$result = $this->$action( $params );

		echo json_encode( $result );
		die();
	}

	function register_new_mock( $params ) {
		$mock_id = intval( $params['mock'] );
		$mock = new LT_Mock( $mock_id );
		if( !$mock_id || $mock_id != $mock->id ) {
			return array( 'error' => 1, 'message' => 'Invalid Mock ID', 'redirect' => home_url( '/' ) );
		}

		$user_id = get_current_user_id();
		if( !$user_id ) {
			return array( 'error' => 1, 'message' => 'Invalid User', 'redirect' => home_url( '/' ) );
		}

		//@todo check if the current user has permissions to access this mock
		if( false ) {
			return array( 'error' => 1, 'message' => 'You haven\'t purchased this exam.', 'redirect' => home_url( '/' ) );
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'exams_records';

		$existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE mock = $mock_id AND user = $user_id" );
		if($existing) {
			return array( 'error' => 0, 'message' => 'This Exam is already running in another window', 'status' => 'unavailable' );
		}

		// If we reached here, we can successfully start this exam
		//@todo write the code to start the exam, create it's record and notify js to start it
	}
}

new LT_AJAX();