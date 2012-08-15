<?php
// ajax file for reset password
include_once facile::$path_classes . "users/users.php";
$vars= $_REQUEST['vars'][0];
$jsString = "";
if(!empty($vars['password']) && !empty($vars['repassword']))
{
	$token=trim($vars['tokenPassword']);
  $params['password']=trim($vars['password']);
  $params['token'] = $token;
	if(!empty($token)) {
		if(users::resetToken($params)) {
      $jsString = "ShowMessage(41,'success','','Y');";
    }
		else
      $jsString = "ShowMessage(40,'error','','Y');";
	}
	//$jsString .= "lightModal.close();";
}
echo $jsString;
?>