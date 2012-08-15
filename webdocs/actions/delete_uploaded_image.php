<?php
$vars= $_REQUEST['vars'][0];
$jsString = "";
$type = trim($_REQUEST['flag']);
if($type!=""){
  $Id = intval($vars['Id']);
  switch($type){
    case 'player_image':
      include_once facile::$path_classes . "player/player.php";
      if($Id>0){
        Player::updateImage("", $Id, "image");
      }
      break;
    case 'player_poster':
      include_once facile::$path_classes . "player/player.php";
      if($Id>0){
        Player::updateImage("", $Id, "poster");
      }
      break;
    case 'team_poster':
      include_once facile::$path_classes . "team/team.php";
      if($Id>0){
        Team::updateImage("", $Id, "poster");
      }
      break;
    case 'team_image':
      include_once facile::$path_classes . "team/team.php";
      if($Id>0){
        Team::updateImage("", $Id, "poster");
      }
      break;

    default:
      break;
  }
}
echo $jsString;
exit;
?>