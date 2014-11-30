<?php

/**
 * A model class for each exam
 *
 * Class LT_Exam
 */
class LT_Exam {

	/**
	 * A unique ID to serve as the primary key
	 *
	 * @var int
	 */
	public $ID;
	/**
	 * The name of the exam to be used as the title
	 *
	 * @var string
	 */
	public $name;
	/**
	 * Total maximum for the marks. The percentage is calculated using this.
	 *
	 * @var int
	 */
	public $total_marks;
	/**
	 * The marks required for passing.
	 *
	 * @var int
	 */
	public $pass_marks;
	/**
	 * Total number of questions in this exam. Exam will be considered invalid without that many questions initialised.
	 *
	 * @var int
	 */
	public $total_questions;
	/**
	 * Marks awarded for every correct answer
	 *
	 * @var int
	 */
	public $correct_answer_marks;
	/**
	 * Negative marks that are taken away for every wrong answer
	 *
	 * @var int
	 */
	public $wrong_answer_marks;
	/**
	 * The author who published this exam
	 *
	 * @var string
	 */
	public $author;
	/**
	 * An array of all the questions for this exam
	 *
	 * @var array
	 */
	public $questions;

	function __construct( $ID = null ) {
		if( $ID ) {
			$this->loadById( $ID );
		}

		$this->ID = $ID;
	}

	function reset() {
		$this->ID = null;
		$this->name = '';
		$this->total_questions = 0;
		$this->total_marks = 0;
		$this->pass_marks = 0;
		$this->correct_answer_marks = 0;
		$this->wrong_answer_marks = 0;
		$this->author = null;
		$this->questions = array();
	}

	function loadById( $id ) {
		$this->reset();

		/** @var WPDB $wpdb */
		global $wpdb;

		$tablename = $wpdb->prefix . "exam";

		$row = $wpdb->get_row( "SELECT * FROM $tablename WHERE ID = $id" );

		if( is_object( $row ) ) {
			$this->ID = $row->ID;
			$this->name = $row->name;
			$this->total_questions = $row->total_questions;
			$this->pass_marks = $row->pass_marks;
			$this->correct_answer_marks = $row->correct_answer_marks;
			$this->wrong_answer_marks = $row->wrong_answer_marks;
			$this->total_marks = $this->total_questions * $this->correct_answer_marks;
		}
	}

	function save() {
		if( $this->ID ) { // existing record
			/** @var WPDB $wpdb */
			global $wpdb;

			$tablename = $wpdb->prefix . "exam";
			$newdata = array(
					'name'                 => $this->name,
					'total_questions'      => $this->total_questions,
					'pass_marks'           => $this->pass_marks,
					'correct_answer_marks' => $this->correct_answer_marks,
					'wrong_answer_marks'   => $this->wrong_answer_marks,
			);
			$format = array( '%s', '%d', '%d', '%d', '%d' );
			$where = array( 'ID' => $this->ID );
			$where_format = array( '%d' );

			$exist = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename WHERE ID = {$this->ID}" );

			if( $exist ) {
				return $wpdb->update( $tablename, $newdata, $where, $format, $where_format );
			} else {
				$newdata['ID'] = $this->ID;
				return $wpdb->insert( $tablename, $newdata, $format );
			}
		} else { // new record
			// Currently we are using the post id to save exams so if the id is not present we can't save it
		}
	}
}