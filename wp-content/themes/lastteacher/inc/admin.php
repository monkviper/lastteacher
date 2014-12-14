<?php

class LT_admin {

	private $cache = array();

	function __construct() {
		add_action( 'acf/input/admin_head', array( $this, 'acf_mocks_scripts' ) );
		remove_action( 'acf/save_post', array( acf(), 'save_post' ), 10 );
		add_action( 'acf/save_post', array( $this, 'save_post' ), 10 );
		add_filter( 'acf/load_value', array( $this, 'load' ), 99, 3 );
	}

	function acf_mocks_scripts() {
		global $wpdb;
		$arr = array();

		$query = new WP_Query( array(
				'post_type'     => 'subject',
				'fields'        => 'ids',
				'post_per_page' => -1
		) );
		$subjects = $query->posts;

		foreach( $subjects as $subject ) {
			$query = new WP_Query( array(
					'post_type'     => 'question',
					'fields'        => 'ids',
					'meta_key'      => '_saved_ext_id',
					'meta_value'    => $wpdb->get_col( "SELECT ID FROM {$wpdb->prefix}questions WHERE subject = " . get_post_meta( $subject, '_saved_ext_id', true ) ),
					'post_per_page' => -1
			) );

			$arr[$subject] = $query->posts;
		}
		?>
		<script type="text/javascript">
			(function() {
				var ids = <?php echo json_encode($arr); ?>;
				var $ = jQuery;

				$.fn.closest_descendent = function(filter) {
					var $found = $(),
							$currentSet = this; // Current place
					while($currentSet.length) {
						$found = $currentSet.filter(filter);
						if($found.length) break;  // At least one match: break loop
						// Get all children of the current set
						$currentSet = $currentSet.children();
					}
					return $found.first(); // Return first match of the collection
				};

				var process = function() {
					var val = $(this).find('select').val();
					if(!val)
						val = $(this).find('select option:not([disabled])').first().attr('value');

					var allowed = ids[val];

					var select = $(this).next().find('select');

					select.children().each(function() {
						if(-1 == $.inArray($(this).attr('value'), allowed))
							$(this).hide().prop('disabled', true);
						else
							$(this).show().prop('disabled', false);
					});

					val = select.val();

					if(!val)
						select.find('option:not([disabled])').first().attr("selected", "selected");
				};

				$(document).live('acf/setup_fields', function(e, div) {
					// div is the element with new html.
					// on first load, this is the $('#poststuff')
					// on adding a repeater row, this is the tr

					if(div.is('#poststuff')) {
						$(div).find('#acf-subjects').closest_descendent('table').find('tr.row').find('[data-field_name="subject"]').each(process).on('change', process);
					} else {
						process.call(div);
						div.on('change', process);
					}
				});
			})();
		</script>
	<?php
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
							$value = reset( $posts );
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