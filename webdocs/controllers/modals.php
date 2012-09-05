<?php
  $base_path = dirname(__FILE__) . '/../../';
  require $base_path . 'config/facile.php';
  include facile::$path_includes . 'functions.php';
  include facile::$path_includes . 'uiFunctions.php';
  $requestedmodal = $_REQUEST['q'];
  switch($requestedmodal){
    case 'modal/venue-detail':
      $callAction = 'venuedetail';
      break;
    case 'modal/venue-images':
      $callAction = 'venueimages';
      break;
    case 'modal/allied-service-detail':
      $callAction = 'alliedservicedetail';
      break;
    default:
      break;
  }
  echo view::renderModal($callAction);