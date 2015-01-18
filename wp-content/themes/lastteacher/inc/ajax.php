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
}

new LT_AJAX();