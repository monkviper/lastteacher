<?php

class LT_admin {

	private $cache = array();

	function __construct() {
		remove_action( 'acf/save_post', array( acf(), 'save_post' ), 10 );
		add_action( 'acf/save_post', array( $this, 'save_post' ), 10 );
		add_filter( 'acf/load_value', array( $this, 'load' ), 99, 3 );
	}

	function save_post( $post_id ) {
		if( !in_array( get_post_type( $post_id ), array( 'question', 'subject' ), true ) ) {
			return acf()->save_post( $post_id );
		}

		// loop through and save
		if( isset( $_POST['fields'] ) && !empty( $_POST['fields'] ) ) {
			$obj = $this->get_obj( $post_id );
			if( $obj ) {
				foreach( $_POST['fields'] as $k => $v ) {
					$f = apply_filters( 'acf/load_field', false, $k );

					if( 'question' === get_post_type( $post_id ) ) {
						switch( $f['name'] ) {
							case 'question_text':
								$obj->setQuestionText( $v );
								break;
							case 'options':
								unset( $v['acfcloneindex'] );
								$save = array();
								foreach( $v as $option ) {
									$save[] = reset( $option );
								}
								$obj->setOptions( $save );
								break;
							case 'answer':
								$obj->setAnswer( $v );
								break;
							case 'subject':
								$obj->setSubject( $this->get_obj( $v ) );
								break;
							case 'subcategory':
								$obj->setSubcategory( $v );
								break;
						}
					} elseif( 'subject' === get_post_type( $post_id ) ) {
						switch( $f['name'] ) {
							case 'name':
								$obj->setName( $v );
								break;
							case 'total_questions':
								$obj->setTotalQuestions( $v );
								break;
							case 'marks_per_question':
								$obj->setMarksPerQuestion( $v );
								break;
							case 'negative_marks':
								$obj->setNegativeMarks( $v );
								break;
							case 'cut_off':
								$obj->setCutOff( $v );
								break;
							case 'time_limit':
								$obj->setTimeLimit( $v );
								break;
						}
					}
				}

				$obj->save();
				update_post_meta( $post_id, '_saved_ext_id', $obj->id );
			}
		}

		return $post_id;
	}

	function load( $value, $post_id, $f ) {
		if( in_array( get_post_type( $post_id ), array( 'question', 'subject' ), true ) ) {
			$obj = $this->get_obj( $post_id );

			if( $obj && $obj->exists() ) {
				if( 'question' === get_post_type( $post_id ) ) {
					switch( $f['name'] ) {
						case 'question_text':
							$value = $obj->getQuestionText();
							break;
						case 'options':
							$value = $obj->getOptionsCount();
							break;
						case 'answer':
							$value = $obj->getAnswer();
							break;
						case 'subject':
							$posts = get_posts( array(
											'meta_key'   => '_saved_ext_id',
											'meta_value' => $obj->getSubject()->id,
											'post_type'  => 'subject',
											'fields'     => 'ids'
									)
							);
							$value = reset($posts);
							break;
						case 'subcategory':
							$value = $obj->getSubcategory();
							break;
					}

					if( 0 === strpos( $f['name'], 'options_' ) ) {
						$path = substr( $f['name'], 8 );
						$options = $obj->getOptions();
						$index = intval( $path );
						$value = $options[$index];
					}
				} elseif( 'subject' === get_post_type( $post_id ) ) {
					switch( $f['name'] ) {
						case 'name':
							$value = $obj->getName();
							break;
						case 'total_questions':
							$value = $obj->getTotalQuestions();
							break;
						case 'marks_per_question':
							$value = $obj->getMarksPerQuestion();
							break;
						case 'negative_marks':
							$value = $obj->getNegativeMarks();
							break;
						case 'cut_off':
							$value = $obj->getCutOff();
							break;
						case 'time_limit':
							$value = $obj->getTimeLimit();
							break;
					}
				}
			}
		}

		return $value;
	}

	/**
	 * @param $post_id
	 *
	 * @return LT_Question|LT_Subject
	 */
	function get_obj( $post_id ) {
		$post_type = get_post_type( $post_id );
		$post_id = get_post_meta( $post_id, '_saved_ext_id', true );
		if( !$post_id ) {
			if( 'question' === $post_type ) {
				return new LT_Question();
			} elseif( 'subject' === $post_type ) {
				return new LT_Subject();
			}
		} elseif( is_numeric( $post_id ) && !isset( $this->cache[$post_type][$post_id] ) ) {
			if( !isset( $this->cache[$post_type] ) ) {
				$this->cache[$post_type] = array();
			}

			if( 'question' === $post_type ) {
				$this->cache[$post_type][$post_id] = new LT_Question( $post_id );
			} elseif( 'subject' === $post_type ) {
				$this->cache[$post_type][$post_id] = new LT_Subject( $post_id );
			}
		}

		return isset( $this->cache[$post_type][$post_id] ) ? $this->cache[$post_type][$post_id] : null;
	}
}

new LT_admin();