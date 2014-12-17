<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
					'id' => 'acf_display-settings',
					'title' => 'Display Settings',
					'fields' => array (
							array (
									'key' => 'field_548465031bd13',
									'label' => 'Name',
									'name' => 'name',
									'type' => 'text',
									'instructions' => 'A name suitable to display on the frontend.',
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'formatting' => 'none',
									'maxlength' => '',
							),
					),
					'location' => array (
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'subject',
											'order_no' => 0,
											'group_no' => 0,
									),
							),
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'mock',
											'order_no' => 0,
											'group_no' => 1,
									),
							),
					),
					'options' => array (
							'position' => 'side',
							'layout' => 'default',
							'hide_on_screen' => array (
							),
					),
					'menu_order' => 0,
			));
	register_field_group(array (
					'id' => 'acf_exams',
					'title' => 'Exams',
					'fields' => array (
							array (
									'key' => 'field_548e2e7ad05d1',
									'label' => 'Cost',
									'name' => 'cost',
									'type' => 'number',
									'instructions' => 'Enter the amount of money we charge for this course.',
									'default_value' => '',
									'placeholder' => '',
									'prepend' => 'Rs.',
									'append' => '/-',
									'min' => 1,
									'max' => '',
									'step' => '0.01',
							),
							array (
									'key' => 'field_548e2f12d05d2',
									'label' => 'Validity',
									'name' => 'validity',
									'type' => 'number',
									'instructions' => 'Time before the purchased course expires.',
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => 'days',
									'min' => 1,
									'max' => '',
									'step' => 1,
							),
							array (
									'key' => 'field_548e2f6ad05d3',
									'label' => 'Exam Date',
									'name' => 'exam_date',
									'type' => 'date_picker',
									'instructions' => 'Enter the date of the exam.',
									'date_format' => 'yyyy-mm-dd',
									'display_format' => 'dd/mm/yy',
									'first_day' => 1,
							),
							array (
									'key' => 'field_548e2e1bd05cf',
									'label' => 'Mocks',
									'name' => 'mocks',
									'type' => 'repeater',
									'instructions' => 'Select the mocks related to this exam (selecting the same mock multiple times will give users ability to attempt that mock again)',
									'required' => 1,
									'sub_fields' => array (
											array (
													'key' => 'field_548e2e31d05d0',
													'label' => 'Mock',
													'name' => 'mock',
													'type' => 'post_object',
													'instructions' => 'Select the mock here',
													'required' => 1,
													'column_width' => '',
													'post_type' => array (
															0 => 'mock',
													),
													'taxonomy' => array (
															0 => 'all',
													),
													'allow_null' => 0,
													'multiple' => 0,
											),
									),
									'row_min' => '',
									'row_limit' => '',
									'layout' => 'table',
									'button_label' => 'Add Row',
							),
					),
					'location' => array (
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'exam',
											'order_no' => 0,
											'group_no' => 0,
									),
							),
					),
					'options' => array (
							'position' => 'normal',
							'layout' => 'no_box',
							'hide_on_screen' => array (
							),
					),
					'menu_order' => 0,
			));
	register_field_group(array (
					'id' => 'acf_mocks',
					'title' => 'Mocks',
					'fields' => array (
							array (
									'key' => 'field_5484e2173d488',
									'label' => 'Subjects',
									'name' => 'subjects',
									'type' => 'repeater',
									'instructions' => 'Add subjects here',
									'required' => 1,
									'sub_fields' => array (
											array (
													'key' => 'field_5484e2c83d489',
													'label' => 'Subject',
													'name' => 'subject',
													'type' => 'post_object',
													'instructions' => 'choose a subject from the list',
													'required' => 1,
													'column_width' => '',
													'post_type' => array (
															0 => 'subject',
													),
													'taxonomy' => array (
															0 => 'all',
													),
													'allow_null' => 0,
													'multiple' => 0,
											),
											array (
													'key' => 'field_5484e3433d48a',
													'label' => 'Questions',
													'name' => 'questions',
													'type' => 'repeater',
													'instructions' => 'Choose your questions here',
													'required' => 1,
													'column_width' => '',
													'sub_fields' => array (
															array (
																	'key' => 'field_5484e3c33d48b',
																	'label' => 'Question',
																	'name' => 'question',
																	'type' => 'post_object',
																	'column_width' => '',
																	'post_type' => array (
																			0 => 'question',
																	),
																	'taxonomy' => array (
																			0 => 'all',
																	),
																	'allow_null' => 0,
																	'multiple' => 0,
															),
													),
													'row_min' => 1,
													'row_limit' => '',
													'layout' => 'row',
													'button_label' => 'Add Question',
											),
									),
									'row_min' => 1,
									'row_limit' => '',
									'layout' => 'row',
									'button_label' => 'Add Subject',
							),
					),
					'location' => array (
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'mock',
											'order_no' => 0,
											'group_no' => 0,
									),
							),
					),
					'options' => array (
							'position' => 'normal',
							'layout' => 'no_box',
							'hide_on_screen' => array (
							),
					),
					'menu_order' => 0,
			));
	register_field_group(array (
					'id' => 'acf_details',
					'title' => 'Details',
					'fields' => array (
							array (
									'key' => 'field_548466ac3ee25',
									'label' => 'Question Text',
									'name' => 'question_text',
									'type' => 'textarea',
									'instructions' => 'This is shown as the question exactly to the user. (HTML IS ALLOWED)',
									'required' => 1,
									'default_value' => '',
									'placeholder' => '',
									'maxlength' => 500,
									'rows' => '',
									'formatting' => 'html',
							),
							array (
									'key' => 'field_548467083ee26',
									'label' => 'Options',
									'name' => 'options',
									'type' => 'repeater',
									'instructions' => 'These are the options provided to the students for selection, html is allowed. (can be anywhere from 2 to 5)',
									'required' => 1,
									'sub_fields' => array (
											array (
													'key' => 'field_548467483ee27',
													'label' => 'Option',
													'name' => 'option',
													'type' => 'text',
													'required' => 1,
													'column_width' => '',
													'default_value' => '',
													'placeholder' => '',
													'prepend' => '',
													'append' => '',
													'formatting' => 'html',
													'maxlength' => '',
											),
									),
									'row_min' => 2,
									'row_limit' => 5,
									'layout' => 'row',
									'button_label' => 'Add Option',
							),
							array (
									'key' => 'field_548467bb3ee28',
									'label' => 'Answer',
									'name' => 'answer',
									'type' => 'text',
									'instructions' => 'This is the full text for the answer. It should closely match one of the options.',
									'required' => 1,
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'formatting' => 'html',
									'maxlength' => '',
							),
							array (
									'key' => 'field_548468113ee29',
									'label' => 'Subject',
									'name' => 'subject',
									'type' => 'post_object',
									'instructions' => 'Choose one of the subject names here to which this question belongs. It can belong to more than one subject. If you don\'t select a subject this question will not be available to choose.',
									'required' => 1,
									'post_type' => array (
											0 => 'subject',
									),
									'taxonomy' => array (
											0 => 'all',
									),
									'allow_null' => 1,
									'multiple' => 0,
							),
							array (
									'key' => 'field_5484689d3ee2a',
									'label' => 'Subcategory',
									'name' => 'subcategory',
									'type' => 'text',
									'instructions' => 'Not sure what this is used for.',
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'formatting' => 'none',
									'maxlength' => 500,
							),
					),
					'location' => array (
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'question',
											'order_no' => 0,
											'group_no' => 0,
									),
							),
					),
					'options' => array (
							'position' => 'normal',
							'layout' => 'default',
							'hide_on_screen' => array (
							),
					),
					'menu_order' => 5,
			));
	register_field_group(array (
					'id' => 'acf_question-contents',
					'title' => 'Question Contents',
					'fields' => array (
							array (
									'key' => 'field_548463897dc55',
									'label' => 'Total Questions',
									'name' => 'total_questions',
									'type' => 'number',
									'instructions' => 'Write the number of total questions here.',
									'required' => 1,
									'default_value' => '',
									'placeholder' => 0,
									'prepend' => '',
									'append' => '',
									'min' => 1,
									'max' => '',
									'step' => 1,
							),
							array (
									'key' => 'field_548463ed7dc56',
									'label' => 'Marks per Question',
									'name' => 'marks_per_question',
									'type' => 'number',
									'instructions' => 'Marks awarded to the student per correct answer.',
									'required' => 1,
									'default_value' => '',
									'placeholder' => 1,
									'prepend' => '',
									'append' => '',
									'min' => 0,
									'max' => 100,
									'step' => 1,
							),
							array (
									'key' => 'field_5484642f7dc57',
									'label' => 'Negative Marks',
									'name' => 'negative_marks',
									'type' => 'number',
									'instructions' => 'Marks deducted from total for wrong answer. (write 0 if there is not negative marking)',
									'required' => 1,
									'default_value' => '',
									'placeholder' => 1,
									'prepend' => '-',
									'append' => '',
									'min' => 0,
									'max' => '',
									'step' => '',
							),
							array (
									'key' => 'field_548464717dc58',
									'label' => 'Cut Off',
									'name' => 'cut_off',
									'type' => 'number',
									'instructions' => 'Marks needed to show the status as pass to the user.',
									'required' => 1,
									'default_value' => '',
									'placeholder' => 40,
									'prepend' => '',
									'append' => '',
									'min' => 0,
									'max' => '',
									'step' => '',
							),
							array (
									'key' => 'field_5484b190299ee',
									'label' => 'Time Limit',
									'name' => 'time_limit',
									'type' => 'number',
									'instructions' => 'Time Limit in minutes. Set to 0 if there is no time limit.',
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => 'minutes',
									'min' => 0,
									'max' => '',
									'step' => 1,
							),
					),
					'location' => array (
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'subject',
											'order_no' => 0,
											'group_no' => 0,
									),
							),
							array (
									array (
											'param' => 'post_type',
											'operator' => '==',
											'value' => 'mock',
											'order_no' => 0,
											'group_no' => 1,
									),
							),
					),
					'options' => array (
							'position' => 'side',
							'layout' => 'default',
							'hide_on_screen' => array (
							),
					),
					'menu_order' => 5,
			));
}
