<?php
include_once facile::$path_utilities . "mail/mail.php";
include_once facile::$path_classes . "users/users.php";

$vars = isset($_REQUEST['vars'][0])  ? $_REQUEST['vars'][0] : array('');
$jsString = "";
if(!empty($vars['useremail'])){
  $params = array();
  $params['useremail'] = $vars['useremail'];
  $params['token']= users::getToken();
  $userRow = users::forgotPassword($params);
  if((int)$userRow['status'] == 0 && !empty($userRow['id'])){
    $jsString = " ShowMessage(50,'error','','Y');";
  } elseif($userRow['id']>0) {
    $url = facile::$web_url.'resetpassword?token='.$token;
    $mail = new sendmail();
    $mail->to = $params['useremail'];
    $mail->from = facile::$web_url.' <noreply@'.facile::$web_url.'.com>';
    $mail->subject = 'Reset your '.ucfirst(facile::$web_url).' password';
    $mail->body = "<p>Password reset token: <a href='".$url."' target='_blank'>$url</a></p>";

    if($mail->send()) {
       $params['id'] = $userRow['id'];
       users::setToken($params);
       $jsString = "ShowMessage(39,'success','','Y');";
    } else {
      $jsString = "ShowMessage(42,'error','','Y');";
    }
  } else {
    $jsString = "ShowMessage(38,'error','','Y');";
  }
}
echo $jsString;
?>