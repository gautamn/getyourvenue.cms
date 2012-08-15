<?php
// ajax file for user login
include_once facile::$path_classes . "users/users.php";
$vars= $_REQUEST['vars'][0];
$rest = users::processLogin($vars);
if(!empty($rest)){
		//setting into session
		users::setSession($rest);
    //updating last login
    users::updateLastLogin($rest['id']);
		//HTML changes
    $userobj = changeHtml();
    echo $jsString="changeHtml('$userobj');";
}
else
{
	echo $jsString = "ShowMessage(37,'error','','Y')";
}

function changeHtml(){
    $user_img = "";//getUserPictures($_SESSION['admin_user_id'], 'small');
    $userobj =  json_encode(array('user_id'=>$_SESSION['admin_user_id'],'username'=>$_SESSION['admin_user_name'],"name"=>$_SESSION['admin_name'],'landing_url'=>$_SESSION['admin_landing_url']));//,"user_img"=>$user_img));
    return $userobj;
}
?>