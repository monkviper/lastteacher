<?php

class LT_admin {

	private $cache = array();

	function __construct() {
		remove_action( 'acf/save_post', array( acf(), 'save_post' ), 10 );
		add_action( 'acf/save_post', array( $this, 'save_post' ), 10 );
		add_filter( 'acf/load_value', array( $this, 'load' ), 99, 3 );
	}

	function save_post( $post_id ) {
		if( 'exam' !== get_post_type( $post_id ) ) {
			acf()->save_post( $post_id );
		}

		// load from post
		if( !isset( $_POST['fields'] ) ) {
			return $post_id;
		}

		// loop through and save
		if( !empty( $_POST['fields'] ) ) {
			$exam = $this->get_exam( $post_id );

			if( $exam ) {
				foreach( $_POST['fields'] as $k => $v ) {
					$f = apply_filters( 'acf/load_field', false, $k );

					switch( $f['name'] ) {
						case 'exam_name':
							$exam->name = $v;
							break;
						case 'total_questions':
							$exam->total_questions = $v;
							break;
						case 'correct_answer_marks':
							$exam->correct_answer_marks = $v;
							break;
						case 'wrong_answer_marks':
							$exam->wrong_answer_marks = $v;
							break;
						case 'passing_marks':
							$exam->pass_marks = $v;
							break;
						case 'questions':
							$exam->questions = array();
							unset( $v['acfcloneindex'] );
							foreach( $v as $row ) {
								$ret = array();
								foreach( $f['sub_fields'] as $sub_field ) {
									$value = isset( $row[$sub_field['key']] ) ? $row[$sub_field['key']] : false;
									if( 'options' === $sub_field['name'] ) {
										$sret = array();
										unset( $value['acfcloneindex'] );
										foreach( $value as $srow ) {
											foreach( $sub_field['sub_fields'] as $ssub_field ) {
												$svalue = isset( $srow[$ssub_field['key']] ) ? $srow[$ssub_field['key']] : false;
												$sret[] = $svalue;
											}
										}
										$value = $sret;
									}
									$ret[$sub_field['name']] = $value;
								}
								$exam->questions[] = $ret;
							}
							break;
					}
				}
			}

			$exam->save();
		}

		return $post_id;
	}

	function load( $value, $post_id, $field ) {
		$exam = $this->get_exam( $post_id );

		if( $exam ) {
			switch( $field['name'] ) {
				case 'exam_name':
					$value = $exam->name;
					break;
				case 'total_questions':
					$value = $exam->total_questions;
					break;
				case 'correct_answer_marks':
					$value = $exam->correct_answer_marks;
					break;
				case 'wrong_answer_marks':
					$value = $exam->wrong_answer_marks;
					break;
				case 'passing_marks':
					$value = $exam->pass_marks;
					break;
				case 'questions':
					$value = count($exam->questions);
					break;
			}

			if(0 === strpos($field['name'], 'questions_')) {
				$path = explode('_', $field['name']);
				if(5 === count($path)) {
					array_pop($path);
				}
				array_shift($path);
				$save = null;
				foreach($path as $index) {
					if(is_null($save)) {
						$save = $exam->questions[$index];
					} else {
						$save = isset( $save[$index] ) ? $save[$index] : $save;
					}
				}

				if( 'repeater' === $field['type'] ) {
					$save = count( $save );
				}

				$value = $save;
			}
		}

		return $value;
	}

	/**
	 * @param $post_id
	 *
	 * @return LT_Exam
	 */
	function get_exam( $post_id ) {
		if( is_numeric( $post_id ) && !isset( $this->cache[$post_id] ) ) {
			$this->cache[$post_id] = new LT_Exam( $post_id );
		}

		return isset( $this->cache[$post_id] ) ? $this->cache[$post_id] : null;
	}
}

new LT_admin();