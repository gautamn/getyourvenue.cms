<?php
// ajax file for logout
include_once facile::$path_classes . "users/users.php";
session_start();
users::unsetSession();
//$url = isset()$_COOKIE['initlogouturl'];
if(empty($url)){
  $url = facile::$web_url;
}
$href = $url;

header('Location: '.$href);
?>