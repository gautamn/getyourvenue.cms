<?php
include_once facile::$path_classes . "/content/content.php";

class contentDetail{
    //process
    function process(){
      $tplData['title'] = 'Content Detail';
      $Id = $_REQUEST['Id'];
      $records = Content::getContentDetails($Id);
      $tplData['records'] = $records;
      $tplData['tpl'] = 'contentDetail_default.tpl';
      return $tplData;
    }
  }