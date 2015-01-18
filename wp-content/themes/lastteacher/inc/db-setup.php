<?php

/** @var wpdb $wpdb */
global $wpdb;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$charset_collate = $wpdb->get_charset_collate();

$table_name = $wpdb->prefix . 'exam';

$wpdb->query("DROP TABLE IF EXISTS $table_name;");

$table_name = $wpdb->prefix . 'questions';

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  question varchar(512) NOT NULL,
  options text NOT NULL,
  answer int(1) NOT NULL,
  subject bigint(20) UNSIGNED NOT NULL,
  subcategory varchar(512) NOT NULL,
  PRIMARY KEY  (ID),
  KEY subject (subject)
) $charset_collate;";

dbDelta( $sql );

$table_name = $wpdb->prefix . 'subjects';

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(256) NOT NULL,
  total_questions int(5) UNSIGNED NOT NULL,
  marks_per_question decimal(5, 2) UNSIGNED NOT NULL,
  negative_marks decimal(5, 2) UNSIGNED NOT NULL,
  cut_off int(5) NOT NULL,
  time_limit int(5) NOT NULL,
  PRIMARY KEY  (ID)
) $charset_collate;";

dbDelta( $sql );

$table_name = $wpdb->prefix . 'mocks';

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(256) NOT NULL,
  total_questions int(5) UNSIGNED NOT NULL,
  marks_per_question decimal(5, 2) UNSIGNED NOT NULL,
  negative_marks decimal(5, 2) UNSIGNED NOT NULL,
  cut_off int(5) NOT NULL,
  time_limit int(5) NOT NULL,
  subjects_questions text NOT NULL,
  PRIMARY KEY  (ID)
) $charset_collate;";

dbDelta( $sql );

$table_name = $wpdb->prefix . 'exams_records';

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  mock bigint(20) UNSIGNED NOT NULL,
  user bigint(20) UNSIGNED NOT NULL,
  started_at DATETIME NOT NULL,
  last_checkpoint_at DATETIME NOT NULL,
  total_time_lapsed int(5) NOT NULL,
  subjectwise_time_lapsed text NOT NULL,
  questions text NOT NULL,
  completed tinyint(1) NOT NULL,
  PRIMARY KEY  (ID)
  KEY mock_user (mock, user)
  KEY mock_user_completed (mock, user, completed)
) $charset_collate;";
// questions is a serialized array of question id, answer, time taken on question, a flag if marked for review
//@todo add columns for the calculated results data

dbDelta( $sql );

$table_name = $wpdb->prefix . 'exams_requests_logs';

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  record_id bigint(20) UNSIGNED NOT NULL,
  mock bigint(20) UNSIGNED NOT NULL,
  user bigint(20) UNSIGNED NOT NULL,
  received_at DATETIME NOT NULL,
  from_ip VARBINARY(16) NOT NULL,
  data text NOT NULL,
  PRIMARY KEY  (ID)
  KEY exam_record (record_id)
  KEY mock_user (mock, user)
) $charset_collate;";

dbDelta( $sql );
