<?php

class LT_AJAX {

	function __construct() {
		$actions = array( 'register_new_mock' );
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

		$existing = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE completed = 0 AND mock <> $mock_id AND user = $user_id" );
		if( $existing ) {
			return array( 'error' => 0, 'message' => 'You already have a different exam running. You can only do one exam at a time.', 'status' => 'unavailable' );
		}

		$existing = $wpdb->get_var( "SELECT completed FROM $table_name WHERE mock = $mock_id AND user = $user_id" );
		if( !is_null( $existing ) ) {
			if( 0 == $existing ) {
				return array( 'error' => 0, 'message' => 'This Exam is already running in another window', 'status' => 'unavailable' );
			} else {
				return array( 'error' => 0, 'message' => 'This Exam is already finished by you.', 'status' => 'unavailable' );
			}
		}

		// If we reached here, we can successfully start this exam
		//@todo write the code to start the exam, create it's record and notify js to start it
		$subjects_questions = $mock->getSubjectsQuestions();
		$all_questions = array();
		foreach( $subjects_questions as $subject_id => $questions ) {
			$subject = new LT_Subject( $subject_id );
			$all_questions[] = array(
					'id'         => $subject_id,
					'name'       => $subject->getName() ? $subject->getName() : get_the_title( $subject->getWPId() ),
					'time_limit' => $subject->getTimeLimit() ? $subject->getTimeLimit() : $mock->getTimeLimit(),
					'questions'  => array()
			);
			foreach( $questions as $question_id ) {
				$question = new LT_Question( $question_id );
				$all_questions[$subject_id]['questions'][] = array(
						'id'       => $question_id,
						'question' => $question->getQuestionText(),
						'answer'   => $question->getAnswer(),
						'options'  => $question->getOptions(),
						'time'     => 0
				);
			}
		}

		$wpdb->insert( $table_name,
				array(
						'mock'                    => $mock_id,
						'user'                    => $user_id,
						'started_at'              => current_time( 'mysql', true ),
						'last_checkpoint_at'      => current_time( 'mysql', true ),
						'total_time_lapsed'       => 0,
						'subjectwise_time_lapsed' => maybe_serialize( array_fill_keys( array_keys( $subjects_questions ), 0 ) ),
						'questions'               => maybe_serialize( $all_questions ),
						'completed'               => 0
				)
		);

		return array(
				'error'      => 0,
				'status'     => 'available',
				'mock'       => $mock_id,
				'user'       => $user_id,
				'name'       => $mock->getName() ? $mock->getName() : get_the_title( $mock->getWPId() ),
				'time_limit' => $mock->getTimeLimit(),
				'questions'  => $all_questions
		);
	}
}

new LT_AJAX();