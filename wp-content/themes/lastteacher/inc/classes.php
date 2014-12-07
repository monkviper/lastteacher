<?php

abstract class LT_MODEL {

	protected $_table;
	public $id;

	function __construct( $id = null ) {
		if( $id ) {
			$this->id = $id;
			$this->load();
		}
	}

	function exists() {
		return isset( $this->id ) ? boolval( intval( $this->id ) ) : false;
	}

	function load() {
		if( $this->id ) {
			global $wpdb;

			$row = $wpdb->get_row( "SELECT * FROM {$this->_table} WHERE ID = {$this->id}", ARRAY_A );

			if( $row ) {
				$this->_populate( $row );
			}
		}
	}

	protected function _populate( $row ) {
		foreach( $row as $key => $value ) {
			$this->$key = $value;
		}
	}

	abstract protected function _getData();

	function save() {
		/** @var wpdb $wpdb */
		global $wpdb;

		if( $this->exists() ) {
			$wpdb->update( $this->_table, $this->_getData(), array( 'ID' => $this->id ) );
		} else {
			$wpdb->insert( $this->_table, $this->_getData() );
			$this->id = $wpdb->insert_id;
		}
	}
}

class LT_Question extends LT_MODEL {

	public $question_text;
	public $options;
	public $answer;
	public $subject;
	public $subcategory;

	function __construct( $id = null ) {
		global $wpdb;

		$this->_table = $wpdb->prefix . 'questions';
		parent::__construct( $id );
	}

	/**
	 * @param string $answer
	 */
	public function setAnswer( $answer ) {
		$this->answer = $answer;
	}

	/**
	 * @return string
	 */
	public function getAnswer() {
		return $this->answer;
	}

	/**
	 * @param array $options
	 */
	public function setOptions( $options ) {
		$this->options = array_filter( array_map( 'trim', (array) $options ) );
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @return array
	 */
	public function getOptionsCount() {
		return is_array( $this->options ) ? count( $this->options ) : 0;
	}

	/**
	 * @param string $question_text
	 */
	public function setQuestionText( $question_text ) {
		$this->question_text = $question_text;
	}

	/**
	 * @return string
	 */
	public function getQuestionText() {
		return $this->question_text;
	}

	/**
	 * @param string $subcategory
	 */
	public function setSubcategory( $subcategory ) {
		$this->subcategory = $subcategory;
	}

	/**
	 * @return string
	 */
	public function getSubcategory() {
		return $this->subcategory;
	}

	/**
	 * @param int|LT_Subject $subject
	 */
	public function setSubject( $subject ) {
		if( !( $subject instanceof LT_Subject ) ) {
			$subject = new LT_Subject( $subject );
		}
		$this->subject = $subject;
	}

	/**
	 * @return LT_Subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	protected function _populate( $row ) {
		foreach( $row as $key => $value ) {
			switch( $key ) {
				case 'question' :
					$this->setQuestionText( $value );
					break;
				case 'options' :
					$this->setOptions( maybe_unserialize( $value ) );
					break;
				case 'subject' :
					$this->setSubject( $value );
					break;
				case 'subcategory' :
					$this->setSubcategory( $value );
					break;
			}
		}

		// now that options are there, we can check the index and accordingly set the answer
		$this->setAnswer( $this->options[intval( $row['answer'] )] );
	}

	protected function _getData() {
		$answer = 0;
		$d = PHP_INT_MAX;
		foreach( $this->options as $i => $option ) {
			$l = levenshtein( $option, $this->answer );
			if( $l < $d ) {
				$answer = $i;
				$d = $l;
			}
		}

		return array(
				'question'    => $this->question_text,
				'options'     => maybe_serialize( $this->options ),
				'answer'      => $answer,
				'subject'     => $this->getSubject()->id,
				'subcategory' => $this->subcategory
		);
	}
}

class LT_Subject extends LT_MODEL {

	public $name;
	public $total_questions;
	public $marks_per_question;
	public $negative_marks;
	public $cut_off;
	public $time_limit;

	function __construct( $id = null ) {
		global $wpdb;

		$this->_table = $wpdb->prefix . 'subjects';
		parent::__construct( $id );
	}

	/**
	 * @param int $cut_off
	 */
	public function setCutOff( $cut_off ) {
		$this->cut_off = absint( $cut_off );
	}

	/**
	 * @return int
	 */
	public function getCutOff() {
		return $this->cut_off;
	}

	/**
	 * @param float $marks_per_question
	 */
	public function setMarksPerQuestion( $marks_per_question ) {
		if( intval( $marks_per_question ) == floatval( $marks_per_question ) ) {
			$marks_per_question = intval( $marks_per_question );
		} else {
			$marks_per_question = floatval( $marks_per_question );
		}

		$this->marks_per_question = abs( $marks_per_question );
	}

	/**
	 * @return float
	 */
	public function getMarksPerQuestion() {
		return $this->marks_per_question;
	}

	/**
	 * @param string $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param float $negative_marks
	 */
	public function setNegativeMarks( $negative_marks ) {
		$this->negative_marks = absint( $negative_marks );
	}

	/**
	 * @return float
	 */
	public function getNegativeMarks() {
		return $this->negative_marks;
	}

	/**
	 * @param int $time_limit
	 */
	public function setTimeLimit( $time_limit ) {
		$this->time_limit = absint( $time_limit );
	}

	/**
	 * @return int
	 */
	public function getTimeLimit() {
		return $this->time_limit;
	}

	/**
	 * @param int $total_questions
	 */
	public function setTotalQuestions( $total_questions ) {
		$this->total_questions = absint( $total_questions );
	}

	/**
	 * @return int
	 */
	public function getTotalQuestions() {
		return $this->total_questions;
	}

	protected function _populate( $row ) {
		foreach( $row as $key => $value ) {
			switch( $key ) {
				case 'name' :
					$this->setName( $value );
					break;
				case 'total_questions' :
					$this->setTotalQuestions( $value );
					break;
				case 'marks_per_question' :
					$this->setMarksPerQuestion( $value );
					break;
				case 'negative_marks' :
					$this->setNegativeMarks( $value );
					break;
				case 'cut_off' :
					$this->setCutOff( $value );
					break;
				case 'time_limit' :
					$this->setTimeLimit( $value );
					break;
			}
		}
	}

	protected function _getData() {
		return array(
				'name'               => $this->name,
				'total_questions'    => $this->total_questions,
				'marks_per_question' => $this->marks_per_question,
				'negative_marks'     => $this->negative_marks,
				'cut_off'            => $this->cut_off,
				'time_limit'         => $this->time_limit
		);
	}
}

class LT_Mock extends LT_Subject {

	function __construct( $id = null ) {
		global $wpdb;

		$this->_table = $wpdb->prefix . 'mocks';
		parent::__construct( $id );
	}
}
