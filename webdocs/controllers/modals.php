<?php
  $base_path = dirname(__FILE__) . '/../../';
  require $base_path . 'config/facile.php';
  include facile::$path_includes . 'functions.php';
  include facile::$path_includes . 'uiFunctions.php';
  $requestedmodal = $_REQUEST['q'];
  switch($requestedmodal){
    case 'modal/schedule':
      $callAction = 'schedule';
      break;
    case 'modal/live-env':
      $callAction = 'liveenv';
      break;
   case 'modal/player-detail':
      $callAction = 'playerdetail';
      break;
    case 'modal/team-detail':
      $callAction = 'teamdetail';
      break;
    case 'modal/news-detail':
      $callAction = 'newsdetail';
      break;
    case 'modal/event-detail':
      $callAction = 'eventdetail';
      break;
     case 'modal/venue-detail':
      $callAction = 'venuedetail';
      break;
    case 'modal/banner-detail':
      $callAction = 'bannerdetail';
      break;
    case 'modal/clipplayer':
      $callAction = 'clipplayer';
      break;
    case 'modal/xmldata':
      $callAction = 'xmldata';
      break;
    case 'modal/managefeature':
      $callAction = 'managefeature';
      break;
    case 'modal/content-detail':
      $callAction = 'contentdetail';
      break;
     case 'modal/managesponser':
      $callAction = 'managesponser';
      break;
	 case 'modal/assign-skin':
      $callAction = 'assignskin';
      break;
	 case 'modal/assign-page-skin':
      $callAction = 'assignpageskin';
      break;
    default:
      break;
  }
  echo view::renderModal($callAction);