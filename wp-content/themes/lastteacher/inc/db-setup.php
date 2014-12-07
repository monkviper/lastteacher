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
