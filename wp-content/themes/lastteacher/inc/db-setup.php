<?php

global $wpdb;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$charset_collate = $wpdb->get_charset_collate();

$table_name = $wpdb->prefix . "questions";

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  question varchar(512) NOT NULL,
  options text NOT NULL,
  answer varchar(512) NOT NULL,
  PRIMARY KEY  (ID)
) $charset_collate;";

dbDelta( $sql );

$table_name = $wpdb->prefix . "exam";

$sql = "CREATE TABLE $table_name (
  ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(256) NOT NULL,
  total_questions int(5) UNSIGNED NOT NULL,
  correct_answer_marks int(5) UNSIGNED NOT NULL,
  wrong_answer_marks int(5) UNSIGNED NOT NULL,
  pass_marks int(5) UNSIGNED NOT NULL,
  questions text NOT NULL,
  PRIMARY KEY  (ID)
) $charset_collate;";

dbDelta( $sql );
