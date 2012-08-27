<?php
/* @desc: php file
 * @auther: Manish Sahu
 * @created On:
 */

include_once facile::$path_classes . "/venue/venue_type.php";
//include_once facile::$path_classes . "/image/image.php";

class venueTypeBlock {

  function process() {
    is_loggedin();
    $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';

    switch ($view) {

      case 'add':
      case 'edit':
        $qarr = isset($_REQUEST) ? $_REQUEST : array();
        $records = array();
        $qarr['id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if ((isset($qarr['id']) && isset($qarr['action']) && $qarr['action'] == 'saveVenueType') || ($qarr['id']>0 && isset($qarr['action']) && $qarr['action'] == 'updateVenueType')) {
          $tplData['msg'] = ($qarr['id'] > 0) ? _DATA_UPDATE : _DATA_INSERT;
          if (venueType::saveVenueType($qarr)) {
            $tplData['class'] = 'success';
          } else {
            $tplData['msg'] = _DATA_UPDATE_FAILED;
            $tplData['class'] = 'error';
          }//die;
        }

        $records = venueType::getVenueTypeDetailsById($qarr['id']);
        $tplData['records'] = $records;
        $tplData['tpl'] = ($qarr['id']>0) ? 'venuetype_edit.tpl' : 'venuetype_add.tpl';
        break;

      default:
        $vars = isset($_REQUEST['vars'][0]) ? $_REQUEST['vars'][0] : array('');
        $vars['currPage'] = isset($vars['currPage']) ? $vars['currPage'] : 1;

        $id     = isset($vars['id']) ? $vars['id'] : 0;
        $action = isset($vars['action']) ? $vars['action'] : '';
        $sh_keyword = isset($vars['sh_keyword']) ? trim($vars['sh_keyword']) : '';

        //searching logic
        $arrKeyword = array();
        $qarr = array();
        if($sh_keyword != '') {
            $op=" REGEXP ";
            $sh_keyword_sarch = str_replace(" ",'|',$sh_keyword);
            $arrKeyword[] = " type ".$op."'".$sh_keyword_sarch."'";
            if(count($arrKeyword)>0)
              $qarr[] = " (".implode(" OR ",$arrKeyword ).") ";
        }
        $tplData['sh_keyword'] = $sh_keyword;

        //counting total records
        $tplData['totalRocords'] = venueType::getVenueTypeListing($qarr, 1, '', '');

        //pagination
        $paginationParam = array();
        $tplData['paginationHtml'] = getPaginationHtml($paginationParam, $tplData['totalRocords'],'showPage({page})',$vars['currPage']);
        $vars['currPage'] = $tplData['currPage'] = $paginationParam['currPage'];

        //records with limit
        $tplData['records'] = venueType::getVenueTypeListing($qarr, 0, $paginationParam['limit'], '');

        //for search result message block
        if($sh_keyword!="" && $tplData['totalRocords']<1) {
            $tplData['msg'] = _NO_RESULT_FOUND;
            $tplData['class'] = 'information';
        }
        break;
    }
    return $tplData;
  }
}