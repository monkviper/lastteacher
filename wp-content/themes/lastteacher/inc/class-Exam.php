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
	private $ID;
	/**
	 * The name of the exam to be used as the title
	 *
	 * @var string
	 */
	private $name;
	/**
	 * Total maximum for the marks. The percentage is calculated using this.
	 *
	 * @var int
	 */
	private $total_marks;
	/**
	 * The marks required for passing.
	 *
	 * @var int
	 */
	private $pass_marks;
	/**
	 * Total number of questions in this exam. Exam will be considered invalid without that many questions initialised.
	 *
	 * @var int
	 */
	private $total_questions;
	/**
	 * Marks awarded for every correct answer
	 *
	 * @var int
	 */
	private $correct_answer_marks;
	/**
	 * Negative marks that are taken away for every wrong answer
	 *
	 * @var int
	 */
	private $wrong_answer_marks;
	/**
	 * Weather this exam has already been attempted
	 *
	 * @var bool
	 */
	private $completed;
	/**
	 * If this exam has been completed, how many marks were achieved.
	 *
	 * @var int
	 */
	private $marks_achieved;
	/**
	 * The author who published this exam
	 *
	 * @var string
	 */
	private $author;
	/**
	 * The time at which exam was started
	 *
	 * @var int
	 */
	private $time_started;
	/**
	 * The time at which exam was ended
	 *
	 * @var int
	 */
	private $time_ended;
	/**
	 * The user who wrote this exam
	 *
	 * @var WP_User
	 */
	private $user;
	/**
	 * An array of all the questions for this exam
	 *
	 * @var array
	 */
	private $questions;

	function __get( $name ) {
		if( isset( $this->$name ) ) {
			return $this->$name;
		} else {
			return null;
		}
	}

	function __set( $name, $value ) {
		if( isset( $this->$name ) ) {
			$this->$name = $value;
		}
	}

	function __isset( $name ) {
		return isset( $this->$name );
	}

	function __unset( $name ) {
		$this->$name = null;
	}
}