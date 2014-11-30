<?php

if( function_exists( "register_field_group" ) ) {
	register_field_group( array(
					'id'         => 'acf_questions',
					'title'      => 'Questions',
					'fields'     => array(
							array(
									'key'          => 'field_547b3b3e73dd6',
									'label'        => 'Question',
									'name'         => 'question',
									'type'         => 'repeater',
									'sub_fields'   => array(
											array(
													'key'           => 'field_547b3b8373dd7',
													'label'         => 'Question',
													'name'          => 'question',
													'type'          => 'textarea',
													'required'      => 1,
													'column_width'  => '',
													'default_value' => '',
													'placeholder'   => '',
													'maxlength'     => '',
													'rows'          => '',
													'formatting'    => 'none',
											),
											array(
													'key'          => 'field_547b3bcd73dd8',
													'label'        => 'Options',
													'name'         => 'options',
													'type'         => 'repeater',
													'column_width' => '',
													'sub_fields'   => array(
															array(
																	'key'           => 'field_547b3bed73dd9',
																	'label'         => 'Option',
																	'name'          => 'option',
																	'type'          => 'text',
																	'column_width'  => '',
																	'default_value' => '',
																	'placeholder'   => '',
																	'prepend'       => '',
																	'append'        => '',
																	'formatting'    => 'none',
																	'maxlength'     => '',
															),
													),
													'row_min'      => 2,
													'row_limit'    => 5,
													'layout'       => 'table',
													'button_label' => 'Add Option',
											),
											array(
													'key'           => 'field_547b3c3873dda',
													'label'         => 'Answer',
													'name'          => 'answer',
													'type'          => 'text',
													'column_width'  => '',
													'default_value' => '',
													'placeholder'   => '',
													'prepend'       => '',
													'append'        => '',
													'formatting'    => 'none',
													'maxlength'     => '',
											),
									),
									'row_min'      => '',
									'row_limit'    => '',
									'layout'       => 'table',
									'button_label' => 'Add Question',
							),
					),
					'location'   => array(
							array(
									array(
											'param'    => 'post_type',
											'operator' => '==',
											'value'    => 'exam',
											'order_no' => 0,
											'group_no' => 0,
									),
							),
					),
					'options'    => array(
							'position'       => 'normal',
							'layout'         => 'no_box',
							'hide_on_screen' => array(),
					),
					'menu_order' => 0,
			)
	);
}
