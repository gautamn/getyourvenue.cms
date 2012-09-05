<?php

include_once '../config/facile.php';

function update_db($update_history) {
  $msg = '';
  foreach ($update_history as $key => $value) {
    $value1 = mysql_escape_string($value);

    $query = "select update_key from log_db_history where update_key='$key'";
    $row = fDB::fetch_assoc_first($query);
    if (!$row) {
      $query = "insert into log_db_history (update_key,statement) values ('$key','$value1')";
      fDB::query($query);
      $msg .= "Updated: $value <br />
			";
      fDB::query($value);
    } else {
      $msg .= "Not updated: $row[update_key] <br />";
    }
  }
  echo "<br /><br /><br />" . $msg;
}

fDB::query("CREATE TABLE IF NOT EXISTS `log_db_history` (
  `update_key` varchar(255) NOT NULL,
  `statement` text NOT NULL,
  PRIMARY KEY (`update_key`)
) ENGINE=MyISAM;");

$update_history['create_admin_forgot_password_11111111'] = "CREATE TABLE IF NOT EXISTS `admin_forgot_password` (
  `user_id` int(12) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `enter_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM;";
$update_history['add_new_log_cms_activity_05092012'] = "CREATE TABLE IF NOT EXISTS `log_cms_activity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `page_url` text NOT NULL,
  `section` varchar(100) NOT NULL,
  `activity` varchar(200) DEFAULT NULL,
  `actity_date` datetime NOT NULL,
  `extra` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB";

$update_history['add_new_log_cms_login_histroy'] = "CREATE TABLE IF NOT EXISTS `log_cms_login_histroy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logged_on` datetime NOT NULL,
  `ip_address` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB";

update_db($update_history);