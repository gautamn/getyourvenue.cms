<?php
// @desc ajax file for change password
include_once facile::$path_classes . "users/users.php";
$vars= $_REQUEST['vars'][0];
$jsString = "";

if(!empty($vars['oldpassword']) && !empty($vars['password']) && !empty($vars['repassword']))
{
  $params['password'] = trim($vars['oldpassword']);
  $params['newpassword'] = trim($vars['password']);
  $params['user_id']  = intval($_SESSION['admin_user_id']);
	$res = users::changePassword($params);
  switch($res){
    case "1":
      $jsString = "ShowMessage(45,'success','','Y');";//change success
      break;
    case "2":
      $jsString = "ShowMessage(46,'error','','Y');";//mis-match
      break;
    default:
      $jsString = "ShowMessage(44,'error','','Y');";//try again
      break;
  }
}
echo $jsString;
?>