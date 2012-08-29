<?php
/* @desc: php file
 * @auther: Manish Sahu
 * @created On:
 */
include_once facile::$path_classes . "/allied_services/allied_services.php";

class alliedServicesBlock{
  function process(){
    is_loggedin();
    $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';

    switch ($view) {
      case 'add':
      case 'edit':
        $qarr = isset($_REQUEST) ? $_REQUEST : array();
        $qarr['id'] = !empty($_REQUEST['id']) ? trim($_REQUEST['id']) : '';

        if ((isset($qarr['id']) && isset($qarr['action']) && $qarr['action'] == 'saveAlService') || (!empty($qarr['id']) && isset($qarr['action']) && $qarr['action'] == 'updateAlService')) {
          $tplData['msg'] = !empty($qarr['id']) ? _DATA_UPDATE : _DATA_INSERT;
          if (Allied_Services::saveAlliedService($qarr)) {
            $tplData['class'] = 'success';
          } else {
            $tplData['msg'] = _DATA_UPDATE_FAILED;
            $tplData['class'] = 'error';
          }
        }
        $records = Allied_Services::getAlliedServiceDetailsId($qarr['id']);
        $tplData['records'] = $records;
        $tplData['tpl'] = !empty($qarr['id']) ? 'allied_service_edit.tpl' : 'allied_service_add.tpl';
        break;

      default:
        $vars = isset($_REQUEST['vars'][0]) ? $_REQUEST['vars'][0] : array('');
        $vars['currPage'] = isset($vars['currPage']) ? $vars['currPage'] : 1;

        $id     = isset($vars['id']) ? trim($vars['id']) : '';
        $action = isset($vars['action']) ? $vars['action'] : '';
        $sh_keyword = isset($vars['sh_keyword']) ? trim($vars['sh_keyword']) : '';
        $sh_status = isset($vars['sh_status']) ? trim($vars['sh_status']) : '';

        if (!empty($id) && $action == 'changeStatus') {//change status
            Allied_Services::change_status($id);
            $tplData['msg'] = _ITEM_STATUS_CHANGED;
            $tplData['class'] = 'success';
        }

        //searching logic
        $arrKeyword = array();
        $qarr = array();
        if($sh_keyword != '') {
            $op=" REGEXP ";
            $sh_keyword_sarch = str_replace(" ",'|',$sh_keyword);
            $arrKeyword[] = " HEADING ".$op."'".$sh_keyword_sarch."'";
            $arrKeyword[] = " SEO_ID ".$op."'".$sh_keyword_sarch."'";
            if(count($arrKeyword)>0)
              $qarr[] = " (".implode(" OR ",$arrKeyword ).") ";
        }
        if($sh_status!=""){
          $qarr[] = " IS_ACTIVE='".$sh_status."'";
        }
        $tplData['sh_keyword'] = $sh_keyword;
        $tplData['sh_status'] = $sh_status;

        //counting total records
        $tplData['totalRocords'] = Allied_Services::getVenueListing($qarr, 1, '', '');

        //pagination
        $paginationParam = array();
        $tplData['paginationHtml'] = getPaginationHtml($paginationParam, $tplData['totalRocords'],'showPage({page})',$vars['currPage']);
        $vars['currPage'] = $tplData['currPage'] = $paginationParam['currPage'];

        //records with limit
        $tplData['records'] = Allied_Services::getVenueListing($qarr, 0, $paginationParam['limit'], '');

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