<?php

include_once facile::$path_classes . "/venue/venue.php";
//include_once facile::$path_classes . "/image/image.php";

class venueBlock {

  function process() {
    is_loggedin();
    if (isset($_REQUEST['view']))
      $view = $_REQUEST['view'];

    switch ($view) {

      case 'add':
        $tplData['regionList']  = Venue::getVenueRegionList();
        $tplData['typeList']    = Venue::getVenueTypeList();
        $tplData['capacityList']= Venue::getVenueCapacityList();
        $tplData['popularChoiceList'] = Venue::getVenuePopularityList();
        $tplData['tpl'] = 'venue_add.tpl';
        break;

      case 'edit':
        $qarr = array();
        $qarr['id'] = ($_POST['id']) ? $_POST['id'] : intval($_GET['id']);
        if ((trim($qarr['id']) != '') && trim($_REQUEST['action']) == 'updateVenue' || trim($_REQUEST['action']) == 'saveVenue') {
          $image_obj = new image();
          if ($_FILES['image']) {
            $upload_path = facile::$web_venueimage_path;
            if ($image = $image_obj->upload_image_resize($_FILES['image'], $upload_path)) {
              $_POST['image'] = $image;
            }
          }
          else
            $_POST['image'] = $_POST['venue_image'];
          $tplData['msg'] = ($qarr['id'] > 0) ? _DATA_UPDATE : _DATA_INSERT;
          if ($qarr['id'] = Venue::updateVenues($qarr)) {
            $tplData['class'] = 'success';
          } else {
            $tplData['msg'] = _DATA_UPDATE_FAILED;
            $tplData['class'] = 'error';
          }
        }
        $tplData['regionList']  = Venue::getVenueRegionList();
        $tplData['typeList']    = Venue::getVenueTypeList();
        $tplData['capacityList']= Venue::getVenueCapacityList();
        $tplData['popularChoiceList'] = Venue::getVenuePopularityList();
        
        $records = Venue::getVenueFullDetailsById($qarr['id']);
        $tplData['records'] = $records;
        $tplData['tpl'] = 'venue_edit.tpl';
        break;

      default:
        $vars = $_REQUEST['vars'][0];
        $vars['currPage'] = isset($vars['currPage']) ? $vars['currPage'] : 1;

        $id     = isset($vars['id']) ? $vars['id'] : intval($_REQUEST['id']);
        $action = isset($vars['action']) ? $vars['action'] : $_REQUEST['action'];
        $sh_keyword = isset($vars['sh_keyword']) ? trim($vars['sh_keyword']) : trim($_REQUEST['sh_keyword']);
        $sh_status = isset($vars['sh_status']) ? trim($vars['sh_status']) : trim($_REQUEST['sh_status']);

        if ($id>0 && $action == 'changeStatus') {//change status
            Venue::change_status($id);
            $tplData['msg'] = _ITEM_STATUS_CHANGED;
            $tplData['class'] = 'success';
        }

        //searching logic
        $arrKeyword = array();
        $qarr = array();
        if($sh_keyword != '') {
            $op=" REGEXP ";
            $sh_keyword_sarch = str_replace(" ",'|',$sh_keyword);
            $arrKeyword[] = " name ".$op."'".$sh_keyword_sarch."'";
            $arrKeyword[] = " address1 ".$op."'".$sh_keyword_sarch."'";
            if(count($arrKeyword)>0)
              $qarr[] = " (".implode(" OR ",$arrKeyword ).") ";
        }
        if($sh_status!=""){
          $qarr[] = " is_active='".$sh_status."'";
        }
        $tplData['sh_keyword'] = $sh_keyword;
        $tplData['sh_status'] = $sh_status;

        //counting total records
        $tplData['totalRocords'] = Venue::getVenueListing($qarr, 1, '', '');

        //pagination
        $paginationParam = array();
        $tplData['paginationHtml'] = getPaginationHtml($paginationParam, $tplData['totalRocords'],'showPage({page})',$vars['currPage']);
        $vars['currPage'] = $tplData['currPage'] = $paginationParam['currPage'];
        //view::$jsInPage .= "console.log(\"currPage:".$paginationParam['currPage']."\");";

        //records with limit
        $tplData['records'] = Venue::getVenueListing($qarr, 0, $paginationParam['limit'], '');

        //for search result message block
        if(($sh_keyword!="" || $sh_status!="") && $tplData['totalRocords']<1) {
            $tplData['msg'] = _NO_RESULT_FOUND;
            $tplData['class'] = 'information';
        }
        break;
    }
    return $tplData;
  }
}