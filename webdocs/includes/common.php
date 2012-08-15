<?php
//inlclude core framework files..
$base_path = dirname(__FILE__) . '/../../';
require $base_path . 'config/facile.php';
facile::$GLOBALS['clip'] = null;
include_once facile::$path_includes . 'functions.php';
include_once facile::$path_includes . 'uiFunctions.php';
include_once facile::$path_classes . 'users/users.php';
if($_SESSION['requestedPage'] != 'home'){
  if(users::checkUrlAuthentication($_SESSION['admin_user_id'], $_SESSION['requestedPage'], $_GET)==false){
    $_SESSION['requestedPage'] = $requestedPage = 'home';
  }
}
facile::$Dynamaic_navigation = users::rightUserDetails($_SESSION['admin_user_id'], 1);
//echo $_SESSION['requestedPage']."<pre>".print_r(facile::$Dynamaic_navigation,1)."</pre>";
include facile::$path_controllers . 'callback.php';
include facile::$path_controllers . 'controller.php';
